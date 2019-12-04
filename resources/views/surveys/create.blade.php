@extends('layouts.auth')

@section('content')
    <h3 class="page-title">Survey Kepuasan Pelanggan</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['survey.store']]) !!}

    <div class="panel panel-default">
        {{ Form::hidden('branch_id', $bon->branch_id)}}
        {{ Form::hidden('income_id', $bon->id)}}
        {{ Form::hidden('template_id', $survey_template->id)}}
        
        <div class="panel-body">
            @for ($i = 1; $i <= $survey_template['no_of_questions']; $i++)
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q'.$i, $survey_template['q'.$i], ['class' => 'control-label']) !!}
                    {!! Form::text('q'.$i, old('q'.$i), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:capitalize', 'autofocus']) !!}                    
                </div>
            </div>
            @endfor

            
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('essay', $survey_template['essay'], ['class' => 'control-label']) !!}
                    {!! Form::textarea('essay', old('essay'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2', 'id' => 'note']) !!}
                    
                </div>
            </div>
           
            
            
        </div>
    </div>

    {!! Form::submit('Kirim', ['class' => 'btn btn-success btn-lg']) !!}
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