<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Product Calculator </h4>
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

<form id="calculator_form" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
action="<?php echo site_url('product/calculator'); ?>">
     
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Product </label>
        <div class="col-md-7 col-sm-9 col-xs-12">
          <input type="text" readonly id="tname_updates" class="form-control">
          <input type="hidden" id="tid_updates" name="tid">
        </div>
    </div>
    
     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Model </label>
        <div class="col-md-7 col-sm-9 col-xs-12">
          <input type="text" readonly id="tmodel_updates" class="form-control">
        </div>
    </div>
    
     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Dimension (m) </label>
        <div class="col-md-7 col-sm-9 col-xs-12">
            <table>
                <tr>
    <td> <input type="text" id="twidth" name="twidth" class="form-control" placeholder="Width" value="0"> </td>
    <td> <input type="text" id="theight" name="theight" class="form-control" placeholder="Height" value="0"> </td>
    <td> <input type="text" id="theightkm" name="theightkm" class="form-control" placeholder="Fixed Glass" value="0"> </td>
<td> <input type="text" id="theightkm1" name="theightkm1" class="form-control" placeholder="Fixed Glass Bottom" value="0"> </td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Color </label>
        <div class="col-md-6 col-sm-9 col-xs-12" id="colorbox">      
        </div>  
    </div>
    
     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Glass - Type </label>
        <div class="col-md-7 col-sm-9 col-xs-12">
            <table width="100%">
                <tr>  
                  <td> 
            <select name="ctype" id="cglasstype" class="form-control">
                <option value=""> -- </option>
                <option value="SINGLE"> SINGLE </option>
                <option value="DOUBLE"> DOUBLE </option>
                <option value="TRIPLE"> TRIPLE </option>
            </select>
                  </td>
                </tr>
                <tr>
                <td> <div id="glassbox">  </div>  </td>
                </tr>
            </table>
      
        </div>
     </div>
    
          <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Sills </label>
        <div class="col-md-3 col-sm-9 col-xs-12">
         <select name="ckusen" id="ckusen" class="form-control">
<option value="KUSEN"<?php echo set_select('ckusen', 'KUSEN', isset($default['kusen']) && $default['kusen'] == 'KUSEN' ? TRUE : FALSE); ?>> KUSEN
</option>
<option value="SAYAP"<?php echo set_select('ckusen', 'SAYAP', isset($default['kusen']) && $default['kusen'] == 'SAYAP' ? TRUE : FALSE); ?>> SAYAP
</option>
         </select>
        </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 btn-group">
          <button type="submit" class="btn btn-primary">Post</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
      </div>
  </form> 
  <div id="err"></div>
</div>
    
<!-- table content -->
<div class="x_content">
    
    <style type="text/css">
        #stotal{ font-weight: bold; font-size: 14px; color: #C9302C;}
    </style>
    
    <table id="" class="table table-striped jambo_table bulk_action">
    <thead>
    <tr class="headings">
    <th> No </th> <th> Material </th> <th> Size (M) </th> <th> Amount </th></tr>
    </thead>
    
    <tbody id="material_table">
<!--        <tr> <td> 1 </td> <td> Jangkar </td> <td> 12.6 </td> <td> 126.000,- </td> </tr>-->
        
    </tbody>    
      
    <tfoot>
        <tr> <td colspan="3"> </td> <td> <b> Total : </b> <span id="stotal"> 0,- </span> </td> </tr>
    </tfoot>    
        
    </table>
    
</div>
<!-- table content -->
    
</div>
<!-- form add -->

</div>
    <div class="modal-footer">
      
    </div>
  </div>
  
</div>