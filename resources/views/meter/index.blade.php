@extends('layouts.admin')

@section('template_title')
Meter Reading
@endsection

@section('content')
<style>
    .number{text-align: right;}
    .ui-datepicker table{
        display: none;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            METER READING
                        </span>

                        <div class="float-right">
                            <a href="#meter-reading" class="btn btn-primary btn-sm float-right"  data-placement="left" data-toggle="modal" data-target="#myModal">
                                Add New Meter Reading
                            </a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">

                    <form action="{{ url('meter') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control monthPicker" required id="selection_date"  name="selection_date" value="{{$criteria}}">
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Submit</button> 
                            </div>
                        </div>
                        @csrf
                        @method('DELETE')

                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover legal">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Water Service Area</th>
                                    <th>Reading Date</th>
                                    <th>Account No.</th>
                                    <th>Account Name</th>
                                    <th>Account Balance</th>
                                    <th>Current Reading</th>
                                    <th>Previous Reading</th>
                                    <th>Consumed Units(cm<sup><small>3</small></sup>)</th>
                                    <th>Billing Rate(Ksh.)</th>
                                    <th>Water Charges(Ksh.)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($readings  as $r)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $r->area_name }}</td>
                                    <td>{{ $r->reading_date }}</td>
                                    <td>{{ $r->client_id }}</td>
                                    <td>{{ $r->account_name }}</td>
                                    <td></td>
                                    <td class="number">{{ $r->current_reading }}</td>
                                    <td class="number">{{ $r->previous_reading }}</td>
                                    <td class="number">{{ $r->consumed_units }}</td>
                                    <td class="number">{{ number_format($r->rate,2) }}</td>
                                    <td class="number"><strong><b>{{ number_format($r->water_charges,2) }}</b></strong></td>

                                    <td>
                                        <form action="{{ route('legal-centers.destroy',$r->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary " href="{{ route('legal-centers.show',$r->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('legal-centers.edit',$r->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                            <a class="btn btn-sm btn-warning" href="{{ url('sendNotification',$r->id) }}"><i class="fa fa-fw fa-edit"></i> Notify</a>
                                            @csrf
                                            @method('DELETE')
    <!--                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>-->
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    $('#area_sel').change(function () {
        val = $(this).val();
        $.getJSON("{{url('api/v1/client')}}/" + val, function (resp) {
            $('#account_').empty();
            $('#account_').append('<option value="">-Select Account-</option>');
            $.each(resp, function (i, d) {
                $('#account_').append('<option value="' + d.id + '">' + d.account_name + '</option>');
            })

        });
    });
})
</script>
