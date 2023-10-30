<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="contohModalScrollableTitle">Anak Dalam Tanggungan</h5>
	</div>
	<div class="modal-body">
		<form id="form_usaha" >
		<input type="hidden" class="form-control" id="txtid" name="id" value="<?php echo $usaha->id;?>">
		<div class="card">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">Nama</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm"  name="nama_art" value="<?php echo $usaha->nama_art;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">No Urut ART ( Sesuai Blok IV, Kol 1 )</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm"  name="no_urut_art" value="<?php echo $usaha->no_urut_art;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">Lapangan Usaha</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm"  name="lapangan_usaha" value="<?php echo $usaha->lapangan_usaha;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">Kode Lapangan Usaha ( Sesuai Blok IV. Kol. 20)</label>
							<div class="col-sm-12">
								<select id="kode_lapangan_usaha" name="kode_lapangan_usaha" class="form-control" >
									<option value="0" selected> -=Please Select=-</option>
									<option value="1" <?php echo ( ( $usaha->kode_lapangan_usaha == '1' ) ? 'selected' : null );?>> Pertanian Tanaman Padi/Palawija</option>
									<option value="2" <?php echo ( ( $usaha->kode_lapangan_usaha == '2' ) ? 'selected' : null );?> > Hortikultura </option>
									<option value="3" <?php echo ( ( $usaha->kode_lapangan_usaha == '3' ) ? 'selected' : null );?> > Perkebunan </option>
									<option value="4" <?php echo ( ( $usaha->kode_lapangan_usaha == '4' ) ? 'selected' : null );?> > Perikanan Tangkap </option>
									<option value="5" <?php echo ( ( $usaha->kode_lapangan_usaha == '5' ) ? 'selected' : null );?> > Perikanan Budidaya </option>
									<option value="6" <?php echo ( ( $usaha->kode_lapangan_usaha == '6' ) ? 'selected' : null );?> > Peternakan </option>
									<option value="7" <?php echo ( ( $usaha->kode_lapangan_usaha == '7' ) ? 'selected' : null );?> > Kehutanan & Pertanian Lainnya </option>
									<option value="8" <?php echo ( ( $usaha->kode_lapangan_usaha == '8' ) ? 'selected' : null );?> > Pertambangan/Penggalian </option>
									<option value="9" <?php echo ( ( $usaha->kode_lapangan_usaha == '9' ) ? 'selected' : null );?> > Industri Pengolahan </option>
									<option value="10" <?php echo ( ( $usaha->kode_lapangan_usaha == '10' ) ? 'selected' : null );?> > Listrik dan Gas </option>
									<option value="11" <?php echo ( ( $usaha->kode_lapangan_usaha == '11' ) ? 'selected' : null );?> > Bangunan/Konstruksi </option>
									<option value="12" <?php echo ( ( $usaha->kode_lapangan_usaha == '12' ) ? 'selected' : null );?> > Perdagangan </option>
									<option value="13" <?php echo ( ( $usaha->kode_lapangan_usaha == '13' ) ? 'selected' : null );?> > Hotel/Rumah Makan </option>
									<option value="14" <?php echo ( ( $usaha->kode_lapangan_usaha == '14' ) ? 'selected' : null );?> > Transportasi & Pergudangan </option>
									<option value="15" <?php echo ( ( $usaha->kode_lapangan_usaha == '15' ) ? 'selected' : null );?> > Informasi dan Komunikasi </option>
									<option value="16" <?php echo ( ( $usaha->kode_lapangan_usaha == '16' ) ? 'selected' : null );?> > Keuangan & Asuransi </option>
									<option value="17" <?php echo ( ( $usaha->kode_lapangan_usaha == '17' ) ? 'selected' : null );?> > Jasa Pendidikan </option>
									<option value="18" <?php echo ( ( $usaha->kode_lapangan_usaha == '18' ) ? 'selected' : null );?> > Jasa Kesehatan  </option>
									<option value="19" <?php echo ( ( $usaha->kode_lapangan_usaha == '19' ) ? 'selected' : null );?> > Jasa Kemasyarakatan. Pemerintahan & Perorangan </option>
									<option value="20" <?php echo ( ( $usaha->kode_lapangan_usaha == '20' ) ? 'selected' : null );?> > Pemulung </option>
									<option value="21" <?php echo ( ( $usaha->kode_lapangan_usaha == '21' ) ? 'selected' : null );?> > Lainnya </option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">Jumlah Pekerja</label>
							<div class="col-sm-12">
								<input type="text" class="form-control form-control-sm"  name="jumlah_pekerja" value="<?php echo $usaha->jumlah_pekerja;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">Tempat/Lokasi Usaha</label>
							<div class="col-sm-6">
								<input type="radio"  name="lokasi_usaha" value="1" <?php echo ( ( $usaha->lokasi_usaha == '1' ) ? 'checked' : null );?> > Ada
							</div>
							<div class="col-sm-6">
								<input type="radio"  name="lokasi_usaha" value="2" <?php echo ( ( $usaha->lokasi_usaha == '2' ) ? 'checked' : null );?> > Tidak Ada
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-12 col-form-label-sm">Omset Usaha Per Bulan</label>
							<div class="col-sm-6">
								<input type="radio"  name="omset_usaha" value="1" <?php echo ( ( $usaha->omset_usaha == '1' ) ? 'checked' : null );?> > Kurang Dari 1 Juta
							</div>
							<div class="col-sm-6">
								<input type="radio"  name="omset_usaha" value="2" <?php echo ( ( $usaha->omset_usaha == '2' ) ? 'checked' : null );?> > 1 - 5 Juta
							</div>
							<div class="col-sm-6">
								<input type="radio"  name="omset_usaha" value="3" <?php echo ( ( $usaha->omset_usaha == '3' ) ? 'checked' : null );?> > 5 - 10 Juta
							</div>
							<div class="col-sm-6">
								<input type="radio"  name="omset_usaha" value="4" <?php echo ( ( $usaha->omset_usaha == '4' ) ? 'checked' : null );?> > Lebih Dari 10 Juta
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
	<div class="modal-footer">
        <button type="button" class="btn btn-primary btn-save-usaha">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

<script type="text/javascript">
	
	$(document).ready( function(){
		
		$(document).on( 'click', 'button.btn-save-usaha', function(){
			var data = $("#form_usaha").serialize();
			$.ajax({
				url:"<?php echo base_url('verivali/detail_data/act_detail_save_usaha/'); ?>",
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