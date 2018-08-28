@extends('layouts.app')

@section('content')
    <h3 class="page-title"><i class="fa fa-shopping-cart"></i> @lang('quickadmin.income.title')</h3>
    @can('income_create')
    <p>
        <a href="{{ route('incomes.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
        <a href="#" id="today" class="btn btn-info">Hari Ini</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table id="example" class="table table-bordered table-striped {{ count($incomes) > 0 ? 'datatable' : '' }} @can('income_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('income_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <!-- <th>@lang('quickadmin.income.fields.branch')</th> -->
                        <th>@lang('quickadmin.income.fields.nobon')</th>
                        <th>@lang('quickadmin.income.fields.vehicle')</th>
                        <th>@lang('quickadmin.income.fields.entry-date')</th>
                        <th>@lang('quickadmin.income.fields.income-category')</th>
                        <th>@lang('quickadmin.income.fields.amount')</th>
                        <!-- <th>@lang('quickadmin.income.fields.discount')</th> -->
                        <th>@lang('quickadmin.income.fields.payment-type')</th>
                        <th>@lang('quickadmin.income.fields.vehicle')</th>
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

                                <td>{{ $income->nobon }}</td>
                                <td>{{ $income->vehicle->full_vehicle or '' }}</td>
                                <td>{{ $income->entry_date }}</td>
                                <td>{{ $income->income_category->name . $income->additional_sales }}</td>
                                <td style="text-align: right">{{ number_format($income->total_amount,0) }}</td>
                                <td>{{ $income->payment_type->name or '' }}</td>
                                <td>{!! $income->vehicle->type !!}</td>
                                <td>
                                    @can('income_view')
                                    <a href="{{ route('incomes.show',[$income->id]) }}" class="btn btn-xs btn-primary">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                    @endcan
                                    @can('income_edit')
                                    <a href="{{ route('incomes.edit',[$income->id]) }}" class="btn btn-xs btn-info">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    @endcan
                                    @can('income_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['incomes.destroy', $income->id])) !!}
                                    {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', array('type'=>'submit' ,'class' => 'btn btn-xs btn-danger')) !!}
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
        // var table = $('#example').DataTable();
        $(document).ready(function(){
            $("#today").click(function(){
                $("input[type='search']").val(moment().format('DD-MM-YYYY')).keyup();
            });

            $('input[type=search]').focus();
        });

    </script>
@endsection