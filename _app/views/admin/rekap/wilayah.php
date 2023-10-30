<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/select2.min.css">
<style>

.height-chart {height: 350px;}
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
                <h5>Rekapitulasi Wilayah</h5>
            </div>
            <div class="card-body">
                <div >
                    <div class="table-responsive">
                        <table class="table table-xs">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;" id="rekap_txt">Propinsi</th>  
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-00-black.png"></th>
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-01-gray.png"></th>
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-02-brown.png"></th>
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-02a-red-white.png"></th>
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-03-maroon.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-03a-red-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-04-orange.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-04a-red-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-05-yellow.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-05a-red-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-06-green.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-06a-green-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-07-brown.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-07a-red-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-08-maroon.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-08a-red-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-09-orange.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-09a-red-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-10-yellow.png"></th>  
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-10a-red-white.png"></th>  
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-11-green.png"></th>  
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-11a-red-white.png"></th>  
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-12-blue.png"></th>  
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-12a-red-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-13-purple.png"></th>  
                                   <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-13a-red-white.png"></th> 
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-13b-red-white.png"></th>
                                    <th style="vertical-align: middle;"><img src="<?php echo base_url();?>assets/style/icon-status/hex-14-pink.png"></th>  
                                </tr> 
                            </thead>
                            <tbody id="tbl_rekap_wilayah">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  

<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/rekap-wilayah.js"></script>

<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
