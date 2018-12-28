
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet" type="text/css">

<style type="text/css">
  a:hover { text-decoration:none;}
</style>

<script src="<?php echo base_url(); ?>js/moduljs/adminmenu.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('adminmenu/add_process/');?>";
	var sites_edit = "<?php echo site_url('adminmenu/update_process/');?>";
	var sites_del  = "<?php echo site_url('adminmenu/delete/');?>";
	var sites_get  = "<?php echo site_url('adminmenu/update/');?>";
	var source = "<?php echo $source;?>";
	
</script>

          <div class="row"> 
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" >
              
              <!-- xtitle -->
              <div class="x_title">
                <h2> Add Admin Menu </h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                </ul>
                
                <div class="clearfix"></div>
              </div>
              <!-- xtitle -->
                
                <div class="x_content">
                      
                  
             <!-- Smart Wizard -->
<div id="wizard" class="form_wizard wizard_horizontal">
  <ul class="wizard_steps">
    <li>
      <a href="#step-1">
        <span class="step_no">1</span>
        <span class="step_descr">
          <small> Primary Details </small>
        </span>
      </a>
    </li>
  </ul>


  <div id="step-1">
    <!-- form -->
    <form class="form-horizontal form-label-left" id="ajaxformdata" method="post" action="<?php echo $form_action; ?>">

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Name </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" class="form-control" id="tname" name="tname" placeholder="Name" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Parent </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?php $js = "class='select2_single form-control' id='cparent' tabindex='-1' style='width:70%;' "; 
	      echo form_dropdown('cparent', $parent, isset($default['parent']) ? $default['parent'] : '', $js); ?>
       </div>
      </div>
      
      <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Component </label>
        <div class="col-md-8 col-sm-6 col-xs-12">
     <?php $js = "class='select2_single form-control' id='cmodul' onChange=\"geturl(this.value, 'turl')\" tabindex='-1' style='width:70%;' "; 
	 echo form_dropdown('cmodul', $modul, isset($default['modul']) ? $default['modul'] : '', $js); ?>
       </div>   
      </div> 
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Url </label>
        <div class="col-md-6 col-sm-6 col-xs-12">          
          <input type="text" title="Url" class="form-control" id="turl" name="turl" required placeholder="Url" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Order </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
			<input type="number" class="form-control" name="tmenuorder" id="tmenuorder" title="Menu Order" placeholder="Order" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Class </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control" name="tclass" id="tclass" title="Class Style" placeholder="Class" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> ID </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control" name="tid" id="tid" title="ID Style" placeholder="ID Style" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Target </label>
        <div class="col-md-2 col-sm-6 col-xs-12">
            <select name="ctarget" id="ctarget" class="form-control" title="Target">
              <option selected="selected" value="_parent"> Parent </option>
              <option value="_blank"> Blank </option>
              <option value="_self"> Self </option>
              <option value="_top"> Top </option>
            </select>
        </div>
      </div>
      
      <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Parent Status </label>
        <div class="col-md-2 col-sm-6 col-xs-12">
         <select name="cstatus" id="cstatus" class="form-control" title="Target">
              <option selected="selected" value="0"> Child </option>
              <option value="1"> Parent </option>
         </select>
        </div>   
      </div> 
      <br>
      
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" class="btn btn-success" onClick="resets();" id="breset">Reset</button>
        </div>
      </div>
      
	</form>
    <!-- end div layer 1 -->
  </div>
  
</div>
<!-- End SmartWizard Content -->     
                      
             </div>
            </div>
            <!-- table panel -->
       		
              <div class="x_panel" >
              
              <!-- xtitle -->
              <div class="x_title">
              <h2> Admin Menu List </h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                </ul>
                
                <div class="clearfix"></div>
              </div>
              <!-- xtitle -->
                
                <div class="x_content">
              
          <form class="form-inline" id="cekallform" method="post" action="<?php echo ! empty($form_action_del) ? $form_action_del : ''; ?>">
                  <!-- table -->
                  
                  <?php echo ! empty($table) ? $table : ''; ?>            
                  
                  <div class="form-group" id="chkbox">
                    Check All : 
                    <button type="submit" id="cekallbutton" class="btn btn-danger btn-xs">
                       <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </div>
                  <!-- Check All Function -->
                  
          </form>       
             </div>
               
               <!-- links -->
	           <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
               <!-- links -->
                             
            </div>
            
                 
            <!-- table panel -->
       </div>
      
    
      <!-- Modal - Add Form -->
      <div class="modal fade" id="myModal" role="dialog">
         <?php //$this->load->view('admin_form'); ?>      
      </div>
      <!-- Modal - Add Form -->
      
      <!-- Modal Edit Form -->
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	     <?php $this->load->view('menu_update'); ?> 
      </div>
      <!-- Modal Edit Form -->
      
      <!-- Modal - Report Form -->
      <div class="modal fade" id="myModal3" role="dialog">
         <?php /*$this->load->view('category_report');*/ ?>    
      </div>
      <!-- Modal - Report Form -->
      
      <script src="<?php echo base_url(); ?>js/icheck/icheck.min.js"></script>
      
       <!-- Datatables JS -->
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.scroller.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.js"></script>
    
    <!-- jQuery Smart Wizard -->
    <script src="<?php echo base_url(); ?>js/wizard/jquery.smartWizard.js"></script>
        
        <!-- jQuery Smart Wizard -->
    <script>
      $(document).ready(function() {
        $('#wizard').smartWizard();

        $('#wizard_verticle').smartWizard({
          transitionEffect: 'slide'
        });

/*        $('.buttonNext').addClass('btn btn-success');
        $('.buttonPrevious').addClass('btn btn-primary');
        $('.buttonFinish').addClass('btn btn-default');*/
      });
    </script>
    <!-- /jQuery Smart Wizard -->
