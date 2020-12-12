@extends('layouts.admin')

@section('template_title')
Area
@endsection


@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-body">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                            <form method="get" action="{{route('area.report')}}">
                                <table>
                                    <tr>
                                        <td>
                                            <select class="form-control" name="type" style="width:200px !important;" id="AREA">
                                                <option value="AREA">SUMMARY</option>
                                                <option value="CLIENTS">DETAILED</option>
                                            </select> 
                                        </td>
                                        <td>
                                            <input type="text" id="dateChange" name="period" value="{{$period}}" class="form-control" placeholder="Select Date..."/>
                                        </td>
                                        <td>
                                            <input type="submit" id="MoveToData" class="btn btn-sm btn-primary" value="Submit"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </nav>
                </div>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive ">

                        <table class="table table-striped table-hover areas">
                            <thead class="thead">
                                <tr>             
                                    <th colspan="6"><center><b>SAMDAMTE WATER</b></center></th>                                   
                            </tr>
                            <tr>             
                                <th colspan="6"><center><b>CONSUMPTION SUMMARY BY AREAS OF {{$period1}}</b></center></th>                                   
                            </tr>
                            <tr>
                                <th>Area Code</th>
                                <th>Service Area</th>
                                <th><center>Client Count</center></th>
                            <th><center>Units Consumed</center></th>
                            <th><center>Flat Rated Customer Count</center></th>
                            <th><center>Invoiced Amount(KSh.)</center></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($result) > 0)
                                @foreach($result as $r)
                                <tr>
                                    <td>{{$r->id}}</td>
                                    <td>{{$r->name}}</td>
                                    <td class=""><center>{{number_format($r->clients,0)}}</center></td>
                            <td class=""><center>{{number_format($r->units_consumed,0)}}</center></td>
                            <td class=""><center>{{number_format($r->flat_rate,0)}}</center></td>
                            <td class="text-right">{{number_format($r->invoiced,2)}}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6"><center><span class="alert alert-warning">No data found for this period!</span></center></td>                             
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#AREA').val("{{$type}}").trigger('change');
    });
</script>

@endsection

