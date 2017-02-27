@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.employees.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.employees.fields.name')</th>
                            <td>{{ $employee->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.employees.fields.gender')</th>
                            <td>{{ $employee->gender }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.employees.fields.join-date')</th>
                            <td>{{ $employee->join_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.employees.fields.posisi')</th>
                            <td>{{ $employee->posisi }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.employees.fields.status')</th>
                            <td>{{ Form::checkbox("status", 1, $employee->status == 1, ["disabled"]) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.employees.fields.branch')</th>
                            <td>{{ $employee->branch->branch_name or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#absensi" aria-controls="absensi" role="tab" data-toggle="tab">Absensi</a></li>
<li role="presentation" class=""><a href="#expense" aria-controls="expense" role="tab" data-toggle="tab">Expense</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="absensi">
<table class="table table-bordered table-striped {{ count($absensis) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.absensi.fields.branch')</th>
                        <th>@lang('quickadmin.absensi.fields.tanggal')</th>
                        <th>@lang('quickadmin.absensi.fields.karyawan')</th>
                        <th>@lang('quickadmin.absensi.fields.note')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($absensis) > 0)
            @foreach ($absensis as $absensi)
                <tr data-entry-id="{{ $absensi->id }}">
                    <td>{{ $absensi->branch->branch_name or '' }}</td>
                                <td>{{ $absensi->tanggal }}</td>
                                <td>{{ $absensi->karyawan->name or '' }}</td>
                                <td>{!! $absensi->note !!}</td>
                                <td>
                                    @can('absensi_view')
                                    <a href="{{ route('absensis.show',[$absensi->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('absensi_edit')
                                    <a href="{{ route('absensis.edit',[$absensi->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('absensi_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['absensis.destroy', $absensi->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
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
<div role="tabpanel" class="tab-pane " id="expense">
<table class="table table-bordered table-striped {{ count($expenses) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.expense.fields.branch')</th>
                        <th>@lang('quickadmin.expense.fields.expense-category')</th>
                        <th>@lang('quickadmin.expense.fields.employee')</th>
                        <th>@lang('quickadmin.expense.fields.entry-date')</th>
                        <th>@lang('quickadmin.expense.fields.amount')</th>
                        <th>@lang('quickadmin.expense.fields.from')</th>
                        <th>@lang('quickadmin.expense.fields.note')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($expenses) > 0)
            @foreach ($expenses as $expense)
                <tr data-entry-id="{{ $expense->id }}">
                    <td>{{ $expense->branch->branch_name or '' }}</td>
                                <td>{{ $expense->expense_category->name or '' }}</td>
                                <td>{{ $expense->employee->name or '' }}</td>
                                <td>{{ $expense->entry_date }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td>{{ $expense->from->name or '' }}</td>
                                <td>{!! $expense->note !!}</td>
                                <td>
                                    @can('expense_view')
                                    <a href="{{ route('expenses.show',[$expense->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('expense_edit')
                                    <a href="{{ route('expenses.edit',[$expense->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('expense_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['expenses.destroy', $expense->id])) !!}
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

            <p>&nbsp;</p>

            <a href="{{ route('employees.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop