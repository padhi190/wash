@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.income.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.income.fields.branch')</th>
                            <td>{{ $income->branch->branch_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.vehicle')</th>
                            <td>{{ $income->vehicle->license_plate or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.entry-date')</th>
                            <td>{{ $income->entry_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.income-category')</th>
                            <td>{{ $income->income_category->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.product')</th>
                            <td>{{ $income->product->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.qty')</th>
                            <td>{{ $income->qty }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.amount')</th>
                            <td>{{ $income->amount }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.discount')</th>
                            <td>{{ $income->discount }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.payment-type')</th>
                            <td>{{ $income->payment_type->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.income.fields.note')</th>
                            <td>{!! $income->note !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('incomes.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop