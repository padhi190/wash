@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.customer.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.customer.fields.branch')</th>
                            <td>{{ $customer->branch->branch_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.customer.fields.name')</th>
                            <td>{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.customer.fields.sex')</th>
                            <td>{{ $customer->sex }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.customer.fields.phone')</th>
                            <td>{{ $customer->phone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.customer.fields.email')</th>
                            <td>{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.customer.fields.join-date')</th>
                            <td>{{ $customer->join_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.customer.fields.note')</th>
                            <td>{!! $customer->note !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#vehicle" aria-controls="vehicle" role="tab" data-toggle="tab">Vehicle</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="vehicle">
<table class="table table-bordered table-striped {{ count($vehicles) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.vehicle.fields.license-plate')</th>
                        <th>@lang('quickadmin.vehicle.fields.customer')</th>
                        <th>@lang('quickadmin.vehicle.fields.type')</th>
                        <th>@lang('quickadmin.vehicle.fields.brand')</th>
                        <th>@lang('quickadmin.vehicle.fields.model')</th>
                        <th>@lang('quickadmin.vehicle.fields.color')</th>
                        <th>@lang('quickadmin.vehicle.fields.note')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($vehicles) > 0)
            @foreach ($vehicles as $vehicle)
                <tr data-entry-id="{{ $vehicle->id }}">
                    <td>{{ $vehicle->license_plate }}</td>
                                <td>{{ $vehicle->customer->name or '' }}</td>
                                <td>{{ $vehicle->type }}</td>
                                <td>{{ $vehicle->brand }}</td>
                                <td>{{ $vehicle->model }}</td>
                                <td>{{ $vehicle->color }}</td>
                                <td>{!! $vehicle->note !!}</td>
                                <td>
                                    @can('vehicle_view')
                                    <a href="{{ route('vehicles.show',[$vehicle->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('vehicle_edit')
                                    <a href="{{ route('vehicles.edit',[$vehicle->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('vehicle_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['vehicles.destroy', $vehicle->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12">@lang('quickadmin.no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('customers.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop