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
            <table id="vehicle-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th>Phone</th>
                        <th>@lang('quickadmin.vehicle.fields.type')</th>
                        <th>@lang('quickadmin.vehicle.fields.model')</th>
                        <th>@lang('quickadmin.vehicle.fields.color')</th>
                        <th>&nbsp;</th>
                        
                    </tr>
                </thead>
                
                <tbody>
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
            $(function() {
                $('#vehicle-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    pageLength: '10',
                    searchDelay: 450,
                    processing: true,
                    serverSide: true,
                    order: [[0, 'asc']],
                    ajax: '{!! route($ajaxurl) !!}',
                    columns: [
                        { data: 'customer.name', name:'customer.name' },
                        { data: 'type', name:'type' },
                        { data: 'customer.phone', name:'customer.phone' },
                        { data: 'license_plate', name:'license_plate', visible: false },
                        { data: 'model', name: 'model', visible: false },
                        { data: 'color', name: 'color', visible: false },
                        { data: 'actions', name: 'actions', searchable: false, sortable: false}
                    ]
                });
            });
        });
    </script>
@endsection