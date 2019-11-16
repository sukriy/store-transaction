<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>SHOP Application</title>

	<!-- Bootstrap -->
	<link href="<?=base_url('assets/'); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?=base_url('assets/'); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="<?=base_url('assets/'); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- Animate.css -->
	<link href="<?=base_url('assets/'); ?>vendors/animate.css/animate.min.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="<?=base_url('assets/'); ?>build/css/custom.min.css" rel="stylesheet">
</head>
<body class="login">
	<div>
		<a class="hiddenanchor" id="signin"></a>
		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<?=((validation_errors()!='') ? '<div "alert alert-danger">'.validation_errors().'</div>' : ''); ?>
					<?=$this->session->flashdata('sign_in');?>
					<?=$this->session->flashdata('message');?>
                    <form method='post' action='<?=base_url('Admin/sign_in'); ?>'>
						<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
						<h1>Login Form</h1>
						<div>
							<input type="text" class="form-control" name='username' placeholder="Username" required="" value='sa'/>
						</div>
						<div>
							<input type="password" class="form-control" name='password' placeholder="Password" required="" value='tester1234'/>
						</div>
						<div>
							<button type="submit" class="form-control btn btn-success" name='submit'>Sign in</button>
						</div>

						<div class="clearfix"></div>
					</form>
				</section>
			</div>
		</div>
	</div>
</body>
</html>
