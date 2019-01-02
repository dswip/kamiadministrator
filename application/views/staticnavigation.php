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
       <li> <a href="http://calculator.dswip.com/userguide/" target="_blank"> Userguide </a> </li>
    </ul>
</li>

<li><a href="<?php echo site_url('login/process_logout'); ?>"><i class="fa fa-power-off"></i> log Out</a>