
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
                    <h5 class="card-title"><?php echo $gallery['nama_kegiatan'] ?></h5>
                    <p class="card-text"><?php echo $gallery['tanggal'] ?></p>
                    <p class="card-text"><?php echo $gallery['deskripsi'] ?></p>
                    <a href="<?php echo base_url( 'admin/documentation' )?>" class="btn btn-sm btn-primary mb-2">Kembali</a>
	                <div class="row text-center">
                        <?php $images = json_decode($gallery['foto']); ?>
                        <?php foreach ($images as $key => $value): ?>
                            <!-- <?php print_r($value); ?> -->
                            <div class="col-xl-2 col-lg-3 col-sm-4 col-xs-12">
                                <a href="<?php echo base_url('assets/uploads/documentation/').$gallery['tanggal'].'/'.str_replace(' ', '_', $gallery['nama_kegiatan']).'/'.$value;?>" data-toggle="lightbox" data-gallery="example-gallery">
									<img src="<?php echo base_url('assets/uploads/documentation/').$gallery['tanggal'].'/'.str_replace(' ', '_', $gallery['nama_kegiatan']).'/'.$value;?>" class="img-fluid m-b-10" alt="">
								</a>
                            </div>
                        <?php endforeach; ?>
	                </div>

	            </div>
	        </div>
	    </div>
	    <!-- [ sample-page ] end -->
	</div>
	<!-- [ Main Content ] end -->

	<!-- ekko-lightbox Js -->
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/ekko-lightbox.min.js"></script>
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/lightbox.min.js"></script>
	<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/ac-lightbox.js"></script>
