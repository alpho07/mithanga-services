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
                        <table class="table table-bordered table-hover client" id="clientsTable">
                            <thead class="thead">
                                <tr>
                                    <th>Account No.</th>
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
<!--                                    <th>Action</th>-->
<!--                                    <th>Arreas(Ksh.)</th>
                                    <th>Acc. Bal.(Ksh.)</th>
                                    <th></th>-->
                                </tr>
                            </thead>
                            <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                            </tfoot>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(function () {


        $('#clientsTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            ajax: '{!! route('get.clients') !!}',
            columns: [
                {data: 'id', name: 'id', mRender: function (data, type, row) {
                        return "<a class='btn btn-sm btn-primary' href={{url('client/show')}}/" + row.id + ">View Account No (" + row.id + ")</a>"
                    }},
                {data: 'area_name', name: 'area_name'},
                {data: 'account_name', name: 'account_name'},
                {data: 'phone_no', name: 'phone_no'},
                {data: 'national_id', name: 'national_id'},
                {data: 'kra_pin', name: 'kra_pin'},
                {data: 'account_open_date', name: 'account_open_date'},
                {data: 'meter_number', name: 'meter_number'},
                {data: 'plot_number', name: 'plot_number'},
                {data: 'status_name', name: 'status_name'},
                {data: 'connection_date', name: 'connection_date'},
                {data: 'vaccation_date', name: 'vaccation_date'},
                {data: 'meter_reading_date', name: 'meter_reading_date'},
                {data: 'avatar', name: 'avatar', "mRender": function (data, type, row) {

                        return "<img width=50px height=50px alt='No Image' src={{url('avatar')}}/" + row.avatar + "/>";
                    }},
            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                            .on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                });
            }
        });

    });
</script>

@endsection

