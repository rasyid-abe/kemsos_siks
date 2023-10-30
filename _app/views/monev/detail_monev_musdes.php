<style type="text/css">
	.loc-ul {list-style-type: none; margin: 0; padding: 0 0 0 25px; display: none; } .loc-li {cursor: pointer; -webkit-user-select: none; /* Safari 3.1+ */ -moz-user-select: none; /* Firefox 2+ */ -ms-user-select: none; /* IE 10+ */ user-select: none; font-size: 23px; padding-right: 10px; display: block; } .loc-text{cursor: pointer; font-family: 'Arial'; font-size: 14px; } .loc::before {content: "\2610"; color: black; display: inline-block; margin-right: 6px; width:10px; } .loc-check::before {content: "\2611"; color: dodgerblue; } .loc-half-check::before {content: "\2612"; color: dodgerblue; } .loc-ul-active {display: block;} .btn-exs{padding: 0.125rem 0.25rem;font-size: smaller;color: black;} .subor::before {content: "\2610"; display: inline-block; font-size: 16px;} .subor-check::before {content: "\2611"; color: dodgerblue; }
</style>
<div class="card">
	<div class="col-md-12" style="padding: 16px;background: #f7f7f7;border-bottom: 1px #000 solid;"><i class="fa fa-info-circle"></i>&nbsp;Detail Monev Musdes</div>
	<div class="col-md-12 mt-md-6">
		<ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link text-reset active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false"><i class="feather icon-user mr-2"></i>Pengenalan Tempat</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="group-tab" data-toggle="tab" href="#group" role="tab" aria-controls="foto" aria-selected="false"><i class="feather icon-user-check mr-2"></i>Foto</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="map-tab" data-toggle="tab" href="#map" role="tab" aria-controls="audit" aria-selected="false"><i class="feather icon-map-pin mr-2"></i>Audit</a>
			</li>
			
		</ul>
	</div>
</div>
<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="">
					<div class="card-body">
						<input type="hidden" name="monev_musdes_id" value="<?php echo $monev_musdes_id;?>">
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Propinsi</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->province_name;?>" readonly>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Kabupaten</label>
									<div class="col-sm-6">
										<input name="user_email" type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->regency_name;?>" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Kecamatan</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->district_name;?>" readonly>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Kelurahan</label>
									<div class="col-sm-6">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->village_name;?>" readonly>
									</div>
								</div>
								
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Lokasi Pelaksanaan Musyawarah</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->lokasi_mnv_musdes;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Tanggal Pelaksanaan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo date("d-m-Y",strtotime($monev_detail->tanggal_mnv_musdes));?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jam Pelaksanaan Musyawarah</label>
									<div class="col-sm-4">Jam Mulai
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jam_mulai_musdes;?>" >
									</div>
									<div class="col-sm-4">Jam Selesai
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jam_selesai_musdes;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Nama Petugas Monitoring</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->petugas_mnv_musdes;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Pengamatan Langsung Musyawarah Kelurahan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->pengamatan_musdes;?>" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK01. Siapa yang memimpin jalannya musyawarah desa/kelurahan/nama lain ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Nama Pemimpin</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->nama_pemimpin_musdes;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jabatan Pemimpin Musdes</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jabatan_pemimpin_musdes;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Nama Pemimpin</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->nama_pemimpin_musdes;?>" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK02. Berapa Jumlah Rukun Warga (RW) di Kelurahan/Desa ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah RW</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_rw;?> orang" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK03. Berapa Jumlah Rukun Warga (RW) Yang Diundang dalam musyawarah ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah RW diundang</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_rw_diundang;?> orang" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK04. Berapa Jumlah Perwakilan RW Yang Hadir ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah Perwakilan RW</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_perwakilan_rw;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Laki-Laki</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_pria_rw;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Perempuan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_perempuan_rw;?> orang" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK05. Berapa Jumlah Rukun Tangga (RT) di Kelurahan/Desa ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah RT</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_rt;?> orang" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK06. Berapa Jumlah Rukun Tangga (RT) Yang Diundang dalam musyawarah ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah RT diundang</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_rt_diundang;?> orang" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK07. Berapa Jumlah Perwakilan RT Yang Hadir ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah Perwakilan RT</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_perwakilan_rt;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Laki-Laki</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_pria_rt;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Perempuan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_perempuan_rt;?> orang" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK08. Peserta Musyawarah Kelurahan Selain Ketua RW dan Ketua RT</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">a. Bintara Pembina Desa</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->bintara_pembina_desa;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">b. Tokoh Masyarakat</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->tokoh_masyarakat;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">c. Tokoh Agama</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->tokoh_agama;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">d. Aparat Desa/Kelurahan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->aparat_desa;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">e. Lainnya</label>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Lainnya 1</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->lainnya_1;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah Lainnya 1</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_lainnya_1;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Lainnya 2</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->lainnya_2;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah Lainnya 2</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_lainnya_2;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Lainnya 3</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->lainnya_3;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah Lainnya 3</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_lainnya_3;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Laki-Laki</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->total_pria;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Perempuan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->total_perempuan;?> orang" >
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="card-header">
						<h5>MK.09. Apakah ada penjelasan mengenai tujuan Musdes dan Verival DT PFM dan OTM dan Pimpinan Musyawarah ? </h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-4">
								<div class="form-group row">
									<label class="col-sm-10 col-form-label-sm">Penjelasan Tujuan</label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->ada_penjelasan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
										</label>
									</div>
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->ada_penjelasan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
										</label>
									</div>									
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK10. Jelaskan proses pemeriksaan daftar awal sasaran</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Proses Pemeriksaan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jelaskan_proses_pemeriksaan;?>" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK11. Jelaskan Proses Pengusulan Rumah Tangga Barun</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Proses Pengusulan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jelaskan_proses_pengusulan_rt;?>" >
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK12. Apakah ada indikator-indikator yang digunakan dalam mengusulkan rumah tangga baru ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div  class="col-md-4">
								<div class="form-group row">
									<label class="col-sm-10 col-form-label-sm">Penggunaan Indikator</label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->indikator_usulan_baru == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
										</label>
									</div>
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->indikator_usulan_baru == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
										</label>
									</div>									
								</div>
							</div>
						</div>
					</div>

					<div class="card-header">
						<h5>MK13. Apa saja indikator-indikator tersebut ?</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 1</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_1;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 2</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_2;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 3</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_3;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 4</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_4;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 5</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_5;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 6</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_6;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 7</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_7;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 8</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_8;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 9</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_9;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Indikator 10</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->indikator_10;?>" >
									</div>
								</div>
							</div>
							
						</div>
					</div>

					<div class="card-header">
						<h5>Pengawasan Administrasi</h5><br/>
						<h5>(Petugas pemantau memeriksa kelengkapan dokumen yang digunakan pada Musdes)</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-4">
								<div class="form-group row">
									<label class="col-sm-10 col-form-label-sm">MK14. Apakah ada proses pengesahan hasil melalui berita acara musyawarah desa/kelurahan ? </label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->apakah_ada_pengesahan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
										</label>
									</div>
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->apakah_ada_pengesahan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group row">
									<label class="col-sm-10 col-form-label-sm">MK15. Apakah ada daftar hadir yang ditandatangani dan distempel desa/kelurahan ?  </label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->apakah_ada_daftar_hadir == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
										</label>
									</div>
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->apakah_ada_daftar_hadir == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group row">
									<label class="col-sm-10 col-form-label-sm">MK16. Apakah ada daftar awal sasaran rumah tangga dari DT PFM dan OTM ? </label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->apakah_ada_prelist_dt == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
										</label>
									</div>
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->apakah_ada_prelist_dt == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group row">
									<label class="col-sm-10 col-form-label-sm">MK17. Apakah ada daftar awal sasaran rumah tangga dari pendaftaran aktif ?</label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->apakah_ada_prelist_pendaftaran == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
										</label>
									</div>
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->apakah_ada_prelist_pendaftaran == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group row">
									<label class="col-sm-10 col-form-label-sm">MK18. Apakah ada daftar awal sasaran rumah tangga dari Daftar usulan rumah tangga baru dari Musdes ?</label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->apakah_ada_prelist_usulan_baru == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
										</label>
									</div>
									<div class="col-sm-4">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->apakah_ada_prelist_usulan_baru == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<div class="tab-pane fade show table-responsive f-12" id="group" role="tabpanel" aria-labelledby="group-tab">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Status</th>
							<th>Preview</th>
							<th>Nama Berkas</th>
							<th>Jenis</th>
							<th>Catatan</th>
							<th>Ukuran</th>
							<th>Lintang</th>
							<th>Bujur</th>
							<th>Diunggah Pada</th>
							<th>Diunggah Oleh</th>							
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ( $foto as $k => $v ) {
						$on = date("d-m-Y H:i:s",strtotime($v->created_on));
						echo '
						<tr>
							<td>' . $v->row_status . '</td>
							<td><img src="' . str_replace( "./", "http://66.96.235.136:8080/apiverval/", $v->internal_filename) . '" width="100px"></td>
							<td>' . substr($v->file_name, 0, 15) . '...</td>							
							<td>' . $v->stereotype . '</td>
							<td>' . $v->description . '</td>
							<td>' . $v->file_size . '</td>
							<td>' . $v->latitude . '</td>
							<td>' . $v->longitude . '</td>
							<td>' . $on . '</td>
							<td>' . $v->user_account_username . '</td>
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

	<div class="tab-pane fade table-responsive f-12" id="map" role="tabpanel" aria-labelledby="map-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<table class="table table-striped table-xs table-bordered m-t-10">
						<thead>
							<tr>
								<th>Action</th>
								<th>By</th>
								<th>From</th>
								<th>On</th>
								<th>Verification Status</th>
								<th>Remark</th>
								<th>Fields Changed</th>
								<th>Detail</th>
							</tr>
						</thead>
						<tbody>
							<?php
							  
							// Sort the array  
							$audit_trail = json_decode( $monev_detail->audit_trails, true ); 
							if ( $audit_trail ) {
								foreach ( $audit_trail as $key => $value) {
									$on = date("d-m-Y H:i:s",strtotime($value['on']));
									echo '
										<tr>
											<td>' . $value['act'] . '</td>
											<td>' . $value['username'] . ' ( ' . $value['user_id'] . ' )</td>
											<td>' . $value['ip'] . '</td>
											<td>' . $on . '</td>
											<td>' . $value['column_data']['stereotype'] . '</td>
											<td>' . $on . '</td>
											<td>' . ( ( array_key_exists( 'properties', $value['column_data'] ) ) ? count( $value['column_data']['properties'] ) : '0' ) . '</td>
											<td> ' . ( ( array_key_exists( 'properties', $value['column_data'] ) ) ? '<button class="btn btn-sm btn-success btn-detail-audit" data=\'' . json_encode( $value['column_data']['properties'] ) . '\'><i class="feather icon-search"></i></button>' : null ) . '</td>
										</tr>
									';
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>  
</div>

<div class="modal" id="modalDetailAudit">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail Data Audit</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div id="detail-data"></div>
			</div>
		</div>
	</div>
 </div>
<!-- <link rel="stylesheet" href="<?php //echo base_url();?>assets/addons/jquery-validate/jquery.validate-1.9.1.min.js"> -->
<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
<script type="text/javascript">
	detail_user = <?php echo json_encode( $monev_detail );?>
	
	$(document).ready( function(){
		$( '.btn-detail-audit' ).on( 'click', function(){
			let detail = $.parseJSON( $(this).attr('data') );
			console.log(detail, 'data:');
			let html = '';
			$.each( detail, function(x,y){
				html += `
					<div class="row col-12"><label class="col-6">${x}</label>=<label class="row col-6 label label-success">&nbsp;${y}</div>`;
			})
			$('#detail-data').html( html );
			$('#modalDetailAudit').modal( 'show' );
		})
	});
</script>
