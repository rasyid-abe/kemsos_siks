<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="contohModalScrollableTitle">Anak Dalam Tanggungan</h5>
	</div>
	<div class="modal-body">
		<form id="form_anak" >
		<input type="hidden" class="form-control" id="txtid" name="id" value="<?php echo $anak->id;?>">
		<div class="card">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">1. Nama</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm" name="nama_art_sekolah" value="<?php echo $anak->nama_art_sekolah;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">2. NISN/ NO KTM</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm" name="art_nisn" value="<?php echo $anak->art_nisn;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">3. Alamat Tempat Tinggal</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm" name="art_sekolah_alamat" value="<?php echo $anak->art_sekolah_alamat;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">4. NIK</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm" name="art_sekolah_nik" value="<?php echo $anak->art_sekolah_nik;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">5. Nama Sekolah</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm" name="art_nama_sekolah" value="<?php echo $anak->art_nama_sekolah;?>" >
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
	<div class="modal-footer">
        <button type="button" class="btn btn-primary btn-save-anak">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

<script type="text/javascript">
	
	$(document).ready( function(){
		
		$(document).on( 'click', 'button.btn-save-anak', function(){
			var data = $("#form_anak").serialize();
			$.ajax({
				url:"<?php echo base_url('verivali/detail_data/act_detail_save_anak/'); ?>",
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