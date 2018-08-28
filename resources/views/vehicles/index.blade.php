@extends('layouts.app')

@section('content')
    <h3 class="page-title"><i class="fa fa-car"></i> @lang('quickadmin.vehicle.title')</h3>
    @can('vehicle_create')
    <p>
        <!-- <a href="{{ route('vehicles.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a> -->
        <a href="{{ route('vehicles.create') }}" class="btn btn-success"><i class="fa fa-car"></i>  + Kendaraan</a>
        <a href="{{ route('customers.create') }}" class="btn btn-info"><i class="fa fa-user"></i>  + Customer</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($vehicles) > 0 ? 'datatable' : '' }} @can('vehicle_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('vehicle_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.vehicle.fields.license-plate')</th>
                        <th>@lang('quickadmin.vehicle.fields.customer')</th>
                        <th>@lang('quickadmin.vehicle.fields.type')</th>
                        <th>@lang('quickadmin.vehicle.fields.model')</th>
                        <th>@lang('quickadmin.vehicle.fields.color')</th>
                        <th>Sales</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($vehicles) > 0)
                        @foreach ($vehicles as $vehicle)
                            <tr data-entry-id="{{ $vehicle->id }}">
                                @can('vehicle_delete')
                                    <td></td>
                                @endcan

                                <td>{{ strtoupper($vehicle->license_plate) }}</td>
                                <td>{{ ucwords($vehicle->customer->name) }}</td>
                                <td>{{ $vehicle->type }}</td>
                                <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                                <td>{{ $vehicle->color }}</td>
                                <td>{{ count($vehicle->sales) . ' (' . number_format($vehicle->sales->sum('amount'),0) .')'}}</td>
                                <td>
                                    @can('vehicle_view')
                                    <a href="{{ route('vehicles.show',[$vehicle->id]) }}" class="btn btn-xs btn-primary">
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </a>
                                    @endcan
                                    @can('vehicle_edit')
                                    <a href="{{ route('vehicles.edit',[$vehicle->id]) }}" class="btn btn-xs btn-info">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </a>
                                    @endcan
                                    @can('vehicle_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['vehicles.destroy', $vehicle->id])) !!}
                                    {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', array('type'=>'submit' ,'class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                    @can('income_create')
                                    <a href="{{ route('vehicles.createIncome',[$vehicle->id]) }}" class="btn btn-sm btn-success">
                                     +Penjualan
                                    </a>
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
@stop

@section('javascript') 
    <script>
        @can('vehicle_delete')
            window.route_mass_crud_entries_destroy = '{{ route('vehicles.mass_destroy') }}';
        @endcan
        $( document ).ready(function() {
            $('input[type=search]').focus();
        });
    </script>
@endsection