<div class="container-fluid">
	<header class="mynavbar">
		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			<div class="tipe">
				<img src="imgs/logo.png" alt="" class="img-responsive block" width="150">
				
				<a href="dashboard" class="mymenu">Dashboard <i id="icon" class="fa fa-bar-chart" aria-hidden="true"></i></a>
				
				<a data-toggle="collapse" data-target="#demo" class="mymenu">Article &nbsp;<i class="glyphicon glyphicon-chevron-down"></i><i id="icon" class="fa fa-book" aria-hidden="true"></i></a>
				<div id="demo" class="collapse">
					<ul class="mynav">
						 <li><a href="article">Article Category</a></li>
						 <li><a href="article#2">Article List</a></li>
						 <li><a href="article#3">Language</a></li>
					</ul>
				</div>
				
				<a data-toggle="collapse" data-target="#demo2" class="mymenu">Catalog &nbsp;<i class="glyphicon glyphicon-chevron-down"></i><i id="icon" class="fa fa-dropbox" aria-hidden="true"></i></a>
				<div id="demo2" class="collapse">
					<ul class="mynav">
						 <li><a href="catalog">Category</a></li>
						 <li><a href="catalog#2">Material Item</a></li>
						 <li><a href="catalog#3">Manufactures</a></li>
						 <li><a href="catalog#4">Model</a></li>
						 <li><a href="catalog#5">Product List</a></li>
						 <li><a href="catalog#6">Attributes</a></li>
					</ul>
				</div>
				
				<a data-toggle="collapse" data-target="#demo3" class="mymenu">Setting &nbsp;<i class="glyphicon glyphicon-chevron-down"></i><i id="icon" class="fa fa-gear" aria-hidden="true"></i></a>
				<div id="demo3" class="collapse">
					<ul class="mynav">
						 <li><a href="setting">Shipping Rate</a></li>
						 <li><a href="setting#2">Payment Type</a></li>
						 <li><a href="setting#3">Sales Discount</a></li>
						 <li><a href="setting#4">Bank Details</a></li>
					</ul>
				</div>
				
				<a data-toggle="collapse" data-target="#demo4" class="mymenu">Sales &nbsp;<i class="glyphicon glyphicon-chevron-down"></i><i id="icon" class="fa fa-shopping-cart" aria-hidden="true"></i></a>
				<div id="demo4" class="collapse">
					<ul class="mynav">
						 <li><a href="sales">Agent</a></li>
						 <li><a href="sales#2">Customers</a></li>
						 <li><a href="sales#3">Orders</a></li>
						 <li><a href="sales#4">Shipping</a></li>
						 <li><a href="sales#5">Order Offer</a></li>
					</ul>
				</div>
				
				<a data-toggle="collapse" data-target="#demo5" class="mymenu">Marketing &nbsp;<i class="glyphicon glyphicon-chevron-down"></i><i id="icon" class="fa fa-users" aria-hidden="true"></i></a>
				<div id="demo5" class="collapse">
					<ul class="mynav">
						 <li><a href="campaign">Campaign</a></li>
					</ul>
				</div>
				
				<a data-toggle="collapse" data-target="#demo6" class="mymenu">Menu &nbsp;<i class="glyphicon glyphicon-chevron-down"></i><i id="icon" class="fa fa-bars" aria-hidden="true"></i></a>
				<div id="demo6" class="collapse">
					<ul class="mynav">
						 <li><a href="menu">Front Menu</a></li>
						 <li><a href="menu#2">Admin Menu</a></li>
					</ul>
				</div>
				
				<a data-toggle="collapse" data-target="#demo7" class="mymenu">Configuration &nbsp;<i class="glyphicon glyphicon-chevron-down"></i><i id="icon" class="fa fa-gear" aria-hidden="true"></i></a>
				<div id="demo7" class="collapse">
					<ul class="mynav">
						 <li><a href="configuration">Web Admin</a></li>
						 <li><a href="configuration#2">Component Manager</a></li>
						 <li><a href="configuration#3">Widget List</a></li>
						 <li><a href="configuration#4">History</a></li>
						 <li><a href="configuration#5">Role</a></li>
						 <li><a href="configuration#6">Global Configuration</a></li>
						 <li><a href="configuration">Web - Mail</a></li>
					</ul>
				</div>
				
			</div>
		</div>
		<div class="menuclick"> 
			<a onclick="openNav()">&#9776;</a> 
		</div>
	</header>
</div>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
</script>
<!--/SideNav-->