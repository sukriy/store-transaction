<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');
	$array = array();	
	foreach($detail as $key=>$value){
		$newdata =  array (
			'id_pembayaran' => cetak($value->id_pembayaran),		
			'tgl_transaksi' => cetak_tgl($value->tgl_transaksi),
			'id_transaksi' => cetak($value->id_transaksi),
			'nominal' => number_format(cetak($value->nominal),0),
		);
		$array[]=$newdata;
	}
	echo "
	<script>
		var detail = ".json_encode($array).";
	</script>";		
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
					<div class="page-title">
						<div class="title_left">
							<h3>Pembayaran List</h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">								
									<ol class="breadcrumb text-right">
										<li><a href="<?=base_url();?>">Dashboard</a></li>
										<li><a href="<?=base_url('Admin/Pembayaran');?>">Pembayaran</a></li>
										<li class="active">Modif</li>
									</ol>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<?php 
									$hak = $hak_akses[$_SESSION['id_account']]['pembayaran'];
								?>
								<?=$this->session->flashdata('pembayaran_list');?>
								<?=$this->session->flashdata('message');?>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<div class='table-responsive'>
								<table class="table table-hover table-bordered example">
									<thead>
										<tr>
											<th></th>
											<th>ID_Pembayaran</th>
											<th>TGL Input</th>
											<th>User Input</th>
											<th>TGL Pembayaran</th>
											<th>Nama</th>
											<th>Nominal</th>
											<th>Keterangan</th>
											<th>Gambar</th>
											<th>Manage</th>
										</tr>
									</thead>
									<tbody>
									<?php
									if(isset($load[0]->id_pembayaran)){
										foreach($load as $key=>$value){
											$ada = 0;
											if(cetak($value->gambar)==''){
												$gambar='';
											}else{ 
												$base = base_url();
												$gambar="<a class='image-link' href='".$base."images/item/".cetak($value->gambar)."'><span class='glyphicon glyphicon-picture' aria-hidden='true'></span></a>";
											}
											
											echo "
											<tr role='row'>
												<td class='details-control'></td>
												<td>".cetak($value->id_pembayaran)."</td>
												<td>".cetak_tglwkt($value->tgl_input)."</td>
												<td>".cetak($value->input)."</td>
												<td>".cetak_tgl($value->tgl_pembayaran)."</td>
												<td>".cetak($value->nama)."</td>
												<td>".cetak(number_format($value->nominal,0))."</td>
												<td>".cetak($value->keterangan)."</td>
												<td>".$gambar."</td>
												<td>";
												
											// if(array_search("edit",$hak)!=''){
												// if($ada>0) echo "&nbsp;|&nbsp;";
												// echo "<a href='#' class='edit' style='color:blue'>Edit</a>";
												// $ada++;
											// } 
											if(array_search("hapus",$hak)!=''){
												if((count($load)-1)==$key){
													if($ada>0) echo "&nbsp;|&nbsp;";
													echo "<a href='#' class='hapus' style='color:blue'>Hapus</a>";
													$ada++;
												}
											}
											echo "</td>
											</tr>
											";
										}
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
	function format ( d ) {
		var txt = "<table class='table table-bordered table-hover'><thead><tr><th>Tgl Transaksi</th><th>ID Transaksi</th><th>Bayar</th></tr></thead><tbody>";
		$.each(detail, function(index, item) {
			if(item['id_pembayaran']==d[1]){
				txt += "<tr><td>"+item['tgl_transaksi']+"</td><td>"+item['id_transaksi']+"</td><td align='right'>"+item['nominal']+"</td></tr>";
			}
		});	
		txt += "</tbody></table>";
		return txt;
	}
    $('.example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
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
				// console.log($(this).closest('tr').find("td:eq(1)").text());
				$.post("<?=base_url('Admin/ajax_pembayaran_hapus'); ?>", {'hapus' : 1, 'id_pembayaran' : $(this).closest('tr').find("td:eq(1)").text(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
					// console.log(result);
					location.reload();
				});	
			}
		});	
	});
	$('button[name=tambah]').click(function(e){
		e.preventDefault();
		window.location.replace("<?=base_url('Admin/pembayaran_list_modif');?>");
	});
</script>