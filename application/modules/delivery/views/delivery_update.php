<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Delivery - Update </h4>
        </div>
        
 <div class="modal-body"> 
 
 <!-- error div -->
 <div class="alert alert-success success"> </div>
 <div class="alert alert-warning warning"> </div>
 <div class="alert alert-error error"> </div>

 <!-- form edit -->
 <form id="upload_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
 action="<?php echo $form_action_update; ?>" enctype="multipart/form-data">
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Sales No </label>
      <div class="col-md-4 col-sm-5 col-xs-12">
        <input id="tsales_update" readonly class="form-control col-md-3 col-xs-12" type="text" name="tsales">
        <input id="tsales_date" readonly class="form-control col-md-3 col-xs-12" type="text" name="tsales_date">
        <input type="hidden" id="tid_update" name="tid_update">
        <input type="hidden" id="tsid_update" name="tsid_update">
        <input type="hidden" id="tstatus" name="tstatus">
        <input type="hidden" id="tsalesstatus" name="tsalesstatus">
      </div>
    </div>
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Courier </label>
      <div class="col-md-5 col-sm-5 col-xs-12">
       <?php $js = "class='select2_single form-control' id='ccourier' tabindex='-1' style='width:100%;' "; 
       echo form_dropdown('ccourier', $courier, isset($default['courier']) ? $default['courier'] : '', $js); ?>
      </div>
    </div> 
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Coordinate / Distance </label>
      <div class="col-md-5 col-sm-5 col-xs-12">
       
        <table>
            <tr> 
            <td> <input id="tcoordinate" class="form-control col-md-3 col-xs-12" type="text" name="tcoordinate"> </td>
            <td> <button type="button" id="bcalculate" class="btn btn-default" style="margin:2px 0 0 2px;">CALC</button> </td>
            </tr>
            <tr> <td> <input id="tdistance" readonly class="form-control col-md-3 col-xs-12" type="text" name="tdistance"> </td> </tr>
        </table>
      </div>
    </div>
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Address </label>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <textarea cols="55" name="taddress" id="taddress" rows="3" style="width:100%;"></textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Amount </label>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="tamount" readonly class="form-control col-md-3 col-xs-12" type="text" name="tamount">
      </div>
    </div>
     
      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 btn-group">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
      </div>
  </form> 
  <!-- form edit -->
  
  </div>
 </div>
</div>