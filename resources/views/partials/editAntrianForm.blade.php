<!-- Modal -->
<div class="modal fade" id="{{$formId}}"  role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 500px; margin: auto;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{$title}}</h4>
      </div>
      <div class="modal-body">
        
        {!! Form::open(array('route' => array('antrians.update', 'test'), 'method' => 'PUT', 'id' => 'antriForm')); !!}
            
        <h4 class="modal-title">Edit</h4>
        <div class="panel panel-default">
            
          <div class="panel-body">
            {{ Form::hidden('branch_id', Session::get('branch_id'))}}

            <div class="row">
              <div class="col-md-12 form-group">
                {!! Form::label('vehicle_id', 'Cari Kendaraan*', ['class' => 'control-label']) !!}
                {!! Form::select('vehicle_id', ["" => "Cari"], null, ['class' => 'form-control vehicle_search', 'id' => 'vehicle_search', 'style' => 'width:100%']) !!}
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 form-group">
                {!! Form::label('license_plate', 'Plat No.*', ['class' => 'control-label']) !!}
                {!! Form::text('license_plate', old('license_plate'), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:uppercase', 'id'=>'antrian_license_plate']) !!}
              </div>

              <div class="col-md-6 form-group">
                {!! Form::label('brand', 'Brand', ['class' => 'control-label']) !!}
                {!! Form::text('brand', old('brand'), ['class' => 'form-control','style' => 'text-transform:capitalize', 'placeholder' => '', 'id' => 'antrian_brand']) !!}
              </div>

            </div>


            <div class="row">
              <div class="col-md-6 form-group">
                {!! Form::label('model', 'Model', ['class' => 'control-label']) !!}
                {!! Form::text('model', old('model'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '', 'id' => 'antrian_model']) !!}
              </div>

              <div class="col-md-6 form-group">
                {!! Form::label('color', 'Warna', ['class' => 'control-label']) !!}
                {!! Form::text('color', old('color'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '', 'id' => 'antrian_color']) !!}
              </div>

            </div>

            <div class="row">
              <div class="col-md-6 form-group">
                {!! Form::label('type', 'Type*', ['class' => 'control-label']) !!}
                <br>
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label id="antrian_mobil" class="btn btn-primary active">
                        <input type="radio" name="type" value='mobil' autocomplete="off" checked> Mobil
                    </label>
                    <label id="antrian_motor" class="btn btn-primary">
                        <input type="radio" name="type" value='motor' autocomplete="off" > Motor
                    </label>
                </div>  
              </div>

              <div class="col-md-6 form-group">
                    {!! Form::label('arrival_time', 'Tanggal*', ['class' => 'control-label']) !!}
                    {!! Form::text('arrival_time', old('arrival_time', Carbon\Carbon::now()->format('d-m-Y H:i')), ['class' => 'form-control datetime', 'placeholder' => '', 'id'=>'datepicker']) !!}
              </div>

            </div>

            <div class="row">
              <div class="col-md-6 form-group">
                {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
                <br>
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label id="antrian_tunggu" class="btn btn-primary active">
                        <input type="radio" name="status" value='Ditunggu' autocomplete="off" checked> Tunggu
                    </label>
                    <label id="antrian_tinggal" class="btn btn-primary">
                        <input type="radio" name="status" value='Ditinggal' autocomplete="off" > Tinggal
                    </label>
                </div>  
              </div>

              <div class="col-md-6 form-group">
                {!! Form::label('customer', 'Customer', ['class' => 'control-label']) !!}
                <br>
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label id="antrian_new" class="btn btn-primary active">
                        <input type="radio" name="customer" value='New' autocomplete="off" checked> Baru
                    </label>
                    <label id="antrian_existing" class="btn btn-primary">
                        <input type="radio" name="customer" value='Existing' autocomplete="off" > Lama
                    </label>
                </div>  
              </div>

            </div>

            <div class="row">
              <div class="col-md-6 form-group">
                {!! Form::label('name', 'Nama', ['class' => 'control-label']) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '', 'id' => 'antrian_name']) !!}
              </div>

              <div class="col-md-6 form-group">
                {!! Form::label('phone', 'Phone', ['class' => 'control-label']) !!}
                {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '', 'id' => 'antrian_phone']) !!}
              </div>

            </div>

            
          </div>
        </div>
         
          
         
      </div>
      <div class="modal-footer">
        {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger btn-lg']) !!}
        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>