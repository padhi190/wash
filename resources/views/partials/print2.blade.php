<!-- Modal -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Print Bon</h4>
      </div>
      <div class="modal-body" id="printSection" style="margin:0; padding:0; align:center">
          <div style="text-align:center; font-size:18px; " >
            <img src="{{asset('img/logo.jpeg')}}" style="width:80px">
            <p ><strong>Wash, Inc</strong></p>
            <p>{{Session::get('branch')->address}}</p>
            <p>--------------------------------</p>
          </div>
          @yield('printSection')
          <div class="footer" style="text-align:center; font-size:18px; margin-bottom:0mm">
            <p>--------------------------------</p>
            <p>Tel: {{Session::get('branch')->phone}}</p>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="window.print();" >Print</button>
      </div>
    </div>
  </div>
</div>