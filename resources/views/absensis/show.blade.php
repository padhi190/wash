@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.absensi.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.absensi.fields.branch')</th>
                            <td>{{ $absensi->branch->branch_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.absensi.fields.tanggal')</th>
                            <td>{{ $absensi->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.absensi.fields.karyawan')</th>
                            <td>{{ $absensi->karyawan->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.absensi.fields.note')</th>
                            <td>{!! $absensi->note !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('absensis.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop