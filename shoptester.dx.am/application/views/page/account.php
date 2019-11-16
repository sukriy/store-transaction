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
								<?=$this->session->flashdata('account');?>
								<?=$this->session->flashdata('message');?>				
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<div class="table-responsive">
								<table class="table table-hover table-bordered example">
									<thead>
										<tr class="headings">
											<th>ID_Account</th>
											<th>Nama_Lengkap</th>
											<th>Username</th>
											<th>Alamat</th>
											<th>NoTlpn</th>
											<th>NPWP</th>
											<th>Email</th>
											<th>Gambar</th>
											<th>Manage</th>
										</tr>
									</thead>
									<tbody>
									<?php
										foreach($load as $key=>$value){
											$ada = 0;
											if(cetak($value->gambar)==''){
												$gambar='';
											}else{
												$base = base_url();
												$gambar="<a class='image-link' href='".$base."images/account/".cetak($value->gambar)."'><span class='glyphicon glyphicon-picture' aria-hidden='true'></span></a>";
											}										
											echo "
											<tr>
												<td>".cetak($value->id_account)."</td>
												<td>".cetak($value->nama_lengkap)."</td>
												<td>".cetak($value->username)."</td>
												<td>".cetak($value->alamat)."</td>
												<td>".cetak($value->notlpn)."</td>
												<td>".cetak($value->npwp)."</td>
												<td>".cetak($value->email)."</td>
												<td>".$gambar."</td>
												<td>";
												
											if(array_search("edit",$hak)!=''){
												if($ada>0) echo "&nbsp;|&nbsp;";
												echo "<a href='#' class='edit' style='color:blue'>Edit</a>";
												$ada++;
											}
											if(array_search("hapus",$hak)!=''){
												if($ada>0) echo "&nbsp;|&nbsp;";
												echo "<a href='#' class='hapus' style='color:blue'>Hapus</a>";
												$ada++;
											}
											echo "</td>
											</tr>
											";
										}
									?>
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
	$('.example tbody').on('click', '.edit', function (e) {
		e.preventDefault();
		window.location.replace("<?=base_url('Admin/account_modif?id_account=');?>"+$(this).closest('tr').find("td:first").text());
	})
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
				
				$.post("<?=base_url('Admin/ajax_account_hapus'); ?>", {'hapus' : 1, 'id_account' : $(this).closest('tr').find("td:first").text(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
					location.reload();
				});	
			}
		});	
	});
	$('button[name=tambah]').click(function(e){
		e.preventDefault();
		window.location.replace("<?=base_url('Admin/account_modif');?>");
	});
</script>