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
        @if($title !='Trashed')
        <a href="{{ route('incomes.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
        @if($title != 'Last 14 Days')
        <a href="#" id="today" class="btn btn-info">Hari Ini</a>
        @endif
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
                'route' => ['incomes.permanentdestroyall'])) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', array('type'=>'submit' ,'class' => 'btn btn-danger')) !!}
            {!! Form::close() !!}
        @endif
    </p>
    @endcan
    
    <p>
        {{ Form::hidden('startdate', old('startdate', Carbon\Carbon::today()->subDays(14)->format('d-m-Y')), ['id' => 'startdate']) }}
        {{ Form::hidden('enddate', old('enddate', Carbon\Carbon::today()->format('d-m-Y')), ['id' => 'enddate']) }}
    </p>

    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number number" id="sales_dollar"></span>
                <span class="info-box-number">
                    <i class="fa fa-credit-card"></i> <strong id="sales_debit"> 0 </strong>K  &nbsp &nbsp
                    <i class="fa fa-ticket"></i> <strong id="used_voucher"> 0 </strong>  
                </span>               
                    
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-4">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-blue"><i class="fa fa-shower"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Carwash/Bikewash</span>
                <span class="info-box-number">
                    <i class="fa fa-car"></i>  &nbsp
                    <span id="carwash_dollar">0</span> (<span id="carwash_no"></span>)
                </span>
                <span class="info-box-number"> 
                    <i class="fa fa-motorcycle"></i> &nbsp
                    <span id="bikewash_dollar">0</span> (<span id="bikewash_no"></span>)
                </span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-4">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-yellow"><i class="fa fa-paint-brush"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Wax</span>
    
                <span class="info-box-number"><span id="wax_dollar">0</span></span>
                <span class="info-box-number"><i class="fa fa-car"></i> <span id="wax_no">0</span></span>
                
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-red"><i class="fa fa-dollar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Expenses</span>
                <span class="info-box-number"><span id="expense_dollar">0</span></span>            
                <span class="info-box-number"><i class="fa fa-credit-card"></i> <span id="expense_debit">0</span></span>    
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-4">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-aqua"><i class="fa fa-camera"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Detailing</span>
                <span class="info-box-number"><span id="detailing_dollar">0</span></span>
                <span class="info-box-number"><i class="fa fa-car"></i> <span id="detailing_no">0</span></span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-4">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-maroon"><i class="fa fa-ticket"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">OTHERS</span>
               
                <span class="info-box-number">
                    <span id="total_etc">0</span>
                </span>
                <span class="info-box-number"> 
                    <i class="fa fa-ticket"></i> <span id="voucher_dollar">0</span>K  &nbsp &nbsp
                    <i class="fa fa-glass"></i> <span id="fnb_dollar">0</span>K &nbsp &nbsp
                    <i class="fa fa-handshake-o"></i> <span id="etc_dollar">0</span>K 
                </span>
        
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>        
    </div>
    


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table id="income-table" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>

                        <!-- <th>@lang('quickadmin.income.fields.branch')</th> -->
                        <th>@lang('quickadmin.income.fields.nobon')</th>
                        <th>@lang('quickadmin.income.fields.entry-date')</th>
                        <th>@lang('quickadmin.income.fields.vehicle')</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Plat No.</th>
                        <th>Type</th>
                        <th>Model</th>
                        <th>Warna</th>
                        <th>Kategori</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>

    
@endsection



@section('javascript')
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
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

            
            var dtable = $('#income-table').DataTable({
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
                        { data: 'nobon' },
                        { data: 'entry_date' },
                        { data: 'full_vehicle' , searchable: false, orderable:false},
                        { data: 'income_category_name_full', name: 'income_category_name_full' , searchable: false, orderable:false},
                        { data: 'total_amount_formatted', searchable: false, orderable: false},
                        { data: 'vehicle.license_plate', visible:false},
                        { data: 'vehicle.type', name:'vehicle.type', visible:false},
                        { data: 'vehicle.model', name: 'vehicle.model', visible:false},
                        { data: 'vehicle.color', name: 'vehicle.color', visible:false},
                        { data: 'income_category.name', name:'income_category.name', visible:false},
                        { data: 'actions', name: 'actions', searchable: false, sortable: false}
                    ]
                });
        
            new $.fn.dataTable.FixedHeader( dtable );
            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                $('input[name=startdate]').val(start.format('D-M-YYYY'));
                $('input[name=enddate]').val(end.format('D-M-YYYY'));
                var date_data = {
                    startdate: $('input[name=startdate]').val(),
                    enddate: $('input[name=enddate]').val(),
                };
                $.ajax(
                    {
                        url: "{!! route('loadDashboardData') !!}",
                        data: date_data,
                        success: function(result){
                            $("#sales_dollar").number(result['sales_dollar']);
                            $("#sales_debit").number(result['sales_debit']/1000);
                            $("#used_voucher").number(result['used_voucher']);
                            $("#carwash_dollar").number(result['carwash_dollar']);
                            $("#carwash_no").number(result['carwash_no']);
                            $("#bikewash_dollar").number(result['bikewash_dollar']);
                            $("#bikewash_no").number(result['bikewash_no']);
                            $("#wax_dollar").number(result['wax_dollar']);
                            $("#wax_no").number(result['wax_no']);
                            $("#detailing_dollar").number(result['detailing_dollar']);
                            $("#detailing_no").number(result['detailing_no']);
                            $("#etc_dollar").number(result['etc_dollar']/1000);
                            $("#fnb_dollar").number(result['fnb_dollar']/1000);
                            $("#voucher_dollar").number(result['voucher_dollar']/1000);
                            $("#total_etc").number(result['total_etc']);
                            $("#expense_dollar").number(result['expense_dollar']);
                            $("#expense_debit").number(result['expense_debit']);

                        }
                    });
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

        

        

    </script>
@endsection