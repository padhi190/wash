@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.vehicle.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['vehicles.storeFull']]) !!}

    <div class="panel panel-default">
        <!-- <div class="panel-heading">
            @lang('quickadmin.create')
        </div> -->
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('customer_id', 'Customer*', ['class' => 'control-label']) !!}
                    {!! Form::select('customer_id', $customers, old('customer_id', $customer_id), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('customer_id'))
                        <p class="help-block">
                            {{ $errors->first('customer_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('license_plate', 'Plat No.*', ['class' => 'control-label']) !!}
                    {!! Form::text('license_plate', old('license_plate'), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:uppercase','autofocus']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('license_plate'))
                        <p class="help-block">
                            {{ $errors->first('license_plate') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-xs-3 form-group">
                    {!! Form::label('brand', 'Brand', ['class' => 'control-label']) !!}
                    {!! Form::text('brand', old('brand'), ['class' => 'form-control', 'style' => 'text-transform:capitalize', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('brand'))
                        <p class="help-block">
                            {{ $errors->first('brand') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-3 form-group">
                    {!! Form::label('model', 'Model', ['class' => 'control-label']) !!}
                    {!! Form::text('model', old('model'), ['class' => 'form-control', 'style' => 'text-transform:capitalize', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('model'))
                        <p class="help-block">
                            {{ $errors->first('model') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-3 form-group">
                    {!! Form::label('color', 'Warna', ['class' => 'control-label']) !!}
                    {!! Form::text('color', old('color'), ['class' => 'form-control', 'style' => 'text-transform:capitalize', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('color'))
                        <p class="help-block">
                            {{ $errors->first('color') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-3 form-group">
                    {!! Form::label('type', 'Type*', ['class' => 'control-label']) !!}
                    <br>
                    @if($errors->has('type'))
                        <p class="help-block">
                            {{ $errors->first('type') }}
                        </p>
                    @endif
                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="type" value='mobil' autocomplete="off" checked> Mobil
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="type" value='motor' autocomplete="off" > Motor
                        </label>
                    </div>
                </div>
            </div>
            
            
            <div class="row">

                
                <div class="col-xs-6 form-group">
                    {!! Form::label('income_category_id', 'Kategori*', ['class' => 'control-label']) !!}
                   
                    <br>
                    @if($errors->has('income_category_id'))
                        <p class="help-block">
                            {{ $errors->first('income_category_id') }}
                        </p>
                    @endif
                    <div class="btn-group btn-group-lg btn-group-justified" data-toggle="buttons">
                      @foreach($income_categories as $key => $cat)
                        <label class="btn btn-primary {{$cat == 'Carwash' ? 'active' : ''}}">
                            <input type="radio" name="income_category_id" value={{$key}} data-name="{{$cat}}" autocomplete="off" 
                            {{$cat == 'Carwash' ? 'checked' : ''}}
                            onchange="showProduct(this); setPrice(this);"> {{ $cat }}
                        </label>
                      @endforeach
                      
                    </div>
                </div>

                <div class="col-xs-3 form-group">
                    {!! Form::label('size', 'Size', ['class' => 'control-label']) !!}
                    <br>
                    <div class="btn-group btn-group-lg" data-toggle="buttons">
                        <label class="btn btn-primary ">
                            <input type="radio" name="size" value='small' autocomplete="off" > Small
                        </label>
                        <label class="btn btn-primary active" >
                            <input type="radio" name="size" value='medium' autocomplete="off" checked > Medium
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="size" value='large' autocomplete="off" > Large
                        </label>
                    </div>
                    @if($errors->has('size'))
                        <p class="help-block">
                            {{ $errors->first('size') }}
                        </p>
                    @endif
                    
                </div>

                <div class="col-xs-3 form-group">
                    {!! Form::label('entry_date', 'Tanggal*', ['class' => 'control-label']) !!}
                    {!! Form::text('entry_date', old('entry_date', Carbon\Carbon::now()->format('d-m-Y H:i')), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
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
                    
                    {{ Form::hidden('branch_id', Session::get('branch_id'))}}
                    <p class="help-block"></p>
                    @if($errors->has('branch_id'))
                        <p class="help-block">
                            {{ $errors->first('branch_id') }}
                            {{ Session::get('branch_id')}}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">

                

            </div>
           
            <div class="row">

                <div class="col-xs-6 form-group">
                    {!! Form::label('payment_type_id', 'Cara Pembayaran*', ['class' => 'control-label']) !!}
                    
                   <br>
                    @if($errors->has('payment_type_id'))
                        <p class="help-block">
                            {{ $errors->first('payment_type_id') }}
                        </p>
                    @endif
                    <div class="btn-group" data-toggle="buttons">
                      @foreach($payment_types as $key => $payment)
                        <label class="btn btn-danger {{ $payment == 'Cash' ? 'active' : ''}}">
                            <input type="radio" name="payment_type_id" value={{$key}} data-name="{{$payment}}" autocomplete="off" 
                             {{ $payment == 'Cash' ? 'checked' : ''}}
                            > 
                            {{ $payment }}
                        </label>
                      @endforeach
                      
                    </div>
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('amount', 'Harga*', ['class' => 'control-label']) !!}
                    {!! Form::number('amount', old('amount', $prices['carwash']), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('amount'))
                        <p class="help-block">
                            {{ $errors->first('amount') }}
                        </p>
                    @endif
                </div>
                
            </div>
        
            <div class="row"> 

                <div class="col-xs-6 form-group">
                        {!! Form::label('nobon', 'No. Bon', ['class' => 'control-label']) !!}
                        {!! Form::text('nobon', old('nobon', $last_bon+1), ['class' => 'form-control', 'placeholder' => $last_bon+1]) !!}
                        <p class="help-block"></p>
                        @if($errors->has('nobon'))
                            <p class="help-block">
                                {{ $errors->first('nobon') }}
                            </p>
                        @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('note', 'Note', ['class' => 'control-label']) !!}
                    {!! Form::textarea('note', old('note'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '3']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('note'))
                        <p class="help-block">
                            {{ $errors->first('note') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 form-group hidden_field" style="visibility: hidden">
                    {!! Form::label('product_id', 'Produk', ['class' => 'control-label']) !!}
                    {!! Form::select('product_id', $products, old('product_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('product_id'))
                        <p class="help-block">
                            {{ $errors->first('product_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group hidden_field" style="visibility: hidden">
                    {!! Form::label('qty', 'Qty*', ['class' => 'control-label']) !!}
                    {!! Form::number('qty', old('qty', 1), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('qty'))
                        <p class="help-block">
                            {{ $errors->first('qty') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger btn-lg']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script>
        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm",
            maxDate:0,
            stepMinute: 5,
            showSecond: false,
            controlType: 'select',
            showMillisec:false,
            showMicrosec:false
        });

        function showProduct(kategori){
            if(kategori.value == 4){
                $('.hidden_field').css('visibility', 'visible');
            }
            else{
                $('.hidden_field').css('visibility', 'hidden');   
            }
        };

        function setPrice(kategori){
            switch(kategori.value) {
                case '1':
                    $('#amount').val({{$prices['carwash']}});
                    break;
                case '2':
                    $('#amount').val({{$prices['wax']}});
                    break;
                case '3':
                    $('#amount').val({{$prices['detailing']}});
                    break;
                case '4':
                    $('#amount').val({{$prices['fnb']}});
                    break;
                case '5':
                    $('#amount').val({{$prices['bikewash']}});
                    break;  
                default:
                    
                    break;
            };
        };
    </script>

@stop
