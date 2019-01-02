<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel" >
<div class="x_title">
  <h2>WEB-ADMIN - 1.0.3 - <?php echo $name; ?> System </h2> <div class="clearfix"></div>
    
   <!-- top tiles -->
  <div class="row tile_count" style="margin-left:5px;">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
      <div class="count">2500</div>
      <span class="count_bottom"><i class="green">4% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
      <div class="count">123.50</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
      <div class="count green">2,500</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
      <div class="count">4,567</div>
      <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
      <div class="count">2,315</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
      <div class="count">7,325</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
  </div>
<!-- /top tiles -->

<div class="clearfix"></div>
     
    <div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
    <p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
    
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <span style="color:#fff !important;">IP Adress : <strong> <?php echo $this->input->ip_address(); ?> </strong> 
      - <?php echo $user_agent; ?> | Last Login : <?php echo $this->session->userdata('waktu'); ?> | Period : <?php echo $month ?> - <?php echo $year; ?> </span> 
    </div>
    
    
    </div>
    
    <div class="x_content">
    
        <style>
          .ixcon{
            display: inline-block;
            margin: 20px;
            text-align: center;
            border:1px solid #eee;
            width: 100px;
            height: 100px;
            margin-bottom: 0;
            margin-right: 0px;
            padding-top: 15px;transition: all .5s;
            margin-left: 0;
          }
          .ixcon img{
            display: block;
        
            margin: 0 auto;margin-bottom: 5px;
          }
          .ixcon:hover{
            border:1px solid #40C1A6;
            transition: all 1s;
          }
          .ixcon:hover a{
            color: #40C1A6;
            text-decoration: none;
          }
        </style>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/article/';?>">
                <img alt="Article Manager" src="<?php echo base_url().'images/article.png';?>">
                <p> Article </p>
                </a>
        
            </div>
        
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/setting/';?>">
                <img alt="setting" src="<?php echo base_url().'images/setting.png';?>">
                <p> Setting </p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/adminmenu/';?>">
                <img alt="Admin Menu" src="<?php echo base_url().'images/menu.png';?>">
                <p>Admin Menu</p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/frontmenu/';?>">
                <img alt="Front Menu" src="<?php echo base_url().'images/frontmenu.png';?>">
                <p>Front Menu</p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/admin/';?>">
                <img alt="user" src="<?php echo base_url().'images/user_icon.png';?>">
                <p>User</p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/product/';?>">
                <img alt="user" src="<?php echo base_url().'images/product.png';?>">
                <p>Product</p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/log/';?>">
                <img alt="log" src="<?php echo base_url().'images/log.png';?>">
                <p>History</p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/component/';?>">
                <img alt="modul" src="<?php echo base_url().'images/modul.png';?>">
                <p>Component</p>
              </a>
              
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/widget/';?>">
                <img alt="modul" src="<?php echo base_url().'images/widget.png';?>">
                <p>Widget</p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/configuration/';?>">
                <img alt="configuration" src="<?php echo base_url().'images/config.png';?>">
                <p>Configuration</p>
              </a>
        
            </div>
        
       <div class="clearfix"></div>
    
    </div> 

<!-- end content -->

</div>
</div>