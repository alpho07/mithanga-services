<!DOCTYPE html>
<html lang="en" >

    <head>

        <meta charset="UTF-8">


        <link href="{{url('print.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="{{url('print.js')}}"></script>



    </head>

    <body translate="no" >
        <a class="btn btn-sm btn-primary" href="{{url('payment')}}">< BACK</a>
        <button class="btn btn-warning btn-sm" id="PRINTER">PRINT</button>


        <div id="invoice-POS">

            <center>
                <h2 id="SamTITLE" style=" ">SAMDAMTE WATER CUSTOMER RECEIPT</h2>
            </center>



            <div id="mid">
                <div class="info">                  
                    <p> 
                        P.O. Box 24732 00100, NAIROBI GPO</br>
                        Tel:- +254-704-107-724 / +254-788-484-737</br>
                        Email:- samdamtewaterservices@yahoo.com</br>
                    </p>
                </div>
            </div><!--End Invoice Mid-->

            <div id="bot">

                <div id="table">
                    <table>                

                        <tr class="">
                            <td class=""><p class="itemtext">Receipt No :- {{$transactions[0]->reference}}</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">Receipt Date :- {{explode(' ', $transactions[0]->date)[0]}} </p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">Receipt Time :- {{explode(' ', $transactions[0]->date)[1]}}</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">Total Received : {{number_format($transactions[0]->amount_received,2)}}</p></td>
                        </tr>


                        <tr class="">
                            <td class=""><p class="itemtext">Account Number:     {{$transactions[0]->id}}</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">Account Name:       {{$transactions[0]->account_name}}</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">{{$transactions[0]->description}}:      Kshs {{number_format($transactions[0]->amount,2)}}</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">Amount Due:         Kshs {{str_replace('-','',number_format($due[0]->balance == '' || $due[0]->balance > 0 ? '0' : $due[0]->balance,2))}}</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">Paymanet Mode:      {{$transactions[0]->mode}}</p></td>
                        </tr>


                        <tr class="">                    
                            <td class=""><p class="itemtext">{{strtoupper($words).' SHILLINGS ONLY'}}</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">You can pay your bills through Paybill No. 823495</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">Disconnection of payment is 10TH of every month</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">Reconnection Charges are Kshs. 1155.00</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">We thank you for giving us an opportunity to serve you.</p></td>
                        </tr>
                        <tr class="">
                            <td class=""><p class="itemtext">You were served by {{strtoupper($transactions[0]->staff)}}</p></td>
                        </tr>
                    </table>
                    <p class="" style="margin-top:320px;">Official Stamp..........................................</p>
                </div><!--End Table-->


            </div><!--End InvoiceBot-->
        </div><!--End Invoice-->

        <script>

$(function () {
    $('#PRINTER').click(function () {
        $('#invoice-POS').printThis({
            importCSS: false,
            loadCSS: "{{url('print.css')}}",
        });
    })
})

function PrintElem(elem)
{
    $(elem).css({fontSize: '12px'});
    $(elem).css('margin-left', '0');
    $(elem).css('padding', '0');

    Popup($(elem).html());
}

function Popup(data)
{
    var mywindow = window.open('', 'my div', 'height=auto,width=400px;');
    mywindow.document.write('<html><head><title></title>');
    mywindow.document.write('<link rel="stylesheet" href="{{url("print.css")}}" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.print();
    mywindow.close();

    return true;
}

function printDiv()
{

    var divToPrint = document.getElementById('invoice-POS');

    var newWin = window.open('', 'Print-Window');

    newWin.document.open();
    newWin.document.write('<link rel="stylesheet" href="{{url("print.css")}}" type="text/css" />');
    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

    newWin.document.close();

    setTimeout(function () {
        //newWin.close();
    }, 10);

}
        </script>




    </body>

</html>