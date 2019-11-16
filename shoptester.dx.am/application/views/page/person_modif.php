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
							<h3>Form Elements</h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">								
									<ol class="breadcrumb text-right">
										<li><a href="<?=base_url();?>">Dashboard</a></li>
										<li><a href="<?=base_url('Admin/Person');?>">Person</a></li>
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
									<?=$this->session->flashdata('person_modif');?>
									<?=$this->session->flashdata('message');?>
									<?=((validation_errors()!='') ? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' : ''); ?>
									<?=form_open_multipart('Admin/Person_Modif/','id="form_temp"');?>
										<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
										<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>
										<input type="hidden" class="form-control" name='id_person' value='<?=(isset($load[0]->id_person) ? $load[0]->id_person :(isset($_POST['id_person']) ? $_POST['id_person'] : (isset($_GET['id_person']) ? $_GET['id_person'] : ''))); ?>'>

										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="nama">Nama</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name='nama_person' value='<?=(isset($load[0]->nama_person) ? $load[0]->nama_person : (isset($_POST['nama_person']) ? $_POST['nama_person'] : '')); ?>' data-validation="required" data-validation="length" data-validation-length="max255">
												<small class="form-text text-danger" id='error'></small>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="jenis">Jenis</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select data-placeholder="Pilih Jenis..." class="form-control" tabindex="1" name='jenis'>
													<option value=""></option>
													<?php
														foreach($group->result() as $row){
															echo "<option value='".cetak($row->opsi)."' ".((isset($load[0]->jenis) && cetak($load[0]->jenis)==cetak($row->opsi)) ? 'selected' : (isset($_POST['jenis']) && cetak($_POST['jenis'])==cetak($row->opsi)) ? 'selected' : '').">".cetak($row->opsi)."</option>";
														}
													?>
												</select>
												<small class="form-text text-danger" id='error0'></small>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="notlpn">NoTlpn</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control only_angka" name='notlpn' value='<?=(isset($load[0]->notlpn) ? $load[0]->notlpn : (isset($_POST['notlpn']) ? $_POST['notlpn'] : '')); ?>' data-validation="angka_20">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="alamat">Alamat</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<textarea class="form-control" rows="5" name='alamat' data-validation="length" data-validation-length="max1000"><?=(isset($load[0]->alamat) ? $load[0]->alamat : (isset($_POST['alamat']) ? $_POST['alamat'] : '')); ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="npwp">NPWP</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control only_angka" name='npwp' value='<?=(isset($load[0]->npwp) ? $load[0]->npwp : (isset($_POST['npwp']) ? $_POST['npwp'] : '')); ?>' data-validation="angka_20">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="gambar">Gambar</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="file" class="form-control" name='gambar'>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success control-label col-md-10 col-sm-10 col-xs-12" name='submit' value=<?=(isset($load[0]->id_person) ? 'edit' : 'baru');?>><?=(isset($load[0]->id_person) ? 'EDIT' : 'INPUT BARU'); ?></button>
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
$('input[name=nama_person]').change(function(e){
	abc();
});
abc = function(){
	$.post("<?=base_url('Admin/ajax_person_double'); ?>", {'check' : 1, 'id_person' : $('input[name=id_person]').val(), 'nama_person' : $('input[name=nama_person]').val(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val(), 'nama' : $('input[name=nama]').val()}, function(result){
		
		var result = JSON.parse(result);
		$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
			$(this).val(result.csrf.hash);
		});
		if(result.nilai){
			$("input[name=nama_person]").removeClass("is-invalid");
			$('#error').html('');
		}else{
			$("input[name=nama_person]").addClass("is-invalid");
			$('#error').html('nama_person Sudah Ada');
		}
		
	});		
}
$('button[name=submit]').click(function(e){
	if($('select[name=jenis]').val()==''){
		$("select[name=jenis]").addClass("is-invalid");
		$('#error0').html('Harap diisi');
		e.preventDefault();
	}else if($('input[name=nama_person]').val()==''){
		swal({
		  title: "Error",
		  text: "Nama Harap Diisi",
		  icon: "warning",
		});
		e.preventDefault();		
	}else{
		$("select[name=jenis]").removeClass("is-invalid");
		$('#error0').html('');
		
		var txt = '';
		if($('#error').html()!=''){
			swal({
			  title: "Error",
			  text: "Nama Sudah Ada",
			  icon: "warning",
			});
			e.preventDefault();
		}		
	}
})
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
$.formUtils.addValidator({
	name : 'angka_20',
	validatorFunction : function(value, $el, config, language, $form) {
		var nilai = value.replace(/,/g , '').length;
		if(nilai>20)
			return false;
		else
			return true;
	},
	errorMessage : 'maksimal 20 digit angka',
	errorMessageKey: 'badEvenNumber'
});
	$.validate();
</script>