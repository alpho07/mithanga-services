<div class="box box-info padding-1">
    <div class="box-body">
        <input type="hidden" value="{{date('YmdHis')}}" name="reference"/>

        <div class="form-group {{ $errors->has('client_id') ? 'has-error' : '' }}">
            <label for="expense_category">Client</label>
            <select name="client_id" id="client_id" class="form-control select2">
                @foreach($clients as $id => $client)
                <option value="{{ $client->id }}">{{'ACCOUNT No. '.$client->id. ' | '.$client->account_name.' | '.$client->area_name  }}</option>
                @endforeach
            </select>
            @if($errors->has('expense_category_id'))
            <em class="invalid-feedback">
                {{ $errors->first('client_id') }}
            </em>
            @endif
        </div>
        <div class="form-group {{ $errors->has('mop') ? 'has-error' : '' }}">
            <label for="mop">Client</label>
            <select name="mop" id="client_id" class="form-control select2">
                @foreach($mop as $id => $m)
                <option value="{{ $m->id }}">{{$m->name  }}</option>
                @endforeach
            </select>
            @if($errors->has('mop'))
            <em class="invalid-feedback">
                {{ $errors->first('mop') }}
            </em>
            @endif
        </div>
        <div class="form-group {{ $errors->has('bank') ? 'has-error' : '' }}">
            <label for="bank">Bank</label>
            <select name="bank" id="BANK" class="form-control select2">
                 <option value="">--Select Bank--</option> 
                @foreach($banks as $id => $m)
                <option value="{{ $m->id }}">{{$m->name  }}</option>
                @endforeach
            </select>
            @if($errors->has('bank'))
            <em class="invalid-feedback">
                {{ $errors->first('bank') }}
            </em>
            @endif
        </div>
         <div class="form-group {{ $errors->has('branch') ? 'has-error' : '' }}">
            <label for="branch">Branch</label>
            <select name="branch" id="BRANCH" class="form-control select2">
                <option value="">--Select Bank first--</option> 
            </select>
            @if($errors->has('bank'))
            <em class="invalid-feedback">
                {{ $errors->first('branch') }}
            </em>
            @endif
        </div>
        <input type="hidden" name="staff" value="{{strtoupper(Auth::user()->name)}}"/>
        <div class="form-group">
            {{ Form::label('description') }}
            {{ Form::text('description', $transaction->description, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Description']) }}
            {!! $errors->first('description', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('date') }}
                {{ Form::text('date', date('Y-m-d H:i:s'), ['class' => 'form-control' . ($errors->has('date') ? ' is-invalid' : ''), 'placeholder' => 'Date','readonly'=>'readonly']) }}
                {!! $errors->first('date', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group"  style="display:none;">
                    {{ Form::label('type') }}
                    {{ Form::text('type', 'credit', ['class' => 'form-control' . ($errors->has('type') ? ' is-invalid' : ''), 'placeholder' => 'Type']) }}
                    {!! $errors->first('type', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('amount') }}
                        {{ Form::text('amount', $transaction->amount, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''), 'placeholder' => 'Amount']) }}
                        {!! $errors->first('amount', '<div class="invalid-feedback">:message</p>') !!}
                        </div>
                        <div class="form-group" style="display:none;">
                            {{ Form::label('units') }}
                            {{ Form::text('units', $transaction->units, ['class' => 'form-control' . ($errors->has('units') ? ' is-invalid' : ''), 'placeholder' => 'Units']) }}
                            {!! $errors->first('units', '<div class="invalid-feedback">:message</p>') !!}
                            </div>

                        </div>
                        <div class="box-footer mt20">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
             