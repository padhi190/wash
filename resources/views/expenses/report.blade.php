@extends('partials.print')
    @section('printSection')
    <div style="text-align:center; font-size:18px;">
        <p id="rcpt">No Bon:</p>
        <p id="date"></p>
        <p id="parent_category"></p>
        <p id="kategori"></p>
        <p id="note"></p>
        
        <p id="total"></p> 

        <p id="signature"></p>
    </div>
    @endsection

@extends('layouts.app')

@section('content')
    <h3 class="page-title"><i class="fa fa-calculator"></i> @lang('quickadmin.expense.title') - {{$title}}</h3>
    @can('expense_create')
    <p>
        <a href="{{ route('expenses.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped" id="expense-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>@lang('quickadmin.expense.fields.entry-date')</th>
                        <th>Tipe</th>
                        <th>@lang('quickadmin.expense.fields.expense-category')</th>
                        <th>Ttd</th>
                        <th>@lang('quickadmin.expense.fields.note')</th>
                        <th>@lang('quickadmin.expense.fields.amount')</th>
                        <th>Sumber</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('expense_delete')
            window.route_mass_crud_entries_destroy = '{{ route('expenses.mass_destroy') }}';
        @endcan

         $( document ).ready(function() {
            $('#expense-table').DataTable({
                    dom: 'Blfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                    pageLength: '10',
                    searchDelay: 450,
                    processing: true,
                    serverSide: true,
                    order: [[1, 'desc']],
                    ajax: '{!! route($ajaxurl) !!}',
                    columns: [
                        { data: 'id' },
                        { data: 'entry_date' },
                        { data: 'expense_category.parent_category'},
                        { data: 'expense_category.name'},
                        { data: 'signature'},
                        { data: 'note', name: 'note' },
                        { data: 'amount', name:'amount' },
                        { data: 'from.name'},
                    ]
                });
        });

    </script>
@endsection