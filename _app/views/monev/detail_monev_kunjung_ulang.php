<style type="text/css">
	.loc-ul {list-style-type: none; margin: 0; padding: 0 0 0 25px; display: none; } .loc-li {cursor: pointer; -webkit-user-select: none; /* Safari 3.1+ */ -moz-user-select: none; /* Firefox 2+ */ -ms-user-select: none; /* IE 10+ */ user-select: none; font-size: 23px; padding-right: 10px; display: block; } .loc-text{cursor: pointer; font-family: 'Arial'; font-size: 14px; } .loc::before {content: "\2610"; color: black; display: inline-block; margin-right: 6px; width:10px; } .loc-check::before {content: "\2611"; color: dodgerblue; } .loc-half-check::before {content: "\2612"; color: dodgerblue; } .loc-ul-active {display: block;} .btn-exs{padding: 0.125rem 0.25rem;font-size: smaller;color: black;} .subor::before {content: "\2610"; display: inline-block; font-size: 16px;} .subor-check::before {content: "\2611"; color: dodgerblue; }
</style>
<div class="modal-body">
<div class="col-md-12 p-20">
	<span class="badge badge-primary">Detail Monev Enumerator</span>
</div>
<div class="col-md-12 mt-md-6">
	<ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link text-reset active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false"><i class="feather icon-user mr-2"></i>Informasi Umum</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-reset" id="group-tab" data-toggle="tab" href="#group" role="tab" aria-controls="foto" aria-selected="false"><i class="feather icon-user-check mr-2"></i>Verifikasi Rumah Tangga</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-reset" id="group-tab" data-toggle="tab" href="#anggota_ruta" role="tab" aria-controls="foto" aria-selected="false"><i class="feather icon-user-check mr-2"></i>Anggota Rumah Tangga</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-reset" id="group-tab" data-toggle="tab" href="#perumahan" role="tab" aria-controls="foto" aria-selected="false"><i class="feather icon-user-check mr-2"></i>Keterangan Perumahan</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-reset" id="sosial-ekonomi-art-tab" data-toggle="tab" href="#sosial-ekonomi-art" role="tab" aria-controls="sosial-ekonomi-art" aria-selected="false"><i class="feather icon-edit mr-2"></i>Nama ART</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-reset" id="nomor-kk-tab" data-toggle="tab" href="#nomor-kk" role="tab" aria-controls="sosial-ekonomi-art" aria-selected="false"><i class="feather icon-edit mr-2"></i>Nomor KK</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-reset" id="foto-tab" data-toggle="tab" href="#foto" role="tab" aria-controls="sosial-ekonomi-art" aria-selected="false"><i class="feather icon-edit mr-2"></i>Foto</a>
		</li>			
	</ul>
</div>
<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="card-body">
					<input type="hidden" name="proses_id" value="<?php echo $proses_id;?>">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">ID01	NAMA PETUGAS MONITORING</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_nama_petugas;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">ID02	TANGGAL KUNJUNGAN ULANG</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo date("l d-m-Y",strtotime($monev_detail->mku_tgl_kunjungan));?>" >
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="border border-secondary p-2">
					<h5>INFORMASI UMUM</h5>
				</div>
				<div class="card-body">
					<input type="hidden" name="proses_id" value="<?php echo $proses_id;?>">
					<div class="row">					
						<!-- left-side -->
						<div class="col-md-6 col-sm-12">
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">IU01	ID PRELIST</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->id_prelist;?>" readonly>
									</div>
								</div>									
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">IU02	PROVINSI</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->province_name;?>" readonly>
									</div>
								</div>									
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan Data</label>
									<div class="col-sm-6">
										<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_provinsi_perbaikan;?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">IU03	KABUPATEN/KOTA</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->regency_name;?>" readonly>
									</div>
								</div>									
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan Data</label>
									<div class="col-sm-6">
										<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_kab_perbaikan;?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">IU04	KECAMATAN</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->district_name;?>" readonly>
									</div>
								</div>									
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan Data</label>
									<div class="col-sm-6">
										<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_kec_perbaikan;?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">IU05	DESA/KELURAHAN</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->village_name;?>" readonly>
									</div>
								</div>									
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan Data</label>
									<div class="col-sm-6">
										<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_kel_perbaikan;?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">IU06	NAMA SLS</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->nama_sls;?>" readonly>
									</div>
								</div>
								
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan Data</label>
									<div class="col-sm-6">
										<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_nama_perbaikan;?>" readonly>
									</div>
								</div>
							</div>								
						</div>
						<!-- end-left-side -->

						<!-- right-side -->
						<div class="col-md-6 col-sm-12">
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-8 col-form-label-sm f-w-900">IU07	ALAMAT RUMAH TANGGA</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->alamat;?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_alamat_art_perbaikan;?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-8 col-form-label-sm f-w-900">IU08	NAMA RESPONDEN</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->nama_krt;?>" readonly>
									</div>
								</div>
								
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan Data</label>
									<div class="col-sm-6">
										<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_nama_responden_perbaikan;?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-10 col-form-label-sm f-w-900">Jabatan Responden </label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-sm-12">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jabatan_responden_dalam_sls_setempat == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Pengurus RT</span>
										</label>
									</div>
									<div class="col-sm-12">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jabatan_responden_dalam_sls_setempat == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Pengurus RW</span>
										</label>
									</div>
									<div class="col-sm-12">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_jabatan_responden_dalam_sls_setempat == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Perangkat kelurahan</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-8 col-form-label-sm f-w-900">IU09	TANGGAL WAWANCARA RUMAH TANGGA</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo date("l d-m-Y",strtotime($monev_detail->tanggal_verivali));?>" readonly>
									</div>
								</div>
								
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm f-w-900">Perbaikan Data</label>
									<div class="col-sm-6">
										<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo date("l d-m-Y",strtotime($monev_detail->mku_tgl_wawancara_perbaikan));?>" readonly>
									</div>
								</div>
							</div>
						</div>
						<!-- end-right-side -->
					</div>
					<!-- end-row -->
				</div>
				<!-- end-card-body -->
			</div>
		</div>
	</div>

	<div class="tab-pane fade show" id="group" role="tabpanel" aria-labelledby="group-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="card-body">
					<div class="form-row">
						<div  class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">VP01	Apakah responden pernah mendengar mengenai verifikasi dan validasi Data Terpadu Penanganan Fakir Miskin dan Orang Tidak Mampu? </label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_mendengar_verfikasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_mendengar_verfikasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak -> VP03
								</div>
								
							</div>
						</div>
					</div>
					<div class="form-row">
						<div  class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">VP02	Apa saja informasi yang diketahui?</label>
							</div>
						</div>
					</div>
					<div class="form-row m-l-15">
						<div class="col-md-10">
							<div class="form-group row">
								<div class="col-sm-10 custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" <?php echo ( ( $monev_detail->mku_tujuan_verifikasi == '1' ) ? 'checked' : null );?> > <label class="custom-control-label"> A. Tujuan verifikasi dan validasi Data Terpadu Penanganan Fakir Miskin dan Orang Tidak Mampu</label>
								</div>							
							</div>
						</div>
					</div>
					<div class="form-row m-l-15">
						<div class="col-md-10">
							<div class="form-group row">
								<div class="col-sm-10 custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" <?php echo ( ( $monev_detail->mku_dpt_bantuan == '1' ) ? 'checked' : null );?> > <label class="custom-control-label"> B. Untuk mendapatkan program bantuan</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row m-l-15">
						<div class="col-md-10">
							<div class="form-group row">
								<div class="col-sm-10 custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" <?php echo ( ( $monev_detail->mku_pendapatan == '1' ) ? 'checked' : null );?> > <label class="custom-control-label"> C. Pendataan untuk orang miskin atau tidak mampu</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row m-l-15">
						<div class="col-md-10">
							<div class="form-group row">
								<div class="col-sm-10 custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" <?php echo ( ( $monev_detail->mku_lainnya == '1' ) ? 'checked' : null );?> > <label class="custom-control-label"> D. Lainnya</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div  class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">VP03	Apakah rumah tangga ini pernah didatangi dan diwawancara oleh petugas pengumpul data? </label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_pernah_diwawancarai == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya </span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_pernah_diwawancarai == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak -> B31a</span>
									</label>
								</div>
								
							</div>
						</div>
					</div>
					<div class="form-row">
						<div  class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">VP04	Apakah petugas pengumpul data menjelaskan tujuan wawancara? </label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_def_tujuan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_def_tujuan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div  class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">VP05. Apakah petugas pengumpul data dalam melaksanakan tugasnya menggunakan kartu identitas?</label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_menggunakan_kartu_identitas == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_menggunakan_kartu_identitas == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div  class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">VP06. Apakah petugas pengumpul data dalam melaksanakan tugasnya mengambil foto/dokumentasi?</label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_mengambil_foto == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_mengambil_foto == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div  class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">VP07. Berapa lama waktu yang dibutuhkan oleh pengumpul data untuk melakukan verifikasi dan validasi di rumah tangga responden?</label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_lama_waktu_verval == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> 30 Menit</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_lama_waktu_verval == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> 60 Menit</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_lama_waktu_verval == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> 90 Menit</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->mku_lama_waktu_verval == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_lama_waktu_verval_lainnya;?>" >
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="tab-pane fade show" id="anggota_ruta" role="tabpanel" aria-labelledby="group-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">AR01	Nama KRT</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-6">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->nama_krt;?>" readonly>
								</div>
							</div>
							
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label-sm">Hasil Konfirmasi</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_nama_krt_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_nama_krt_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label-sm">Perbaikan Data</label>
								<div class="col-sm-6">
									<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_nama_krt_perbaikan;?>" readonly>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">AR02	Jumlah Anggota Rumah Tangga</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-6">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_art;?>" readonly>
								</div>
							</div>
							
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label-sm">Hasil Konfirmasi</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jml_anggota_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jml_anggota_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label-sm">Perbaikan Data</label>
								<div class="col-sm-6">
									<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_jml_anggota_perbaikan;?>" readonly>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">AR03	Jumlah Keluarga</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-6">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_keluarga;?>" readonly>
								</div>
							</div>
							
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label-sm">Hasil Konfirmasi</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jml_kel_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jml_kel_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label-sm">Perbaikan Data</label>
								<div class="col-sm-6">
									<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->mku_jml_kel_perbaikan;?>" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="tab-pane fade show" id="perumahan" role="tabpanel" aria-labelledby="data-tab">
		<div class="row">
			<div class="col-sm-12">
			<div class="border border-secondary p-2 m-t-10">
					<h5>B31a Status Ppenguasaan Bangunan Tempat Tinggal Yang Ditempati</h5>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->status_bangunan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Milik Sendiri</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->status_bangunan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kontrak/Sewa</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->status_bangunan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bebas Sewa</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->status_bangunan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Dinas</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->status_bangunan == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnnya</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi </label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_penguasaan_bangunan_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_penguasaan_bangunan_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan Data</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_penguasaan_bangunan_perbaikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Milik Sendiri
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_penguasaan_bangunan_perbaikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kontrak/Sewa</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_penguasaan_bangunan_perbaikan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bebas Sewa</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->mku_penguasaan_bangunan_perbaikan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Dinas</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->mku_penguasaan_bangunan_perbaikan == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnnya</span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="border border-secondary p-2">
					<h5>B31b Status Lahan Tempat Tinggal Yang Ditempati</h5>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->status_lahan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Milik Sendiri</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->status_lahan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Milik Orang Lain</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->status_lahan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tanah Negara</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->status_lahan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi </label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_status_lahan_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_status_lahan_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan Data</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_status_lahan_perbaikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Milik Sendiri</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_status_lahan_perbaikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Milik Orang Lain</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_status_lahan_perbaikan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tanah Negara</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->mku_status_lahan_perbaikan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="border border-secondary p-2">
					<h5>B303 Jenis Lantai Terluas </h5>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->lantai == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Marmer/Granit</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->lantai == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Keramik</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->lantai == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Parket/Vinil/Permadani</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->lantai == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ubin/Tegal/Teraso</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->lantai == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kayu/Papan Berkualitas Tinggi</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $monev_detail->lantai == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Sementara/Bata Merah</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $monev_detail->lantai == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bambu</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $monev_detail->lantai == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kayu/Papan Berkualitas Rendah</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="9" <?php echo ( ( $monev_detail->lantai == '9' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tanah</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="10" <?php echo ( ( $monev_detail->lantai == '10' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi </label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jenis_lantai_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jenis_lantai_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan Data</label>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Marmer/Granit</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Keramik</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Parket/Vinil/Permadani</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ubin/Tegal/Teraso</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kayu/Papan Berkualitas Tinggi</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Sementara/Bata Merah</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bambu</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kayu/Papan Berkualitas Rendah</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="9" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '9' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tanah</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="10" <?php echo ( ( $monev_detail->mku_jenis_lantai_perbaikan == '10' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="border border-secondary p-2">
					<h5>B34a Jenis Dinding Terluas </h5>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->dinding == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tembok</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->dinding == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Plesteran Anyaman Bambu/Kawat</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->dinding == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kayu</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->dinding == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Anyaman Bambu</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->dinding == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Batang Kayu</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $monev_detail->dinding == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bambu</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $monev_detail->dinding == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi </label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jenis_dinding_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jenis_dinding_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan Data</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jenis_dinding_perbaikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tembok</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jenis_dinding_perbaikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Plesteran Anyaman Bambu/Kawat</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_jenis_dinding_perbaikan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Kayu</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->mku_jenis_dinding_perbaikan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Anyaman Bambu</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->mku_jenis_dinding_perbaikan == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Batang Kayu</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $monev_detail->mku_jenis_dinding_perbaikan == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bambu</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $monev_detail->mku_jenis_dinding_perbaikan == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="border border-secondary p-2">
					<h5>B35a Jenis Atap Terluas</h5>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->atap == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Beton/Genteng Beton</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->atap == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Genteng Keramik</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->atap == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Genteng Metal</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->atap == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Genteng Tanah Liat</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->atap == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Asbes</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $monev_detail->atap == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Seng</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $monev_detail->atap == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Sirap</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $monev_detail->atap == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bambu</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="9" <?php echo ( ( $monev_detail->atap == '9' ) ? 'checked' : null );?> > <span class="custom-control-label"> Jerami/Ijuk/Daun-Daunan/Rumbia</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="10" <?php echo ( ( $monev_detail->atap == '10' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi </label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan Data</label>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Beton/Genteng Beton</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Genteng Keramik</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Genteng Metal</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> Genteng Tanah Liat</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Asbes</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Seng</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="7" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '7' ) ? 'checked' : null );?> > <span class="custom-control-label"> Sirap</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="8" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '8' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bambu</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="9" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '9' ) ? 'checked' : null );?> > <span class="custom-control-label"> Jerami/Ijuk/Daun-Daunan/Rumbia</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="10" <?php echo ( ( $monev_detail->mku_jenis_atap_perbaikan == '10' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="border border-secondary p-2">
					<h5>B39a Sumber Penerangan utama</h5>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->sumber_penerangan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Listrik PLN</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->sumber_penerangan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Listrik Non PLN</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->sumber_penerangan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bukan Listrik</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi </label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_sumber_penerangan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_sumber_penerangan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan Data</label>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_sumber_penerangan_perbaikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Listrik PLN</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_sumber_penerangan_perbaikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Listrik Non PLN</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_sumber_penerangan_perbaikan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> Bukan Listrik</span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="border border-secondary p-2">
					<h5>B39b Daya Terpasang</h5>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Data</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->daya == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> 450 Watt</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->daya == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> 900 Watt</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->daya == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> 1.300 Watt</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->daya == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> 2.200 Watt</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->daya == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lebih Dari 2.200 Watt</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $monev_detail->daya == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tanpa Meteran</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Hasil Konfirmasi </label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_daya_terpasang_konfirmasi == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Benar</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_daya_terpasang_konfirmasi == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Salah</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label-sm f-w-900">Perbaikan Data</label>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mku_daya_terpasang_perbaikan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> 450 Watt</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mku_daya_terpasang_perbaikan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> 900 Watt</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->mku_daya_terpasang_perbaikan == '3' ) ? 'checked' : null );?> > <span class="custom-control-label"> 1.300 Watt</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->mku_daya_terpasang_perbaikan == '4' ) ? 'checked' : null );?> > <span class="custom-control-label"> 2.200 Watt</span>
									</label>
								</div>
								<div class="col-sm-3">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->mku_daya_terpasang_perbaikan == '5' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lebih Dari 2.200 Watt</span>
									</label>
								</div>
								<div class="col-sm-2">
									<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="6" <?php echo ( ( $monev_detail->mku_daya_terpasang_perbaikan == '6' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tanpa Meteran</span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>						
			</div>
		</div>
	</div>

	<div class="tab-pane fade show" id="sosial-ekonomi-art" role="tabpanel" aria-labelledby="sosial-ekonomi-art-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Nama</th>
								<th>NIK</th>
								<th>Hubungan Dengan KRT</th>
								<th>No Urut</th>
								<th>Hubungan dengan KK</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
		
							foreach ( $art as $k => $val) {
							$detail = '<button act="' . base_url( 'monev/monev_kunjungan_ulang' ) . '/get_form_detail_art/' . enc( [ 'id' => $val->id ] ) . '" class="btn btn-warning btn-xs btn-edit-art" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';
							if($val->hubungan_keluarga=='1')
								$hubungan_keluarga='Kepala keluarga';
							elseif($val->hubungan_keluarga=='2')
								$hubungan_keluarga='Istri/Suami';
							elseif($val->hubungan_keluarga=='3')
								$hubungan_keluarga='Anak';
							elseif($val->hubungan_keluarga=='4')
								$hubungan_keluarga='Menantu';
							elseif($val->hubungan_keluarga=='5')
								$hubungan_keluarga='Cucu';
							elseif($val->hubungan_keluarga=='6')
								$hubungan_keluarga='Orang Tua/Mertua';
							elseif($val->hubungan_keluarga=='7')
								$hubungan_keluarga='Pembantu ruta';
							elseif($val->hubungan_keluarga=='8')
								$hubungan_keluarga='Lainnya';
							else
								$hubungan_keluarga='';
								echo '
							<tr>
								<td>' . $val->nama . '</td>
								<td>' . $val->nik . '</td>
								<td>' . $val->hubungan_krt . '</td>
								<td>' . $val->index . '</td>
								<td>' . $hubungan_keluarga . '</td>
								<td>' . $detail . '</td>
							</tr>
								';
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="tab-pane fade show" id="nomor-kk" role="tabpanel" aria-labelledby="nomor-kk-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Nomor Urut</th>
								<th>No KK</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach ( $kk as $k => $val) {
							$detail = '<button act="' . base_url( 'monev/monev_kunjungan_ulang' ) . '/get_form_detail_kk/' . enc( [ 'id' => $val->id ] ) . '" class="btn btn-warning btn-xs btn-edit-kk" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';
					
								echo '
							<tr>
								<td>' . $val->nuk . '</td>
								<td>' . $val->nokk . '</td>
								<td>' . $detail . '</td>
							</tr>
								';
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="tab-pane fade show" id="foto" role="tabpanel" aria-labelledby="foto-tab">
		<div class="row">
			<div class="col-sm-12">
				<img src="">
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Status</th>
								<th>Preview</th>
								<th>Nama Berkas</th>
								<th>Catatan / Keterangan</th>
								<th>Ukuran</th>
								<th>Lintang</th>
								<th>Bujur</th>
								<th>Diunggah Pada</th>
								<th>Diunggah Oleh</th>
								<th>Jenis</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ( $foto as $k => $v ) {
							echo '
							<tr>
								<td>' . $v->row_status . '</td>
								<td><img src="' . str_replace( "./", "http://66.96.235.136:8080/apiverval/", $v->internal_filename) . '" width="100px"></td>
								<td>' . $v->file_name . '</td>
								<td>' . $v->description . '</td>
								<td>' . $v->file_size . '</td>
								<td>' . $v->latitude . '</td>
								<td>' . $v->longitude . '</td>
								<td>' . $v->created_on . '</td>
								<td>' . $v->user_account_username . '</td>
								<td>' . $v->file_type . '</td>
								<td></td>
							</tr>
							';
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>	
</div>
</div>

<div class="modal" id="modalFormArt">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div id="modalContentArt" class="modal-content">
		</div>
	</div>
</div>
<div class="modal" id="modalFormKK">
	<div class="modal-dialog modal-sm modal-dialog-scrollable">
		<div id="modalContentKK" class="modal-content">
		</div>
	</div>
</div>

<script type="text/javascript">
	function show_form_art( url ){
		$.ajax({
			url:url,
			type: 'GET',
			dataType: 'html',
			beforeSend: function( xhr ) {
				$('#loader').modal('show');
			},
			success : function(data) {
				$('#loader').modal('hide');
				$('#modalContentArt').html(data);
				$('#modalFormArt').modal('show');
			},
		});
	}
	
	function show_form_kk( url ){
		$.ajax({
			url:url,
			type: 'GET',
			dataType: 'html',
			beforeSend: function( xhr ) {
				$('#loader').modal('show');
			},
			success : function(data) {
				$('#loader').modal('hide');
				$('#modalContentKK').html(data);
				$('#modalFormKK').modal('show');
			},
		});
	}
	$(document).ready(function() {
		
		$(document).on( 'click', 'button.btn-edit-art', function(){
			show_form_art( $(this).attr('act') );
		});
		
		$(document).on( 'click', 'button.btn-edit-kk', function(){
			show_form_kk( $(this).attr('act') );
		});
		
	});
</script>
