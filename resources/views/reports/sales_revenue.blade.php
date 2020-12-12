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
                            <form method="get" action="">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><input type="radio" class="radio" value="detail" name="report_type" checked="checked"> Detail</td>
                                        <td><input type="radio" class="radio" value="summary" name="report_type"> Summary</td>
                                        <td><input type="radio" class="radio" value="receipt" name="report_type"> Receipt</td>
                                        <td><input type="radio" class="radio" value="votehead" name="report_type"> Votehead</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input id="receiptno" name="receiptno" type="number" placeholder="Receipt No." class="form-control" style="display: none;"/>
                                        </td>
                                        <td>
                                            <div id="VH" style="display:none;">
                                                <select id="votehead" class="form-control" name="voteheadselection" >
                                                    <option value="APPICATION FEE">APPLICATION FEE</option>
                                                    <option value="ADVANCE PAY">ADVANCE PAY</option>
                                                    <option value="ARREARS">ARREARS</option>
                                                    <option value="RECONNECTION FEES">RECONNECTION FEE</option>
                                                    <option value="WATER CHARGES">WATER CHARGES</option>
                                                </select>
                                            </div>
                                        </td>
                                    <tr>
                                        <td>
                                            <select id="DateSel" class="form-control" name="datecriteria">
                                                <option value="datesingle">DATE</option>
                                                <option value="date_range">DATE RANGE</option>                                             
                                            </select> 
                                        </td>
                                        <td><input type="text" id="d1"  class="form-control datepicker" value="{{date('Y-m-d')}}" name="date" placeholder="Select Date"></td>
                                        <td><input type="text" id=""  class="form-control datepicker d2" style="display:none;" name="datefrom" placeholder="Select From Date"></td>
                                        <td><input type="text"  class="form-control datepicker d2" style="display:none;" name="dateto" placeholder="Select To Date"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="submit" value="Submit" class="btn btn-sm btn-warning"/></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

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
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <strong><b>SAMDAMTE WATER - HISTORY OF METER READINGS</b></strong>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">           
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <table class="table table-bordered" style="width:1000px !important;">
                                <thead>
                                    <tr>
                                        <th class="tg-7btt">PERIOD</th>
                                        <th class="">METER READING</th>
                                        <th class="tg-7btt">CONSUMPTION</th>                                             
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script>
    $(function () {
        
          $('#SCLIENTID').val("{{@$client_id}}").trigger('change');
         

        $('.radio').change(function () {
            value = $(this).val();
            if (value == 'receipt') {
                $('#receiptno').show();
            } else {
                $('#receiptno').hide();
            }
            if (value == 'votehead') {
                $('#VH').show();
            } else {
                $('#VH').hide();
            }
        })

        $('#DateSel').change(function () {
            value = $(this).val();
            if (value == 'datesingle') {
                $('#d1').show();
                $('.d2').hide();
            } else {
                $('#d1').hide();
                $('.d2').show();
            }
        })



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