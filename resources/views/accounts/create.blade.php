@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.account.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['accounts.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Nama', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('account_no', 'No. rek', ['class' => 'control-label']) !!}
                    {!! Form::text('account_no', old('account_no'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('account_no'))
                        <p class="help-block">
                            {{ $errors->first('account_no') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('holder_name', 'Atas Nama', ['class' => 'control-label']) !!}
                    {!! Form::text('holder_name', old('holder_name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('holder_name'))
                        <p class="help-block">
                            {{ $errors->first('holder_name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('branch', 'Cabang Account', ['class' => 'control-label']) !!}
                    {!! Form::text('branch', old('branch'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('branch'))
                        <p class="help-block">
                            {{ $errors->first('branch') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

