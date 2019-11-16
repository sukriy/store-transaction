<!DOCTYPE html>
<html lang="en">
<?php
    include('assets.php');
    $array = array();
    foreach ($load_detail as $key=>$value) {
        $newdata =  array(
            'id_penjualan' => cetak($value->id_penjualan),
            'id_item' => cetak($value->id_item),
            'harga' => number_format(cetak($value->harga), 0),
            'qty' => number_format(cetak($value->qty), 2).' '.cetak($value->satuan),
            'diskon' => cetak_diskon($value->diskon),
            'keterangan' => cetak($value->keterangan),
            'batch' => cetak($value->batch),
            'nama' => cetak($value->nama),
            'diskon0' => cetak_diskon($value->diskon0),
            'subtotal' => number_format($value->subtotal, 0)
        );
        $array[]=$newdata;
    }
    echo "
	<script>
		var detail = ".json_encode($array).";
	</script>";
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="<?=base_url('assets/');?>jspdf.plugin.autotable.js"></script>
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
                                    if (array_search("baru", $hak)!='') {
                                        echo "<button type='submit' class='btn btn-success btn-flat m-b-30 m-t-30' name='tambah'>Tambah</button>";
                                    }
                                ?>
								<?=$this->session->flashdata('penjualan');?>
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
											<th style='display:none'>Kode_penjualan</th>
											<th>Customer</th>
											<th>Sales</th>
											<th>Tgl_penjualan</th>
											<th>Kode Penjualan</th>
											<th>Total</th>
											<th>Keterangan</th>
											<th>Manage</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                            $ada = 0;
                                            foreach ($load as $key=>$value) {
                                                echo "
												<tr role='row'>
													<td class='details-control'></td>
													<td style='display:none'>".cetak($value->id_penjualan)."</td>
													<td>".cetak($value->customer)."</td>
													<td>".cetak($value->sales)."</td>
													<td>".cetak_tgl($value->tgl_penjualan)."</td>
													<td>".cetak($value->id_penjualan)."</td>
													<td align='right'>".number_format(hitung($value->subtotal, 1, $value->diskon), 0)."</td>
													<td>".cetak($value->keterangan)."</td>
													<td>";
                                                echo "<a href='#' class='print' style='color:blue'>Print</a>";
                                                $ada++;

                                                if (array_search("edit", $hak)!='') {
                                                    if ($ada>0) {
                                                        echo "&nbsp;|&nbsp;";
                                                    }
                                                    echo "<a href='#' class='edit' style='color:blue'>Edit</a>";
                                                    $ada++;
                                                }
                                                if (array_search("hapus", $hak)!='') {
                                                    if ($ada>0) {
                                                        echo "&nbsp;|&nbsp;";
                                                    }
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
			if(item['id_penjualan']==d[1]){
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

		$.post("<?=base_url('Admin/ajax_penjualan_print'); ?>", {'id_penjualan' : $(this).closest('tr').find("td").eq(1).text(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
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
		window.location.replace("<?=base_url('Admin/penjualan_modif?id_penjualan=');?>"+$(this).closest('tr').find("td").eq(1).text());
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

				$.post("<?=base_url('Admin/ajax_penjualan_hapus'); ?>", {'hapus' : 1, 'id_penjualan' : $(this).closest('tr').find("td").eq(1).text(), <?php echo $this->security->get_csrf_token_name(); ?>: $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val()}, function(result){
					// console.log(result);
					var result = JSON.parse(result);

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
		window.location.replace("<?=base_url('Admin/penjualan_modif');?>");
	});
function generate(result) {
    var doc = new jsPDF("l", "mm", [216, 139.5]); // 	216 × 279
	var width = doc.internal.pageSize.width;
	var height = doc.internal.pageSize.height;
	console.log('width = '+width);
	console.log('height = '+height);

	var temp4 = 0;
	var temp5 = 0;
	var x0 = 10;
	var x1 = 196;
	var y0 = 45;
	var y1 = 5;

	var x = x0;
	var y = 14;

	const totalPagesExp = '{total_pages_count_string}';

    var elem = document.getElementById("table");
    var res = doc.autoTableHtmlToJson(elem);

	var byk = (res.columns.length)-1;

	if(byk == 5){
		// byk = 5
		var pageContent = function (data) {
			// HEADER
			var y2 = data.settings.margin.top+7;
			var x_temp = 35;
			y2 = y2 - 40;
			doc.setDrawColor(0);
			doc.setFontSize(20);
			doc.text("FAKTUR", width/2-10, y2);

			doc.setFontSize(40);
			doc.setTextColor(40);
			doc.setFontStyle('normal');
			doc.text("SP", x, y2+10);
			doc.setFontSize(18);
			doc.text("MEDAN", x+17, y2+10);

			doc.setFontSize(11);
			y2 = y2 + 4;
			doc.text("Kepada Yth, ", width/2+x_temp, y2);

			y2 = y2 + 4;
			doc.text(result['nilai'][0]['customer'], width/2+x_temp, y2);

			y2 = y2 + 4;
			doc.text("No", x, y2+4);
			doc.text(":", x+15, y2+4);
			doc.text(result['nilai'][0]['id_penjualan'], x+18, y2+4);
			doc.text("Di", width/2+x_temp, y2);

			y2 = y2 + 4;
			doc.text("Tanggal", x, y2+4);
			doc.text(":", x+15, y2+4);
			doc.text(result['nilai'][0]['tgl_penjualan'], x+18, y2+4);
			doc.text(result['nilai'][0]['alamat'], width/2+x_temp, y2);

			doc.setFontType("bold");
			y2 = y2 + 6;
			doc.line(x0, y2, x0+x1, y2); // horizontal line
			y2 = y2 + 5;
			doc.text("No", x0+4,y2);
			doc.text("Nama Barang", x0+48,y2);
			doc.text("Qty", x1-73,y2);
			doc.text("Harga", x1-55,y2);
			doc.text("Diskon", x1-36,y2);
			doc.text("Total", x1-10,y2);

			y2 = y2 + 2;
			doc.line(x0, y2, x0+x1, y2); // horizontal line
			doc.setFontType("normal");

			// FOOTER
			var str = "Page " + data.pageCount;
			// Total page number plugin only2 available in jspdf v1.0+

			if (typeof doc.putTotalPages === 'function') {
				str = str + " of " + totalPagesExp;
			}
			doc.setFontSize(10);
			var pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
			doc.text(str, x1, 10);
		};
		const options = {
			addPageContent: pageContent,
			showHeader: 'everyPage',
			pageBreak: 'auto',
			theme: 'plain', // 'striped', 'grid' or 'plain'
			// startY: 43,
			margin: {
				top: 45,
				right: 10,
				left: 10,
				bottom: 17
			},
			styles: {
				fontSize: 11,
				overflow: 'linebreak',
				halign: 'right', // left, center, right
				valign: 'bottom',
				// lineColor: [0, 0, 0],
				// lineWidth: 0.3
			},
			columnStyles: {
				0: {columnWidth: 12},
				1: {columnWidth: 'auto', halign: 'left'},
				2: {columnWidth: 30},
				3: {columnWidth: 20},
				4: {columnWidth: 25},
				5: {columnWidth: 30},
			},
			drawHeaderRow: function(row, data) {
				return false;
			},
			drawRow: function(row, data) {
				row.height = 5;
			},
		};
		doc.autoTable(res.columns, res.data, options);
	}else{
		// byk = 4
		// byk = 5
		var pageContent = function (data) {
			// HEADER
			var y2 = data.settings.margin.top+7;
			var x_temp = 35;
			y2 = y2 - 40;
			doc.setDrawColor(0);
			doc.setFontSize(20);
			doc.text("FAKTUR", width/2-10, y2);

			doc.setFontSize(40);
			doc.setTextColor(40);
			doc.setFontStyle('normal');
			doc.text("SP", x, y2+10);
			doc.setFontSize(18);
			doc.text("MEDAN", x+17, y2+10);

			doc.setFontSize(11);
			y2 = y2 + 4;
			doc.text("Kepada Yth, ", width/2+x_temp, y2);

			y2 = y2 + 4;
			doc.text(result['nilai'][0]['customer'], width/2+x_temp, y2);

			y2 = y2 + 4;
			doc.text("No", x, y2+4);
			doc.text(":", x+15, y2+4);
			doc.text(result['nilai'][0]['id_penjualan'], x+18, y2+4);
			doc.text("Di", width/2+x_temp, y2);

			y2 = y2 + 4;
			doc.text("Tanggal", x, y2+4);
			doc.text(":", x+15, y2+4);
			doc.text(result['nilai'][0]['tgl_penjualan'], x+18, y2+4);
			doc.text(result['nilai'][0]['alamat'], width/2+x_temp, y2);

			doc.setFontType("bold");
			y2 = y2 + 6;
			doc.line(x0, y2, x0+x1, y2); // horizontal line
			y2 = y2 + 5;
			doc.text("No", x0+4,y2);
			doc.text("Nama Barang", x0+57,y2);
			doc.text("Qty", x1-53,y2);
			doc.text("Harga", x1-35,y2);
			doc.text("Total", x1-10,y2);

			y2 = y2 + 2;
			doc.line(x0, y2, x0+x1, y2); // horizontal line
			doc.setFontType("normal");

			// FOOTER
			var str = "Page " + data.pageCount;
			// Total page number plugin only2 available in jspdf v1.0+

			if (typeof doc.putTotalPages === 'function') {
				str = str + " of " + totalPagesExp;
			}
			doc.setFontSize(10);
			var pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
			doc.text(str, x1, 10);
		};
		const options = {
			addPageContent: pageContent,
			showHeader: 'everyPage',
			pageBreak: 'auto',
			theme: 'plain', // 'striped', 'grid' or 'plain'
			// startY: 43,
			margin: {
				top: 45,
				right: 10,
				left: 10,
				bottom: 17
			},
			styles: {
				fontSize: 11,
				overflow: 'linebreak',
				halign: 'right', // left, center, right
				valign: 'bottom',
				// lineColor: [0, 0, 0],
				// lineWidth: 0.3
			},
			columnStyles: {
				0: {columnWidth: 12},
				1: {columnWidth: 'auto', halign: 'left'},
				2: {columnWidth: 30},
				3: {columnWidth: 25},
				4: {columnWidth: 30},
			},
			drawHeaderRow: function(row, data) {
				return false;
			},
			drawRow: function(row, data) {
				row.height = 5;
			},
		};
		doc.autoTable(res.columns, res.data, options);
	}


	var kolom = doc.autoTable.previous.columns;
	var temp0 = x;
	var temp1 = x;
	var temp3 = x;
	$.each(kolom, function(index, item) {
		if(index <= (kolom.length-1)){
			if(index <= (kolom.length-2)){
				temp1 += item.width;
			}
			if(index <= (kolom.length-3)){
				temp0 += item.width;
			}
			temp3 += item.width;
		}
	});
	doc.setFontSize(11);
	var selisih = temp3-temp0;
	console.log('temp3 = '+temp3);
	temp3 -= 12;
	console.log('temp3 = '+temp3);

	var x0 = doc.autoTable.previous.pageStartX;
	var x1 = doc.autoTable.previous.width;
	var y0 = doc.autoTable.previous.pageStartY;
	var y1 = 5;

	console.log('x0 = '+x0);
	console.log('x1 = '+x1);
	console.log('y0 = '+y0);
	console.log('y1 = '+y1);

	if(parseFloat(result.nilai[0].diskon) != 0){
		var y_final = (doc.internal.pageSize.height) - 35;
	}else{
		var y_final = (doc.internal.pageSize.height) - 25;
	}
	doc.line(x0, y_final, temp0, y_final);

	doc.text('Diterima oleh',x0+30, y_final+5);
	doc.text('(__________________)',x0+23, y_final+20);
	doc.text('Hormat Kami',x0+95, y_final+5);
	doc.text('(__________________)',x0+88, y_final+20);
	//height
	y_final -= y1;
	var temp2;

	if(parseFloat(result.nilai[0].diskon) != 0){
		temp2 = result.nilai[0].subtotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		if(temp2.length < 4){
			temp3 += 4;
		}

		y_final += y1;
		doc.line(temp0, y_final, x0+x1, y_final);
		doc.text('Subtotal', temp0+2, y_final+4);
		doc.line(temp1, y_final, temp1, y_final+y1);
		doc.text(temp2, temp3-temp2.length, y_final+4);
		doc.rect(temp0, y_final, selisih, y1);

		temp2 = result.nilai[0].diskon;
		y_final += y1;
		doc.line(temp0, y_final, x0+x1, y_final);
		doc.text('Diskon', temp0+2, y_final+4);
		doc.line(temp1, y_final, temp1, y_final+y1);
		doc.text(temp2, temp3-temp2.length, y_final+4);
		doc.rect(temp0, y_final, selisih, y1);
	}
	temp2 = result.nilai[0].total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	y_final += y1;
	doc.line(temp0, y_final, x0+x1, y_final);
	doc.text('Total', temp0+2, y_final+4);
	doc.line(temp1, y_final, temp1, y_final+y1);
	doc.text(temp2, temp3-temp2.length, y_final+4);
	doc.rect(temp0, y_final, selisih, y1);

	y_final += (y1+4);
	doc.setFontSize(10);
	doc.text('NB: Jumlah barang dianggap benar',temp0-4, y_final+(0*4));
	doc.text('apabila tidak ada pemberitahuan',temp0-4, y_final+(1*4));
	doc.text('paling lama 1 minggu setelah',temp0-4, y_final+(2*4));
	doc.text('barang diterima.',temp0-4, y_final+(3*4));


	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

    doc.save('invoice.pdf');
}
</script>
