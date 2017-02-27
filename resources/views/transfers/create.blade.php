@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.transfer.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['transfers.store']]) !!}

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
                    {!! Form::text('tanggal', old('tanggal', Carbon\Carbon::now()->format('d-m-Y H:i:s')), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
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
                    {!! Form::label('dari_id', 'Dari*', ['class' => 'control-label']) !!}
                    {!! Form::select('dari_id', $daris, old('dari_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('dari_id'))
                        <p class="help-block">
                            {{ $errors->first('dari_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('ke_id', 'Ke*', ['class' => 'control-label']) !!}
                    {!! Form::select('ke_id', $kes, old('ke_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('ke_id'))
                        <p class="help-block">
                            {{ $errors->first('ke_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('jumlah', 'Jumlah*', ['class' => 'control-label']) !!}
                    {!! Form::text('jumlah', old('jumlah'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('jumlah'))
                        <p class="help-block">
                            {{ $errors->first('jumlah') }}
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