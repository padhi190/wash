@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.tasks.title')</h3>
    @can('task_create')
    <p>
        <a href="{{ route('tasks.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($tasks) > 0 ? 'datatable' : '' }} @can('task_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('task_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.tasks.fields.branch')</th>
                        <th>@lang('quickadmin.tasks.fields.kendaraan')</th>
                        <th>@lang('quickadmin.tasks.fields.description')</th>
                        <th>@lang('quickadmin.tasks.fields.status')</th>
                        <th>@lang('quickadmin.tasks.fields.tag')</th>
                        <th>@lang('quickadmin.tasks.fields.due-date')</th>
                        <th>@lang('quickadmin.tasks.fields.approval-date')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($tasks) > 0)
                        @foreach ($tasks as $task)
                            <tr data-entry-id="{{ $task->id }}">
                                @can('task_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $task->branch->branch_name or '' }}</td>
                                <td>{{ $task->kendaraan->license_plate or '' }}</td>
                                <td>{!! $task->description !!}</td>
                                <td>{{ $task->status->name or '' }}</td>
                                <td>
                                    @foreach ($task->tag as $singleTag)
                                        <span class="label label-info label-many">{{ $singleTag->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $task->due_date }}</td>
                                <td>{{ $task->approval_date }}</td>
                                <td>
                                    @can('task_view')
                                    <a href="{{ route('tasks.show',[$task->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('task_edit')
                                    <a href="{{ route('tasks.edit',[$task->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('task_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['tasks.destroy', $task->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('task_delete')
            window.route_mass_crud_entries_destroy = '{{ route('tasks.mass_destroy') }}';
        @endcan

    </script>
@endsection