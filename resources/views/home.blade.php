@extends('layouts.app')

@section('content')
    {!! Form::open(['method' => 'get']) !!}
        <div class="row">
            <div class="col-xs-6 col-md-2 form-group">
                {!! Form::label('req_date','Date',['class' => 'control-label']) !!}
                {!! Form::text('req_date', old('req_date', $now_date), ['class' => 'form-control date', 'placeholder' => '']) !!}
            </div>
            <div class="col-xs-6">
                <label class="control-label">&nbsp;</label><br>
                {!! Form::submit('Select',['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}
    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-blue"><i class="fa fa-car"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Vehicles</span>
                <span class="info-box-number"> {{ $today_sales_no }}</span>
                <span class="info-box-number"> 
                    <i class="fa fa-car"></i> {{ $today_sales_no_mobil }} &nbsp &nbsp
                    <i class="fa fa-motorcycle"></i> {{ $today_sales_no_motor }} 
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
                <span class="info-box-number">{{ number_format($today_expense_dollar, 0)}}</span>            
                    
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-6">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Today Sales</span>
                <span class="info-box-number">{{ number_format($today_sales_dollar, 0)}}</span>
                <span class="info-box-number">
                    <i class="fa fa-car"></i> <strong>{{ number_format($today_sales_dollar_mobil, 0) }}</strong> &nbsp &nbsp
                    <i class="fa fa-motorcycle"></i> <strong> {{ number_format($today_sales_dollar_motor, 0) }} </strong>  &nbsp &nbsp
                    <i class="fa fa-credit-card"></i> <strong> {{ number_format($today_sales_debit, 0) }} &nbsp &nbsp
                    <i class="fa fa-ticket"></i> <strong> {{ $today_sales_no_voucher }} </strong>  
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
                @if( sizeof($carwash_no)>0)
                <span class="info-box-number">
                    <i class="fa fa-car"></i>  &nbsp
                    {{ number_format($carwash_dollar[sizeof($carwash_dollar)-1],0) . " (" . number_format($carwash_no[sizeof($carwash_no)-1], 0) .")"}}
                </span>
                <span class="info-box-number"> 
                    <i class="fa fa-motorcycle"></i> &nbsp
                    {{ number_format($bikewash_dollar[sizeof($bikewash_dollar)-1],0) ." (" . $bikewash_no[sizeof($bikewash_no)-1] .")"}}
                </span>
                @endif
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-yellow"><i class="fa fa-paint-brush"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Wax</span>
                @if( sizeof($wax_no)>0)
                <span class="info-box-number">{{ number_format($wax_dollar[sizeof($wax_dollar)-1],0) }}</span>
                <span class="info-box-number"><i class="fa fa-car"></i> {{ number_format($wax_no[sizeof($wax_no)-1], 0) }}</span>
                @endif
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-aqua"><i class="fa fa-camera"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Detailing</span>
                <!-- @if( sizeof($today_sales_detailing)>0) -->
                <span class="info-box-number">{{ number_format($today_sales_detailing,0) }}</span>
                <span class="info-box-number"><i class="fa fa-car"></i> {{ $today_sales_no_detailing }}</span>
                <!-- @endif -->
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->
              <span class="info-box-icon bg-maroon"><i class="fa fa-ticket"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">OTHERS</span>
                @if( sizeof($carwash_no)>0)
                <span class="info-box-number">
                    {{ number_format($today_sales_voucher + $today_sales_etc + $today_sales_fnb) }}
                </span>
                <span class="info-box-number"> 
                    <i class="fa fa-ticket"></i> {{ $today_sales_voucher/1000 }}K  &nbsp &nbsp
                    <i class="fa fa-glass"></i> {{ $today_sales_fnb/1000 }}K 
                </span>
                @endif
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
                <canvas id="barChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

          
          <!-- /.box -->

          <!-- DONUT CHART -->
              <!-- <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Donut Chart</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button> -->
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                  <!-- </div>
                </div>
                <div class="box-body">
                  <canvas id="pieChart" style="height:250px"></canvas>
                </div> -->
                <!-- /.box-body -->
              <!-- </div> -->
              <!-- /.box -->
    </div>

     <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Sales - Last 14 Days</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart" style="height:250px"></canvas>
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
    <script>
  $(function () {
    var date_labels = {!! json_encode($date) !!}
    var sales_no = {{ json_encode($sales_no) }}
    var sales_dollar = {{ json_encode($sales_dollar) }}
    var wax_no = {{ json_encode($wax_no) }}
    var hour = {!! json_encode($hour) !!}
    var intra_sales_no = {{ json_encode($intra_sales_no) }}
    var intra_wax_no = {{ json_encode($intra_wax_no) }}
    var week_date_labels = {!! json_encode($week_date) !!}
    var weekly_wax_no = {{ json_encode($weekly_wax_no) }}
    var weekly_sales_no = {{ json_encode($weekly_sales_no) }}
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    //--------------
    //- AREA CHART -
    //--------------
    // Get context with jQuery - using jQuery's .get() method.
    // var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    // var areaChart = new Chart(areaChartCanvas);
    var areaChartData = {
      // labels: ["January", "February", "March", "April", "May", "June", "July"],
      labels: date_labels,
      datasets: [
        {
          label: "Sales",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: sales_dollar
        }
      ]
    };
    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      scaleLabel:
        function(label){return  label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");},
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      tooltips: {
                enabled: true,
                mode: 'single',
                callbacks: {
                    label: function(tooltipItems, data) { 
                        return tooltipItems.yLabel + ' €';
                    }
                }
            },
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };
    //Create the line chart
    // areaChart.Line(areaChartData, areaChartOptions);
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
    var lineChartOptions = areaChartOptions;
    lineChartOptions.datasetFill = false;
    lineChart.Bar(areaChartData, lineChartOptions);
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    // var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    // var pieChart = new Chart(pieChartCanvas);
    // var PieData = [
    //   {
    //     value: 700,
    //     color: "#f56954",
    //     highlight: "#f56954",
    //     label: "Chrome"
    //   },
    //   {
    //     value: 500,
    //     color: "#00a65a",
    //     highlight: "#00a65a",
    //     label: "IE"
    //   },
    //   {
    //     value: 400,
    //     color: "#f39c12",
    //     highlight: "#f39c12",
    //     label: "FireFox"
    //   },
    //   {
    //     value: 600,
    //     color: "#00c0ef",
    //     highlight: "#00c0ef",
    //     label: "Safari"
    //   },
    //   {
    //     value: 300,
    //     color: "#3c8dbc",
    //     highlight: "#3c8dbc",
    //     label: "Opera"
    //   },
    //   {
    //     value: 100,
    //     color: "#d2d6de",
    //     highlight: "#d2d6de",
    //     label: "Navigator"
    //   }
    // ];
    // var PieData = [];
    // for (var i = pie_data.length - 1; i >= 0; i--) {
    //     PieData.push({value: pie_data[i]});
    // }
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // pieChart.Doughnut(PieData, pieOptions);


    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    // var barChartData = areaChartData;
    var barChartData = {
          labels: date_labels,
          datasets: [
            {
              label: "Tot. Vehicles",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: sales_no
            }
            ,
            {
              label: "Wax",
              fillColor: "rgba(60,141,188,0.9)",
              strokeColor: "rgba(60,141,188,0.8)",
              pointColor: "#3b8bba",
              pointStrokeColor: "rgba(60,141,188,1)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(60,141,188,1)",
              data: wax_no
            }
          ]
    };
    barChartData.datasets[0].fillColor = "#00a65a";
    barChartData.datasets[0].strokeColor = "#00a65a";
    barChartData.datasets[0].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };
    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);

    var barChartCanvas2 = $("#barChart2").get(0).getContext("2d");
    var barChart2 = new Chart(barChartCanvas2);
    var barChartData2 = {
          labels: hour,
          datasets: [
            {
              label: "Vehicles",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: intra_sales_no
            }
            ,
            {
              label: "Wax",
              fillColor: "rgba(60,141,188,0.9)",
              strokeColor: "rgba(60,141,188,0.8)",
              pointColor: "#3b8bba",
              pointStrokeColor: "rgba(60,141,188,1)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(60,141,188,1)",
              data: intra_wax_no
            }
          ]
    };
    barChartData2.datasets[0].fillColor = "#00a65a";
    barChartData2.datasets[0].strokeColor = "#00a65a";
    barChartData2.datasets[0].pointColor = "#00a65a";
    barChart2.Bar(barChartData2, barChartOptions);

    var barChartCanvas3 = $("#barChart3").get(0).getContext("2d");
    var barChart3 = new Chart(barChartCanvas3);
    var barChartData3 = {
          labels: week_date_labels,
          datasets: [
            {
              label: "Vehicles",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: weekly_sales_no
            }
            ,
            {
              label: "Wax",
              fillColor: "rgba(60,141,188,0.9)",
              strokeColor: "rgba(60,141,188,0.8)",
              pointColor: "#3b8bba",
              pointStrokeColor: "rgba(60,141,188,1)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(60,141,188,1)",
              data: weekly_wax_no
            }
          ]
    };
    barChartData3.datasets[0].fillColor = "#00a65a";
    barChartData3.datasets[0].strokeColor = "#00a65a";
    barChartData3.datasets[0].pointColor = "#00a65a";
    barChart3.Bar(barChartData3, barChartOptions);

  });

        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });
</script>
@endsection
