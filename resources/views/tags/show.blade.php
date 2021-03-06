@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.tags.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.tags.fields.name')</th>
                            <td>{{ $tag->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#products" aria-controls="products" role="tab" data-toggle="tab">Products</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="products">
<table class="table table-bordered table-striped {{ count($products) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.products.fields.name')</th>
                        <th>@lang('quickadmin.products.fields.description')</th>
                        <th>@lang('quickadmin.products.fields.price')</th>
                        <th>@lang('quickadmin.products.fields.category')</th>
                        <th>@lang('quickadmin.products.fields.tag')</th>
                        <th>@lang('quickadmin.products.fields.photo1')</th>
                        <th>@lang('quickadmin.products.fields.photo2')</th>
                        <th>@lang('quickadmin.products.fields.photo3')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($products) > 0)
            @foreach ($products as $product)
                <tr data-entry-id="{{ $product->id }}">
                    <td>{{ $product->name }}</td>
                                <td>{!! $product->description !!}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    @foreach ($product->category as $singleCategory)
                                        <span class="label label-info label-many">{{ $singleCategory->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($product->tag as $singleTag)
                                        <span class="label label-info label-many">{{ $singleTag->name }}</span>
                                    @endforeach
                                </td>
                                <td>@if($product->photo1)<a href="{{ asset('uploads/' . $product->photo1) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $product->photo1) }}"/></a>@endif</td>
                                <td>@if($product->photo2)<a href="{{ asset('uploads/' . $product->photo2) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $product->photo2) }}"/></a>@endif</td>
                                <td>@if($product->photo3)<a href="{{ asset('uploads/' . $product->photo3) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $product->photo3) }}"/></a>@endif</td>
                                <td>
                                    @can('product_view')
                                    <a href="{{ route('products.show',[$product->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('product_edit')
                                    <a href="{{ route('products.edit',[$product->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('product_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['products.destroy', $product->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12">@lang('quickadmin.no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('tags.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop