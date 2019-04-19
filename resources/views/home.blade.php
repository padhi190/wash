@extends('partials.print2')
    @section('printSection')
    <div style="text-align:center; font-weight:normal">
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
              <h3 class="box-title">Vehicles - <span id="today_date"></span></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart" id="vehiclesHourlyContainer">
                <canvas id="vehiclesHourlyChart" style="height:250px"></canvas>
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
              <div class="chart" id="vehiclesLast14DaysContainer">
                <canvas id="vehiclesLast14DaysChart" style="height:250px"></canvas>
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
              <h3 class="box-title">Vehicles - Last 4 Months</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart" id="vehicles4weeksContainer">
                <canvas id="vehicles4weeksChart" style="height:250px"></canvas>
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
          $('#reportrange span, #date_bon, #today_date').html(start.format('dddd D MMMM, YYYY'));
          $('input[name=startdate]').val(start.format('D-M-YYYY'));
          
          var date_data = {
              startdate: $('input[name=startdate]').val(),
              enddate: $('input[name=startdate]').val(),
              category: "total"
          };
          //ajax request for info-box
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
          //ajax request for vehicles hourly chart
          $.ajax({
              url: "{!! route('loadVehiclesDataByHour') !!}",
              data: date_data,
              success: function(result){
                var vehiclesdata = [];
                var waxdata = [];

                $.each(result.data, function(key, value){
                  // alert(JSON.stringify(date_data['enddate']));
                  var x = moment(date_data['enddate'],'DD-MM-YYYY');
                  x.set({hour:value['hour'], minute: 0, second: 0, millisecond: 0});
                  x.toISOString();
                  x.format();
                  vehiclesdata.push({x : x, y: value['no_vehicles']});
                  waxdata.push({x : x, y: value['wax_amount']});
                });
                // alert(JSON.stringify(vehiclesdata));
                $("#vehiclesHourlyChart").remove();
                $("#vehiclesHourlyContainer").append('<canvas id="vehiclesHourlyChart" style="height:250px"></canvas>');
                var vehicleshourlyctx = $("#vehiclesHourlyChart");
                var vehiclesHourlyChart = new Chart(vehicleshourlyctx,{
                    type: 'bar',
                    data: {
                      datasets: [
                      {
                        data: vehiclesdata,
                        label: "Vehicles",
                        backgroundColor: "rgba(60,141,188,0.9)",
                      },
                      {
                        data: waxdata,
                        label: "Wax",
                        backgroundColor: "rgba(180,0,0,0.9)",
                      },
                      ]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                offset: true, 
                                time: {
                                    unit: 'hour'
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
                            mode: 'index',
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    
                                    return label + $.number(tooltipItem.yLabel);
                                }
                            }
                        }
                    }
                });
              }
          });
          var sub_14 = start.subtract(14, 'days');
          date_data['startdate'] = sub_14.format('D-M-YYYY');
          //ajax request for chart Sales - last 14 days
          $.ajax(
          {
              url: "{!! route('loadIncomeDataByDate') !!}",
              data: date_data,
              success: function(result){
                var chartdata = [];

                $.each(result.data, function(key, value){
                  chartdata.push({x : moment(value['date']), y: value['amount'] + value['wax_amount'] + value['fnb_amount']});
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
                                offset: true,
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
                                title: function(tooltipItems, data) {
                                    //Return value for title
                                    var date = moment(tooltipItems[0].xLabel,"MMM DD, YYYY").format("ddd, DD-MMM-YYYY");
                                    return date;
                                },
                                label: function(tooltipItem, data) {                                    
                                    return $.number(tooltipItem.yLabel);
                                }
                            }
                        }
                    }
                });

              }
          });
          //ajax request for chart Vehicles - Last 14 days
          $.ajax(
          {
            url: "{!! route('loadVehiclesDataByDate') !!}",
            data: date_data,
            success: function(result){
              // alert(JSON.stringify(result));
              var chartdata = [];
              var waxdata = [];

              $.each(result.data, function(key, value){
                chartdata.push({x : moment(value['date']), y: value['no_vehicles']-value['wax_amount']});
                waxdata.push({x : moment(value['date']), y: value['wax_amount']});
              });

              $("#vehiclesLast14DaysChart").remove();
              $("#vehiclesLast14DaysContainer").append('<canvas id="vehiclesLast14DaysChart" style="height:250px"></canvas>')
              var vehiclesLast14Daysctx = $("#vehiclesLast14DaysChart");
              var vehiclesLast14DaysChart = new Chart(vehiclesLast14Daysctx,{
                    type: 'bar',
                    data: {
                      datasets: [
                      {
                        data: waxdata,
                        label: "Wax",
                        backgroundColor: "rgba(180,0,0,0.9)",
                      },
                      {
                          data: chartdata,
                          label: "Vehicles",
                          backgroundColor: "rgba(60,141,188,0.9)",
                      }
                      ]        
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                offset: true,
                                stacked: true,
                                time: {
                                    unit: 'day'
                                }
                            }],
                            yAxes: [{
                                stacked: true,
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
                            mode: 'index',
                            callbacks: {
                                title: function(tooltipItems, data) {
                                    //Return value for title
                                    var date = moment(tooltipItems[0].xLabel,"MMM DD, YYYY").format("ddd, DD-MMM-YYYY");
                                    return date;
                                },
                                label: function(tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                    if (label) {
                                        label += ': ';
                                    }
                                    
                                    if (tooltipItem.datasetIndex != data.datasets.length - 1) {
                                      return label + $.number(tooltipItem.yLabel);
                                    }
                                    else
                                    {
                                      // return JSON.stringify(tooltipItem);
                                      var total = $.number(parseInt(data.datasets[0].data[tooltipItem.index].y) + parseInt(tooltipItem.yLabel));
                                      var total_label = 'Vehicles: ' + total;

                                      return [total_label];
                                    }
                                }
                            }
                        }
                    }
                }); 

            }
          });
          //ajax request for chart Vehicles - Last 4 weeks
          
          var sub_4_weeks = start.subtract(3, 'month').startOf('month');
          date_data['startdate'] = sub_4_weeks.format('D-M-YYYY');
          $.ajax(
          {
            url: "{!! route('loadVehiclesDataByMonth') !!}",
            data: date_data,
            success: function(result){
              // alert(JSON.stringify(result));
              var chartdata = [];
              var waxdata = [];

              $.each(result.data, function(key, value){
                var date = moment().year(value['year']).month(value['month']).endOf('month').set({hour:0, minute:0, second:0, millisecond:0});
                chartdata.push({x : date, y: value['no_vehicles']-value['wax_amount']});
                waxdata.push({x : date, y: value['wax_amount']});
              });
              // alert(JSON.stringify(chartdata));

              $("#vehicles4weeksChart").remove();
              $("#vehicles4weeksContainer").append('<canvas id="vehicles4weeksChart" style="height:250px"></canvas>');

              var vehicles4weeksctx = $("#vehicles4weeksChart");
              var vehicles4weeksChart = new Chart(vehicles4weeksctx,{
                  type: 'bar',
                    data: {
                      datasets: [
                      {
                        data: waxdata,
                        label: "Wax",
                        backgroundColor: "rgba(180,0,0,0.9)",
                      },
                      {
                          data: chartdata,
                          label: "Vehicles",
                          backgroundColor: "rgba(60,141,188,0.9)",
                      }
                      ]        
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                distribution: 'series',
                                offset: true,
                                stacked: true,
                                time: {
                                    unit: 'month',
                                    displayFormats: {
                                       'month': 'MMM YYYY',
                                    }
                                },
                                ticks: {
                                  callback: function(value) {
                                      var date = moment(value).subtract(1, 'days'); 
                                      return date.format('MMM YYYY'); 
                                  },
                                }
                              

                            }],
                            yAxes: [{
                                stacked: true,
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
                            mode: 'index',
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                    if (label) {
                                        label += ': ';
                                    }
                                    
                                    if (tooltipItem.datasetIndex != data.datasets.length - 1) {
                                      return label + $.number(tooltipItem.yLabel);
                                    }
                                    else
                                    {
                                      // return JSON.stringify(tooltipItem);
                                      var total = $.number(parseInt(data.datasets[0].data[tooltipItem.index].y) + parseInt(tooltipItem.yLabel));
                                      var total_label = 'Vehicles: ' + total;

                                      return [total_label];
                                    }
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
