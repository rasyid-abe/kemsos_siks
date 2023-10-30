<div class="card">
	<div class="col-md-12" style="padding: 16px;background: #f7f7f7;border-bottom: 1px #000 solid;"><i class="fa fa-info-circle"></i>&nbsp;Profile User</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <li><a class="nav-link text-left active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Profile</a></li>
                    <li><a class="nav-link text-left" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Ganti Password</a></li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
					<div class="col-md-6 alert alert-info alert-dismissible fade show" id="response_message" style="display:none;" role="alert"></div>
						<form id="form_account" class="m-b-20">
							<input type="hidden" name="user_id" value="<?php $user_info = $_SESSION['user_info']; echo $user_info['user_id'];?>">
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label-sm f-w-900">Nama Lengkap</label>
										<div class="col-sm-8">
											<input type="text" class="form-control form-control-sm" value="<?php echo $datap->user_profile_first_name;?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label-sm f-w-900">Username</label>
										<div class="col-sm-8">
											<input type="text" class="form-control form-control-sm" value="<?php echo $datap->user_account_username;?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label-sm f-w-900">NIK</label>
										<div class="col-sm-8">
											<input name="nik" id="nik" pattern=".{16,16}" minlength="16" maxlength="16" class="value_nik form-control form-control-sm" value="<?php echo $datap->user_profile_nik;?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label-sm f-w-900">Email</label>
										<div class="col-sm-8">
											<input name="user_email" id="user_email" type="email" class="form-control form-control-sm" value="<?php echo $datap->user_account_email;?>" required />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label-sm f-w-900">Jenis Kelamin</label>
										<div class="col-sm-8">
											<select name="gender" id="gender" class="form-control form-control-sm">
												<option disabled>Pilih</option>
												<option value="pria" <?php echo ( ( $datap->user_profile_sex == 'pria' ) ? 'selected' : '' ) ;?>>Laki-laki</option>
												<option value="wanita" <?php echo ( ( $datap->user_profile_sex == 'wanita' ) ? 'selected' : '' ) ;?>>Perempuan</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label-sm f-w-900">Tempat Lahir</label>
										<div class="col-sm-8">
											<input type="text" name="tmplahir" id="tmplahir" class="form-control form-control-sm" value="<?php echo $datap->user_profile_born_place;?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label-sm f-w-900">Tanggal Lahir</label>
										<div class="col-sm-8">
											<input type="date" name="tgllahir" id="tgllahir" class="form-control form-control-sm" value="<?php echo $datap->user_profile_born_date;?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label-sm f-w-900">Last Login On</label>
										<div class="col-sm-8">
											<input type="text" class="form-control form-control-sm" value="<?php echo ( ( $datap->user_account_last_login_datetime == '' ) ? 'Never Login' : date("d-m-Y H:i:s",strtotime($datap->user_account_last_login_datetime)) ) ;?>" readonly>
										</div>
									</div>									
									<button id="save_account" type="submit" class="btn btn-sm btn-danger">Simpan</button>
								</div>
								
							</div>
						</form>
                    </div>

					<!-- ganti-password -->
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
						<form id="form_pass" class="m-b-20">
						<input type="hidden" name="user_id" value="<?php $user_info = $_SESSION['user_info']; echo $user_info['user_id'];?>">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label-sm f-w-900">Password Lama</label>
							<div class="col-sm-6">
								<input type="password" name="kata_sandi_lama" id="kata_sandi_lama" class="form-control form-control-sm" required />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label-sm f-w-900">Password Baru</label>
							<div class="col-sm-6">
								<input type="password" name="kata_sandi_baru" id="kata_sandi_baru" class="form-control form-control-sm" required />
							</div>
						</div>
						<button id="save_pass" type="submit" class="btn btn-sm btn-danger">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function() {
		$('#response_message').hide();
		<?php if($this->session->flashdata('msg')){ ?>
		$('#response_message').html('<?php echo $this->session->flashdata('msg'); ?>').show();
		<?php } ?>
	});

	$(document).ready( function(){

		$(document).on( 'click', 'button#save_account', function(){
			var emm = document.getElementById("user_email").value;
			var nik = document.getElementById("nik").value;
			var gender = document.getElementById("gender").value;
			var tmplahir = document.getElementById("tmplahir").value;
			var tgllahir = document.getElementById("tgllahir").value;
			if (nik != "" && emm != ""  && gender != ""  && tmplahir != ""  && tgllahir != "") {
				$.ajax({
					url:"<?php echo base_url( $this->dir ); ?>simpan_profile",
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

		$(document).on( 'click', 'button#save_pass', function(){
			var lama = document.getElementById("kata_sandi_lama").value;
			var baru = document.getElementById("kata_sandi_baru").value;
			if (lama != "" && baru != "") {
				$.ajax({
					url:"<?php echo base_url( $this->dir ); ?>simpan_password_baru",
					type: 'POST',
					data: $('form#form_pass').serialize(),
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
	setInputFilter(document.getElementByClass("value_nik"), function(value) {
	return /^-?\d*$/.test(value); });
</script>
