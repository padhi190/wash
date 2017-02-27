@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.products.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.products.fields.name')</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.description')</th>
                            <td>{!! $product->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.price')</th>
                            <td>{{ $product->price }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.category')</th>
                            <td>
                                @foreach ($product->category as $singleCategory)
                                    <span class="label label-info label-many">{{ $singleCategory->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.tag')</th>
                            <td>
                                @foreach ($product->tag as $singleTag)
                                    <span class="label label-info label-many">{{ $singleTag->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.photo1')</th>
                            <td>@if($product->photo1)<a href="{{ asset('uploads/' . $product->photo1) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $product->photo1) }}"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.photo2')</th>
                            <td>@if($product->photo2)<a href="{{ asset('uploads/' . $product->photo2) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $product->photo2) }}"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.photo3')</th>
                            <td>@if($product->photo3)<a href="{{ asset('uploads/' . $product->photo3) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $product->photo3) }}"/></a>@endif</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#income" aria-controls="income" role="tab" data-toggle="tab">Income</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="income">
<table class="table table-bordered table-striped {{ count($incomes) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
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

            <p>&nbsp;</p>

            <a href="{{ route('products.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop