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
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('balances') }}" class="btn btn-block btn-primary"> DETAILED AREA
                                    BALANCES</a>
                            </div>
                            <div class="col">
                                <a href="{{ route('client.with_balances') }}" class="btn btn-block btn-danger">CLIENTS WITH
                                    BALANCES</a>
                            </div>
                            <div class="col">
                                <a href="{{ route('client.with_no_balances') }}" class="btn btn-block btn-success">CLIENTS
                                    WITH NO BALANCES
                                </a>
                            </div>
                        </div>
                        <div class="card">

                            <div class="card-body">
                                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                                        <center>
                                            <div class="card-title mt-3" style="font-weight:bold;">
                                                DETAILED AREA BALANCES
                                            </div>
                                        </center>
                                        <!--form method="get" action="{{ route('waterbill') }}">
                                                    <select class="form-input" name="area" style="width:200px !important;"
                                                        id="AREA">
                                                        <option value="">-SELECT-</option>
                                                        <option value="AREA">DETAILED AREA BALANCES</option>
                                                        <option value="CWB">CLIENTS WITH BALANCES</option>
                                                        <option value="CWNB">CLIENTS WITH NO BALANCES</option>
                                                    </select>


                                                </form-->
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
                            <div class="col-md-10">
                                <table class="table table-bordered" style="width:1000px !important;">
                                    <thead>
                                        <tr>
                                            <th class="tg-7btt">AREA CODE</th>
                                            <th class="">AREA NAME</th>
                                            <th class="tg-7btt">CLIENT COUNT</th>
                                            <th class="tg-7btt">BALANCE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $clients = 0;
                                        $balances = 0;
                                        ?>
                                        @foreach ($balances_ as $b)
                                            <?php
                                            $clients = $clients + $b->client_count;
                                            $balances = $balances + $b->balance;
                                            ?>

                                            <tr>
                                                <td class="">{{ $b->area }}</td>
                                                <td class="tg-c3ow" style="text-align: left;">{{ $b->area_name }}</td>
                                                <td class="tg-c3ow">{{ $b->client_count }}<br></td>
                                                <td class="" style="text-align: right;">
                                                    {{ $b->balance < 0 ? '(' . str_replace('-', '', number_format($b->balance, 2)) . ')' : number_format($b->balance, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="" colspan="1">TOTALS</td>
                                            <td class="tg-c3ow"></td>
                                            <td class="tg-c3ow">{{ $clients }}</td>
                                            <td class="" style="text-align: right;">
                                                {{ $balances < 0 ? '(' . str_replace('-', '', number_format($balances, 2)) . ')' : number_format($balances, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script>
        $(function() {

            // Check/uncheck all individual checkboxes when the "Select All" checkbox is clicked
            $('.send_messageMain').click(function() {
                var isChecked = $(this).prop('checked');
                $('.send_message').prop('checked', isChecked);
            });

            // If any of the individual checkboxes are unchecked, uncheck the "Select All" checkbox
            $('.send_message').click(function() {
                if (!$(this).prop('checked')) {
                    $('.send_messageMain').prop('checked', false);
                }
            });



            $('#AREA').change(function() {
                value = $(this).val();
                if (value == 'AREA') {
                    //.setItem('page', 'AREA');
                    window.location.href = "{{ route('balances') }}"
                } else if (value == 'CLIENTS') {
                    //localStorage.setItem('page', 'CLIENTS');
                    window.location.href = "{{ route('client.balances') }}"
                } else if (value == 'CWB') {
                    //localStorage.setItem('page', 'CWB');
                    window.location.href = "{{ route('client.with_balances') }}"
                } else if (value == 'CWNB') {
                    //localStorage.setItem('page', 'CWNB');
                    window.location.href = "{{ route('client.with_no_balances') }}"
                }
            })


            function printData() {
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

            $('#PRINT').on('click', function() {
                printData();
            })

        })
    </script>
@endsection
