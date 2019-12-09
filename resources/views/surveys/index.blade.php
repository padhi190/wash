@extends('layouts.app')

@section('content')
    <h3 class="page-title"><i class="fa fa-list-alt"></i> Survey Results</h3>
    <br>
    
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            {!! Form::select('survey_template_id', $survey_template_id, 1, ['class' => 'form-control select', 'id' => 'survey_template_select']) !!}
        </div>
    </div>
    <p>
        <br><span id="q1">Q1</span><span id="q1_avg">Q1</span><br>
        <span id="q2">Q2</span><span id="q2_avg">Q1</span><br>
        <span id="q3">Q3</span><span id="q3_avg">Q1</span><br>
        <span id="q4">Q4</span><span id="q4_avg">Q1</span><br>
        <span id="q5">Q5</span><span id="q5_avg">Q1</span><br>
        <span id="essay">Essay</span><br><br>
    </p>
    

     <p>
        {{ Form::hidden('startdate', old('startdate', Carbon\Carbon::today()->subDays(14)->format('d-m-Y')), ['id' => 'startdate']) }}
        {{ Form::hidden('enddate', old('enddate', Carbon\Carbon::today()->format('d-m-Y')), ['id' => 'enddate']) }}
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped" id="survey-table">
                <thead>
                    <tr>
                        <th>No Bon</th>
                        <th>Kategori</th>
                        <th>Plat No</th>
                        <th>Jumlah</th>
                        <th id="q1">q1</th>
                        <th id="q2">q2</th>
                        <th id="q3">q3</th>
                        <th id="q4">q4</th>
                        <th id="q5">q5</th>
                        <th id="essay">Essay</th>
                        
                        <!-- <th>&nbsp</th> -->
                    </tr>
                </thead>
                
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
        

         $( document ).ready(function() {
            var dtable = $('#survey-table').DataTable({
                    dom: 'Blfrtip',
                    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                    pageLength: '50',
                    responsive: true,
                    searchDelay: 450,
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: {
                        url: '{!! route($ajaxurl) !!}',
                        data: function(d) {
                            d.startdate = $('input[name=startdate]').val();
                            d.enddate = $('input[name=enddate]').val();
                            d.survey_template_id = $('#survey_template_select').val();
                        }
                    },
                    columns: [
                        { data: 'income_id' },
                        { data: 'income_category_name_full', searchable: false, orderable: false },
                        { data: 'license_plate', searchable: false, orderable: false },
                        { data: 'amount', searchable: false, orderable: false },
                        { data: 'q1'},
                        { data: 'q2'},
                        { data: 'q3'},
                        { data: 'q4' },
                        { data: 'q5' },
                        { data: 'essay'},
                    ]
                });
            
            var start = moment().startOf('month');
            var end = moment().endOf('month');

            function cb(start, end) {
                $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                $('input[name=startdate]').val(start.format('D-M-YYYY'));
                $('input[name=enddate]').val(end.format('D-M-YYYY'));
                var date_data = {
                    startdate: $('input[name=startdate]').val(),
                    enddate: $('input[name=enddate]').val(),
                    survey_template_id: $('#survey_template_select').val(), 
                };
                $.ajax({
                    url : "{!! route('loadSurveyStats') !!}",
                    data: date_data,
                    beforeSend: function(){

                    },
                    success: function(result){
                        $('#q1').html('q1 - ' + result['questions']['q1']+' : ');
                        $('#q2').html('q2 - ' +result['questions']['q2']+' : ');
                        $('#q3').html('q3 - ' +result['questions']['q3']+' : ');
                        $('#q4').html('q4 - ' +result['questions']['q4']+' : ');
                        $('#q5').html('q5 - ' +result['questions']['q5']+' : ');
                        $('#essay').html('Essay - ' +result['questions']['essay']);
                        $('#q1_avg').number(result['stats'][0]['avg_q1'],2);
                        $('#q2_avg').number(result['stats'][0]['avg_q2'],2);
                        $('#q3_avg').number(result['stats'][0]['avg_q3'],2);
                        $('#q4_avg').number(result['stats'][0]['avg_q4'],2);
                        $('#q5_avg').number(result['stats'][0]['avg_q5'],2);

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
            $("#survey_template_select").on("change", function(){
                // cb($('input[name=startdate]').val(), $('input[name=enddate]').val());
                enddate = moment($('input[name=enddate]').val(), "DD-MM-YYYY");
                startdate = moment($('input[name=startdate]').val(), "DD-MM-YYYY");
                // alert(this.value);
                cb(startdate, enddate);
            });
        });

    </script>
@endsection