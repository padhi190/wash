@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.vehicle.title')</h3>
    @can('vehicle_create')
    <p>
        <a href="{{ route('vehicles.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
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
                        <!-- <th>@lang('quickadmin.vehicle.fields.brand')</th> -->
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
                                @can('vehicle_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $vehicle->license_plate }}</td>
                                <td>{{ $vehicle->customer->name or '' }}</td>
                                <td>{{ $vehicle->type }}</td>
                                <!-- <td>{{ $vehicle->brand }}</td> -->
                                <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
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
                                    @can('income_create')
                                    <a href="{{ route('vehicles.createIncome',[$vehicle->id]) }}" class="btn btn-xs btn-success">
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

    </script>
@endsection