@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.expense.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.expense.fields.branch')</th>
                            <td>{{ $expense->branch->branch_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.expense.fields.expense-category')</th>
                            <td>{{ $expense->expense_category->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.expense.fields.employee')</th>
                            <td>{{ $expense->employee->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.expense.fields.entry-date')</th>
                            <td>{{ $expense->entry_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.expense.fields.amount')</th>
                            <td>{{ $expense->amount }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.expense.fields.from')</th>
                            <td>{{ $expense->from->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.expense.fields.note')</th>
                            <td>{!! $expense->note !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('expenses.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop