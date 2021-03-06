@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.expense-category.title')</h3>
    
    {!! Form::model($expense_category, ['method' => 'PUT', 'route' => ['expense_categories.update', $expense_category->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('parent_category', 'Parent Category', ['class' => 'control-label']) !!}
                    {!! Form::text('parent_category', old('parent_category'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('parent_category'))
                        <p class="help-block">
                            {{ $errors->first('parent_category') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

