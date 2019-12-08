@extends('layouts.app')

@section('content')
    <h3 class="page-title">Survey Questions Templates</h3>
    @can('branch_create')
    <p>
        <a href="{{ route('surveytemplate.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($surveytemplates) > 0 ? 'datatable' : '' }} ">
                <thead>
                    <tr>

                        <th>Template Name</th>
                        <th>No of Questions</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                        <th>Q5</th>
                        <th>Q6</th>
                        <th>Q7</th>
                        <th>Q8</th>
                        <th>Q9</th>
                        <th>Q10</th>
                        <th>Essay</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($surveytemplates) > 0)
                        @foreach ($surveytemplates as $surveytemplate)
                            <tr data-entry-id="{{ $surveytemplate->id }}">

                                <td>{{ $surveytemplate->template_name }}</td>
                                <td>{{ $surveytemplate->no_of_questions }}</td>
                                <td>{{ $surveytemplate->q1 }}</td>
                                <td>{{ $surveytemplate->q2 }}</td>
                                <td>{{ $surveytemplate->q3 }}</td>
                                <td>{{ $surveytemplate->q4 }}</td>
                                <td>{{ $surveytemplate->q5 }}</td>
                                <td>{{ $surveytemplate->q6 }}</td>
                                <td>{{ $surveytemplate->q7 }}</td>
                                <td>{{ $surveytemplate->q8 }}</td>
                                <td>{{ $surveytemplate->q9 }}</td>
                                <td>{{ $surveytemplate->q10 }}</td>
                                <td>{{ $surveytemplate->essay }}</td>
                                <td>
                                    <a href="{{ route('surveytemplate.show',[$surveytemplate->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    <a href="{{ route('surveytemplate.edit',[$surveytemplate->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['surveytemplate.destroy', $surveytemplate->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
    
    </script>
@endsection