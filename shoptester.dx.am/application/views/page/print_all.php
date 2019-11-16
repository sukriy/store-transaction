<table id='example_table' style="display:none">
	<thead>
		<tr>
			<th>ID_ITEM</th>
			<th>ITEM</th>
			<th>Stock</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach($cetak as $key=>$value){
	echo "
	<tr>
		<td>".cetak($value->id_item)."</td>
		<td>".cetak($value->nama)."</td>
		<td>".number_format($value->stock_sisa,2).' '.cetak($value->satuan)."</td>
	</tr>
	";
}
?>
	</tbody>
</table>
