@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.transfer.title')</h3>
    @can('transfer_create')
    <p>
        <a href="{{ route('transfers.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($transfers) > 0 ? 'datatable' : '' }} @can('transfer_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('transfer_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

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
                                @can('transfer_delete')
                                    <td></td>
                                @endcan

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
    </div>
@stop

@section('javascript') 
    <script>
        @can('transfer_delete')
            window.route_mass_crud_entries_destroy = '{{ route('transfers.mass_destroy') }}';
        @endcan

    </script>
@endsection