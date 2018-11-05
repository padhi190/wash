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
    <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                  @if(Session::has('alert-' . $msg))

                  <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                  @endif
                @endforeach
    </div> 
    <p>
        @if($title != 'Trashed')
        <a href="{{ route('expenses.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
        <a href="#" id="today" class="btn btn-info">Hari Ini</a>
        @if($title !='Full')
        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
        @endif
        @endif

        @if($title == 'Trashed')
            {!! Form::open(array(
                'style' => 'display: inline-block;',
                'method' => 'POST',
                'onsubmit' => "return confirm('Permanently delete ALL trashed?');",
                'route' => ['expenses.permanentdestroyall'])) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', array('type'=>'submit' ,'class' => 'btn btn-danger')) !!}
            {!! Form::close() !!}
        @endif
    </p>
    @endcan

     <p>
        {{ Form::hidden('startdate', old('startdate', Carbon\Carbon::today()->subDays(14)->format('d-m-Y')), ['id' => 'startdate']) }}
        {{ Form::hidden('enddate', old('enddate', Carbon\Carbon::today()->format('d-m-Y')), ['id' => 'enddate']) }}
    </p>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped" id="expense-table" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>@lang('quickadmin.expense.fields.entry-date')</th>
                        <th>Parent Category</th>
                        <th>@lang('quickadmin.expense.fields.expense-category')</th>
                        <th>Ttd</th>
                        <th>@lang('quickadmin.expense.fields.note')</th>
                        <th>@lang('quickadmin.expense.fields.amount')</th>
                        <th>Sumber</th>
                        <th>Amount</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />  
    <script>
        @can('expense_delete')
            window.route_mass_crud_entries_destroy = '{{ route('expenses.mass_destroy') }}';
        @endcan

         $( document ).ready(function() {
            $("#today").click(function(){
                $("input[type='search']").val(moment().format('YYYY-MM-DD')).keyup();
            });
            
            var dtable = $('#expense-table').DataTable({
                    dom: 'Blfrtip',
                    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    responsive: true,
                    pageLength: '10',
                    searchDelay: 450,
                    processing: true,
                    serverSide: true,
                    order: [[1, 'desc']],
                    ajax: {
                        url: '{!! route($ajaxurl) !!}',
                        data: function(d) {
                            d.startdate = $('input[name=startdate]').val();
                            d.enddate = $('input[name=enddate]').val();
                        }
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'entry_date' },
                        { data: 'expense_category.parent_category'},
                        { data: 'expense_category.name'},
                        { data: 'signature'},
                        { data: 'note', name: 'note' },
                        { data: 'amount_rp' , searchable:false},
                        { data: 'from.name'},
                        { data: 'amount', visible: false},
                        { data: 'actions', name: 'actions', searchable: false, sortable: false}
                    ]
                });

            new $.fn.dataTable.FixedHeader( dtable );

            var start = moment().subtract(14, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                $('input[name=startdate]').val(start.format('D-M-YYYY'));
                $('input[name=enddate]').val(end.format('D-M-YYYY'));
                dtable.draw();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                   'Hari ini': [moment(), moment()],
                   'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   '7 Hari terakhir': [moment().subtract(6, 'days'), moment()],
                   '14 Hari terakhir': [moment().subtract(14, 'days'), moment()],
                   'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                   'Bulan kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);



            @if(Session::has('print-bon'))
            $(".modal-body #rcpt").html( "No Bon: {{ Session::get('print-bon')[0] }}" );
            $(".modal-body #date").html( "{{ Session::get('print-bon')[1] }}" );
            $(".modal-body #kategori").html( "{{ Session::get('print-bon')[2] }}" );
            $(".modal-body #total").html( "<strong>Total : Rp. {{ number_format(Session::get('print-bon')[3])}}</strong>" );
            @if(Session::get('print-bon')[4]!='')
                $(".modal-body #signature").css("margin-top","15mm");
                $(".modal-body #signature").html( "({{ Session::get('print-bon')[4] }})" );
            @else
                $(".modal-body #signature").css("margin-top","0mm");
                $(".modal-body #signature").html( "" );
            @endif
            $('#printModal').modal('show');
             
             // window.alert('test');
             // window.print();
            @endif
        });

    </script>
@endsection