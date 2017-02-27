@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.categories.title')</h3>
    @can('category_create')
    <p>
        <a href="{{ route('categories.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($categories) > 0 ? 'datatable' : '' }} @can('category_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('category_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.categories.fields.name')</th>
                        <th>@lang('quickadmin.categories.fields.description')</th>
                        <th>@lang('quickadmin.categories.fields.photo')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($categories) > 0)
                        @foreach ($categories as $category)
                            <tr data-entry-id="{{ $category->id }}">
                                @can('category_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $category->name }}</td>
                                <td>{!! $category->description !!}</td>
                                <td>@if($category->photo)<a href="{{ asset('uploads/' . $category->photo) }}" target="_blank"><img src="{{ asset('uploads/thumb/' . $category->photo) }}"/></a>@endif</td>
                                <td>
                                    @can('category_view')
                                    <a href="{{ route('categories.show',[$category->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('category_edit')
                                    <a href="{{ route('categories.edit',[$category->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('category_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['categories.destroy', $category->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('category_delete')
            window.route_mass_crud_entries_destroy = '{{ route('categories.mass_destroy') }}';
        @endcan

    </script>
@endsection