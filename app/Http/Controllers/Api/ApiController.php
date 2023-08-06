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
        $clients = DB::table('vw_clients')->orderBy('previous_reading','desc')->get();
        $totalClients = $clients->count();
        return [
            'total' => $totalClients,
            'data' => $clients,
            'status' => 'Success'
        ];
    }
}
