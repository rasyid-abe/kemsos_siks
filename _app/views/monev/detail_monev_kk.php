<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="contohModalScrollableTitle">Nomor KK</h5>
	</div>
	<div class="modal-body">
		<div class="card-body">
			<div class="form-row">
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Nomor Urut Kartu Keluarga</label>
						<div class="col-sm-12">
							<input type="text" class="form-control form-control-sm" value="<?php echo $kk->nuk;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Nomor Kartu Keluarga</label>
						<div class="col-sm-12">
							<input type="text" class="form-control form-control-sm" value="<?php echo $kk->nokk;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-6">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $kk->mku_hasil_kk_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Benar</span>
							</label>
						</div>
						<div class="col-sm-6">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $kk->mku_hasil_kk_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Salah</span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Nomor Kartu Keluarga Perbaikan</label>
						<div class="col-sm-12">
							<input type="text" class="form-control form-control-sm" value="<?php echo $kk->NoKK_perbaikan;?>" >
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>