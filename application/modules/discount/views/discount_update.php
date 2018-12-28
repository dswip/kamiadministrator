<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Discount - Update </h4>
        </div>
        
 <div class="modal-body"> 
 
 <!-- error div -->
 <div class="alert alert-success success"> </div>
 <div class="alert alert-warning warning"> </div>
 <div class="alert alert-error error"> </div>

 <!-- form edit -->
 <form id="edit_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
 action="<?php echo $form_action_update; ?>" enctype="multipart/form-data">
     
     <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Name </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea id="tname_update" class="form-control" name="tname" required placeholder="Discount Name"></textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Period </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <table>
            <tr> 
                <td> <input type="text" title="Date" class="form-control" id="ds2" name="tstart" required> </td>
                <td> <input type="text" title="Date" class="form-control" id="ds3" name="tend" required> </td>
            </tr>
        </table>  
      </div>
    </div>
         
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Payment Type </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="cpaymenttype" id="cpaymenttype_update" class="select2_single form-control" style="width:150px;">
           <option value="CASH"> CASH </option>
           <option value="WALLET"> WALLET </option>
         </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Type </label>
      <div class="col-md-5 col-sm-6 col-xs-12">
         <select name="ctype" id="ctype_update" class="form-control" style="width:150px;">
           <option value="PERIOD"> PERIOD </option>
           <option value="REGULAR"> REGULAR </option>
         </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Min-Amount </label>
      <div class="col-md-4 col-sm-6 col-xs-12">
<input type="number" title="Minimum Amount" class="form-control" id="tminorder_update" name="tminorder" placeholder="Minimum Order">
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Percentage (%) </label>
      <div class="col-md-2 col-sm-6 col-xs-12">
<input type="number" max="100" title="Percentage" class="form-control" id="tpercent_update" name="tpercent" placeholder="%" step="0.1">
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