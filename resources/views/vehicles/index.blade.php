@extends('layouts.app')

@section('content')
    <h3 class="page-title"><i class="fa fa-car"></i> @lang('quickadmin.vehicle.title') {{$title}}</h3> 
    @can('vehicle_create')
    <p>
        <!-- <a href="{{ route('vehicles.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a> -->
        @if($title != '- Trashed')
            <a href="{{ route('vehicles.create') }}" class="btn btn-success"><i class="fa fa-car"></i>  + Kendaraan</a>
            <a href="{{ route('customers.create') }}" class="btn btn-info"><i class="fa fa-user"></i>  + Customer</a>
        @endif
        @if($title == '- Trashed')
            {!! Form::open(array(
                'style' => 'display: inline-block;',
                'method' => 'POST',
                'onsubmit' => "return confirm('Permanently delete ALL trashed?');",
                'route' => ['vehicles.permanentdestroyall'])) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', array('type'=>'submit' ,'class' => 'btn btn-danger')) !!}
            {!! Form::close() !!}
        @endif
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table id="vehicle-table" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th>Phone</th>
                        <th>Sales</th>
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
                var dtable = $('#vehicle-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    responsive: true,
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
                        { data: 'sales', name:'sales' , searchable: false, sortable: false},
                        { data: 'license_plate', name:'license_plate', visible: false },
                        { data: 'model', name: 'model', visible: false },
                        { data: 'color', name: 'color', visible: false },
                        { data: 'actions', name: 'actions', searchable: false, sortable: false}
                    ]
                });
                
                new $.fn.dataTable.FixedHeader( dtable );
            });
        });
    </script>
@endsection