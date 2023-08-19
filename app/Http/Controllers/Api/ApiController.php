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
                    ->where(DB::raw("DATE_FORMAT(m.reading_date, '%Y-%m')"), '=', date('Y-m'));
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

        $previous_reading = DB::select("SELECT current_reading FROM meter_readings WHERE client_id='$r->id' ORDER BY id DESC LIMIT 1");
        
        if (!empty($previous_reading)) {           
            $pr = $previous_reading[0]->current_reading;
        } else {
            $pr = 0;
        }

        $rate = Area::find($r->area_id)['rate'];
        $current_reading = $r->current_reading;
        $consumed = $current_reading - $pr;
        $total_cost = $consumed * $rate;
        $date =  date('Y-m-d H:i:s');
        DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading,previous_reading) VALUES ('$r->id','$date','$r->current_reading',$pr)");
        $date = date('Y-m-d H:i:s');
        $date1 = date_create($date);
        $date2 = date_format($date1, "M - Y");

        $total_cost = $consumed * 120;

        $description = "WATER - $date2";
        $ref = 'REF' . date('Ymd-His');

        DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,previous_read,reference) VALUES ('$r->id','$description','$date','debit','$total_cost','$consumed','$current_reading','$pr','$ref')");
        DB::update("UPDATE meter_readings SET bill_run='1' WHERE client_id = '$r->id';");

        return ['success' => 'Meter Reading Registered Successfully for account ' . $r->id];
    }


    function loadClientsByArea($aid)
    {
        return Client::select('id', 'account_name')->where('area', $aid)->get();
    }
}
