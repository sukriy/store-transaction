<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');

	$item0 = array();
	foreach($item as $key=>$value){
		array_push($item0, cetak($value->nama));
	}
	echo "
	<script>
		var item0 = ".json_encode($item0).";
	</script>";		
	
	if(isset($load[0]->group)){
		$load[0]->group = explode(", ",$load[0]->group);
		foreach($load[0]->group as $key=>$value){
			$load[0]->group[$key] = cetak($load[0]->group[$key]);
		}
	}else if(isset($_POST['group'])){
		foreach($_POST['group'] as $key=>$value){
			$_POST['group'][$key] = cetak($_POST['group'][$key]);
		}		
	}
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
							<h3>ITEM <?=(isset($load[0]->id_item) ? 'EDIT' : 'BARU');?></h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">								
									<ol class="breadcrumb text-right">
										<li><a href="<?=base_url();?>">Dashboard</a></li>
										<li><a href="<?=base_url('Admin/Item');?>">Item</a></li>
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
									<?=$this->session->flashdata('pembelian_modif');?>
									<?=$this->session->flashdata('message');?>
									<?=((validation_errors()!='') ? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' : ''); ?>
									<?=form_open_multipart('Admin/Item_Modif/','id="form_temp"');?>
										<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>
										<input type="hidden" class="form-control" name='id_item' value='<?=(isset($load[0]->id_item) ? $load[0]->id_item :(isset($_POST['id_item']) ? $_POST['id_item'] : (isset($_GET['id_item']) ? $_GET['id_item'] : ''))); ?>'>
										<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
										
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="nama">Nama</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name='nama' value='<?=(isset($load[0]->nama) ? cetak($load[0]->nama) : (isset($_POST['nama']) ? cetak($_POST['nama']) : '')); ?>'  
													data-validation="required length" 
													data-validation-length="max255"
												>
												<small class="form-text text-danger" id='error'></small>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="harga_beli">Harga Beli</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control angka" name='harga_beli' value='<?=(isset($load[0]->harga_beli) ? number_format(cetak($load[0]->harga_beli)) : (isset($_POST['harga_beli']) ? number_format(cetak0($_POST['harga_beli']),0) : 0)); ?>'
													data-validation="angka_9"
												>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="no_bon">Diskon(%)</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control diskon" name='diskon' value='<?=(isset($load[0]->diskon) ? cetak($load[0]->diskon) : (isset($_POST['diskon']) ? cetak($_POST['diskon']) : 0)); ?>'>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="jatuh_tempo">Group_item</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select class="select2_multiple form-control" multiple="multiple" name='group[]'>
													<option value=""></option>
													<?php
														foreach($group->result() as $row){
															echo "<option value='".cetak($row->opsi)."' ".((isset($load[0]) && in_array(cetak($row->opsi), $load[0]->group)) ? 'selected' : (isset($_POST['group']) && in_array(cetak($row->opsi), $_POST['group'])) ? 'selected' : '').">".cetak($row->opsi)."</option>";
														}
													?>
												</select>	
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="satuan">Satuan</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select class="form-control" name='satuan'>
													<option value=""></option>
													<?php
														foreach($satuan->result() as $row){
															echo "<option value='".cetak($row->opsi)."' ".((isset($load[0]->satuan) && cetak($load[0]->satuan)==cetak($row->opsi)) ? 'selected' : (isset($_POST['satuan']) && cetak($_POST['satuan'])==cetak($row->opsi)) ? 'selected' : '').">".cetak($row->opsi)."</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="keterangan">Keterangan</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<textarea class="form-control" rows="5" name='keterangan' 
													data-validation="length" 
													data-validation-length="max1000"
												><?=(isset($load[0]->keterangan) ? $load[0]->keterangan : (isset($_POST['keterangan']) ? $_POST['keterangan'] : '')); ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="gambar">Gambar</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="file" class="form-control" name='gambar'>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success control-label col-md-10 col-sm-10 col-xs-12" name='submit' value=<?=(isset($load[0]->id_item) ? 'edit' : 'baru');?>><?=(isset($load[0]->id_item) ? 'EDIT' : 'INPUT BARU'); ?></button>
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
	$(".hapus").click(function(e){
		e.preventDefault();
		$(this).closest('.temp').remove();
	});	
}
$('input[name=nama]').change(function(e){
	abc();
});
$('input[name=nama]').autocomplete({
	source: item0,
	minLength: 3
});
// $('input[name=nama]').autocomplete({
	// source: "<?php echo site_url('Admin/get_autocomplete');?>",

	// select: function (event, ui) {
		// $('input[name=nama]').val(ui.item.nama); 
	// }
// });
abc = function(){
	$.post("<?=base_url('Admin/ajax_item_double'); ?>", {'check' : 1, 'id_item' : $('input[name=id_item]').val(), 'nama' : $('input[name=nama]').val(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val(), 'nama' : $('input[name=nama]').val()}, function(result){
		// console.log(result);
		
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
$('button[name=submit]').click(function(e){
	var txt = '';
	$('.search-choice>span').each(function() {
		if(txt=='')
			txt += $(this).text();
		else
			txt += ', '+$(this).text();
	});
	$('input[name=group]').val(txt);
	if($('#error').html()!=''){
		swal({
		  title: "Error",
		  text: "Nama Sudah Ada",
		  icon: "warning",
		});
		e.preventDefault();
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
	name : 'angka_9',
	validatorFunction : function(value, $el, config, language, $form) {
		var nilai = value.replace(/,/g , '').length;
		if(nilai>9)
			return false;
		else
			return true;
	},
	errorMessage : 'maksimal 9 digit angka',
	errorMessageKey: 'badEvenNumber'
});
	$.validate();
</script>