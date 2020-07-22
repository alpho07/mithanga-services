<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Area;
use App\Models\Status;
use Illuminate\Http\Request;
use DB;
use AfricasTalking\SDK\AfricasTalking;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class MeterController extends Controller {

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
        $readings = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE reading_date like '%$criteria%'"));
        return view('meter.index', ['area' => $area, 'readings' => $readings, 'i' => 1, 'criteria' => $criteria]);
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
