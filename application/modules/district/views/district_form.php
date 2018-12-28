<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Add Shipping Rate </h4>
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

<form id="upload_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST"
      action="<?php echo $form_action; ?>" >
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> City / Region </label>
      <div class="col-md-8 col-sm-6 col-xs-12">
          
          <table>
              <tr> 
                  <td>
          <?php $js = "class='select2_single form-control' id='ccity' tabindex='-1' style='width:330px; margin-bottom:15px;' "; 
          echo form_dropdown('ccity', $city, isset($default['city']) ? $default['city'] : '', $js); ?> <br>
                  </td> 
              </tr>
              
              <tr> <td> <div id="dbox" style="margin-top:10px;"></div> </td> </tr>
          </table>
          
      </div>
    </div>
    
    <div class="form-group">
       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Courrier <span class="required">*</span></label>
       <div class="col-md-8 col-sm-6 col-xs-12">
           
           <table>
               <tr>
                   <td>
           <?php $js = "class='form-control' id='' tabindex='-1' style='width:150px; margin-right:10px;' "; 
	       echo form_dropdown('ccourrier', $courrier, isset($default['ccourrier']) ? $default['ccourrier'] : '', $js); ?>
                   </td>
                   <td>
                    <input type="text" class="form-control" name="tcourrier" placeholder="New Courrier">
                   </td>
               </tr>
           </table>
           
       </div>
    </div>
    
    <div class="form-group">
       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Type </label>
       <div class="col-md-6 col-sm-6 col-xs-12">
           <select id="ctype" name="ctype" class="form-control" style="width:120px;">
               <option value="dimension"> Dimension </option>
               <option value="weight"> Weight </option>
           </select> 
       </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Rate </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="number" class="form-control" name="trate" style="width:120px;" placeholder="Rate">
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