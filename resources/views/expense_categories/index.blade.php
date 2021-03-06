@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.expense-category.title')</h3>
    @can('expense_category_create')
    <p>
        <a href="{{ route('expense_categories.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($expense_categories) > 0 ? 'datatable' : '' }} @can('expense_category_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('expense_category_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.expense-category.fields.name')</th>
                        <th>Parent Category</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($expense_categories) > 0)
                        @foreach ($expense_categories as $expense_category)
                            <tr data-entry-id="{{ $expense_category->id }}">
                                @can('expense_category_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $expense_category->name }}</td>
                                <td>{{ $expense_category->parent_category }}</td>
                                <td>
                                    @can('expense_category_view')
                                    <a href="{{ route('expense_categories.show',[$expense_category->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('expense_category_edit')
                                    <a href="{{ route('expense_categories.edit',[$expense_category->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('expense_category_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['expense_categories.destroy', $expense_category->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('expense_category_delete')
            window.route_mass_crud_entries_destroy = '{{ route('expense_categories.mass_destroy') }}';
        @endcan

    </script>
@endsection