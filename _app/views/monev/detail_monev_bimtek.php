<style type="text/css">
	.loc-ul {list-style-type: none; margin: 0; padding: 0 0 0 25px; display: none; } .loc-li {cursor: pointer; -webkit-user-select: none; /* Safari 3.1+ */ -moz-user-select: none; /* Firefox 2+ */ -ms-user-select: none; /* IE 10+ */ user-select: none; font-size: 23px; padding-right: 10px; display: block; } .loc-text{cursor: pointer; font-family: 'Arial'; font-size: 14px; } .loc::before {content: "\2610"; color: black; display: inline-block; margin-right: 6px; width:10px; } .loc-check::before {content: "\2611"; color: dodgerblue; } .loc-half-check::before {content: "\2612"; color: dodgerblue; } .loc-ul-active {display: block;} .btn-exs{padding: 0.125rem 0.25rem;font-size: smaller;color: black;} .subor::before {content: "\2610"; display: inline-block; font-size: 16px;} .subor-check::before {content: "\2611"; color: dodgerblue; }
</style>
<div class="card">
	<div class="col-md-12" style="padding: 16px;background: #f7f7f7;border-bottom: 1px #000 solid;"><i class="fa fa-info-circle"></i>&nbsp;Detail Monev Bimtek</div>
	<div class="col-md-12 mt-md-6">
		<ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link text-reset active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false"><i class="feather icon-user mr-2"></i>Monitoring Bimtek</a>
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
		<div class="container">
			<div class="col-sm-12">
				<div class="row">					
					<div class="col-md-12">
						<input type="hidden" name="monev_bimtek_id" value="<?php echo $monev_bimtek_id;?>">			
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
									<label class="col-sm-4 col-form-label-sm">Tanggal Pelaksanaan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo date('d-m-Y',strtotime($monev_detail->tanggal_pelaksanaan_bimtek))?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Alamat</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->alamat_bimtek;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah Korcam Yang Hadir</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_korcam_bimtek;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah Pengawas/Pemeriksa</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_pengawas_bimtek;?> orang" >
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label-sm">Jumlah Pengumpul Data</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_pengumpul_data_bimtek;?> orang" >
									</div>
								</div>
							</div>
						</div>
					</div>				

					<div class="col-sm-12">
						<div class="row">
							<!-- left-side -->
							<div class="col-md-6 col-sm-12">
								<div class="form-inline bg-light border border-primary p-2">
									<h5>Penyelenggaraan Bimtek (Kondisi Prasarana & Sarana)</h5>
								</div>
								<div class="">
									<div class="form-row">
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">1. Ruang Kelas / Pertemuan</label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->ruang_kelas_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->ruang_kelas_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->ruang_kelas_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->ruang_kelas_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->ruang_kelas_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>									
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Ruang Kelas / Pertemuan</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_ruang_kelas;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">2. Ruang Makan</label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->ruang_makan_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->ruang_makan_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->ruang_makan_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->ruang_makan_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->ruang_makan_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>									
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Ruang Makan</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_ruang_makan;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">3. Tempat Ibadah</label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->tempat_ibadah_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->tempat_ibadah_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->tempat_ibadah_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->tempat_ibadah_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->tempat_ibadah_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>									
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Tempat Ibadah</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_tempat_ibadah;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">4. Meja Dan Kursi </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->meja_kursi_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->meja_kursi_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->meja_kursi_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->meja_kursi_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->meja_kursi_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>									
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Meja Dan Kursi</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_meja_kursi;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">5. Whiteboard </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->whiteboard_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->whiteboard_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->whiteboard_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->whiteboard_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->whiteboard_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>									
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Meja Dan Kursi</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_whiteboard;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">6. Infocus </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->infocus_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->infocus_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->infocus_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->infocus_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->infocus_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>									
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Infocus</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_infocus;?>" >
												</div>
											</div>
										</div>

										
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">7. Sound System </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->sound_system_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->sound_system_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->sound_system_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->sound_system_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->sound_system_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>									
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Sound System</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_sound_system;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">8. Modul / Materi  </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->modul_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->modul_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->modul_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->modul_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->modul_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>									
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Modul / Materi </label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_materi;?>" >
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> 
							<!-- end-left-side -->

							<!-- right-side -->
							<div class="col-md-6 col-sm-12">
								<div class="form-inline bg-light border border-primary p-2">
									<h5>Nara Sumber / Fasilitator</h5>
								</div>
					
								<div class="">
									<div class="form-row">
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">1. Penguasaan Materi</label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->penguasaan_materi_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->penguasaan_materi_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->penguasaan_materi_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->penguasaan_materi_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->penguasaan_materi_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Penguasaan Materi</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_penguasaan_materi;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">2. Sistematika Penyajian</label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->sistematika_penyajian_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->sistematika_penyajian_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->sistematika_penyajian_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->sistematika_penyajian_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->sistematika_penyajian_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Sistematika Penyajian</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_sistematika_penyajian;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">3. Kemampuan Penyajian </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->kemampuan_penyajian_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->kemampuan_penyajian_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->kemampuan_penyajian_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->kemampuan_penyajian_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->kemampuan_penyajian_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Kemampuan Penyajian</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_kemampuan_penyajian;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">4. Ketepatan Waktu Kehadiran </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->ketepatan_waktu_kehadiran_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->ketepatan_waktu_kehadiran_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->ketepatan_waktu_kehadiran_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->ketepatan_waktu_kehadiran_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->ketepatan_waktu_kehadiran_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Ketepatan Waktu Kehadiran</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_kehadiran;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">5. Penggunaan Metode Dan Sarana Diklat </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->penggunaan_sarana_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->penggunaan_sarana_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->penggunaan_sarana_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->penggunaan_sarana_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->penggunaan_sarana_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Penggunaan Sarana</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_penggunaan_sarana;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">6. Sikap Dan Perilaku  </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->sikap_perilaku_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->sikap_perilaku_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->sikap_perilaku_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->sikap_perilaku_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->sikap_perilaku_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Sikap Dan Perilaku </label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_sikap_perilaku;?>" >
												</div>
											</div>
										</div>
											
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">7. Cara Menjawab Pertanyaan Peserta </label>
											</div>												
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->cara_menjawab_pertanyaan_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->cara_menjawab_pertanyaan_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->cara_menjawab_pertanyaan_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->cara_menjawab_pertanyaan_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->cara_menjawab_pertanyaan_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Cara Menjawab Pertanyaan</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_cara_menjawab;?>" >
												</div>
											</div>
										</div>
								
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">8. Penggunaan Bahasa</label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->penggunaan_bahasa_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->penggunaan_bahasa_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->penggunaan_bahasa_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->penggunaan_bahasa_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->penggunaan_bahasa_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Penggunaan Bahasa </label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_penggunaan_bahasa;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">9. Pemberian Motivasi Kepada Peserta </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->pemberian_motivasi_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->pemberian_motivasi_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->pemberian_motivasi_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->pemberian_motivasi_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->pemberian_motivasi_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Pemberian Motivasi </label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_pemberian_motivasi;?>" >
												</div>
											</div>									
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">10. Pencapaian Tujuan Pembelajaran</label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->pencapaian_tujuan_pembelajaran_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->pencapaian_tujuan_pembelajaran_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->pencapaian_tujuan_pembelajaran_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->pencapaian_tujuan_pembelajaran_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->pencapaian_tujuan_pembelajaran_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Pencapaian Tujuan Pembelajaran</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_pencapaian_pembelajaran;?>" >
												</div>
											</div>
										</div>
							
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">11. Kerapihan Berpakaian </label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->kerapihan_berpakaian_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->kerapihan_berpakaian_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->kerapihan_berpakaian_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->kerapihan_berpakaian_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->kerapihan_berpakaian_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Kerapihan Berpakaian</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_berpakaian;?>" >
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-sm-10 col-form-label-sm f-w-900">12. Kerjasama antar Narsum/Fasilitator</label>
											</div>
											<div class="form-group row m-l-10">
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->kerjasama_bimtek == '1' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Tidak Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->kerjasama_bimtek == '2' ) ? 'checked' : null );?> > <span class="custom-control-label">Kurang Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="3" <?php echo ( ( $monev_detail->kerjasama_bimtek == '3' ) ? 'checked' : null );?> > <span class="custom-control-label">Cukup Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="4" <?php echo ( ( $monev_detail->kerjasama_bimtek == '4' ) ? 'checked' : null );?> > <span class="custom-control-label">Baik</span>
													</label>
												</div>
												<div class="col-sm-9">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" value="5" <?php echo ( ( $monev_detail->kerjasama_bimtek == '5' ) ? 'checked' : null );?> > <span class="custom-control-label">Sangat Baik</span>
													</label>
												</div>												
											</div>
											<div class="form-group row m-l-10">
												<label class="col-sm-9 col-form-label-sm">Keterangan Kerjasama antar Narsum/Fasilitator</label>
												<div class="col-sm-8">
													<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->keterangan_kerjasama;?>" >
												</div>
											</div>
										</div> 
										<!-- end-col-md-12 -->
									</div> 
									<!-- end-form-row -->
								</div> 
								<!-- end-class -->
							</div>
							<!-- end-right-side -->
						</div>
						<!-- end-row -->
					</div>		
					<!-- end-col-sm-12 -->
				</div>		
			</div>
		</div>
	</div>
	
	<div class="tab-pane fade show table-responsive" id="group" role="tabpanel" aria-labelledby="group-tab">
		<div class="row">
			<div class="col-sm-12">
				<img src="">
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
						$tanggal = date("d-m-Y H:i:s",strtotime($v->created_on));
						echo '
						<tr>
							<td>' . $v->row_status . '</td>
							<td><img src="' . str_replace( "./", "http://66.96.235.136:8080/apiverval/", $v->internal_filename) . '" width="100px"></td>
							<td>' . substr($v->file_name, 0, 15) . '...</td>
							<td>' . $v->stereotype . '</td>
							<td>' . $v->description . '</td>
							<td>' . $v->file_size . ' kB</td>
							<td>' . $v->latitude . '</td>
							<td>' . $v->longitude . '</td>
							<td>' . $tanggal . '</td>
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
