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
    <h3 class="page-title"><i class="fa fa-calculator"></i> @lang('quickadmin.expense.title') :
        @if($title != 'Trashed')
            <span id="date"></span>
        @else
            {{$title}}
        @endif
    </h3>
    
    <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                  @if(Session::has('alert-' . $msg))

                  <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                  @endif
                @endforeach
    </div> 
    <p>
       
        @if($title != 'Trashed')
         @can('expense_create')
        <a href="{{ route('expenses.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
        @endcan
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
                'route' => ['expenses.permanentdestroyall'])) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', array('type'=>'submit' ,'class' => 'btn btn-danger')) !!}
            {!! Form::close() !!}
        @endif
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
                <span class="info-box-number">
                    <i class="fa fa-car"></i> <span id="wax_no_mobil">0</span>&nbsp &nbsp 
                    <i class="fa fa-motorcycle"></i> <span id="wax_no_motor">0</span>
                </span>
                
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
                        <th style="width:40px">ID</th>
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
                <tfoot>
                    <tr>
                        <th><input type="text" placeholder="NoBon" size="5"/></th>
                        <th><input type="text" placeholder="YYYY-MM-DD" size="10" /></th>
                        <th><input type="text" placeholder="Parent Category" size="12" /></th>
                        <th><input type="text" placeholder="Category" size="12" /></th>
                        <th><input type="text" placeholder="Ttd" size="8"/></th>
                        <th><input type="text" placeholder="Note" size="15"/></th>
                        <th>@lang('quickadmin.expense.fields.amount')</th>
                        <th><input type="text" placeholder="Sumber" size="5"/></th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </tfoot>
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

            // $('#expense-table tfoot th').each( function () {
            //     var title = $(this).text();
            //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            // } );
            // new $.fn.dataTable.FixedHeader( dtable );
            dtable.columns().every( function () {
                var that = this;
         
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#reportrange span, #date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
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
                            $("#wax_no_mobil").number(result['wax_no_mobil']);
                            $("#wax_no_motor").number(result['wax_no_motor']);
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