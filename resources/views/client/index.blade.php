@extends('layouts.admin')

@section('template_title')
Client
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            CLIENTS
                        </span>

                        <div class="float-right">
                            <a href="{{ route('client.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                Add New Client
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
                    <div class="table-responsive">
                        <table class="table table-striped table-hover client">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Area</th>
                                    <th>Account Name</th>
                                    <th>Phone No</th>
                                    <th>National Id</th>
                                    <th>KRA PIN</th>
                                    <th>Account Open Date</th>
                                    <th>Meter Number</th>
                                    <th>Plot Number</th>
                                    <th>Status</th>
                                    <th>Connection Date</th>
                                    <th>Vaccation Date</th>
                                    <th>Meter Reading Date</th>
                                    <th>Avatar</th>
                                    <th>Arreas(Ksh.)</th>
                                    <th>Acc. Bal.(Ksh.)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php ($i=1)
                                @foreach ($clients as $client)
                                <tr>
                                    <td>{{$i}}</td>                                
                                    <td>{{ $client->area_name }}</td>                                    
                                    <td>{{ $client->account_name }}</td>
                                    <td>{{ $client->phone_no }}</td>
                                    <td>{{ $client->national_id }}</td>
                                    <td>{{ $client->kra_pin }}</td>
                                    <td>{{ $client->account_open_date }}</td>
                                    <td>{{ $client->meter_number }}</td>
                                    <td>{{ $client->plot_number }}</td>
                                    <td>{{ $client->status_name }}</td>
                                    <td>{{ $client->connection_date }}</td>
                                    <td>{{ $client->vaccation_date }}</td>
                                    <td>{{ $client->meter_reading_date }}</td>
                                    <td>{{ $client->avatar }}</td>
                                    <td></td>
                                    <td></td>



                                    <td>
                                        <form action="{{ route('client.destroy',$client->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary " href="{{ route('client.show',$client->id) }}"><i class="fa fa-fw fa-eye" title="Show"></i> View</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('client.edit',$client->id) }}"><i class="fa fa-fw fa-edit" title="Edit"></i> Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash titleDelete"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @php ($i++)
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
