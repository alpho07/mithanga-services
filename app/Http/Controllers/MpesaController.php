<?php

namespace App\Http\Controllers;

use App\Http\Request;
use Savannabits\Daraja\Daraja;

class MpesaController extends Controller
{
    public function index()
    {
    }

    function registerURLs()
    {
        
        $shortcode = "600737"; //Your Paybill or till number here
        $confirmationURL = "http://44.203.161.99/api/mpesa/confirm-url";
        $validationURL = "http://44.203.161.99/api/mpesa/validate-url"; // Optional. Leave null if you don't want validation
        $environment = "sandbox"; // or "live"
        $responseType = "Completed"; //Default Response type in case the validation URL is unreachable or is undefined. Either Cancelled or Completed as per the safaricom documentation
        $response = Daraja::getInstance()
            ->setCredentials("pUa9b2FKxxys2MEigOEQVfXmsfPNt7Kn", "iXMm01elw0YqPhtA", $environment)
            ->registerCallbacks($shortcode, $confirmationURL, $validationURL, $responseType);

        return 'Done';
    }

    function simulate()
    {
        $shortcode = "600737"; //Your Paybill or till number here
        $commandID = "CustomerPayBillOnline";
        $amount = 100;
        $environment = "sandbox"; // or "live"
        $msisdn = "0715882227"; // See safaricom daraja documentation and check your credentials for the specific number given for testing.
        $billRefNumber = "THE PAYBILL ACCOUNT NO."; // e.g "MAMA MBOGA 212"
        $response = Daraja::getInstance()
            ->setCredentials("pUa9b2FKxxys2MEigOEQVfXmsfPNt7Kn", "iXMm01elw0YqPhtA", $environment)
            ->c2b($shortcode, $commandID, $amount, $msisdn, $billRefNumber);
    }


    public function c2bValidationCallback(Request $request)
    {
        // Perform your validations here and set the status
        $status = true; // Or false based on whether you want to accept or reject the transaction.
        Daraja::getInstance()->finishTransaction($status);
    }

    public function c2bConfirmationCallback(Request $request)
    {
        //Get Response data
        $response = Daraja::getInstance()->getDataFromCallback();

        // $response = $request->all(); //Alternatively...
        // Do what you want with the data
        // ...
        // Finish Transaction
        Daraja::getInstance()->finishTransaction(true);
    }

    function simulate1()
    {
        echo 'This is the data';
    }
}
