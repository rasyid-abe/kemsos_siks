<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/select2.min.css">
<style>
 th{
    text-align: center;
 }
 .text-right{
    text-align: right !important;
 }
</style>
<!-- [ Main Content ] start -->

 <input type="hidden" id="base_url" value="<?php echo $base_url;?>">
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
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Rekapitulasi Status Verivali</h5>
            </div>
            <div class="card-body">
                <div >
                    <div class="table-responsive">
                        <table class="table table-xs">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;" id="rekap_status_txt">Nama Wilayah</th>  
                                    <th style="vertical-align: middle;">Verivali Submit</th>
                                    <th style="vertical-align: middle;">Selesai Di cacah</th>
                                    <th style="vertical-align: middle;">rumah tangga <br>tidak ditemukan</th>
                                    <th style="vertical-align: middle;">rumah tangga <br>pindah / bangunan  <br> sudah tidak ditemukan</th> 
                                    <th style="vertical-align: middle;">bagian dari rumah<br> tangga di dokumen</th>   
                                    <th style="vertical-align: middle;">responden menolak</th>  
                                    <th style="vertical-align: middle;">data ganda</th>  
                                </tr> 
                            </thead>
                            <tbody id="tbl_rekap_status">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  

<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/rekap-status-verval.js"></script>

<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
