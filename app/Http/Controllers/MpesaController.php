<?php

namespace App\Http\Controllers;

use App\Http\Request;
use Savannabits\Daraja\Daraja;
use DB;

class MpesaController extends Controller
{
    public function index()
    {
    }

    function registerURLs()
    {
        
        $shortcode = "600737"; //Your Paybill or till number here
        $confirmationURL = "http://44.203.161.99/api/payment/confirm-url";
        $validationURL = "http://44.203.161.99/api/payment/validate-url"; // Optional. Leave null if you don't want validation
        $environment = "sandbox"; // or "live"
        $responseType = "Completed"; //Default Response type in case the validation URL is unreachable or is undefined. Either Cancelled or Completed as per the safaricom documentation
        $response = Daraja::getInstance()
            ->setCredentials("pUa9b2FKxxys2MEigOEQVfXmsfPNt7Kn", "iXMm01elw0YqPhtA", $environment)
            ->registerCallbacks($shortcode, $confirmationURL, $validationURL, $responseType);

         return response()->json($response);
    }

    function simulate()
    {
        $shortcode = "600737"; //Your Paybill or till number here
        $commandID = "CustomerPayBillOnline";
        $amount = 100;
        $environment = "sandbox"; // or "live"
        $msisdn = "0715892221"; // See safaricom daraja documentation and check your credentials for the specific number given for testing.
        $billRefNumber = "4287"; // e.g "MAMA MBOGA 212"
        $response = Daraja::getInstance()
            ->setCredentials("pUa9b2FKxxys2MEigOEQVfXmsfPNt7Kn", "iXMm01elw0YqPhtA", $environment)
            ->c2b($shortcode, $commandID, $amount, $msisdn, $billRefNumber);
        return response()->json($response);
    }


    public function c2bValidationCallback(Request $request)
    {
        // Perform your validations here and set the status
        $status = true; // Or false based on whether you want to accept or reject the transaction.
        Daraja::getInstance()->finishTransaction($status);
    }

    public function c2bConfirmationCallback(Request $request)
    {

        echo 1;
        die;
        //Get Response data
        $response = Daraja::getInstance()->getDataFromCallback();
        //return response()->json($response);
         DB::table('payment_dump')->insert([
             'response'=>$response->all()
         ]);

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
