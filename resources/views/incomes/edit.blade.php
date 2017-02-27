@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>
    
    {!! Form::model($income, ['method' => 'PUT', 'route' => ['incomes.update', $income->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                   <!--  {!! Form::label('branch_id', 'Cabang*', ['class' => 'control-label']) !!}
                    {!! Form::select('branch_id', $branches, old('branch_id'), ['class' => 'form-control select2']) !!} -->
                    {{ Form::hidden('branch_id', Session::get('branch_id'))}}
                    <p class="help-block"></p>
                    @if($errors->has('branch_id'))
                        <p class="help-block">
                            {{ $errors->first('branch_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('vehicle_id', 'Kendaraan*', ['class' => 'control-label']) !!}
                    {!! Form::select('vehicle_id', $vehicles, old('vehicle_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('vehicle_id'))
                        <p class="help-block">
                            {{ $errors->first('vehicle_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('entry_date', 'Tanggal*', ['class' => 'control-label']) !!}
                    {!! Form::text('entry_date', old('entry_date'), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('entry_date'))
                        <p class="help-block">
                            {{ $errors->first('entry_date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('income_category_id', 'Kategori*', ['class' => 'control-label']) !!}
                    {!! Form::select('income_category_id', $income_categories, old('income_category_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('income_category_id'))
                        <p class="help-block">
                            {{ $errors->first('income_category_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('product_id', 'Produk (opsional)', ['class' => 'control-label']) !!}
                    {!! Form::select('product_id', $products, old('product_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('product_id'))
                        <p class="help-block">
                            {{ $errors->first('product_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('qty', 'Qty*', ['class' => 'control-label']) !!}
                    {!! Form::number('qty', old('qty'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('qty'))
                        <p class="help-block">
                            {{ $errors->first('qty') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('amount', 'Harga*', ['class' => 'control-label']) !!}
                    {!! Form::text('amount', old('amount'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('amount'))
                        <p class="help-block">
                            {{ $errors->first('amount') }}
                        </p>
                    @endif
                </div>
            </div>
           <!--  <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('discount', 'Discount', ['class' => 'control-label']) !!}
                    {!! Form::text('discount', old('discount'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('discount'))
                        <p class="help-block">
                            {{ $errors->first('discount') }}
                        </p>
                    @endif
                </div>
            </div> -->
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('payment_type_id', 'Cara Pembayaran*', ['class' => 'control-label']) !!}
                    {!! Form::select('payment_type_id', $payment_types, old('payment_type_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('payment_type_id'))
                        <p class="help-block">
                            {{ $errors->first('payment_type_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('note', 'Note', ['class' => 'control-label']) !!}
                    {!! Form::textarea('note', old('note'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('note'))
                        <p class="help-block">
                            {{ $errors->first('note') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script>
        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "hh:mm:ss"
        });
    </script>

@stop