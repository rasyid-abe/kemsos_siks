<style type="text/css">
	.loc-ul {list-style-type: none; margin: 0; padding: 0 0 0 25px; display: none; } .loc-li {cursor: pointer; -webkit-user-select: none; /* Safari 3.1+ */ -moz-user-select: none; /* Firefox 2+ */ -ms-user-select: none; /* IE 10+ */ user-select: none; font-size: 23px; padding-right: 10px; display: block; } .loc-text{cursor: pointer; font-family: 'Arial'; font-size: 14px; } .loc::before {content: "\2610"; color: black; display: inline-block; margin-right: 6px; width:10px; } .loc-check::before {content: "\2611"; color: dodgerblue; } .loc-half-check::before {content: "\2612"; color: dodgerblue; } .loc-ul-active {display: block;} .btn-exs{padding: 0.125rem 0.25rem;font-size: smaller;color: black;} .subor::before {content: "\2610"; display: inline-block; font-size: 14px;} .subor-check::before {content: "\2611"; color: dodgerblue; }
	ul, #myUL {
	  list-style-type: none;
	}

	#myUL {
	  margin: 0;
	  padding: 0;
	  font-size: 11pt;
	  line-height: 1.2;
	}

	.caret {
	  cursor: pointer;
	  -webkit-user-select: none; /* Safari 3.1+ */
	  -moz-user-select: none; /* Firefox 2+ */
	  -ms-user-select: none; /* IE 10+ */
	  user-select: none;
	}

	.caret::before {
	  content: "\25B6";
	  color: black;
	  display: inline-block;
	  margin-right: 6px;
	}

	.caret-down::before {
	  -ms-transform: rotate(90deg); /* IE 9 */
	  -webkit-transform: rotate(90deg); /* Safari */'
	  transform: rotate(90deg);
	}

	.nested {
	  display: none;
	}

	.active {
	  display: block;
	}

</style>
<div class="card">
	<div class="col-md-12" style="padding: 16px;background: #f7f7f7;border-bottom: 1px #000 solid;"><i class="fa fa-info-circle"></i>&nbsp;Detail User</div>
	<div class="col-md-12 mt-md-6">
		<ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link text-reset active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false"><i class="feather icon-user mr-2"></i>User Data</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="group-tab" data-toggle="tab" href="#group" role="tab" aria-controls="group" aria-selected="false"><i class="feather icon-user-check mr-2"></i>Groups</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="map-tab" data-toggle="tab" href="#map" role="tab" aria-controls="map" aria-selected="false"><i class="feather icon-map-pin mr-2"></i>Locations</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="sub-tab" data-toggle="tab" href="#sub" role="tab" aria-controls="sub" aria-selected="false"><i class="feather icon-share-2 mr-2"></i>Subordinates</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="logs-tab" data-toggle="tab" href="#logs" role="tab" aria-controls="logs" aria-selected="false"><i class="feather icon-slack mr-2"></i>Logs</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="feather icon-edit mr-2"></i>Profile</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="false"><i class="feather icon-lock mr-2"></i>Account</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-reset" id="device-tab" data-toggle="tab" href="#device" role="tab" aria-controls="device" aria-selected="false"><i class="feather icon-smartphone mr-2"></i>Device</a>
			</li>
		</ul>
	</div>
</div>
<div class="tab-content" id="myTabContent">
	<div class="container tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
		<div class="row m-b-20 m-l-20 m-r-20">
			<div class="col-sm-12">
				<form id="form_account" class="m-b-20">
					<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Username</label>
								<div class="col-sm-6">
									<input type="text" class="form-control form-control-sm" value="<?php echo $user_detail->user_account_username;?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Email</label>
								<div class="col-sm-6">
									<input name="user_email" id="email" type="email" class="form-control form-control-sm" value="<?php echo $user_detail->user_account_email;?>" required />
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Password</label>
								<div class="col-sm-6">
									<input name="user_password" id="kata_sandi" type="password" class="form-control form-control-sm" placeholder="*****" required />
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Last Login On</label>
								<div class="col-sm-6">
									<input type="text" class="form-control form-control-sm" value="<?php echo ( ( $user_detail->user_account_last_login_datetime == '' ) ? 'Never Login' : date("d-m-Y H:i:s",strtotime($user_detail->user_account_last_login_datetime)) ) ;?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Last Login From</label>
								<div class="col-sm-6">
									<input type="text" class="form-control form-control-sm" value="<?php echo ( ( $user_detail->user_account_last_login_ip == '' ) ? 'Never Login' : $user_detail->user_account_last_login_ip ) ;?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label-sm f-w-900">Status</label>
								<div class="col-sm-6">
									<select name="user_is_active" class="form-control form-control-sm">
										<option disabled>Pilih</option>
										<option value="1" <?php echo ( ( $user_detail->user_account_is_active == '1' ) ? 'selected' : '' ) ;?>>Enable</option>
										<option value="0" <?php echo ( ( $user_detail->user_account_is_active == '0' ) ? 'selected' : '' ) ;?>>Disable</option>
									</select>
								</div>
							</div>
						</div>
						<div class="float-right">
							<button id="save_account" type="submit" class="btn btn-sm btn-primary">Save</button>
							<button id="reset_account" type="button" class="btn btn-sm btn-danger">Reset Form</button>
							<button act="<?php echo base_url( 'config/user/restore_db' ); ?>" type="button" class="btn btn-warning btn-sm btn-restore" >Get Restore DB Code</button>
						</div>
					</div>
				</form>

				<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
					<li class="nav-item active">
						<a href="#tab1" id="tab1p" class="nav-link active" data-toggle="tab" aria-controls="tab1" aria-selected="true">Properties</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1p">
						<form id="form_properties">
							<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
							<div class="form-group row">
								<label for="b-t-nik" class="col-sm-2 col-form-label">NIK</label>
								<div class="col-sm-5">
									<input type="text" name="nik" min="1" class="form-control" id="properties_nik" placeholder="NIK" value="<?php echo $user_detail->user_profile_nik;?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="b-t-name" class="col-sm-2 col-form-label">Full Name</label>
								<div class="col-sm-5">
									<input type="text" name="first_name" class="form-control" id="properties_first_name" placeholder="First Name" value="<?php echo $user_detail->user_profile_first_name;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label-sm">Android ID</label>
								<div class="col-sm-5">
									<div class="input-group input-group-sm">
										<input id="android_id" name="android_id" type="text" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_android_id;?>">
										<div class="input-group-append">
											<div class="input-group-text" id="inputGroup-sizing-sm">
												<button id="reset_android_id" type="button" class="btn btn-exs btn-warning" title="Reset Android ID" <?php echo ( ( empty( $user_detail->user_profile_android_id ) ) ? 'disabled' : null );?>><i class="fa fa-sync"></i></button></div>
										</div>
									</div>
								</div>
							</div>
							<button id="save_properties" type="button" class="btn btn-sm btn-primary">Save</button>
						</form>
					</div>
				</div>
				<!-- end myTabContent -->
			</div>
		</div>
	</div>

	<div class="container tab-pane fade show" id="group" role="tabpanel" aria-labelledby="group-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-md-5">
						<div style="overflow: scroll; height:500px"><?php echo $user_group;?></div>
					</div>
					<div class="col-md-7">
						<table id="gridview-group" style="display:none;"></table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container tab-pane fade show" id="map" role="tabpanel" aria-labelledby="map-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-md-5 f-10">
						<?php
						$user_info = $_SESSION['user_info'];
						?>
						<?php if (in_array('root', $user_info['user_group'])): ?>
							<div id="treeview" style="overflow: scroll; height:500px"></div>
						<?php else: ?>
							<ul id="myUL" style="overflow: scroll; height:485px; border: 1px solid lightgray; padding: 10px; margin-bottom: 15px">
							<?php for ($i=0; $i < count($userloc); $i++) { ?>
								<li>
									<span class="caret">
										<input type="checkbox" id="<?php echo $userloc[$i]['location_id'] ?>">
										<label for="<?php echo $userloc[$i]['location_id'] ?>"> <?php echo $userloc[$i]['full_name'] ?> </label>
									</span>
									<ul class="nested">

									<?php if (count($userloc[$i]['hasChild']) > 0): ?>
										<?php for ($j=0; $j < count($userloc[$i]['hasChild']); $j++) { ?>
											<li>
												<span class="caret">
													<input type="checkbox" id="<?php echo $userloc[$i]['hasChild'][$j]['location_id'] ?>" name="location_id[]" value="<?php echo $userloc[$i]['hasChild'][$j]['location_id'] ?>">
													<label for="<?php echo $userloc[$i]['hasChild'][$j]['location_id'] ?>"> <?php echo $userloc[$i]['hasChild'][$j]['full_name'] ?> </label>
												</span>
												<ul class="nested">

													<?php if (count($userloc[$i]['hasChild'][$j]['hasChild']) > 0): ?>
														<?php for ($k=0; $k < count($userloc[$i]['hasChild'][$j]['hasChild']); $k++) { ?>
															<li>
																<!-- <span class="caret"> -->
																	<input type="checkbox" id="<?php echo $userloc[$i]['hasChild'][$j]['hasChild'][$k]['location_id'] ?>" name="location_id[]" value="<?php echo $userloc[$i]['hasChild'][$j]['hasChild'][$k]['location_id'] ?>">
																	<label for="<?php echo $userloc[$i]['hasChild'][$j]['hasChild'][$k]['location_id'] ?>"> <?php echo $userloc[$i]['hasChild'][$j]['hasChild'][$k]['full_name'] ?> </label>
																<!-- </span> -->
															</li>
														<?php } ?>
													<?php endif; ?>
												</ul>
											</li>
										<?php } ?>
									<?php endif; ?>
									</ul>
								</li>
							<?php }	?>
						</ul>
						<?php endif; ?>
					</div>
					<div class="col-md-7">
						<table id="gridview-loc" style="display:none;"></table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container tab-pane fade show" id="sub" role="tabpanel" aria-labelledby="sub-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="row m-b-10">
					<div class="col-5">
						<table id="gridview-subordinat-user" style="display:none;"></table>
					</div>
					<div class="col-1 text-center" style="margin-top:auto;margin-bottom: auto;">
						<button type="button" id="save_subordiantes" class="btn btn-info btn-sm mb-1"><i class="fa fa-arrow-right"></i></button>
						<button type="button" id="remove_subordiantes" class="btn btn-info btn-sm"><i class="fa fa-arrow-left"></i></button>
					</div>
					<div class="col-6">
						<table id="gridview-subordinat-detail" style="display:none;"></table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container tab-pane fade show" id="logs" role="tabpanel" aria-labelledby="logs-tab">
		<div class="row m-b-10">
			<div class="col-sm-12">
				<table id="gridview-logs-user" style="display:none;"></table>
			</div>
		</div>
	</div>

	<div class="container tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		<!-- banner -->
		<div class="col-sm-12">
			<div class="card user-card user-card-2 shape-right">
				<div class="card-header border-0 p-2 pb-0">
					<div class="cover-img-block">
						<img src="<?php echo base_url( 'assets/uploads/images/cover.jpg' )?>" alt="" class="img-fluid">
					</div>
				</div>
				<div class="card-body pt-0">
					<div class="user-about-block">
						<div class="row align-items-center">
							<div class="col">
								<div class="row align-items-center">
									<div class="col-auto col pr-0">
										<div class="change-profile">
											<div class="dropdown">
												<a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<div class="profile-dp">
													<?php
														$foto = base_url( 'assets/uploads/images/users/') . ( ( ! empty( $user_detail->user_profile_image ) ) && ( file_exists( './assets/uploads/images/users/' . $user_detail->user_profile_image ) ) ? $user_detail->user_profile_image : 'default.png' );
													?>
														<img class="img-radius img-fluid wid-100" src="<?php echo $foto;?>" alt="User image">
													</div>
												</a>
											</div>
										</div>
									</div>
									<div class="col">
										<h6 class="mb-1"><?php echo $user_detail->user_profile_first_name ." ". $user_detail->user_profile_last_name;?></h6>
										<p class="mb-0"><?php echo $user_detail->user_account_username;?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end banner -->

		<div class="row">
			<div id="info-profile" class="col-md-12"></div>
		</div>

		<form id="form_profile" enctype="multipart/form-data">
			<div class="row">
				<!-- left-side -->
				<div class="col-md-6 col-sm-12">
					<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Nama Lengkap</label>
						<div class="col-sm-8">
							<input name="first_name" type="text" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_first_name;?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">NIK</label>
						<div class="col-sm-8">
							<input name="nik" id="value_nik" pattern=".{16,16}" minlength="16" maxlength="16" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_nik;?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Sub-regional</label>
						<div class="col-sm-8">
							<input name="sub_regional" type="text" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_sub_regional;?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Tempat Kelahiran</label>
						<div class="col-sm-8">
							<input name="tempat_lahir" type="text" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_born_place;?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Tanggal Kelahiran</label>
						<div class="col-sm-8">
							<input name="tanggal_lahir" type="date" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_born_date;?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Jenis Kelamin</label>
						<div class="col-sm-4">
						<label class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" name="sex" value="pria" <?php echo ( ( $user_detail->user_profile_sex == 'pria' ) ? 'checked' : null );?> > <span class="custom-control-label">Pria </span>
						</label>
						</div>
						<div class="col-sm-4">
						<label class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" name="sex" value="wanita" <?php echo ( ( $user_detail->user_profile_sex == 'wanita' ) ? 'checked' : null );?>> <span class="custom-control-label">Wanita </span>
						</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Alamat</label>
						<div class="col-sm-8">
							<textarea name="address" class="form-control form-control-sm"><?php echo $user_detail->user_profile_address;?></textarea>
						</div>
					</div>
				</div>
				<!-- end-left-side -->

				<!-- right-side -->
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Email Alternatif</label>
						<div class="col-sm-8">
							<input name="email_alternatif" type="email" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_email_alternatif ;?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Nomor HP Utama</label>
						<div class="col-sm-8">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<div class="input-group-text" id="inputGroup-sizing-sm">+62</div>
								</div>
								<input name="no_hp" id="no_hp_utama" minlength="10" maxlength="12" type="text" class="form-control form-control-sm" value="<?php echo substr($user_detail->user_profile_no_hp, 3);?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="no_hp2" class="col-sm-5 col-form-label-sm f-w-900">Nomor HP Alternatif</label>
						<div class="col-sm-8">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<div class="input-group-text" id="inputGroup-sizing-sm">+62</div>
								</div>
								<input name="no_hp2" id="no_hp_alt" minlength="10" maxlength="12" type="text" class="form-control form-control-sm" value="<?php echo substr($user_detail->user_profile_no_hp2, 3);?>" maxlength="13" minlength="10">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Tanggal Akhir Kontrak</label>
						<div class="col-sm-8">
							<input name="tanggal_kontrak" type="date" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_tgl_kontrak;?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Android ID</label>
						<div class="col-sm-8">
							<div class="input-group input-group-sm">
								<input id="android_id" name="android_id" type="text" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_android_id;?>">
								<div class="input-group-append">
									<div class="input-group-text" id="inputGroup-sizing-sm">
										<button id="reset_android_id" type="button" class="btn btn-exs btn-warning" title="Reset Android ID" <?php echo ( ( empty( $user_detail->user_profile_android_id ) ) ? 'disabled' : null );?>><i class="fa fa-sync"></i></button></div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Mobile Apps Last Login</label>
						<div class="col-sm-8">
							<input name="ip_last" type="text" class="form-control form-control-sm" value="<?php echo $user_detail->user_profile_ip_last;?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-form-label-sm f-w-900">Pas Foto</label>
						<div class="input-group col-sm-8">
							<div class="custom-file">
								<input type="file" name="image" size="20" class="custom-file-input form-control-sm" id="inputGroupFile01">
								<label class="custom-file-label" for="inputGroupFile01">Pilih File Foto</label>
							</div>
						</div>
					</div>
					<div class="form-group d-flex justify-content-center">
						<button id="save_profile" type="button" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
						<button id="reset_profile" type="button" class="btn btn-sm btn-danger"><i class="fa fa-undo"></i>&nbsp;&nbsp;Reset Form</button><br/><br/>
					</div>
				</div>
				<!-- end-right-side -->
			</div>
		</form>
	</div>

	<div class="container tab-pane fade show" id="account" role="tabpanel" aria-labelledby="account-tab">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-md-12 form-group">
						<button id="copyToClipboard" type="button" class="btn btn-sm btn-primary"><i class="fa fa-copy"></i>&nbsp;Copy To Clipboard</button>
						<input id="clipboard" type="hidden" value="">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<textarea id="account_information" class="form-control form-control-sm" readonly style="height: 300px;font-family: Consolas !important;"><?php
							$url = base_url();
							$url = base_url();
	echo "*Informasi Account untuk akses SIKS-DROID*

*Nama:* {$user_detail->user_profile_first_name} {$user_detail->user_profile_last_name}
*NIK:* {$user_detail->user_profile_nik}
*No. HP:* {$user_detail->user_profile_no_hp}
*Email Pribadi:* {$user_detail->user_account_email}

Username: {$user_detail->user_account_username}
Password: {$this->encryption->decrypt( $user_detail->user_account_password )}

*SIKS-DROID* bisa diunduh di {$url}download/siksdroid.apk";
							?>
						</textarea>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container tab-pane fade show" id="device" role="tabpanel" aria-labelledby="device-tab">
		<div class="row">
			<div class="col-md-12 form-group">
				<button id="copyToClipboard2" type="button" class="btn btn-sm btn-primary"><i class="fa fa-copy"></i>&nbsp;Copy To Clipboard</button>
				<input id="clipboard" type="hidden" value="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 form-group">
				<textarea id="account_information2" class="form-control form-control-sm" readonly style="height: 300px;font-family: Consolas !important;">
<?php
$description = "No data.";
if ( !empty( $user_device->user_desciption ) ) {
	$description = 
	$user_device->user_desciption;
}
echo $description;

?>
				</textarea>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modalFormRestore">
	<div class="modal-dialog modal-sm modal-dialog-scrollable">
		<div id="modalContentRestore" class="modal-content">
		</div>
	</div>
</div>

<script type="text/javascript">

	$('input[name="location_id[]"]').click(function () {
		$id = $(this).val();
		save_user_location($id)
	});

	function save_user_location(id) {
		$.ajax({
			url : '<?php echo base_url() ?>config/user/my_user_location',
			dataType : 'json',
			data : {
				id:id,
				'user': <?php echo $user_id;?>
			},
			type : 'post',
			async: false,
			success : function(res) {
				if (res.status == true) {
					$('#gridview-loc').flexReload();
					alert(res.msg);
				} else {
					alert(res.msg);
				}
			}
		})
	}

	function process_treeview() {
		var toggler = document.getElementsByClassName("caret");
		for (i = 0; i < toggler.length; i++) {
			toggler[i].addEventListener("click", function() {
				this.parentElement.querySelector(".nested").classList.toggle("active");
				this.classList.toggle("caret-down");
			});
		}
	}

	detail_user = <?php echo json_encode( $user_detail );?>

	function show_form_restore( url ){
		$.ajax({
			url:url,
			type: 'GET',
			dataType: 'html',
			beforeSend: function( xhr ) {
				$('#loader').modal('show');
			},
			success : function(data) {
				$('#loader').modal('hide');
				$('#modalContentRestore').html(data);
				$('#modalFormRestore').modal('show');
			},
		});
	}

	$(document).ready( function(){
		process_treeview();

		$("#gridview-loc").flexigrid({
			url: '<?php echo $grid_loc['link_data']; ?>',
			dataType: 'json',
			colModel: [<?php echo $grid_loc['columns'];?>],
			buttons: [<?php echo $grid_loc['toolbars'];?>],
			sortname: "<?php echo $grid_loc['col_id'];?>",
			sortorder: "<?php echo ( ( isset( $grid_loc['sort'] ) ) ? $grid_loc['sort'] : 'asc' );?>",
			usepager: true,
			title: '',
			useRp: true,
			rp: 50,
			showTableToggleBtn: false,
			showToggleBtn: true,
			width: 'auto',
			height: '400',
			resizable: false,
			singleSelect: false
		});

		$("#gridview-group").flexigrid({
			url: '<?php echo $grid_group['link_data']; ?>',
			dataType: 'json',
			colModel: [<?php echo $grid_group['columns'];?>],
			buttons: [<?php echo $grid_group['toolbars'];?>],
			sortname: "<?php echo $grid_group['col_id'];?>",
			sortorder: "<?php echo ( ( isset( $grid_group['sort'] ) ) ? $grid_group['sort'] : 'asc' );?>",
			usepager: true,
			title: '',
			useRp: true,
			rp: 50,
			showTableToggleBtn: false,
			showToggleBtn: true,
			width: 'auto',
			height: '400',
			resizable: false,
			singleSelect: false
		});

		$("#gridview-subordinat-user").flexigrid({
			url: '<?php echo $grid_subordinat_user['link_data']; ?>',
			dataType: 'json',
			colModel: [<?php echo $grid_subordinat_user['columns'];?>],
			buttons: [<?php echo $grid_subordinat_user['toolbars'];?>],
			sortname: "<?php echo $grid_subordinat_user['col_id'];?>",
			sortorder: "<?php echo ( ( isset( $grid_subordinat_user['sort'] ) ) ? $grid_subordinat_user['sort'] : 'desc' );?>",
			usepager: true,
			title: '',
			useRp: true,
			rp: 50,
			showTableToggleBtn: false,
			showToggleBtn: true,
			width: 'auto',
			height: '400',
			resizable: false,
			singleSelect: false,
			showCheckbox: true,
		});

		$("#gridview-subordinat-detail").flexigrid({
			url: '<?php echo $grid_subordinat_detail['link_data']; ?>',
			dataType: 'json',
			colModel: [<?php echo $grid_subordinat_detail['columns'];?>],
			buttons: [<?php echo $grid_subordinat_detail['toolbars'];?>],
			sortname: "<?php echo $grid_subordinat_detail['col_id'];?>",
			sortorder: "<?php echo ( ( isset( $grid_subordinat_detail['sort'] ) ) ? $grid_subordinat_detail['sort'] : 'asc' );?>",
			usepager: true,
			title: '',
			useRp: true,
			rp: 50,
			showTableToggleBtn: false,
			showToggleBtn: true,
			width: 'auto',
			height: '400',
			resizable: false,
			singleSelect: false,
			showCheckbox: true,
		});


		$("#gridview-logs-user").flexigrid({
			url: '<?php echo $grid_logs_user['link_data']; ?>',
			dataType: 'json',
			colModel: [<?php echo $grid_logs_user['columns'];?>],
			buttons: [<?php echo $grid_logs_user['toolbars'];?>],
			sortname: "<?php echo $grid_logs_user['col_id'];?>",
			sortorder: "<?php echo ( ( isset( $grid_logs_user['sort'] ) ) ? $grid_logs_user['sort'] : 'asc' );?>",
			usepager: true,
			title: '',
			useRp: true,
			rp: 50,
			showTableToggleBtn: false,
			showToggleBtn: true,
			width: 'auto',
			height: '400',
			resizable: false,
			singleSelect: false,
			showCheckbox: true,
		});


		$(document).off( 'click', 'button.btn-restore').on( 'click', 'button.btn-restore', function(){
			show_form_restore( $(this).attr('act') );
		});

		$("#save_subordiantes").off( "click").on( "click", function(){
			let arr_id = [];
			$('table#gridview-subordinat-user tbody tr').each( function(x, y){
				if( $(y).hasClass('trSelected') ) {
					arr_id.push( $(this).children( 'td[abbr="user_account_id"]').text() );
				}
			});
			$.ajax({
				url:"<?php echo base_url( 'config/user' ); ?>/act_save_user_subordinate",
				type: 'POST',
				data:{
					'id':arr_id,
					'id_user': '<?php echo $user_id;?>',
				},
				dataType: 'json',
				success : function( data ) {
					if ( data.status == 200 ) {
						$('#gridview-subordinat-detail').flexReload();
					}
					alert(data.msg);
				},
			});
		});

		$("#remove_subordiantes").off( "click").on( "click", function(){
			let arr_id = [];
			$('table#gridview-subordinat-detail tbody tr').each( function(x, y){
				if( $(y).hasClass('trSelected') ) {
					arr_id.push( $(this).children( 'td[abbr="user_id"]').text() );
				}
			});
			$.ajax({
				url:"<?php echo base_url( 'config/user' ); ?>/act_remove_user_subordinate",
				type: 'POST',
				data:{
					'id':arr_id,
					'id_user': '<?php echo $user_id;?>',
				},
				dataType: 'json',
				success : function( data ) {
					if ( data.status == 200 ) {
						$('#gridview-subordinat-detail').flexReload();
					}
					alert(data.msg);
				},
			});
		});

		json_location = <?php echo $location;?>;
		json_location_active = <?php echo $location_active;?>;

		$('#treeview').ready( function(){
			let params = {
				'parent_el': '',
				'id_parent_el': '0',
				'id_el': '0',
				'level_el' : '0',
				'is_checked_el': false,
			};
			render_element( json_location, params );
		});

		$(document).off('click', '.loc').on('click', '.loc', function() {
			checked_unchecked( this );
		});

		$(document).off('click', '.loc-text').on( 'click', '.loc-text', function(){
			
			let parent = $( this ).parent();
			// console.log( 'is empty :', parent.children( '.loc-ul' ).is(':empty') );
			// console.log( 'ul is active :', parent.children( '.loc-ul.loc-ul-active' ).length );
			if ( parent.children( '.loc-ul' ).is(':empty') ){
				parent.children( 'i.fa' ).removeClass( 'fa-caret-right' ).addClass( 'fa-caret-down' );
				let params = {
					'parent_el': parent,
					'id_parent_el': parent.attr( 'data-id' ),
					'level_el' : parent.attr( 'data-level' ),
					'is_checked_el': parent.children('.loc').hasClass( 'loc-check' ),
				};
				get_child( params );
			} else {
				if ( parent.children( '.loc-ul.loc-ul-active' ).length > 0 ) {
					parent.children( '.loc-ul' ).removeClass( 'loc-ul-active' );
					parent.children( 'i.fa' ).removeClass( 'fa-caret-down' ).addClass( 'fa-caret-right' );
				} else {
					parent.children( '.loc-ul' ).addClass( 'loc-ul-active' );
					parent.children( 'i.fa' ).removeClass( 'fa-caret-right' ).addClass( 'fa-caret-down' );
				}
			}
		});

		function get_child( params ) {
			
			$.ajax({
				url:"<?php echo $url_service; ?>/" + params.id_parent_el,
				type: 'GET',
				dataType: 'json',
				success : function(loc) {

					render_element( loc, params );
				},
			});
		}

		function render_element( loc, params = '' ) {
			let html = '';

			let checked = ( ( params.is_checked_el ) ? 'loc loc-check' : 'loc' );
			let class_el = '';
			let level = '';
			let parent_el = params.parent_el;
			let el = ( ( parent_el == '' ) ? $('#treeview') : parent_el.children('ul.loc-ul') );

			$.each( loc, function( key, value ) {
				
				level = value.level;
				let carret = '<i class="fa fa-caret-right"></i>&nbsp;';
				if ( value.level == '1' ) {
					let class_n = 'cn-' + value.id;
					class_el = class_n;
				} else if ( value.level == '2') {
					let class_n = 'child-cn-' + parseInt( params.id_parent_el, 10 );
					let class_p = 'cp-' + value.id;
					class_el = class_n + ' ' + class_p;
				} else if ( value.level == '3' ) {
					let class_n = 'child-cn-' + parseInt( params.parent_el.parent().parent().attr( 'data-id' ) );
					let class_p = 'child-cp-' + params.id_parent_el;
					let class_kt = 'ckt-' + value.id;
					class_el = class_n + ' ' + class_p + ' ' + class_kt;
				} else if ( value.level == '4' ) {
					let class_n = 'child-cn-' + parseInt( params.parent_el.parent().parent().parent().parent().attr( 'data-id' ) );
					let class_p = 'child-cp-' + parseInt( params.parent_el.parent().parent().attr( 'data-id' ) );
					let class_kt = 'child-ckt-' + params.id_parent_el;
					let class_ckc = 'ckc-' + value.id;
					class_el = class_n + ' ' + class_p + ' ' + class_kt + ' ' + class_ckc;
				} else if ( value.level == '5' ) {
					let class_n = 'child-cn-' + parseInt( params.parent_el.parent().parent().parent().parent().parent().parent().attr( 'data-id' ) );
					let class_p = 'child-cp-' + parseInt( params.parent_el.parent().parent().parent().parent().attr( 'data-id' ) );
					let class_kt = 'child-ckt-' + parseInt( params.parent_el.parent().parent().attr( 'data-id' ) );
					let class_ckc = 'child-ckc-' + parseInt( params.id_parent_el );
					let class_ckl = 'ckl-' + value.id;
					class_el = class_n + ' ' + class_p + ' ' + class_kt + ' ' + class_ckc + ' ' + class_ckl;
					carret = '&nbsp;&nbsp;&nbsp;&nbsp;';
				}

				html += `
					<li class="loc-li li-${value.id}" data-id="${value.id}" data-level="${value.level}">
						${carret}
						<span id="loc-${value.id}" class="${checked} ${class_el}"></span>
						<span class="loc-text">&nbsp;${value.name}</span>
						<ul class="loc-ul"></ul>
					</li>`;
			});

			if ( level != '1' ) {
				el.addClass('loc-ul-active');
			}
			el.html(html);
		}

		function checked_unchecked( el ){
			let id_el = $( el ).parent().attr( 'data-id' );
			let lev = $( el ).parent().attr( 'data-level' );
			if ( lev == '1' ) {
				checked_child( el, 'child-cn', id_el );
			} else if ( lev == '2' ){
				checked_child( el, 'child-cp', id_el );

				let id_parent_n = $(el).parent().parent().parent().attr('data-id');
				checked_parent( 'child-cn', id_parent_n);
			} else if ( lev == '3' ){
				checked_child( el, 'child-ckt', id_el );

				let id_parent_p = $(el).parent().parent().parent().attr('data-id');
				checked_parent( 'child-cp', id_parent_p);

				let id_parent_n = $(el).parent().parent().parent().parent().parent().attr('data-id');
				checked_parent( 'child-cn', id_parent_n);
			} else if ( lev == '4' ){
				checked_child( el, 'child-ckc', id_el );

				let id_parent_kt = $(el).parent().parent().parent().attr('data-id');
				checked_parent( 'child-ckt', id_parent_kt);
				let id_parent_p = $(el).parent().parent().parent().parent().parent().attr('data-id');
				checked_parent( 'child-cp', id_parent_p);
				let id_parent_n = $(el).parent().parent().parent().parent().parent().parent().parent().attr('data-id');
				checked_parent( 'child-cn', id_parent_n);
			} else if ( lev == '5' ){
				checked_child( el, 'child-ckl', id_el );

				let id_parent_kc = $(el).parent().parent().parent().attr('data-id');
				checked_parent( 'child-ckc', id_parent_kc);
				let id_parent_kt = $(el).parent().parent().parent().parent().parent().attr('data-id');
				checked_parent( 'child-ckt', id_parent_kt);
				let id_parent_p = $(el).parent().parent().parent().parent().parent().parent().parent().attr('data-id');
				checked_parent( 'child-cp', id_parent_p);
				let id_parent_n = $(el).parent().parent().parent().parent().parent().parent().parent().parent().parent().attr('data-id');
				checked_parent( 'child-cn', id_parent_n);
			}
		}

		function checked_child( el, child_class, id_el ) {
			if ( $( el ).hasClass( 'loc-check' ) ) {
				//uncheck
				$( el ).removeClass('loc-check');
				$( '.' + child_class + '-' + id_el ).removeClass( 'loc-check' );
				save_location( id_el,0 );
			} else {
				//check
				$( el ).removeClass('loc-half-check');
				$( el ).addClass( 'loc-check' );
				$( '.' + child_class + '-' + id_el ).addClass( 'loc-check' );
				save_location( id_el,1 );
			}
		}

		function checked_parent( class_el, id_parent) {
			let total = $( '.' + class_el + '-' + id_parent ).length;
			let total_check = $( '.' + class_el + '-' + id_parent + '.loc-check').length;
			if ( total_check == total ) {
				$( '#loc-' + id_parent ).addClass( 'loc-check' );
				$( '#loc-' + id_parent ).removeClass( 'loc-half-check' );
			} else if ( total_check < total && total_check > 0 ) {
				$( '#loc-' + id_parent ).removeClass( 'loc-check' );
				$( '#loc-' + id_parent ).addClass( 'loc-half-check' );
			} else if ( total_check == 0 ) {
				$( '#loc-' + id_parent ).removeClass( 'loc-check loc-half-check' );
			}
		}

		function save_location( id, val ){
			$.ajax({
				url:"<?php echo base_url( 'config/user' ); ?>/save_show_user_location",
				type: 'POST',
				data:{
					'id_loc':id,
					'id_user': '<?php echo $user_id;?>',
					'id_val':val,
				},
				dataType: 'json',
				success : function( data ) {
					if ( data.status == 200 ) {
						$('#gridview-loc').flexReload();
					}
					alert(data.msg);
				},
			});
		}


		function remove_location( com, grid, urlaction ){
			var grid_id = $(grid).attr('id');
			grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);

			if ($('.trSelected', grid).length > 0) {
				var conf = confirm(com + ' ' + $('.trSelected', grid).length + ' data?');
				if (conf == true) {
					var arr_id = [];
					var i = 0;
					$('.trSelected', grid).each(function () {
						var id = $(this).attr('data-id');
						var id_location = $(this).children( ":first" ).text();
						// $( '#loc-' + id_location ).removeClass('loc-check');
						checked_unchecked( $( '#loc-' + id_location ) );
						arr_id.push(id);
						i++;
					});
					$.ajax({
						type: 'POST',
						url: urlaction,
						data: com + '=true&item=' + JSON.stringify(arr_id),
						dataType: 'json',
						success: function (response) {
							$('#' + grid_id).flexReload();
							if (response['message'] != '') {
								var message_class = response['message_class'];
								if (message_class == '') {
									message_class = 'response_confirmation alert alert-success';
								}
								$("#response_message").finish();
								$("#response_message").addClass(message_class);
								$("#response_message").slideDown("fast");
								$("#response_message").html(response['message']);
								$("#response_message").delay(10000).slideUp(1000, function () {
									$("#response_message").removeClass(message_class);
								});
							}
						}
					});
				}
			}
		}

		$(document).off('click','input.ck').on( 'click', 'input.ck', function(){
			let id = $(this).val();
			$.ajax({
				url:"<?php echo base_url( 'config/user' ); ?>/act_show_group",
				type: 'POST',
				data:{
					'type': ( ( $(this).is(":checked") ) ? 'add' : 'delete' ),
					'item': JSON.stringify( [id] ),
					'id_user': '<?php echo $user_id;?>',
				},
				dataType: 'json',
				success : function( data ) {
					if ( data.status == 200 ) {
						$('#gridview-group').flexReload();
					}
					alert(data.message);
				},
			});
		});

		$(document).off( 'click', 'button#save_account').on( 'click', 'button#save_account', function(){
			var pass = document.getElementById("kata_sandi").value;
			var emm = document.getElementById("email").value;
			if (pass != "" && emm != "") {
				$.ajax({
					url:"<?php echo base_url( $this->dir ); ?>act_detail_save_account",
					type: 'POST',
					data: $('form#form_account').serialize(),
					dataType: 'json',
					success : function( data ) {
						if ( data.status == 200 ) {
							$('#gridview').flexReload();
						} else {
							alert(data.message);
						}
					},
				});
			}
		});

		$(document).off('click', 'button#save_properties').on( 'click', 'button#save_properties', function(){
			$.ajax({
				url:"<?php echo base_url( $this->dir ); ?>act_detail_save_account_properties",
				type: 'POST',
				data: $('form#form_properties').serialize(),
				dataType: 'json',
				success : function( data ) {
					if ( data.status == 200 ) {
						$('#gridview').flexReload();
					} else {
						alert(data.message);
					}
				},
			});
		});

		$(document).off( 'click', 'button#fetch_database').on( 'click', 'button#fetch_database', function(){
			$.ajax({
				url:"<?php echo base_url( $this->dir ); ?>act_fetch_database",
				type: 'POST',
				data: $('form#form_properties').serialize(),
				dataType: 'json',
				success : function( data ) {
					if ( data.status == 200 ) {
						$('#loader').modal('hide');
						$('#modalForm').modal('hide');
						alert(data.message);
					} else {
						$('#loader').modal('hide');
						$('#modalForm').modal('hide');
						alert(data.message);
					}
				},
			});
		});

		$(document).off( 'click', 'button#copyToClipboard').on( 'click', 'button#copyToClipboard', function(){
			$( '#account_information' ).select();
			document.execCommand('copy');
		});

		$(document).off( 'click', 'button#copyToClipboard2').on( 'click', 'button#copyToClipboard2', function(){
			$( '#account_information2' ).select();
			document.execCommand('copy');
		});

		$(document).off( 'click', 'button#reset_android_id').on( 'click', 'button#reset_android_id', function(){
			let reseted = confirm( "Anda yakin akan menghapus data Android ID dari database ?" );
			if ( reseted ) {
				$.ajax({
					url:"<?php echo base_url( $dir ); ?>act_reset_android_id",
					type: 'POST',
					data: {user_id: <?php echo $user_id;?>},
					dataType: 'json',
					success : function( res ) {
						if ( res.status ) {
							let notif = `<div class="col-md-12 ${res.class}">${res.msg}</div>`;
							$('#info-profile').html(notif);
							$('#android_id').val("");
						}
					},
				});
			}
		});

		$(document).off( 'click', 'button#save_profile').on( 'click', 'button#save_profile', function(){
			let myForm = $('form#form_profile')[0];
			console.log(myForm);
			let formData = new FormData( myForm );
			$.ajax({
				url:"<?php echo base_url( $dir ); ?>act_update_profile",
				type: 'POST',
				data: formData,
				contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    			processData: false,
				success : function( res ) {
					let notif = `<ul class="col-md-12 ${res.class}">`;
					$.each(res.msg, function(x, y) {
						notif += y;
					});
					notif += '</ul>';
					console.log(notif);
					$('#info-profile').html(notif);
				},
			});
		});

		$(document).off( 'click', 'button#reset_profile').on( 'click', 'button#reset_profile', function(){
			let reseted = confirm( "Anda yakin akan menghapus data Android ID dari database ?" );
			if ( reseted ) {
				console.log('data dihapus');
			}
		});

		$(document).off( 'click', 'table#gridview-subordinat-user tbody tr').on( 'click', 'table#gridview-subordinat-user tbody tr', function(){
			if( $(this).hasClass('trSelected') ) {
				$( this ).find( '.subor' ).addClass( 'subor-check');
			} else {
				$( this ).find( '.subor' ).removeClass( 'subor-check' );
			}
		});

		$(document).off( 'click', '.subor').on( 'click', '.subor', function(){
			console.log( $(this).is(":checked") );
			let par = $(this).parent().parent().parent().parent();
			if( $(this).is(":checked") ){
				par.addClass( 'trSelected' );
			} else {
				par.removeClass( 'trSelected' );
			}
		});
	});
</script>

<script>
	// Restricts input for the given textbox to the given inputFilter.
	function setInputFilter(textbox, inputFilter) {
	["input"].forEach(function(event) {
		textbox.addEventListener(event, function() {
		if (inputFilter(this.value)) {
			this.oldValue = this.value;
			this.oldSelectionStart = this.selectionStart;
			this.oldSelectionEnd = this.selectionEnd;
		} else if (this.hasOwnProperty("oldValue")) {
			this.value = this.oldValue;
			this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
		} else {
			this.value = "";
		}
		});
	});
	}

	// Install input filters.
	setInputFilter(document.getElementById("value_nik"), function(value) {
	return /^-?\d*$/.test(value); });
	setInputFilter(document.getElementById("no_hp_utama"), function(value) {
	return /^-?\d*$/.test(value); });
	setInputFilter(document.getElementById("no_hp_alt"), function(value) {
	return /^-?\d*$/.test(value); });
</script>
