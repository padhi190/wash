@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.absensi.title')</h3>
    @can('absensi_create')
    <p>
        <a href="{{ route('absensis.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($absensis) > 0 ? 'datatable' : '' }} @can('absensi_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('absensi_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.absensi.fields.branch')</th>
                        <th>@lang('quickadmin.absensi.fields.tanggal')</th>
                        <th>@lang('quickadmin.absensi.fields.karyawan')</th>
                        <th>@lang('quickadmin.absensi.fields.note')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($absensis) > 0)
                        @foreach ($absensis as $absensi)
                            <tr data-entry-id="{{ $absensi->id }}">
                                @can('absensi_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $absensi->branch->branch_name or '' }}</td>
                                <td>{{ $absensi->tanggal }}</td>
                                <td>{{ $absensi->karyawan->name or '' }}</td>
                                <td>{!! $absensi->note !!}</td>
                                <td>
                                    @can('absensi_view')
                                    <a href="{{ route('absensis.show',[$absensi->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('absensi_edit')
                                    <a href="{{ route('absensis.edit',[$absensi->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('absensi_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['absensis.destroy', $absensi->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('absensi_delete')
            window.route_mass_crud_entries_destroy = '{{ route('absensis.mass_destroy') }}';
        @endcan

    </script>
@endsection