
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
	<link rel="icon" href="<?php echo base_url() . THEMES_LOGIN ;?>assets/images/favicon.ico" type="image/x-icon">

	<!-- vendor css -->
	<link rel="stylesheet" href="<?php echo base_url() . THEMES_LOGIN ;?>assets/css/style.css">
</head>

<body>
	<form method="post" action="<?php echo base_url( 'auth/login/auth' );?>">
	<input type="hidden" name="redirect_url" value="<?php echo ( ( isset( $_GET['redirect_url'] ) ) ? $_GET['redirect_url'] : '' );?>">
	<div class="auth-wrapper">
		<div class="auth-content">
			<div class="card">
				<div class="row align-items-center text-center">
					<div class="col-md-12">
						<div class="card-body">
							<img src="<?php echo base_url() . THEMES_LOGIN ;?>assets/images/auth/auth.png" alt="Login" class="img-fluid mb-4">
							<h4 class="f-w-600" style="font-family: david">SIKS-DROID</h4>							
							<div class="form-group mb-3">
								<?php 
								if ( $this->session->flashdata('message') ) {
									echo '
								<div class="alert alert-danger" role="alert">' .
									$this->session->flashdata('message') . '
								</div>';
								}
								?>
							</div>
							<div class="form-group mb-3">
								<label class="floating-label" for="Username">Username</label>
								<input type="text" class="form-control" name="username" id="Username" placeholder="" required>
							</div>
							<div class="form-group mb-3">
								<label class="floating-label" for="Password">Password</label>
								<input type="password" class="form-control" name="password" id="Password" placeholder="" required>								
							</div>													
							<div class="form-group mb-3">
								<?php if ( !empty( $content ) ) echo $content;	?>
							</div>		
							<p class="mb-2 text-muted">Aplikasi SIKS-DROID</p>
    						<p class="mb-2 text-muted">Sistem Informasi Kesejahteraan Sosial</p>									
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>	

	<!-- Required Js -->
	<script src="<?php echo base_url() . THEMES_LOGIN ;?>assets/js/vendor-all.min.js"></script>
	<script src="<?php echo base_url() . THEMES_LOGIN ;?>assets/js/plugins/bootstrap.min.js"></script>
	<script src="<?php echo base_url() . THEMES_LOGIN ;?>assets/js/ripple.js"></script>
	<script src="<?php echo base_url() . THEMES_LOGIN ;?>assets/js/pcoded.min.js"></script>

</body>
</html>
