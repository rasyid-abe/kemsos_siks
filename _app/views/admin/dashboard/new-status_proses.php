<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/select2.min.css">
<style>

/* .height-chart {height: 200px;} */
.card{
    margin-bottom: 10px;
}
.custom-table td{
    border:1px solid black;
    padding:5px;
}
.custom-table th{
    border:1px solid black;
    padding:5px;
}
</style>
<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php
                if ( isset( $cari ) ) {
                    ?>
                    <?php echo $cari;?>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
 <input type="hidden" id="base_url" value="<?php echo $base_url;?>">
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>PROGRES PUBLISH S/D MUSDES DATA PRELIST</h5>
            </div>
            <div class="card-body height-chart">
                <!-- <div id="progres_publish"></div> -->
                <table class="table table-xs">
                    <thead>
                        <tr>
                            <th rowspan="2" width="30%" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;">Keterangan Status</th>
                            <th colspan="2" style="vertical-align: middle;" class="text-center">Dalam Proses</th>
                            <th colspan="2" style="vertical-align: middle;"class="text-center">Selesai Proses</th>
                        </tr>
                        <tr>

                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody id="progress-publish">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Status Prelist Dalam Proses</h5>
            </div>
            <div class="card-body height-chart" style="height:368px;">
                <div id="chart-publish-musdes"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>PROGRES MUSDES DATA USULAN BARU</h5>
            </div>
            <div class="card-body height-chart">
                <!-- <div id="progres_survey"></div> -->
                <table class="table table-xs" >
                    <thead>
                        <tr>
                            <th rowspan="2" width="30%" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-left">Keterangan Status</th>
                            <th colspan="2" style="vertical-align: middle;" class="text-center">Dalam Proses</th>
                            <th colspan="2" style="vertical-align: middle;"class="text-center">Selesai Proses</th>
                        </tr>
                        <tr>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody id="progress-usulan-baru">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5></h5>
            </div>
            <div class="card-body height-chart">
              <div id="chart-musdes-ub"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>HASIL MUSYAWARAH DESA/KELURAHAN</h5>
            </div>
            <div class="card-body height-chart"> 
                <table class="table table-xs" id="hasil_musdes">
                    <tbody>
                    <tr>
                        <th colspan="4">Status Rumah Tangga Hasil Musdes/Muskel</th>
                    </tr> 
                    <tr>
                        <th colspan="4">Rekapitulasi Hasil Musdes/Muskel</th>
                    </tr>  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card task-card">
            <div class="card-header">
                <h5> </h5>
            </div>
            <div class="card-body height-chart" style="height:462px;">
                <div id="chart-status-musdes"></div>
                <div id="chart-rekap-musdes"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Progress Publish S/D Verval Data Prelist</h5>
            </div>
            <div class="card-body  " style="height:800px;"> 
                <table class="table table-xs" id="verval_valid">
                   <thead>
                        <tr>
                            <th rowspan="2" width="30%" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-left">Keterangan Status</th>
                            <th colspan="2" style="vertical-align: middle;" class="text-center">Dalam Proses</th>
                            <th colspan="2" style="vertical-align: middle;"class="text-center">Selesai Proses</th>
                        </tr>
                        <tr>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
                <h6>Prelist Awal Invalid Musdes</h6>
                <table class="table table-xs" id="verval_invalid">
                    <thead>
                        <tr>
                            <th rowspan="2" width="30%" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-left">Keterangan Status</th>
                            <th colspan="2" style="vertical-align: middle;" class="text-center">Dalam Proses</th>
                            <th colspan="2" style="vertical-align: middle;"class="text-center">Selesai Proses</th>
                        </tr>
                        <tr>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card task-card">
            <div class="card-header">
                <h5> </h5>
            </div>
            <div class="card-body  " style="height:800px;">
                <div id="chart-verval-valid"></div>
                <div id="chart-verval-invalid"></div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>PROGRESS SURVEY VERIVALI DATA PRELIST AKHIR</h5>
            </div>
            <div class="card-body height-chart"> 
                <table class="table table-xs">
                    <thead>
                        <tr>
                            <th rowspan="2" width="30%" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;">Keterangan Status</th>
                            <th colspan="2" style="vertical-align: middle;" class="text-center">Dalam Proses</th>
                            <th colspan="2" style="vertical-align: middle;"class="text-center">Selesai Proses</th>
                        </tr>
                        <tr>

                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr>
                            <td class="text-left ">0</td>
                            <td class="text-left ">Prelist Awal</td>
                            <td class="text-center ">12</td>
                            <td class="text-center ">12%</td>
                            <td class="text-center ">12</td>
                            <td class="text-center ">12%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card task-card">
            <div class="card-header">
                <h5></h5>
            </div>
            <div class="card-body height-chart">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>PRELIST AWAL INVALID MUSDES</h5>
            </div>
            <div class="card-body height-chart"> 
                <table class="table table-xs">
                    <thead>
                        <tr>
                            <th rowspan="2" width="30%" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;">Keterangan Status</th>
                            <th colspan="2" style="vertical-align: middle;" class="text-center">Dalam Proses</th>
                            <th colspan="2" style="vertical-align: middle;"class="text-center">Selesai Proses</th>
                        </tr>
                        <tr>

                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr>
                            <td class="text-left ">0</td>
                            <td class="text-left ">Prelist Awal</td>
                            <td class="text-center ">12</td>
                            <td class="text-center ">12%</td>
                            <td class="text-center ">12</td>
                            <td class="text-center ">12%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card task-card">
            <div class="card-header">
                <h5></h5>
            </div>
            <div class="card-body height-chart">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>HASIL VERIFIKASI DAN VALIDASI</h5>
            </div>
            <div class="card-body height-chart"> 
                <table class="table table-xs">
                        <tr>
                            <th colspan="4">Status Rumah Tangga Hasil Musdes/Muskel</th>
                        </tr>

                        <tr>
                            <td class="text-right ">Ditemukan</td>
                            <td class="text-left ">:</td>
                            <td class="text-center ">12</td>
                            <td class="text-center ">12</td>
                        </tr>
                        <tr>
                            <th colspan="4">Rekapitulasi Hasil Musdes/Muskel</th>
                        </tr>
                        <tr>
                            <td class="text-right ">Ditemukan</td>
                            <td class="text-left ">:</td>
                            <td class="text-center ">12</td>
                            <td class="text-center ">12</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card task-card">
            <div class="card-header">
                <h5> </h5>
            </div>
            <div class="card-body height-chart">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>DATA DALAM PENANGANAN KEMBALI KE SEBELUMNYA</h5>
            </div>
            <div class="card-body height-chart"> 
                <table class="table table-xs">


                        <tr>
                            <td class="text-left ">NO</td>
                            <td class="text-left ">KETERANGAN</td>
                            <td class="text-center ">TOTAL</td>
                        </tr>
                        <tr>
                            <td class="text-left ">2a</td>
                            <td class="text-left ">:</td>
                            <td class="text-center ">12</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card task-card">
            <div class="card-header">
                <h5> </h5>
            </div>
            <div class="card-body height-chart">
            </div>
        </div>
    </div>
</div> -->
<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/apexcharts.min.js"></script>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/dashboard-status-proses.js"></script>
