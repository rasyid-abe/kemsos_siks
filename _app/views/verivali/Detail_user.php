<style type="text/css">
	.loc-ul {list-style-type: none; margin: 0; padding: 0 0 0 25px; display: none; } .loc-li {cursor: pointer; -webkit-user-select: none; /* Safari 3.1+ */ -moz-user-select: none; /* Firefox 2+ */ -ms-user-select: none; /* IE 10+ */ user-select: none; font-size: 23px; padding-right: 10px; display: block; } .loc-text{cursor: pointer; font-family: 'Arial'; font-size: 14px; } .loc::before {content: "\2610"; color: black; display: inline-block; margin-right: 6px; width:10px; } .loc-check::before {content: "\2611"; color: dodgerblue; } .loc-half-check::before {content: "\2612"; color: dodgerblue; } .loc-ul-active {display: block;} .btn-exs{padding: 0.125rem 0.25rem;font-size: smaller;color: black;} .subor::before {content: "\2610"; display: inline-block; font-size: 14px;} .subor-check::before {content: "\2611"; color: dodgerblue; }
</style>

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<div id="response_message" style="display:none;"></div>
				<table id="gridviewuser" style="display:none;"></table>
			</div>
		</div>
	</div>
</div>
<input name="prelist" id="prelist" type="hidden" class="form-control form-control-sm" value=<?php echo $prelist;?> readonly>
								
<script>
	$("#gridviewuser").flexigrid({
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
		params: [{"location_id": <?php echo $grid['location_id'];?>}],
		rp: 50,
		showTableToggleBtn: false,
		showToggleBtn: true,
		width: 'auto',
		height: '400',
		resizable: false,
		singleSelect: true
	});

</script>