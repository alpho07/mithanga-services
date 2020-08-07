@extends('layouts.admin')

@section('template_title')
    Create Transaction
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Make New Payment</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('payment.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('payment.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
