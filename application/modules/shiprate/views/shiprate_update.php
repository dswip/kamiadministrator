<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Edit - Delivery Rate </h4>
</div>
<div class="modal-body">
 
 <!-- error div -->
 <div class="alert alert-success success"> </div>
 <div class="alert alert-warning warning"> </div>
 <div class="alert alert-error error"> </div>
 
 <!-- form add -->
<div class="x_panel" >
<div class="x_title">
  
  <div class="clearfix"></div> 
</div>
<div class="x_content">

<form id="edit_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST"
      action="<?php echo $form_action_update; ?>" >
     
   <div class="form-group">
       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Period </label>
       <div class="col-md-6 col-sm-6 col-xs-12">
          <table>
              
              <tr>
 <td> <?php $js = "class='form-control' id='ctime1_update' tabindex='-1' style='width:65px; margin-right:5px;' "; 
      echo form_dropdown('ctime1', $combo_time, isset($default['time']) ? $default['time'] : '', $js); ?>
 </td>
 <td>
      <?php $js = "class='form-control' id='ctime2_update' tabindex='-1' style='width:65px;' "; 
	  echo form_dropdown('ctime2', $combo_time, isset($default['time']) ? $default['time'] : '', $js); ?> 
 </td>
              </tr>
          </table>
       </div>
    </div>
    
    <div class="form-group">
       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Distance </label>
       <div class="col-md-6 col-sm-6 col-xs-12">
          <table>
              
              <tr>
 <td> <input type="text" name="tdistance1" id="tdistance1_update" class="form-control" style="width:45px; margin-right:5px;" maxlength="2"> </td>
 <td> <input type="text" name="tdistance2" id="tdistance2_update" class="form-control" style="width:45px;" maxlength="2"> </td>
              </tr>
          </table>
       </div>
    </div>
    
    <div class="form-group">
       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Type </label>
       <div class="col-md-6 col-sm-6 col-xs-12">
          <select name="cpayment" id="cpayment_update" class="form-control" style="width:120px;">
            <option value="CASH"> CASH </option>
            <option value="WALLET"> WALLET </option>
          </select>
       </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Minimum Order </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="number" class="form-control" name="tminimum" id="tminimum_update" style="width:120px;" placeholder="Minimum">
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Rate </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="number" class="form-control" name="trate" id="trate_update" style="width:120px;" placeholder="Rate">
      </div>
    </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 btn-group">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" id="bclose" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="reset" id="breset" class="btn btn-warning">Reset</button>
          </div>
      </div>
  </form> 

</div>
</div>
<!-- form add -->

</div>
    <div class="modal-footer"> </div>
</div>
  
</div>