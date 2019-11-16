<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');
?>
<style>
tbody>tr>:nth-child(2){ 
	white-space: nowrap;
}
</style>
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
								<?php 
									$hak = $hak_akses[$_SESSION['id_account']][strtolower($this->router->fetch_method())];
									if(array_search("baru",$hak)!=''){
										echo "<button type='submit' class='btn btn-success btn-flat m-b-30 m-t-30' name='tambah'>Tambah</button>";
									}
								?>
								<?=$this->session->flashdata('item');?>
								<?=$this->session->flashdata('message');?>							
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<div class='table-responsive'>
								<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
								<table class="table table-hover table-bordered" id='example'>
									<thead>
										<tr>
											<th>ID_item</th>
											<th nowrap>Nama</th>
											<th>Harga_Beli</th>
											<th>Diskon(%)</th>
											<th>Satuan</th>
											<th>Group</th>
											<th>Keterangan</th>
											<th>Gambar</th>
											<th>Manage</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
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
<script type="text/javascript">
        //datatables
	table = $('#example').DataTable({ 

		"processing": true, 
		"serverSide": true, 
		"order": [], 
		
		"ajax": {
			"url": "<?php echo site_url('Admin/get_data_user')?>",
			"type": "POST"
		},

		
		"columnDefs": [
		{ 
			"targets": [ 0 ], 
			"orderable": false, 
		},
		],
		"fnDrawCallback": function () {
			$('.image-link').magnificPopup({
				type: 'image'
			});
		}

	});
	$('#example tbody').on('click', '.edit', function (e) {
		e.preventDefault();
		window.location.replace("<?=base_url('Admin/item_modif?id_item=');?>"+$(this).closest('tr').find("td:eq(0)").text());
	})
	$('#example tbody').on('click', '.hapus', function (e) {
		e.preventDefault();
		swal({
			title: "Apakah Anda yakin?",
			text: "Sekali dihapus, Anda tidak dapat lagi mengembalikannya!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$.post("<?=base_url('Admin/ajax_item_hapus'); ?>", {'hapus' : 1, 'id_item' : $(this).closest('tr').find("td:first").text(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
					// console.log(result);
					location.reload();
				});	
			}
		});	
	});
	$('button[name=tambah]').click(function(e){
		e.preventDefault();
		window.location.replace("<?=base_url('Admin/item_modif');?>");
	});
</script>