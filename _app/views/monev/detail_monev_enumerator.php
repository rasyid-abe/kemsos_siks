<style type="text/css">
	.loc-ul {list-style-type: none; margin: 0; padding: 0 0 0 25px; display: none; } .loc-li {cursor: pointer; -webkit-user-select: none; /* Safari 3.1+ */ -moz-user-select: none; /* Firefox 2+ */ -ms-user-select: none; /* IE 10+ */ user-select: none; font-size: 23px; padding-right: 10px; display: block; } .loc-text{cursor: pointer; font-family: 'Arial'; font-size: 14px; } .loc::before {content: "\2610"; color: black; display: inline-block; margin-right: 6px; width:10px; } .loc-check::before {content: "\2611"; color: dodgerblue; } .loc-half-check::before {content: "\2612"; color: dodgerblue; } .loc-ul-active {display: block;} .btn-exs{padding: 0.125rem 0.25rem;font-size: smaller;color: black;} .subor::before {content: "\2610"; display: inline-block; font-size: 16px;} .subor-check::before {content: "\2611"; color: dodgerblue; }
</style>
<div class="card">
	<div class="col-md-12" style="padding: 16px;background: #f7f7f7;border-bottom: 1px #000 solid;"><i class="fa fa-info-circle"></i>&nbsp;Detail Monev Enumerator</div>
	<div class="col-md-12 mt-md-6">
		<ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link text-reset active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false"><i class="feather icon-user mr-2"></i>Informasi Umum</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="group-tab" data-toggle="tab" href="#group" role="tab" aria-controls="foto" aria-selected="false"><i class="feather icon-user-check mr-2"></i>Hasil Monitoring Enumerator</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="map-tab" data-toggle="tab" href="#map" role="tab" aria-controls="audit" aria-selected="false"><i class="feather icon-map-pin mr-2"></i>Audit</a>
			</li>
		</ul>
	</div>
</div>
<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade container show active" id="data" role="tabpanel" aria-labelledby="data-tab">
		<div class="">
			<div class="col-sm-12">				
				<div class="row">
					<input type="hidden" name="monev_enum_id" value="<?php echo $monev_enum_id;?>">										
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

					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label-sm">Tanggal Pengamatan</label>
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-sm" value="<?php echo date("d-m-Y H:i:s",strtotime($monev_detail->created_on));?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label-sm">Nama Petugas Monitoring</label>
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->monev_officer;?>" >
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label-sm">Jabatan Petugas Monitoring</label>
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->pd_jbt_petugas;?>" >
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<div class="tab-pane fade container show" id="group" role="tabpanel" aria-labelledby="group-tab">
		<div class="row">
			<div class="col-sm-12">
				<h5>A. Identitas Responden (Petugas Verifikasi/Enumerator)</h5>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">1. Nama</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->nama_enumerator;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">2. Usia</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->usia_enumerator;?> tahun" >
								</div>
							</div>
						</div>
					</div>
				</div>

				<h5>B. Pelaksanaan Kegiatan Verivikasi, Ketersediaan Verifikator, dan Tantangan dalam Verifikasi</h5>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">1.Berapa Jumlah Petugas Verivikasi/Enumerator di Wilayah Ini? </label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->jumlah_enumerator;?> orang" >
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">2. Berasal dari unsur mana petugas Verifikator</label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->unsur_verifikator == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> TKSK</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->unsur_verifikator == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Lainnya</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">3. Apakah Anda Mendapatkan Pelatihan/Bimbingan Teknis Sebelum Melaksanakan Tugas? </label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->apakah_mendapatkan_pelatihan == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->apakah_mendapatkan_pelatihan == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">4. Berapa lama pelatihannya? </label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->lama_pelatihan;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">5. Dimana tempat pelatihannya? </label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->tempat_pelatihan;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">6. Siapa yang melatih?</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->siapa_pelatih;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">7. Formulir Verifikasi mana yang Anda gunakan?</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->formulir_verifikasi;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">8. Apa kesulitan yang Anda hadapi saat Verifikasi?</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->kesulitan_dihadapi_verifikasi;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">9. Bagaimana Anda mengatasi kesulitan tersebut?</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->cara_menghadapi_kesulitan;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">10. Berapa waktu yang diberikan untuk melakukan seluruh Verifikasi?</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->waktu_verifikasi;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label class="col-sm-10 col-form-label-sm">11. Apakah Anda mampu menyelesaikan tepat waktu? </label>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="1" <?php echo ( ( $monev_detail->mampu_tepat_waktu == '1' ) ? 'checked' : null );?> > <span class="custom-control-label"> Ya</span>
									</label>
								</div>
								<div class="col-sm-4">
									<label class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" value="2" <?php echo ( ( $monev_detail->mampu_tepat_waktu == '2' ) ? 'checked' : null );?> > <span class="custom-control-label"> Tidak</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">12. Jika tidak, apa alasannya</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->alasan_tidak_tepat_waktu;?>" >
								</div>
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm">13. Setelah Verifikasi apa yang harus Anda lakukan?</label>
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="<?php echo $monev_detail->setelah_verifikasi;?>" >
								</div>
							</div>
						</div>
					</div>
				</div>
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