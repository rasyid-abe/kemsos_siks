<div class="row">
	<!-- [ tabs ] start -->
	<div class="col-sm-12">
		<div class="card">
		<input type="hidden" name="proses_id" value="<?php echo $row->proses_id;?>">
			<div class="card-body">
				<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="tab1p" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Data Prelist</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab2p" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Pengenalan Tempat</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab3p" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Nomor KK</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab4p" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Petugas dan Responden</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab5p" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="false">Perumahan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab6p" data-toggle="tab" href="#tab6" role="tab" aria-controls="tab6" aria-selected="false">Sosial Ekonomi ART</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab7p" data-toggle="tab" href="#tab7" role="ta7" aria-controls="tab7" aria-selected="false">Anak Tanggungan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab8p" data-toggle="tab" href="#tab8" role="tab" aria-controls="tab8" aria-selected="false">Aset dan Program</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab9p" data-toggle="tab" href="#tab9" role="tab" aria-controls="tab9" aria-selected="false">ART Usaha</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab10p" data-toggle="tab" href="#tab10" role="tab" aria-controls="tab10" aria-selected="false">Foto</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab11p" data-toggle="tab" href="#tab11" role="tab" aria-controls="tab11" aria-selected="false">Audit</a>
					</li>
				</ul>

				<div class="tab-content" id="myTabContent">
					<!-- tab-data-prelist -->
					<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1p">
						<form id="form_prelist" >
						<input type="hidden" class="form-control" id="txtproses_id" name="proses_id" value="<?php echo $row->proses_id;?>">
						<div class="row form-group col-12 p-t-10">
							<div class="col-md-3 col-sm-12">
								<div class="form-inline bg-light border border-primary">
									<div class="form-group">
										<label class="col-12 font-weight-bold" for="txtKDPROP">1. Kode Provinsi :</label>
									</div>
									<div class="form-group col-3">
										<input type="text" class="form-control-plaintext form-control-sm font-weight-bold" id="txtKDPROP" name="KDPROP" value="<?php echo $row->kode_propinsi;?>">
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-inline bg-light border border-primary">
									<div class="form-group">
										<label class="col-12 font-weight-bold" for="txtKDKAB">2. Kode Kabupaten :</label>
									</div>
									<div class="form-group col-3">
										<input type="text" class="form-control-plaintext form-control-sm font-weight-bold" id="txtKDKAB" name="KDKAB" value="<?php echo $row->kode_kabupaten;?>">
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-inline bg-light border border-primary">
									<div class="form-group">
										<label class="col-12 font-weight-bold" for="txtKDKEC">3. Kode Kecamatan :</label>
									</div>
									<div class="form-group col-3">
										<input type="text" class="form-control-plaintext form-control-sm font-weight-bold" id="txtKDKEC" name="KDKEC" value="<?php echo $row->kode_kecamatan;?>">
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-inline bg-light border border-primary">
									<div class="form-group">
										<label class="col-12 font-weight-bold" for="txtKDDESA">4. Kode Kelurahan :</label>
									</div>
									<div class="form-group col-3">
										<input type="text" class="form-control-plaintext form-control-sm font-weight-bold" id="txtKDDESA" name="KDDESA" value="<?php echo $row->kode_desa;?>">
									</div>
								</div>
							</div>
						</div>


						<div class="row m-t-30">
							<!-- left side -->
							<div class="col-md-6 col-sm-12">
								<div class="col-12">
									<label class="col-12" for="txtnama_krt"><b>5. Nama Kepala Rumah Tangga</b></label>
									<div class="col-12">
										<input type="text" class="form-control " id="txtnama_krt" name="nama_krt" value="<?php echo $row->nama_krt;?>">
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12 font-weight-bold" for="nothing">6. Jenis Kelamin</label>
									<div class="row col-12">
										<?php
											$arr_jk = [1 => 'Laki-Laki', 2 => 'Perempuan'];
											foreach ( $arr_jk as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="radio-inline custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="jenis_kelamin_krt" value="' . $key . '" ' . ( ( $key == $row->jenis_kelamin_krt ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12" for="txtnama_pasangan_krt"><b>7. Nama Pasangan Kepala Rumah Tangga</b></label>
									<div class="col-12">
										<input type="text" class="form-control" id="txtnama_pasangan_krt" name="nama_pasangan_krt" value="<?php echo $row->nama_pasangan_krt;?>">
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12" for="txaalamat"><b>8. Alamat</b></label>
									<div class="row col-12">
										<div class="col-12">
											<textarea class="form-control" id="txaalamat" ><?php echo $row->alamat;?></textarea>
										</div>
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12" for="txtnomor_nik"><b>9. Nomor NIK</b></label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtnomor_nik" name="nomor_nik" value="<?php echo $row->nomor_nik;?>">
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>10. Status Rumah Tangga</b></label>
									<div class="row col-12">
										<?php
											$arr_jk = [1 => 'Ditemukan', 2 => 'Tidak Ditemukan', 3 => 'Ganda', 4 => 'Usulan Baru'];
											foreach ( $arr_jk as $key => $value ) {
												echo '
												<div class="col-12">
													<label class="radio-inline custom-control custom-radio">
														<input type="radio" class="custom-control-input"  name="status_rumahtangga" value="' . $key . '" ' . ( ( $key == $row->status_rumahtangga ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
													</label>
												</div>';
											}
										?>
									</div>
								</div>
							</div>

							<!-- right side -->
							<div class="col-md-6 col-sm-12">
								<div class="col-12">
									<label class="col-12 f-w-900" for="nothing"><b>11. Jika Tidak Ditemukan, Apa Alasannya ?</b></label>
									<div class="row col-12">
										<?php
											$arr_jk = [1 => 'Pindah', 2 => 'Meninggal', 3 => 'Tidak Tahu', 4 => 'Alamat tidak ada di Desa/Kelurahan Setempat'];
											foreach ( $arr_jk as $key => $value ) {
												echo '
												<div class="col-12">
													<label class="custom-control custom-radio">
														<input type="radio" class="custom-control-input"  name="alasan_tidak_ditemukan" value="' . $key . '" ' . ( ( $key == $row->alasan_tidak_ditemukan ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
													</label>
												</div>';
											}
										?>
									</div>
								</div>
								<h5 class="f-w-900 p-t-10">Jika Ditemukan atau Usulan Baru</h5>
								<div class="col-12">
									<label class="col-12 f-w-900" for="nothing"><b>12. Apakah Rumah Tangga Mampu ?</b></label>
									<div class="row col-12">
										<?php
											$arr_jk = [1 => 'Ya', 2 => 'Tidak'];
											foreach ( $arr_jk as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="radio-inline custom-control custom-radio">
												<input type="radio" class="custom-control-input"  name="apakah_mampu" value="' . $key . '" ' . ( ( $key == $row->apakah_mampu ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>13. Apakah Ada Anggota Rumah Tangga Yang Bekerja</b></label>
									<div class="row col-12">
										<?php
											$arr_jk = [1 => 'Ya', 2 => 'TIdak'];
											foreach ( $arr_jk as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="radio-inline custom-control custom-radio">
												<input type="radio" class="custom-control-input"  name="ada_art_bekerja" value="' . $key . '" ' . ( ( $key == $row->ada_art_bekerja ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>14. Jika Ada, Sebutkan Status Kedudukan Dalam Pekerjaan ?</b></label>
									<div class="row col-12">
										<div class="col-12">
											<select id="status_pekerjaan" name="status_pekerjaan" class="form-control clearInput js-example-basic-single col-12">
												<option value="">Status Kedudukan Dalam Pekerjaan</option>
												<?php
													$arr_jk = [
														1 => 'Berusaha Sendiri',
														2 => 'Berusaha Dibantu Buruh Tidak Tetap/Tidak Dibayar',
														3 => 'Berusaha Dibantu Buruh Tetap',
														4 => 'Buruh/Karyawan/Pegawai Stasta',
														5 => 'PNS/TNI/POLRI/BUMN/BUMD/Anggota Legislatif',
														6 => 'Pekerja Bebas Pertanian',
														7 => 'Pekerja Bebas Non-Pertanian',
														8 => 'Pekerja Keluarga/Tidak Dibayar',
													];
													foreach ( $arr_jk as $key => $value ) {
														echo '
												<option value="' . $key . '" ' . ( ( $key == $row->status_pekerjaan ) ? 'selected' : null ) . '> ' . $key . ' = ' . $value . '</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>15. Apakah Ada Anggota Rumah Tangga Penyandang Disabilitas</b></label>
									<div class="row col-12">
										<div class="col-12">
											<label class="radio-inline custom-control custom-radio">
												<input type="radio" class="custom-control-input"  name="ada_art_cacat" id="rbtada_art_cacat1" value="1" onclick="javascript:rbtada_art_cacat_onclick('1 = Ya');"> <span class="custom-control-label">1 = Ya</span>
											</label>
										</div>
										<div class="col-12">
											<label class="radio-inline custom-control custom-radio">
												<input type="radio" class="custom-control-input"  name="ada_art_cacat" id="rbtada_art_cacat2" value="2" checked="checked" onclick="javascript:rbtada_art_cacat_onclick(' 2 = Tidak');"><span class="custom-control-label">2 = Tidak</span>
											</label>
											<input type="hidden" name="ada_art_cacat_label" id="hidada_art_cacat_label" value="2 = Tidak">
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
					<!-- end tab-data-prelist -->

					<!-- tab-pengenalan-tempat -->
					<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2p">
						<form id="form_tempat" >
						<div class="row form-group col-12 p-t-10">
							<div class="col-md-3 col-sm-12">
								<div class="form-inline bg-light border border-success">
									<div class="form-group">
										<label class="col-12 font-weight-bold" for="txtKDPROP">1. Kode Provinsi :</label>
									</div>
									<div class="form-group col-3">
										<input type="text" class="form-control-plaintext form-control-sm font-weight-bold" id="txtKDPROP" name="KDPROP" value="<?php echo $row->kode_propinsi;?>">
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-inline bg-light border border-success">
									<div class="form-group">
										<label class="col-12 font-weight-bold" for="txtKDKAB">2. Kode Kabupaten :</label>
									</div>
									<div class="form-group col-3">
										<input type="text" class="form-control-plaintext form-control-sm font-weight-bold" id="txtKDKAB" name="KDKAB" value="<?php echo $row->kode_kabupaten;?>">
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-inline bg-light border border-success">
									<div class="form-group">
										<label class="col-12 font-weight-bold" for="txtKDKEC">3. Kode Kecamatan :</label>
									</div>
									<div class="form-group col-3">
										<input type="text" class="form-control-plaintext form-control-sm font-weight-bold" id="txtKDKEC" name="KDKEC" value="<?php echo $row->kode_kecamatan;?>">
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-inline bg-light border border-success">
									<div class="form-group">
										<label class="col-12 font-weight-bold" for="txtKDDESA">4. Kode Kelurahan :</label>
									</div>
									<div class="form-group col-3">
										<input type="text" class="form-control-plaintext form-control-sm font-weight-bold" id="txtKDDESA" name="KDDESA" value="<?php echo $row->kode_desa;?>">
									</div>
								</div>
							</div>
						</div>

						<div class="row m-t-30">
							<div class="col-md-6 col-sm-12">
								<div class="col-12">
									<label class="col-12" for="txtNama_SLS"><b>5. Nama SLS</b></label>
									<div class="col-12">
										<input type="text" class="form-control" name="Nama_SLS" value="<?php echo $row->nama_sls;?>">
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12" for="txaAlamat"><b>6. Alamat</b></label>
									<div class="col-12">
										<textarea class="form-control" name="Alamat"><?php echo $row->alamat;?></textarea>
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12" for="txtnomor_urut_rt"><b>7. Nomor Urut Rumah Tangga (Dari Prelist)</b></label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtnomor_urut_rt" name="nomor_urut_rt" value="<?php echo $row->id_prelist;?>" >
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="col-12">
									<label class="col-12" for="txtNama_KRT"><b>8. Nama Kepala Rumah Tangga</b></label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtNama_KRT" value="<?php echo $row->nama_krt;?>">
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12" for="txtJumlah_ART"><b>9. Jumlah Anggota Rumah Tangga</b></label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtJumlah_ART" name="Jumlah_ART" value="<?php echo $row->jumlah_art;?>" >
									</div>
								</div>
								<div class="col-12 p-t-30">
									<label class="col-12" for="txtJumlah_Keluarga"><b>10. Jumlah Keluarga</b></label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtJumlah_Keluarga" name="Jumlah_Keluarga" value="<?php echo $row->jumlah_keluarga;?>">
									</div>
								</div>
							</div>
						</div>
						</form>
					</div>
					<!-- end tab-pengenalan-tempat -->

					<!-- tab-nomor-kk -->
					<div class="tab-pane fade table-responsive m-t-10" id="tab3" role="tabpanel" aria-labelledby="tab3p">
						<table class="table table-striped table-xs table-bordered">
							<thead>
								<tr>
									<th>Status</th>
									<th>Nomor Urut</th>
									<th>Nomor KK</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach ( $kk as $k => $v ) {
									if ($v->row_status=='ACTIVE')
										$status = '<img src="' . base_url('assets/style/icon-status/bullet-gray.png') . '" title="Data Aktif" alt="Data Aktif"/>' ;
									else if ($v->row_status == 'NEW')
										$status = '<img src="' . base_url('assets/style/icon-status/bullet-green.png') . '" title="Data Baru" alt="Data Baru" />';
									else if ($v->row_status == 'DELETED')
										$status = '<img src="' . base_url('assets/style/icon-status/bullet-red.png') . '" title="Data Di Hapus" alt="Data Di Hapus" />';
									$detail = '<button act="' . base_url( 'verivali/detail_data' ) . '/get_form_detail_kk/' . enc( [ 'id' => $v->id ] ) . '" class="btn btn-warning btn-xs btn-edit-kk" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';

									echo '
									<tr>
										<td>' . $status . '</td>
										<td>' . $v->nuk . '</td>
										<td>' . $v->nokk .'</td>
										<td>' . $detail . '</td>
									</tr>';
								}
							?>
							</tbody>
						</table>
					</div>
					<!-- end tab-nomor-kk -->

					<!-- tab-petugas-responden -->
					<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4p">
						<form id="form_responden" >

						<div class="row">
							<!-- left-side -->
							<div class="col-md-6 col-sm-12">
								<div class="col-12 m-t-10">
									<label class="col-12" for="daptanggal_verivali" style="display:block;"><b>1. Tanggal Verivali</b></label>
									<div class="col-12">
										<input type="date" class="form-control" id="daptanggal_verivali" name="tanggal_verivali" value="<?php echo $row->tanggal_verivali;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtpetugas_verivali"><b>2. Nama Petugas Verivali</b></label>
									<div class="col-12">
										<input type="text" class="form-control" id="txtpetugas_verivali" name="petugas_verivali" value="<?php echo $row->petugas_verivali;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="daptanggal_pemeriksaan" style="display:block;"><b>3. Tanggal Pemeriksaan</b></label>
									<div class="col-12">
										<input type="date" class="form-control" id="daptanggal_pemeriksaan" name="tanggal_pemerikasaan" value="<?php echo $row->tanggal_pemerikasaan;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtnama_pemeriksa"><b>4. Nama Pemeriksa</b></label>
									<div class="col-12">
										<input type="text" class="form-control" id="txtnama_pemeriksa" name="nama_pemeriksa" value="<?php echo $row->nama_pemeriksa;?>">
									</div>
								</div>
							</div>
							<!-- end left-side -->

							<!-- right-side -->
							<div class="col-md-6 col-sm-12">
								<div class="col-12 m-t-10">
									<label class="col-12 f-w-900" for="nothing"><b>5. Hasil Verivali</b></label>
									<?php
										$arr = [
											1 => 'Selesai Dicacah',
											2 => 'Rumah Tangga Tidak Ditemukan',
											3 => 'Rumah Tangga Pindah',
											4 => 'Bagian Dari Rumah Tangga',
											5 => 'Responden Menolak',
											6 => 'Data Ganda',
										];
										foreach ( $arr as $key => $value ) {
											echo '
										<div class="col-12">
											<label class="radio-inline custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="hasil_verivali" value="' . $key . '" ' . ( ( $key == $row->hasil_verivali ) ? 'checked="checked"' : null ) . '>  <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>
											';
										}
									?>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="txtdata_idbdt_double_dengan">Bila data ganda atau bagian dari rumah tangga di dokumen, dengan ID Prelist/No. urut ruta mana ?</label>
									<div class="col-12">
										<input type="text" class="form-control" id="txtdata_idbdt_double_dengan" name="data_idbdt_double_dengan" value="<?php echo $row->data_idbdt_double_dengan;?>">
									</div>
								</div>
							</div>
							<!-- end right-side -->
						</div>
						</form>
					</div>
					<!-- end tab-petugas-responden -->

					<!-- tab-perumahan -->
					<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5p">
						<form id="form_rumah" >

						<div class="row">
							<!-- left-side -->
							<div class="col-md-6 col-sm-12 m-t-10">
								<div class="col-12">
									<label class="col-12 f-w-900" for="nothing">1a. Status penggunaan bangunan tempat tinggal yang diamati</label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Milik Sendiri',
												2 => 'Kontrak/Sewa',
												3 => 'Bebas Sewa',
												4 => 'Dinas',
												5 => 'Lainnnya'
											];
											foreach ( $arr as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_bangunan" value="' . $key . '" ' . ( ( $key == $row->status_bangunan ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">1b. Status lahan tempat tinggal yang ditempati</label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Milik Sendiri',
												2 => 'Milik Orang Lain',
												3 => 'Tanah Negara',
												4 => 'Lainnnya'
											];
											foreach ( $arr as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_lahan" value="' . $key . '" ' . ( ( $key == $row->status_lahan ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtluas_lantai"><b>2. Luas Lantai (M<sup>2</sup>)</b></label>
									<div class="row col-12">
										<input type="text" class="form-control" name="luas_lantai" value="<?php echo $row->luas_lantai;?>" >
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>3. Jenis Lantai Terluas</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Marmer/Granit',
												2 => 'Keramik',
												3 => 'Parket/Vinil/Permadani',
												4 => 'Ubin/Tegal/Teraso',
												5 => 'Kayu/Papan Berkualitas Tinggi',
												6 => 'Sementara/Bata Merah',
												7 => 'Bambu',
												8 => 'Kayu/Papan Berkualitas Rendah',
												9 => 'Tanah',
												10 => 'Lainnya'
											];
											foreach ( $arr as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="lantai" value="' . $key . '" ' . ( ( $key == $row->lantai ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>4a. Jenis Dinding Terluas</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Tembok',
												2 => 'Plesteran Anyaman Bambu/Kawat',
												3 => 'Kayu',
												4 => 'Anyaman Bambu',
												5 => 'Batang Kayu',
												6 => 'Bambu',
												7 => 'Lainnya',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="dinding" value="' . $key . '" ' . ( ( $key == $row->dinding ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
											?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>4b. Jika R.4a Berkode 1, 2, dan 3, Kondisi Dinding</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Bagus/Kualitas Tinggi',
												2 => 'Jelek/Kualitas Rendah',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="kondisi_dinding" value="' . $key . '" ' . ( ( $key == $row->kondisi_dinding ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>5a. Jenis Atap Terluas</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Beton/Genteng Beton',
												2 => 'Genteng Keramik',
												3 => 'Genteng Metal',
												4 => 'Genteng Tanah Liat',
												5 => 'Asbes',
												6 => 'Seng',
												7 => 'Sirap',
												8 => 'Bambu',
												9 => 'Jerami/Ijuk/Daun-Daunan/Rumbia',
												10 => 'Lainnya',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="atap" value="' . $key . '" ' . ( ( $key == $row->atap ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>5b. Jika R.5a berkode 1,2,3,4,5,6 atau 7 Kondisi Atap</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Bagus/Kualitas Tinggi',
												2 => 'Jelek/Kualitas Rendah',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="kondisi_atap" value="' . $key . '" ' . ( ( $key == $row->kondisi_atap ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtjumlah_kamar"><b>6. Jumlah Kamar Tidur</b></label>
									<div class="col-12">
										<input type="text" class="form-control" name="jumlah_kamar" value="<?php echo $row->jumlah_kamar;?>">
									</div>
								</div>								
							</div>
							<!-- end left-side -->

							<!-- right-side -->
							<div class="col-md-6 col-sm-12 m-t-10">								
								<div class="col-12">
									<label class="col-12 f-w-900" for="nothing"><b>7a. Sumber Air Minum</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Air Kemasan Bermerk',
												2 => 'Air Isi Ulang',
												3 => 'Leding Meteran',
												4 => 'Leding Eceran',
												5 => 'Sumur Berpompa',
												6 => 'Sumur Terlindung',
												7 => 'Sumur Tak Terlindung',
												8 => 'Mata Air Terlindung',
												9 => 'Mata Air Tak Terlindung',
												10 => 'Air Sungai/Waduk/Danau',
												11 => 'Air Hujan',
												12 => 'Lainnya',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="sumber_airminum" value="' . $key . '" ' . ( ( $key == $row->sumber_airminum ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtnomor_meter_air"><b>7b. Jika R.7a berkode 3 (Leding Meteran), No ID Pelanggan</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'PAM',
												2 => 'PDAM',
												3 => 'BDAM',
												4 => 'Lainnya',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="jenis_pelanggan_airminum" value="' . $key . '" ' . ( ( $key == $row->sumber_airminum ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtjenis_pelanggan_airminum_lainnya"><b>Lainnya</b></label>
									<div class="col-12">
										<input type="text" class="form-control" name="jenis_pelanggan_airminum_lainnya" value="<?php echo $row->jenis_pelanggan_airminum_lainnya;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>8. Cara Memperoleh Air Minum</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Membeli Eceran',
												2 => 'Langganan',
												3 => 'Tidak Membeli',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="cara_peroleh_airminum" value="' . $key . '" ' . ( ( $key == $row->cara_peroleh_airminum ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>9a. Sumber Penerangan Utama</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Listrik PLN',
												2 => 'Listrik Non PLN',
												3 => 'Bukan Listrik',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="sumber_penerangan" value="' . $key . '" ' . ( ( $key == $row->sumber_penerangan ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>9b. Jika R.9a berkode 1, Daya Terpasang</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => '450 Watt',
												2 => '900 Watt',
												3 => '1.300 Watt',
												4 => '2.200 Watt',
												5 => 'Lebih Dari 2.200 Watt',
												6 => 'Tanpa Meteran',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="daya" value="' . $key . '" ' . ( ( $key == $row->daya ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtnomor_pln"><b>9c. Jika R.9a  berkode 1, No ID Pelanggan</b></label>
									<div class="col-12">
										<input type="text" class="form-control" name="nomor_pln" value="<?php echo $row->nomor_pln;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>10a. Bahan Bakar/Energi Utama Untuk Memasak</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Listrik',
												2 => 'Gas &gt; 3 Kg',
												3 => 'Gas 3 Kg',
												4 => 'Gas Kota/Biogas',
												5 => 'Minyak Tanah',
												6 => 'Briket',
												7 => 'Arang',
												8 => 'Kayu Bakar',
												9 => 'Tidak Memasak Di Rumah',

											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="bb_masak" value="' . $key . '" ' . ( ( $key == $row->bb_masak ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtnomor_gas"><b>10b. Jika R.10a berkode 4 (Gas Kota/Biogas), No ID Pelanggan</b></label>
									<div class="row col-12">
										<?php
										
											$arr = [
												1 => 'PGN',
												2 => 'Gas Kota',
												3 => 'Lainnya',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="jenis_pelanggan_gas" value="' . $key . '" ' . ( ( $key == $row->jenis_pelanggan_gas ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtnomor_gas"><b>No ID Pelanggan</b></label>
									<div class="col-12">
										<input type="text" class="form-control" id="txtnomor_gas" name="nomor_gas" value="<?php echo $row->nomor_gas;?>">
									</div>									
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12" for="txtjenis_pelanggan_gas_lainnya"><b>Lainnya</b></label>
									<div class="col-12">
										<input type="text" class="form-control" id="txtjenis_pelanggan_gas_lainnya" name="jenis_pelanggan_gas_lainnya" value="<?php echo $row->jenis_pelanggan_gas_lainnya;?>">
									</div>									
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>11a. Penggunaan Fasilitas Tempat Buang Air Besar</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Sendiri',
												2 => 'Bersama',
												3 => 'Umum',
												4 => 'Tidak Ada ( R.12)',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="fasbab" value="' . $key . '" ' . ( ( $key == $row->fasbab ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>11b. Jenis Kloset</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Leher Angsa',
												2 => 'Plengsengan',
												3 => 'Cemplung/Cubluk',
												4 => 'Tidak Pakai',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="kloset" value="' . $key . '" ' . ( ( $key == $row->kloset ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing"><b>12. Tempat Pembuangan Akhir Tinja</b></label>
									<div class="row col-12">
										<?php
											$arr = [
												1 => 'Tangki',
												2 => 'SPAL',
												3 => 'Lubang Tanah',
												4 => 'Kolam/Sawah/Sungai/Danau/Laut',
												5 => 'Pantai/Tanah Lapang/Kebun',
												6 => 'Lainnya',
											];
											foreach ( $arr as $key => $value ) {
													echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="buang_tinja" value="' . $key . '" ' . ( ( $key == $row->buang_tinja ) ? 'checked="checked"': null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
							</div>
							<!-- end right-side -->
						</div>
						</form>
					</div>
					<!-- end tab-perumahan -->

					<!-- tab-sosial-ekonomi-art -->
					<div class="tab-pane fade table-responsive f-12" id="tab6" role="tabpanel" aria-labelledby="tab6p">
						<table class="table table-striped table-xs table-bordered m-t-10">
							<thead>
								<tr>
									<th>Status</th>
									<th>Nama</th>
									<th>NIK</th>
									<th>NO KK</th>
									<th>Hub dengan KRT</th>
									<th>No Urut</th>
									<th>Hub dengan KK</th>
									<th>Status Keberadaan KRT</th>
									<th>Pemadanan</th>
									<th>Dokumen</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach ( $art as $k => $val) {
								if ($val->row_status=='ACTIVE')
									$status = '<img src="' . base_url('assets/style/icon-status/bullet-gray.png') . '" title="Data Aktif" alt="Data Aktif"/>' ;
								else if ($val->row_status == 'NEW')
									$status = '<img src="' . base_url('assets/style/icon-status/bullet-green.png') . '" title="Data Baru" alt="Data Baru" />';
								else if ($val->row_status == 'DELETED')
									$status = '<img src="' . base_url('assets/style/icon-status/bullet-red.png') . '" title="Data Di Hapus" alt="Data Di Hapus" />';

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

								if($val->hubungan_krt=='1')
									$hubungan_krt='Kepala rumah tangga';
								elseif($val->hubungan_krt=='2')
									$hubungan_krt='Istri/Suami';
								elseif($val->hubungan_krt=='3')
									$hubungan_krt='Anak';
								elseif($val->hubungan_krt=='4')
									$hubungan_krt='Menantu';
								elseif($val->hubungan_krt=='5')
									$hubungan_krt='Cucu';
								elseif($val->hubungan_krt=='6')
									$hubungan_krt='Orang Tua/Mertua';
								elseif($val->hubungan_krt=='7')
									$hubungan_krt='Pembantu ruta';
								elseif($val->hubungan_krt=='8')
									$hubungan_krt='Lainnya';
								else
									$hubungan_krt='';

								if($val->status_keberadaan_art=='1')
									$status_keberadaan_art='Tinggal Di Ruta';
								elseif($val->status_keberadaan_art=='2')
									$status_keberadaan_art='Meninggal';
								elseif($val->status_keberadaan_art=='3')
									$status_keberadaan_art='Tidak Tinggal di Ruta/Pindah';
								elseif($val->status_keberadaan_art=='4')
									$status_keberadaan_art='Anggota Rumah Tangga Baru';
								elseif($val->status_keberadaan_art=='5')
									$status_keberadaan_art='Kesalahan Prelist';
								elseif($val->status_keberadaan_art=='6')
									$status_keberadaan_art='Tidak Ditemukan';
								else
									$status_keberadaan_art='';

								if($val->flag_pemadanan == 1)
									$flag_pemadanan='<span class="badge badge-success">PADAN</span>';
								elseif($val->flag_pemadanan == 2)
									$flag_pemadanan='<span class="badge badge-danger">TIDAK PADAN</span>';
								else
									$flag_pemadanan='<span class="badge badge-secondary">Belum Dipadankan</span>';

								if($val->flag_dokumen == 1)
									$flag_dokumen='<span class="badge badge-success">SESUAI DOKUMEN</span>';
								elseif($val->flag_dokumen == 2)
									$flag_dokumen='<span class="badge badge-danger">TIDAK SESUAI DOKUMEN</span>';
								else
									$flag_dokumen='<span class="badge badge-secondary">Belum Diisi</span>';

								$detail = '<button act="' . base_url( 'verivali/detail_data' ) . '/get_form_detail_art/' . enc( [ 'id' => $val->id ] ) . '" class="btn btn-warning btn-xs btn-edit-art" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';

									echo '
								<tr>
									<td>' . $status . '</td>
									<td>' . $val->nama . '</td>
									<td>' . $val->nik . '</td>
									<td>' . $val->nokk . '</td>
									<td>' . $hubungan_krt . '</td>
									<td>' . $val->index . '</td>
									<td>' . $hubungan_keluarga . '</td>
									<td>' . $status_keberadaan_art . '</td>
									<td>' . $flag_pemadanan . '</td>
									<td>' . $flag_dokumen . '</td>
									<td>' . $detail . '</td>
								</tr>
									';
								}
							?>
							</tbody>
						</table>
					</div>
					<!-- end tab-sosial-ekonomi-art -->

					<!-- tab-anak-tanggungan -->
					<div class="tab-pane fade table-responsive f-12" id="tab7" role="tabpanel" aria-labelledby="tab7p">
						<table class="table table-striped table-xs table-bordered m-t-10">
							<thead>
								<tr>
									<th>Nama Siswa</th>
									<th>NISN</th>
									<th>Alamat Sekolah</th>
									<th>NIK</th>
									<th>Nama Sekolah</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach ( $tanggungan as $k => $val) {
									$detail = '<button act="' . base_url( 'verivali/detail_data' ) . '/get_form_detail_anak/' . enc( [ 'id' => $val->id ] ) . '" class="btn btn-warning btn-xs btn-edit-anak" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';
									echo '
								<tr>
									<td>' . $val->nama_art_sekolah . '</td>
									<td>' . $val->art_nisn . '</td>
									<td>' . $val->art_sekolah_alamat . '</td>
									<td>' . $val->art_sekolah_nik . '</td>
									<td>' . $val->art_nama_sekolah . '</td>
									<td>' . $detail . '</td>
								</tr>
									';
								}
							?>
							</tbody>
						</table>
					</div>
					<!-- end tab-anak-tanggungan -->

					<!-- tab-aset-program -->
					<div class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="tab8p">
						<form id="form_aset" >

						<div class="row">
							<!-- left-side -->
							<?php
								$arr_yes_no = [ 1 => 'Ya', 2 => 'Tidak'];
								$arr_yes_no2 = [ 3 => 'Ya', 4 => 'Tidak'];
							?>
							<div class="col-md-6 col-sm-12 m-t-10">
								<div class="bg-light border border-primary p-2 col-8">
									<h6>1. Rumah Tangga Memiliki Aset Bergerak Sebagai Berikut</h6>
								</div>
								<div class="col-12 m-t-10">
									<label class="col-12 f-w-900" for="nothing">a. Tabung Gas 5,5 Kg atau Lebih</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_tabung_gas" value="' . $key . '" ' . ( ( $key == $row->ada_tabung_gas ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">b. Lemari Es/Kulkas</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_lemari_es" value="' . $key . '" ' . ( ( $key == $row->ada_lemari_es ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">c. AC</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_ac" value="' . $key . '" ' . ( ( $key == $row->ada_ac ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">d. Pemanas Air (Water Heater)</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_pemanas" value="' . $key . '" ' . ( ( $key == $row->ada_pemanas ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">e. Telepon Rumah (PSTN)</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_telepon" value="' . $key . '" ' . ( ( $key == $row->ada_telepon ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">f. Televisi</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_tv" value="' . $key . '" ' . ( ( $key == $row->ada_tv ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">g. Emas/Perhiasan &amp; Tabungan (Senilai 10 Gram Emas)</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_emas" value="' . $key . '" ' . ( ( $key == $row->ada_emas ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">h. Komputer/Laptop</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_laptop" value="' . $key . '" ' . ( ( $key == $row->ada_laptop ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">i. Sepeda</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_sepeda" value="' . $key . '" ' . ( ( $key == $row->ada_sepeda ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">j. Sepeda Motor</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_motor" value="' . $key . '" ' . ( ( $key == $row->ada_motor ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">k. Mobil</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_mobil" value="' . $key . '" ' . ( ( $key == $row->ada_mobil ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">l. Perahu</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_perahu" value="' . $key . '" ' . ( ( $key == $row->ada_perahu ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">m. Motor Tempel</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_motor_tempel" value="' . $key . '" ' . ( ( $key == $row->ada_motor_tempel ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">n. Perahu Motor</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_perahu_motor" value="' . $key . '" ' . ( ( $key == $row->ada_perahu_motor ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">o. Kapal</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="ada_kapal" value="' . $key . '" ' . ( ( $key == $row->ada_kapal ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
							</div>
							<!-- end left-side -->

							<!-- right-side -->
							<div class="col-md-6 col-sm-12 m-t-10">
								<div class="bg-light border border-primary p-2 col-10">
									<h6>2. Rumah Tangga Memiliki Aset Tidak Bergerak Sebagai Berikut</h6>
								</div>
								<div class="col-12 m-t-10">
									<label class="col-12 f-w-900" for="nothing">a. Lahan</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="aset_tak_bergerak" value="' . $key . '" ' . ( ( $key == $row->aset_tak_bergerak ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
									<div class="row col-12">
										<label class="col-12 f-w-900" for="txtluas_atb">Luas Lahan</label>
										<div class="col-12">
											<input type="text" class="form-control" id="txtluas_atb" name="luas_atb" value="<?php echo $row->luas_atb;?>" >
										</div>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">b. Rumah Ditempat Lain</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="rumah_lain" value="' . $key . '" ' . ( ( $key == $row->rumah_lain ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>

								<div class="bg-light border border-primary p-2 col-10 m-t-30">
									<h6>3. Jumlah Ternak Yang Dimiliki (Ekor) :</h6>
								</div>
								<div class="col-12 m-t-10">
									<label class="col-12 f-w-900" for="txtjumlah_sapi">a. Sapi</label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtjumlah_sapi" name="jumlah_sapi" value="<?php echo $row->jumlah_sapi;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="txtjumlah_kerbau">b. Kerbau</label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtjumlah_kerbau" name="jumlah_kerbau" value="<?php echo $row->jumlah_kerbau;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="txtjumlah_kuda">d. Kuda</label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtjumlah_kuda" name="jumlah_kuda" value="<?php echo $row->jumlah_kuda;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="txtjumlah_babi">d. Babi</label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtjumlah_babi" name="jumlah_babi" value="<?php echo $row->jumlah_babi;?>">
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="txtjumlah_kambing">e. Kambing/Domba</label>
									<div class="col-12">
										<input type="text" class="form-control clearInput " id="txtjumlah_kambing" name="jumlah_kambing" value="<?php echo $row->jumlah_kambing;?>">
									</div>
								</div>

								<div class="bg-light border border-primary p-2 col-10 m-t-30">
									<h6>4. Apakah ada ART yang memiliki usaha sendiri/bersama</h6>
								</div>
								<div class="col-12 m-t-20">
									<?php
										foreach ( $arr_yes_no as $key => $value ) {
											echo '
									<div class="col-12">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" name="status_art_usaha" value="' . $key . '" ' . ( ( $key == $row->status_art_usaha ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
										</label>
									</div>';
										}
									?>
								</div>

								<div class="bg-light border border-primary p-2 col-10 m-t-30">
									<h6>5. Rumah Tangga Menjadi Peserta Program/Memiliki Kartu Program</h6>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">a. Kartu Keluarga Sejahtera (KKS)/Kartu Perlindungan Sosial (KPS)</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_kks" value="' . $key . '" ' . ( ( $key == $row->status_kks ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">b. Kartu Indonesia Pintar (KIP)/Bantuan Siswa Miskin(BSW)</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_kip" value="' . $key . '" ' . ( ( $key == $row->status_kip ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">c. Kartu Indonesia Sehat(KIS)/BPJS Kesehatan/Jamkesmas</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_kis" value="' . $key . '" ' . ( ( $key == $row->status_kis ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">d. BPJS Kesehatan Peserta Mandiri</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_bpjs_mandiri" value="' . $key . '" ' . ( ( $key == $row->status_bpjs_mandiri ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">e. Jaminan Sosial Tenaga Kerja(JAMSOSTEK)/BPJS Ketenagakerjaan</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_jamsostek" value="' . $key . '" ' . ( ( $key == $row->status_jamsostek ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">f. Asuransi Kesehatan Lainnya</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_asuransi" value="' . $key . '" ' . ( ( $key == $row->status_asuransi ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">g. Program Keluarga Harapan</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_pkh" value="' . $key . '" ' . ( ( $key == $row->status_pkh ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">h. Beras Untuk Orang Miskin (Raskin)</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no2 as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_rastra" value="' . $key . '" ' . ( ( $key == $row->status_rastra ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
								<div class="col-12 m-t-30">
									<label class="col-12 f-w-900" for="nothing">i. Kredit Usaha Rakyat</label>
									<div class="row col-12">
										<?php
											foreach ( $arr_yes_no as $key => $value ) {
												echo '
										<div class="col-12">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="status_kur" value="' . $key . '" ' . ( ( $key == $row->status_kur ) ? 'checked="checked"' : null ) . '> <span class="custom-control-label">' . $key . ' = ' . $value . '</span>
											</label>
										</div>';
											}
										?>
									</div>
								</div>
							</div>
							<!-- end right-side -->

						</div>
						</form>
					</div>
					<!-- end tab-aset-program -->

					<!-- tab-art-usaha -->
					<div class="tab-pane fade table-responsive f-12" id="tab9" role="tabpanel" aria-labelledby="tab9p">
						<table class="table table-striped table-xs table-bordered m-t-10">
							<thead>
								<tr>
									<th>Nama</th>
									<th>No Urut ART</th>
									<th>Lapangan Usaha</th>
									<th>Kode Lapangan Usaha</th>
									<th>Jumlah Pekerja</th>
									<th>Lokasi Usaha</th>
									<th>Omset Usaha</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach ( $usaha as $k => $val) {
									$detail = '<button act="' . base_url( 'verivali/detail_data' ) . '/get_form_detail_usaha/' . enc( [ 'id' => $val->id ] ) . '" class="btn btn-warning btn-xs btn-edit-anak" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';
									echo '
								<tr>
									<td>' . $val->nama_art . '</td>
									<td>' . $val->no_urut_art . '</td>
									<td>' . $val->lapangan_usaha . '</td>
									<td>' . $val->kode_lapangan_usaha . '</td>
									<td>' . $val->jumlah_pekerja . '</td>
									<td>' . $val->lokasi_usaha . '</td>
									<td>' . $val->omset_usaha . '</td>
									<td>' . $detail . '</td>
								</tr>
									';
								}
							?>
							</tbody>
						</table>
					</div>
					<!-- end tab-art-usaha -->

					<!-- tab-foto -->
					<div class="tab-pane fade table-responsive f-12" id="tab10" role="tabpanel" aria-labelledby="tab10p">
						<?php
							$warna = "badge-danger";
							if ($jml_foto->jumlah >= 9) {
								$warna = "badge-success";
							}
						?>
						<span class="badge badge-warning text-dark float-right m-b-10"><?php echo "Foto Dihapus : ".$jml_foto_hapus->jumlah;?></span>
						<span class="badge <?php echo $warna; ?> float-right m-b-10 m-r-5"><?php echo "Foto Aktif : ".$jml_foto->jumlah;?></span>
						<table class="table table-striped table-xs table-bordered m-t-10">
							<thead>
								<tr>
									<th>Status</th>
									<th>Preview</th>
									<th>Nama Berkas</th>
									<th>Keterangan</th>
									<th>Size</th>
									<th>Jenis</th>
									<th>Lintang</th>
									<th>Bujur</th>
									<th>Upload On</th>
									
								</tr>
							</thead>
							<tbody>
							<?php
							$status="";
							foreach ( $foto as $k => $v ) {
								if ($v->row_status=='ACTIVE')
									$status = '<img src="' . base_url('assets/style/icon-status/bullet-gray.png') . '" title="Data Aktif" alt="Data Aktif"/>' ;
								else if ($v->row_status == 'NEW')
									$status = '<img src="' . base_url('assets/style/icon-status/bullet-green.png') . '" title="Data Baru" alt="Data Baru" />';
								else if ($v->row_status == 'DELETED')
									$status = '<img src="' . base_url('assets/style/icon-status/bullet-red.png') . '" title="Data Di Hapus" alt="Data Di Hapus" />';
									$createon = date("d-m-Y H:i:s",strtotime($v->created_on));
								echo '
								<tr>
									<td>' . $status . '</td>
									<td>
										<a href="' ."https://siksdroidv2-api.cacah.net/".$v->internal_filename. '" target="_blank">
											<img src="' ."https://siksdroidv2-api.cacah.net/".$v->internal_filename. '" width="100px" height="100px" title="'.$v->file_name.'">
										</a>
								
									</td>
									<td>' . substr($v->file_name, 0, 20) . '...</td>
									<td>' . substr($v->description, 0, 40) . '...</td>
									<td>' . $v->file_size . ' kB</td>
									<td>' . $v->stereotype . '</td>
									<td>' . $v->latitude . '</td>
									<td>' . $v->longitude . '</td>
									<td>' . $createon . '</td>
									
								</tr>
								';
							}
							?>
							</tbody>
						</table>
					</div>
					<!-- end tab-foto -->

					<!-- tab-audit -->
					<div class="tab-pane fade table-responsive f-12" id="tab11" role="tabpanel" aria-labelledby="tab11p">
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
								function date_compare($element1, $element2) {
									$datetime1 = strtotime($element1['on']);
									$datetime2 = strtotime($element2['on']);
									return $datetime1 - $datetime2;
								}

								// Sort the array
								$audit_trail = json_decode( $row->audit_trails, true );
								usort($audit_trail, 'date_compare');
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
					<!-- end tab-audit -->
				</div>

				<!-- super-admin-only -->
				<div class="container m-t-30">
					<div class="row d-flex justify-content-center">
						<?php if ($_SESSION['user_info']['user_username'] == 'root' || $acl_approve ): ?>
							<button type="button" class="btn btn-sm btn-primary btn-save-prelist col-md-2 f-w-900" >
								Simpan
							</button>
						
						<button type="reset" class="btn btn-sm btn-danger col-md-2 f-w-900" onclick="location.reload();">
							Batal
						</button>
						<?php endif; ?>
					</div>
				</div>
					<!-- end super-admin-only -->

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
<div class="modal" id="modalFormAnak">
	<div class="modal-dialog modal-l modal-dialog-scrollable">
		<div id="modalContentAnak" class="modal-content">
		</div>
	</div>
</div>
<div class="modal" id="modalFormUsaha">
	<div class="modal-dialog modal-l modal-dialog-scrollable">
		<div id="modalContentUsaha" class="modal-content">
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
	function show_form_anak( url ){
		$.ajax({
			url:url,
			type: 'GET',
			dataType: 'html',
			beforeSend: function( xhr ) {
				$('#loader').modal('show');
			},
			success : function(data) {
				$('#loader').modal('hide');
				$('#modalContentAnak').html(data);
				$('#modalFormAnak').modal('show');
			},
		});
	}

	function show_form_usaha( url ){
		$.ajax({
			url:url,
			type: 'GET',
			dataType: 'html',
			beforeSend: function( xhr ) {
				$('#loader').modal('show');
			},
			success : function(data) {
				$('#loader').modal('hide');
				$('#modalContentUsaha').html(data);
				$('#modalFormUsaha').modal('show');
			},
		});
	}

	$(document).ready( function(){
		
		$(document).on( 'click', 'button.btn-edit-art', function(){
			show_form_art( $(this).attr('act') );
		});

		$(document).on( 'click', 'button.btn-edit-kk', function(){
			show_form_kk( $(this).attr('act') );
		});

		$(document).on( 'click', 'button.btn-edit-anak', function(){
			show_form_anak( $(this).attr('act') );
		});

		$(document).on( 'click', 'button.btn-edit-usaha', function(){
			show_form_usaha( $(this).attr('act') );
		});

		$(document).on( 'click', 'button.btn-save-prelist', function(){
			var data = $("#form_prelist").serialize() + "&" + $("#form_tempat").serialize() + "&" + $("#form_responden").serialize() + "&" + $("#form_rumah").serialize() + "&" + $("#form_aset").serialize();
			$.ajax({
				url:"<?php echo base_url('verivali/detail_data/act_detail_save_prelist/'); ?>",
				type: 'POST',
				data: data,
				dataType: 'json',
				success : function( data ) {
					if ( data.status == 200 ) {
						alert(data.message);
					} else {
						alert(data.message);
					}
				},
			});
		});

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
