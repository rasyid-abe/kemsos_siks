<?php
if ( isset( $extra_style ) ) {
    echo $extra_style;
}
?>
<div class="row">
    <!-- start -->
    <div class="col-md-12 col-xl-4">
        <div class="card bg-c-blue order-card">
            <div class="card-body">
                <h6 class="text-white">Progres Verivali Hari Terakhir</h6>
                <h2 class="text-white" id="verval_lastday">memuat ...</h2>
                <i class="card-icon feather icon-edit"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card bg-c-green order-card">
            <div class="card-body">
                <h6 class="text-white">Total Verivali s/d <?php echo convert_date_chart(date('Y-m-d')) ?></h6>
                <h2 class="text-white" id="verval_now">memuat ...</h2>
                <i class="card-icon feather icon-server"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card bg-c-red order-card">
            <div class="card-body">
                <h6 class="text-white">Presentasi Verivali s/d <?php echo convert_date_chart(date('Y-m-d')) ?></h6>
                <h2 class="text-white" id="precentage">memuat ...</h2>
                <i class="card-icon feather icon-bar-chart"></i>
            </div>
        </div>
    </div>
    <!-- end -->
</div>

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
    <div class="col-md-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_daily_verval_chart">memuat ...</p>
                <div id="daily_verval_chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_akumulasi_verval_chart">memuat ...</p>
                <div id="akumulasi_verval_chart"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <p class="text-muted  text-center m-b-10" id="title_chart_rekap_prelist_usulan">memuat ...</p>
                <div id="chart_rekap_prelist_usulan"></div>
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
                <div id="tbl_rekapitulasi_musdes"></div>
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
                <div id="tbl_rekapitulasi_prelist_usulan"></div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] start -->

<!-- [ Main Content ] end -->
<script type="text/javascript">
$(document).ready(function() {

    get_data_chart(['','','','']);

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    }

    <?php if ( isset( $cari ) ) { ?>
        $('#panel_header').on( 'click', function(){
            $('.search-arrow').toggleClass('fa-caret-square-right fa-caret-square-down')
            $('#search_body').slideToggle( "slow", function() {
            });
            $('#search_footer').slideToggle( "slow", function() {
            });
        });
    <?php } ?>

    $( "button#cari" ).on( "click", function(){
        $("#loader").modal("show");

        var area =[
            $( "#select-propinsi ").val(),
            $( "#select-kabupaten ").val(),
            $( "#select-kecamatan ").val(),
            $( "#select-kelurahan ").val()
        ];

        get_data_chart(area);
    });

    function get_data_chart(area) {
        $.ajax({
            url: '<?php echo base_url() ?>dashboard/eksekutif/data_content',
            type: 'post',
            dataType: 'json',
            // async: false,
            data: {'area' : area},
            success: function(data){
                $('#verval_lastday').html(formatNumber(data.daily_verval.slice(-1)));
                $('#verval_now').html(formatNumber(data.akumulasi_verval.slice(-1)));
                var percent_all = parseInt(data.akumulasi_verval.slice(-1)) / parseInt(data.target_all) * 100;
                $('#precentage').html(percent_all.toFixed(2) + ' %');

                $('#title_daily_verval_chart').html('Progress Harian Kegiatan Verivali ' + data.title_chart);
                $('#title_akumulasi_verval_chart').html('Progress Akumulasi ' + data.title_chart);
                $('#title_chart_rekap_prelist_usulan').html('Rekapitulasi Prelist & Usulan Baru ' + data.title_chart);

                extract_chart(data, area);
                extract_rekapitulasi_musdes(data.tbl_musdes_result, area);
                extract_prelist_usulan(data.data_prelist_usulan, area);

                $("#loader").modal("hide");
            },
            error: function(error){
                console.log("Error:");
                console.log(error);
            }
        });
    }

    function extract_chart(data, area) {

        // Proses Chart Prelist Musdes
        var prelist_musdes = data.data_prelist_usulan;

        var wilayah_prelist_usulan = [];
        var realisasi_prelist_usulan = [];
        var target_prelist_usulan = [];
        $.each(prelist_musdes, function(i, val) {
            wilayah_prelist_usulan.push(val.nama_area);
            result_real = val.res_realisasi != null ? val.res_realisasi : 0;
            realisasi_prelist_usulan.push(result_real);
            target_prelist_usulan.push(val.res_target);
        })


        if ((area[0] < 1) && (area[1] < 1) && (area[2] < 1) && (area[3] < 1)) {
            $('#daily_verval_chart').html('<div id="daily_verval_chart_prov"></div>')
            $('#akumulasi_verval_chart').html('<div id="akumulasi_verval_chart_prov"></div>')
            $('#chart_rekap_prelist_usulan').html('<div id="rekap_prelist_usulan_prov"></div>')
            var source_daily_verval = document.querySelector("#daily_verval_chart_prov");
            var source_akumulasi_verval = document.querySelector("#akumulasi_verval_chart_prov");
            var source_rekap_prelist_usulan = document.querySelector("#rekap_prelist_usulan_prov");

        } else if ((area[0] > 0) && (area[1] < 1) && (area[2] < 1) && (area[3] < 1)) {
            $('#daily_verval_chart').html('<div id="daily_verval_chart_kab"></div>')
            $('#akumulasi_verval_chart').html('<div id="akumulasi_verval_chart_kab"></div>')
            $('#chart_rekap_prelist_usulan').html('<div id="rekap_prelist_usulan_kab"></div>')
            var source_daily_verval = document.querySelector("#daily_verval_chart_kab");
            var source_akumulasi_verval = document.querySelector("#akumulasi_verval_chart_kab");
            var source_rekap_prelist_usulan = document.querySelector("#rekap_prelist_usulan_kab");

        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] < 1) && (area[3] < 1)) {
            $('#daily_verval_chart').html('<div id="daily_verval_chart_kec"></div>')
            $('#akumulasi_verval_chart').html('<div id="akumulasi_verval_chart_kec"></div>')
            $('#chart_rekap_prelist_usulan').html('<div id="rekap_prelist_usulan_kec"></div>')
            var source_daily_verval = document.querySelector("#daily_verval_chart_kec");
            var source_akumulasi_verval = document.querySelector("#akumulasi_verval_chart_kec");
            var source_rekap_prelist_usulan = document.querySelector("#rekap_prelist_usulan_kec");

        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] > 0) && (area[3] < 1)) {
            $('#daily_verval_chart').html('<div id="daily_verval_chart_kel"></div>')
            $('#akumulasi_verval_chart').html('<div id="akumulasi_verval_chart_kel"></div>')
            $('#chart_rekap_prelist_usulan').html('<div id="rekap_prelist_usulan_kel"></div>')
            var source_daily_verval = document.querySelector("#daily_verval_chart_kel");
            var source_akumulasi_verval = document.querySelector("#akumulasi_verval_chart_kel");
            var source_rekap_prelist_usulan = document.querySelector("#rekap_prelist_usulan_kel");
        }

        setTimeout(function() {
            $(function() {
                var options = {
                    chart: {
                        height: 350,
                        type: 'area',
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ["lightgreen", "#ff5252"],
                    series: [{
                        name: 'Realisasi',
                        data: data.daily_verval
                    // }, {
                    //     name: 'series2',
                    //     data: [11, 32, 45, 32, 34, 52, 41]
                    }],

                    xaxis: {
                        type: 'date',
                        categories: data.date_chart,
                    },
                    tooltip: {
                        // x: {
                        //     format: 'dd m Y'
                        // },
                    }
                }

                var chart = new ApexCharts(
                    source_daily_verval,
                    options
                );

                chart.render();
            });

            $(function() {
                var options = {
                    chart: {
                        height: 350,
                        type: 'area',
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ["blue", "purple"],
                    series: [{
                        name: 'Realisasi',
                        data: data.akumulasi_verval
                    }, {
                        name: 'Approval',
                        data: data.akumulasi_approval
                    }],

                    xaxis: {
                        type: 'date',
                        categories: data.date_chart,
                    },
                    tooltip: {
                        // x: {
                        //     format: 'dd/MM/yy HH:mm'
                        // },
                    }
                }

                var chart = new ApexCharts(
                source_akumulasi_verval,
                options
                );

                chart.render();
            });

            $(function() {
            var options = {
                chart: {
                    height: 'auto',
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                colors: ["#4680ff", "#0e9e4a"],
                // dataLabels: {
                //     enabled: true,
                //     offsetX: -6,
                //     style: {
                //         fontSize: '12px',
                //         colors: ['#fff']
                //     }
                // },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                series: [{
                    name: 'Realisasi',
                    data: realisasi_prelist_usulan
                }, {
                    name: 'Target',
                    data: target_prelist_usulan
                }],
                xaxis: {
                    categories: wilayah_prelist_usulan,
                },

            }
            var chart = new ApexCharts(
                source_rekap_prelist_usulan,
                options
            );
            chart.render();
        });

        }, 700);
    }

    function extract_rekapitulasi_musdes(data, area) {
        if ((area[0] < 1) && (area[1] < 1) && (area[2] < 1) && (area[3] < 1)) {
            var title_area = 'Provinsi';
        } else if ((area[0] > 0) && (area[1] < 1) && (area[2] < 1) && (area[3] < 1)) {
            var title_area = 'Kabupaten/Kota';
        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] < 1) && (area[3] < 1)) {
            var title_area = 'Kecamatan';
        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] > 0) && (area[3] < 1)) {
            var title_area = 'Kelurahan';
        }

        var total_desa = 0;
        var total_desa_realisasi = 0;
        var total_prelist = 0;
        var total_prelist_realisasi = 0;
        var body = '';
        $.each(data, function(i, val) {

            percent_target_desa = val.tot_realisasi_desa / val.tot_desa * 100;
            warning_desa = val.tot_realisasi_desa < val.tot_desa ? 'background-color: red;' : 'background-color: green;';

            percent_prelist = val.realisasi / val.prelist * 100;
            warning_prelist = val.realisasi < val.prelist ? 'background-color: red;' : 'background-color: green;'

            body += `
                <tr>
                    <td>${val.nama_area}</td>
                    <td>${formatNumber(val.tot_desa)}</td>
                    <td>${formatNumber(val.tot_realisasi_desa)}</td>
                    <td>${percent_target_desa.toFixed(2)} %</td>
                    <td class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${warning_desa}"></div></td>
                    <td>${formatNumber(val.prelist)}</td>
                    <td>${formatNumber(val.realisasi)}</td>
                    <td>${percent_prelist.toFixed(2)} %</td>
                    <td class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${warning_prelist}"></div></td>
                </tr>
            `;

            total_desa += val.tot_desa;
            total_desa_realisasi += val.tot_realisasi_desa;
            total_prelist += val.prelist;
            total_prelist_realisasi += val.realisasi;

        });

        percent_total_desa = total_desa_realisasi / total_desa * 100;
        warning_total_desa = total_desa_realisasi < total_desa ? 'background-color: red;' : 'background-color: green;'

        percent_total_prelist = total_prelist_realisasi / total_prelist * 100;
        warning_total_prelist = total_prelist_realisasi < total_prelist ? 'background-color: red;' : 'background-color: green;'

        var content = `
        <div class="table-responsive">
            <table class="table table-xs">
                <thead>
                    <tr>
                        <th rowspan="2" width=30% style="vertical-align: middle;">${title_area}</th>
                        <th rowspan="2" style="vertical-align: middle;">Target Desa</th>
                        <th colspan="3" style="vertical-align: middle;">Realisasi</th>
                        <th rowspan="2" style="vertical-align: middle;">Target Prelist</th>
                        <th colspan="3" style="vertical-align: middle;">Realisasi</th>
                    </tr>
                    <tr>
                        <th class="text-right head_table">Total</th>
                        <th class="text-right head_table">%</th>
                        <th class="text-right head_table">&nbsp;</th>
                        <th class="text-right head_table">Total</th>
                        <th class="text-right head_table">%</th>
                        <th class="text-right head_table">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    ${body}
                </tbody>
                <thead>
    				<tr>
        				<th>Total</th>
        				<th>${formatNumber(total_desa)}</th>
        				<th>${formatNumber(total_desa_realisasi)}</th>
                        <th>${percent_total_desa.toFixed(2)} %</th>
        				<th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${warning_total_desa}"></div></th>
        				<th>${formatNumber(total_prelist)}</th>
        				<th>${formatNumber(total_prelist_realisasi)}</th>
        				<th>${percent_total_prelist.toFixed(2)} %</th>
                        <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${warning_total_prelist}"></div></th>
    				</tr>
				</thead>
            </table>
        </div>
        `;

        $('#tbl_rekapitulasi_musdes').html(content);
    }

    function extract_prelist_usulan(data, area) {

        if ((area[0] < 1) && (area[1] < 1) && (area[2] < 1) && (area[3] < 1)) {

            var body = '';
            var total_kab = 0;
			var total_kec = 0;
			var total_desa = 0;
			var total_target = 0;
			var total_prelist = 0;
			var total_usulan = 0;
			var total_realisasi = 0;
			var total_percent = 0;
			var total_warning = '';

            $.each(data, function(i, val) {
                percent_pre_us = val.res_realisasi / val.res_target * 100;
                warning =  val.res_realisasi < val.res_target ? 'background-color: red;' : 'background-color: green;';

                body +=`
                    <tr>
                        <td>${val.nama_area}</td>
                        <td>${formatNumber(val.tot_kabupaten)}</td>
                        <td>${formatNumber(val.tot_kecamatan)}</td>
                        <td>${formatNumber(val.tot_desa)}</td>
                        <td>${formatNumber(val.res_target)}</td>
                        <td>${formatNumber(val.res_prelist != null ? val.res_prelist : 0)}</td>
                        <td>${formatNumber(val.res_usulan != null ? val.res_usulan : 0)}</td>
                        <td>${formatNumber(val.res_realisasi != null ? val.res_realisasi : 0)}</td>
                        <td>${percent_pre_us.toFixed(2)} %</td>
                        <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${warning}"></div></th>
                    </tr>
                `;

                total_kab += val.tot_kabupaten;
                total_kec += val.tot_kecamatan;
                total_desa += val.tot_desa;
                total_target += val.res_target;
                total_prelist += val.res_prelist != null ? val.res_prelist : 0;
                total_usulan += val.res_usulan != null ? val.res_usulan : 0;
                total_realisasi += val.res_realisasi != null ? val.res_realisasi : 0;
            });

            total_percent += total_realisasi / total_target * 100;
            total_warning += total_realisasi < total_target ? 'background-color: red;' : 'background-color: green;';

            var title_head = `
                <th rowspan="2">Provinsi</th>
                <th rowspan="2">Kab</th>
                <th rowspan="2">Kec</th>
                <th rowspan="2">Kel</th>
            `;
            var val_foot = `
                <th>${formatNumber(total_kab)}</th>
                <th>${formatNumber(total_kec)}</th>
                <th>${formatNumber(total_desa)}</th>
                <th>${formatNumber(total_target)}</th>
                <th>${formatNumber(total_prelist)}</th>
                <th>${formatNumber(total_usulan)}</th>
                <th>${formatNumber(total_realisasi)}</th>
                <th>${total_percent.toFixed(2)} %</th>
                <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${total_warning}"></div></th>
            `;

        } else if ((area[0] > 0) && (area[1] < 1) && (area[2] < 1) && (area[3] < 1)) {

            var body = '';
			var total_kec = 0;
			var total_desa = 0;
			var total_target = 0;
			var total_prelist = 0;
			var total_usulan = 0;
			var total_realisasi = 0;
			var total_percent = 0;
			var total_warning = '';

            $.each(data, function(i, val) {
                percent_pre_us = val.res_realisasi / val.res_target * 100;
                warning =  val.res_realisasi < val.res_target ? 'background-color: red;' : 'background-color: green;';

                body +=`
                    <tr>
                        <td>${val.nama_area}</td>
                        <td>${formatNumber(val.tot_kecamatan)}</td>
                        <td>${formatNumber(val.tot_desa)}</td>
                        <td>${formatNumber(val.res_target)}</td>
                        <td>${formatNumber(val.res_prelist != null ? val.res_prelist : 0)}</td>
                        <td>${formatNumber(val.res_usulan != null ? val.res_usulan : 0)}</td>
                        <td>${formatNumber(val.res_realisasi != null ? val.res_realisasi : 0)}</td>
                        <td>${percent_pre_us.toFixed(2)} %</td>
                        <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${warning}"></div></th>
                    </tr>
                `;

                total_kec += val.tot_kecamatan;
                total_desa += val.tot_desa;
                total_target += val.res_target;
                total_prelist += val.res_prelist != null ? val.res_prelist : 0;
                total_usulan += val.res_usulan != null ? val.res_usulan : 0;
                total_realisasi += val.res_realisasi != null ? val.res_realisasi : 0;
            });

            total_percent += total_realisasi / total_target * 100;
            total_warning += total_realisasi < total_target ? 'background-color: red;' : 'background-color: green;';

            var title_head = `
                <th rowspan="2">Kabupaten/Kota</th>
                <th rowspan="2">Kec</th>
                <th rowspan="2">Kel</th>
            `;
            var val_foot = `
                <th>${formatNumber(total_kec)}</th>
                <th>${formatNumber(total_desa)}</th>
                <th>${formatNumber(total_target)}</th>
                <th>${formatNumber(total_prelist)}</th>
                <th>${formatNumber(total_usulan)}</th>
                <th>${formatNumber(total_realisasi)}</th>
                <th>${total_percent.toFixed(2)} %</th>
                <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${total_warning}"></div></th>
            `;

        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] < 1) && (area[3] < 1)) {

            var body = '';
            var total_desa = 0;
            var total_target = 0;
            var total_prelist = 0;
            var total_usulan = 0;
            var total_realisasi = 0;
            var total_percent = 0;
            var total_warning = '';

            $.each(data, function(i, val) {
                percent_pre_us = val.res_realisasi / val.res_target * 100;
                warning =  val.res_realisasi < val.res_target ? 'background-color: red;' : 'background-color: green;';

                body +=`
                    <tr>
                        <td>${val.nama_area}</td>
                        <td>${formatNumber(val.tot_desa)}</td>
                        <td>${formatNumber(val.res_target)}</td>
                        <td>${formatNumber(val.res_prelist != null ? val.res_prelist : 0)}</td>
                        <td>${formatNumber(val.res_usulan != null ? val.res_usulan : 0)}</td>
                        <td>${formatNumber(val.res_realisasi != null ? val.res_realisasi : 0)}</td>
                        <td>${percent_pre_us.toFixed(2)} %</td>
                        <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${warning}"></div></th>
                    </tr>
                `;

                total_desa += val.tot_desa;
                total_target += val.res_target;
                total_prelist += val.res_prelist != null ? val.res_prelist : 0;
                total_usulan += val.res_usulan != null ? val.res_usulan : 0;
                total_realisasi += val.res_realisasi != null ? val.res_realisasi : 0;
            });

            total_percent += total_realisasi / total_target * 100;
            total_warning += total_realisasi < total_target ? 'background-color: red;' : 'background-color: green;';

            var title_head = `
                <th rowspan="2">Kecamatan</th>
                <th rowspan="2">Kel</th>
            `;
            var val_foot = `
                <th>${formatNumber(total_desa)}</th>
                <th>${formatNumber(total_target)}</th>
                <th>${formatNumber(total_prelist)}</th>
                <th>${formatNumber(total_usulan)}</th>
                <th>${formatNumber(total_realisasi)}</th>
                <th>${total_percent.toFixed(2)} %</th>
                <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${total_warning}"></div></th>
            `;

        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] > 0) && (area[3] < 1)) {

            var body = '';
            var total_target = 0;
            var total_prelist = 0;
            var total_usulan = 0;
            var total_realisasi = 0;
            var total_percent = 0;
            var total_warning = '';

            $.each(data, function(i, val) {
                percent_pre_us = val.res_realisasi / val.res_target * 100;
                warning =  val.res_realisasi < val.res_target ? 'background-color: red;' : 'background-color: green;';

                body +=`
                <tr>
                <td>${val.nama_area}</td>
                <td>${formatNumber(val.res_target)}</td>
                <td>${formatNumber(val.res_prelist != null ? val.res_prelist : 0)}</td>
                <td>${formatNumber(val.res_usulan != null ? val.res_usulan : 0)}</td>
                <td>${formatNumber(val.res_realisasi != null ? val.res_realisasi : 0)}</td>
                <td>${percent_pre_us.toFixed(2)} %</td>
                <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${warning}"></div></th>
                </tr>
                `;

                total_target += val.res_target;
                total_prelist += val.res_prelist != null ? val.res_prelist : 0;
                total_usulan += val.res_usulan != null ? val.res_usulan : 0;
                total_realisasi += val.res_realisasi != null ? val.res_realisasi : 0;
            });

            total_percent += total_realisasi / total_target * 100;
            total_warning += total_realisasi < total_target ? 'background-color: red;' : 'background-color: green;';

            var title_head = `
            <th rowspan="2">Kecamatan</th>
            `;
            var val_foot = `
            <th>${formatNumber(total_target)}</th>
            <th>${formatNumber(total_prelist)}</th>
            <th>${formatNumber(total_usulan)}</th>
            <th>${formatNumber(total_realisasi)}</th>
            <th>${total_percent.toFixed(2)} %</th>
            <th class="rowRight" style="vertical-align: middle;"><div style = "width: 10px; height: 10px; border-radius: 50%; ${total_warning}"></div></th>
            `;

        }

        var content = `
        <div class="table-responsive">
            <table class="table table-xs">
                <thead>
                    <tr>
                        ${title_head}
                        <th rowspan="2">Target</th>
                        <th colspan="5">Realisasi</th>
                    </tr>
                    <tr>
                        <th>Prelist</th>
                        <th>Usulan Baru</th>
                        <th>Total</th>
                        <th>%</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                ${body}
                </tbody>
                <thead>
                    <tr>
                        <th>Total</th>
                        ${val_foot}
                    </tr>
                </thead>
            </table>
        </div>
        `;

        $('#tbl_rekapitulasi_prelist_usulan').html(content);
    }

});
</script>
<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/apexcharts.min.js"></script>
