@extends('layouts.app')

@section('content')
	
	<p>Select Period</p>
	<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
    <p>
        {{ Form::hidden('startdate', old('startdate', Carbon\Carbon::today()->subDays(14)->format('d-m-Y')), ['id' => 'startdate']) }}
        {{ Form::hidden('enddate', old('enddate', Carbon\Carbon::today()->format('d-m-Y')), ['id' => 'enddate']) }}
    </p>
    <br>
    <br>

    <div class="row">
      <div class="col-md-4">
        <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Profit</span>
                <span class="info-box-number" style="font-size: 15px">Kopo : <span id="kopo_profit" style="float: right">1</span></span>            
                <span class="info-box-number" style="font-size: 15px">Banceuy : <span id="banceuy_profit" style="float: right">1</span></span>  
                <span class="info-box-number" style="font-size: 15px">Bubat : <span id="bubat_profit" style="float: right">1</span></span>    
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
      </div>

      <div class="col-md-4">
        <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Revenue</span>
                <span class="info-box-number" style="font-size: 15px">Kopo : <span id="kopo_revenue" style="float: right">1</span></span>            
                <span class="info-box-number" style="font-size: 15px">Banceuy : <span id="banceuy_revenue" style="float: right">1</span></span>  
                <span class="info-box-number" style="font-size: 15px">Bubat : <span id="bubat_revenue" style="float: right">1</span></span>    
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
      </div>

      <div class="col-md-4">
        <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-red"><i class="fa fa-dollar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Expense</span>
                <span class="info-box-number" style="font-size: 15px">Kopo : <span id="kopo_expense" style="float: right">1</span></span>            
                <span class="info-box-number" style="font-size: 15px">Banceuy : <span id="banceuy_expense" style="float: right">1</span></span>  
                <span class="info-box-number" style="font-size: 15px">Bubat : <span id="bubat_expense" style="float: right">1</span></span>    
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
      </div>
    </div>

    <div class="row">
        <div class="col-md-6">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Revenue - Unit</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart" id="revenueUnitContainer">
                <canvas id="revenueUnitChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>


          <!-- BAR CHART -->
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Revenue - Rp</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart" id="revenueRpContainer">
                <canvas id="revenueRpChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Expenses </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart" id="expenseContainer">
                <canvas id="expenseChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Wax </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart" id="waxContainer">
                <canvas id="waxChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
    </div>

          
          <!-- /.box -->

         
@endsection

@section('javascript')
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> 
	<script>
		var start = moment().startOf('month');
        var end = moment().endOf('month');
        var kopo_revenue = 0;
        function cb(start, end) {
            $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
            $('#period').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
            $('input[name=startdate]').val(start.format('D-M-YYYY'));
            $('input[name=enddate]').val(end.format('D-M-YYYY'));
            var date_data = {
                startdate: start.format('D-M-YYYY'),
                enddate: end.format('D-M-YYYY'),
            };
            $.ajax(
                {
                    url: "{!! route('loadAllBranchesRevenue') !!}",
                    data: date_data,
                    beforeSend: function(){
                      var processingText = 'Wait for it...'
                    	$('#kopo_profit, #banceuy_profit, #bubat_profit').html(processingText);
                      $('#kopo_revenue, #banceuy_revenue, #bubat_revenue').html(processingText);
                      $('#kopo_expense, #banceuy_expense, #bubat_expense').html(processingText);
                    },
                    success: function(result){

                      // get data for revenue - unit
                      var kopo_no = [];
                      var banceuy_no = [];
                      var bubat_no = [];
                      var len = 4;
                      kopo_no.length = len;
                      bubat_no.length = len;
                      banceuy_no.length = len;
                      banceuy_no.fill(0);
                      kopo_no.fill(0);
                      bubat_no.fill(0);
                      $.each(result.carwash_no, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_no[0]=(value['no']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_no[0]=(value['no']);
                        else
                          banceuy_no[0]=(value['no']);
                      });

                      $.each(result.bikewash_no, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_no[1]=(value['no']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_no[1]=(value['no']);
                        else
                          banceuy_no[1]=(value['no']);
                      });

                      $.each(result.wax_no, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_no[2]=(value['no']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_no[2]=(value['no']);
                        else
                          banceuy_no[2]=(value['no']);
                      });

                      $.each(result.detailing_no, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_no[3]=(value['no']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_no[3]=(value['no']);
                        else
                          banceuy_no[3]=(value['no']);
                      });

                      kopo_no.unshift(kopo_no[0]+kopo_no[1]+kopo_no[3]);
                      bubat_no.unshift(bubat_no[0]+bubat_no[1]+bubat_no[3]);
                      // alert(JSON.stringify(banceuy_no[3]));
                      banceuy_no.unshift(banceuy_no[0]+banceuy_no[1]+banceuy_no[3]);


                      // get data for revenue - rp
                      var kopo_dollar = [];
                      var bubat_dollar = [];
                      var banceuy_dollar = [];
                      var kopo_profit = 0;
                      var bubat_profit = 0;
                      var banceuy_profit = 0;
                      var len = 8;
                      kopo_dollar.length = len;
                      bubat_dollar.length = len;
                      banceuy_dollar.length = len;
                      kopo_dollar.fill(0);
                      bubat_dollar.fill(0);
                      banceuy_dollar.fill(0);

                      $.each(result.sales_dollar, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_dollar[0]=(value['amount']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_dollar[0]=(value['amount']);
                        else
                          banceuy_dollar[0]=(value['amount']);
                      });

                      $.each(result.expense_dollar, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_profit = kopo_dollar[0] - value['amount'];
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_profit = bubat_dollar[0] - value['amount'];
                        else
                          banceuy_profit = banceuy_dollar[0] - value['amount'];
                      });

                      $("#kopo_profit").number(kopo_profit);
                      $("#bubat_profit").number(bubat_profit);
                      $("#banceuy_profit").number(banceuy_profit);

                      $.each(result.carwash_dollar, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_dollar[1]=(value['amount']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_dollar[1]=(value['amount']);
                        else
                          banceuy_dollar[1]=(value['amount']);
                      });

                      $.each(result.bikewash_dollar, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_dollar[2]=(value['amount']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_dollar[2]=(value['amount']);
                        else
                          banceuy_dollar[2]=(value['amount']);
                      });

                      $.each(result.wax_dollar, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_dollar[3]=(value['amount']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_dollar[3]=(value['amount']);
                        else
                          banceuy_dollar[3]=(value['amount']);
                      });

                      $.each(result.detailing_dollar, function(key, value){
                        if(value['branch']['branch_name'] == 'Kopo')
                          kopo_dollar[4]=(value['amount']);
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                          bubat_dollar[4]=(value['amount']);
                        else
                          banceuy_dollar[4]=(value['amount']);
                      });

                      $.each(result.fnb_dollar, function(key, value){
                        // alert(JSON.stringify(value['branch']['branch_name']));
                        if(value['branch']['branch_name'] == 'Kopo')
                        {
                          kopo_dollar[5]=(value['amount']);
                        }
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                        {
                          bubat_dollar[5]=(value['amount']);
                        }
                        else
                        {
                          banceuy_dollar[5]=(value['amount']);
                        }
                      });

                      $.each(result.voucher_dollar, function(key, value){
                        // alert(JSON.stringify(value['branch']['branch_name']));
                        if(value['branch']['branch_name'] == 'Kopo')
                        {
                          kopo_dollar[6]=(value['amount']);
                        }
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                        {
                          bubat_dollar[6]=(value['amount']);
                          // alert(JSON.stringify(value['amount']));
                        }
                        else
                        {
                          banceuy_dollar[6]=(value['amount']);
                        }
                      });

                      $.each(result.etc_dollar, function(key, value){
                        // alert(JSON.stringify(value['branch']['branch_name']));
                        if(value['branch']['branch_name'] == 'Kopo')
                        {
                          kopo_dollar[7]=(value['amount']);
                        }
                        else if(value['branch']['branch_name'] == 'Buah Batu')
                        {
                          bubat_dollar[7]=(value['amount']);
                          // alert(JSON.stringify(value['amount']));
                        }
                        else
                        {
                          banceuy_dollar[7]=(value['amount']);
                        }
                      });

                      kopo_revenue = kopo_dollar[0];
                      $("#kopo_revenue").number(kopo_dollar[0]);
                      $("#banceuy_revenue").number(banceuy_dollar[0]);
                      $("#bubat_revenue").number(bubat_dollar[0]);

                      // alert(JSON.stringify(kopo_dollar));

                      //draw Revenue Unit Chart

                      $("#revenueUnitChart").remove();
                      $("#revenueUnitContainer").append('<canvas id="revenueUnitChart" style="height:350px"></canvas>');
                      var revenueUnitCtx = $("#revenueUnitChart");
                      var revenueUnitChart = new Chart(revenueUnitCtx,{
                        type: 'horizontalBar',
                        data: {
                          labels: ['Total', 'Carwash', 'Bikewash', 'Wax', 'Detailing'],
                          datasets: [
                          {
                            data: kopo_no,
                            label: "Kopo",
                            backgroundColor: "rgb(255,196,13)",
                          },
                          {
                            data: banceuy_no,
                            label: "Banceuy",
                            backgroundColor: "rgb(30,113,69)",
                          },
                          {
                            data: bubat_no,
                            label: "Buah Batu",
                            backgroundColor: "rgb(185,29,71)",
                          },
                          ]
                        },
                        options: {
                            scales: {
                                xAxes: [{
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
                                        
                                        return label + $.number(tooltipItem.xLabel);
                                    }
                                }
                            }
                          }

                      });

                      //draw Revenue Rp Chart

                      $("#revenueRpChart").remove();
                      $("#revenueRpContainer").append('<canvas id="revenueRpChart" style="height:350px"></canvas>');
                      var revenueRpCtx = $("#revenueRpChart");
                      var revenueRpChart = new Chart(revenueRpCtx,{
                        type: 'horizontalBar',
                        data: {
                          labels: ['Total', 'Carwash', 'Bikewash', 'Wax', 'Detailing', 'F&B', 'Voucher', 'Lain2'],
                          datasets: [
                          {
                            data: kopo_dollar,
                            label: "Kopo",
                            backgroundColor: "rgb(255,196,13)",
                          },
                          {
                            data: banceuy_dollar,
                            label: "Banceuy",
                            backgroundColor: "rgb(30,113,69)",
                          },
                          {
                            data: bubat_dollar,
                            label: "Buah Batu",
                            backgroundColor: "rgb(185,29,71)",
                          },
                          ]
                        },
                        options: {
                            scales: {
                                xAxes: [{
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
                                        
                                        return label + $.number(tooltipItem.xLabel);
                                    }
                                }
                            }
                          }

                      });


                    }
                });
            
            $.ajax(
                {
                    url: "{!! route('loadAllBranchesExpenses') !!}",
                    data: date_data,
                    beforeSend: function(){
                      var processingText = 'Wait for it...'
                      $('#kopo_profit, #banceuy_profit, #bubat_profit').html(processingText);
                      $('#kopo_revenue, #banceuy_revenue, #bubat_revenue').html(processingText);
                      $('#kopo_expense, #banceuy_expense, #bubat_expense').html(processingText);
                    },
                    success: function(result){
                      var dataExpense = {
                        kopo: [],
                        banceuy: [],
                        bubat: []
                      };
                      var len = 17;
                      dataExpense.kopo.length = len;
                      dataExpense.kopo.fill(0);

                      dataExpense.banceuy.length = len;
                      dataExpense.banceuy.fill(0);

                      dataExpense.bubat.length = len;
                      dataExpense.bubat.fill(0);

                      var expense_categories = ['Total', 'Alat penunjang cuci', 'Alat penunjang kebersihan', 'ATK', 'Bonus Pegawai', 'Bonus Salon', 'Bonus Wax', 'Fee Marketing', 'Gaji Pegawai', 'Iuran Bulanan', 'Lain-lain', 'Listrik', 'Operasional', 'Perbaikan dan Pembelian Alat', 'Restock Minuman/Rokok', 'Tunjangan Karyawan', 'Wax dan Obat Salon'];

                      $.each(result.data, function(key, value){
                        // alert(JSON.stringify(value));

                        for (var i = expense_categories.length - 1; i >= 1; i--) {
                          if(value['parent_category'] == expense_categories[i])
                          {
                            if(value['branch']['branch_name'] == 'Kopo')
                              dataExpense.kopo[i] = value['amount'];
                            else if(value['branch']['branch_name'] == 'Banceuy')
                              dataExpense.banceuy[i] = value['amount'];
                            else
                              dataExpense.bubat[i] = value['amount'];
                          }
                        }
                        
                      });

                      var sum=0;
                      $.each(dataExpense.kopo,function(){sum+=parseFloat(this) || 0;});
                      dataExpense.kopo[0] = sum;
                      sum=0;
                      $.each(dataExpense.banceuy,function(){sum+=parseFloat(this) || 0;});
                      dataExpense.banceuy[0] = sum;
                      sum=0;
                      $.each(dataExpense.bubat,function(){sum+=parseFloat(this) || 0;});
                      dataExpense.bubat[0] = sum;


                      $("#kopo_expense").number(dataExpense.kopo[0]);
                      $("#banceuy_expense").number(dataExpense.banceuy[0]);
                      $("#bubat_expense").number(dataExpense.bubat[0]);
                      // alert($("#kopo_revenue").text());

                      // draw Expense Chart

                      $("#expenseChart").remove();
                      $("#expenseContainer").append('<canvas id="expenseChart" style="height:500px"></canvas>');
                      var expenseCtx = $("#expenseChart");
                      var expenseChart = new Chart(expenseCtx,{
                        type: 'bar',
                        data: {
                          labels: expense_categories,
                          datasets: [
                          {
                            data: dataExpense.kopo,
                            label: "Kopo",
                            backgroundColor: "rgb(255,196,13)",
                          },
                          {
                            data: dataExpense.banceuy,
                            label: "Banceuy",
                            backgroundColor: "rgb(30,113,69)",
                          },
                          {
                            data: dataExpense.bubat,
                            label: "Buah Batu",
                            backgroundColor: "rgb(185,29,71)",
                          },
                          ]
                        },
                        options: {
                            scales: {
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
            $.ajax(
                {
                  url: "{!! route('loadVehiclesDataByDate') !!}",
                  data: date_data,
                  beforeSend: function(){
                      
                    },
                  success: function(result){
                    // alert(JSON.stringify(result));
                      console.log(JSON.stringify(result));
                      var kopo_vehicles = [];
                      var kopo_wax = [];
                      var banceuy_vehicles = [];
                      var banceuy_wax = [];
                      var bubat_vehicles = [];
                      var bubat_wax = [];

                    $.each(result.data, function(key, value){
                      if(value['branch_id'] == 1){
                        kopo_vehicles.push({x : moment(value['date']), y: value['no_vehicles']-value['wax_amount']});
                        kopo_wax.push({x : moment(value['date']), y: value['wax_amount']});  
                      }

                      if(value['branch_id'] == 3){
                        banceuy_vehicles.push({x : moment(value['date']), y: value['no_vehicles']-value['wax_amount']});
                        banceuy_wax.push({x : moment(value['date']), y: value['wax_amount']});  
                      }

                      if(value['branch_id'] == 2){
                        bubat_vehicles.push({x : moment(value['date']), y: value['no_vehicles']-value['wax_amount']});
                        bubat_wax.push({x : moment(value['date']), y: value['wax_amount']});  
                      }

                    });

                    $("#waxChart").remove();
                    $("#waxContainer").append('<canvas id="waxChart" style="height:350px"></canvas>');
                    var waxCtx = $("#waxChart");
                    var waxChart = new Chart(waxCtx,{
                        type: 'bar',
                        data: {
                          datasets: [
                            {
                                data: kopo_wax,
                                label: "Kopo Wax",
                                stack: '0',
                                backgroundColor: "rgba(180,0,0,0.9)",
                            },
                            {
                                data: kopo_vehicles,
                                label: "Kopo Vehicles",
                                stack: '0',
                                backgroundColor: "rgba(255,196,13,1)",
                            },
                            {
                                data: banceuy_wax,
                                label: "Banceuy Wax",
                                stack: '1',
                                backgroundColor: "rgba(180,0,0,0.9)",
                            },
                            {
                                data: banceuy_vehicles,
                                stack: '1',
                                label: "Banceuy Vehicles",
                                backgroundColor: "rgb(30,113,69)",
                            },
                            {
                                data: bubat_wax,
                                label: "Bubat Wax",
                                stack: '2',
                                backgroundColor: "rgba(180,0,0,0.9)",
                            },
                            {
                                data: bubat_vehicles,
                                stack: '2',
                                label: "Bubat Vehicles",
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
                                        
                                        if (tooltipItem.datasetIndex % 2 == 0) {
                                          return label + $.number(tooltipItem.yLabel);
                                        }
                                        else
                                        {
                                          // return JSON.stringify(tooltipItem.datasetIndex);
                                          // return JSON.stringify(data.datasets[tooltipItem.datasetIndex-1].data[tooltipItem.index].y);
                                          var total = $.number(parseInt(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].y) + parseInt(data.datasets[tooltipItem.datasetIndex-1].data[tooltipItem.index].y));
                                          var total_label = label + total;

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
            startDate: start,
            endDate: end,
            ranges: {
               'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
               'Bulan kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
               'Januari': [moment().set('month',0).startOf('month'), moment().set('month',0).endOf('month')],
               'Februari': [moment().set('month',1).startOf('month'), moment().set('month',1).endOf('month')],
               'Maret': [moment().set('month',2).startOf('month'), moment().set('month',2).endOf('month')],
               'April': [moment().set('month',3).startOf('month'), moment().set('month',3).endOf('month')],
               'Mei': [moment().set('month',4).startOf('month'), moment().set('month',4).endOf('month')],
               'Juni': [moment().set('month',5).startOf('month'), moment().set('month',5).endOf('month')],
               'Juli': [moment().set('month',6).startOf('month'), moment().set('month',6).endOf('month')],
               'Agustus': [moment().set('month',7).startOf('month'), moment().set('month',7).endOf('month')],
               'September': [moment().set('month',8).startOf('month'), moment().set('month',8).endOf('month')],
               'Oktober': [moment().set('month',9).startOf('month'), moment().set('month',9).endOf('month')],
               'November': [moment().set('month',10).startOf('month'), moment().set('month',10).endOf('month')],
               'Desember': [moment().set('month',11).startOf('month'), moment().set('month',11).endOf('month')],
            }
        }, cb);

        cb(start, end);

  



		

	</script>

@endsection