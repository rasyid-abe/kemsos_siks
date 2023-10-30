<link rel="stylesheet" type="text/css" href="<?php echo base_url( 'assets/addons/flexigrid/css/flexigrid.css' );?>">
<style>
#loader{display: none; opacity: 0.5; } .spin {position: absolute; left: 50%; top: 50%; z-index: 1; color: #fff; } .text {color:#fff; font-size: 20px; position: absolute; left: 49%; bottom: 30%; }.hasDateRange{z-index: 1100 !important;}
</style>
<?php
if ( isset( $extra_style ) ) {
    echo $extra_style;
}
?>
	<div class="card">
		<div class="card-body">
<?php 
if ( isset( $cari ) ) {
?>
	<?php echo $cari;?> 			
<?php
}
?>
			<div id="response_message" style="display:none;"></div>
			<table id="gridview" style="display:none;"></table>

			<div id="loader" class="modal-backdrop">
				<div class="spin">
					<span class="fa fa-spinner fa-spin fa-4x"></span>
				</div>
				<span class="text">Loading...</span>
			</div>
		</div>
	</div>

<div class="modal" id="modalForm">
	<div class="modal-dialog modal-lg">
		<div id="modalContent" class="modal-content">
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url( 'assets/addons/daterangepicker/moment.js' );?>"></script>
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
		title: '',
		useRp: true,
		rp: 50,
		showTableToggleBtn: false,
		showToggleBtn: true,
		width: 'auto',
		height: '500',
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
		$(document).on( 'click', '#btn_save', function() {
			$.ajax({
				url: $( '#form-data' ).attr( 'action' ),
				type: 'POST',
				dataType: 'json',
				data: $('#form-data').serialize(),
				beforeSend: function( xhr ) {
					$('#modalLoader').modal('show');
				},
				success : function(data) {
					if ( data.status == 200 ) {
						$('#modalForm').modal('hide');
						$('#gridview').flexReload();
						$('#response_message').html(data.msg).show().addClass('alert alert-success');
					} else {
						alert(data.msg);
					}
				},
			});
		});

		$(document).on( 'click', 'button.btn-edit', function(){
			show_form( $(this).attr('act') );
		});

		$("#response_message").fadeTo(2000, 500).slideUp(500, function(){
			$("#response_message").slideUp(500);
		});

<?php if ( isset( $cari ) ) { ?>
		$('#panel_header').on( 'click', function(){
			$('.search-arrow').toggleClass('fa-caret-square-right fa-caret-square-down')
			$('#search_body').slideToggle( "slow", function() {
			});
			$('#search_footer').slideToggle( "slow", function() {
			});
		});
<?php } ?>
	});
</script>
<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
