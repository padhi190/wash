@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.customer.title') - Edit</h3>
    
    {!! Form::model($customer, ['method' => 'PUT', 'route' => ['customers.update', $customer->id]]) !!}

    <div class="panel panel-default">
        <!-- <div class="panel-heading">
            @lang('quickadmin.edit')
        </div> -->

        <div class="panel-body">
            <!-- <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('branch_id', 'Cabang', ['class' => 'control-label']) !!}
                    {!! Form::select('branch_id', $branches, old('branch_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('branch_id'))
                        <p class="help-block">
                            {{ $errors->first('branch_id') }}
                        </p>
                    @endif
                </div>
            </div> -->
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('name', 'Nama*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'autofocus']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('sex', 'Jenis Kelamin*', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('sex'))
                        <p class="help-block">
                            {{ $errors->first('sex') }}
                        </p>
                    @endif
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary {{$customer->sex == 'Laki-laki' ? 'active':''}}">
                            <input type="radio" name="sex" value='Laki-laki' autocomplete="off" {{$customer->sex == 'Laki-laki' ? 'checked':''}}> Laki-laki
                        </label>
                        <label class="btn btn-primary {{$customer->sex == 'Perempuan' ? 'active':''}}">
                            <input type="radio" name="sex" value='Perempuan' autocomplete="off" {{$customer->sex == 'Perempuan' ? 'checked':''}}> Perempuan
                        </label>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('phone', 'Phone', ['class' => 'control-label']) !!}
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone'))
                        <p class="help-block">
                            {{ $errors->first('phone') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                    {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <!-- <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('join_date', 'Tanggal', ['class' => 'control-label']) !!}
                    {!! Form::text('join_date', old('join_date', Carbon\Carbon::now()->format('d-m-Y')), ['class' => 'form-control date', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('join_date'))
                        <p class="help-block">
                            {{ $errors->first('join_date') }}
                        </p>
                    @endif
                </div>
            </div> -->
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('note', 'Note', ['class' => 'control-label']) !!}
                    {!! Form::textarea('note', old('note'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
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
    <script>
        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });
    </script>

@stop