<link rel="stylesheet" type="text/css" href="<?php echo base_url( 'assets/addons/flexigrid/css/flexigrid.css' );?>">
<style>
#loader{display: none; opacity: 0.5; } .spin {position: absolute; left: 50%; top: 50%; z-index: 1; color: #fff; } .text {color:#fff; font-size: 20px; position: absolute; left: 49%; bottom: 30%; }.hasDateRange{z-index: 1100 !important;}
</style>
<?php
if ( isset( $extra_style ) ) {
    echo $extra_style;
	//$grid['title'];
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
		height: '400',
		resizable: false,
		singleSelect: true
	});

	function add(com, grid, urlaction) {
		show_form( urlaction );
	}

	function show_form( url ){
		window.open(url);
        return false;
	}

	function get_selected(com, grid, urlaction) {
		if ( $(".trSelected", grid).length > 0 ) {
			var arr_id = [];
			var i = 0;
			$( ".trSelected", grid ).each( function () {
				let code = $(this).find("[abbr=status_code]").text();
				if ( code == "11" || code == "6a" ) {
					var id = $(this).attr("data-id");
					arr_id.push(id);
				}
				i++;
			});
			var conf = confirm(com + " " + arr_id.length + " data ?" );
			if ( conf == true ) {
				let params = {
					'com': com,
					'grid': grid,
					'urlaction': urlaction,
					'arr_id': arr_id,
				};
				act_proses( params );
			}
		}
	}

	function act_proses( par ){
		var grid_id = $( par.grid ).attr("id");
		grid_id = grid_id.substring( grid_id.lastIndexOf( "grid_" ) + 5 );
		$.ajax({
			type: "POST",
			url: par.urlaction,
			data: par.com + "=true&item=" + JSON.stringify( par.arr_id ),
			dataType: "json",
			beforeSend: function( xhr ) {
				let loading = `
				<div id="loading" class="modal-backdrop">
					<div class="spin">
						<span class="fa fa-spinner fa-spin fa-4x"></span>
					</div>
					<span class="text">Loading...</span>
				</div>
				`;
				$("body").append( loading );
				$("#loading").modal("show");
			},
			success: function (response) {
				$( "#" + grid_id ).flexReload();
				$("#loading").modal("hide");
				$("#loading").remove();
				if ( response["message"] != "") {
					var message_class = response["message_class"];
					if ( message_class == "" ) {
						message_class = "response_confirmation alert alert-success";
					}
					$("#response_message").finish();
					$("#response_message").addClass(message_class);
					$("#response_message").slideDown("fast");
					$("#response_message").html(response["message"]);
					$("#response_message").delay(10000).slideUp(1000, function () {
						$("#response_message").removeClass(message_class);
					});
				}
			}
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
