@extends('partials.print2')
    @section('printSection')
    <div style="text-align:center; font-size:12px; font-weight:normal">
        <p><strong><span id="date_bon"></span></strong></p>
        <p><strong>Penjualan</strong></p>
        <p>Carwash: <span id="carwash_dollar_bon"></span> (<span id="carwash_no_bon"></span>)</p>
        <p>Bikewash: <span id="bikewash_dollar_bon"></span> (<span id="bikewash_no_bon"></span>)</p>
        <p>Wax: <span id="wax_dollar_bon"></span> (<span id="wax_no_mobil_bon"></span> mbl <span id="wax_no_motor_bon"></span> mtr)</p>
        <p>Detailing: <span id="detailing_dollar_bon"></span> (<span id="detailing_no_bon"></span>)</p>
        <p>Voucher: <span id="voucher_dollar_bon"></span>K</p>
        <p>F&B: <span id="fnb_dollar_bon"></span>K</p>
        <p>Lain-lain: <span id="etc_dollar_bon"></span>K</p>
        <p><strong>Total Penjualan: <span id="sales_dollar_bon"></span></strong></p>
        <p><strong>Debit: <span id="sales_debit_bon"></span>K</strong></p>
        <p><strong>Kas Masuk: <span id="kas_masuk_bon"></span></strong></p>
        <p><strong>-------------------------------</strong></p>
        <p><strong>Pengeluaran: <span id="expense_dollar_bon"></span></strong></p>
        <p><strong>Debit: <span id="expense_debit_bon"></span></strong></p>
        <p><strong>Kas Keluar: <span id="kas_keluar_bon"></span></strong></p>
        <p><strong>-------------------------------</strong></p>
        <p><strong>Total Kas: <span id="total_kas_bon"></span></strong></p>
        <p><strong>Used Voucher: <span id="used_voucher_bon"></span></strong></p>
        <p id="total"></p> 
    </div>
    @endsection

@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-md-4" id="reportrange" style="background: #fff; cursor: pointer; margin-left:15px; padding: 5px 10px; border: 1px solid #ccc; ">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
        <div class="col-md-6">
            <button type="button" id="printButton" class="btn btn-primary" data-toggle="modal" data-target="#printModal">
            Closing Harian
          </button>
        </div>
       
    </div>
    <p>
        {{ Form::hidden('startdate', old('startdate', Carbon\Carbon::today()->subDays(14)->format('d-m-Y')), ['id' => 'startdate']) }}
        {{ Form::hidden('enddate', old('enddate', Carbon\Carbon::today()->format('d-m-Y')), ['id' => 'enddate']) }}
    </p>
    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-blue"><i class="fa fa-car"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Vehicles</span>
                <span class="info-box-number" id="total_vehicle"></span>
                <span class="info-box-number"> 
                    <i class="fa fa-car"></i> <span id="total_mobil"></span> &nbsp &nbsp
                    <i class="fa fa-motorcycle"></i> <span id="total_motor"></span> 
                </span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-red"><i class="fa fa-dollar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Today Expenses</span>
                <span class="info-box-number" id="expense_dollar"></span>            
                <span class="info-box-number"><i class="fa fa-credit-card"></i> <span id="expense_debit"> </span></span>    
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-6">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Today Sales</span>
                <span class="info-box-number" id="sales_dollar"></span>
                <span class="info-box-number">
                    <i class="fa fa-credit-card"></i> <strong> <span id="sales_debit"></span>K &nbsp &nbsp
                    <i class="fa fa-ticket"></i> <strong> <span id="used_voucher"></span> </strong>  
                </span>               
                    
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-blue"><i class="fa fa-shower"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Carwash/Bikewash</span>
                <span class="info-box-number">
                    <i class="fa fa-car"></i>  &nbsp
                    <span id="carwash_dollar"></span> (<span id="carwash_no"></span>)
                </span>
                <span class="info-box-number"> 
                    <i class="fa fa-motorcycle"></i> &nbsp
                    <span id="bikewash_dollar"></span> (<span id="bikewash_no"></span>)
                </span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-yellow"><i class="fa fa-paint-brush"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Wax</span>
                <span class="info-box-number" id="wax_dollar"></span>
                <span class="info-box-number"><i class="fa fa-car"></i> <span id="wax_no_mobil"></span> &nbsp &nbsp
                <i class="fa fa-motorcycle"></i> <span id="wax_no_motor"></span>
              </span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-aqua"><i class="fa fa-camera"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Detailing</span>
                <span class="info-box-number" id="detailing_dollar"></span>
                <span class="info-box-number"><i class="fa fa-car"></i> <span id="detailing_no"></span></span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-maroon"><i class="fa fa-ticket"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">OTHERS</span>
                <span class="info-box-number" id="total_etc">
                    
                </span>
                <span class="info-box-number"> 
                    <i class="fa fa-ticket"></i> <span id="voucher_dollar"></span>K  &nbsp &nbsp
                    <i class="fa fa-glass"></i> <span id="fnb_dollar"></span>K &nbsp &nbsp
                </span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>        

    </div>

    <div class="row">
        <div class="col-md-6">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Vehicles - Today</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart2" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>


          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Vehicles - Last 14 Days</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="vehiclesHourlyChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

          
          <!-- /.box -->

         
    </div>

     <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Sales - Last 14 Days</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-to ol" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart" id="sales14daysContainer">
                <canvas id="sales14daysChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Vehicles - Last 4 Weeks</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart3" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

        </div>
        <!-- /.col (RIGHT) -->
    </div>

@endsection


@section('javascript')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> 
    <script>

    $(document).ready(function(){
      var start = moment();
      
      function cb(start) {
          $('#reportrange span, #date_bon').html(start.format('D MMMM, YYYY'));
          $('input[name=startdate]').val(start.format('D-M-YYYY'));
          var sub_14 = start.subtract(14, 'days');
          var date_data = {
              startdate: $('input[name=startdate]').val(),
              enddate: $('input[name=startdate]').val(),
              category: "total"
          };
          $.ajax(
                    {
                        url: "{!! route('loadDashboardData') !!}",
                        data: date_data,
                        beforeSend: function(){
                            var processingText = '...'
                            $("#sales_dollar, #sales_dollar_bon").html(processingText);
                            $("#sales_debit, #sales_debit_bon").html(processingText);
                            $("#used_voucher, #used_voucher_bon").html(processingText);
                            $("#kas_masuk, #kas_masuk_bon").html(processingText);
                            $("#carwash_dollar, #carwash_dollar_bon").html(processingText);
                            $("#carwash_no, #carwash_no_bon").html(processingText);
                            $("#bikewash_dollar, #bikewash_dollar_bon").html(processingText);
                            $("#bikewash_no, #bikewash_no_bon").html(processingText);
                            $("#wax_dollar, #wax_dollar_bon").html(processingText);
                            $("#wax_no_mobil, #wax_no_mobil_bon").html(processingText);
                            $("#wax_no_motor, #wax_no_motor_bon").html(processingText);
                            $("#detailing_dollar, #detailing_dollar_bon").html(processingText);
                            $("#detailing_no, #detailing_no_bon").html(processingText);
                            $("#etc_dollar, #etc_dollar_bon").html(processingText);
                            $("#fnb_dollar, #fnb_dollar_bon").html(processingText);
                            $("#voucher_dollar, #voucher_dollar_bon").html(processingText);
                            $("#total_etc, #total_etc_bon").html(processingText);
                            $("#expense_dollar, #expense_dollar_bon").html(processingText);
                            $("#expense_debit").html(processingText);
                            $("#total_vehicle").html(processingText);
                            $("#total_mobil").html(processingText);
                            $("#total_motor").html(processingText);
                        },
                        success: function(result){
                            $("#sales_dollar, #sales_dollar_bon").number(result['sales_dollar']);
                            $("#sales_debit, #sales_debit_bon").number(result['sales_debit']/1000);
                            $("#used_voucher, #used_voucher_bon").number(result['used_voucher']);
                            $("#kas_masuk, #kas_masuk_bon").number(result['sales_dollar']-result['sales_debit']);
                            $("#kas_keluar, #kas_keluar_bon").number(result['expense_dollar']-result['expense_debit']);
                            $("#total_kas, #total_kas_bon").number((result['sales_dollar']-result['sales_debit'])-(result['expense_dollar']-result['expense_debit']));
                            $("#carwash_dollar, #carwash_dollar_bon").number(result['carwash_dollar']);
                            $("#carwash_no, #carwash_no_bon").number(result['carwash_no']);
                            $("#bikewash_dollar, #bikewash_dollar_bon").number(result['bikewash_dollar']);
                            $("#bikewash_no, #bikewash_no_bon").number(result['bikewash_no']);
                            $("#wax_dollar, #wax_dollar_bon").number(result['wax_dollar']);
                            $("#wax_no_mobil, #wax_no_mobil_bon").number(result['wax_no_mobil']);
                            $("#wax_no_motor, #wax_no_motor_bon").number(result['wax_no_motor']);
                            $("#detailing_dollar, #detailing_dollar_bon").number(result['detailing_dollar']);
                            $("#detailing_no, #detailing_no_bon").number(result['detailing_no']);
                            $("#etc_dollar, #etc_dollar_bon").number(result['etc_dollar']/1000);
                            $("#fnb_dollar, #fnb_dollar_bon").number(result['fnb_dollar']/1000);
                            $("#voucher_dollar, #voucher_dollar_bon").number(result['voucher_dollar']/1000);
                            $("#total_etc, #total_etc_bon").number(result['total_etc']);
                            $("#expense_dollar, #expense_dollar_bon").number(result['expense_dollar']);
                            $("#expense_debit, #expense_debit_bon").number(result['expense_debit']);
                            $("#total_vehicle").number(result['total_vehicle']);
                            $("#total_mobil").number(result['total_mobil']);
                            $("#total_motor").number(result['total_motor']);

                        }
                    });
          date_data['startdate'] = sub_14.format('D-M-YYYY');
          $.ajax(
          {
              url: "{!! route('loadIncomeDataByDate') !!}",
              data: date_data,
              success: function(result){
                var chartdata = [];

                $.each(result.data, function(key, value){
                  chartdata.push({x : value['date'], y: value['amount'] + value['wax_amount'] + value['fnb_amount']});
                });
                
                // alert(JSON.stringify(chartdata));
                $("#sales14daysChart").remove();
                $("#sales14daysContainer").append('<canvas id="sales14daysChart" style="height:250px"></canvas>');
                var sales14daysctx = $("#sales14daysChart");
                var sales14daysChart = new Chart(sales14daysctx,{
                    type: 'bar',
                    data: {
                      datasets: [{
                          data: chartdata,
                          label: "Sales",
                          backgroundColor: "rgba(60,141,188,0.9)",
                      }]         
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                     callback: function(label, index, labels) {
                                          return $.number(label);
                                      }
                                }
                            }]
                        },
                        legend: {
                            display: false,
                            labels: {
                                fontColor: 'rgb(255, 99, 132)'
                            }
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return $.number(tooltipItem.yLabel);
                                }
                            }
                        }
                    }
                });

              }
          });
          
      }

      $('#reportrange').daterangepicker({
                singleDatePicker: true,
                showDrowdowns: true,
                startDate: start
                
            }, cb);

      

      cb(start);
    });
  
    
        
</script>
@endsection
