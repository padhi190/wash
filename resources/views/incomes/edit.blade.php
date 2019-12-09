@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title') - Edit</h3>
    
    {!! Form::model($income, ['method' => 'PUT', 'route' => ['incomes.update', $income->id]]) !!}

    {{ Form::hidden('wax_category', old('wax_category'), ['id' => 'wax_category']) }}

    <div class="panel panel-default">

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('income_category_id', 'Kategori*', ['class' => 'control-label']) !!}
                    <!-- {!! Form::select('income_category_id', $income_categories, old('income_category_id'), ['class' => 'form-control select2', 'onchange' => 'showProduct(this)']) !!} -->
                    <p class="help-block"></p>
                    @if($errors->has('income_category_id'))
                        <p class="help-block">
                            {{ $errors->first('income_category_id') }}
                        </p>
                    @endif
                    <div class="btn-group btn-group-lg" data-toggle="buttons">
                      @foreach($income_categories as $key => $cat)
                        @if(in_array($cat,array('Carwash','Detailing','Bikewash','Beli Voucher','Lain-lain')))
                        <label class="btn btn-primary {{$key == $income->income_category_id ? 'active' : ''}}">
                            <input type="radio" name="income_category_id" value={{$key}} data-name="{{$cat}}" autocomplete="off" 
                            {{$key == $income->income_category_id ? 'checked' : ''}}
                            onchange="showProduct(this); setPrice(this);"> {{ $cat }}
                        </label>
                        @endif
                      @endforeach
                      
                    </div>
                </div>
            </div>
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
                <div class="col-xs-6 form-group">
                    {!! Form::label('vehicle_id', 'Kendaraan*', ['class' => 'control-label']) !!}
                    
                    {!! Form::select('vehicle_id', [$income->vehicle_id => $income->vehicle['full_vehicle']], old('vehicle_id'), ['class' => 'form-control cari']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('vehicle_id'))
                        <p class="help-block">
                            {{ $errors->first('vehicle_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
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
                <div class="col-xs-6 form-group">
                    {!! Form::label('payment_type_id', 'Cara Pembayaran*', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('payment_type_id'))
                        <p class="help-block">
                            {{ $errors->first('payment_type_id') }}
                        </p>
                    @endif
                    <div class="btn-group" data-toggle="buttons">
                      @foreach($payment_types as $key => $payment)
                        <label class="btn btn-danger {{ $key == $income->payment_type_id ? 'active' : ''}}">
                            <input type="radio" name="payment_type_id" value={{$key}} data-name="{{$payment}}" autocomplete="off" 
                             {{ $key == $income->payment_type_id ? 'checked' : ''}}
                            > 
                            {{ $payment }}
                        </label>
                      @endforeach
                      
                    </div>
                </div>

                <div class="col-xs-6 form-group">
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
            
            <div class="row">

                <div class="col-xs-6 form-group">
                    {!! Form::label('nobon', 'No. Bon', ['class' => 'control-label']) !!}
                    {!! Form::text('nobon', old('nobon'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nobon'))
                        <p class="help-block">
                            {{ $errors->first('nobon') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('note', 'Note', ['class' => 'control-label']) !!}
                    {!! Form::textarea('note', old('note'), ['class' => 'form-control ', 'placeholder' => '', 'rows'=>'3']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('note'))
                        <p class="help-block">
                            {{ $errors->first('note') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('addon', 'Tambahan', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    
                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-success {{$income->fnb_amount > 0 ? 'active' : ''}}">
                            <input type="checkbox" name="FnBcheckbox" id="FnBcheckbox" value="FnB" data-name="fnb" autocomplete="off" onchange="showFnB(this), updateTotal()" 
                            {{$income->fnb_amount > 0 ? 'checked' : ''}}> 
                                F&B
                        </label>
                        <label class="btn btn-success {{($income->wax_amount > 0 && $income->wax_category != 'Spray') ? 'active' : ''}}">
                            <input type="checkbox" name="Waxcheckbox" id="Waxcheckbox" value="Wax" data-name="fnb" autocomplete="off" onchange="showWax(this), updateTotal()"
                            {{($income->wax_amount > 0 && $income->wax_category != 'Spray') ? 'checked' : ''}}> 
                                Full Wax
                        </label>
                        <label class="btn btn-success {{$income->wax_category == 'Spray' ? 'active' : ''}}">
                            <input type="checkbox" name="Spraywaxcheckbox" id="Spraywaxcheckbox" value="SprayWax" data-name="fnb" autocomplete="off" onchange="showWax(this),updateTotal()"
                            {{$income->wax_category == 'Spray' ? 'checked' : ''}}> 
                                Spray Wax
                        </label>
                      
                    </div>
                </div>
                
                <div class="col-xs-3 form-group fnb_field" style="{{$income->fnb_amount > 0 ? '' : 'visibility: hidden;'}}">
                    {!! Form::label('fnb_amount', 'Harga F&B', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    {!! Form::number('fnb_amount', old('fnb_amount'), ['class' => 'form-control', 'placeholder' => '', 'id' => 'fnb_amount', 'onchange' => 'updateTotal()']) !!}
                    
                    @if($errors->has('fnb_amount'))
                        <p class="help-block">
                            {{ $errors->first('fnb_amount') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-3 form-group wax_field" style="{{$income->wax_amount > 0 ? '' : 'visibility: hidden;'}}">
                    {!! Form::label('wax_amount', 'Harga Wax', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    {!! Form::number('wax_amount', old('wax_amount'), ['class' => 'form-control', 'placeholder' => '', 'id' => 'wax_amount', 'onchange'=>'updateTotal()']) !!}
                    
                    @if($errors->has('wax_amount'))
                        <p class="help-block">
                            {{ $errors->first('wax_amount') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-3 form-group">
                    {!! Form::label('total_amount', 'Total', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    {!! Form::number('total_amount', old('total_amount'), ['class' => 'form-control disabled', 'placeholder' => '', 'id' => 'total_amount','disabled']) !!}
                    
                    @if($errors->has('total_amount'))
                        <p class="help-block">
                            {{ $errors->first('total_amount') }}
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

        $(document).ready(function(){
            $('.cari').select2({
                ajax: {
                  url: "{!! route('loadVehiclesData') !!}",
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    var results = [];
                    $.each(data, function (index, vehicles) {
                        results.push({
                            id: vehicles.id,
                            text: vehicles.license_plate + " | " + vehicles.type + " " + vehicles.model + " " + vehicles.color + ": " + vehicles.customer.name
                        });
                    });

                    return {
                        results: results
                    };
                  },
                }
            });
        });

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

        // if($('#income_category_id').val() == 4) {
        //     $('.hidden_field').css('visibility', 'visible');
        // }
        function showProduct(kategori){
            if(kategori.value == 4){
                $('.hidden_field').css('visibility', 'visible');
            }
            else{
                $('.hidden_field').css('visibility', 'hidden');   
            }
        }

        function updateTotal(){
            var fnb = 0;
            var wax = 0;
            // window.alert($('input[name="FnBcheckbox"]').is(':checked'));
            if($('input[name="FnBcheckbox"]').is(':checked')){
                fnb = parseInt($('#fnb_amount').val());
            }

            if($('input[name="Waxcheckbox"]').is(':checked')){
                wax = parseInt($('#wax_amount').val());
            }

            if($('input[name="Spraywaxcheckbox"]').is(':checked')){
                $('#wax_category').val("Spray");
                wax = parseInt($('#wax_amount').val());
            }

            if($('input[name="Spraywaxcheckbox"]').is(':checked') == false){
                $('#wax_category').val("");
                wax = parseInt($('#wax_amount').val());
            }

            var total = fnb + wax + parseInt($('#amount').val());
            $('#total_amount').val(total);
        };

        function showFnB(addition){
            // window.alert(addition.checked);
            if(addition.checked){
                $('.fnb_field').css('visibility', 'visible');
                $('#fnb_amount').val(0);
            }
            else{
                $('.fnb_field').css('visibility', 'hidden'); 
                $('#fnb_amount').val(0);
            }
        };

        function showWax(addition){
            // window.alert(addition.checked);
            if(addition.checked){
                $('.wax_field').css('visibility', 'visible');
                $('#wax_amount').val(0); 
            }
            else{
                $('.wax_field').css('visibility', 'hidden'); 
                $('#wax_amount').val(0);
            }
        };
    </script>

@stop