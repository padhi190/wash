@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.expense.title')</h3>
    @can('expense_create')
    <p>
        <a href="{{ route('expenses.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($expenses) > 0 ? 'datatable' : '' }} @can('expense_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('expense_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

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
                                @can('expense_delete')
                                    <td></td>
                                @endcan

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
@stop

@section('javascript') 
    <script>
        @can('expense_delete')
            window.route_mass_crud_entries_destroy = '{{ route('expenses.mass_destroy') }}';
        @endcan

    </script>
@endsection