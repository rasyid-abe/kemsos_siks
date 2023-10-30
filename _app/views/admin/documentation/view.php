<!-- ekko-lightbox css -->
<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/ekko-lightbox.css">
<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/lightbox.min.css">

<!-- [ Main Content ] start -->
<div class="row">
	<!-- [ sample-page ] start -->
	<div class="col-sm-12">

		<div class="card">
			<div class="card-header">
				<h5>Documentation</h5>
			</div>
			<div class="card-body">

				<?php if($this->session->flashdata('flash')): ?>
					<div class="alert alert-<?php echo $this->session->flashdata('class');?> alert-dismissible fade show" role="alert">
						<?php echo $this->session->flashdata('flash'); ?>.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
				<?php endif ?>

				<button type="button" class="btn btn-info btn-sm mb-3" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false"><i class="feather mr-2 icon-file-plus"></i>Input Dokumentasi</button>
				<div class="card-columns">
					<?php foreach ($gallery as $key => $value): ?>
						<?php $images = json_decode($value['foto']); ?>
						<div class="card">
							<img class="img-fluid card-img-top" src="<?php echo base_url('assets/uploads/documentation/').$value['tanggal'].'/'.str_replace(' ', '_', $value['nama_kegiatan']).'/'.$images[0];?>" alt="Card image">
							<div class="card-body">
								<h5 class="job-card-desc"><?php echo $value['nama_kegiatan'] ?></h5>
								<p><?php echo substr($value['deskripsi'],0,100).' ...'; ?></p>
								<div class="job-meta-data mb-1"><i class="fas fa-map-marker-alt"></i><?php echo $value['lokasi_kegiatan'] ?></div>
								<div class="job-meta-data"><i class="fas fa-calendar-alt"></i><?php echo $value['tanggal'] ?></div>
								<a href="<?php echo base_url( 'admin/documentation/detail/' ) . $value['id']; ?>" class="btn btn-primary btn-sm mt-3"><i class="feather mr-2 icon-camera"></i>Lihat</a>
								<a href="<?php echo base_url( 'admin/documentation/delete/' ) . $value['id']; ?>" class="btn btn-danger btn-sm mt-3"><i class="feather mr-2 icon-trash-2"></i>Lihat</a>
								<!-- <buton type="button" onclick="delete_file(<?php echo $value['id'] ?>)" class="btn btn-danger btn-sm mt-3 sweet-multiple"><i class="feather mr-2 icon-trash-2"></i>Hapus</button> -->
								</div>
							</div>
						<?php endforeach; ?>
					</div>

				</div>
			</div>
		</div>
		<!-- [ sample-page ] end -->
	</div>
	<!-- [ Main Content ] end -->

	<!-- Modal Input Dokumentasi -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?php echo base_url( 'admin/documentation/store' ); ?>" method="post" id="id_form_upload" enctype="multipart/form-data">
					<div class="modal-header">
						<h5 class="modal-title h4" id="myLargeModalLabel">Form Input Dokumentasi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="kegiatan" class="col-form-label">Nama Kegiatan:</label>
							<input type="text" class="form-control" id="kegiatan" name="kegiatan" required>
						</div>
						<div class="form-group">
							<label for="lokasi" class="col-form-label">Lokasi Kegiatan:</label>
							<input type="text" class="form-control" id="lokasi" name="lokasi" required>
						</div>
						<div class="form-group">
							<label for="tanggal" class="col-form-label">Tanggal Kegiatan:</label>
							<input type="date" class="form-control" id="tanggal" name="tanggal" required>
						</div>
						<div class="form-group">
							<label for="deskripsi" class="col-form-label">Deskripsi:</label>
							<textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Foto:</label><br>
							<input type="file" id="file" class="validation-file" name="files[]" multiple="multiple" accept="image/*" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn  btn-secondary" data-dismiss="modal">Tutup</button>
						<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
						<!-- <button type="button" class="btn  btn-primary">Simpan</button> -->
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- ekko-lightbox Js -->
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/ekko-lightbox.min.js"></script>
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/lightbox.min.js"></script>
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/ac-lightbox.js"></script>

	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/sweetalert.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {

		function delete_file(id) {
			console.log(id);
			// swal({
			// 	title: "Anda yakin menghapus data Dokumentasi ini?",
			// 	text: "Saat Dihapus, anda tidak akan bisa memulihkan file tersebut!",
			// 	icon: "warning",
			// 	buttons: true,
			// 	dangerMode: true,
			// })
			// .then((willDelete) => {
			// 	if (willDelete) {
			// 		$.ajax({
			// 			url : '<?php echo base_url( 'admin/documentation/delete/' )?>',
			// 			data : {'id':id},
			// 			dataType : 'json',
			// 			async: false,
			// 			method : 'post',
			// 			success : function(res){
			// 				result = res;
			// 			}
			// 		})
			// 		swal("Berhasil! Dokumentasi telah Berhasil dihapus!", {
			// 			icon: "success",
			// 		});
			// 	} else {
			// 		swal("Foto dokumentasi masih aman!", {
			// 			icon: "error",
			// 		});
			// 	}
			//
			// });

		}

	})

	</script>
