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
	<div class="panel panel-default">
        <div class="panel-heading bg-yellow-gradient">
            <h4 class="panel-title" style="text-align:center">
            	<strong>
            	<span>Wash, Inc - {{ Session::get('branch_name') }}</span><br>
                <span data-toggle="collapse" data-parent="#accordion1">Income Statement
                </span>
                <br>
                <span id="period"></span>
                </strong>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse">
            <div class="panel-body">
                <div class="panel-body">
                    <h3>Revenue <span class="pull-right" id="sales_dollar">0</span></h3>
                    <div class="panel-group" id="accordion21" style="font-size:16px">
                        <div class="panel">
                            <a data-toggle="collapse" href="#collapseCarwash" id="carwash">Carwash <span class="pull-right" id="carwash_dollar">0</span>
                            </a>
                            <div id="collapseCarwash" class="panel-collapse collapse">
                                <div class="panel-body" id="carwash_details">

                                </div>
                            </div>
                        </div>

                        <div class="panel ">
                            <a data-toggle="collapse"  href="#collapseBikewash">Bikewash <span id="bikewash_dollar" class="pull-right">0</span>
                            </a>
                            <div id="collapseBikewash" class="panel-collapse collapse">
                                <div class="panel-body" id="bikewash_details">
                                </div>
                            </div>
                        </div>

                        <div class="panel ">
                            <a data-toggle="collapse"  href="#collapseWax">Wax <span id="wax_dollar" class="pull-right">0</span>
                            </a>
                            <div id="collapseWax" class="panel-collapse collapse">
                                <div class="panel-body" id="wax_details">
                                </div>
                            </div>
                        </div>

                        <div class="panel ">
                            <a data-toggle="collapse"  href="#collapseVoucher">Voucher <span id="voucher_dollar" class="pull-right">0</span>
                            </a>
                            <div id="collapseVoucher" class="panel-collapse collapse">
                                <div class="panel-body" id="voucher_details">
                                </div>
                            </div>
                        </div>

                        <div class="panel ">
                            <a data-toggle="collapse"  href="#collapseDetailing">Detailing <span id="detailing_dollar" class="pull-right">0</span>
                            </a>
                            <div id="collapseDetailing" class="panel-collapse collapse">
                                <div class="panel-body" id="detailing_details">
                                </div>
                            </div>
                        </div>

                        <div class="panel ">
                            <a data-toggle="collapse"  href="#collapseFnBProfit">F&B Profit <span id="fnb_profit" class="pull-right">0</span>
                            </a>
                            <div id="collapseFnBProfit" class="panel-collapse collapse">
                            	<div class="panel">
	                                <a data-toggle="collapse" href="#collapseFnBRevenue" class="panel-body">
	                                	F&B Revenue	<span id="fnb_dollar" class="pull-right">0</span>
	                                </a>
	                                <div id="collapseFnBRevenue" class="panel-collapse collapse">
	                                	<div class="panel-body" id="fnb_details"></div>
	                                </div>
                                </div>

                                <div class="panel">
	                                <a data-toggle="collapse" href="#collapseFnBRestock" class="panel-body">
	                                	F&B Restock	<span id="fnb_restock_total" class="pull-right">0</span><span class="pull-right">-</span>
	                                </a>
	                                <div id="collapseFnBRestock" class="panel-collapse collapse">
	                                	<div class="panel-body" id="fnb_restock_details"></div>
	                                </div>
                                </div>

                            </div>
                        </div>

                        <div class="panel ">
                            <a data-toggle="collapse"  href="#collapseLain2">Lain-lain <span id="etc_dollar" class="pull-right">0</span>
                            </a>
                            <div id="collapseLain2" class="panel-collapse collapse">
                                <div class="panel-body" id="lain2_details">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="panel-body">
                	<h3>Expense <span class="pull-right" id="expense_dollar">0</span></h3>
                	<div class="panel-group" id="expense_category" style="font-size:16px">
                		
                	</div>
                </div>

                <div class="panel-body">
                	<h3>Profit <span class="pull-right" id="total_profit">0</span></h3>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('javascript')
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> 
	<script>
		var start = moment().startOf('month');
        var end = moment().endOf('month');

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
                    url: "{!! route('loadIncomeStatementData') !!}",
                    data: date_data,
                    beforeSend: function(){
                    	$('#expense_category').html('Processing...');
                    },
                    success: function(result){
                       $("#sales_dollar").number(result['sales_dollar']);
                       $("#carwash_dollar").number(result['carwash_dollar']);
                       $("#bikewash_dollar").number(result['bikewash_dollar']);
                       $("#wax_dollar").number(result['wax_dollar']);
                       $("#detailing_dollar").number(result['detailing_dollar']);
                       $("#fnb_profit").number(result['fnb_profit']);
                       $("#fnb_dollar").number(result['fnb_dollar']);
                       $("#fnb_restock_total").number(result['fnb_restock_total']);
                       $("#etc_dollar").number(result['etc_dollar']);
                       $("#voucher_dollar").number(result['voucher_dollar']);
                       $("#expense_dollar").number(result['expense_dollar']);
                       $("#total_profit").number(result['total_profit']);

                       $('#expense_category').html('');
                       $.each(result['expenses'],function(key,value){
                       		// alert(value['parent_category']);
                       		$parcat_string = value['parent_category'].split(' ').join('');
                       		$append1 = '<div class="panel"> <a data-toggle="collapse" href="#collapse' +$parcat_string;
                       		$append1 = $append1 + '">' + value['parent_category'] + '<span class="pull-right" id="' + $parcat_string;
                       		$append1 = $append1 + '">' + $.number(value['amount']) + '</span> </a> </div>';
                       		$append1 = $append1 + '<div id="collapse' +$parcat_string + '" class="panel-collapse collapse"> <div class="panel-body" id="';
                       		$append1 = $append1 + $parcat_string + '_details"></div></div>';

                       		$('#expense_category').append($append1);
                       });

                       $.each(result['expenses'],function(key,value){
                       	   $parcat_string = value['parent_category'].split(' ').join('');
	                       $('#collapse'+$parcat_string).on('show.bs.collapse', function() {
	                       		  $parcat_string = value['parent_category'].split(' ').join('');
            								  // alert($parcat_string);
                              $details=$parcat_string+'_details';
                              sendExpenseDataByCategory(value['parent_category'], $details);
            								});
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

        $('#collapseCarwash').on('show.bs.collapse', function() {
		  sendIncomeDataRequest("carwash", 'carwash_details');
		});

		$('#collapseBikewash').on('show.bs.collapse', function() {
		  sendIncomeDataRequest("bikewash", 'bikewash_details');
		});

		$('#collapseWax').on('show.bs.collapse', function() {
		  sendIncomeDataRequest("wax", 'wax_details');
		});

		$('#collapseDetailing').on('show.bs.collapse', function() {
		  sendIncomeDataRequest("detailing", 'detailing_details');
		});

		$('#collapseFnBRevenue').on('show.bs.collapse', function() {
		  sendIncomeDataRequest("fnb", 'fnb_details');
		});

		$('#collapseLain2').on('show.bs.collapse', function() {
		  sendIncomeDataRequest("lain2", 'lain2_details');
		});

    $('#collapseVoucher').on('show.bs.collapse', function() {
      sendIncomeDataRequest("voucher", 'voucher_details');
    });



    $('#collapseFnBRestock').on('show.bs.collapse', function() {
      sendExpenseDataByCategory("Restock Minuman/Rokok", 'fnb_restock_details');
    });

		

  //       $(document).on("click", "#carwash", function() {
		//   sendIncomeDataRequest(1, 'carwash_details');
		// });

		function sendIncomeDataRequest(category, target_id)
		{
			var date_data = {
                startdate: $('input[name=startdate]').val(),
                enddate: $('input[name=enddate]').val(),
                category: category
            };
			$.ajax(
                {
                    url: "{!! route('loadIncomeDataByDate') !!}",
                    data: date_data,
                    beforeSend: function(){
                    	$('#' + target_id).html('Processing..');
                    }, 
                    success: function(result){
                    	$('#' + target_id).html('');
                    	$.each(result.data, function(key, value){
                    		var amount = $.number(value['amount']);
                    		var date = moment(value['date']).format('D-MMM-YYYY (dddd)');
                    		$('#' + target_id).append('<span>'+date + ' <span class="pull-right">' + amount + '</span></span><br>');
                    	});
                       // $('#' + target_id).append(result.data[0].amount);

                    }
                });
		}

    function sendExpenseDataByCategory(category, target_id)
    {
      var date_data = {
                startdate: $('input[name=startdate]').val(),
                enddate: $('input[name=enddate]').val(),
                category: category
            };
      $.ajax(
                {
                    url: "{!! route('loadExpenseDataByCategory') !!}",
                    data: date_data,
                    beforeSend: function(){
                      $('#' + target_id).html('Processing..');
                    }, 
                    success: function(result){
                      $('#' + target_id).html('');
                      $.each(result.data, function(key, value){
                        var amount = $.number(value['amount']);
                        var date = moment(value['date']).format('D-MMM-YYYY (dddd)');
                        $('#' + target_id).append('<span>'+date + ' - ' + value['name'] + ' ' + value['signature']  + ' ' + value['note'] +  ' <span class="pull-right">' + amount + '</span></span><br>');
                      });
                       // $('#' + target_id).append(result.data[0].amount);

                    }
                });
    }

	</script>

@endsection