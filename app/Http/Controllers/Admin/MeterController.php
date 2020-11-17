<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Area;
use App\Models\Status;
use Illuminate\Http\Request;
use DB;
use AfricasTalking\SDK\AfricasTalking;
use PDF;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class MeterController extends Controller {

    private $ref = '';

    public function __construct() {
        $this->ref = date('YmdHis');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $area = Area::all();
        if (request()->filled('selection_date')) {
            $criteria = substr(request()->selection_date, 0, -3);
        } else {
            $criteria = date('Y-m');
        }
        $first_client = DB::select(DB::raw("SELECT MIN(id) id FROM clients"));
        $ccid = $first_client[0]->id;
        $area_id = DB::select(DB::raw("SELECT area FROM clients WHERE id='$ccid'"))[0]->area;
        $readings = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE reading_date like '%$criteria%'"));
        return view('meter.index', ['area' => $area, 'readings' => $readings, 'i' => 1, 'criteria' => $criteria, 'fc' => $first_client, 'aid' => $area_id]);
    }

    function loadlast($id) {
        return DB::select(DB::raw("select * from vm_meter_readings where client_id='$id' ORDER by id desc limit 1;"));
    }

    public function notification_center($id, $date) {

        $area = Area::all();
        //$new_date = substr($date, 0, -3);

        $first_client = DB::select(DB::raw("SELECT MIN(id) id FROM clients"));
        $ccid = $first_client[0]->id;
        $area_id = DB::select(DB::raw("SELECT area FROM clients WHERE id='$ccid'"))[0]->area;
        $readings = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE reading_date like '%$date%' and area_id='$id' group by area_id"));
        return view('notification.index', ['area' => $area, 'readings' => $readings, 'i' => 1, 'area_' => $id, 'date' => $date, 'fc' => $first_client, 'aid' => $area_id]);
    }

    public function register($id, $aid) {
        $pv_status = '';
        $nt_status = '';
        $total = DB::select(DB::raw("SELECT COUNT(id) total FROM vw_clients WHERE area_id='$aid'"))[0]->total;
        $pbal = DB::select(DB::raw("SELECT balance  FROM vw_balances  WHERE id='$id'"))[0]->balance;
        $pmrr = DB::select(DB::raw("SELECT current_reading  FROM meter_readings  WHERE client_id='$id' ORDER BY id DESC LIMIT 1"));
        if (count($pmrr) > 0) {
            $pmr = $pmrr[0]->current_reading;
        } else {
            $pmr = '';
        }
        $i = 1;
        $previous = DB::select(DB::raw("SELECT id FROM vw_clients WHERE id < $id AND area_id='$aid' ORDER BY id  DESC LIMIT 1"));
        if (empty($previous)) {
            $pv = $id;
            $pv_status = "disabled=disabled " . "style=display:none;";
            $alert = '';
            $i = 1;
        } else {
            $pv = $previous[0]->id;
            $i = $i - 1;
        }

        $next = DB::select(DB::raw("SELECT id FROM vw_clients WHERE id > $id AND area_id='$aid' ORDER BY id ASC LIMIT 1"));
        if (empty($next)) {
            $nt = $id;
            $nt_status = "disabled=disabled " . "style=display:none;";
            $i = $id;
        } else {
            $nt = $next[0]->id;
            $i = $i + 1;
        }
        $client = DB::select(DB::raw("SELECT * FROM vw_clients WHERE id='$id' AND area_id='$aid'"));
        $area = Area::all();
        $area_name = Area::find($aid)->rate;
        return view('meter.meter_reading', [
            'client' => $client,
            'area' => $area,
            'area_name' => $area_name,
            'p' => $pv,
            'n' => $nt,
            'nts' => $nt_status,
            'pvs' => $pv_status,
            'aid' => $aid,
            'i' => $i,
            'total' => $total,
            'bal' => $pbal ? $pbal : '0.00',
            'prevr' => $pmr
        ]);
    }

    function getFid($id) {
        echo DB::select(DB::raw("SELECT MIN(id) id FROM clients WHERE area ='$id'"))[0]->id;
    }

    function load_sheet($area_id) {
        $area = Area::find($area_id);
        $i = 0;
        $clients = DB::select(DB::raw("SELECT * FROM vw_clients WHERE area_id='$area_id'"));
        return view('meter.load_sheet', compact('clients', 'i', 'area', 'area_id'));
    }

    function download_sheet($area_id) {
        $area = Area::find($area_id);
        $i = 0;
        $clients = DB::select(DB::raw("SELECT * FROM vw_clients WHERE area_id='$area_id'"));
        //return view('meter.download_sheet', compact('clients', 'i', 'area'));
        $pdf = PDF::loadView('meter.download_sheet', compact('clients', 'i', 'area'));
        return $pdf->download($area->name . '_READING-SHEET.pdf');
    }

    function load_staement($client_id) {
        $area = Area::find($area_id);
        $i = 0;
        $clients = DB::select(DB::raw("SELECT * FROM vw_clients WHERE area_id='$area_id'"));
        return view('meter.load_sheet', compact('clients', 'i', 'area'));
    }

    function save_reading(Request $r, $cid, $id, $aid) {
        $previous_reading = DB::select("SELECT current_reading FROM meter_readings WHERE client_id='$cid' ORDER BY id DESC LIMIT 1");
        if (count($previous_reading) <= 0) {
            $pr = $previous_reading = 0;
        } else {
            $pr = $previous_reading[0]->current_reading;
        }
        $rate = Area::find($aid)['rate'];
        $current_reading = $r->current_reading;
        $consumed = $current_reading - $pr;
        $total_cost = $consumed * $rate;
        $date = $r->reading_date . ' ' . date('H:i:s');
        DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$cid','$date','$r->current_reading')");
        //DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,'bill_run') VALUES ('$cid','Water Bill','$date','debit','$total_cost','$consumed','1')");

        return redirect()->route('meter.reading.m', ['id' => $id, 'aid' => $aid])->with('success', 'Meter Reading Registered Successfully for account ' . $cid);
    }

    function disconnect(Request $r) {
        $date = date('Y-m-d H:i:s');
        $query = DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading,discon) VALUES ('$r->cid','$date','$r->current_reading','d')");
        //DB::insert("INSERT INTO transactions (client_id,description,date,type,amount) VALUES ('$r->cid','DISCONNECTION FEE','$date','debit','1155')");
        DB::table('clients')->where('id', "$r->cid")->update(['status' => 2]);
        if ($query) {
            return ['status' => 'true'];
        } else {
            return ['status' => 'false'];
        }
    }

    function reconnect(Request $r) {
        $date = date('Y-m-d H:i:s');
        //$query = DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$r->cid','$date','$r->current_reading')");
        $query = DB::insert("INSERT INTO transactions (client_id,description,date,type,amount) VALUES ('$r->cid','Reconnection Fee','$date','credit','$r->amount')");
        DB::table('clients')->where('id', "$r->cid")->update(['status' => 1]);
        if ($query) {
            return ['status' => 'true'];
        } else {
            return ['status' => 'false'];
        }
    }

    function runBill() {
        $query = DB::select(DB::raw("SELECT * FROM vm_meter_readings  WHERE bill_run='0'"));
        // dd($query);
        $total = count($query);
        $message = $total > 0 ? $total . ' Bill(s) Sucessfully run and generated' : 'No pending bill(s) to process';
        foreach ($query as $q):
            $id = $q->id;
            $cid = $q->client_id;
            $date = $q->reading_date;
            $date1 = date_create($date);
            $date2 = date_format($date1, "M-Y");
            $consumed = ($q->consumed_units) ? $q->consumed_units : 0;
            $current_reading = ($q->current_reading) ? $q->current_reading : 0;
            $total_cost = ($q->water_charges) ? $q->water_charges : 0;
            if ($q->discon == 'd') {
                $description = 'DISCONNECTION UNITS';
            } else {
                $description = "WATER CHARGES($date2)";
            }
            DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,reference) VALUES ('$cid','$description','$date','debit','$total_cost','$consumed','$current_reading','$this->ref')");
            DB::update("UPDATE meter_readings SET bill_run='1' WHERE id = '$id';");
        endforeach;
        $this->addStandingCharges();
        return redirect()->route('billing.index')->with('success', $message);
    }

    function addStandingCharges() {
        $query = DB::select(DB::raw("SELECT * FROM vm_meter_readings  WHERE consumed_units='0' AND standing_charge='0'"));
        foreach ($query as $q):
            $id = $q->id;
            $cid = $q->client_id;
            $date = date('Y-d-m H:i:s');
            $current_reading = ($q->current_reading) ? $q->current_reading : 0;
            $consumed = ($q->consumed_units) ? $q->consumed_units : 0;
            $total_cost = '100';
            DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,'ref') VALUES ('$cid','Standing Charge','$date','debit','$total_cost','$consumed',$current_reading,'$this->ref')");
            DB::update("UPDATE meter_readings SET standing_charge='1' WHERE id = '$id';");
        endforeach;
    }

    public function loadClient($id) {
        return DB::table('clients')->where('area', $id)->get();
    }

    function meter_reading(Request $r) {
        DB::insert("REPLACE INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$r->client_id','$r->reading_date','$r->current_reading')");
        return redirect()->route('meter.index')->with('success', 'Meter Reading Registered Successfully!');
    }

    function sendNotification($id) {
        $readings = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE id='$id'"));
        $message2 = "Dear " . strtoupper($readings[0]->account_name) . " A/C " . $readings[0]->client_id . " your bill as at 26-" . date('m-Y') . "  Prev Read " . $readings[0]->previous_reading . " Curr Read " . $readings[0]->current_reading . " Consumption " . $readings[0]->consumed_units . " Arrears 0.00 Amount Paid 0.00 Current Bill " . number_format($readings[0]->water_charges) . " Total Amount  " . number_format($readings[0]->water_charges) . "  Due date is 10-Jul-20. Reconnection Fee is 1155. Bills payable through Paybill No 823496. WE MAKE IT SAFE BECAUSE WATER IS LIFE. THANK YOU. OPT OUT *456*9*5#";
        $this->sendSampleText($message2, $readings[0]->phone_no);
        return redirect()->route('meter.index')->with('success', 'SMS Notification Successfully sent!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $area = Area::all();
        $status = Status::all();
        return view('client.create', ['area' => $area, 'status' => $status]);
    }

    function updateReadings(Request $r) {
        DB::insert(DB::raw("UPDATE meter_readings SET reading_date='$r->reading_date',current_reading='$r->current_reading' WHERE id='$r->id_'"));
        return redirect()->route('meter.index')->with('success', 'Update Successfull');
    }

    function sendSampleText($message, $number) {
        $username = 'alpho07'; // use 'sandbox' for development in the test environment
        $apiKey = '89d148b1c97450883698fc0c6c35f78fab73bb7e0a4998e24fbdf1cd5245d6a1'; // use your sandbox app API key for development in the test environment
        $AT = new AfricasTalking($username, $apiKey);

// Get one of the services
        $sms = $AT->sms();
        $new = substr($number, 1);
        $recipients = "+254" . $new;

// Use the service
        $result = $sms->send([
            'to' => $recipients,
            'message' => $message
        ]);

        return $result;
    }

    function getClientPage($cid) {
        $client = Client::find($cid);
        if (empty($client)) {
            return '0';
        } else {
            return $client;
        }
    }

    function updateTransaction() {

        DB::insert("REPLACE INTO transactions (client_id,description,date,type,amount) VALUES ('$r->client_id','$r->reading_date','$r->current_reading')");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(Client::$rules);

        $client = Client::create($request->all());
        $id = DB::select(DB::raw("SELECT MAX(id) id FROM clients"));
        $message = "Dear " . strtoupper($request->account_name) . " Your A/C is " . $id[0]->id . "  We are pleased to welcome you as a new client. We feel honored that you have chosen us to fill your water service needs, and we are eager to be of service. WE MAKE IT SAFE BECAUSE WATER IS LIFE. THANK YOU AND WELCOME!";
        $message2 = 'Dear ANIRITA POUL FARM LIMITED A/C 4615 your bill as at 26-Apr-20  Prev Read 158 Curr Read 310 Consumption 152 Arrears 0.00 Amount Paid 15,200.00 Current Bill 15,200.00 Total Amount 0.00. Due date is 10-May-20. Reconnection Fee is 1155. Bills payable through Paybill No 823496. WE MAKE IT SAFE BECAUSE WATER IS LIFE. THANK YOU. OPT OUT *456*9*5#';
        $this->sendSampleText($message, $request->phone_no);
        return redirect()->route('client.index')
                        ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $client = DB::select(DB::raw("SELECT c.*, a.name area_name,s.status status_name FROM clients c INNER JOIN areas a ON c.area = a.id INNER JOIN statuses s ON c.status = s.id WHERE c.id='$id'"));
        $area = Area::all();
        $status = Status::all();


        return view('client.show', ['area' => $area, 'status' => $status, 'client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $client = DB::select(DB::raw("SELECT c.*, a.name area_name,s.status status_name FROM clients c INNER JOIN areas a ON c.area = a.id INNER JOIN statuses s ON c.status = s.id WHERE c.id='$id'"));
        $area = Area::all();
        $status = Status::all();
        return view('client.edit', ['area' => $area, 'status' => $status, 'client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $client = Client::find($id);
        $client->area = $request->area;
        $client->phone_no = $request->phone_no;
        $client->account_name = $request->account_name;
        $client->national_id = $request->national_id;
        $client->email = $request->email;
        $client->plot_number = $request->plot_number;
        $client->account_open_date = $request->account_open_date;
        $client->meter_number = $request->meter_number;
        $client->status = $request->status;
        $client->connection_date = $request->connection_date;
        $client->vaccation_date = $request->vaccation_date;
        $client->reconnection_date = $request->reconnection_date;
        $client->connection_date = $request->connection_date;
        $client->comment = $request->comment;
        $client->update();

        return redirect()->route('client.index')->with('success', 'Client updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $client = Client::find($id)->delete();

        return redirect()->route('client.index')
                        ->with('success', 'Client deleted successfully');
    }

}
