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
							<h3>Hak Akses</h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">								
									<ol class="breadcrumb text-right">
										<li><a href="<?=base_url();?>">Dashboard</a></li>
										<li class="active">Hak Akses</li>
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
									<?=$this->session->flashdata('menu_list');?>
									<?=$this->session->flashdata('message');?>
									<?=((validation_errors()!='') ? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' : ''); ?>
									<?=form_open('Admin/Menu_List/','id="form_temp"');?>
										<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>
										<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="id_account">Account</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select class="form-control" name='id_account' data-validation="required">
													<option value=""></option>
													<?php
														foreach($load as $key=>$value){
															echo "<option value='".cetak($value->id_account)."' ".((isset($_POST['id_account']) && cetak($_POST['id_account'])==cetak($row->id_account)) ? 'selected' : '').">".cetak($value->nama_lengkap)."</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="form-group row">

<div class='table-responsive'>
	<table class='table table-bordered table-hover compact'>
		<thead>
			<tr>
				<th>Menu</th>
				<th>Hak Akses</th>
			</tr>
		</thead>
		<tbody>
<?php
	foreach($menulist as $key=>$value){
		$opsi = array();
		foreach($value as $key2=>$value2){
			$nilai = "
				<label class='checkbox-inline'>
				  <input type='checkbox' class='".strtolower(cetak($key))."' name='".cetak($key)."[]' value='".cetak($key2)."'>".cetak($key2)."
				</label>
			";
			$opsi[]=$nilai;
		}
		echo "
			<tr>
				<td>".cetak($key)."</td>
				<td>".implode(' ',$opsi)."</td>
			</tr>
		";
	}
?>
		</tbody>
	</table>
</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success control-label col-md-10 col-sm-10 col-xs-12" name='submit' value='edit'>EDIT</button>
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
$('select[name=id_account]').change(function(e){
	abc();
});
abc = function(){
	if($('select[name=id_account]').val()!=''){
		$('input[type=checkbox]').prop( "checked", false);
		$.post("<?=base_url('Admin/ajax_menu_load'); ?>", {'check' : 1, 'id_account' : $('select[name=id_account]').val(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
			// console.log(result);
			
			var result = JSON.parse(result);
			$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
				$(this).val(result.csrf.hash);
			});
			$('table > tbody  > tr').each(function() {
				var menu = $(this).find("td:eq(0)").html().toLowerCase();
				$.each( result.nilai, function( index, value ){
					if($('select[name=id_account]').val().toLowerCase() == value['id_account'].toLowerCase() &&	menu == value['bagian'].toLowerCase() ){
						var res = value['hak'].toLowerCase().split(", ");
						$.each( res, function( index2, value2 ){
							$('.'+menu).each(function(){
								var jenis = $(this).val().toLowerCase();
								if(jenis == value2){
									$(this).prop( "checked", true);	
								}
							});
						});
					}
				});
			});
			
		});
	}else{
		$('input[type=checkbox]').prop( "checked", false);
	}
}
$.validate();
</script>