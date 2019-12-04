@extends('layouts.app')

@section('content')
    <h3 class="page-title">Create Survey</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['surveytemplate.store']]) !!}

    <div class="panel panel-default">
        <!-- <div class="panel-heading">
            @lang('quickadmin.create')
        </div> -->
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('template_name', 'Template Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('template_name', old('template_name'), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:capitalize', 'autofocus']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('template_name'))
                        <p class="help-block">
                            {{ $errors->first('template_name') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('no_of_questions', 'No of Questions*', ['class' => 'control-label']) !!}
                    {!! Form::text('no_of_questions', old('no_of_questions'), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:capitalize', 'autofocus']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('no_of_questions'))
                        <p class="help-block">
                            {{ $errors->first('no_of_questions') }}
                        </p>
                    @endif
                </div>
            </div>            
        
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q1', 'Question 1', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q1', old('q1'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q1'))
                        <p class="help-block">
                            {{ $errors->first('q1') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q2', 'Question 2', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q2', old('q2'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q2'))
                        <p class="help-block">
                            {{ $errors->first('q2') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q3', 'Question 3', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q3', old('q3'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q3'))
                        <p class="help-block">
                            {{ $errors->first('q3') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q4', 'Question 4', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q4', old('q4'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q4'))
                        <p class="help-block">
                            {{ $errors->first('q4') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q5', 'Question 5', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q5', old('q5'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q5'))
                        <p class="help-block">
                            {{ $errors->first('q5') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q6', 'Question 6', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q6', old('q6'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q6'))
                        <p class="help-block">
                            {{ $errors->first('q6') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q7', 'Question 7', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q7', old('q7'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q7'))
                        <p class="help-block">
                            {{ $errors->first('q7') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q8', 'Question 8', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q8', old('q8'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q8'))
                        <p class="help-block">
                            {{ $errors->first('q8') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q9', 'Question 9', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q9', old('q9'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q9'))
                        <p class="help-block">
                            {{ $errors->first('q9') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q10', 'Question 10', ['class' => 'control-label']) !!}
                    {!! Form::textarea('q10', old('q10'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('q10'))
                        <p class="help-block">
                            {{ $errors->first('q10') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('essay', 'Essay Question*', ['class' => 'control-label']) !!}
                    {!! Form::text('essay', old('essay'), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:capitalize', 'autofocus']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('essay'))
                        <p class="help-block">
                            {{ $errors->first('essay') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger btn-lg']) !!}
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