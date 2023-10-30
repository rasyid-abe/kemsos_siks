<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="contohModalScrollableTitle">Detail Data Anggota Rumah Tangga</h5>
	</div>
	<div class="modal-body">
		<div class="card-body">
			<div class="form-row">
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">1. Nama Anggota Rumah Tangga</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->nama;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->mku_perbaikan_nama;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">2. Nomor NIK</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->nik;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->mku_perbaikan_nik;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">3. Hubungan Dengan Kepala Rumah Tangga</label>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->hubungan_krt == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kepala Rumah Tangga
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->hubungan_krt == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Istri/Suami
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->hubungan_krt == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Anak
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->hubungan_krt == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Menantu
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->hubungan_krt == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cucu
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->hubungan_krt == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Orang Tua/Mertua
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $art->hubungan_krt == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Pembantu Rumah Tangga
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $art->hubungan_krt == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-2">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_konfirmasi_hub_krt == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-2">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_konfirmasi_hub_krt == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_perbaikan_hub_krt == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kepala Rumah Tangga
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_perbaikan_hub_krt == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Istri/Suami
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->mku_perbaikan_hub_krt == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Anak
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->mku_perbaikan_hub_krt == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Menantu
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->mku_perbaikan_hub_krt == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cucu
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->mku_perbaikan_hub_krt == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Orang Tua/Mertua
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $art->mku_perbaikan_hub_krt == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Pembantu Rumah Tangga
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $art->mku_perbaikan_hub_krt == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">4. Nomor Urut Keluarga</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->nuk;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->mku_perbaikan_nuk;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">5. Hubungan Dengan Kepala Keluarga</label>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->hubungan_keluarga == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kepala Rumah Tangga
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->hubungan_keluarga == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Istri/Suami
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->hubungan_keluarga == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Anak
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->hubungan_keluarga == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Menantu
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->hubungan_keluarga == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cucu
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->hubungan_keluarga == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Orang Tua/Mertua
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $art->hubungan_keluarga == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Pembantu Rumah Tangga
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $art->hubungan_keluarga == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-2">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_konfirmasi_hubkel == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-2">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_konfirmasi_hubkel == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_perbaikan_hubkel == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kepala Rumah Tangga
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_perbaikan_hubkel == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Istri/Suami
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->mku_perbaikan_hubkel == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Anak
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->mku_perbaikan_hubkel == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Menantu
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->mku_perbaikan_hubkel == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cucu
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->mku_perbaikan_hubkel == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Orang Tua/Mertua
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $art->mku_perbaikan_hubkel == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Pembantu Rumah Tangga
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $art->mku_perbaikan_hubkel == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">6. Jenis Kelamin</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->jenis_kelamin == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Laki-Laki
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->jenis_kelamin == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Perempuan
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-2">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_korfirmasi_jnskel == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-2">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_korfirmasi_jnskel == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_perbaikan_jnskel == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Laki-Laki
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_perbaikan_jnskel == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Perempuan
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">7. Umur</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->umur;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->mku_perbaikan_umur;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">8. Status Perkawinan</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->status_kawin == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Belum Kawin
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->status_kawin == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kawin/Nikah
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->status_kawin == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cerai Hidup
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->status_kawin == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cerai Mati
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">9. Jika Kol 8 (2 atau 3), Kepemilikan Akta Buku Nikah Atau Akta Cerai</label>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->ada_akta_nikah == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->ada_akta_nikah == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya, Dapat Ditunjukan
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->ada_akta_nikah == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya, Tidak Dapat Ditunjukan
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">10. Tercantum Dalam KK, Di Rumah Tangga Ini</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->ada_di_kk == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->ada_di_kk == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">11. Kepemilikan Kartu Identitas</label>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo ( ( $art->ada_kartu_identitas == '0' ) ? 'checked' : null );?> > <label class="custom-control-label"> Tidak Memiliki</label>
						</div>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo ( ( $art->ada_kartu_identitas == '1' ) ? 'checked' : null );?> > <label class="custom-control-label"> Akta Kelahiran</label>
						</div>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo ( ( $art->ada_kartu_identitas == '2' ) ? 'checked' : null );?> > <label class="custom-control-label"> Kartu Pelajar</label>
						</div>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo ( ( $art->ada_kartu_identitas == '4' ) ? 'checked' : null );?> > <label class="custom-control-label"> KTP</label>
						</div>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo ( ( $art->ada_kartu_identitas == '8' ) ? 'checked' : null );?> > <label class="custom-control-label"> SIM</label>
						</div>					
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">12. Untuk Wanita Usia 10-49 Tahun Dan KDL(8) = 2, Status Kehamilan</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->status_hamil == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->status_hamil == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">13. Jenis Cacat</label>
						<div class="col-sm-6">
							<select id="status_pekerjaan" name="status_pekerjaan" class="form-control">
								<option value="0" <?php echo ( ( $art->jenis_cacat == '0' ) ? 'selected' : null );?> > Tidak Cacat </option>
								<option value="1" <?php echo ( ( $art->jenis_cacat == '1' ) ? 'selected' : null );?> > Tuna Daksa/Cacat Tubuh </option>
								<option value="2" <?php echo ( ( $art->jenis_cacat == '2' ) ? 'selected' : null );?> > Tuna Netra/Buta </option>
								<option value="3" <?php echo ( ( $art->jenis_cacat == '3' ) ? 'selected' : null );?> > Tuna Wicara </option>
								<option value="4" <?php echo ( ( $art->jenis_cacat == '4' ) ? 'selected' : null );?> > Tuna Rungu & Wicara </option>
								<option value="5" <?php echo ( ( $art->jenis_cacat == '5' ) ? 'selected' : null );?> > Tuna Netra & Cacat Tubuh </option>
								<option value="6" <?php echo ( ( $art->jenis_cacat == '6' ) ? 'selected' : null );?> > Tuna Netra, Rungu & Wicara </option>
								<option value="7" <?php echo ( ( $art->jenis_cacat == '7' ) ? 'selected' : null );?> > Tuna Rungu, Wicara Dan Cacat Tubuh </option>
								<option value="8" <?php echo ( ( $art->jenis_cacat == '8' ) ? 'selected' : null );?> > Tuna Rungu,Wicara,Netra Dan Cacat Tubuh </option>
								<option value="9" <?php echo ( ( $art->jenis_cacat == '9' ) ? 'selected' : null );?> > Cacat Mental Retardasi </option>
								<option value="10" <?php echo ( ( $art->jenis_cacat == '10' ) ? 'selected' : null );?> > Mantan Penderita Gangguan Jiwa </option>
								<option value="11" <?php echo ( ( $art->jenis_cacat == '11' ) ? 'selected' : null );?> > Cacat Fisik Dan Mental </option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">14. Penyakit Kronis Menahun</label>
						<div class="col-sm-6">
							<select id="status_pekerjaan" name="status_pekerjaan" class="form-control">
								<option value="0" <?php echo ( ( $art->penyakit_kronis == '0' ) ? 'selected' : null );?> > Tidak Cacat </option>
								<option value="1" <?php echo ( ( $art->penyakit_kronis == '1' ) ? 'selected' : null );?> > Hipertensi (Tekanan Darah Tinggi) </option>
								<option value="2" <?php echo ( ( $art->penyakit_kronis == '2' ) ? 'selected' : null );?> > Rematik </option>
								<option value="3" <?php echo ( ( $art->penyakit_kronis == '3' ) ? 'selected' : null );?> > Asma </option>
								<option value="4" <?php echo ( ( $art->penyakit_kronis == '4' ) ? 'selected' : null );?> > Masalah Jantung </option>
								<option value="5" <?php echo ( ( $art->penyakit_kronis == '5' ) ? 'selected' : null );?> > Diabetes(Kencing Manis) </option>
								<option value="6" <?php echo ( ( $art->penyakit_kronis == '6' ) ? 'selected' : null );?> > Tuberkolosis(TBC) </option>
								<option value="7" <?php echo ( ( $art->penyakit_kronis == '7' ) ? 'selected' : null );?> > Stroke </option>
								<option value="8" <?php echo ( ( $art->penyakit_kronis == '8' ) ? 'selected' : null );?> > Kanker Atau Tumor Ganas </option>
								<option value="9" <?php echo ( ( $art->penyakit_kronis == '9' ) ? 'selected' : null );?> > Lainnya(gagal ginjal,paru-paru flek, dan sejenisnya) </option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">15. Partisipasi Sekolah</label>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="0" <?php echo ( ( $art->partisipasi_sekolah == '0' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak/Belum Bersekolah 
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->partisipasi_sekolah == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Masih Sekolah
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->partisipasi_sekolah == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak Bersekolah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_konfirmasi_partisipasi_sekolah == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_konfirmasi_partisipasi_sekolah == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="0" <?php echo ( ( $art->mku_perbaikan_partisipasi_sekolah == '0' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak/Belum Bersekolah 
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_perbaikan_partisipasi_sekolah == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Masih Sekolah
						</div>
						<div class="col-sm-4">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_perbaikan_partisipasi_sekolah == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak Bersekolah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">16. Jenjang Dan Jenis Pendidikan Tertinggi Yang Pernah/Sedang Diduduki</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->pendidikan_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> SD/SDLB
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->pendidikan_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket A
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->pendidikan_tertinggi == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Ibtidaiyah
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->pendidikan_tertinggi == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMP/SMPLB
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->pendidikan_tertinggi == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket B
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->pendidikan_tertinggi == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Tsanawiyah
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $art->pendidikan_tertinggi == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMA/SMK/SMALB
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $art->pendidikan_tertinggi == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket C
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="9" <?php echo ( ( $art->pendidikan_tertinggi == '9' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Aliyah
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="10" <?php echo ( ( $art->pendidikan_tertinggi == '10' ) ? 'checked' : null );?> > <span class="custom-control-label"> Perguruan Tinggi
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_konfirmasi_jenjang_pendidikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_konfirmasi_jenjang_pendidikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> SD/SDLB
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket A
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Ibtidaiyah
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMP/SMPLB
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket B
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Tsanawiyah
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMA/SMK/SMALB
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket C
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="9" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '9' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Aliyah
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="10" <?php echo ( ( $art->mku_perbaikan_jenjang_pendidikan == '10' ) ? 'checked' : null );?> > <span class="custom-control-label"> Perguruan Tinggi
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">17. Kelas Tertingi Yang Pernah/Sedang Di duduki</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->kelas_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> 1
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->kelas_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> 2
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->kelas_tertinggi == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> 3
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->kelas_tertinggi == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> 4
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->kelas_tertinggi == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> 5
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->kelas_tertinggi == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> 6
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $art->kelas_tertinggi == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> 7
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $art->kelas_tertinggi == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> 8 (Tamat)
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_konfirmasi_kelas_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_konfirmasi_kelas_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_perbaikan_kelas_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> 1
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_perbaikan_kelas_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> 2
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->mku_perbaikan_kelas_tertinggi == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> 3
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->mku_perbaikan_kelas_tertinggi == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> 4
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->mku_perbaikan_kelas_tertinggi == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> 5
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->mku_perbaikan_kelas_tertinggi == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> 6
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $art->mku_perbaikan_kelas_tertinggi == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> 7
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $art->mku_perbaikan_kelas_tertinggi == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> 8 (Tamat)
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">18. Ijazah Tertinggi Yang Dimiliki</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="0" <?php echo ( ( $art->ijazah_tertinggi == '0' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak Punya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->ijazah_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> SD/Sederajat
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->ijazah_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMP/Sederajat
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->ijazah_tertinggi == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMA/Sederajat
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->ijazah_tertinggi == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> D1/D2/D3
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->ijazah_tertinggi == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> D4/S1
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->ijazah_tertinggi == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> S2/S3
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_konfirmasi_ijazah_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_konfirmasi_ijazah_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="0" <?php echo ( ( $art->mku_perbaikan_ijazah_tertinggi == '0' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak Punya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_perbaikan_ijazah_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> SD/Sederajat
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_perbaikan_ijazah_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMP/Sederajat
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $art->mku_perbaikan_ijazah_tertinggi == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMA/Sederajat
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $art->mku_perbaikan_ijazah_tertinggi == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> D1/D2/D3
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $art->mku_perbaikan_ijazah_tertinggi == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> D4/S1
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $art->mku_perbaikan_ijazah_tertinggi == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> S2/S3
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">19. Bekerja/Membantu Bekerja Selama Seminggu Yang Lalu</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->status_bekerja == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->status_bekerja == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_konfirmasi_sta_bekerja == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_konfirmasi_sta_bekerja == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_perbaikan_sta_bekerja == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_perbaikan_sta_bekerja == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Lama bekerja</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->jumlah_jam_kerja;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">20. Lapangan Usaha Dari Pekerjaan Utama</label>
						<div class="col-sm-6">
							<select id="lapangan_usaha" name="lapangan_usaha" class="form-control" disabled>
								<option value="1" <?php echo ( ( $art->lapangan_usaha == '1' ) ? 'selected' : null );?>> Pertanian Tanaman Padi/Palawija</option>
								<option value="2" <?php echo ( ( $art->lapangan_usaha == '2' ) ? 'selected' : null );?> > Hortikultura </option>
								<option value="3" <?php echo ( ( $art->lapangan_usaha == '3' ) ? 'selected' : null );?> > Perkebunan </option>
								<option value="4" <?php echo ( ( $art->lapangan_usaha == '4' ) ? 'selected' : null );?> > Perikanan Tangkap </option>
								<option value="5" <?php echo ( ( $art->lapangan_usaha == '5' ) ? 'selected' : null );?> > Perikanan Budidaya </option>
								<option value="6" <?php echo ( ( $art->lapangan_usaha == '6' ) ? 'selected' : null );?> > Peternakan </option>
								<option value="7" <?php echo ( ( $art->lapangan_usaha == '7' ) ? 'selected' : null );?> > Kehutanan & Pertanian Lainnya </option>
								<option value="8" <?php echo ( ( $art->lapangan_usaha == '8' ) ? 'selected' : null );?> > Pertambangan/Penggalian </option>
								<option value="9" <?php echo ( ( $art->lapangan_usaha == '9' ) ? 'selected' : null );?> > Industri Pengolahan </option>
								<option value="10" <?php echo ( ( $art->lapangan_usaha == '10' ) ? 'selected' : null );?> > Listrik dan Gas </option>
								<option value="11" <?php echo ( ( $art->lapangan_usaha == '11' ) ? 'selected' : null );?> > Bangunan/Konstruksi </option>
								<option value="12" <?php echo ( ( $art->lapangan_usaha == '12' ) ? 'selected' : null );?> > Perdagangan </option>
								<option value="13" <?php echo ( ( $art->lapangan_usaha == '13' ) ? 'selected' : null );?> > Hotel/Rumah Makan </option>
								<option value="14" <?php echo ( ( $art->lapangan_usaha == '14' ) ? 'selected' : null );?> > Transportasi & Pergudangan </option>
								<option value="15" <?php echo ( ( $art->lapangan_usaha == '15' ) ? 'selected' : null );?> > Informasi dan Komunikasi </option>
								<option value="16" <?php echo ( ( $art->lapangan_usaha == '16' ) ? 'selected' : null );?> > Keuangan & Asuransi </option>
								<option value="17" <?php echo ( ( $art->lapangan_usaha == '17' ) ? 'selected' : null );?> > Jasa Pendidikan </option>
								<option value="18" <?php echo ( ( $art->lapangan_usaha == '18' ) ? 'selected' : null );?> > Jasa Kesehatan  </option>
								<option value="19" <?php echo ( ( $art->lapangan_usaha == '19' ) ? 'selected' : null );?> > Jasa Kemasyarakatan. Pemerintahan & Perorangan </option>
								<option value="20" <?php echo ( ( $art->lapangan_usaha == '20' ) ? 'selected' : null );?> > Pemulung </option>
								<option value="21" <?php echo ( ( $art->lapangan_usaha == '21' ) ? 'selected' : null );?> > Lainnya </option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->mku_konfirmasi_lapangan_usaha == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->mku_konfirmasi_lapangan_usaha == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan</label>
						<div class="col-sm-6">
							<select id="mku_perbaikan_lapangan_usaha" name="mku_perbaikan_lapangan_usaha" class="form-control">
								<option value="0" selected> -=Please Select=-</option>
								<option value="1" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '1' ) ? 'selected' : null );?>> Pertanian Tanaman Padi/Palawija</option>
								<option value="2" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '2' ) ? 'selected' : null );?> > Hortikultura </option>
								<option value="3" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '3' ) ? 'selected' : null );?> > Perkebunan </option>
								<option value="4" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '4' ) ? 'selected' : null );?> > Perikanan Tangkap </option>
								<option value="5" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '5' ) ? 'selected' : null );?> > Perikanan Budidaya </option>
								<option value="6" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '6' ) ? 'selected' : null );?> > Peternakan </option>
								<option value="7" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '7' ) ? 'selected' : null );?> > Kehutanan & Pertanian Lainnya </option>
								<option value="8" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '8' ) ? 'selected' : null );?> > Pertambangan/Penggalian </option>
								<option value="9" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '9' ) ? 'selected' : null );?> > Industri Pengolahan </option>
								<option value="10" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '10' ) ? 'selected' : null );?> > Listrik dan Gas </option>
								<option value="11" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '11' ) ? 'selected' : null );?> > Bangunan/Konstruksi </option>
								<option value="12" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '12' ) ? 'selected' : null );?> > Perdagangan </option>
								<option value="13" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '13' ) ? 'selected' : null );?> > Hotel/Rumah Makan </option>
								<option value="14" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '14' ) ? 'selected' : null );?> > Transportasi & Pergudangan </option>
								<option value="15" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '15' ) ? 'selected' : null );?> > Informasi dan Komunikasi </option>
								<option value="16" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '16' ) ? 'selected' : null );?> > Keuangan & Asuransi </option>
								<option value="17" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '17' ) ? 'selected' : null );?> > Jasa Pendidikan </option>
								<option value="18" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '18' ) ? 'selected' : null );?> > Jasa Kesehatan  </option>
								<option value="19" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '19' ) ? 'selected' : null );?> > Jasa Kemasyarakatan. Pemerintahan & Perorangan </option>
								<option value="20" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '20' ) ? 'selected' : null );?> > Pemulung </option>
								<option value="21" <?php echo ( ( $art->mku_perbaikan_lapangan_usaha == '21' ) ? 'selected' : null );?> > Lainnya </option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">21. Status Kedudukan Dalam Pekerjaan Utama</label>
						<div class="col-sm-6">
							<select id="status_pekerjaan" name="status_pekerjaan" class="form-control">
								<option value="0" selected> -=Please Select=-</option>
								<option value="1" <?php echo ( ( $art->status_pekerjaan == '1' ) ? 'selected' : null );?>> Berusaha Sendiri</option>
								<option value="2" <?php echo ( ( $art->status_pekerjaan == '2' ) ? 'selected' : null );?> > Berusaha Dibantu Buruh Tidak Tetap/Tidak Dibayar </option>
								<option value="3" <?php echo ( ( $art->status_pekerjaan == '3' ) ? 'selected' : null );?> > Berusaha Dibantu Buruh Tetap/Dibayar </option>
								<option value="4" <?php echo ( ( $art->status_pekerjaan == '4' ) ? 'selected' : null );?> > Buruh/Karyawan/Pegawai Stasta </option>
								<option value="5" <?php echo ( ( $art->status_pekerjaan == '5' ) ? 'selected' : null );?> > PNS/TNI/POLRI/BUMN/BUMD/Anggota Legislatif </option>
								<option value="6" <?php echo ( ( $art->status_pekerjaan == '6' ) ? 'selected' : null );?> > Pekerja Bebas Pertanian </option>
								<option value="7" <?php echo ( ( $art->status_pekerjaan == '7' ) ? 'selected' : null );?> > Pekerja Bebas Non-Pertanian </option>
								<option value="8" <?php echo ( ( $art->status_pekerjaan == '8' ) ? 'selected' : null );?> > Pekerja Keluarga/Tidak Dibayar </option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">22. Keterangan Keberadaan Anggota Rumah Tangga</label>
						<div class="col-sm-6">
							<select id="status_keberadaan_art" name="status_keberadaan_art" class="form-control">
								<option value="0" selected> -=Please Select=-</option>
								<option value="1" <?php echo ( ( $art->status_keberadaan_art == '1' ) ? 'selected' : null );?>> Tinggal Di Ruta</option>
								<option value="2" <?php echo ( ( $art->status_keberadaan_art == '2' ) ? 'selected' : null );?> > Meninggal </option>
								<option value="3" <?php echo ( ( $art->status_keberadaan_art == '3' ) ? 'selected' : null );?> > Tidak Tinggal di Ruta/Pindah </option>
								<option value="4" <?php echo ( ( $art->status_keberadaan_art == '4' ) ? 'selected' : null );?> > Anggota Rumah Tangga Baru </option>
								<option value="5" <?php echo ( ( $art->status_keberadaan_art == '5' ) ? 'selected' : null );?> > Kesalahan Prelist </option>
								<option value="6" <?php echo ( ( $art->status_keberadaan_art == '6' ) ? 'selected' : null );?> > Tidak Ditemukan </option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">23. KPB/KKS</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->ada_kks == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->ada_kks == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">24. KIS/PBI JKN</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->ada_pbi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->ada_pbi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Nomor KIS/PBI JKN</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->no_peserta_pbi;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">25. KIP/BSM</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->ada_kip == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->ada_kip == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">26. PKH</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->ada_pkh == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->ada_pkh == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">27. Raskin/Rastra</label>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $art->ada_rastra == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
						</div>
						<div class="col-sm-3">
							<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $art->ada_rastra == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">28. Nama Ibu Kandung</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" value="<?php echo $art->nama_gadis_ibu_kandung;?>" >
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>