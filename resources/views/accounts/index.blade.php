@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.account.title')</h3>
    @can('account_create')
    <p>
        <a href="{{ route('accounts.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($accounts) > 0 ? 'datatable' : '' }} @can('account_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('account_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.account.fields.name')</th>
                        <th>@lang('quickadmin.account.fields.account-no')</th>
                        <th>@lang('quickadmin.account.fields.holder-name')</th>
                        <th>@lang('quickadmin.account.fields.branch')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($accounts) > 0)
                        @foreach ($accounts as $account)
                            <tr data-entry-id="{{ $account->id }}">
                                @can('account_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $account->name }}</td>
                                <td>{{ $account->account_no }}</td>
                                <td>{{ $account->holder_name }}</td>
                                <td>{{ $account->branch }}</td>
                                <td>
                                    @can('account_view')
                                    <a href="{{ route('accounts.show',[$account->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('account_edit')
                                    <a href="{{ route('accounts.edit',[$account->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('account_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['accounts.destroy', $account->id])) !!}
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
        @can('account_delete')
            window.route_mass_crud_entries_destroy = '{{ route('accounts.mass_destroy') }}';
        @endcan

    </script>
@endsection