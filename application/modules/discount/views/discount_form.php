<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Add New Discount </h4>
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

<form id="upload_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo $form_action; ?>" >
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Name </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea id="tname" class="form-control" name="tname" required placeholder="Discount Name"></textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Period </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" title="Date" class="form-control" id="d1" name="tdates" required>
      </div>
    </div>
        
     <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Payment Type </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="cpaymenttype" id="cpaymenttype" class="form-control" style="width:150px;">
           <option value="CASH"> CASH </option>
           <option value="WALLET"> WALLET </option>
         </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Type </label>
      <div class="col-md-5 col-sm-6 col-xs-12">
         <select name="ctype" id="ctype" class="select2_single form-control" style="width:150px;">
           <option value="PERIOD"> PERIOD </option>
           <option value="REGULAR"> REGULAR </option>
         </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Min-Amount </label>
      <div class="col-md-4 col-sm-6 col-xs-12">
<input type="number" title="Minimum Amount" class="form-control" id="tminorder" name="tminorder" placeholder="Minimum Order">
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Percentage (%) </label>
      <div class="col-md-2 col-sm-6 col-xs-12">
<input type="number" max="100" title="Percentage" class="form-control" id="tpercent" name="tpercent" placeholder="%" step="0.1">
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