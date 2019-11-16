<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');
	$hak = $hak_akses[$_SESSION['id_account']]['pembayaran'];	
	
	$nilai = array();
	$array = array();
	if(isset($load)){
		foreach(array_unique(array_column($load, 'id_person')) as $key=>$value){
			$temp = array (
				'id_person' => $value,
				'nama' => check_array($load, $value, 'id_person', 'nama'),
				'bon' => check_array($load, $value, 'id_person', 'id_transaksi'),
				'total' => check_array($load, $value, 'id_person', 'tagihan'),
				'bayar' => check_array($load, $value, 'id_person', 'bayar')
			);
			$nilai[] = $temp;
		}
		foreach($load as $key=>$value){
			if($value['id_transaksi'] == '-') continue;
			$newdata =  array (
				'id_transaksi' => strtoupper(cetak($value['id_transaksi'])),
				'tgl_transaksi' => cetak_tgl($value['tgl_transaksi']),
				'id_person' => cetak($value['id_person']),
				'no_po' => cetak($value['no_po']),
				'total' => number_format(hitung($value['subtotal'], 1, $value['diskon']),0),
				'bayar' => number_format(cetak($value['bayar']),0)
			);
			$array[]=$newdata;
		}
	}

	echo "<script>var detail = ".json_encode($array)."</script>";	
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
								<div style="color: red;"><?=validation_errors(); ?></div>
								<?=form_open_multipart('Admin/Pembayaran','id="form_temp"');?>
									<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
									<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>
									<div class="form-group row">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="password">Jenis</label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<label class="radio-inline">
												<input type="radio" class='jenis' name="jenis" value='pembelian'
													<?=(empty($_POST['jenis']) ? 'checked' : (($_POST['jenis']=='pembelian') ? 'checked' : '')); ?>
												>Pembelian
											</label>
											<label class="radio-inline">
												<input type="radio" class='jenis' name="jenis" value='penjualan'
													<?=((isset($_POST['jenis']) && $_POST['jenis']=='penjualan') ? 'checked' : ''); ?>
												>Penjualan
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
								<button class="btn btn-success" id='btn_export'>Export</button>
								<?=$this->session->flashdata('pembayaran');?>
								<?=$this->session->flashdata('message');?>	
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<div class='table-responsive'>
								<table style='display:none' id='temp_table'>
									<thead>
										<tr>
											<th nowrap>Nama</th>
											<th nowrap>Total Bon</th>
											<th nowrap>Total Tagihan</th>
											<th nowrap>Total Bayar</th>
											<th nowrap>Total Pembayaran Sisa</th>
										</tr>
									</thead>
									<tbody>
									<?php
										foreach($nilai as $key=>$value){ 
											echo "
											<tr>
												<td nowrap data-id=".cetak($value['id_person']).">".cetak($value['nama'])."</td>
												<td nowrap style='text-align: right'>".cetak(number_format($value['bon'],0))."</td>
												<td nowrap style='text-align: right'>".cetak(number_format($value['total'],0))."</td>
												<td nowrap style='text-align: right'>".cetak(number_format($value['bayar'],0))."</td>
												<td nowrap style='text-align: right'>".cetak(number_format($value['total']-$value['bayar'],0))."</td>
											</tr>
											";
										}
									?>
									</tbody>
								</table>
							</div>
							<div class='table-responsive'>
								<table class="table table-hover table-bordered example">
									<thead>
										<tr>
											<th></th>
											<th nowrap>Nama</th>
											<th nowrap>Total Bon</th>
											<th nowrap>Total Tagihan</th>
											<th nowrap>Total Bayar</th>
											<th nowrap>Total Pembayaran Sisa</th>
											<th nowrap>Manage</th>
										</tr>
									</thead>
									<tbody>
									<?php
										foreach($nilai as $key=>$value){
											$ada = 0;
											echo "
											<tr>
												<td class='details-control'></td>
												<td nowrap data-id=".cetak($value['id_person']).">".cetak($value['nama'])."</td>
												<td nowrap>".cetak(number_format($value['bon'],0))."</td>
												<td nowrap style='text-align: right'>".cetak(number_format($value['total'],0))."</td>
												<td nowrap style='text-align: right'>".cetak(number_format($value['bayar'],0))."</td>
												<td nowrap style='text-align: right'>".cetak(number_format($value['total']-$value['bayar'],0))."</td>
												<td nowrap>";
												
											if(array_search("bayar",$hak)!=''){
												if($ada>0) echo "&nbsp;|&nbsp;";
												echo "<a href='#' class='bayar' style='color:blue' data-toggle='modal' data-target='#myModal'>Bayar</a>";
												$ada++;
											}
											if(array_search("edit",$hak)!=''){
												if($ada>0) echo "&nbsp;|&nbsp;";
												echo "<a href='#' class='edit' style='color:blue'>Edit</a>";
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
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Pembayaran</h4>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<?=form_open_multipart('Admin/Pembayaran_Modif/','id="form_temp"');?>
						<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="nama">Nama</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>
								<input type="hidden" class="form-control" name='id_person' readonly
									data-validation="required" 
								>
								<input type="text" class="form-control" name='nama_person' readonly  
									data-validation="required length" 
									data-validation-length="max255"
								>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="tgl_pembayaran">Tgl Pembayaran</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<input type="text" class="form-control tgl" name='tgl_pembayaran' 
									data-validation="required date" 
									data-validation-format="dd-mm-yyyy"
								>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="bayar">Bayar</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<input type="text" class="form-control angka" name='bayar' 
									data-validation="angka_9"
								>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="sisa">Sisa</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<input type="text" class="form-control angka" name='sisa' readonly
									data-validation="angka_9"
								>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="total">Total</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<input type="text" class="form-control angka" name='total' readonly
									data-validation="angka_9"
								>
							</div>
						</div>		
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="bayar">Transaksi</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<select class="select2_multiple form-control" id='temp_transaksi' multiple="multiple" name='transaksi[]'>
									
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="retur">Retur</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<select class="select2_multiple form-control" id='temp_retur' multiple="multiple" name='retur[]'>
									
								</select>
							</div>
						</div>
		
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="keterangan">Gambar</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<input type="file" class="form-control" name='gambar'>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="keterangan">Keterangan</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<textarea class="form-control" rows="2" name='keterangan' 
									data-validation="length" 
									data-validation-length="max1000"
								></textarea>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30 col-md-11 form-control" name='submit' value='bayar'>Bayar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>		
</body>
</html>
<script type="text/javascript">
$('#btn_export').click(function(e){
	$("#temp_table").table2excel({
		// exclude CSS class
		exclude: ".noExl",
		name: "Worksheet Name",
		filename: "Pembayaran" //do not include extension
	}); 	
});
  
// $('.jenis').click(function(e){
	// e.preventDefault();
	// $('#form_temp').submit();
// });
function format ( d, d2 ) {
	var txt = "<table class='table'><thead><th>ID_Transaksi</th><th>Tgl Transaksi</th><th>ID Person</th><th>Total</th></thead><tbody>";
	var total_harga = 0;
	$.each(detail, function(index, item) {
		if(item['id_person']==d2){
			txt += "<tr><td>"+item['id_transaksi']+"</td><td>"+item['tgl_transaksi']+"</td><td>"+item['no_po']+"</td><td style='text-align: right'>"+item['total']+"</td></tr>";			
			total_harga += +item['total'].replace(/,/g, "");
		}
	});	
	txt += "<tr><td colspan='3'>Total</td><td style='text-align: right'>"+total_harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+"</td></tr>";
	txt += "</tbody></table>";
	return txt;
}
$('.example tbody').on('click', 'td.details-control', function () {
	var tr = $(this).closest('tr');
	var row = table.row( tr );

	var temp = $($(tr.find('td:eq(1)'))[0]['outerHTML']);
	
	if ( row.child.isShown() ) {
		// This row is already open - close it
		row.child.hide();
		tr.removeClass('shown');
	}
	else {
		// Open this row
		row.child( format(row.data(), temp.attr('data-id')) ).show();
		tr.addClass('shown');
	}
});	
$(document).ready(function(){
	$('.example tbody').on('click', '.bayar', function (e) {
		e.preventDefault();
		$('input[name=total]').val(0);
		var temp = $($($(this).closest('tr').find('td:eq(1)'))[0]['outerHTML']);
		var bayar = $(this).closest('tr').find('td:eq(4)').text();
		$('input[name=id_person]').val(temp.attr('data-id'));
		$('input[name=nama_person]').val(temp.text());
		
		var transaksi='<option value=""></option>';
		var retur='<option value=""></option>';
		$.each(detail, function(index, item) {
			if(item['id_person']==temp.attr('data-id')){
				if(parseInt(item['total']) > 0){
					transaksi += "<option value='"+item['id_transaksi']+"' data-nominal='"+item['total'].replace(/,/g, "")+"'>"+item['id_transaksi']+"  "+item['total']+"</option>";
				}else{
					retur += "<option value='"+item['id_transaksi']+"' data-nominal='"+item['total'].replace(/,/g, "")+"'>"+item['id_transaksi']+"  "+item['total']+"</option>";
				}
			}
		});
		$('input[name=sisa]').val(bayar);
		$('#temp_transaksi').html(transaksi);
		$('#temp_retur').html(retur);
		
		
		$('#temp_transaksi').change(function(e){
			hitung_total();
		});		
		$('#temp_retur').change(function(e){
			hitung_total();
		});
	});
	$('.example tbody').on('click', '.edit', function (e) {
		e.preventDefault();
		var temp = $($($(this).closest('tr').find('td:eq(1)'))[0]['outerHTML']);	
		window.location.replace("<?=base_url('Admin/pembayaran_list?id_person=');?>"+temp.attr('data-id'));
	});
	$(".tgl").datepick({dateFormat: 'dd-mm-yyyy'});
});
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
function hitung_total(){
	// console.log('hitung_total');
	var transaksi = 0;
	$('#temp_transaksi').find('option:selected').each(function(){
		console.log(isNaN($(this).attr('data-nominal')));
		if(!isNaN($(this).attr('data-nominal'))){
			transaksi += +$(this).attr('data-nominal');
			console.log(transaksi);					
		}
	});
	$('#temp_retur').find('option:selected').each(function(){
		console.log(isNaN($(this).attr('data-nominal')));
		if(!isNaN($(this).attr('data-nominal'))){
			transaksi += +$(this).attr('data-nominal');
			console.log(transaksi);					
		}
	});
	$('input[name=total]').val(transaksi.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}
	$.validate();
</script>