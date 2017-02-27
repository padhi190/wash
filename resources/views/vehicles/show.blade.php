@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.vehicle.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.vehicle.fields.license-plate')</th>
                            <td>{{ $vehicle->license_plate }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.vehicle.fields.customer')</th>
                            <td>{{ $vehicle->customer->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.vehicle.fields.type')</th>
                            <td>{{ $vehicle->type }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.vehicle.fields.brand')</th>
                            <td>{{ $vehicle->brand }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.vehicle.fields.model')</th>
                            <td>{{ $vehicle->model }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.vehicle.fields.color')</th>
                            <td>{{ $vehicle->color }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.vehicle.fields.size')</th>
                            <td>{{ $vehicle->size }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.vehicle.fields.note')</th>
                            <td>{!! $vehicle->note !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#income" aria-controls="income" role="tab" data-toggle="tab">Income</a></li>
<li role="presentation" class=""><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">Tasks</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="income">
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
</div>

            <p>&nbsp;</p>

            <a href="{{ route('vehicles.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop