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
                    
                        <li><a href="<?php echo site_url('main'); ?>"> <i class="fa fa-home"></i> Home </a> </li>
                        <li><a> <i class="fa fa-dropbox"></i> Product <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu" style="display: none">
                                <li><a href="<?php echo site_url('category'); ?>">Category</a> <span class=""></span> </li>
                                <li><a href="<?php echo site_url('product'); ?>">Product List </a></li>
                                <li><a href="<?php echo site_url('slider'); ?>">Image Slider </a></li>
                                <li><a href="<?php echo site_url('banner'); ?>">Banner </a></li>
                                <li><a href="<?php echo site_url('project'); ?>">Event</a></li>
                                <li><a href="<?php echo site_url('testimonial'); ?>">Testimonial</a></li>
                            </ul>
                        </li>
                        
                        <li><a><i class="fa fa-book"></i> Article <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu" style="display: none">
                                <li><a href="<?php echo site_url('article/add'); ?>"> New Article</a> </li>
                                <li><a href="<?php echo site_url('article'); ?>"> Artile List</a> </li>
                                <li><a href="<?php echo site_url('newscategory'); ?>"> News Category</a> </li>
                                <li><a href="<?php echo site_url('newsbox'); ?>"> News Box</a> </li>
                                <li><a href="<?php echo site_url('language'); ?>"> Language</a> </li>
                            </ul>
                        </li>
                        
                        <li><a><i class="fa fa-bars"></i> Menu <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu" style="display: none">
                                <li><a href="<?php echo site_url('frontmenu'); ?>"> Front Menu</a> </li>
                                <li><a href="<?php echo site_url('adminmenu'); ?>"> Admin menu</a> </li>
                            </ul>
                        </li>
                       <li><a><i class="fa fa-gear"></i> Configuration <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu" style="display: none">
                                <li><a href="<?php echo site_url('admin'); ?>">Web Admin</a></li>
                               <li><a href="<?php echo site_url('component'); ?>">Component Manager</a></li>
                               <li><a href="<?php echo site_url('widget'); ?>">Widget List</a></li>
                               <li><a href="<?php echo site_url('log'); ?>">History</a></li>
                               <li><a href="<?php echo site_url('roles'); ?>">Role</a></li>
                               <li><a href="<?php echo site_url('configuration'); ?>">Global Configuration</a></li>
                               <li> <a href="#" target="_blank"> Web - Mail </a> </li>
                            </ul>
                        </li>

                        <li><a href="<?php echo site_url('login/process_logout'); ?>"><i class="fa fa-power-off"></i> log Out</a>
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
