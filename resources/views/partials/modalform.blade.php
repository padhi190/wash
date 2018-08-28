<!-- Modal -->
<div class="modal fade" id="{{$formId}}" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 1000px; margin: auto;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{$title}}</h4>
      </div>
      <div class="modal-body" id="formSection">
         
          @yield('formSection')
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>