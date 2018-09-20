@extends('layouts.app')

@section('content')
    <h3 class="page-title"><i class="fa fa-users"></i> @lang('quickadmin.customer.title')</h3>
    @can('customer_create')
    <p>
        <a href="{{ route('customers.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped @can('customer_delete') dt-select @endcan" id="customer-table">
                <thead>
                    <tr>
                        <th>@lang('quickadmin.customer.fields.name')</th>
                        <th>@lang('quickadmin.customer.fields.phone')</th>
                        <th>@lang('quickadmin.customer.fields.email')</th>
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
            $('#customer-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                pageLength: '20',
                processing: true,
                serverSide: true,
                ajax: '{!! route('loadCustomersData') !!}',
                columns: [
                    { data: 'name' },
                    { data: 'phone' },
                    { data: 'email' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection