@extends('layouts.app')

@section('content')
    <h3 class="page-title"><i class="fa fa-users"></i> @lang('quickadmin.customer.title') - {{$title}}</h3>
    @can('customer_create')
    <p>
        @if($title !='Trashed')
        <a href="{{ route('customers.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
        @endif
        @if($title == 'Trashed')
            {!! Form::open(array(
                'style' => 'display: inline-block;',
                'method' => 'POST',
                'onsubmit' => "return confirm('Permanently delete ALL trashed?');",
                'route' => ['customers.permanentdestroyall'])) !!}
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
            <table class="table table-bordered table-striped @can('customer_delete') dt-select @endcan" id="customer-table" style="width:100%">
                <thead>
                    <tr>
                        <th>@lang('quickadmin.customer.fields.name')</th>
                        <th>@lang('quickadmin.customer.fields.phone')</th>
                        <th>@lang('quickadmin.customer.fields.email')</th>
                        <th>Vehicles</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('customer_delete')
            window.route_mass_crud_entries_destroy = '{{ route('customers.mass_destroy') }}';
        @endcan

        $( document ).ready(function() {
            $('input[type=search]').focus();
        });

        $(function() {
            var dtable = $('#customer-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                responsive: true, 
                pageLength: '20',
                processing: true,
                serverSide: true,
                ajax: '{!! route($ajaxurl) !!}',
                columns: [
                    { data: 'name' },
                    { data: 'phone' },
                    { data: 'email' },
                    { data: 'vehicles', name: 'vehicles', orderable: false, searchable: false},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });

            new $.fn.dataTable.FixedHeader( dtable );
        });
    </script>
@endsection