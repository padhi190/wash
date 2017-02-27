@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.transfer.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.transfer.fields.branch')</th>
                            <td>{{ $transfer->branch->branch_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.transfer.fields.tanggal')</th>
                            <td>{{ $transfer->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.transfer.fields.dari')</th>
                            <td>{{ $transfer->dari->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.transfer.fields.ke')</th>
                            <td>{{ $transfer->ke->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.transfer.fields.jumlah')</th>
                            <td>{{ $transfer->jumlah }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.transfer.fields.note')</th>
                            <td>{!! $transfer->note !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('transfers.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop