<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Savannabits\Daraja\Daraja;
use Illuminate\Support\Facades\Log;
use DB;

class MpesaController extends Controller
{
    public function index()
    {
    }

    function registerURLs()
    {
        
        $shortcode = "600986"; //Your Paybill or till number here
        $confirmationURL = "http://44.203.161.99/confirmation";
        $validationURL = "http://44.203.161.99/validation"; // Optional. Leave null if you don't want validation
        $environment = "sandbox"; // or "live"
        $responseType = "Completed"; //Default Response type in case the validation URL is unreachable or is undefined. Either Cancelled or Completed as per the safaricom documentation
        $response = Daraja::getInstance()
            ->setCredentials("pUa9b2FKxxys2MEigOEQVfXmsfPNt7Kn", "iXMm01elw0YqPhtA", $environment)
            ->registerCallbacks($shortcode, $confirmationURL, $validationURL, $responseType);

         return response()->json($response);
    }

    function simulate()
    {
        $shortcode = "600986"; //Your Paybill or till number here
        $commandID = "CustomerPayBillOnline";
        $amount = 1;
        $environment = "sandbox"; // or "live"
        $msisdn = "254708374149"; // See safaricom daraja documentation and check your credentials for the specific number given for testing.
        $billRefNumber = "4287"; // e.g "MAMA MBOGA 212"
        $response = Daraja::getInstance()
            ->setCredentials("pUa9b2FKxxys2MEigOEQVfXmsfPNt7Kn", "iXMm01elw0YqPhtA", $environment)
            ->c2b($shortcode, $commandID, $amount, $msisdn, $billRefNumber);
        //return json_decode($response,TRUE);
    }


    public function c2bValidationCallback()
    {
        $status=true;
        if ($status === true) {
            $resultArray = [
                "ResultDesc" => "Accepted",
                "ResultCode" => "0"
            ];
        } else {
            $resultArray = [
                "ResultDesc" => "Rejected",
                "ResultCode" => "C2B00011"
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($resultArray);
    }

    public function c2bConfirmationCallback(Request $r)
    {

        $callbackJSONData=file_get_contents('php://input');

        //return $callbackJSONData;

        
        //Get Response data
        //  $response = Daraja::getInstance()->getDataFromCallback();
          Log::info('Formatted JSON:', ['json' =>   $callbackJSONData]);
        //    DB::table('payment_dump')->insert([
        //        'response'=>$response
        //    ]);

        // $response = $request->all(); //Alternatively...
        // Do what you want with the data
        // ...
        // Finish Transaction
        //Daraja::getInstance()->finishTransaction(true);
    }

    function simulate1()
    {
        echo 'This is the data';
    }
}
