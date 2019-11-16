<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');
	$hak = $hak_akses[$_SESSION['id_account']][strtolower($this->router->fetch_method())];
?>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<?php
				include('header.php');
			?>
			<!-- page content -->
			<div class="right_col" role="main">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<?=$this->session->flashdata('custom');?>
								<?=$this->session->flashdata('message');?>	

								<div class="form-group row">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="jenis">Jenis</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
										<select data-placeholder="Pilih..." class="form-control" name='jenis'>
											<option value="" selected></option>
											<?php
												foreach($list->result() as $row){
													echo "<option value='".$row->id_kategori."'>".$row->nama_kategori."</option>";
												}
											?>
										</select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12" id='tambah'></div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
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
<script type="text/javascript">
window.onload = function(e){
	
	var jenis = "<?=$this->session->flashdata('id_kategori'); ?>";
	if(jenis!=""){
		$('select[name=jenis]').val(jenis);
		$('select[name=jenis]').change();
	}
	
}
abc = function(obj){
	// console.log('obj = '+obj);
	if(obj==''){
		$('.x_content').html('');
		$('#tambah').html('');		
	}else{
		$.post("<?=base_url('Admin/ajax_custom'); ?>", {'load':1, 'id_kategori':obj, <?=$this->security->get_csrf_token_name(); ?>: $("input[name=<?=$this->security->get_csrf_token_name(); ?>]").val()}, function(result){
			// console.log(result);
			
			var list = JSON.parse(result);
			$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
				$(this).val(list.csrf.hash);
			});
			var txt2 = "<?=((array_search('baru',$hak)!='') ? "<button type='submit' class='btn btn-success btn-flat m-b-30 m-t-30' name='tambah'>Tambah</button>" :""); ?>";
			var txt = "<div class='container'><div class='table-responsive'><table id='table_temp' class='table table-striped table-bordered compact example' style='width:100%'><thead><tr><th>Jenis</th><th>Nama</th><th>Keterangan</th><th>Manage</th></tr></thead><tbody>";
			$.each(list.nilai, function (index, value) {
				txt += "<tr><td data-id='"+value['id_custom']+"'>"+value.nama_kategori+"</td><td>"+value.opsi+"</td><td>"+value.keterangan+"</td><td>";
				txt += "<?=((array_search("edit",$hak)!="")  ? "<a href='#' class='edit'  style='color:blue'>Edit</a>" : ""); ?>";
				txt += "<?=(((array_search("hapus",$hak)!="") && (array_search("edit",$hak)!="")) ? "&nbsp;|&nbsp;" : ""); ?>";
				txt += "<?=((array_search("hapus",$hak)!="") ? "<a href='#' class='hapus' style='color:blue'>Hapus</a>" : ""); ?>";
				txt += "</td></tr>";
			});
			txt += "</tbody></table></div></div>";
			$('.x_content').html(txt);
			$('#tambah').html(txt2);
			
			$('.example tbody').on('click', '.edit', function (e) {
				e.preventDefault();
				window.location.replace("<?=base_url('Admin/custom_modif?id=');?>"+$('select[name=jenis]').val()+"&id_custom="+$(this).closest('tr').find('td:eq(0)').attr('data-id'));
			});
			$('button[name=tambah]').click(function(e){
				e.preventDefault();
				window.location.replace("<?=base_url('Admin/custom_modif?id=');?>"+$('select[name=jenis]').val());
			});

			$('.example tbody').on('click', '.hapus', function (e) {
				e.preventDefault();
				swal({
					title: "Apakah Anda yakin?",
					text: "Sekali dihapus, Anda tidak dapat lagi mengembalikannya!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				}).then((willDelete) => {
					if (willDelete) {
						
						$.post("<?=base_url('Admin/ajax_custom_hapus'); ?>", {'hapus' : 1, 'id_kategori' : $('select[name=jenis]').val(), 'id_custom' : $(this).closest('tr').find('td:eq(0)').attr('data-id'), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
							var list2 = JSON.parse(result);
							$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
								$(this).val(list2.csrf.hash);
							});
							abc($('select[name=jenis]').val());						
						});	
					}
					
				});	
			});
			$('#table_temp').DataTable({
				"scrollX": true
			});		
			
		});
	}		
}
	$(document).ready(function(){
		$('select[name=jenis]').change(function(e){
			abc($('select[name=jenis]').val());
		});
		$('button[type=submit]').click(function(e){
			e.preventDefault();
			window.location.replace("<?=base_url('Admin/Custom_Modif?id=');?>"+$('select[name=jenis]').val());
		});
	});
</script>