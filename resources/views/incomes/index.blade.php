@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>
    @can('income_create')
    <p>
        <a href="{{ route('incomes.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($incomes) > 0 ? 'datatable' : '' }} @can('income_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('income_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.income.fields.branch')</th>
                        <th>@lang('quickadmin.income.fields.vehicle')</th>
                        <th>@lang('quickadmin.income.fields.entry-date')</th>
                        <th>@lang('quickadmin.income.fields.income-category')</th>
                        <th>@lang('quickadmin.income.fields.qty')</th>
                        <th>@lang('quickadmin.income.fields.amount')</th>
                        <th>@lang('quickadmin.income.fields.discount')</th>
                        <th>@lang('quickadmin.income.fields.payment-type')</th>
                        <th>@lang('quickadmin.income.fields.note')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($incomes) > 0)
                        @foreach ($incomes as $income)
                            <tr data-entry-id="{{ $income->id }}">
                                @can('income_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $income->branch->branch_name or '' }}</td>
                                <td>{{ $income->vehicle->license_plate or '' }}</td>
                                <td>{{ $income->entry_date }}</td>
                                <td>{{ $income->income_category->name or '' }}</td>
                                <td>{{ $income->qty }}</td>
                                <td>{{ $income->amount }}</td>
                                <td>{{ $income->discount }}</td>
                                <td>{{ $income->payment_type->name or '' }}</td>
                                <td>{!! $income->note !!}</td>
                                <td>
                                    @can('income_view')
                                    <a href="{{ route('incomes.show',[$income->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('income_edit')
                                    <a href="{{ route('incomes.edit',[$income->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('income_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['incomes.destroy', $income->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="14">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('income_delete')
            window.route_mass_crud_entries_destroy = '{{ route('incomes.mass_destroy') }}';
        @endcan

    </script>
@endsection