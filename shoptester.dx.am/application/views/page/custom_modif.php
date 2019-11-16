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
							<h3>Custom</h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">								
									<ol class="breadcrumb text-right">
										<li><a href="<?=base_url();?>">Dashboard</a></li>
										<li><a href="<?=base_url('Admin/Custom');?>">Custom</a></li>
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
									<?=$this->session->flashdata('custom_modif');?>
									<?=$this->session->flashdata('message');?>
									<?=((validation_errors()!='') ? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' : ''); ?>
									<?=form_open('Admin/Custom_Modif/','id="form_temp"');?>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="opsi">Opsi</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<?php
													$id_kategori = (isset($_POST['id_kategori']) ? $_POST['id_kategori'] : (isset($_GET['id']) ? $_GET['id'] : ''));
													echo "<input type='hidden' class='form-control' name='id_kategori' value='".$id_kategori."'>";
													$id_custom = (isset($_POST['id_custom']) ? $_POST['id_custom'] : (isset($_GET['id_custom']) ? $_GET['id_custom'] : ''));
													echo "<input type='hidden' class='form-control' name='id_custom' value='".$id_custom."'>";
													echo "<input type='hidden' class='form-control' name='uniqid' value='".uniqid()."'>";
												?>
												<input type="text" class="form-control" name='opsi' value="<?=(isset($detail[0]) ? $detail[0]->opsi : (isset($_POST['opsi']) ? $_POST['opsi'] : '')); ?>" 
													data-validation="required length" 
													data-validation-length="max85"									
												>
												<small class="form-text text-danger" id='error'></small>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="keterangan">Keterangan</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<textarea class="form-control" rows="5" name='keterangan' data-validation="length" data-validation-length="max1000"><?=(isset($detail) ? $detail[0]->keterangan : (isset($_POST['keterangan']) ? $_POST['keterangan'] : '')); ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success control-label col-md-10 col-sm-10 col-xs-12" name='submit' value=<?=(isset($detail) ? 'edit' : 'baru');?>><?=(isset($detail) ? 'EDIT' : 'INPUT BARU'); ?></button>
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
abc = function(){
	$.post("<?=base_url('Admin/ajax_custom_double'); ?>", {'hapus' : 1, 'id_kategori' : $('input[name=id_kategori]').val(), 'id_custom' : $('input[name=id_custom]').val(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val(), 'opsi' : $('input[name=opsi]').val()}, function(result){
		
		var result = JSON.parse(result);
		$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
			$(this).val(result.csrf.hash);
		});
		if(result.nilai){
			$("input[name=nama]").removeClass("is-invalid");
			$('#error').html('');
		}else{
			$("input[name=nama]").addClass("is-invalid");
			$('#error').html('Nama Sudah Ada');
		}
		
	});		
}
	$('input[name=nama]').change(function(e){
		abc();
	});
	$('button[name=submit]').click(function(e){
		if($('#error').html()!=''){
			swal({
			  title: "Error",
			  text: "Nama Sudah Ada",
			  icon: "warning",
			});
			e.preventDefault();
		}
	});
	$.validate();
</script>