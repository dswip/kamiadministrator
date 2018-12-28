
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>js/moduljs/topup.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<!-- Date time picker -->
 <script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>css/datetimepicker/bootstrap-datetimepicker.min.js"></script>
 
 <!-- Include Date Range Picker -->
<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datetimepicker/bootstrap-datetimepicker.min.css" />

<style type="text/css">
    
    .normal_p{ text-decoration: line-through; margin: 0;}
    .discount_p { color: red;}
</style>

<!-- bootstrap toogle -->
<!--<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>-->

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('topup/add_process/');?>";
	var sites_edit = "<?php echo site_url('topup/update_process/');?>";
	var sites_del  = "<?php echo site_url('topup/delete/');?>";
	var sites_get  = "<?php echo site_url('topup/update/');?>";
    var sites_primary = "<?php echo site_url('topup/publish/');?>";
    var sites_redeem = "<?php echo site_url('topup/redeem/');?>";
    var sites_ajax  = "<?php echo site_url('topup/');?>";
	var source = "<?php echo $source;?>";
	
</script>

          <div class="row"> 
          
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" >
              
              <!-- xtitle -->
              <div class="x_title">
                
               <h2> Topup Filter </h2>
                
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                </ul>
                
                <div class="clearfix"></div>
              </div>
              <!-- xtitle -->
                
                <div class="x_content">
                
<?php
    
$atts1 = array(
	  'class'      => 'btn btn-primary button_inline',
	  'title'      => 'Customer - List',
	  'width'      => '800',
	  'height'     => '600',
	  'scrollbars' => 'yes',
	  'status'     => 'yes',
	  'resizable'  => 'yes',
	  'screenx'    =>  '\'+((parseInt(screen.width) - 800)/2)+\'',
	  'screeny'    =>  '\'+((parseInt(screen.height) - 600)/2)+\'',
);

?>
           
           <!-- searching form -->
           
           <form id="searchform" class="form-inline">
               
              <div class="form-group">
                <?php $js = "class='select2_single form-control' id='ccust' tabindex='-1' style='min-width:150px;' "; 
			     // echo form_dropdown('ccust', $customer, isset($default['cust']) ? $default['cust'] : '', $js); ?>
                 CU0 <input type="text" class="form-control" name="tcust" id="ccust" readonly style="width:70px;">
                 <?php echo anchor_popup(site_url("customer/get_list/ccust/"), '[ ... ]', $atts1); ?> &nbsp;
              </div>
             
              <div class="form-group">
                <select name="ctype" id="ctype" class="select2_single form-control" style="min-width:150px;">
                   <option value="0"> Cash </option>
                   <option value="1"> Driver </option>
                   <option value="2"> Transfer </option>
                </select>
              </div>       
               
              <div class="form-group">
                <select name="cpublish" id="cpublish" class="select2_single form-control" style="min-width:150px;">
                   <option value="1"> Publish </option>
                   <option value="0"> Unpublish </option>
                </select>
              </div>
              
              <div class="btn-group">
               <button type="submit" class="btn btn-primary button_inline"> Filter </button>
               <button type="reset" onClick="" class="btn btn-success button_inline"> Clear </button>
               <button type="button" onClick="load_data();" class="btn btn-danger button_inline"> Reset </button>
              </div>
          </form> <br>

           
          <!-- searching form --> 
          <form class="form-inline" id="cekallform" method="post" action="<?php echo ! empty($form_action_del) ? $form_action_del : ''; ?>">
                  <!-- table -->
                  
                  <div class="table-responsive">
                    <?php echo ! empty($table) ? $table : ''; ?>            
                  </div>
                  
                  <div class="form-group" id="chkbox">
                    Check All : 
                    <button type="submit" id="cekallbutton" class="btn btn-danger btn-xs">
                       <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </div>
                  <!-- Check All Function -->
                  
          </form>       
             </div>

    <div class="btn-group"> 
               <!-- Trigger the modal with a button --> 
    <button type="button" onClick="resets();" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> 
      <i class="fa fa-plus"></i>&nbsp;Add New 
    </button>
<!--               <a class="btn btn-primary" href="<?php //echo site_url('product/add'); ?>"> <i class="fa fa-plus"></i>&nbsp;Add New </a>-->
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3"> Report  </button>
               
               <!-- links -->
	           <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
               <!-- links -->
    </div>                           
            </div>
          </div>  
    
      
      <!-- Modal - Add Form -->
      <div class="modal fade" id="myModal" role="dialog">
         <?php $this->load->view('topup_form'); ?>    
      </div>
      <!-- Modal - Add Form -->
      
      <!-- Modal Attribute -->
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		 <?php $this->load->view('topup_update'); ?> 
      </div>
      <!-- Modal Attribute -->
      
      
      <!-- Modal - Report Form -->
      <div class="modal fade" id="myModal3" role="dialog">
         <?php $this->load->view('topup_report_panel'); ?>    
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
