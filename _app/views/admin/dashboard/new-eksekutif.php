<?php
if ( isset( $extra_style ) ) {
    echo $extra_style;
}
?>
<style>
    .text-right{
        text-align: right !important;
    }

</style>
 <input type="hidden" id="base_url" value="<?php echo $base_url;?>">
<div class="card">
    <div class="card-body">
        <?php
        if ( isset( $cari ) ) {
            ?>
                <?php echo $cari;?>
            <?php
        }
        ?>
        <div id="response_message" style="display:none;"></div>
        <table id="gridview" style="display:none;"></table>
    </div>
</div>
<div class="row">
    <!-- start -->
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-blue order-card">
            <div class="card-body">
                <h6 class="text-white">Progres Musdes Hari Terakhir</h6>
                <h2 class="text-white" id="musdes_lastday">memuat ...</h2>
                <!-- <i class="card-icon feather icon-edit"></i> -->
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-blue order-card">
            <div class="card-body">
                <h6 class="text-white">Total Musdes s/d <?php echo convert_date_chart(date('Y-m-d')) ?></h6>
                <h2 class="text-white" id="musdes_now">memuat ...</h2>
                <!-- <i class="card-icon feather icon-server"></i> -->
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-red order-card">
            <div class="card-body">
                <h6 class="text-white">Progres Verivali Hari Terakhir</h6>
                <h2 class="text-white" id="verval_lastday">memuat ...</h2>
                <!-- <i class="card-icon feather icon-edit"></i> -->
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-red order-card">
            <div class="card-body">
                <h6 class="text-white">Total Verivali s/d <?php echo convert_date_chart(date('Y-m-d')) ?></h6>
                <h2 class="text-white" id="verval_now">memuat ...</h2>
                <!-- <i class="card-icon feather icon-server"></i> -->
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-green order-card">
            <div class="card-body">
                <h6 class="text-white">Progres Approval Hari Terakhir</h6>
                <h2 class="text-white" id="approval_lastday">memuat ...</h2>
                <!-- <i class="card-icon feather icon-edit"></i> -->
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-green order-card">
            <div class="card-body">
                <h6 class="text-white">Total Approval s/d <?php echo convert_date_chart(date('Y-m-d')) ?></h6>
                <h2 class="text-white" id="approval_now">memuat ...</h2>
                <!-- <i class="card-icon feather icon-server"></i> -->
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-yellow order-card">
            <div class="card-body">
                <h6 class="text-white">Progres Monev Hari Terakhir</h6>
                <h2 class="text-white" id="monev_lastday">memuat ...</h2>
                <!-- <i class="card-icon feather icon-edit"></i> -->
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-yellow order-card">
            <div class="card-body">
                <h6 class="text-white">Total Monev s/d <?php echo convert_date_chart(date('Y-m-d')) ?></h6>
                <h2 class="text-white" id="monev_now">memuat ...</h2>
                <!-- <i class="card-icon feather icon-server"></i> -->
            </div>
        </div>
    </div>
</div>

<div class="row" id="musdes">
    <div class="col-md-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_harian_musdes">Progress Harian Kegiatan Musdes Seluruh Indonesia</p>
                <div id="chart_harian_musdes"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_akumulasi_musdes">Progress Akumulasi Musdes Seluruh Indonesia</p>
                <div id="chart_akumulasi_musdes"></div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="verval">
    <div class="col-md-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_harian_verval">Progress Harian Kegiatan Verivali Seluruh Indonesia</p>
                <div id="chart_harian_verval"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_akumulasi_verval">Progress Akumulasi Verivali Seluruh Indonesia</p>
                <div id="chart_akumulasi_verval"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card" style="height: 425px;">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_rekap_wilayah">Rekapitulasi Prelist & Usulan Baru Seluruh Indonesia</p>
                <div id="chart_rekap_wilayah"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card" style="height: 425px;">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_total_rekap_wilayah">Rekapitulasi Prelist & Usulan Baru Seluruh Indonesia</p>
                <div id="chart_total_rekap_wilayah"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Rekapitulasi Musdes</h5>
            </div>
            <div class="card-body">
                <div >
                    <div class="table-responsive">
                        <table class="table table-xs">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="20%" style="vertical-align: middle;" id="musdes_area_txt">Provinsi</th>
                                    <th rowspan="2" style="vertical-align: middle;">Target Desa</th>
                                    <th colspan="3" style="vertical-align: middle;">Realisasi</th>
                                    <th  rowspan="2"  style="vertical-align: middle;">Target Prelist Awal</th>
                                    <th  rowspan="2" style="vertical-align: middle;">Ditemukan</th>
                                    <th rowspan="2" style="vertical-align: middle;">Tidak Ditemukan</th>
                                    <th rowspan="2" style="vertical-align: middle;">Data Ganda</th>
                                    <th rowspan="2" style="vertical-align: middle;">Usulan Baru</th>
                                    <th rowspan="2" style="vertical-align: middle;">Prelist Akhir</th>
                                    <th rowspan="2" style="vertical-align: middle;">%</th>
                                </tr>
                                <tr>
                                    <th class="text-right head_table">Total</th>
                                    <th class="text-right head_table">%</th>
                                    <th class="text-right head_table">&nbsp;</th>  
                                </tr>
                            </thead>
                            <tbody id="tbl_rekapitulasi_musdes">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Rekapitulasi Prelist dan Usulan Baru</h5>
            </div>
            <div class="card-body">
                <div id="tbl_rekapitulasi_verval">
                    <div class="table-responsive"> 
                        <table class="table table-xs" id="rekap_verval">
                            <thead>
                                <tr>
                                    <th>Kel/Desa</th>
                                    <th >Prelist Akhir</th>  
                                    <th>Verivali Submit</th>
                                    <th>Approval Pengawas</th>
                                    <th>Approval Korkab</th> 
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/apexcharts.min.js"></script>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/dashboard-eksekutif.js"></script>
