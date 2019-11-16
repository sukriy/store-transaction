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
							<h3>Account</h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">								
									<ol class="breadcrumb text-right">
										<li><a href="<?=base_url();?>">Dashboard</a></li>
										<li><a href="<?=base_url('Admin/Account');?>">Account</a></li>
										<li class="active">Modif</li>
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
									<?=$this->session->flashdata('account_modif');?>
									<?=$this->session->flashdata('message');?>
									<?=((validation_errors()!='') ? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' : ''); ?>
									<?=form_open_multipart('Admin/account_modif','id="form_temp"');?>
										<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>
										<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
										<input type="hidden" class="form-control" name='id_account' value='<?=(isset($load[0]->id_account) ? $load[0]->id_account :(isset($_POST['id_account']) ? $_POST['id_account'] : (isset($_GET['id_account']) ? $_GET['id_account'] : ''))); ?>'>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="nama_lengkap">Nama Lengkap</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name='nama_lengkap' value='<?=(isset($load[0]->nama_lengkap) ? $load[0]->nama_lengkap : (isset($_POST['nama_lengkap']) ? $_POST['nama_lengkap'] : '')); ?>'  
													data-validation="required length" 
													data-validation-length="6-255">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="username">Username</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name='username' value='<?=(isset($load[0]->username) ? $load[0]->username : (isset($_POST['username']) ? $_POST['username'] : '')); ?>' 
													data-validation="required length" 
													data-validation-length="6-255">
												<small class="form-text text-danger" id='error'></small>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="password_confirmation">Password</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="password" class="form-control" name='password_confirmation' value='<?=(isset($load[0]->password) ? $load[0]->password : (isset($_POST['password_confirmation']) ? $_POST['password_confirmation'] : '')); ?>' 
													data-validation="required length" 
													data-validation-length="6-255">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="password">Re-Password</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="password" class="form-control" name='password' value='<?=(isset($load[0]->password) ? $load[0]->password : (isset($_POST['password']) ? $_POST['password'] : '')); ?>' 
													data-validation="confirmation">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="alamat">Alamat</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name='alamat' value='<?=(isset($load[0]->alamat) ? $load[0]->alamat : (isset($_POST['alamat']) ? $_POST['alamat'] : '')); ?>' 
													data-validation="length" 
													data-validation-length="max1000">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="notlpn">NoTlpn</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control only_angka" name='notlpn' value='<?=(isset($load[0]->notlpn) ? $load[0]->notlpn : (isset($_POST['notlpn']) ? $_POST['notlpn'] : '')); ?>' 
													data-validation="length" 
													data-validation-length="max20">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="npwp">NPWP</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control only_angka" name='npwp' value='<?=(isset($load[0]->npwp) ? $load[0]->npwp : (isset($_POST['npwp']) ? $_POST['npwp'] : '')); ?>' 
													data-validation="length" 
													data-validation-length="max255">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="email">Email</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name='email' value='<?=(isset($load[0]->email) ? $load[0]->email : (isset($_POST['email']) ? $_POST['email'] : '')); ?>' 
													data-validation="length" 
													data-validation-length="max255">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="gambar">Gambar</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="file" class="form-control" name='gambar'>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success control-label col-md-10 col-sm-10 col-xs-12" name='submit' value=<?=(isset($load[0]->id_account) ? 'edit' : 'baru');?>><?=(isset($load[0]->id_person) ? 'EDIT' : 'INPUT BARU'); ?></button>
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
window.onload = function(e){
	abc();
}
$('input[name=username]').change(function(e){
	abc();
});
abc = function(){
	$.post("<?=base_url('Admin/ajax_account_double'); ?>", {'check' : 1, 'id_account' : $('input[name=id_account]').val(), 'username' : $('input[name=username]').val(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val(), 'username' : $('input[name=username]').val()}, function(result){
		// console.log(result);
		
		var result = JSON.parse(result);
		$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
			$(this).val(result.csrf.hash);
		});
		if(result.nilai){
			$("input[name=username]").removeClass("is-invalid");
			$('#error').html('');
		}else{
			$("input[name=username]").addClass("is-invalid");
			$('#error').html('Username Sudah Ada');
		}
		
	});		
}
$('input[type=file]').bind('change', function() {
	var ukuran = this.files[0].size/1024/1024;
	if(ukuran>2){
		swal({
		  title: "Error",
		  text: "Ukuran Gambar melebih batas yang ditentukan",
		  icon: "warning",
		});		
		$(this).val('');
	}else{
		var arr = $(this).val().split('.');
		var tipe = arr[(arr.length)-1];
		if(!(tipe=='jpg' || tipe=='jpeg' || tipe=='png')){
			alert('Tipe data tidak sesuai ketentuan');
			$(this).val('');
		}	
	}			
});
$('button[name=submit]').click(function(e){
	if($('#error').html()!=''){
		swal({
		  title: "Error",
		  text: "Username Sudah Ada",
		  icon: "warning",
		});
		e.preventDefault();
	}
})
  $.validate({
    modules : 'security'
  });
</script>