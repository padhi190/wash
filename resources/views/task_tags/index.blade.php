@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.task-tags.title')</h3>
    @can('task_tag_create')
    <p>
        <a href="{{ route('task_tags.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($task_tags) > 0 ? 'datatable' : '' }} @can('task_tag_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('task_tag_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.task-tags.fields.name')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($task_tags) > 0)
                        @foreach ($task_tags as $task_tag)
                            <tr data-entry-id="{{ $task_tag->id }}">
                                @can('task_tag_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $task_tag->name }}</td>
                                <td>
                                    @can('task_tag_view')
                                    <a href="{{ route('task_tags.show',[$task_tag->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('task_tag_edit')
                                    <a href="{{ route('task_tags.edit',[$task_tag->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('task_tag_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['task_tags.destroy', $task_tag->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('task_tag_delete')
            window.route_mass_crud_entries_destroy = '{{ route('task_tags.mass_destroy') }}';
        @endcan

    </script>
@endsection