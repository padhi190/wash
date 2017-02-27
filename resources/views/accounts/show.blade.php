@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.account.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.account.fields.name')</th>
                            <td>{{ $account->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.account.fields.account-no')</th>
                            <td>{{ $account->account_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.account.fields.holder-name')</th>
                            <td>{{ $account->holder_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.account.fields.branch')</th>
                            <td>{{ $account->branch }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#transfer" aria-controls="transfer" role="tab" data-toggle="tab">Transfer</a></li>
<li role="presentation" class=""><a href="#transfer" aria-controls="transfer" role="tab" data-toggle="tab">Transfer</a></li>
<li role="presentation" class=""><a href="#expense" aria-controls="expense" role="tab" data-toggle="tab">Expense</a></li>
<li role="presentation" class=""><a href="#income" aria-controls="income" role="tab" data-toggle="tab">Income</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="transfer">
<table class="table table-bordered table-striped {{ count($transfers) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.transfer.fields.branch')</th>
                        <th>@lang('quickadmin.transfer.fields.tanggal')</th>
                        <th>@lang('quickadmin.transfer.fields.dari')</th>
                        <th>@lang('quickadmin.transfer.fields.ke')</th>
                        <th>@lang('quickadmin.transfer.fields.jumlah')</th>
                        <th>@lang('quickadmin.transfer.fields.note')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($transfers) > 0)
            @foreach ($transfers as $transfer)
                <tr data-entry-id="{{ $transfer->id }}">
                    <td>{{ $transfer->branch->branch_name or '' }}</td>
                                <td>{{ $transfer->tanggal }}</td>
                                <td>{{ $transfer->dari->name or '' }}</td>
                                <td>{{ $transfer->ke->name or '' }}</td>
                                <td>{{ $transfer->jumlah }}</td>
                                <td>{!! $transfer->note !!}</td>
                                <td>
                                    @can('transfer_view')
                                    <a href="{{ route('transfers.show',[$transfer->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('transfer_edit')
                                    <a href="{{ route('transfers.edit',[$transfer->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('transfer_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['transfers.destroy', $transfer->id])) !!}
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
<div role="tabpanel" class="tab-pane " id="transfer">
<table class="table table-bordered table-striped {{ count($transfers) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.transfer.fields.branch')</th>
                        <th>@lang('quickadmin.transfer.fields.tanggal')</th>
                        <th>@lang('quickadmin.transfer.fields.dari')</th>
                        <th>@lang('quickadmin.transfer.fields.ke')</th>
                        <th>@lang('quickadmin.transfer.fields.jumlah')</th>
                        <th>@lang('quickadmin.transfer.fields.note')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($transfers) > 0)
            @foreach ($transfers as $transfer)
                <tr data-entry-id="{{ $transfer->id }}">
                    <td>{{ $transfer->branch->branch_name or '' }}</td>
                                <td>{{ $transfer->tanggal }}</td>
                                <td>{{ $transfer->dari->name or '' }}</td>
                                <td>{{ $transfer->ke->name or '' }}</td>
                                <td>{{ $transfer->jumlah }}</td>
                                <td>{!! $transfer->note !!}</td>
                                <td>
                                    @can('transfer_view')
                                    <a href="{{ route('transfers.show',[$transfer->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('transfer_edit')
                                    <a href="{{ route('transfers.edit',[$transfer->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('transfer_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['transfers.destroy', $transfer->id])) !!}
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
<div role="tabpanel" class="tab-pane " id="income">
<table class="table table-bordered table-striped {{ count($incomes) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.income.fields.branch')</th>
                        <th>@lang('quickadmin.income.fields.vehicle')</th>
                        <th>@lang('quickadmin.income.fields.entry-date')</th>
                        <th>@lang('quickadmin.income.fields.income-category')</th>
                        <th>@lang('quickadmin.income.fields.qty')</th>
                        <th>@lang('quickadmin.income.fields.amount')</th>
                        <th>@lang('quickadmin.income.fields.discount')</th>
                        <th>@lang('quickadmin.income.fields.payment-type')</th>
                        <th>@lang('quickadmin.income.fields.note')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($incomes) > 0)
            @foreach ($incomes as $income)
                <tr data-entry-id="{{ $income->id }}">
                    <td>{{ $income->branch->branch_name or '' }}</td>
                                <td>{{ $income->vehicle->license_plate or '' }}</td>
                                <td>{{ $income->entry_date }}</td>
                                <td>{{ $income->income_category->name or '' }}</td>
                                <td>{{ $income->qty }}</td>
                                <td>{{ $income->amount }}</td>
                                <td>{{ $income->discount }}</td>
                                <td>{{ $income->payment_type->name or '' }}</td>
                                <td>{!! $income->note !!}</td>
                                <td>
                                    @can('income_view')
                                    <a href="{{ route('incomes.show',[$income->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('income_edit')
                                    <a href="{{ route('incomes.edit',[$income->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('income_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['incomes.destroy', $income->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="14">@lang('quickadmin.no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('accounts.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop