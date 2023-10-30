<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="contohModalScrollableTitle">Restore DB Code</h5>
	</div>
	<div class="modal-body">
		<div class="card">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">Challange Code:</label>
							<div class="col-sm-12">
								<input type="text" id="challange_code" class="form-control form-control-sm"  >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">Restore Code:</label>
							<div class="col-sm-12">
								<input type="text" id="restore_code" class="form-control form-control-sm" >
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
        <button type="button" class="btn btn-primary submit">Get Code</button>
    </div>
</div>

 <script type="text/javascript">
  $(document).ready(function() {
   $(".submit").click(function(event) {
	   event.preventDefault();
	   var challange_code = $("#challange_code").val();
	   
		if(challange_code.length!=8)
		{ 
		alert("challange_code harus 8 karakter");
		return false;
		}
		jQuery.ajax({
			type: "POST",
			url:"<?php echo base_url( 'config/user' ); ?>/restore_db2",
			dataType: 'json',
			data: {challange: challange_code},
			success: function(res) {
				//jQuery("#restore_code").html(res.hasil);
				$("#restore_code").val(res.hasil);
			}
		});
	});
	
});
</script>