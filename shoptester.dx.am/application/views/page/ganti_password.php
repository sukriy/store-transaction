<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');
?>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<?php
				include('header.php');
			?>
			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Ganti Password</h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">								
									<ol class="breadcrumb text-right">
										<li><a href="<?=base_url();?>">Dashboard</a></li>
										<li class="active">Ganti Password</li>
									</ol>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_content">
									<br />						
									<?=$this->session->flashdata('ganti_password');?>
									<?=$this->session->flashdata('message');?>
									<?=((validation_errors()!='') ? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' : ''); ?>
									<?=form_open('Admin/Ganti_Password','id="form_temp"');?>
										<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
										<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>

										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="password_lama">Password Lama</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="password" class="form-control" name='password_lama' value="<?=(isset($_POST['password_lama']) ? $_POST['password_lama'] : ''); ?>" 
													data-validation="required"
												>
										</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="pass_confirmation">Password Baru</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="password" class="form-control" name='pass_confirmation' value="<?=(isset($_POST['pass_confirmation']) ? $_POST['pass_confirmation'] : ''); ?>" 
													data-validation="required length"
													data-validation-length='6-255'
												>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="pass">Password retype</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="password" class="form-control" name='pass' value="<?=(isset($_POST['pass']) ? $_POST['pass'] : ''); ?>" 
													data-validation="confirmation"
												>
											</div>
										</div>
										<div class="form-group col-md-7 col-sm-7 col-xs-12"">
											<button type="submit" class="btn btn-success control-label col-md-10 col-sm-10 col-xs-12" name='submit' value='submit'>Ganti Password</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
				</div>
				<div class="clearfix"></div>
			</footer>
		<!-- /footer content -->
		</div>
	</div>	
	<?php
		include('footer.php');
	?>
</body>
</html>
<script>
	$.validate({
		modules : 'security'
	});
</script>