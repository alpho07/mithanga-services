@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <select value="" id="selecOR" class="form-control">
                                        <option value="area">Area</option>
                                        <option value="person">Person</option>
                                        <option value="account">Account</option>
                                    </select>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                            </div>
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                                    <form method="get" action="{{route('waterbill')}}">
                                        <select class="form-input" name="client" id="CLIENT">
                                            <option value="">-Select Client-</option>
                                            @foreach($clients as $a)
                                            <option value="{{$a->id}}">{{$a->account_name}}<option>
                                                @endforeach                            
                                        </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div id="AREA2" style="display:none !important;">
                                            <select class="form-input" name="" style="width:200px !important; " id="AREA">
                                                <option value="">-Select Area-</option>
                                                @foreach($areas as $a)
                                                <option value="{{$a->id}}">{{$a->name}}<option>
                                                    @endforeach                            
                                            </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>


                                        <input class="form-control mr-sm-2" id="CCID" style="display:none;" type="text" value="{{$cid ?? ''}}" name="" autofocus placeholder="Enter Client Account" aria-label="Search">
                                        &nbsp;&nbsp;&nbsp;&nbsp;                                        
                                        <input class="btn btn-sm btn-primary" type="submit"  value="Submit">

                                    </form>
                                </div>
                            </nav>
                        </div>
                    </div> 

                    <div style="">



                        <div class="row pull-right">
                            <button id="PRINT" class="btn btn-sm btn-primary">Print</button>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif



                <div class="card-body" id="printToPdf">

                    <div class="row">


                        <div class="row col-md-12">


                            <style type="text/css">
                                .tg  {border-collapse:collapse;border-color:#ccc;border-spacing:0;}
                                .tg td{background-color:#fff;border-color:#ccc;border-style:solid;border-width:1px;color:#333;
                                       font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;}
                                .tg th{background-color:#f0f0f0;border-color:#ccc;border-style:solid;border-width:1px;color:#333;
                                       font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                                .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
                                .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
                                .tg .tg-7btt{border-color:inherit;font-weight:bold;text-align:center;vertical-align:top}
                                .tg .tg-dvpl{border-color:inherit;text-align:right;vertical-align:top}
                                .tg .tg-fymr{border-color:inherit;font-weight:bold;text-align:left;vertical-align:top}
                            </style>

                            <div class="row col-12">

                                <center>
                                    @if ($message = Session::get('error'))
                                    <div class="alert alert-danger">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @endif
                                    <table class="" style="width:750px !important;">
                                        <thead>
                                            <tr>
                                                <td colspan="4"><center><strong>SAMDAMTE WATER - WATER BILL</strong></center></td>
                                        </tr>
                                        <tr><td colspan="4" style="height: 10px;"></td></tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Name</strong></td>
                                                <td><strong>{{$data2[0]->account_name}}</strong></td>
                                                <td><strong>Bill Period:</strong></td>
                                                <td><strong>{{\Carbon\Carbon::parse($data2[0]->reading_date)->format('d/m/Y')}}</strong></td>

                                            </tr>
                                            <tr>
                                                <td><strong>Account No.</strong></td>
                                                <td><strong>{{$data2[0]->client_id}}</strong></td>
                                                <td><strong>Bill No.</strong> </td>
                                                <td><strong>{{$data2[0]->client_id}} - {{$data2[0]->id}}</strong></td>

                                            </tr>
                                            <tr>
                                                <td><strong>Member No.</strong></td>
                                                <td><strong>0</strong></td>
                                                <td><strong>Meter No.</strong></td>
                                                <td><strong>{{$data2[0]->client_id}}</strong></td>

                                            </tr>
                                            <tr>
                                                <td><strong>Service Area</strong></td>
                                                <td><strong>{{$data2[0]->area_name}}</strong></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <table class="tg">
                                        <thead>
                                            <tr>
                                                <th class="tg-7btt">BILLING DATE</th>
                                                <th class="tg-7btt">DUE DATE</th>
                                                <th class="tg-7btt">READING DATE</th>
                                                <th class="tg-7btt">PREVIOUS READING</th>
                                                <th class="tg-7btt">CURRENT READING</th>
                                                <th class="tg-7btt">CONSUMPTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td class="tg-c3ow">{{\Carbon\Carbon::parse($data2[0]->reading_date)->format('d/m/Y')}}</td>
                                                <td class="tg-c3ow">10/{{\Carbon\Carbon::parse(strtotime( "+1 month", strtotime( $data2[0]->reading_date) ))->format('m/Y')}}</td>
                                                <td class="tg-c3ow">{{\Carbon\Carbon::parse($data2[0]->reading_date)->format('d/m/Y')}}<br></td>
                                                <td class="tg-dvpl">{{$data2[0]->previous_reading}}</td>
                                                <td class="tg-dvpl">{{$data2[0]->current_reading}}</td>
                                                <td class="tg-dvpl">{{$data2[0]->consumed_units}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tg-0pky" rowspan="3"></td>
                                                <td class="tg-7btt" colspan="4">CONSUMPTION DATA</td>
                                                <td class="tg-fymr">AMOUNT(In Kshs.)</td>
                                            </tr>
                                            <tr>
                                                <td class="tg-0pky" colspan="4">
                                                    <p>BALANCE BROUGHT B/F FROM PREVIOUS BILLING</p>
                                                    <p>WATER CHARGES @ {{$billing[0]->rate}} Shs. PER CUBIC METER</p>
                                                </td>
                                                <td class="tg-0pky" style="text-align: right;">
                                                    <p>{{number_format($balance[0]->balance,2)}}</p>
                                                    <p>{{$data2[0]->water_charges}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tg-7btt" colspan="4">AMOUNT DUE</td>
                                                <td class="tg-fymr" style="text-align: right;">{{number_format($data2[0]->balance + $data2[0]->water_charges,2)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>

                            </div>
                            {!! $data2->appends(request()->query())->links() !!}
                            <div class=" row col-md-12">  
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <span>{{$data[0]->first_billing_message}}</span><br>
                                <span>{{$data[0]->second_billing_message}}.</span><br>
                                <span>{{$data[0]->third_billing_message}}.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {


        $('#selecOR').on('select2:select', function () {
            value = $(this).val();

            if (value == 'area') {
                alert(value)
                $('#CLIENT').removeAttr('name');
                $('#AREA2').attr('name');
                $('#CCID').removeAttr('cid');
                $('#CLIENT').hide();
                $('#CCID').hide();
            } else if (value == 'person') {
                $('#CLIENT').attr('name', 'client');
                $('#AREA2').removeAttr('name');
                $('#CCID').removeAttr('name');
                $('#AREA2').hide();
                $('#CCID').hide();
            } else if (value == 'account') {
                $('#CLIENT').removeAttr('name', 'client');
                $('#AREA2').removeAttr('name');
                $('#CCID').atr('name', 'cid');
                $('#CCID').show();
                $('#AREA2').hide();
                $('#CLIENT').hide();
            }
        })



        $('#CLIENT').val("{{$client}}").trigger('change');
        $('#CID').val("{{$cid}}").trigger('change');
        $('#AREA').val("{{$area}}").trigger('change');


        function printData()
        {
            $('.pagination').hide();
            $('table th').css('border', '1px solid black')
            $('table th').css('padding', '3px`')
            $('table td').css('border', '1px solid black')
            $('table td').css('padding', '3px')
            $('table').css('border-collapse', 'collapse')
            var divToPrint = document.getElementById("printToPdf");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        $('#PRINT').on('click', function () {
            printData();
        })

    })
</script>
@endsection