@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.branch.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.branch.fields.branch-name')</th>
                            <td>{{ $branch->branch_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.branch.fields.address')</th>
                            <td>{{ $branch->address }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.branch.fields.city')</th>
                            <td>{{ $branch->city }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.branch.fields.phone')</th>
                            <td>{{ $branch->phone }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#customer" aria-controls="customer" role="tab" data-toggle="tab">Customer</a></li>
<li role="presentation" class=""><a href="#absensi" aria-controls="absensi" role="tab" data-toggle="tab">Absensi</a></li>
<li role="presentation" class=""><a href="#income" aria-controls="income" role="tab" data-toggle="tab">Income</a></li>
<li role="presentation" class=""><a href="#expense" aria-controls="expense" role="tab" data-toggle="tab">Expense</a></li>
<li role="presentation" class=""><a href="#transfer" aria-controls="transfer" role="tab" data-toggle="tab">Transfer</a></li>
<li role="presentation" class=""><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">Tasks</a></li>
<li role="presentation" class=""><a href="#employees" aria-controls="employees" role="tab" data-toggle="tab">Employees</a></li>
<li role="presentation" class=""><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="customer">
<table class="table table-bordered table-striped {{ count($customers) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.customer.fields.branch')</th>
                        <th>@lang('quickadmin.customer.fields.name')</th>
                        <th>@lang('quickadmin.customer.fields.sex')</th>
                        <th>@lang('quickadmin.customer.fields.phone')</th>
                        <th>@lang('quickadmin.customer.fields.join-date')</th>
                        <th>@lang('quickadmin.customer.fields.note')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($customers) > 0)
            @foreach ($customers as $customer)
                <tr data-entry-id="{{ $customer->id }}">
                    <td>{{ $customer->branch->branch_name or '' }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->sex }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->join_date }}</td>
                                <td>{!! $customer->note !!}</td>
                                <td>
                                    @can('customer_view')
                                    <a href="{{ route('customers.show',[$customer->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('customer_edit')
                                    <a href="{{ route('customers.edit',[$customer->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('customer_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['customers.destroy', $customer->id])) !!}
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
<div role="tabpanel" class="tab-pane " id="absensi">
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
<div role="tabpanel" class="tab-pane " id="tasks">
<table class="table table-bordered table-striped {{ count($tasks) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
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
<div role="tabpanel" class="tab-pane " id="employees">
<table class="table table-bordered table-striped {{ count($employees) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
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
<div role="tabpanel" class="tab-pane " id="users">
<table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.users.fields.name')</th>
                        <th>@lang('quickadmin.users.fields.email')</th>
                        <th>@lang('quickadmin.users.fields.role')</th>
                        <th>@lang('quickadmin.users.fields.branch')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($users) > 0)
            @foreach ($users as $user)
                <tr data-entry-id="{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->title or '' }}</td>
                                <td>{{ $user->branch->branch_name or '' }}</td>
                                <td>
                                    @can('user_view')
                                    <a href="{{ route('users.show',[$user->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('user_edit')
                                    <a href="{{ route('users.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('user_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['users.destroy', $user->id])) !!}
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

            <p>&nbsp;</p>

            <a href="{{ route('branches.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop