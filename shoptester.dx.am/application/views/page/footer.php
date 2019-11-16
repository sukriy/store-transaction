	<div class="se-pre-con"></div>
	<style>	
		.datepick-popup{
			z-index: 999999;
			position: absolute;
			top: 0px;
		}
		.no-js #loader { display: none;  }
		.js #loader { display: block; position: absolute; left: 100px; top: 0; }
		.se-pre-con {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(<?=base_url('images/Preloader.gif'); ?>) center no-repeat;
		}
	</style>

    <!-- jQuery -->
	<script src="<?=base_url('assets/jquery/jquery-2.2.3.min.js')?>"></script>
	<script src="<?=base_url('assets/'); ?>magnific-popup/jquery.magnific-popup.js"></script>

	<script src="<?=base_url('assets/exportexcel/'); ?>/jquery.table2excel.js"></script>

	
	<script src="<?=base_url('assets/datepicker/');?>js/jquery.plugin.min.js"></script>
	<script src="<?=base_url('assets/datepicker/');?>js/jquery.datepick.js"></script>	

    <!-- Bootstrap -->
    <script src="<?=base_url('assets/'); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=base_url('assets/'); ?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- Datatables -->
	<script src="<?=base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>	
	
    <!-- Custom Theme Scripts -->
    <script src="<?=base_url('assets/'); ?>build/js/custom.min.js"></script>
    <script type="text/javascript">
		$(".se-pre-con").fadeOut("slow");
        $(".tgl").datepick({dateFormat: 'dd-mm-yyyy'});
		var table = $('.example').DataTable({
			"fnDrawCallback": function () {
				$('.image-link').magnificPopup({
					type: 'image'
				});
			}
		});	
		var table2 = $('.example2').DataTable({
			"fnDrawCallback": function () {
				$('.image-link').magnificPopup({
					type: 'image'
				});
			},
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv'
			]
		});	
        $(document).ready(function() {
			$('.angka').change(function(){
				var temp = Number($(this).val().replace(/,/g, "")).toString();
				$(this).val(temp.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
			});
			$('.angka_qty').keypress(function(evt){
				console.log($(this).val());
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode != 46 && charCode > 31	&& (charCode < 48 || charCode > 57))
					return false;
				return true;
			});	
			$('.angka').keypress(function(evt){				
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode != 46 && charCode > 31	&& (charCode < 48 || charCode > 57))
					return false;
				return true;
			});	
			$('.only_angka').keypress(function(evt){
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode != 46 && charCode > 31	&& (charCode < 48 || charCode > 57))
					return false;
				return true;
			});
			$('.diskon').keypress(function(evt){
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode != 37 && charCode != 43 && charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
					return false;
				return true;
			});	
			$('.diskon').change(function(){
				$(this).val($(this).val().replace(/,/g, ""));
				console.log($(this).val());
				if($.isNumeric($(this).val())){
					$(this).val(Number($(this).val().replace(/,/g, "")).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
				}
			});
			$('.image-link').magnificPopup({type:'image'});
		});
    </script>	
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>	
<script src="<?php echo base_url().'assets/autocomplete/js/jquery-ui.js'?>" type="text/javascript"></script>	


