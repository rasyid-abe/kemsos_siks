<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sistem Informasi Kesejahteraan Sosial</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- Favicon icon -->
	<link rel="icon" href="<?php echo base_url( 'assets/uploads/images/logos/' );?>favicon.ico" type="image/x-icon">

	<!-- vendor css -->
	<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/prism-coy.css">
	<link rel="stylesheet" href="<?php echo $style;?>icons/mdi/css/materialdesignicons.min.css">
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/vendor-all.min.js"></script>
	<!-- select2 css -->
    <link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/select2.min.css">

	<?php echo ( isset( $header_script ) ? $header_script : '' );?>
	<style media="screen">
		.fbutton, .pDiv2 {
			font-size: small
		}
	</style>
</head>
<?php
$user_info = $_SESSION['user_info'];
$last_login = $this->db->get_where('dbo.core_user_account', ['user_account_id' => $user_info['user_id']])->row('user_account_last_login_datetime');
if ( $user_info['user_image'] != '' && file_exists( ADMIN_IMAGE . $user_info['user_image'] ) ) {
    $profile_image = $user_info['w'];
} else {
    $profile_image = 'default.png';
}
?>
<style>
.siks-res {
	margin-left:22%;
}

.subtitle1 {
	position:absolute;
	top:-5px;
	left:220px;
}
.subtitle2 {
	position:absolute;
	top:6px;
	left:220px;
}
@media only screen and (max-width: 575px) {
	.siks-res {
		margin-left:1%;
    }

    .subtitle1 {
        position:absolute;
        top:-5px;
        left:110px;
    }

    .subtitle2 {
        position:absolute;
        top:6px;
        left:110px;
    }
}
</style>
<body class="background-img-1">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar theme-horizontal menu-light brand-blue">
        <div class="navbar-wrapper">
            <div class="navbar-content sidenav-horizontal" id="layout-sidenav">
				<?php require('nav.php'); ?>
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
		<div class="m-header">
			<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
			<a href="#!" class="b-brand">
				<!-- ========   change your logo hear   ============ -->
				<img src="<?php echo base_url( 'assets/uploads/images/users/logo-nav.png' );?>" class="img-radius" style="width:35px;margin-right:5px">
				<span class="siks">SIKS-DROID</span>
			</a>
			<a href="#!" class="mob-toggler">
				<i class="feather icon-more-vertical"></i>
			</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav mr-auto siks-res">
				<li class="nav-item">
					<div class="subtitle1">
						<div class="small-title">VERIFIKASI DAN VALIDASI DATA TERPADU</div>
					</div>
					<div class="subtitle2">
						<div class="small-title">KEMENTERIAN SOSIAL R.I</div>
					</div>
				</li>
				<li class="nav-item">
					<img src="<?php echo base_url( 'assets/uploads/images/logos/siks-ng.png' );?>" width="58px">
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li>
					<span class="m-b-0" style="font-size: 11px; font-weight: bold;"><?php echo $user_info['user_name'];?> (<?php echo $user_info['user_username'];?>) | Last Login : <?php echo convert_datetime($last_login);?> | </span>
				</li>
				<li>
					<div class="dropdown drp-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<button type="button" class="btn btn-sm btn-info rounded-circle"><i class="feather icon-user icon-thumbs-up"></i></button>
						</a>
						<div class="dropdown-menu dropdown-menu-right profile-notification">
							<div class="pro-head">
								<img src="<?php echo base_url( 'assets/uploads/images/users/' ) . $profile_image;?>" class="img-radius" alt="User-Profile-Image">
								<span><?php echo $user_info['user_name'];?></span>
							</div>
							<ul class="pro-body">
								<li><a href="#" class="dropdown-item"><i class="feather icon-users"></i> <?php echo "User ID : ".$user_info['user_id'];?></a></li>
								<li><a href="#" class="dropdown-item"><i class="feather icon-phone"></i> <?php echo $user_info['user_username'];?></a></li>
								<?php if (in_array('root', $user_info['user_group']) == false) {?>
									<li><a href="<?php echo base_url('config/user/profile_user');?>" class="dropdown-item"><i class="feather icon-user"></i> Ubah Profile</a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<div class="dropdown">
						<a class="btn btn-sm btn-danger rounded-circle" href="<?php echo base_url( 'logout' );?>" title="Logout"><i class="icon feather icon-power"></i></a>
					</div>
				</li>
			</ul>
		</div>
	</header>
	<div class="pcoded-main-container">
		<div class="pcoded-content">
			<div class="page-header">
				<div class="page-block">
					<div class="row align-items-center">
						<div class="col-md-12">
							<div class="page-header-title">
							</div>
							<ul class="breadcrumb">
									<?php
									if ( isset( $breadcrumb ) && is_array( $breadcrumb ) && !empty( $breadcrumb ) ){
									    $length = count( $breadcrumb );
									    $num = 1;
									    foreach ( $breadcrumb as $title => $link ) {
									        $class_active = ( ( $num == $length ) ? "active" : null );
									        echo '
			                                    <li class="breadcrumb-item ' . $class_active . '">
			                                        <a href="' . $link . '">' . $title. '</a>
			                                    </li>';
									    }
									}
									?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
		    	<div class="col-md-12" style="margin-top: -35px">
					<div class="alert alert-secondary">
						<span class="m-b-0" style="font-size:12px;font-weight:bold;"><i class="feather icon-home"></i> / Home / <?php echo ( isset( $title ) ? $title : "Module Title" );?></span>
						<a href="#" class="m-b-0 float-right" data-toggle="modal" data-target="#exampleModalLong"><span style="font-size:12px;font-weight:bold;"><i class="feather icon-book"></i> Informasi Status</span></a>
					</div>
				<?php
					if ( ! empty( $content ) ) echo $content;
				?>
			</div>
		</div>
	</div>

	<div id="exampleModalLong" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Informasi Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<!-- <ul> -->
						<?php foreach ($legend as $key => $value): ?>
							<div class="mb-1"><img src="<?= base_url('assets/style/icon-status') . '/' . $value['icon'] ?>"> = <?php echo $value['long_label'] ?></div>
						<?php endforeach; ?>
					<!-- </ul> -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Required Js -->
    <script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/ripple.js"></script>
    <script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pcoded.min.js"></script>
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/horizontal-menu.js"></script>
	<!-- select2 Js -->
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/select2.full.min.js"></script>
	<!-- form-select-custom Js -->
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/form-select-custom.js"></script>
    <?php echo ( isset( $script_footer ) ? $script_footer : '' );?>
    <script>
        (function() {
            if ($('#layout-sidenav').hasClass('sidenav-horizontal') || window.layoutHelpers.isSmallScreen()) {
                return;
            }
            try {
                window.layoutHelpers._getSetting("Rtl")
                window.layoutHelpers.setCollapsed(
                    localStorage.getItem('layoutCollapsed') === 'true',
                    false
                );
            } catch (e) {}
        })();
        $(function() {
            $('#layout-sidenav').each(function() {
                new SideNav(this, {
                    orientation: $(this).hasClass('sidenav-horizontal') ? 'horizontal' : 'vertical'
                });
            });
            $('body').on('click', '.layout-sidenav-toggle', function(e) {
                e.preventDefault();
                window.layoutHelpers.toggleCollapsed();
                if (!window.layoutHelpers.isSmallScreen()) {
                    try {
                        localStorage.setItem('layoutCollapsed', String(window.layoutHelpers.isCollapsed()));
                    } catch (e) {}
                }
            });
        });
        $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                themelayout: 'horizontal',
                MenuTrigger: 'hover',
                SubMenuTrigger: 'hover',
            });
        });
    </script>

</body>
</html>
