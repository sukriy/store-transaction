<?php
    if ($_SESSION['gambar']!='') {
        $gmbr = base_url('images/account/').cetak($_SESSION['gambar']);
    } else {
        $gmbr = base_url('images/account/img.jpg');
    }
?>
<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="/" class="site_title"><i class="fa fa-paw"></i> <span>SHOP</span></a>
		</div>

		<div class="clearfix"></div>

		<!-- menu profile quick info -->
		<div class="profile clearfix">
			<div class="profile_pic">
				<img src="<?=$gmbr; ?>" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Welcome,</span>
				<h2><?=cetak($_SESSION['nama_lengkap']); ?></h2>
			</div>
		</div>
		<!-- /menu profile quick info -->

		<br />

		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
				<h3>General</h3>
				<ul class="nav side-menu">
					<li><a href='<?=base_url('Admin'); ?>'><i class="fa fa-home"></i> Home </a></li>
					<?php
                    foreach ($hak_akses[$_SESSION['id_account']] as $key=>$value) {
                        foreach ($value as $key2=>$value2) {
                            if (isset($menulist[$key][$value2]['link']) && $menulist[$key][$value2]['link'] != '') {
                                echo $menulist[$key][$value2]['link'];
                            }
                        }
                    }
                    ?>
				</ul>
			</div>
		</div>
		<!-- /sidebar menu -->

		<!-- /menu footer buttons -->
		<div class="sidebar-footer hidden-small">

		</div>
		<!-- /menu footer buttons -->
	</div>
</div>
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
			<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>

			<ul class="nav navbar-nav navbar-right">
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<img src="<?=$gmbr; ?>" alt=""><?=cetak($_SESSION['nama_lengkap']); ?>
					<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
					<!--<li><a href="javascript:;"> Profile</a></li>-->
					<li><a href="<?=base_url('Admin/Ganti_Password'); ?>">Ganti Password</a></li>
					<li><a href="<?=base_url('Admin/Logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
</div>
