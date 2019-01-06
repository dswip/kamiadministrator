
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>js/moduljs/sales.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<!--canvas js-->
<script type="text/javascript" src="<?php echo base_url().'js-old/' ?>canvasjs.min.js"></script>

<!-- Date time picker -->
 <script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
 <!-- Include Date Range Picker -->
<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<style type="text/css">
    
    .normal_p{ text-decoration: line-through; margin: 0;}
    .discount_p { color: red;}
</style>

<!-- bootstrap toogle -->
<!--<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>-->

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('sales/add_process/');?>";
	var sites_edit = "<?php echo site_url('sales/update_process/');?>";
	var sites_del  = "<?php echo site_url('sales/delete/');?>";
	var sites_get  = "<?php echo site_url('sales/update/');?>";
    var sites_confirmation  = "<?php echo site_url('sales/confirmation/');?>";
    var sites_print_invoice  = "<?php echo site_url('sales/invoice/');?>";
    var sites_primary   = "<?php echo site_url('sales/publish/');?>";
    var sites_redeem    = "<?php echo site_url('sales/redeem/');?>";
    var sites_cancel    = "<?php echo site_url('sales/cancel/');?>";
    var sites_cleaning    = "<?php echo site_url('sales/cleaning/');?>";
	var sites_attribute = "<?php echo site_url('sales/attribute/');?>";
    var sites_ajax_product = "<?php echo site_url('product/get_price/');?>";
	var source = "<?php echo $source;?>";
    
    var url  = "<?php echo $graph;?>";
	
    $(document).ready(function (e) {
    
     //chart render
	
	$.getJSON(url, function (result) {
		
		var chart = new CanvasJS.Chart("chartcontainer", {

			theme: "theme1",//theme1
			axisY:{title: "", },
  		    animationEnabled: true, 
			data: [
				{
					type: "column",
					dataPoints: result
				}
			]
		});

		chart.render();
	});
	
	//chart render
        
    // document ready end	
    });
    
</script>

          <div class="row"> 
          
            <div class="col-md-12 col-sm-12 col-xs-12">
                  
              <!--  batas xtitle 2  -->    
                
              <div class="x_panel" >
                   
              <!-- xtitle -->
              <div class="x_title">
                
               <h2> Sales Order Filter </h2>
                
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                </ul>
                
                <div class="clearfix"></div>
              </div>
              <!-- xtitle -->
                
                <div class="x_content">
           
           <!-- searching form -->
           
                
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
           
           <form id="searchform" class="form-inline">
             
             <div class="form-group">
                <label class="control-label labelx"> Customer : </label> <br>  
                 MBR-0 <input type="text" class="form-control" name="tcust" id="ccust" readonly style="width:70px;">
                 <?php echo anchor_popup(site_url("member/get_list/ccust/"), '[ ... ]', $atts1); ?> &nbsp;
                   &nbsp;
              </div>
                           
              <div class="form-group">
                <label class="control-label labelx"> Confirmation Status : </label> <br>    
                <select name="cconfirm" id="cconfirm" class="form-control" style="min-width:150px;">
                   <option value="" selected> -- </option>
                   <option value="1"> Confirmed </option>
                   <option value="0"> Unconfirmed </option>
                </select> &nbsp;
              </div>   
              
<!--          <div class="form-group">
              <input type="text" readonly style="width: 200px" name="reservation" id="d1" class="form-control active" value="">
                 &nbsp; 
              </div>-->
              
          <div class="form-group btn-group">
           <br>      
           <button type="submit" class="btn btn-primary button_inline"> Filter </button>
           <button type="reset" onClick="" class="btn btn-success button_inline"> Clear </button>
           <button type="button" onClick="load_data();" class="btn btn-danger button_inline"> Reset </button>
           <button type="button" id="bcleaning" class="btn btn-warning button_inline"> Cleaning </button>
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
        <button type="submit" id="cekallbutton" class="btn btn-danger btn-xs" value="hapus">
           <span class="glyphicon glyphicon-trash"></span>
        </button>
      </div>
      <!-- Check All Function -->
</form>       
             </div>
                  
         <div class="btn-group">
               <!-- Trigger the modal with a button  -->
            <!-- <button type="button" onClick="resets();" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"></i>&nbsp;Add New </button> -->
<!--    <a class="btn btn-primary" href="<?php //echo site_url('sales/add'); ?>"> <i class="fa fa-plus"></i>&nbsp;Add New </a>-->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3"> Report  </button>
<!--            <a class="btn btn-success" href="<?php echo site_url('delivery'); ?>"> Shipping </a>-->
               
               <!-- links -->
	           <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
               <!-- links -->             
            </div>
          </div>  
        </div>
    
      <!-- Modal - Add Form -->
      <div class="modal fade" id="myModal2" role="dialog">
         <?php $this->load->view('sales_confirmation'); ?> 
      </div>
      <!-- Modal - Add Form -->
      
      <!-- Modal Attribute -->
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	     
		 <?php //$this->load->view('product_attribute_frame'); ?> 
      </div>
      <!-- Modal Attribute -->
      
      
      <!-- Modal - Report Form -->
      <div class="modal fade" id="myModal3" role="dialog">subl
         <?php $this->load->view('sales_report_panel'); ?>    
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
