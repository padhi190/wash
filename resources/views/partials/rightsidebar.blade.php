@inject('request', 'Illuminate\Http\Request')
<!-- The Right Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Content of the sidebar goes here -->
  <section class="sidebar" style="height: 100%">
  	<ol class="sidebar-menu">
	  @if($request->segment(1) == 'incomes' && $request->segment(2) == 'create')
	  <li>{!! Form::select('vehicle_id', ["" => "Cari"], null, ['class' => 'form-control cari']) !!}</li>
	  <li><a href="#" onclick="sendData(this)">{{$last_bon}}</a></li>
	  @endif
	</ol>
  
</section>
</aside>
<!-- The sidebar's background -->
<!-- This div must placed right after the sidebar for it to work-->
<div class="control-sidebar-bg"></div>