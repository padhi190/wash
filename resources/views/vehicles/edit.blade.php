@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.vehicle.title')</h3>
    
    {!! Form::model($vehicle, ['method' => 'PUT', 'route' => ['vehicles.update', $vehicle->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('customer_id', 'Customer*', ['class' => 'control-label']) !!}
                    {!! Form::select('customer_id', $customers, old('customer_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('customer_id'))
                        <p class="help-block">
                            {{ $errors->first('customer_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('license_plate', 'Plat No.*', ['class' => 'control-label']) !!}
                    {!! Form::text('license_plate', old('license_plate'), ['class' => 'form-control', 'placeholder' => '', 'autofocus']) !!}
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
                    {!! Form::text('brand', old('brand'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('brand'))
                        <p class="help-block">
                            {{ $errors->first('brand') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-3 form-group">
                    {!! Form::label('model', 'Model', ['class' => 'control-label']) !!}
                    {!! Form::text('model', old('model'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('model'))
                        <p class="help-block">
                            {{ $errors->first('model') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-3 form-group">
                    {!! Form::label('color', 'Warna', ['class' => 'control-label']) !!}
                    {!! Form::text('color', old('color'), ['class' => 'form-control', 'placeholder' => '']) !!}
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
                        <label class="btn btn-primary {{$vehicle->type == 'mobil' ? 'active':''}}">
                            <input type="radio" name="type" value='mobil' autocomplete="off" {{$vehicle->type == 'mobil' ? 'checked':''}}> Mobil
                        </label>
                        <label class="btn btn-primary {{$vehicle->type == 'motor' ? 'active':''}}"" >
                            <input type="radio" name="type" value='motor' autocomplete="off" {{$vehicle->type == 'motor' ? 'checked':''}}> Motor
                        </label>
                    </div>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('size', 'Size', ['class' => 'control-label']) !!}
                    <br>
                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-primary {{$vehicle->size == 'small' ? 'active':''}}">
                            <input type="radio" name="size" value='small' autocomplete="off" {{$vehicle->size == 'small' ? 'checked':''}}> Small
                        </label>
                        <label class="btn btn-primary {{$vehicle->size == 'medium' ? 'active':''}}" >
                            <input type="radio" name="size" value='medium' autocomplete="off" {{$vehicle->size == 'medium' ? 'checked':''}}> Medium
                        </label>
                        <label class="btn btn-primary {{$vehicle->size == 'large' ? 'active':''}}">
                            <input type="radio" name="size" value='large' autocomplete="off" {{$vehicle->size == 'large' ? 'checked':''}}> Large
                        </label>
                    </div>
                    @if($errors->has('size'))
                        <p class="help-block">
                            {{ $errors->first('size') }}
                        </p>
                    @endif
                    
                </div>
                <div class="col-xs-9 form-group">
                    {!! Form::label('note', 'Note', ['class' => 'control-label']) !!}
                    {!! Form::textarea('note', old('note'), ['class' => 'form-control ', 'placeholder' => '', 'rows'=>'2']) !!}
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

    {!! Form::submit(trans('quickadmin.update'), ['class' => 'btn btn-danger btn-lg']) !!}
    {!! Form::close() !!}
@stop

