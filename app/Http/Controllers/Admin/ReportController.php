<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Area;
use DB;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
class ReportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function waterbill() {
        $cid = @$_GET['cid'];
        $client = @$_GET['client'];
        $area = @$_GET['area'];
        $query = '';

        $areas = Area::all();
        $clients = Client::all();
        $data = DB::select(DB::raw("SELECT * FROM settings_dpms"));


        if (!empty($cid) && !empty($client)) {
            $query .= " AND client_id ='$cid'";
        }
        if (!empty($client) && empty($cid)) {
            $query .= " AND client_id ='$client'";
        }

        if (!empty($cid) && empty($client)) {
            $query .= " AND client_id ='$cid'";
        }
        if (!empty($area)) {
            $query .= " AND area_id ='$area'";
        }

        $raw = preg_replace('/AND/', '', $query, 1);

        if (empty($query)) {
            $balance = DB::select(DB::raw("SELECT balance FROM vw_balances WHERE client_id='1'"));
            $billing = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE client_id='1' ORDER BY id DESC LIMIT 1"));
            $data2 = DB::table('vm_meter_readings')->paginate(1)->appends(request()->query());
            return view('reports.waterbill', compact('data', 'balance', 'billing', 'data2', 'areas', 'clients', 'cid', 'client', 'area'))->with('i', (request()->input('page', 1) - 1) * $data2->perPage());
        } else {

            $billing = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE client_id='$client'"));
            $balance = DB::select(DB::raw("SELECT balance FROM vw_balances WHERE client_id='$client'"));
            $data2 = DB::table('vm_meter_readings')->whereRaw($raw)->paginate(1)->appends(request()->query());
            if ($data2->count() > 0) {
                return view('reports.waterbill', compact('data', 'balance', 'billing', 'data2', 'areas', 'clients', 'cid', 'client', 'area'))->with('i', (request()->input('page', 1) - 1) * $data2->perPage());
            } else {
                return redirect()->back()->with('error', 'Record Not found');
            }
        }
    }

    function balances() {
        $areas = Area::all();
        DB::statement("DROP TABLE IF EXISTS temp_balances;CREATE TABLE temp_balances as SELECT * FROM vw_final_balances");
        $balances = DB::select("SELECT * FROM temp_balances");
        return view('reports.balances', compact('areas', 'balances'));
    }

    function balances_client() {
        $areas = Area::all();
        DB::statement("DROP TABLE IF EXISTS temp_balances_clients;CREATE TABLE temp_balances_clients as SELECT * FROM vw_balances");
        $balances = DB::select("SELECT * FROM temp_balances_clients");
        return view('reports.client_balances', compact('areas', 'balances'));
    }

    function history() {
        $cid = @$_GET['client'];
        $date = @$_GET['date'];
        $query = '';
        if (!empty($cid)) {
            $query .= " AND client_id ='$cid'";
        }
        if (!empty($date)) {
            $query .= " AND reading_date <='$date'";
        }

        $raw = preg_replace('/AND/', '', $query, 1);
        $areas = Area::all();
        $clients = DB::select("SELECT * FROM vw_clients");

        if (!empty($query)) {
            $client = DB::select("SELECT * FROM vw_clients WHERE id='$cid'");
            $balances = DB::select("SELECT *  FROM vm_meter_readings WHERE $raw");
        } else {
            $client = DB::select("SELECT * FROM vw_clients WHERE id='1'");
            $balances = DB::select("SELECT * FROM vm_meter_readings WHERE client_id='1'");
        }
        return view('reports.history', compact('areas', 'balances', 'client', 'date', 'cid', 'clients'));
    }

    function sales_revenue(Request $r) {
        $areas = Area::all();

        $report_type = $r->input('report_type');
        $date = $r->input('report_type');
        $date_from = $r->input('report_type');
        $date_to = $r->input('report_type');
        echo $report_type;
        die;

        DB::statement("DROP TABLE IF EXISTS temp_balances_clients;CREATE TABLE temp_balances_clients as SELECT * FROM vw_balances;");
        $balances = DB::select("SELECT * FROM temp_balances_clients");
        return view('reports.sales_revenue', compact('areas', 'balances'));
    }

    function no_water_debits() {
        $areas1 = @$_GET['area'];
        $area2 = Area::all();
        if (!empty($areas1)) {
            foreach ($areas1 as $a):
                echo $a;
            endforeach;
        }

        return view('reports.no_water_index', compact('area2'));
    }

    function no_water_debit_post(Request $r) {
        $areas1 = $r->area;
        $str = '';
        $data = [];
        $date = date('Y-m-d');
        $date2 = date('Y-m');
        $area2 = Area::all();
        DB::statement("DROP TABLE  IF EXISTS temp_no_water ; CREATE TABLE temp_no_water SELECT c.id account,c.area_id, c.account_name,IF(t.consumed_units IS NULL,0,t.consumed_units) units,IF(t.consumed_units=0 OR t.consumed_units IS NULL,'100',t.consumed_units * c.rate) invoiced,t.reading_date
                    FROM vw_clients c 
                    LEFT JOIN vm_meter_readings t ON c.id = t.client_id
                    AND DATE_FORMAT(t.reading_date,'%Y-%m-%d') >= CONCAT(LEFT('$date' - INTERVAL 1 MONTH,7),'-23')  AND DATE_FORMAT(t.reading_date,'%Y-%m-%d') <='$date2-23'
                    group by c.id");


        foreach ($areas1 as $a):
            $areas = Area::find($a);
            $clients = DB::select("SELECT * FROM temp_no_water WHERE area_id='$a' AND reading_date IS NULL ORDER BY account DESC");
            $fidata = ['area' => $areas->name, 'clients' => $clients];
            array_push($data, $fidata);
        endforeach;
        return view('reports.no_water_debits', compact('areas', 'data', 'area2'));
    }

    function reading_sheets() {
        $area = Area::all();
        $data = [];
        $i = 0;
        foreach ($area as $a):
            $clients = ['area' => $a->name, 'clients' => DB::select(DB::raw("SELECT * FROM vw_clients WHERE area_id='$a->id'"))];
            array_push($data, $clients);
        endforeach;


        return view('reports.readingsheet', compact('data', 'i'));
    }

    function area_report() {
        $period = @$_GET['period'];
        $type = @$_GET['type'];

        $date = date_create($period);
        $period1 = strtoupper(date_format($date, "F-Y"));


        if ($type == 'AREA') {
            $result = DB::select(DB::raw("SELECT a.id,a.name,COUNT(c.id) clients, SUM(mr.consumed_units) units_consumed, (a.rate * SUM(mr.consumed_units)) + (COUNT(mr.consumed_units='0') * 100) invoiced,COUNT(mr.consumed_units='0')  flat_rate
                                        FROM areas a
                                        INNER JOIN clients c ON c.area = a.id
                                        LEFT JOIN vm_meter_readings mr ON a.id = mr.area_id
                                        WHERE mr.reading_date >= DATE_FORMAT( '$period' - INTERVAL 1 MONTH, '%Y-%m-23' ) 
                                        AND  mr.reading_date <= DATE_FORMAT('$period', '%Y-%m-23' )
                                        GROUP BY a.id"));
            //dd($result);
            return view('reports.acreport', compact('period1', 'result', 'period', 'type'));
        } else {

            DB::statement("DROP TABLE  IF EXISTS temp_consumption ; CREATE TABLE temp_consumption SELECT c.id account,c.area_id, c.account_name,IF(t.consumed_units IS NULL,0,t.consumed_units) units,IF(t.consumed_units=0 OR t.consumed_units IS NULL,'100',t.consumed_units * c.rate) invoiced,t.reading_date
                    FROM vw_clients c 
                    LEFT JOIN vm_meter_readings t ON c.id = t.client_id
                    AND DATE_FORMAT(t.reading_date,'%Y-%m-%d') >= CONCAT(LEFT('$period' - INTERVAL 1 MONTH,7),'-23')  AND DATE_FORMAT(t.reading_date,'%Y-%m-%d') <='$period'
                    group by c.id");

            $area = Area::all();
            $data = [];
            $i = 0;
            foreach ($area as $a):
                $clients = ['area' => $a->name, 'clients' => DB::select(DB::raw("SELECT * FROM temp_consumption WHERE area_id='$a->id'"))];
                array_push($data, $clients);
            endforeach;
            //dd($result);
            return view('reports.screport', compact('period1', 'data', 'period', 'type'));
        }
    }

    function meter_changes() {
        $period = @$_GET['period'];
        $type = @$_GET['type'];

        $clients = Client::all();

        $date = date_create($period);
        $period1 = strtoupper(date_format($date, "F-Y"));
        $period_filter = strtoupper(date_format($date, "Y-m"));

        $result = DB::select("SELECT c.id account,c.account_name,c.area_name,mc.change_date,mc.reading
                        FROM vw_clients c
                        INNER JOIN meter_changes mc ON c.id = mc.client_id
                        WHERE DATE_FORMAT(mc.change_date,'%Y-%m') LIKE '%$period_filter%'");

        //dd($result);
        return view('reports.mchanges', compact('period1', 'result', 'period', 'type', 'clients'));
    }

    function history_report() {
        $period = @$_GET['period'];
        $type = @$_GET['type'];
        $clients = Client::all();
        $single = Client::find($type);
        $date = date_create($period);
        $period1 = strtoupper(date_format($date, "F-Y"));
    



        $result = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE client_id='$type' AND DATE_FORMAT(reading_date,'%Y-%m-%d') <='$period' ORDER BY id ASC"));
                                
     
        return view('reports.hreport', compact('period1', 'result', 'period', 'type','clients','single'));
    }

}
