@extends('layouts.app')

@section('content')
	
	<p>Select Period</p>
	<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
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
                    <div class="panel-group" id="accordion21">
                        <div class="panel">
                            <a data-toggle="collapse" href="#collapseOneOne">Carwash <span class="pull-right" id="carwash_dollar">Jumlah</span>
                            </a>
                            <div id="collapseOneOne" class="panel-collapse collapse">
                                <div class="panel-body">Details 1</div>
                            </div>
                        </div>
                        <div class="panel ">
                            <a data-toggle="collapse"  href="#collapseTwoTwo">View details 2.2 &raquo;
                            </a>
                            <div id="collapseTwoTwo" class="panel-collapse collapse">
                                <div class="panel-body">Details 2</div>
                            </div>
                        </div>
                    </div>
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
                    success: function(result){
                       $("#sales_dollar").number(result['sales_dollar']);
                       $("#carwash_dollar").number(result['carwash_dollar']);

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