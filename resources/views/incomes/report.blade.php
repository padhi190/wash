@extends('partials.print')
    @section('printSection')
    <div style="text-align:center; font-size:18px;">
        <p id="rcpt">Rcpt No:</p>
        <p id="date"></p>
        <p id="vehicle"></p>
        <p id="kategori"></p>
        
        
        <p id="wax"></p>
        <p id="fnb"></p>
        
        <p id="total"></p> 
    </div>
    @endsection
@extends('layouts.app')
@section('content')
    <h3 class="page-title"><i class="fa fa-shopping-cart"></i> @lang('quickadmin.income.title') - {{$title}}</h3>
    @can('income_create')
    <p>
        <a href="{{ route('incomes.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
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
            <table id="income-table" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <!-- <th>@lang('quickadmin.income.fields.branch')</th> -->
                        <th>@lang('quickadmin.income.fields.nobon')</th>
                        <th>@lang('quickadmin.income.fields.entry-date')</th>
                        <th>Time</th>
                        <th>@lang('quickadmin.income.fields.vehicle')</th>
                        <th>Kategori</th>
                        <th>FnB</th>
                        <th>Wax</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Warna</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>

    
@endsection



@section('javascript') 
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> 
    <script>
        @can('income_delete')
            window.route_mass_crud_entries_destroy = '{{ route('incomes.mass_destroy') }}';
        @endcan
        // var table = $('#example').DataTable();
        $(document).ready(function(){
            $("#today").click(function(){
                $("input[type='search']").val(moment().format('YYYY-MM-DD')).keyup();
            });

            $('input[type=search]').focus();

            $(function() {
                var dtable = $('#income-table').DataTable({
                    dom: 'Blfrtip',
                    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
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
                        { data: 'nobon', searchable: true },
                        { data: 'entry_date', searchable: true },
                        { data: 'entry_time', searchable: false},
                        { data: 'vehicle.license_plate', name: 'vehicle.license_plate', searchable: true },
                        { data: 'income_category.name', name: 'income_category.name', searchable: true },
                        { data: 'fnb_amount', searchable: true},
                        { data: 'wax_amount', searchable: true},
                        { data: 'amount', searchable: true},
                        { data: 'total_amount_number', searchable: false},
                        { data: 'payment_type.name', searchable: true},
                        { data: 'vehicle.type', name:'vehicle.type', visible:true, searchable: true},
                        { data: 'vehicle.brand', searchable: true},
                        { data: 'vehicle.model', name: 'vehicle.model', visible:true, searchable: true},
                        { data: 'vehicle.color', name: 'vehicle.color', visible:true, searchable: true},
                       
                    ]
                });

                var start = moment().startOf('month');
                var end = moment().endOf('month');

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
                });
        });

        

    </script>
@endsection