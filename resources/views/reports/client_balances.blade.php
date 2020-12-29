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
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                                    <form method="get" action="{{route('waterbill')}}">
                                        <select class="form-input" name="area" style="width:200px !important;" id="AREA">
                                            <option value="CLIENTS">DETAILED CLIENT BALANCES</option> 
                                            <option value="AREA">DETAILED AREA BALANCES</option>
                                        </select> 


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



                @foreach($data as $d)
                <div class="card-body" id="printToPdf">

                    <div class="row">           
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <table class="table table-bordered" style="width:1000px !important;">
                                <thead>
                                    <tr>
                                        <td colspan="4"><strong>AREA: {{$d['area']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="tg-7btt">AREA CODE</th>
                                        <th class="">AREA NAME</th>
                                        <th class="tg-7btt">CLIENT NAME</th>
                                        <th class="tg-7btt">BALANCE</th>                                               
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($d['clients'] as $b)
                                    <tr>
                                        <td class="">{{$b->area}}</td>
                                        <td class="tg-c3ow" style="text-align: left;">{{$b->area_name}}</td>
                                        <td class="tg-c3ow">{{$b->account_name}}<br></td>
                                        <td class="" style="text-align: right;">{{($b->balance < 0) ? '('.str_replace('-','',number_format($b->balance,2)).')' : number_format($b->balance,2) }}</td>                                      
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                <td></td>
                                <td></td>
                                <td><strong>TOTALS</strong></td>
                                <td style="text-align: right;"><strong>{{number_format($d['balance'],2)}}</strong></td>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>


<script>
    $(function () {
        $('#AREA').change(function () {
            value = $(this).val();
            if (value == 'AREA') {
                window.location.href = "{{route('balances')}}"
            } else {
                window.location.href = "{{route('client.balances')}}"
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