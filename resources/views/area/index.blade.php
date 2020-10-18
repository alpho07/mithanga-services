@extends('layouts.admin')

@section('template_title')
Area
@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Area') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('areas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                {{ __('Create New') }}
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
                    <div class="table-responsive ">
                        <table class="table table-striped table-hover areas">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $area->name }}</td>
                                    <td>{{ $area->rate }}</td>

                                    <td>
                                        <form action="{{ route('areas.destroy',$area->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary " href="{{ route('reading.sheet',$area->id) }}"><i class="fa fa-fw fa-eye"></i> View Clients ({{$area->client->count()}})</a>
                                            <a class="btn btn-sm btn-warning " href="{{ route('clients.print',$area->id) }}"><i class="fa fa-fw fa-print"></i> Print Clients</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('areas.edit',$area->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
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

@endsection
