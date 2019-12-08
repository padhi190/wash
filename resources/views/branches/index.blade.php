@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.branch.title')</h3>
    @can('branch_create')
    <p>
        <a href="{{ route('branches.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($branches) > 0 ? 'datatable' : '' }} @can('branch_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('branch_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.branch.fields.branch-name')</th>
                        <th>@lang('quickadmin.branch.fields.address')</th>
                        <th>@lang('quickadmin.branch.fields.city')</th>
                        <th>@lang('quickadmin.branch.fields.phone')</th>
                        <th>@lang('quickadmin.branch.fields.last_bon')</th>
                        <th>SMS url</th>
                        <th>SMS bon?</th>
                        <th>Survey Template</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($branches) > 0)
                        @foreach ($branches as $branch)
                            <tr data-entry-id="{{ $branch->id }}">
                                @can('branch_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $branch->branch_name }}</td>
                                <td>{{ $branch->address }}</td>
                                <td>{{ $branch->city }}</td>
                                <td>{{ $branch->phone }}</td>
                                <td>{{ $branch->last_bon }}</td>
                                <td>{{ $branch->sms_url }}</td>
                                <td>{{ $branch->sms_on }}</td>
                                <td>{{ $branch->survey_template['template_name'] }}</td>
                                <td>
                                    @can('branch_view')
                                    <a href="{{ route('branches.show',[$branch->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('branch_edit')
                                    <a href="{{ route('branches.edit',[$branch->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('branch_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['branches.destroy', $branch->id])) !!}
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
        @can('branch_delete')
            window.route_mass_crud_entries_destroy = '{{ route('branches.mass_destroy') }}';
        @endcan

    </script>
@endsection