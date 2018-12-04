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

    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Cash Flow</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                  <th>Date</th>
                  <th style="text-align:right">Penjualan</th>
                  <th style="text-align:right">Pengeluaran</th>
                  <th style="text-align:right">Prive</th>
                  <th style="text-align:right">Kas Masuk</th>
                  <th style="text-align:right">Total Kas</th>
                </tr>
                </thead>
                <tbody id="content">
                  
                </tbody>
            </table>
            </div>
            <!-- /.box-body -->
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
                    url: "{!! route('loadCashFlowData') !!}",
                    data: date_data,
                    beforeSend: function(){
                      $('#content').html('Processing...');
                    },
                    success: function(result){
                      $('#content').html('');
                      $.each(result.data, function(key, value){
                        var cash_expense = $.number(value['cash_expense']);
                        var cash_income = $.number(value['cash_income']);
                        var transfer_out = $.number(value['transfer_out']);
                        var kas_masuk = $.number(value['cash_income'] - value['cash_expense']);
                        var kas = $.number(value['kas']);
                        var prive_out = '-';
                        if (value['transfer_out'] != null)
                        {
                          prive_out = transfer_out + ' (' + value['transfer_out_note'] + ')';
                        }
                        var date = moment(value['date']).format('D-MMM-YYYY (dddd)');

                        var build = [
                          '<tr><td>' + date + '</td>',
                          '<td style="text-align:right">' + cash_income + '</td>',
                          '<td style="text-align:right">' + cash_expense + '</td>',
                          '<td style="text-align:right">' +  prive_out + '</td>',
                          '<td style="text-align:right">' +  kas_masuk + '</td>',
                          '<td style="text-align:right; font-weight:bold">' +  kas + '</td>',
                          '</tr>'
                          ].join('\n');
                        $('#content').append(build);
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