<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');
	$array = array();	
	foreach($load_detail as $key=>$value){
		$newdata =  array (
			'id_retur_jual' => cetak($value->id_retur_jual),
			'id_item' => cetak($value->id_item),
			'harga' => number_format(cetak($value->harga),0),
			'qty' => number_format(cetak($value->qty),2).' '.cetak($value->satuan),
			'diskon' => cetak_diskon($value->diskon),
			'keterangan' => cetak($value->keterangan),
			'batch' => cetak($value->batch),
			'nama' => cetak($value->nama),
			'diskon0' => cetak_diskon($value->diskon0),
			'subtotal' => number_format($value->subtotal,0)
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
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">						
								<?php 
									$hak = $hak_akses[$_SESSION['id_account']][strtolower($this->router->fetch_method())];
									if(array_search("baru",$hak)!=''){
										echo "<button type='submit' class='btn btn-success btn-flat m-b-30 m-t-30' name='tambah'>Tambah</button>";
									}
								?>
								<?=$this->session->flashdata('retur_jual');?>
								<?=$this->session->flashdata('message');?>							
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<div class='table-responsive'>
								<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
								<table class="table table-hover table-bordered example">
									<thead>
										<tr>
											<th></th>
											<th style='display:none'>Kode_retur_jual</th>
											<th>Customer</th>
											<th>Tgl_retur_jual</th>
											<th>Tgl_Jatuh_Tempo</th>
											<th>Total</th>
											<th>Keterangan</th>
											<th>Manage</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($load as $key=>$value){
												$ada = 0;
												echo "
												<tr role='row'>
													<td class='details-control'></td>
													<td style='display:none'>".cetak($value->id_retur_jual)."</td>
													<td>".cetak($value->customer)."</td>
													<td>".cetak_tgl($value->tgl_retur_jual)."</td>
													<td>".cetak_tgl($value->tgl_TOP)."</td>
													<td align='right'>".number_format(hitung($value->subtotal,1,$value->diskon),0)."</td>
													<td>".cetak($value->keterangan)."</td>
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
							<div id='cetak'></div>	
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
		var txt = "<table class='table table-bordered table-hover'><thead><tr><th>ID_ITEM</th><th>Nama_Item</th><th>Qty</th><th>Harga</th><th>Diskon</th><th>Subtotal</th><th>Keterangan</th></tr></thead><tbody>";
		var total_harga = 0;
		var diskon;
		$.each(detail, function(index, item) {
			if(item['id_retur_jual']==d[1]){
				txt += "<tr><td>"+item['id_item']+"</td><td>"+item['nama']+"</td><td align='right'>"+item['qty']+"</td><td align='right'>"+item['harga']+"</td><td align='right'>"+item['diskon']+"</td><td align='right'>"+item['subtotal']+"</td><td>"+item['keterangan']+"</td></tr>";
				total_harga += +item['subtotal'].replace(/,/g, "");
				diskon = item['diskon0'].replace(/,/g, "");
			}
		});	
		
		if($.isNumeric(diskon)){
			var total = total_harga - diskon;
			diskon = diskon.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
		}else{
			var total = total_harga;
			$.each( (diskon.replace(/%/g , '').split("+")), function( index, value ){
				total = total * (100-value) / 100;
			});
		}

		txt += "<tr><td colspan='5'>Subtotal</td><td align='right'>"+total_harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td></td></tr>";
		txt += "<tr><td colspan='5'>Diskon</td><td align='right'>"+diskon+"</td><td></td></tr>";
		txt += "<tr><td colspan='5'>Total</td><td align='right'>"+Math.round(total).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td></td></tr>";
		txt += "</tbody></table>";
		return txt;
	}
	$('.example tbody').on('click', '.print', function (e) {
		e.preventDefault();
		
		$.post("<?=base_url('Admin/ajax_retur_jual_print'); ?>", {'id_retur_jual' : $(this).closest('tr').find("td").eq(1).text(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
			var result = JSON.parse(result);
			$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
				$(this).val(result.csrf.hash);
			});
			$('#cetak').html(result['cetak']);
			generate(result);
			
		});		
	});		
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
	$('.example tbody').on('click', '.edit', function (e) {
		e.preventDefault();
		window.location.replace("<?=base_url('Admin/retur_jual_modif?id_retur_jual=');?>"+$(this).closest('tr').find("td").eq(1).text());
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
				
				$.post("<?=base_url('Admin/ajax_retur_jual_hapus'); ?>", {'hapus' : 1, 'id_retur_jual' : $(this).closest('tr').find("td").eq(1).text(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
					var result = JSON.parse(result);
					// console.log(result);
					$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
						$(this).val(result.csrf.hash);
					});
					if(result.nilai==false){
						swal("Harap Check Kembali", "Stock Harap dikembalikan ke posisi awal sebelum dihapus", "error");
					}else{
						location.reload();
					}
				});	
			}
		});	
	});
	$('button[name=tambah]').click(function(e){
		e.preventDefault();
		window.location.replace("<?=base_url('Admin/retur_jual_modif');?>");
	});
</script>