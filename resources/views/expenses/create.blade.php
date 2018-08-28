@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.expense.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['expenses.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    <!-- {!! Form::label('branch_id', 'Cabang*', ['class' => 'control-label']) !!}
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
                <div class="col-xs-4 form-group">
                    {!! Form::label('expense_category_id', 'Kategori*', ['class' => 'control-label']) !!}
                    {!! Form::select('expense_category_id', $expense_categories, old('expense_category_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('expense_category_id'))
                        <p class="help-block">
                            {{ $errors->first('expense_category_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-4 form-group">
                    {!! Form::label('employee_id', 'Karyawan', ['class' => 'control-label']) !!}
                    {!! Form::select('employee_id', $employees, old('employee_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('employee_id'))
                        <p class="help-block">
                            {{ $errors->first('employee_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-4 form-group">
                    {!! Form::label('entry_date', 'Tanggal*', ['class' => 'control-label']) !!}
                    {!! Form::text('entry_date', old('entry_date', Carbon\Carbon::now()->format('d-m-Y')), ['class' => 'form-control date', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('entry_date'))
                        <p class="help-block">
                            {{ $errors->first('entry_date') }}
                        </p>
                    @endif
                </div>

            </div>
            
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('amount', 'Jumlah*', ['class' => 'control-label']) !!}
                    {!! Form::text('amount', old('amount'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('amount'))
                        <p class="help-block">
                            {{ $errors->first('amount') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-4 form-group">
                    {!! Form::label('from_id', 'Dari*', ['class' => 'control-label']) !!}
                    {!! Form::select('from_id', $froms, old('from_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('from_id'))
                        <p class="help-block">
                            {{ $errors->first('from_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-4 form-group">
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

    {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script>
        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            maxDate:0,
        });
    </script>

@stop