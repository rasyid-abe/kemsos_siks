<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="contohModalScrollableTitle">Detail Data Anggota Rumah Tangga</h5>
	</div>
	<div class="modal-body">
		<form action="<?php echo base_url('verivali/detail_data/edit_prelist')?>" method="POST" enctype="multipart/form-data" >
			<input type="hidden" class="form-control" id="txtid" name="id" value="<?php echo $art->id;?>">
			<input type="hidden" class="form-control" id="txtid" name="proses_id" value="<?php echo $art->proses_id;?>">
			<div class="form-row">				
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Apakah NIK Sesuai Dokumen ?</label>
						<div class="col-sm-8">
							<select class="form-control" name="flag_dokumen" required >
								<option value=''>Pilih Kesesuaian Dokumen</option>
								<?php                                            
									if ($art->flag_dokumen == 1) echo "<option value=1 selected>SESUAI DOKUMEN</option>";
									else echo "<option value=1>SESUAI DOKUMEN</option>";
									
									if ($art->flag_dokumen == 2) echo "<option value=2 selected>TIDAK SESUAI DOKUMEN</option>";
									else echo "<option value=2>TIDAK SESUAI DOKUMEN</option>";						
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">1. Nama Anggota Rumah Tangga</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" name="nama" value="<?php echo $art->nama;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">2. Nomor NIK</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" name="nik" value="<?php echo $art->nik;?>" >
						</div>
					</div>
				</div>	
				<div class="col-10 float-right">
					<?php if ($_SESSION['user_info']['user_username'] == 'root'): ?>
						<button type="submit" class="btn btn-sm btn-primary col-md-2 f-w-900" >
							Simpan
						</button>

					<?php endif; ?>
					<button type="reset" class="btn btn-sm btn-danger col-md-2 f-w-900" onclick="location.reload();">
						Batal
					</button>
				</div>		
				<div class="col-md-12">
					<hr/>
				</div>		
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">3. Hubungan Dengan Kepala Rumah Tangga</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_krt" value="1" <?php echo ( ( $art->hubungan_krt == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kepala Rumah Tangga </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_krt" value="2" <?php echo ( ( $art->hubungan_krt == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Istri/Suami </span>
						</div>
						</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_krt" value="3" <?php echo ( ( $art->hubungan_krt == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Anak </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_krt" value="4" <?php echo ( ( $art->hubungan_krt == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Menantu </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_krt" value="5" <?php echo ( ( $art->hubungan_krt == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cucu </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_krt" value="6" <?php echo ( ( $art->hubungan_krt == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Orang Tua/Mertua </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_krt" value="7" <?php echo ( ( $art->hubungan_krt == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Pembantu Rumah Tangga </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_krt" value="8" <?php echo ( ( $art->hubungan_krt == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">4. Nomor Urut Keluarga</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" name="nuk" value="<?php echo $art->nuk;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">5. Hubungan Dengan Kepala Keluarga</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_keluarga" value="1" <?php echo ( ( $art->hubungan_keluarga == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kepala Keluarga </span>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_keluarga" value="2" <?php echo ( ( $art->hubungan_keluarga == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Istri/Suami </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_keluarga" value="3" <?php echo ( ( $art->hubungan_keluarga == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Anak </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_keluarga" value="4" <?php echo ( ( $art->hubungan_keluarga == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Menantu </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_keluarga" value="5" <?php echo ( ( $art->hubungan_keluarga == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cucu </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_keluarga" value="6" <?php echo ( ( $art->hubungan_keluarga == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Orang Tua/Mertua </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_keluarga" value="7" <?php echo ( ( $art->hubungan_keluarga == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Pembantu Rumah Tangga </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="hubungan_keluarga" value="8" <?php echo ( ( $art->hubungan_keluarga == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">6. Jenis Kelamin</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="jenis_kelamin" value="1" <?php echo ( ( $art->jenis_kelamin == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Laki-Laki </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="jenis_kelamin" value="2" <?php echo ( ( $art->jenis_kelamin == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Perempuan </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">7. Umur</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" name="umur" value="<?php echo $art->umur;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Tempat Lahir</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" name="tempat_lahir" value="<?php echo $art->tempat_lahir;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Tanggal Lahir</label>
						<div class="col-sm-8">
							<input type="date" class="form-control form-control-sm" name="tanggal_lahir" value="<?php echo $art->tanggal_lahir;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">8. Status Perkawinan</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="status_kawin" value="1" <?php echo ( ( $art->status_kawin == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Belum Kawin </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="status_kawin" value="2" <?php echo ( ( $art->status_kawin == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kawin/Nikah </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="status_kawin" value="3" <?php echo ( ( $art->status_kawin == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cerai Hidup </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="status_kawin" value="4" <?php echo ( ( $art->status_kawin == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Cerai Mati </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">9. Jika Kol 8 ("Kawin/Nikah" atau "Cerai Hidup"), Kepemilikan Akta Buku Nikah Atau Akta Cerai</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_akta_nikah" value="0" <?php echo ( ( $art->ada_akta_nikah == '0' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_akta_nikah" value="1" <?php echo ( ( $art->ada_akta_nikah == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya, Dapat Ditunjukan </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_akta_nikah" value="2" <?php echo ( ( $art->ada_akta_nikah == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya, Tidak Dapat Ditunjukan </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">10. Tercantum Dalam KK, Di Rumah Tangga Ini</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_di_kk" value="1" <?php echo ( ( $art->ada_di_kk == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_di_kk" value="2" <?php echo ( ( $art->ada_di_kk == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">11. Kepemilikan Kartu Identitas</label>
						<?php
							$check1 = null;
							$check2 = null;
							$check3 = null;
							$check4 = null;
							$check5 = null;
							$adakartu = $art->ada_kartu_identitas;
							//tidak-memiliki
							if($adakartu == '0'){
								$check1 = 'checked';
							}
							//akta-kelahiran
							if($adakartu == '1' || $adakartu == '3' || $adakartu == '5' || $adakartu == '9' || $adakartu == '7' || $adakartu == '11' || $adakartu == '13' || $adakartu == '15'){
								$check2 = 'checked';
							}
							//kartu-pelajar
							if($adakartu == '2' || $adakartu == '3' || $adakartu == '6' || $adakartu == '7' || $adakartu == '10' || $adakartu == '11' || $adakartu == '14' || $adakartu == '15'){
								$check3 = 'checked';
							}
							//ktp
							if($adakartu == '4' || $adakartu == '4' || $adakartu == '6' || $adakartu == '7' || $adakartu == '12' || $adakartu == '13' || $adakartu == '14' || $adakartu == '15'){
								$check4 = 'checked';
							}
							//sim
							if($adakartu == '8' || $adakartu == '9' || $adakartu == '10' || $adakartu == '11' || $adakartu == '12' || $adakartu == '13' || $adakartu == '14' || $adakartu == '15'){
								$check5 = 'checked';
							}
						?>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo $check1; ?> ><label class="custom-control-label">Tidak Memiliki</label>
						</div>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo $check2; ?> ><label class="custom-control-label">Akta Kelahiran</label>
						</div>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo $check3; ?> ><label class="custom-control-label">Kartu Pelajar</label>
						</div>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo $check4; ?> ><label class="custom-control-label">KTP</label>
						</div>
						<div class="col-sm-12 custom-control custom-checkbox m-l-20">
							<input type="checkbox" class="custom-control-input" <?php echo $check5; ?> ><label class="custom-control-label">SIM</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">12. Untuk Wanita Usia 10-49 Tahun Dan Kol(8) = ("Kawin/Nikah" atau "Cerai Hidup" atau "Cerai Mati"), Status Kehamilan</label>
						<div class="col-sm-12">
						<?php if ($art->jenis_kelamin != 1): ?>
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="status_hamil" value="1" <?php echo ( ( $art->status_hamil == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="status_hamil" value="2" <?php echo ( ( $art->status_hamil == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>

						<?php else: ?>
						<label class="radio-inline custom-control custom-radio">
							<input disabled type="radio"  class="custom-control-input" name="status_hamil" value="1" <?php echo ( ( $art->status_hamil == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input disabled type="radio"  class="custom-control-input" name="status_hamil" value="2" <?php echo ( ( $art->status_hamil == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">13. Jenis Disabilitas</label>
						<div class="col-sm-6">
							<select id="status_pekerjaan" name="jenis_cacat" class="js-example-basic-single form-control">
								<option value="0" <?php echo ( ( $art->jenis_cacat == '0' ) ? 'selected' : null );?> > Tidak Disabilitas </option>
								<option value="1" <?php echo ( ( $art->jenis_cacat == '1' ) ? 'selected' : null );?> > Tuna Daksa/Disabilitas Tubuh </option>
								<option value="2" <?php echo ( ( $art->jenis_cacat == '2' ) ? 'selected' : null );?> > Tuna Netra/Buta </option>
								<option value="3" <?php echo ( ( $art->jenis_cacat == '3' ) ? 'selected' : null );?> > Tuna Wicara </option>
								<option value="4" <?php echo ( ( $art->jenis_cacat == '4' ) ? 'selected' : null );?> > Tuna Rungu & Wicara </option>
								<option value="5" <?php echo ( ( $art->jenis_cacat == '5' ) ? 'selected' : null );?> > Tuna Netra & Disabilitas Tubuh </option>
								<option value="6" <?php echo ( ( $art->jenis_cacat == '6' ) ? 'selected' : null );?> > Tuna Netra, Rungu & Wicara </option>
								<option value="7" <?php echo ( ( $art->jenis_cacat == '7' ) ? 'selected' : null );?> > Tuna Rungu, Wicara Dan Disabilitas Tubuh </option>
								<option value="8" <?php echo ( ( $art->jenis_cacat == '8' ) ? 'selected' : null );?> > Tuna Rungu,Wicara,Netra Dan Disabilitas Tubuh </option>
								<option value="9" <?php echo ( ( $art->jenis_cacat == '9' ) ? 'selected' : null );?> > Disabilitas Mental Retardasi </option>
								<option value="10" <?php echo ( ( $art->jenis_cacat == '10' ) ? 'selected' : null );?> > Mantan Penderita Gangguan Jiwa </option>
								<option value="11" <?php echo ( ( $art->jenis_cacat == '11' ) ? 'selected' : null );?> > Disabilitas Fisik Dan Mental </option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">14. Penyakit Kronis Menahun</label>
						<div class="col-sm-6">
							<select id="status_pekerjaan" name="penyakit_kronis" class="js-example-basic-single form-control">
								<option value="0" <?php echo ( ( $art->penyakit_kronis == '0' ) ? 'selected' : null );?> > Tidak Disabilitas </option>
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
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="partisipasi_sekolah" value="0" <?php echo ( ( $art->partisipasi_sekolah == '0' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak/Belum Bersekolah  </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="partisipasi_sekolah" value="1" <?php echo ( ( $art->partisipasi_sekolah == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Masih Sekolah </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="partisipasi_sekolah" value="2" <?php echo ( ( $art->partisipasi_sekolah == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak Bersekolah </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">16. Jenjang Dan Jenis Pendidikan Tertinggi Yang Pernah/Sedang Diduduki</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="1" <?php echo ( ( $art->pendidikan_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> SD/SDLB </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="2" <?php echo ( ( $art->pendidikan_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket A </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="3" <?php echo ( ( $art->pendidikan_tertinggi == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Ibtidaiyah </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="4" <?php echo ( ( $art->pendidikan_tertinggi == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMP/SMPLB </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="5" <?php echo ( ( $art->pendidikan_tertinggi == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket B </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="6" <?php echo ( ( $art->pendidikan_tertinggi == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Tsanawiyah </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="7" <?php echo ( ( $art->pendidikan_tertinggi == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMA/SMK/SMALB </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="8" <?php echo ( ( $art->pendidikan_tertinggi == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Paket C </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="9" <?php echo ( ( $art->pendidikan_tertinggi == '9' ) ? 'checked' : null );?> > <span class="custom-control-label"> M Aliyah </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="pendidikan_tertinggi" value="10" <?php echo ( ( $art->pendidikan_tertinggi == '10' ) ? 'checked' : null );?> > <span class="custom-control-label"> Perguruan Tinggi </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">17. Kelas Tertingi Yang Pernah/Sedang Di duduki</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="kelas_tertinggi" value="1" <?php echo ( ( $art->kelas_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> 1 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="kelas_tertinggi" value="2" <?php echo ( ( $art->kelas_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> 2 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="kelas_tertinggi" value="3" <?php echo ( ( $art->kelas_tertinggi == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> 3 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="kelas_tertinggi" value="4" <?php echo ( ( $art->kelas_tertinggi == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> 4 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="kelas_tertinggi" value="5" <?php echo ( ( $art->kelas_tertinggi == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> 5 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="kelas_tertinggi" value="6" <?php echo ( ( $art->kelas_tertinggi == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> 6 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="kelas_tertinggi" value="7" <?php echo ( ( $art->kelas_tertinggi == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> 7 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="kelas_tertinggi" value="8" <?php echo ( ( $art->kelas_tertinggi == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> 8 (Tamat) </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">18. Ijazah Tertinggi Yang Dimiliki</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ijazah_tertinggi" value="0" <?php echo ( ( $art->ijazah_tertinggi == '0' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak Punya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ijazah_tertinggi" value="1" <?php echo ( ( $art->ijazah_tertinggi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> SD/Sederajat </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ijazah_tertinggi" value="2" <?php echo ( ( $art->ijazah_tertinggi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMP/Sederajat </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ijazah_tertinggi" value="3" <?php echo ( ( $art->ijazah_tertinggi == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> SMA/Sederajat </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ijazah_tertinggi" value="4" <?php echo ( ( $art->ijazah_tertinggi == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> D1/D2/D3 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ijazah_tertinggi" value="5" <?php echo ( ( $art->ijazah_tertinggi == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> D4/S1 </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ijazah_tertinggi" value="6" <?php echo ( ( $art->ijazah_tertinggi == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> S2/S3 </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">19. Bekerja/Membantu Bekerja Selama Seminggu Yang Lalu</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio" onclick="enable_2021(1)" class="custom-control-input" name="status_bekerja" value="1" <?php echo ( ( $art->status_bekerja == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio" onclick="enable_2021(2)" class="custom-control-input" name="status_bekerja" value="2" <?php echo ( ( $art->status_bekerja == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Lama bekerja</label>
						<div class="col-sm-8">
							<input type="number" class="form-control form-control-sm" name="jumlah_jam_kerja" value="<?php echo $art->jumlah_jam_kerja > 98 ? 98 : $art->jumlah_jam_kerja;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">20. Lapangan Usaha Dari Pekerjaan Utama</label>
						<div class="col-sm-6">
							<select id="lapangan_usaha" name="lapangan_usaha" class="js-example-basic-single form-control disabledd">
								<option value="0" selected> -=Please Select=-</option>
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
						<label class="col-sm-12 col-form-label-sm f-w-900">21. Status Kedudukan Dalam Pekerjaan Utama</label>
						<div class="col-sm-6">
							<select id="status_pekerjaan" name="status_pekerjaan" class="js-example-basic-single form-control disabledd">
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
							<select id="status_keberadaan_art" name="status_keberadaan_art" class="js-example-basic-single form-control">
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
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_kks" value="1" <?php echo ( ( $art->ada_kks == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_kks" value="2" <?php echo ( ( $art->ada_kks == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">24. KIS/PBI JKN</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_pbi" value="1" <?php echo ( ( $art->ada_pbi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_pbi" value="2" <?php echo ( ( $art->ada_pbi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">Nomor KIS/PBI JKN</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" name="no_peserta_pbi" value="<?php echo $art->no_peserta_pbi;?>" >
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">25. KIP/BSM</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_kip" value="1" <?php echo ( ( $art->ada_kip == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_kip" value="2" <?php echo ( ( $art->ada_kip == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">26. PKH</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_pkh" value="1" <?php echo ( ( $art->ada_pkh == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_pkh" value="2" <?php echo ( ( $art->ada_pkh == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-12 col-form-label-sm f-w-900">27. Kartu Sembako/BPNT</label>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_rastra" value="1" <?php echo ( ( $art->ada_rastra == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
						</label>
						</div>
						<div class="col-sm-12">
						<label class="radio-inline custom-control custom-radio">
							<input type="radio"  class="custom-control-input" name="ada_rastra" value="2" <?php echo ( ( $art->ada_rastra == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak </span>
						</label>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label-sm f-w-900">28. Nama Ibu Kandung</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" name="nama_gadis_ibu_kandung" value="<?php echo $art->nama_gadis_ibu_kandung;?>" >
						</div>
					</div>
				</div>
			</div>		
		</form>
	</div>
</div>
<script type="text/javascript">

	$(document).ready( function(){

		// $(document).on( 'click', 'button.btn-save-art', function(){
		// 	var data = $("#form_art").serialize();
		// 	$.ajax({
		// 		url:"<?php echo base_url('verivali/detail_data/act_detail_save_art/'); ?>",
		// 		type: 'POST',
		// 		data: data,
		// 		dataType: 'json',
		// 		success : function( data ) {
		// 			if ( data.status == 200 ) {
		// 				alert(data.message);
		// 				location.reload();
		// 				return false;
		// 			} else {
		// 				alert(data.message);
		// 			}
		// 		},
		// 	});
		// });

		// let radio19 = $('input[name=status_bekerja]:checked').val()
		// enable_2021(radio19);
	});

	function enable_2021(ret) {
		if (ret < 2) {
			$('.disabledd').removeAttr( 'disabled' );
		} else {
			$('.disabledd').attr( 'disabled', true );
		}
	}

	$('input[name=jumlah_jam_kerja]').on('keydown keyup', function(e){
		if ($(this).val() > 98
			&& e.keyCode !== 46 // keycode for delete
			&& e.keyCode !== 8 // keycode for backspace
			) {
			e.preventDefault();
			$(this).val(98);
		}
	});
</script>
