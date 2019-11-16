<!DOCTYPE html>
<html lang="en">
<?php
	include('assets.php');
	if(isset($load)){
		$date1=date_create($load[0]->tgl_retur_beli);
		$date2=date_create($load[0]->tgl_TOP);
		$diff=date_diff($date1,$date2);
		$load[0]->jatuh_tempo = abs($diff->format("%R%a"));		
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
							<h3>Retur Pembelian <?=(isset($load[0]->id_retur_beli) ? 'EDIT' : 'INPUT BARU'); ?></h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">								
									<ol class="breadcrumb text-right">
										<li><a href="<?=base_url();?>">Dashboard</a></li>
										<li><a href="<?=base_url('Admin/retur_beli');?>">Retur Beli</a></li>
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
									<?=$this->session->flashdata('retur_beli_modif');?>
									<?=$this->session->flashdata('message');?>
									<?=((validation_errors()!='') ? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' : ''); ?>
									<?=form_open_multipart('Admin/retur_beli_Modif/','id="form_temp"');?> 
										<input type='hidden' class='form-control' name='uniqid' value='<?=uniqid(); ?>'>
										<input type="hidden" class="form-control" name='id_retur_beli' value='<?=(isset($load[0]->id_retur_beli) ? cetak($load[0]->id_retur_beli) :(isset($_POST['id_retur_beli']) ? cetak($_POST['id_retur_beli']) : (isset($_GET['id_retur_beli']) ? cetak($_GET['id_retur_beli']) : ''))); ?>'>
										<input type="hidden" id='token' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
										
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="tgl_retur_beli">Tgl Retur Pembelian</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control tgl" autocomplete="off" name='tgl_retur_beli' value='<?=(isset($load[0]->tgl_retur_beli) ? cetak_tgl($load[0]->tgl_retur_beli) : (isset($_POST['tgl_retur_beli']) ? $_POST['tgl_retur_beli'] : '')); ?>' 
													data-validation="date" 
													data-validation-format="dd-mm-yyyy"
												>					
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="supplier">Supplier</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select data-placeholder="Pilih Supplier..." class="form-control standardSelect" name='id_supplier'>
													<option value=""></option>
													<?php
														foreach($list->result() as $row){
															echo "<option value='".cetak($row->id_person)."' ".((isset($load[0]->id_supplier) && cetak($load[0]->id_supplier)==cetak($row->id_person)) ? 'selected' : ((isset($_POST['id_supplier']) && cetak($_POST['id_supplier'])==cetak($row->id_person)) ? 'selected' : '')).">".cetak($row->nama_person)."</option>";
														}
													?>
												</select>
												<small class="form-text text-danger" id='error0'></small>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="jatuh_tempo">Jatuh Tempo (Hari)</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control only_angka" name='jatuh_tempo' value='<?=(isset($load[0]->jatuh_tempo) ? cetak($load[0]->jatuh_tempo) : (isset($_POST['jatuh_tempo']) ? cetak($_POST['jatuh_tempo']) : '')); ?>' 
													data-validation="required length" 
													data-validation-length="max3"
												>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="diskon">Diskon</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control diskon" name='diskon' value='<?=(isset($load[0]->diskon) ? cetak_diskon($load[0]->diskon) : (isset($_POST['diskon']) ? cetak_diskon($_POST['diskon']) : '')); ?>' 
													data-validation="required" 
												>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="keterangan">Keterangan</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<textarea class="form-control" rows="5" name='keterangan' 
													data-validation="length" 
													data-validation-length="max1000"
												><?=(isset($load[0]->keterangan) ? cetak($load[0]->keterangan) : (isset($_POST['keterangan']) ? cetak($_POST['keterangan']) : '')); ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="item">Item</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select data-placeholder="Pilih Item..." class="form-control standardSelect" tabindex="1" name='item0'>
													<option value=""></option>
													<?php
														$list_item = array();
														foreach($item as $key=>$value){
															echo "<option value='".cetak($value['id_item'])."'>".cetak($value['nama'])." - ".cetak($value['stock_sisa'])."</option>";
															$newdata =  array (
																'id_item' => cetak($value['id_item']),
																'satuan' => cetak($value['satuan'])
															);
															$list_item[]=$newdata;
														}
														echo "
														<script>
															var list_item = ".json_encode($list_item).";
														</script>";		
													?>
												</select>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" class="form-control angka" name='satuan_item0' placeholder='Satuan....' readonly>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" class="form-control angka" name='qty_item0' placeholder='Qty...'>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" class="form-control angka" name='harga_item0' placeholder='Harga....'>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" class="form-control diskon" name='diskon_item0' placeholder='Diskon...'>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="text" class="form-control angka" readonly name='SubTotal_item0' placeholder='SubTotal...'>
											</div>
											<div class="col-md-1 col-sm-1 col-xs-12">
												<button type="button" class="btn btn-success" name='tambah'>+</button>
											</div>
										</div>
										<div class="form-group row">
											<div class='container'>
												<div class="table-responsive">
													<table class="table table-striped table-bordered">
														<thead>
															<tr>
																<th style='display:none'>ID_Item</th>
																<th>Item</th>
																<th>Qty</th>
																<th>Harga</th>
																<th>Diskon</th>
																<th>SubTotal</th>
																<th>Keterangan</th>
																<th>#</th>
															</tr>
														</thead>
														<tbody>
												<?php
													echo "
													<script>
														var check = new Array();
													</script>";
													if(isset($load) || isset($_POST['id_item'])){
														if(isset($_POST['id_item'])){
															$array = array();
															foreach($_POST['id_item'] as $key=>$value){
																if(isset($_POST['id_retur_beli']) && $_POST['id_retur_beli']!=''){
																	$newdata =  array (
																		'id_retur_beli' => cetak0($_POST['id_retur_beli']),
																		'id_item' => cetak0($_POST['id_item'][$key]),
																		'nama_item' => cetak0($_POST['nama_item'][$key]),
																		'harga' => cetak0($_POST['harga_item'][$key]),
																		'qty' => cetak0($_POST['qty_item'][$key]),
																		'satuan' => cetak0($_POST['satuan_item'][$key]),
																		'diskon_item' => cetak0($_POST['diskon_item'][$key]),
																		'subtotal' => cetak0($_POST['subtotal_item'][$key]),
																		'keterangan_item' => cetak0($_POST['keterangan_item'][$key])
																	);																	
																}else{
																	$newdata =  array (
																		'id_item' => cetak0($_POST['id_item'][$key]),
																		'nama_item' => cetak0($_POST['nama_item'][$key]),
																		'harga' => cetak0($_POST['harga_item'][$key]),
																		'qty' => cetak0($_POST['qty_item'][$key]),
																		'satuan' => cetak0($_POST['satuan_item'][$key]),
																		'diskon_item' => cetak0($_POST['diskon_item'][$key]),
																		'subtotal' => cetak0($_POST['subtotal_item'][$key]),
																		'keterangan_item' => cetak0($_POST['keterangan_item'][$key])
																	);
																}
																$array[]=array_to_object($newdata);
															}
															$load = $array;
														}

														foreach($load as $key=>$value){
															echo "
															<tr>
																<td>
																	<input type='text' readonly style='display:none; border:none' name='id_item[]' value='".cetak($value->id_item)."'>
																	<input type='text' readonly style='display:none; border:none' name='nama_item[]' value='".cetak($value->nama_item)."'>".cetak($value->nama_item)."
																</td>
																<td>
																	<input type='text' readonly style='display:none; border:none' name='qty_item[]' value='".number_format(cetak($value->qty),2)."'>
																	<input type='text' readonly style='display:none; border:none' name='satuan_item[]' value='".cetak($value->satuan)."'>
																	".number_format(cetak($value->qty),2)." ".cetak($value->satuan)."
																</td>
																<td>
																	<input type='text' readonly style='display:none; border:none' name='harga_item[]' value='".number_format(cetak($value->harga),0)."'>".number_format(cetak($value->harga),0)."
																</td>
																<td>
																	<input type='text' readonly style='display:none; border:none' name='diskon_item[]' value='".cetak_diskon($value->diskon_item)."'>".cetak_diskon($value->diskon_item,0)."
																</td>
																<td>
																	<input type='text' readonly style='display:none; border:none' class='substotal' name='subtotal_item[]' value='".number_format(cetak($value->subtotal),0)."'>".number_format(cetak($value->subtotal),0)."
																</td>
																<td>
																	<textarea type='text' style='border:none' name='keterangan_item[]' cols='4'>".cetak($value->keterangan_item)."</textarea>
																</td>
																<td>
																	<button type='button' class='btn btn-danger hapus'>X</button>
																</td>
															</tr>
															<script>
																check.push('".cetak($value->id_item)."');
															</script>
															";
														}
													}
												?>														
														</tbody>
														<tfoot>
															<tr>
																<td colspan='4'>Total</td>
																<td id='total_beli'>0</td>
																<td></td>
																<td></td>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success control-label col-md-10 col-sm-10 col-xs-12" name='submit' value=<?=(isset($load[0]->id_retur_beli) ? 'edit' : 'baru');?>><?=(isset($load[0]->id_retur_beli) ? 'EDIT' : 'INPUT BARU'); ?></button>
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
$(window).load(function() {
	$('.hapus').click(function(){
		check.splice($.inArray($($($(this).closest('tr')[0]['cells'][0]['children'][0])).val(), check), 1);
		$(this).closest('tr').remove();
		hitung0();
	});
});
hitung0();
	$('button[name=tambah]').click(function(e){
		e.preventDefault();
		if($('select[name=item0]').val()=='' || $('input[name=harga_item0]').val()=='' || $('input[name=qty_item0]').val()=='' || $('input[name=diskon_item0]').val()==''){
			swal("INFO", "Harap isi semua kolom", "warning");
		}else{
			abc();
			hitung();
			if($('input[name=SubTotal_item0]').val().replace(/,/g , '') > 0){
				if($.inArray($('select[name=item0]').val(), check) == -1){
					check.push($('select[name=item0]').val());
					var qty = Math.round($('input[name=qty_item0]').val().replace(/,/g , '') * 100) / 100;
					$('input[name=qty_item0]').val(qty);
					
					var txt = "<tr><td><input type='text' readonly style='display:none; border:none' name='id_item[]' value='"+$('select[name=item0]').val()+"'><input type='text' readonly style='display:none; border:none' name='nama_item[]' value='"+$("select[name=item0] option:selected").text()+"'>"+$("select[name=item0] option:selected").text()+"</td><td><input type='text' readonly style='display:none; border:none' name='qty_item[]' value='"+$('input[name=qty_item0]').val()+"'><input type='text' readonly style='display:none; border:none' name='satuan_item[]' value='"+$('input[name=satuan_item0]').val()+"'>"+$('input[name=qty_item0]').val()+" "+$('input[name=satuan_item0]').val()+"</td><td><input type='text' readonly style='display:none; border:none' name='harga_item[]' value='"+$('input[name=harga_item0]').val()+"'>"+$('input[name=harga_item0]').val()+"</td><td><input type='text' readonly style='display:none; border:none' name='diskon_item[]' value='"+$('input[name=diskon_item0]').val()+"'>"+$('input[name=diskon_item0]').val()+"</td><td><input type='text' readonly style='display:none; border:none' class='substotal' name='subtotal_item[]' value='"+$('input[name=SubTotal_item0]').val()+"'>"+$('input[name=SubTotal_item0]').val()+"</td><td><textarea type='text' style='border:none' name='keterangan_item[]' cols='4'></textarea></td><td><button type='button' class='btn btn-danger hapus'>X</button></td></tr>";
					$('tbody').append(txt);

					$('select[name=item0]').val('');
					$('input[name=harga_item0]').val('');
					$('input[name=qty_item0]').val('');
					$('input[name=diskon_item0]').val('');		
					$('input[name=satuan_item0]').val('');
					$('input[name=SubTotal_item0]').val(0);
					
					$('.hapus').click(function(){
						check.splice($.inArray($($($(this).closest('tr')[0]['cells'][0]['children'][0])).val(), check), 1);
						$(this).closest('tr').remove();
						hitung0();
					});
					hitung0();
				}else{
					swal("INFO", "Item Telah ada", "warning");
				}
			}else{
				swal("INFO", "Tidak boleh minus", "warning");
			}
		}
	});
	$('select[name=item0]').change(function(e){
		e.preventDefault();
		abc();
		hitung();
	});
	$('input[name=harga_item0]').keyup(function(e){
		e.preventDefault();
		abc();
		hitung();
	});
	$('input[name=qty_item0]').keyup(function(e){
		e.preventDefault();
		abc();
		hitung();
	});
	$('input[name=diskon_item0]').keyup(function(e){
		e.preventDefault();
		abc();
		hitung();
	});
	$('select[name=item0]').change(function(e){
		e.preventDefault();
		var nilai0 = $(this).val();
		$.each( list_item, function( index, value ){
			if(value['id_item']==nilai0){
				$('input[name=satuan_item0]').val(value['satuan']);
			}
		});
		abc();
	});
	function hitung(){
		var diskon = $('input[name=diskon_item0]').val().replace(/,/g , '');
		var qty = Math.round($('input[name=qty_item0]').val().replace(/,/g , '') * 100) / 100;
		var subtotal = Math.round($('input[name=harga_item0]').val().replace(/,/g , '')*qty);

		if(diskon.includes("%")){
			diskon = diskon.replace(/%/g , '').split("+");
			$.each( diskon, function( index, value ){
				subtotal = subtotal * (100-value) / 100;
			});
		}else{
			diskon = diskon.replace(/%/g , '').split("+");
			$.each( diskon, function( index, value ){
				if(value != ''){
					subtotal = subtotal - value;
				}
			});
		}
		$('input[name=SubTotal_item0]').val(Math.round(subtotal).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
	}
	function hitung0(){
		var total_beli = 0;
		$('.substotal').each(function(){
			total_beli += +$(this).val().replace(/,/g , '');
		})	
		$('#total_beli').html(total_beli.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
	}
	function abc(){
		if($('select[name=item0]').val()!=''){
			var str = ($('select[name=item0] :selected').text()).split(' - ');
			str = str[(str.length)-1];
			str = Number(str.replace(/,/g, "").toString());
			
			var nilai = Number($('input[name=qty_item0]').val().replace(/,/g, "").toString());
			if(isNaN(nilai)){
				$('input[name=qty_item0]').val(0);
			}else{
				if(nilai>str){
					swal("Stock", "Melebihi Stock", "error");
					$('input[name=qty_item0]').val(0);
				}
				if(nilai<0){
					swal("Stock", "Stock tidak boleh minus", "error");
					$('input[name=qty_item0]').val(0);
				}
			}			
		}	
	}	
	$.validate();
</script>