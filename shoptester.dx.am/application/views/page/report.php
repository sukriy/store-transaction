<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');
	$array = array();?>
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
								<?=$this->session->flashdata('report_modif');?>
								<?=$this->session->flashdata('message');?>
								<div style="color: red;"><?=validation_errors(); ?></div>
								<?=form_open_multipart('Admin/report/','id="form_temp"');?>
									<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
									<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>
									<div class="form-group row">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Jenis">Jenis</label>
										<div class="col-md-8 col-sm-8 col-xs-12">
											<label class="form-check-label">
												<input type="radio" id="inline-radio1" name="jenis" value="omset" class="form-check-input" <?=((isset($_POST['jenis']) &&$_POST['jenis']=='omset') ? 'checked' : '' ); ?>>Omset
											</label>
											<label class="form-check-label">
												<input type="radio" id="inline-radio2" name="jenis" value="pembelian" class="form-check-input" <?=((isset($_POST['jenis']) &&$_POST['jenis']=='pembelian') ? 'checked' : '' ); ?>>Pembelian
											</label>
											<label class="form-check-label">
												<input type="radio" id="inline-radio3" name="jenis" value="penjualan" class="form-check-input" <?=((isset($_POST['jenis']) &&$_POST['jenis']=='penjualan') ? 'checked' : '' ); ?>>Penjualan
											</label>
											<label class="form-check-label">
												<input type="radio" id="inline-radio2" name="jenis" value="retur_beli" class="form-check-input" <?=((isset($_POST['jenis']) &&$_POST['jenis']=='retur_beli') ? 'checked' : '' ); ?>>Retur Beli
											</label>
											<label class="form-check-label">
												<input type="radio" id="inline-radio3" name="jenis" value="retur_jual" class="form-check-input" <?=((isset($_POST['jenis']) &&$_POST['jenis']=='retur_jual') ? 'checked' : '' ); ?>>Retur Jual
											</label>
											<label class="form-check-label">
												<input type="radio" id="inline-radio3" name="jenis" value="stock" class="form-check-input" <?=((isset($_POST['jenis']) &&$_POST['jenis']=='stock') ? 'checked' : '' ); ?>>Stock
											</label>
											<label class="form-check-label">
												<input type="radio" id="inline-radio3" name="jenis" value="pembayaran" class="form-check-input" <?=((isset($_POST['jenis']) &&$_POST['jenis']=='pembayaran') ? 'checked' : '' ); ?>>Pembayaran
											</label>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="tanggal">Tanggal</label>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<input type="text" class="form-control tgl" name='dari' value='<?=(isset($_POST['dari']) ? $_POST['dari'] : ''); ?>' placeholder='Dari...'>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<input type="text" class="form-control tgl" name='sampai' value='<?=(isset($_POST['sampai']) ? $_POST['sampai'] : ''); ?>' placeholder='Sampai...'>
										</div>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-success control-label col-md-10 col-sm-10 col-xs-12" name='submit' value='load'>LOAD</button>
									</div>										
								</form>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
<?php
	if(isset($detail)){
		echo "<button class=;btn btn-success; id='btn_export'>Export</button>";
		if($_POST['jenis']=='omset'){
			echo "
				<div class='table-responsive'>
					<table class='table table-bordered table-hover compact example'>
						<thead>
							<tr>
								<th></th>
								<th nowrap>ID_Penjualan</th>
								<th nowrap>Tgl_Penjualan</th>
								<th nowrap>Customer</th>
								<th nowrap>Total Jual</th>
								<th nowrap>Total Beli</th>
							</tr>
						</thead>
						<tbody>";
			foreach($load as $key=>$value){
				if($value->id_penjualan == null) continue;
				echo "
					<tr>
						<td class='details-control'></td>
						<td nowrap>".cetak($value->id_penjualan)."</td>
						<td nowrap>".cetak_tgl($value->tgl_penjualan)."</td>
						<td nowrap>".cetak($value->customer)."</td>
						<td nowrap align='right'>".cetak(number_format($value->subtotal_jual))."</td>
						<td nowrap align='right'>".cetak(number_format($value->subtotal_beli))."</td>
					</tr>
				";
			}
			echo "
						</tbody>
					</table>
				</div>
			";
			foreach($detail as $key=>$value){
				$newdata =  array (
						'id_penjualan' => cetak($value->id_penjualan),
						'id_item' => cetak($value->id_item),
						'nama' => cetak($value->nama),	
						'qty' => number_format(cetak($value->qty),2).' '.cetak($value->satuan),
						'beli' => number_format(cetak($value->beli),0),
						'jual' => number_format(cetak($value->subtotal_jual / $value->qty),0),
						'total_jual' => number_format(cetak($value->subtotal_jual),0),
						'batch' => cetak($value->batch)
					);
				$array[]=$newdata;
			}
			echo "<script>var detail = ".json_encode($array)."</script>";
			
			?>
			<script>
			function format ( d ) {
				var txt = "<table class='table'><thead><tr><th nowrap>Nama</th><th nowrap>Qty</th><th nowrap>Jual</th><th nowrap>Beli</th><th nowrap>Subtotal</th><th nowrap>Batch</th></tr></thead><tbody>";
				var total_harga = 0;
				$.each(detail, function(index, item) {
					if(item['id_penjualan']==d[1]){
						txt += "<tr><td nowrap>"+item['nama']+"</td><td nowrap align='right'>"+item['qty']+"</td><td nowrap align='right'>"+item['jual']+"</td><td nowrap align='right'>"+item['beli']+"</td><td nowrap align='right'>"+item['total_jual']+"</td><td nowrap>"+item['batch']+"</td></tr>";
					}
				});	
				txt += "</tbody></table>";
				return txt;
			}
			</script>
			<?php
		}else if($_POST['jenis']=='pembelian'){
			echo "
				<div class='table-responsive'>
					<table class='table table-bordered table-hover compact example'>
						<thead>
							<tr>
								<th></th>
								<th style='display:none'>Kode_pembelian</th>
								<th nowrap>Supplier</th>
								<th nowrap>Tgl_pembelian</th>
								<th nowrap>No_PO</th>
								<th nowrap>Total</th>
								<th nowrap>Keterangan</th>
								<th nowrap>Gambar</th>
							</tr>
						</thead>
						<tbody>";
			foreach($load as $key=>$value){
				if(cetak($value->gambar)==''){
					$gambar='';
				}else{
					$base = base_url();
					$gambar="<a class='image-link' href='".$base."images/pembelian/".cetak($value->gambar)."'><span class='glyphicon glyphicon-picture' aria-hidden='true'></span></a>";
				}
				
				echo "
				<tr role='row'>
					<td class='details-control'></td>
					<td style='display:none'>".cetak($value->id_pembelian)."</td>
					<td nowrap>".cetak($value->nama_person)."</td>
					<td nowrap>".cetak_tgl($value->tgl_pembelian)."</td>
					<td nowrap>".cetak($value->no_bon)."</td>
					<td align='right' nowrap>".number_format(hitung($value->subtotal,1,$value->diskon),0)."</td>
					<td nowrap>".cetak($value->keterangan)."</td>
					<td nowrap>".$gambar."</td>
				</tr>
				";
			}
			echo "
						</tbody>
					</table>
				</div>
			";
			
			foreach($detail as $key=>$value){
				$newdata =  array (
					'id_pembelian' => cetak($value->id_pembelian),
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
			echo "<script>var detail = ".json_encode($array)."</script>";
			
			?>
			<script>
				function format ( d ) {
					var txt = "<table class='table table-bordered table-hover'><thead><tr><th nowrap>ID_ITEM</th><th nowrap>Nama_Item</th><th nowrap>Qty</th><th nowrap>Harga</th><th nowrap>Diskon</th><th nowrap>Subtotal</th><th nowrap>Keterangan</th></tr></thead><tbody>";
					var total_harga = 0;
					var diskon;
					$.each(detail, function(index, item) {
						if(item['id_pembelian']==d[1]){
							txt += "<tr><td nowrap>"+item['id_item']+"</td><td nowrap>"+item['nama']+"</td><td align='right' nowrap>"+item['qty']+"</td><td align='right' nowrap>"+item['harga']+"</td><td align='right' nowrap>"+item['diskon']+"</td><td align='right' nowrap>"+item['subtotal']+"</td><td nowrap>"+item['keterangan']+"</td></tr>";
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

					txt += "<tr><td colspan='5'>Subtotal</td><td align='right' nowrap>"+total_harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td nowrap></td></tr>";
					txt += "<tr><td colspan='5'>Diskon</td><td align='right' nowrap>"+diskon+"</td><td nowrap></td></tr>";
					txt += "<tr><td colspan='5'>Total</td><td align='right' nowrap>"+Math.round(total).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td nowrap></td></tr>";
					txt += "</tbody></table>";
					return txt;
				}
			</script>
			<?php			
		}else if($_POST['jenis']=='retur_beli'){
			echo "
				<div class='table-responsive'>
					<table class='table table-bordered table-hover compact example'>
						<thead>
							<tr>
								<th></th>
								<th style='display:none'>Kode_retur_beli</th>
								<th nowrap>Customer</th>
								<th nowrap>Tgl_retur_beli</th>
								<th nowrap>Tgl_Jatuh_Tempo</th>
								<th nowrap>Total</th>
								<th nowrap>Keterangan</th>
							</tr>
						</thead>
						<tbody>";
			foreach($load as $key=>$value){
				$ada = 0;
				echo "
				<tr role='row'>
					<td class='details-control'></td>
					<td style='display:none'>".cetak($value->id_retur_beli)."</td>
					<td nowrap>".cetak($value->supplier)."</td>
					<td nowrap>".cetak_tgl($value->tgl_retur_beli)."</td>
					<td nowrap>".cetak_tgl($value->tgl_TOP)."</td>
					<td align='right' nowrap>".number_format(hitung($value->subtotal,1,$value->diskon),0)."</td>
					<td nowrap>".cetak($value->keterangan)."</td>
				</tr>
				"; 
			}

			echo "
						</tbody>
					</table>
				</div>
			";
			
			foreach($detail as $key=>$value){
				$newdata =  array (
					'id_retur_beli' => cetak($value->id_retur_beli),
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
			echo "<script>var detail = ".json_encode($array)."</script>";
			
			?>
			<script>
				function format ( d ) {
					var txt = "<table class='table table-bordered table-hover'><thead><tr><th nowrap>ID_ITEM</th><th nowrap>Nama_Item</th><th nowrap>Qty</th><th nowrap>Harga</th><th nowrap>Diskon</th><th nowrap>Subtotal</th><th nowrap>Keterangan</th></tr></thead><tbody>";
					var total_harga = 0;
					var diskon;
					$.each(detail, function(index, item) {
						if(item['id_retur_beli']==d[1]){
							txt += "<tr><td nowrap>"+item['id_item']+"</td><td nowrap>"+item['nama']+"</td><td align='right' nowrap>"+item['qty']+"</td><td align='right' nowrap>"+item['harga']+"</td><td align='right' nowrap>"+item['diskon']+"</td><td align='right' nowrap>"+item['subtotal']+"</td><td nowrap>"+item['keterangan']+"</td></tr>";
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

					txt += "<tr><td colspan='5'>Subtotal</td><td align='right' nowrap>"+total_harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td nowrap></td></tr>";
					txt += "<tr><td colspan='5'>Diskon</td><td align='right' nowrap>"+diskon+"</td><td nowrap></td></tr>";
					txt += "<tr><td colspan='5'>Total</td><td align='right' nowrap>"+Math.round(total).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td nowrap></td></tr>";
					txt += "</tbody></table>";
					return txt;
				}	
			</script>
			<?php			
		}else if($_POST['jenis']=='retur_jual'){
			echo "
				<div class='table-responsive'>
					<table class='table table-bordered table-hover compact example'>
						<thead>
							<tr>
								<th></th>
								<th style='display:none'>Kode_retur_jual</th>
								<th nowrap>Customer</th>
								<th nowrap>Tgl_retur_jual</th>
								<th nowrap>Tgl_Jatuh_Tempo</th>
								<th nowrap>Total</th>
								<th nowrap>Keterangan</th>
							</tr>
						</thead>
						<tbody>";
			foreach($load as $key=>$value){
				echo "
				<tr role='row'>
					<td class='details-control'></td>
					<td style='display:none'>".cetak($value->id_retur_jual)."</td>
					<td nowrap>".cetak($value->customer)."</td>
					<td nowrap>".cetak_tgl($value->tgl_retur_jual)."</td>
					<td nowrap>".cetak_tgl($value->tgl_TOP)."</td>
					<td align='right' nowrap>".number_format(hitung($value->subtotal,1,$value->diskon),0)."</td>
					<td nowrap>".cetak($value->keterangan)."</td>
				</tr>
				";
			}

			echo "
						</tbody>
					</table>
				</div>
			";
			
			foreach($detail as $key=>$value){
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
			echo "<script>var detail = ".json_encode($array)."</script>";
			
			?>
			<script>
				function format ( d ) {
					var txt = "<table class='table table-bordered table-hover'><thead><tr><th nowrap>ID_ITEM</th><th nowrap>Nama_Item</th><th nowrap>Qty</th><th nowrap>Harga</th><th nowrap>Diskon</th><th nowrap>Subtotal</th><th nowrap>Keterangan</th></tr></thead><tbody>";
					var total_harga = 0;
					var diskon;
					$.each(detail, function(index, item) {
						if(item['id_retur_jual']==d[1]){
							txt += "<tr><td nowrap>"+item['id_item']+"</td><td nowrap>"+item['nama']+"</td><td align='right' nowrap>"+item['qty']+"</td><td align='right' nowrap>"+item['harga']+"</td><td align='right' nowrap>"+item['diskon']+"</td><td align='right' nowrap>"+item['subtotal']+"</td><td nowrap>"+item['keterangan']+"</td></tr>";
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

					txt += "<tr><td colspan='5'>Subtotal</td><td align='right' nowrap>"+total_harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td nowrap></td></tr>";
					txt += "<tr><td colspan='5'>Diskon</td><td align='right' nowrap>"+diskon+"</td><td nowrap></td></tr>";
					txt += "<tr><td colspan='5'>Total</td><td align='right' nowrap>"+Math.round(total).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td nowrap></td></tr>";
					txt += "</tbody></table>";
					return txt;
				}
			</script>
			<?php			
		}else if($_POST['jenis']=='penjualan'){
			echo "
				<div class='table-responsive'>
					<table class='table table-bordered table-hover compact example'>
						<thead>
							<tr>
								<th></th>
								<th style='display:none'>Kode_penjualan</th>
								<th nowrap>Customer</th>
								<th nowrap>Sales</th>
								<th nowrap>Tgl_penjualan</th>
								<th nowrap>Kode_penjualan</th>
								<th nowrap>Total</th>
								<th nowrap>Keterangan</th>
							</tr>
						</thead>
						<tbody>";
			foreach($load as $key=>$value){
				$ada = 0;
				echo "
				<tr role='row'>
					<td class='details-control'></td>
					<td style='display:none'>".cetak($value->id_penjualan)."</td>
					<td nowrap>".cetak($value->customer)."</td>
					<td nowrap>".cetak($value->sales)."</td>
					<td nowrap>".cetak_tgl($value->tgl_penjualan)."</td>
					<td nowrap>".cetak($value->id_penjualan)."</td>
					<td align='right' nowrap>".number_format(hitung($value->subtotal,1,$value->diskon),0)."</td>
					<td nowrap>".cetak($value->keterangan)."</td>
				</tr>
				";
			}
			echo "
						</tbody>
					</table>
				</div>
			";
			
			foreach($detail as $key=>$value){
				$newdata =  array (
					'id_penjualan' => cetak($value->id_penjualan),
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

			echo "<script>var detail = ".json_encode($array)."</script>";
			
			?>
			<script>
				function format ( d ) {
					var txt = "<table class='table table-bordered table-hover'><thead><tr><th nowrap>ID_ITEM</th><th nowrap>Nama_Item</th><th nowrap>Qty</th><th nowrap>Harga</th><th nowrap>Diskon</th><th nowrap>Subtotal</th><th nowrap>Keterangan</th></tr></thead><tbody>";
					var total_harga = 0;
					var diskon;
					$.each(detail, function(index, item) {
						if(item['id_penjualan']==d[1]){
							txt += "<tr><td nowrap>"+item['id_item']+"</td><td nowrap>"+item['nama']+"</td><td align='right' nowrap>"+item['qty']+"</td><td align='right' nowrap>"+item['harga']+"</td><td align='right' nowrap>"+item['diskon']+"</td><td align='right' nowrap>"+item['subtotal']+"</td><td nowrap>"+item['keterangan']+"</td></tr>";
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

					txt += "<tr><td colspan='5'>Subtotal</td><td align='right' nowrap>"+total_harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td nowrap></td></tr>";
					txt += "<tr><td colspan='5'>Diskon</td><td align='right' nowrap>"+diskon+"</td><td nowrap></td></tr>";
					txt += "<tr><td colspan='5'>Total</td><td align='right' nowrap>"+Math.round(total).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td><td nowrap></td></tr>";
					txt += "</tbody></table>";
					return txt;
				}	
			</script>
			<?php
		}else if($_POST['jenis']=='stock'){
			echo "<button class='btn btn-success' id='btn_export_all'>Export ALL</button>";
			echo "<div class='div_example_all'></div>"; 
			echo "
				<div class='table-responsive'>
					<table class='table table-bordered table-hover compact example'>
						<thead>
							<tr>
								<th></th>
								<th nowrap>ID_Item</th>
								<th nowrap>Item</th>
								<th nowrap>Tgl Transaksi</th>
								<th nowrap>Stock</th>
							</tr>
						</thead>
						<tbody>";
			foreach($load as $key=>$value){
				$ada = 0;
				echo "
				<tr role='row'>
					<td class='details-control'></td>
					<td nowrap>".cetak($value->id_item)."</td>
					<td nowrap>".cetak($value->nama)."</td>
					<td nowrap>".cetak_tgl($value->tgl_input)."</td>
					<td align='right' nowrap>".cetak(number_format($value->stock_sisa,2))." ".cetak($value->satuan)."</td>
				</tr>
				";
			}
			echo "
						</tbody>
					</table>
				</div>
			";
			foreach($detail as $key=>$value){
				$newdata =  array (
					'id_item' => cetak($value->id_item),
					'item' => cetak($value->item),
					'id_transaksi' => cetak($value->id_transaksi),			
					'tgl_input' => cetak_tglwkt($value->tgl_input),			
					'tgl_transaksi' => cetak_tgl($value->tgl_transaksi),			
					'person' => cetak($value->person),			
					'qty' => number_format(cetak($value->qty),2),
					'satuan' => cetak($value->satuan),
					'harga' => number_format(cetak($value->subtotal / abs($value->qty)),0)
				);
				$array[]=$newdata;
			}
			echo "<script>var detail = ".json_encode($array)."</script>";
			
			?>
			<script>
				function format ( d ) {
					var txt = "<table class='table'><thead><tr><th nowrap>Item</th><th nowrap>Id_Transaksi</th><th nowrap>Tgl_Input</th><th nowrap>Tgl_Transaksi</th><th nowrap>Person</th><th nowrap>Qty</th><th nowrap>Harga</th></tr></thead><tbody>";
					var satuan = "";
					var total_harga = 0;
					$.each(detail, function(index, item) {
						if(item['id_item']==d[1]){
							satuan = item['satuan'];
							txt += "<tr><td nowrap>"+item['item']+"</td><td nowrap>"+item['id_transaksi']+"</td><td nowrap>"+item['tgl_input']+"</td><td nowrap>"+item['tgl_transaksi']+"</td><td nowrap>"+item['person']+"</td><td align='right' nowrap>"+item['qty']+" "+item['satuan']+"</td><td align='right' nowrap>"+item['harga']+"</td></tr>";
							total_harga += +item['qty'].replace(/,/g, "");
							total_harga = Math.round(total_harga * 100) / 100;
						}
					});	
					total_harga = total_harga.toFixed(2);
					txt += "<tr><td colspan='5'>Total</td><td align='right' nowrap>"+total_harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+" "+satuan+"</td><td nowrap></td></tr>";
					txt += "</tbody></table>";
					return txt;
				}
			</script>
			<?php
		}else if($_POST['jenis']=='pembayaran'){
			$hak = $hak_akses[$_SESSION['id_account']]['pembayaran'];
			echo "
				<div class='table-responsive'>
					<table class='table table-bordered table-hover compact example'>
						<thead>
							<tr>
								<th></th>
								<th nowrap>ID_Pembayaran</th>
								<th nowrap>TGL Input</th>
								<th nowrap>User Input</th>
								<th nowrap>TGL Pembayaran</th>
								<th nowrap>Nama</th>
								<th nowrap>Nominal</th>
								<th nowrap>Keterangan</th>
								<th nowrap>Gambar</th>
							</tr>
						</thead>
						<tbody>";		
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
					<td nowrap>".cetak($value->id_pembayaran)."</td>
					<td nowrap>".cetak_tglwkt($value->tgl_input)."</td>
					<td nowrap>".cetak($value->input)."</td>
					<td nowrap>".cetak_tgl($value->tgl_pembayaran)."</td>
					<td nowrap>".cetak($value->nama)."</td>
					<td nowrap>".cetak(number_format($value->nominal,0))."</td>
					<td nowrap>".cetak($value->keterangan)."</td>
					<td nowrap>".$gambar."</td>
				</tr>
				";
			}
			echo "
						</tbody>
					</table>
				</div>
			";
			foreach($detail as $key=>$value){
				$newdata =  array (
					'id_pembayaran' => cetak($value->id_pembayaran),		
					'tgl_transaksi' => cetak_tgl($value->tgl_transaksi),
					'id_transaksi' => cetak($value->id_transaksi),
					'nominal' => number_format(cetak($value->nominal),0),
				);
				$array[]=$newdata;
			}
			echo "<script>var detail = ".json_encode($array)."</script>";
			
			?>
			<script>
				function format ( d ) {
					var txt = "<table class='table table-bordered table-hover'><thead><tr><th nowrap>Tgl Transaksi</th><th nowrap>ID Transaksi</th><th nowrap>Bayar</th></tr></thead><tbody>";
					$.each(detail, function(index, item) {
						if(item['id_pembayaran']==d[1]){
							txt += "<tr><td nowrap>"+item['tgl_transaksi']+"</td><td nowrap>"+item['id_transaksi']+"</td><td align='right' nowrap>"+item['nominal']+"</td></tr>";
						}
					});	
					txt += "</tbody></table>";
					return txt;
				}
			</script>
			<?php
		}
	}
?>
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
$('#btn_export_all').click(function(e){
	e.preventDefault();
	$.post("<?=base_url('Admin/ajax_print_all'); ?>", {'print' : 1, <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
		var list = JSON.parse(result);
		$("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").each(function() { 
			$(this).val(list.csrf.hash);
		});
		$('.div_example_all').html(list.cetak);
		$("#example_table").table2excel({
			exclude: ".noExl",
			name: "Worksheet Name",
			filename: "Report Stock", //do not include extension
		});
	});	
});
$('#btn_export').click(function(e){
	$(".example").table2excel({
		// exclude CSS class
		exclude: ".noExl",
		name: "Worksheet Name",
		filename: "Report "+ $('input[type=radio]').val()+" "+$('input[name=dari]').val()+" sd "+$('input[name=sampai]').val() //do not include extension
	});
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
			
			$.post("<?=base_url('Admin/ajax_pembayaran_hapus'); ?>", {'hapus' : 1, 'id_pembayaran' : $(this).closest('tr').find("td:first").text(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
				// console.log(result);
				location.reload();
			});	
		}
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
} );
</script>			