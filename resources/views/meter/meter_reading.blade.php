@extends('layouts.admin')

@section('template_title')
Meter Reading
@endsection

@section('content')
<style>
    .number{text-align: right;}

</style>
<div class="container-fluid">
    <div class="row">
        <div class="row col-sm-12">    
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <strong>METER READING ENTRY</strong>
                            </span>
                            <!--span class="badge badge-info pull-right" style="font-weight: bold; font-size: 17px;">{{$i.'/'.$total}}</span-->

                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    @if ($message = Session::get('error'))
                    <div class="alert alert-error">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="{{route('save.meter.reading',['cid'=>$client[0]->id,'id'=>$n,'aid'=>$aid])}}">
                            @csrf
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="email">Area:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" required id='meterselection' name=''>
                                        <option value="{{$client[0]->area_id}}">{{$client[0]->area_name}}</option>
                                        @foreach($area as $a)
                                        <option value="{{$a->id}}">{{$a->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="pwd">Account Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control"  id="" value="{{$client[0]->account_name}}" readonly placeholder="Account Name" >

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-6" for="pwd">Reading Date</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control datepicker" required  id="reading_date" value="{{date('Y-m-d')}}" name="reading_date" placeholder="Reading Date" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="pwd">Reading(Units)</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" value="" required id="current_reading"  name="current_reading" placeholder="Reading(Units)" autofocus >
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" id="SUBMITTER" class="btn btn-danger" value="Submit">
                                    <a href="{{route('meter.reading.m',['id'=>$p,'aid'=>$aid])}}" class="btn btn-primary" {{$pvs}}>Previous</a>
                                    <a href="{{route('meter.reading.m',['id'=>$n,'aid'=>$aid])}}" class="btn btn-primary" {{$nts}}>Next</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <strong>MORE DETAILS</strong>
                            </span>
                            <!--span class="badge badge-info pull-right" style="font-weight: bold; font-size: 17px;">{{$i.'/'.$total}}</span-->

                        </div>
                    </div>

                    <div class="card-body">


                        <div class="form-group">
                            <label class="control-label col-sm-6" for="pwd" style="font-weight: bold;">Previous Meter Reading (Units)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control"  id="prev_reading" value="{{@$prevr}}" readonly  >

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="pwd" style="font-weight: bold;">Consumed (Units)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control"  id="consumed_units" value="0.00" readonly  >

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="pwd" style="font-weight: bold;">Billing Rate (Kshs.)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control"  id="area_rates" value="{{@number_format($area_name,2)}}" readonly  >

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="pwd" style="font-weight: bold;">Water Charges (Kshs.)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control"  id="charges" readonly  >

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-6" for="pwd" style="font-weight: bold;">Account Balance (Ksh.)</label>
                            <div class="col-sm-12">
                                <input type="hidden"  class="form-control" value="{{$bal}}"    id="cust_balance"  >

                                <input type="number" readonly class="form-control" value="{{number_format($bal,2)}}" required   id="show_balance" placeholder="Reading(Units)" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">

                            </div>
                        </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title float-left" style="float: left;">Meter Reading</h4>

            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="{{url('meter_reading')}}">
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="email">Area:</label>
                        <div class="col-sm-12">
                            <select class="form-control" required id='area_sel' name=''>
                                <option value="">-Select Area-</option>
                                @foreach($area as $a)
                                <option value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="pwd">Account</label>
                        <div class="col-sm-12">
                            <select class="form-control" required id='account_' name='client_id'>
                                <option value="">-Select Account-</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-6" for="pwd">Reading Date</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control datepicker" required id="reading_date"  name="reading_date" placeholder="Reading Date" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="pwd">Reading(Units)</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" required id="current_reading"  name="current_reading" placeholder="Reading(Units)" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>




@endsection
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(function () {
    $(".datepicker11").datepicker({dateFormat: 'yy-mm-dd'});
    $('#area_sel').change(function () {
        val = $(this).val();
        $.getJSON("{{url('api/v1/client')}}/" + val, function (resp) {
            $('#account_').empty();
            $('#account_').append('<option value="">-Select Account-</option>');
            $.each(resp, function (i, d) {
                $('#account_').append('<option value="' + d.id + '">' + d.account_name + '</option>');
            })
            //  $('#account_').select2();
        });
    });

    //$('#area_sel').select2();

    $('#current_reading').keyup(function () {
        val = parseInt($(this).val());
        prev = parseInt($('#prev_reading').val());
        cust_balance = parseInt($('#cust_balance').val());
        $('#consumed_units').val(val - prev);
        if (val < prev) {
//            Swal.fire(
//                    'Current reading cannot be less than the previous reading',
//                    ' ',
//                    'error'
//                    );
            //$('#current_reading').val('');
        }
        consumed = $('#consumed_units').val();
        area_rates = parseInt($('#area_rates').val());
        $('#charges').val(consumed * area_rates);
        charges = $('#charges').val();
        amount = cust_balance - charges;
        if (amount > 0) {
            bal = '(' + amount + ')';
        } else {
            bal = amount * -1;
        }
        $('#show_balance').val(bal);
    });


    $(document).on('click', '.EDITS', function () {
        id = $(this).attr('data-id');
        account = $(this).attr('data-account');
        account_name = $(this).attr('data-account-name');
        area = $(this).attr('data-area');
        date = $(this).attr('data-date');
        units = $(this).attr('data-units');
        $('#EDITTITLE').text("AREA > " + area + " | ACCOUNT No. > " + account + " | ACC.NAME > " + account_name);
        $('#reading_date1').val(date);
        $('#current_reading1').val(units);
        $('#id_').val(id);
    });

    $('#UpdateData').click(function () {
        data = {
            id_: $('#id_').val(),
            reading_date: $('#reading_date1').val(),
            current_reading: $('#current_reading1').val(),
            _token: "{{csrf_token()}}"
        }
        $.post("{{url('updateReadings')}}/", data, function () {
            window.location.href = ""
        });
    });
})
</script>
