@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.customer.title')</h3>
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
            <table class="table table-bordered table-striped {{ count($customers) > 0 ? 'datatable' : '' }} @can('customer_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('customer_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

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
                                @can('customer_delete')
                                    <td></td>
                                @endcan

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
    </div>
@stop

@section('javascript') 
    <script>
        @can('customer_delete')
            window.route_mass_crud_entries_destroy = '{{ route('customers.mass_destroy') }}';
        @endcan

    </script>
@endsection