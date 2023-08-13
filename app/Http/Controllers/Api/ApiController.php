<?php

namespace App\Http\Controllers\Api;

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
class ApiController extends Controller
{

    function index()
    {
        return 'Mithanga services API Version 1.0';
    }

    function loadClients()
    {
        $clients =  DB::table('vw_clients as c')
            ->leftJoin('meter_readings as m', function ($join) {
                $join->on('c.id', '=', 'm.client_id')
                    ->where(DB::raw("DATE_FORMAT(m.reading_date, '%Y-%m')"), '=', '2023-08');
            })
            ->select('c.id', 'c.area_id', 'c.account_name', 'c.phone_no', 'c.area_name', 'c.rate', 'c.previous_reading', 'c.balance')
            ->selectRaw('IF(m.client_id IS NOT NULL, 1, 0) as status')
            ->get();
        $totalClients = $clients->count();
        return [
            'total' => $totalClients,
            'data' => $clients,
            'status' => 'Success'
        ];
    }

    function saveData()
    {
    }



    function save_reading(Request $r)
    {
      
        $cid = $r->id;
        $aid = $r->area_id;
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
        $date =  date('Y-m-d H:i:s');
        DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$cid','$date','$r->current_reading')");
        //DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,bill_run) VALUES ('$cid','Water Bill','$date','debit','$total_cost','$consumed','1')");

        // if ($pr == $r->current_reading) {
        //     $description = "WATER - " . date('M Y');
        //     DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,reference,sc) VALUES ('$cid','$description','$date','debit','100','0',$current_reading,'$this->ref','yes')");
        //     $tid_ = DB::select(DB::raw("SELECT MAX(id) id FROM transactions"))[0]->id;
        //     DB::update("UPDATE meter_readings SET standing_charge='1' WHERE id = '$tid_';");
        // } else {
        //     DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$cid','$date','$r->current_reading')");
        // }
        //DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,'bill_run') VALUES ('$cid','Water Bill','$date','debit','$total_cost','$consumed','1')");

        $query = DB::select(DB::raw("SELECT * FROM vm_meter_readings  WHERE bill_run='0'"));

        // dd($query);
        $total = count($query);
        //$message = $total > 0 ? $total . ' Bill(s) Sucessfully run and generated' : 'No pending bill(s) to process';
        foreach ($query as $q) :

            $id = $q->id;
            $cid = $q->client_id;
            $date = $q->reading_date;
            $date1 = date_create($date);
            $date2 = date_format($date1, "M - Y");
            $consumed = ($q->consumed_units) ? $q->consumed_units : 0;
            $current_reading = ($q->current_reading) ? $q->current_reading : 0;
            $total_cost = ($q->water_charges) ? $q->water_charges : 0;
            if ($q->discon == 'd') {
                $description = 'DISCONNECTION UNITS';
            } else {
                $description = "WATER - $date2";
            }
            DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,reference) VALUES ('$cid','$description','$date','debit','$total_cost','$consumed','$current_reading','xyxyxyx')");
            DB::update("UPDATE meter_readings SET bill_run='1' WHERE id = '$id';");
        endforeach;

        return ['success' => 'Meter Reading Registered Successfully for account ' . $cid];
    }
}
