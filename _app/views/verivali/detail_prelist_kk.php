<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="contohModalScrollableTitle">Nomor Kartu Keluarga</h5>
	</div>
	<div class="modal-body">
		<form id="form_kk" >
		<input type="hidden" class="form-control" id="txtid" name="id" value="<?php echo $kk->id;?>">
		<div class="form-row">
			<div class="col-md-10">
				<div class="form-group row">
					<label class="col-sm-12 col-form-label-sm">Nomor Urut Kartu Keluarga</label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" name="nuk" value="<?php echo $kk->nuk;?>" >
					</div>
				</div>
			</div>
			<div class="col-md-10">
				<div class="form-group row">
					<label class="col-sm-12 col-form-label-sm">Nomor Kartu Keluarga</label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" name="nokk" value="<?php echo $kk->nokk;?>" >
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
	<div class="modal-footer">
        <button type="button" class="btn btn-primary btn-save-kk">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>


<script type="text/javascript">
	
	$(document).ready( function(){
		
		$(document).on( 'click', 'button.btn-save-kk', function(){
			var data = $("#form_kk").serialize();
			$.ajax({
				url:"<?php echo base_url('verivali/detail_data/act_detail_save_kk/'); ?>",
				type: 'POST',
				data: data,
				dataType: 'json',
				success : function( data ) {
					if ( data.status == 200 ) {
						alert(data.message);
						location.reload();
						return false;
					} else {
						alert(data.message);
					}
				},
			});
		});
		
		
	});
</script>