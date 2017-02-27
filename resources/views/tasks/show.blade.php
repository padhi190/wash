@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.tasks.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.tasks.fields.branch')</th>
                            <td>{{ $task->branch->branch_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.tasks.fields.kendaraan')</th>
                            <td>{{ $task->kendaraan->license_plate or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.tasks.fields.description')</th>
                            <td>{!! $task->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.tasks.fields.status')</th>
                            <td>{{ $task->status->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.tasks.fields.tag')</th>
                            <td>
                                @foreach ($task->tag as $singleTag)
                                    <span class="label label-info label-many">{{ $singleTag->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.tasks.fields.due-date')</th>
                            <td>{{ $task->due_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.tasks.fields.approval-date')</th>
                            <td>{{ $task->approval_date }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('tasks.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop