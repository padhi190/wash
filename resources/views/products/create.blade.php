@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.products.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['products.store'], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Product name*', ['class' => 'control-label']) !!}
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
                    {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('price', 'Price*', ['class' => 'control-label']) !!}
                    {!! Form::text('price', old('price'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('price'))
                        <p class="help-block">
                            {{ $errors->first('price') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('category', 'Category', ['class' => 'control-label']) !!}
                    {!! Form::select('category[]', $categories, old('category'), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('category'))
                        <p class="help-block">
                            {{ $errors->first('category') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('tag', 'Tag', ['class' => 'control-label']) !!}
                    {!! Form::select('tag[]', $tags, old('tag'), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tag'))
                        <p class="help-block">
                            {{ $errors->first('tag') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('photo1', 'Photo 1', ['class' => 'control-label']) !!}
                    {!! Form::file('photo1', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('photo1_max_size', 8) !!}
                    {!! Form::hidden('photo1_max_width', 6000) !!}
                    {!! Form::hidden('photo1_max_height', 6000) !!}
                    <p class="help-block"></p>
                    @if($errors->has('photo1'))
                        <p class="help-block">
                            {{ $errors->first('photo1') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('photo2', 'Photo 2', ['class' => 'control-label']) !!}
                    {!! Form::file('photo2', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('photo2_max_size', 8) !!}
                    {!! Form::hidden('photo2_max_width', 6000) !!}
                    {!! Form::hidden('photo2_max_height', 6000) !!}
                    <p class="help-block"></p>
                    @if($errors->has('photo2'))
                        <p class="help-block">
                            {{ $errors->first('photo2') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('photo3', 'Photo 3', ['class' => 'control-label']) !!}
                    {!! Form::file('photo3', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('photo3_max_size', 8) !!}
                    {!! Form::hidden('photo3_max_width', 6000) !!}
                    {!! Form::hidden('photo3_max_height', 6000) !!}
                    <p class="help-block"></p>
                    @if($errors->has('photo3'))
                        <p class="help-block">
                            {{ $errors->first('photo3') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

