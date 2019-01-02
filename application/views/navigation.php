   <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo site_url('main'); ?>" class="site_title"><i class="fa fa-home"></i> <span> D'swip Panel </span></a>
        </div>
        <div class="clearfix"></div>
            <div class="profile">
                <div class="profile_pic">
                    <img src="<?php echo base_url(); ?>images/img.png" alt="..." class="img-circle profile_img">
                </div>
                <div class="profile_info">
                    <span>Welcome,</span>
                    <h2> <?php echo $this->session->userdata('username'); ?> </h2>
                </div>
            </div>
            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <h3>General</h3>
                    
                    <ul class="nav side-menu">
                    <li><a href="<?php echo site_url('main'); ?>"> <i class="fa fa-bar-chart"></i> Dashboard </a> </li>
					<?php 
					
					     $lib = new Adminmenu_lib();
						 
						 foreach($lib->get_parent_menu() as $res) 
						 {
							if ($lib->has_child($res->id) == TRUE){
							
					echo "<li> <a> <i class=\"".$res->class_style."\"></i> ".$res->name." <span class=\"fa fa-chevron-down\"></span></a>
                          <ul class=\"nav child_menu\" style=\"display: none\">
						  ".get_child($res->id)."
                          </ul>
                          </li>";
							
							}
							else 
							{ echo "<li> <a href=".site_url($res->url)."> <i class=\"".$res->class_style."\"></i> ".$res->name." </a> </li>"; }
							 
					     }
						 
						 // child menu
						 function get_child($parent=0)
						 {
							 $lib = new Adminmenu_lib();
							 $result = "";
							 foreach ($lib->get_child_menu($parent) as $res)
							 {
					 $result = $result."<li> <a target=\"".$res->target."\" href=".site_url($res->url)."> ".$res->name." </a> </li>";
							 }
							 return $result;
						 }
						  
					 ?>
						
                     <?php $this->load->view('staticnavigation'); ?>   
                        
                     </ul>
                </div>
            </div>
            <!-- /sidebar menu -->
        </div>
</div>


<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <div class="row">
            <div class="col-lg-6">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                      <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                </nav>
            </div>
            <div class="col-lg-5 text-right">
                <h4> <?php echo date('D').' - '.date('d / m / Y'); ?> <p id="time" style="color:#720909; font-size:10pt; font-weight:bold; margin:5px;"></p> </h4>
            </div>
            <div class="col-lg-1"></div>
        </div>

    </div>
</div>
<!-- /top navigation -->
	
    
    