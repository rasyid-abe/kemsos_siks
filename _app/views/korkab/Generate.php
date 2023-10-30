<link rel="stylesheet" type="text/css" href="<?php echo base_url( 'assets/addons/flexigrid/css/flexigrid.css' );?>">
<style>
	#loader{display: none; opacity: 0.5; } .spin {position: absolute; left: 50%; top: 50%; z-index: 1; color: #fff; } .text {color:#fff; font-size: 20px; position: absolute; left: 49%; bottom: 30%; } </style>
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<div id="response_message" style="display:none;"></div>
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<table id="gridview" style="display:none;"></table>
					</div>
					<div class="col-md-6 col-sm-12">
						<input type="number" name="value_generate" id="value_generate" value="">
						<button type="button" class="btn btn-sm btn-primary btn-generate col-md-2 f-w-900" >
							Proses
						</button>
						<table id="gridview2" style="display:none;"></table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<div id="response_message" style="display:none;"></div>

			</div>
		</div>
	</div>
</div>

<div id="loader" class="modal-backdrop">
	<div class="spin">
		<span class="fa fa-spinner fa-spin fa-4x"></span>
	</div>
	<span class="text">Loading...</span>
</div>

<div id="modalForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div id="modalContent" class="modal-content">
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url( 'assets/addons/daterangepicker/moment.js' );?>"></script>
<!-- <script type="text/javascript" src="<?php echo base_url( 'assets/addons/jquery/jquery.slimscroll.min.js' );?>"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/select2/select2.js' );?>"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/daterangepicker/daterangepicker.js' );?>"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/flexigrid/js/flexigrid-ed.js' );?>"></script>
<script>
	$("#gridview").flexigrid({
		url: '<?php echo $grid['link_data']; ?>',
		dataType: 'json',
		colModel: [<?php echo $grid['columns'];?>],
		buttons: [<?php echo $grid['toolbars'];?>],
		searchitems: [<?php echo $grid['filters'];?>],
		sortname: "<?php echo $grid['col_id'];?>",
		sortorder: "<?php echo ( ( isset( $grid['sort'] ) ) ? $grid['sort'] : 'asc' );?>",
		usepager: true,
		title: 'User List (Supervisor)',
		useRp: true,
		rp: 50,
		showTableToggleBtn: false,
		showToggleBtn: true,
		width: 'auto',
		height: '400',
		resizable: false,
		singleSelect: true
	});
	$('#gridview').click(function(event){
		$('.trSelected', this).each( function(){
		//	console.log( ' rowId: ' + $(this).attr('id').substr(3) + ' name: ' + $('td[abbr="name"] >div', this).html() + ' sign: ' + $('td[abbr="sign"] >div', this).html() + ' status: ' + $('td[abbr="status"] >div', this).html() );
			$("#loader").modal("show");
			$( "#gridview2" ).flexOptions({
				url: "<?php echo base_url('korkab/generate/get_show_location/'); ?>",
				params: [
					{
						"id": $(this).attr('id').substr(13)
					},
				],
			}).flexReload();
			$("#loader").modal("hide");

		});
	});
	$("#gridview2").flexigrid({
		url: "<?php echo base_url('korkab/generate/get_show_location/'); ?>",
		dataType: 'json',
		colModel: [<?php echo $grid2['columns'];?>],
		buttons: [<?php echo $grid2['toolbars'];?>],
		searchitems: [<?php echo $grid2['filters'];?>],
		sortname: "<?php echo $grid2['col_id'];?>",
		sortorder: "<?php echo ( ( isset( $grid2['sort'] ) ) ? $grid2['sort'] : 'asc' );?>",
		usepager: true,
		title: 'Selected Locations',
		useRp: true,
		rp: 50,
		showTableToggleBtn: false,
		showToggleBtn: true,
		width: 'auto',
		height: '375',
		resizable: false,
		singleSelect: false
	});

	function add(com, grid, urlaction) {
		show_form( urlaction );
	}

	function show_form( url ){
		$.ajax({
			url:url,
			type: 'GET',
			dataType: 'html',
			beforeSend: function( xhr ) {
				$('#loader').modal('show');
			},
			success : function(data) {
				$('#loader').modal('hide');
				$('#modalContent').html(data);
				$('#modalForm').modal('show');
			},
		});
	}

	$(document).ready(function() {

		$(document).on( 'click', 'button.btn-edit', function(){
			show_form( $(this).attr('act') );
		});

		$(document).on( 'click', 'button.btn-generate', function(){
			var rowId = $('.trSelected', $("#gridview2"));
			val_gen = $('#value_generate').val();
			var arr_id = [];
			var i = 0;
			$.each(rowId,function(key, value){
				asd = value.children[5].innerText;
				if (asd == '0') {
					alert('Maaf, Anda tidak diperbolehkan memilih desa dengan prelist 0');
					die;
				}
			});
			if (val_gen.length == 0 || val_gen==0) {
                    alert('Maaf, nilai generate harus diisi atau nilai lebih dari 0');
					die;
            }
			$('.trSelected', $("#gridview2")).each(function () {
				var id = $(this).attr('data-id');
				arr_id.push(id);
				i++;
			});
			$.ajax({
				url : "<?php echo base_url('korkab/generate/get_data_location/'); ?>",
				data :  "item=" + JSON.stringify(arr_id) + "&val_gen=" + val_gen,
				dataType : 'json',
				async: false,
				method : 'post',
				success : function( data ) {
					if ( data.status == 200 ) {
						alert(data.message);
						$("#loader").modal("show");
						$( "#gridview2" ).flexReload();
						$("#loader").modal("hide");
					} else {
						alert(data.message);
					}
				},
			});

			/* $.each(rowId,
                            function(key, value){
								asd = value.children[5].innerText;
								if (asd == '0') {
									alert('Maaf, Anda tidak diperbolehkan memilih desa dengan prelist 0');
								//	return;
								}
								else
								{
									alert('mantap');
								//	return;
								}

                        }); */
			//var conf = confirm('Delete ' + asd + ' items?');
			//alert(conf);
		});

		$("#response_message").fadeTo(2000, 500).slideUp(500, function(){
			$("#response_message").slideUp(500);
		});

		<?php
			if ( isset( $cari ) ) {
		?>

		$('#panel_header').on( 'click', function(){
			$('.search-arrow').toggleClass('fa-caret-square-right fa-caret-square-down')
			$('#search_body').slideToggle( "slow", function() {
			});
			$('#search_footer').slideToggle( "slow", function() {
			});
		});
		<?php
			}
		?>

		$('#modalForm').on('hidden.bs.modal', function () {
			$( '#modalContent' ).empty();
		});
	});

</script>
