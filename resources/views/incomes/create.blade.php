@extends('layouts.app')

@section('content')
   
    
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>
    @can('vehicle_create')
    <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                  @if(Session::has('alert-' . $msg))

                  <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                  @endif
                @endforeach
    </div> 
    <p>
        <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#formModal">
              <i class="fa fa-user"></i>  + Customer Baru
        </button> -->
        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#formModal">
              <i class="fa fa-car"></i>  + Kendaraan Baru</a>
        </button>

        <a href="{!!route('incomes.index')!!}" class="btn btn-primary btn-lg">
              <i class="fa fa-list"></i> List Penjualan</a>
        </a>

        <button class="btn btn-primary btn-lg" data-toggle="control-sidebar" id="antrianButton">Antrian</button>

        <button type="button" data-toggle="tooltip" title="{{$wainfo}}" class="btn {{$wastatus['success'] ? 'btn-success' : 'btn-danger'}} btn-lg">
              <i class="fa fa-whatsapp fa-lg"></i> 
        </button>

       
    </p>
    @endcan

    
        

       
    
    {!! Form::open(['method' => 'POST', 'route' => ['incomes.store']]) !!}

    <div class="panel panel-default">
        
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('income_category_id', 'Kategori*', ['class' => 'control-label']) !!}
                   
                    <p class="help-block"></p>
                    @if($errors->has('income_category_id'))
                        <p class="help-block">
                            {{ $errors->first('income_category_id') }}
                        </p>
                    @endif
                    <div class="btn-group btn-group-lg" data-toggle="buttons">
                      @foreach($income_categories as $key => $cat)
                        @if(in_array($cat,array('Carwash','Detailing','Bikewash','Beli Voucher','Lain-lain')))
                        <label class="btn btn-primary {{$cat == 'Carwash' ? 'active' : ''}}" id="{{$cat}}">
                            <input type="radio" name="income_category_id" value={{$key}} data-name="{{$cat}}" autocomplete="off" 
                            {{$cat == 'Carwash' ? 'checked' : ''}}
                            onchange="setPrice(this);"> {{ $cat }}
                        </label>
                        @endif
                      @endforeach
                      
                    </div>
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
                <div class="col-xs-6 form-group">
                    {!! Form::label('vehicle_id', 'Kendaraan*', ['class' => 'control-label']) !!}
                    {!! Form::select('vehicle_id', ["" => "Cari"], null, ['class' => 'form-control cari', 'id' => 'vehicle_id']) !!}
                    <!-- <select class="cari form-control select2" style="width:500px;" name="vehicle_id"; id="cari" ></select> -->
                    <p class="help-block"></p>
                    @if($errors->has('vehicle_id'))
                        <p class="help-block">
                            {{ $errors->first('vehicle_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
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
                        <label class="btn btn-danger {{ $payment == 'Cash' ? 'active' : ''}}">
                            <input type="radio" name="payment_type_id" value={{$key}} data-name="{{$payment}}" autocomplete="off" 
                             {{ $payment == 'Cash' ? 'checked' : ''}}
                            onchange="setPayment(this)"> 
                            {{ $payment }}
                        </label>
                      @endforeach
                      
                    </div>
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('amount', 'Harga*', ['class' => 'control-label']) !!}
                    {!! Form::number('amount', old('amount', $prices['carwash']), ['class' => 'form-control', 'placeholder' => '', 'onchange' =>'updateTotal()']) !!}
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
                    {!! Form::textarea('note', old('note'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2', 'id' => 'note']) !!}
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
                        <label class="btn btn-success">
                            <input type="checkbox" name="FnBcheckbox" id="FnBcheckbox" value="FnB" data-name="fnb" autocomplete="off" onchange="showFnB(this),updateTotal()"> 
                                F&B
                        </label>
                        <label class="btn btn-success">
                            <input type="checkbox" name="Waxcheckbox" id="Waxcheckbox" value="Wax" data-name="fnb" autocomplete="off" onchange="showWax(this),updateTotal()"> 
                                Wax
                        </label>
                      
                    </div>
                </div>
                
                <div class="col-xs-3 form-group fnb_field" style="visibility: hidden;">
                    {!! Form::label('fnb_amount', 'Harga F&B', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    {!! Form::number('fnb_amount', old('fnb_amount'), ['class' => 'form-control', 'placeholder' => '', 'id' => 'fnb_amount', 'onchange' => 'updateTotal()']) !!}
                    
                    @if($errors->has('fnb_amount'))
                        <p class="help-block">
                            {{ $errors->first('fnb_amount') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-3 form-group wax_field" style="visibility: hidden;">
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
                    {!! Form::number('total_amount', old('total_amount', $prices['carwash']), ['class' => 'form-control disabled', 'placeholder' => '', 'id' => 'total_amount','disabled']) !!}
                    
                    @if($errors->has('total_amount'))
                        <p class="help-block">
                            {{ $errors->first('total_amount') }}
                        </p>
                    @endif
                </div>              
            </div>
            
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 form-group">
            {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger btn-lg']) !!}
            <button type="button" id="printButton" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#printModal">
              Print Bon Terakhir
            </button>
        </div>
        <div class="col-xs-6 form-group">
             
        </div>

    </div>
    {!! Form::close() !!}
    
    <!-- Print Modal Form -->
    
    @extends('partials.print')
    @section('printSection')
         <div style="text-align:center; font-size:18px;">
            @if($last_sales != null)
            <p>Rcpt No: {{$last_sales->nobon}}</p>
            <p>{{$last_sales->entry_date}}</p>
            <p><strong>{{$last_sales->vehicle->license_plate}} - {{$last_sales->vehicle->type}}</strong></p>
            <p>{{$last_sales->income_category->name}} : <span text-align="right">Rp. {{number_format($last_sales->amount)}}</span></p>
            
            @if($last_sales->wax_amount > 0)
            <p>Wax : <span text-align="right">Rp. {{number_format($last_sales->wax_amount)}}</span></p>
            @endif

            @if($last_sales->fnb_amount > 0)
            <p>F&B : <span text-align="right">Rp. {{number_format($last_sales->fnb_amount)}}</span></p>
            @endif
            <!-- <p style="font-size:14px">{{$last_sales->note}}</p> -->
            <p><strong>Total: Rp. {{number_format($last_sales->total_amount)}}</strong></p>
            @endif
        </div>
    @stop

    <!-- Add New Customer Modal Form -->
    @extends('partials.modalform', ['title' => 'Customer', 'formId' => 'formModal'])

    @section('formSection')
        {!! Form::open(['method' => 'POST', 'route' => ['customers.storeFull']]) !!}

        <div class="panel panel-default">
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-3 form-group">
                        {!! Form::label('name', 'Nama*', ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:capitalize', 'autofocus']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('name'))
                            <p class="help-block">
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-3 form-group">
                        {!! Form::label('phone', 'Phone', ['class' => 'control-label']) !!}
                        {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('phone'))
                            <p class="help-block">
                                {{ $errors->first('phone') }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-3 form-group">
                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                        {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('email'))
                            <p class="help-block">
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>


                    <div class="col-xs-3 form-group">
                        {!! Form::label('sex', 'Jenis Kelamin*', ['class' => 'control-label']) !!}
                        <br>
                        @if($errors->has('sex'))
                            <p class="help-block">
                                {{ $errors->first('sex') }}
                            </p>
                        @endif
                        <div class="btn-group btn-group-justified" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" name="sex" value='Laki-laki' autocomplete="off" checked> Laki-laki
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="sex" value='Perempuan' autocomplete="off" > Perempuan
                            </label>
                        </div>
                        
                    </div>
                </div>
                
                <div class="row">

                    <div class="col-xs-3 form-group">
                        {!! Form::label('license_plate', 'Plat No.*', ['class' => 'control-label']) !!}
                        {!! Form::text('license_plate', old('license_plate'), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:uppercase']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('license_plate'))
                            <p class="help-block">
                                {{ $errors->first('license_plate') }}
                            </p>
                        @endif
                    </div>
                    
                    <div class="col-xs-6">
                        <div class="col-xs-4 form-group">
                            {!! Form::label('brand', 'Brand', ['class' => 'control-label']) !!}
                            {!! Form::text('brand', old('brand'), ['class' => 'form-control','style' => 'text-transform:capitalize', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('brand'))
                                <p class="help-block">
                                    {{ $errors->first('brand') }}
                                </p>
                            @endif
                        </div>

                        <div class="col-xs-4 form-group">
                            {!! Form::label('model', 'Model', ['class' => 'control-label']) !!}
                            {!! Form::text('model', old('model'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('model'))
                                <p class="help-block">
                                    {{ $errors->first('model') }}
                                </p>
                            @endif
                        </div>

                        <div class="col-xs-4 form-group">
                            {!! Form::label('color', 'Warna', ['class' => 'control-label']) !!}
                            {!! Form::text('color', old('color'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('color'))
                                <p class="help-block">
                                    {{ $errors->first('color') }}
                                </p>
                            @endif
                        </div>
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
                            <label id="mobil" class="btn btn-primary active">
                                <input type="radio" name="type" value='mobil' onchange="setKategori(this)" autocomplete="off" checked> Mobil
                            </label>
                            <label id="motor" class="btn btn-primary">
                                <input type="radio" name="type" value='motor' onchange="setKategori(this)" autocomplete="off" > Motor
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
                        <div class="btn-group btn-group-justified" data-toggle="buttons">
                          @foreach($income_categories as $key => $cat)
                            @if(in_array($cat,array('Carwash','Detailing','Bikewash','Beli Voucher')))
                            <label class="btn btn-primary {{$cat == 'Carwash' ? 'active' : ''}}" id="{{$cat}}2">
                                <input type="radio" name="income_category_id" value={{$key}} data-name="{{$cat}}" autocomplete="off" 
                                {{$cat == 'Carwash' ? 'checked' : ''}}
                                onchange="showProduct2(this); setPrice2(this);"> {{ $cat }}
                            </label>
                            @endif
                          @endforeach
                          
                        </div>
                    </div>

                    <div class="col-xs-3 form-group">
                        {!! Form::label('size', 'Size', ['class' => 'control-label']) !!}
                        <br>
                        <div class="btn-group" data-toggle="buttons">
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
                        {!! Form::text('entry_date', old('entry_date', Carbon\Carbon::now()->format('d-m-Y H:i')), ['class' => 'form-control datetime', 'placeholder' => '', 'id'=>'entry_date2']) !!}
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
                                onchange="setPayment2(this)"> 
                                {{ $payment }}
                            </label>
                          @endforeach
                          
                        </div>
                    </div>

                    <div class="col-xs-6 form-group">
                        {!! Form::label('amount', 'Harga*', ['class' => 'control-label']) !!}
                        {!! Form::number('amount', old('amount', $prices['carwash']), ['class' => 'form-control', 'placeholder' => '', 'id' => 'amount2', 'onchange' => 'updateTotal2()']) !!}
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
                        {!! Form::textarea('note', old('note'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '3', 'id'=>'note2']) !!}
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
                            <label class="btn btn-success">
                                <input type="checkbox" name="FnBcheckbox" id="FnBcheckbox2" value="FnB" data-name="fnb" autocomplete="off" onchange="showFnB2(this),updateTotal2()"> 
                                    F&B
                            </label>
                            <label class="btn btn-success">
                                <input type="checkbox" name="Waxcheckbox" id="Waxcheckbox2" value="Wax" data-name="fnb" autocomplete="off" onchange="showWax2(this),updateTotal2()"> 
                                    Wax
                            </label>
                          
                        </div>
                    </div>

                    <div class="col-xs-3 form-group fnb_field2" style="visibility: hidden;">
                        {!! Form::label('fnb_amount', 'Harga F&B', ['class' => 'control-label']) !!}
                        <p class="help-block"></p>
                        {!! Form::number('fnb_amount', old('fnb_amount'), ['class' => 'form-control', 'placeholder' => '', 'id' => 'fnb_amount2', 'onchange' => 'updateTotal2()']) !!}
                        
                        @if($errors->has('fnb_amount'))
                            <p class="help-block">
                                {{ $errors->first('fnb_amount') }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-3 form-group wax_field2" style="visibility: hidden;">
                        {!! Form::label('wax_amount', 'Harga Wax', ['class' => 'control-label']) !!}
                        <p class="help-block"></p>
                        {!! Form::number('wax_amount', old('wax_amount'), ['class' => 'form-control', 'placeholder' => '', 'id' => 'wax_amount2', 'onchange'=>'updateTotal2()']) !!}
                        
                        @if($errors->has('wax_amount'))
                            <p class="help-block">
                                {{ $errors->first('wax_amount') }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-3 form-group">
                        {!! Form::label('total_amount', 'Total', ['class' => 'control-label']) !!}
                        <p class="help-block"></p>
                        {!! Form::number('total_amount', old('total_amount', $prices['carwash']), ['class' => 'form-control disabled', 'placeholder' => '', 'id' => 'total_amount2','disabled']) !!}
                        
                        @if($errors->has('total_amount'))
                            <p class="help-block">
                                {{ $errors->first('total_amount') }}
                            </p>
                        @endif
                    </div>    


                </div>

            </div>
        </div>

        {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger btn-lg']) !!}
        {!! Form::close() !!}
    @stop

    <!-- Add New Vehicle Modal Form -->
    @extends('partials.modalform2', ['title' => 'Vehicle', 'formId' => 'formModal2'])
    @section('formSection2')
        {!! Form::open(['method' => 'POST', 'route' => ['vehicles.storeFull']]) !!}

        <div class="panel panel-default">
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('customer_id', 'Customer*', ['class' => 'control-label']) !!}<br>
                        
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
                            <label id="mobil3" class="btn btn-primary active">
                                <input type="radio" name="type" value='mobil' autocomplete="off" onchange="setKategori3(this)" checked> Mobil
                            </label>
                            <label id="motor3" class="btn btn-primary">
                                <input type="radio" name="type" value='motor' autocomplete="off" onchange="setKategori3(this)"> Motor
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
                        <div class="btn-group btn-group-justified" data-toggle="buttons">
                          @foreach($income_categories as $key => $cat)
                            @if(in_array($cat,array('Carwash','Detailing','Bikewash')))
                            <label class="btn btn-primary {{$cat == 'Carwash' ? 'active' : ''}}" id="{{$cat}}3">
                                <input type="radio" name="income_category_id" value={{$key}} data-name="{{$cat}}" autocomplete="off" 
                                {{$cat == 'Carwash' ? 'checked' : ''}}
                                onchange="showProduct3(this); setPrice3(this);"> {{ $cat }}
                            </label>
                            @endif
                          @endforeach
                          
                        </div>
                    </div>

                    <div class="col-xs-3 form-group">
                        {!! Form::label('size', 'Size', ['class' => 'control-label']) !!}
                        <br>
                        <div class="btn-group" data-toggle="buttons">
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
                        {!! Form::text('entry_date', old('entry_date', Carbon\Carbon::now()->format('d-m-Y H:i')), ['class' => 'form-control datetime', 'placeholder' => '', 'id'=>'entry_date3']) !!}
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
                        {!! Form::number('amount', old('amount', $prices['carwash']), ['class' => 'form-control', 'placeholder' => '', 'id' => 'amount3']) !!}
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
                    <div class="col-xs-3 form-group">
                        {!! Form::label('addon', 'Tambahan', ['class' => 'control-label']) !!}
                        <p class="help-block"></p>
                        
                        <div class="btn-group btn-group-justified" data-toggle="buttons">
                            <label class="btn btn-success">
                                <input type="checkbox" name="FnBcheckbox" id="FnBcheckbox3" value="FnB" data-name="fnb" autocomplete="off" onchange="showFnB3(this),updateTotal3()"> 
                                    F&B
                            </label>
                            <label class="btn btn-success">
                                <input type="checkbox" name="Waxcheckbox" id="Waxcheckbox3" value="Wax" data-name="fnb" autocomplete="off" onchange="showWax3(this),updateTotal3()"> 
                                    Wax
                            </label>
                          
                        </div>
                    </div>

                    <div class="col-xs-3 form-group fnb_field3" style="visibility: hidden;">
                        {!! Form::label('fnb_amount', 'Harga F&B', ['class' => 'control-label']) !!}
                        <p class="help-block"></p>
                        {!! Form::number('fnb_amount', old('fnb_amount'), ['class' => 'form-control', 'placeholder' => '', 'id' => 'fnb_amount3', 'onchange' => 'updateTotal3()']) !!}
                        
                        @if($errors->has('fnb_amount'))
                            <p class="help-block">
                                {{ $errors->first('fnb_amount') }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-3 form-group wax_field3" style="visibility: hidden;">
                        {!! Form::label('wax_amount', 'Harga Wax', ['class' => 'control-label']) !!}
                        <p class="help-block"></p>
                        {!! Form::number('wax_amount', old('wax_amount'), ['class' => 'form-control', 'placeholder' => '', 'id' => 'wax_amount3', 'onchange'=>'updateTotal3()']) !!}
                        
                        @if($errors->has('wax_amount'))
                            <p class="help-block">
                                {{ $errors->first('wax_amount') }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-3 form-group">
                        {!! Form::label('total_amount', 'Total', ['class' => 'control-label']) !!}
                        <p class="help-block"></p>
                        {!! Form::number('total_amount', old('total_amount', $prices['carwash']), ['class' => 'form-control disabled', 'placeholder' => '', 'id' => 'total_amount3','disabled']) !!}
                        
                        @if($errors->has('total_amount'))
                            <p class="help-block">
                                {{ $errors->first('total_amount') }}
                            </p>
                        @endif
                    </div>   
                </div>

            </div>
        </div>

        {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger btn-lg']) !!}
        {!! Form::close() !!}
        
    @stop

    @extends('partials.antrianForm', ['title' => 'Antrian', 'formId' => 'antrianForm'])
    @extends('partials.editAntrianForm', ['title' => 'Antrian', 'formId' => 'editAntrianForm'])


@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.0/locale/id.js"></script> 
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script>
       

        @if(Session::has('print-bon'))
             $('#printModal').modal('show');
             // window.alert('test');
             // window.print();
        @endif

        $(document).ready(function(){
            $('#antrianButton').click();
            $('.cari').select2({
                minimumInputLength: 3,
                width: 'resolve', 
                placeholder:'Cari...',
                ajax: {
                  url: "{!! route('loadVehiclesData') !!}",
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    var results = [];
                    $.each(data, function (index, vehicles) {
                        results.push({
                            id: vehicles.id,
                            text: vehicles.license_plate + " | " + vehicles.model.toUpperCase() + " " + vehicles.color.toUpperCase() + ": " + vehicles.customer.name + " (" + vehicles.type.toUpperCase() + ")"
                        });
                    });

                    return {
                        results: results
                    };
                  },
                }
            }).on('select2:open', () => {
                    $(".select2-results:not(:has(a))").append('<a data-toggle="modal" href="#formModal" style="padding: 6px;height: 20px;display: inline-table;">Tambahkan Kendaraan Baru</a>');
            });


            $('.modal').on('shown.bs.modal', function() {
              $('.cari').select2("close");
              $(this).find('[autofocus]').focus();
            });

            @if(Session::has('alert-success'))
                $('#printModal').modal('show');
            @endif


            // for antrian

            $('.vehicle_search').select2({
                minimumInputLength: 3,
                width: 'resolve', 
                placeholder:'Cari...',
                ajax: {
                  url: "{!! route('loadVehiclesData') !!}",
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    var results = [];
                    $.each(data, function (index, vehicles) {
                        results.push({
                            id: vehicles.id,
                            text: vehicles.license_plate + " | " + vehicles.brand.toUpperCase() + ", " +vehicles.model.toUpperCase() + ", " + vehicles.color.toUpperCase() + " | " + vehicles.customer.name + ", " + vehicles.customer.phone + ", " +vehicles.type.toUpperCase() 
                        });
                    });

                    return {
                        results: results
                    };
                  },
                }
            }).on('select2:open', () => {
                    $(".select2-results:not(:has(a))").append('<a href="#" style="padding: 6px;height: 20px;display: inline-table;" onclick="copyData()">Copy Plat No</a>');
            }).on('select2:select', function (e) {
                var data = e.params.data;
                var s_text = data['text'];
                var split_text = s_text.split('|');
                var license_plate = split_text[0];
                var brand = split_text[1].split(',')[0];
                var model = split_text[1].split(',')[1];
                var color = split_text[1].split(',')[2];
                var type = $.trim(split_text[2].split(',')[2]);
                var name = $.trim(split_text[2].split(',')[0]);
                var phone = $.trim(split_text[2].split(',')[1]);
                // alert(data['text']);
                $('#antrianForm #antrian_license_plate').val($.trim(license_plate));
                $('#antrianForm #antrian_brand').val($.trim(brand));
                $('#antrianForm #antrian_model').val($.trim(model));
                $('#antrianForm #antrian_color').val($.trim(color));
                $('#antrianForm #antrian_name').val(name);
                $('#antrianForm #antrian_phone').val(phone);

                if(type == 'MOTOR')
                    $('#antrianForm #antrian_motor').button('toggle');
                else
                    $('#antrianForm #antrian_mobil').button('toggle');

                $('#antrianForm #antrian_existing').button('toggle');

                //edit form populate
                $('#editAntrianForm #antrian_license_plate').val($.trim(license_plate));
                $('#editAntrianForm #antrian_brand').val($.trim(brand));
                $('#editAntrianForm #antrian_model').val($.trim(model));
                $('#editAntrianForm #antrian_color').val($.trim(color));
                $('#editAntrianForm #antrian_name').val(name);
                $('#editAntrianForm #antrian_phone').val(phone);

                if(type == 'MOTOR')
                    $('#editAntrianForm #antrian_motor').button('toggle');
                else
                    $('#editAntrianForm #antrian_mobil').button('toggle');

                $('#editAntrianForm #antrian_existing').button('toggle');
            });


        });

        var maxDate = new Date();
        maxDate.setMinutes(maxDate.getMinutes() + 60);

        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm",
            maxDate:maxDate,
            stepMinute: 1,
            showSecond: false,
            controlType: 'select',
            showMillisec:false,
            showMicrosec:false
        });

        function copyData(){
            var searchtext = $("#new_vehicle_search").data("select2").dropdown.$search.val()
            // alert(searchtext);
            $('#antrianForm #antrian_license_plate').val(searchtext);
            $('#new_vehicle_search').select2("close");
            $('#antrianForm #antrian_brand').val('');
            $('#antrianForm #antrian_model').val('');
            $('#antrianForm #antrian_color').val('');
            $('#antrianForm #antrian_name').val('');
            $('#antrianForm #antrian_phone').val('');
            $('#antrianForm #antrian_mobil').button('toggle');
            $('#antrianForm #antrian_new').button('toggle');
            $("#antrianForm #datepicker").datetimepicker("setDate", new Date());

            var searchtext2 = $("#vehicle_search").data("select2").dropdown.$search.val()
            // alert(searchtext);
            $('#editAntrianForm #antrian_license_plate').val(searchtext2);
            $('#vehicle_search').select2("close");
            $('#editAntrianForm #antrian_brand').val('');
            $('#editAntrianForm #antrian_model').val('');
            $('#editAntrianForm #antrian_color').val('');
            $('#editAntrianForm #antrian_name').val('');
            $('#editAntrianForm #antrian_phone').val('');
            $('#editAntrianForm #antrian_mobil').button('toggle');
            $('#editAntrianForm #antrian_new').button('toggle');
            $("#editAntrianForm #datepicker").datetimepicker("setDate", new Date());

        };

        function GetAntrianData(data){
            if(data['customer'] == 'Existing'){
                if(data['type'] == 'MOTOR')
                    $('#Bikewash').button('toggle');
                else
                    $('#Carwash').button('toggle');
                $('.cari').val(null).trigger('change');
                $('.cari').select2("open");
                $('.select2-search__field').val(data['license_plate']);
                $('.select2-search').find('input').trigger('input');
                $(".control-sidebar").removeClass('control-sidebar-open');
                $('.select2-search').find('input').trigger('input');
                $('#entry_date').datetimepicker('setDate', new Date());
                if(data['type'].toUpperCase() == 'MOTOR')
                    $('#Bikewash').button('toggle');
                else
                    $('#Carwash').button('toggle');

            }
            else
                InsertAntrianData(data);
        };

        function InsertAntrianData(data){
            // alert(data['license_plate']);
            $('#formModal').modal('show');
            $('#formModal #license_plate').val(data['license_plate']);
            $('#formModal #brand').val(data['brand']);
            $('#formModal #model').val(data['model']);
            $('#formModal #color').val(data['color']);
            $('#formModal #name').val(data['name']);
            $('#formModal #phone').val(data['phone']);
            if(data['type'].toUpperCase() == 'MOTOR')
                $('#formModal #motor').button('toggle');
            else
                $('#formModal #mobil').button('toggle');
        };

        $('#editAntrianForm').on('show.bs.modal', function (e) {
            var route = $(e.relatedTarget).data('route');
            var antrian = $(e.relatedTarget).data('antrian');

            // alert(route);

            $('#editAntrianForm #antriForm').attr('action', route);

            $('#editAntrianForm #antrian_license_plate').val(antrian['license_plate']);
            $('#editAntrianForm #antrian_brand').val(antrian['brand']);
            $('#editAntrianForm #antrian_model').val(antrian['model']);
            $('#editAntrianForm #antrian_color').val(antrian['color']);
            $('#editAntrianForm #antrian_name').val(antrian['name']);
            $('#editAntrianForm #antrian_phone').val(antrian['phone']);
            if(antrian['type'].toUpperCase() == 'MOTOR')
                $('#editAntrianForm #antrian_motor').button('toggle');
            else
                $('#editAntrianForm #antrian_mobil').button('toggle');

            if(antrian['customer'].toUpperCase() == 'NEW')
                $('#editAntrianForm #antrian_new').button('toggle');
            else
                $('#editAntrianForm #antrian_existing').button('toggle');

            if(antrian['status'].toUpperCase() == 'DITUNGGU')
                $('#editAntrianForm #antrian_tunggu').button('toggle');
            else
                $('#editAntrianForm #antrian_tinggal').button('toggle');
            var arrival_time = moment(antrian['arrival_time']).toDate();
            // alert(arrival_time);
            $("#editAntrianForm #datepicker").datetimepicker("setDate", arrival_time);
        });


        function setPayment(type){
            if (type.value==6){
                $('#amount').val('0');
                $('textarea#note').val('Voucher');
                updateTotal();    
            }
        };

        function setPayment2(type){
            if (type.value==6){
                $('#amount2').val('0');
                $('textarea#note2').val('Voucher');
                updateTotal2();    
            }
        };

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
            var total = fnb + wax + parseInt($('#amount').val());
            $('#total_amount').val(total);
        };

        function updateTotal2(){
            var fnb = 0;
            var wax = 0;
            // window.alert($('input[id="FnBcheckbox2"]').is(':checked'));
            if($('input[id="FnBcheckbox2"]').is(':checked')){
                fnb = parseInt($('#fnb_amount2').val());
            }

            if($('input[id="Waxcheckbox2"]').is(':checked')){
                wax = parseInt($('#wax_amount2').val());
            }
            var total = fnb + wax + parseInt($('#amount2').val());
            $('#total_amount2').val(total);
        };

        function updateTotal3(){
            var fnb = 0;
            var wax = 0;
            // window.alert($('input[id="FnBcheckbox2"]').is(':checked'));
            if($('input[id="FnBcheckbox3"]').is(':checked')){
                fnb = parseInt($('#fnb_amount3').val());
            }

            if($('input[id="Waxcheckbox3"]').is(':checked')){
                wax = parseInt($('#wax_amount3').val());
            }
            var total = fnb + wax + parseInt($('#amount3').val());
            $('#total_amount3').val(total);
        };

        function showFnB(addition){
            // window.alert(addition.checked);
            if(addition.checked){
                $('.fnb_field').css('visibility', 'visible');
                $('#fnb_amount').val({{$prices['fnb']}}); 
            }
            else{
                $('.fnb_field').css('visibility', 'hidden'); 
                $('#fnb_amount').val(0);
            }
        };

        function showFnB2(addition){
            // window.alert(addition.checked);
            if(addition.checked){
                $('.fnb_field2').css('visibility', 'visible');
                $('#fnb_amount2').val({{$prices['fnb']}}); 
            }
            else{
                $('.fnb_field2').css('visibility', 'hidden'); 
                $('#fnb_amount2').val(0);
            }
        };


        function showFnB3(addition){
            // window.alert(addition.checked);
            if(addition.checked){
                $('.fnb_field3').css('visibility', 'visible');
                $('#fnb_amount3').val({{$prices['fnb']}}); 
            }
            else{
                $('.fnb_field3').css('visibility', 'hidden'); 
                $('#fnb_amount3').val(0);
            }
        };

        

        function showWax(addition){
            // window.alert(addition.checked);
            if(addition.checked){
                $('.wax_field').css('visibility', 'visible'); 
                $('#wax_amount').val({{$prices['wax']}});
            }
            else{
                $('.wax_field').css('visibility', 'hidden'); 
                $('#wax_amount').val(0);
            }
        };

        function showWax2(addition){
            // window.alert(addition.checked);
            if(addition.checked){
                $('.wax_field2').css('visibility', 'visible'); 
                $('#wax_amount2').val({{$prices['wax']}});
            }
            else{
                $('.wax_field2').css('visibility', 'hidden'); 
                $('#wax_amount2').val(0);
            }
        };

        function showWax3(addition){
            // window.alert(addition.checked);
            if(addition.checked){
                $('.wax_field3').css('visibility', 'visible'); 
                $('#wax_amount3').val({{$prices['wax']}});
            }
            else{
                $('.wax_field3').css('visibility', 'hidden'); 
                $('#wax_amount3').val(0);
            }
        };

        function showProduct2(kategori){
            if(kategori.value == 4){
                $('.hidden_field2').css('visibility', 'visible');
            }
            else{
                $('.hidden_field2').css('visibility', 'hidden');   
            }
        };

        function showProduct3(kategori){
            if(kategori.value == 4){
                $('.hidden_field3').css('visibility', 'visible');
            }
            else{
                $('.hidden_field3').css('visibility', 'hidden');   
            }
        };

        function setPrice(kategori){
            switch(kategori.value) {
                case '1':
                    $('#amount').val({{$prices['carwash']}});
                    updateTotal();
                    break;
                case '2':
                    $('#amount').val({{$prices['wax']}});
                    updateTotal();
                    break;
                case '3':
                    $('#amount').val({{$prices['detailing']}});
                    updateTotal();
                    break;
                case '4':
                    $('#amount').val({{$prices['fnb']}});
                    break;
                case '5':
                    $('#amount').val({{$prices['bikewash']}});
                    updateTotal();
                    break;  
                default:
                    
                    break;
            };
        };

        function setPrice2(kategori){
            switch(kategori.value) {
                case '1':
                    $('#amount2').val({{$prices['carwash']}});
                    $("#mobil").button('toggle');
                    updateTotal2();                    
                    break;
                case '2':
                    $('#amount2').val({{$prices['wax']}});
                    break;
                case '3':
                    $('#amount2').val({{$prices['detailing']}});
                    updateTotal2();                    
                    break;
                case '4':
                    $('#amount2').val({{$prices['fnb']}});
                    break;
                case '5':
                    $('#amount2').val({{$prices['bikewash']}});
                    $("#motor").button('toggle');
                    updateTotal2();                    
                    break;
                default:
                    
                    break;
            };
        };

        function setKategori(type){
            switch(type.value) {
                case 'mobil':
                    $('#Carwash2').button('toggle');
                    break;
                case 'motor':
                    $('#Bikewash2').button('toggle');
                    break;
                default:
                    break;
            }

        };

        function setKategori3(type){
            switch(type.value) {
                case 'mobil':
                    $('#Carwash3').button('toggle');
                    break;
                case 'motor':
                    $('#Bikewash3').button('toggle');
                    break;
                default:
                    break;
            }
        };



        function setPrice3(kategori){
            switch(kategori.value) {
                case '1':
                    $('#amount3').val({{$prices['carwash']}});
                    $("#mobil3").button('toggle');
                    updateTotal3();
                    break;
                case '2':
                    $('#amount3').val({{$prices['wax']}});
                    break;
                case '3':
                    $('#amount3').val({{$prices['detailing']}});
                    updateTotal3();
                    break;
                case '4':
                    $('#amount3').val({{$prices['fnb']}});
                    break;
                case '5':
                    $('#amount3').val({{$prices['bikewash']}});
                    $("#motor3").button('toggle');
                    updateTotal3();
                    break;  
                default:
                    
                    break;
            };
        };
    </script>

@stop