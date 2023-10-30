<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/leaflet/leaflet.css" />
    <!-- <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/MarkerCluster.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/leaflet/MarkerCluster.Default.css" />

<!-- [ Main Content ] start -->
<style>
    .spin{
        left: 50%;
        position: relative;
        top: 50%;
    }
    #loader{
        display: none;
        opacity: 0.8;
    }
    .detail-map .col-form-label{
        padding-bottom:0px !important;
        padding-top:0px !important;
    }
    .carousel-caption h5{
        background: #fff;
    }
    .carousel-item img{
        
        height: 250px;
    }
    .content{
        overflow-y: auto;
        overflow-x: hidden;
        height:300px;

    }
</style>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php
                if ( isset( $cari ) ) {
                  echo $cari;?> 
                    <?php
                }
                ?>
                <div id="response_message" style="display:none;"></div>
                <table id="gridview" style="display:none;"></table>

                <div id="loader" class="modal-backdrop">
                    <div class="spin">
                        <span class="fa fa-spinner fa-spin fa-4x"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div id="map" style="width: 100%; height: 500px; border: 1px solid #AAA;"></div>
            </div>
        </div>
    </div>
</div>

<section class="detail-map" style="display:none;position:absolute;height:100%;width:400px;border:1px solid #e2e3e5;top:0px;right:0px;z-index:9999; background:white;padding:10px;">
    <div class="close-bar" style="position:relative;right:0px;float:right;padding-bottom:10px;z-index:999;">
        <button type="button" name="button" class="btn btn-primary btn-sm" >Close</button>
    </div>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="margin-top:10px;">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
      </ol>
      <div class="carousel-inner" id="foto">
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="top:45px;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <div class="title-bar">
        <h5 style="padding-top: 30px;"  id="nama_krt"></h5>
        <h5 style="opacity: 0.6;" id="alamat"></h5>
    </div>
    <div  class="content">
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-6 col-form-label">Lat </label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="lat"></label>
            </div>
            <label for="inputEmail3" class="col-sm-6 col-form-label">Long </label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="long"></label>
            </div>
            <label for="inputEmail3" class="col-sm-6 col-form-label">Provinsi </label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="propinsi"></label>
            </div>
            <label for="inputEmail3" class="col-sm-6 col-form-label">Kabupaten </label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="kabupaten"></label>
            </div>
            <label for="inputEmail3" class="col-sm-6 col-form-label">Kecamatan </label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="kecamatan"></label>
            </div>
            <label for="inputEmail3" class="col-sm-6 col-form-label">Kelurahan</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="kelurahan"></label>
            </div>
            <label for="inputEmail3" class="col-sm-6 col-form-label">NIK KRT </label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="nomor_nik"></label>
            </div>
            <label for="inputEmail3" class="col-sm-6 col-form-label">No. KK KRT </label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="no_kk"></label>
            </div>
            <label for="inputEmail3" class="col-sm-6 col-form-label">Jenis Kelamin </label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="jenis_kelamin_krt"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Jumlah ART</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="jumlah_art"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Jumlah Keluarga</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="jumlah_keluarga"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Status Rumah Tangga</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="status_rumahtangga"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Apakah Mampu</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="apakah_mampu"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Tgl Interview</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="tgl_interview"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Durasi Interview</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="interview_duration_ms"></label>
            </div></br></br>
             
            <label for="inputPassword3" class="col-sm-6 col-form-label">Peserta KKS/KPS</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="status_kks"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Peserta KIS/PBI JKN</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="status_kis"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Peserta KIP/BSM</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="status_kip"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Peserta PKH</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="status_pkh"></label>
            </div>
            <label for="inputPassword3" class="col-sm-6 col-form-label">Peserta Raskin/Rastra</label>
            <div class="col-sm-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label" id="status_rastra"></label>
            </div></br></br>


          </div>
    </div>
</section>

<input type="hidden" id="base_url" value="<?php echo $base_url;?>">
<input type="hidden" id="base_photo_url" value="<?php echo $base_photo_url;?>">
<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
<script type='text/javascript' src='<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/leaflet/leaflet.js'></script>
 <script type='text/javascript' src='<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/leaflet/leaflet.markercluster.js'></script>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/markers.js"></script>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/maps.js"></script>
