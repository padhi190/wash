@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.absensi.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['absensis.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.create')
        </div>
        
        <div class="panel-body">
            {{ Form::hidden('branch_id', Session::get('branch_id'))}}
            <!-- <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('branch_id', 'Cabang*', ['class' => 'control-label']) !!}
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
                <div class="col-xs-12 form-group">
                    {!! Form::label('tanggal', 'Tanggal*', ['class' => 'control-label']) !!}
                    {!! Form::text('tanggal', old('tanggal', Carbon\Carbon::now()->format('d-m-Y')), ['class' => 'form-control date', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tanggal'))
                        <p class="help-block">
                            {{ $errors->first('tanggal') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('karyawan', 'Karyawan*', ['class' => 'control-label']) !!}
                    {!! Form::select('karyawan[]', $karyawans, old('karyawan'), ['class' => 'form-control select2' , 'multiple' => 'multiple']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('karyawan_id'))
                        <p class="help-block">
                            {{ $errors->first('karyawan_id') }}
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

    {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger']) !!}
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