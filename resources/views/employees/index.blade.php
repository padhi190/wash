@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.employees.title')</h3>
    @can('employee_create')
    <p>
        <a href="{{ route('employees.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($employees) > 0 ? 'datatable' : '' }} @can('employee_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('employee_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.employees.fields.name')</th>
                        <th>@lang('quickadmin.employees.fields.gender')</th>
                        <th>@lang('quickadmin.employees.fields.join-date')</th>
                        <th>@lang('quickadmin.employees.fields.posisi')</th>
                        <th>@lang('quickadmin.employees.fields.status')</th>
                        <th>@lang('quickadmin.employees.fields.branch')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($employees) > 0)
                        @foreach ($employees as $employee)
                            <tr data-entry-id="{{ $employee->id }}">
                                @can('employee_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->gender }}</td>
                                <td>{{ $employee->join_date }}</td>
                                <td>{{ $employee->posisi }}</td>
                                <td>{{ Form::checkbox("status", 1, $employee->status == 1, ["disabled"]) }}</td>
                                <td>{{ $employee->branch->branch_name or '' }}</td>
                                <td>
                                    @can('employee_view')
                                    <a href="{{ route('employees.show',[$employee->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('employee_edit')
                                    <a href="{{ route('employees.edit',[$employee->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('employee_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['employees.destroy', $employee->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('employee_delete')
            window.route_mass_crud_entries_destroy = '{{ route('employees.mass_destroy') }}';
        @endcan

    </script>
@endsection