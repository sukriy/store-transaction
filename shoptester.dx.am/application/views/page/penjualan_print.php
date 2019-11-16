<table id="table" style='display:none'>
    <thead>
		<tr>
			<th>Coly</th>
			<th>Nama Barang</th>
			<th>Qty</th>
			<th>Harga</th>
			<?php
				if($detail[0]->diskon9>0) {echo "<th>Diskon</th>";}
			?>
			<th>Total</th>
		</tr>
    </thead>
    <tbody>
		<?php
			$i=1;
			$total=0;
			$qty=0;
			foreach($detail as $key=>$value){
				$total += $value->subtotal;
				echo "
				<tr>
					<td>".cetak($i++)."</td>
					<td>".cetak_print($value->nama)."</td>
					<td>".$value->qty." ".cetak($value->satuan)."</td>
					<td>".cetak(number_format($value->harga,0))."</td>
				";
				if($detail[0]->diskon9>0) {echo "<td>".cetak_diskon($value->diskon)."</td>";}
				echo "
					<td>".cetak(number_format($value->subtotal,0))."</td>
				</tr>
				";
			}
		?>
    </tbody>
</table>