<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/select2.min.css">
<style>

.height-chart {height: 350px;}
</style>
<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php
                if ( isset( $cari ) ) {
                    ?>
                    <div id="panel_search" class="card">
                        <div id="panel_header" class="card-header bg-primary"><i class="fa fa-search"></i>&nbsp;Pencarian <i class="search-arrow fa fa-caret-square-right" style="float: right"></i></div>
                        <div id="search_body" class="card-body" style="display: none;">
                            <?php echo $cari;?>
                        </div>
                        <div id="search_footer" class="card-footer text-right" style="display: none;">
                            <button type="button" id="cari" class="btn btn-info btn-sm"><i class="fa fa-search"></i>&nbsp;Cari</button>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>PROGRES PUBLISH S/D MUSDES DATA PRELIST</h5>
            </div>
            <div class="card-body height-chart">
                <div id="progres_publish"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>STATUS RUTA HASIL MUSDES/MUSKEL</h5>
            </div>
            <div class="card-body height-chart">
                <div id="status_ruta_musdes" style="width:100%"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>PROGRES SURVEY VERIVALI DATA PRELIST AKHIR</h5>
            </div>
            <div class="card-body height-chart">
                <div id="progres_survey"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>STATUS RUTA HASIL VERVAL</h5>
            </div>
            <div class="card-body height-chart">
                <div id="status_ruta_verval" style="width:100%"></div>
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
                <div id="prelist_invalid"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card task-card">
            <div class="card-header">
                <h5>PROGRES MUSDES DATA USULAN BARU</h5>
            </div>
            <div class="card-body height-chart">
                <ul class="list-unstyled task-list">
                    <li>
                        <i class="feather icon-check f-w-600 task-icon bg-c-green"></i>
                        <p class="m-b-5">Status 5</p>
                        <h6>Prelist SELESAI MUSDES / MUSKEL</h6>
                        <h6 id="proses_5">Proses : </h6>
                        <h6 id="selesai_5">Selesai : </h6>
                    </li>
                    <li>
                        <i class="task-icon bg-c-blue"></i>
                        <p class="m-b-5">Status 6</p>
                        <h6>USULAN BARU Hasil Musdes</h6>
                        <h6 id="proses_6">Proses : </h6>
                        <h6 id="selesai_6">Selesai : </h6>
                        <h6>&nbsp;</h6>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>DATA DALAM PENANGANAN KEMBALI PROSES KE SEBELUMNYA</h5>
            </div>
            <div class="card-body">
                <div id="penangangan_kembali"></div>
            </div>
        </div>
    </div>

</div>

<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/apexcharts.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    setTimeout(function() {
        $(function() {
            //status_ruta_verval
            $(function() {
                var options = {
                    chart: {
                        height: 280,
                        type: 'donut',
                    },
                    series: [44, 55, 41, 17, 15],
                    colors: ["#4680ff", "#0e9e4a", "#00acc1", "#ffba57", "#ff5252"],
                    legend: {
                        show: true,
                        position: 'bottom',
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '45%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true
                                    },
                                    value: {
                                        show: true
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        dropShadow: {
                            enabled: false,
                        }
                    },
                    responsive: [{
                        breakpoint: 300,
                        options: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                }
                var chart = new ApexCharts(
                    document.querySelector("#status_ruta_verval"),
                    options
                );
                chart.render();
            });

            //status_ruta_musdes
            $(function() {
                var options = {
                    chart: {
                        height: 275,
                        type: 'pie',
                    },
                    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                    series: [44, 55, 13, 43, 22],
                    colors: ["#4680ff", "#0e9e4a", "#00acc1", "#ffba57", "#ff5252"],
                    legend: {
                        show: true,
                        position: 'bottom',
                    },
                    dataLabels: {
                        enabled: true,
                        dropShadow: {
                            enabled: false,
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                }
                var chart = new ApexCharts(
                    document.querySelector("#status_ruta_musdes"),
                    options
                );
                chart.render();
            });

            //prelist_invalid
            $(function() {
                var options = {
                    chart: {
                        height: 280,
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
                    dataLabels: {
                        enabled: true,
                        offsetX: -6,
                        style: {
                            fontSize: '12px',
                            colors: ['#fff']
                        }
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ['#fff']
                    },
                    series: [{
                        data: [44, 55, 41, 64, 22, 43, 21]
                    }],
                    xaxis: {
                        categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
                    },

                }
                var chart = new ApexCharts(
                    document.querySelector("#prelist_invalid"),
                    options
                );
                chart.render();
            });

            //penangangan_kembali
            $(function() {
                var options = {
                    chart: {
                        height: 280,
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
                    colors: ["red"],
                    dataLabels: {
                        enabled: true,
                        offsetX: -6,
                        style: {
                            fontSize: '12px',
                            colors: ['#fff']
                        }
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ['#fff']
                    },
                    series: [{
                        data: [44, 55, 41, 64, 22, 43, 21]
                    }],
                    xaxis: {
                        categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
                    },

                }
                var chart = new ApexCharts(
                    document.querySelector("#penangangan_kembali"),
                    options
                );
                chart.render();
            });

            //progres_publish
            $(function() {
                var options = {
                    chart: {
                        height: 280,
                        type: 'bar',
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    colors: ["#4680ff", "#0e9e4a", "#ffba57", "#ff5252"],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                        },
                    },
                    series: [{
                        name: 'PRODUCT A',
                        data: [44, 55, 41, 67, 22, 43]
                    }, {
                        name: 'PRODUCT B',
                        data: [13, 23, 20, 8, 13, 27]
                    }, {
                        name: 'PRODUCT C',
                        data: [11, 17, 15, 15, 21, 14]
                    }, {
                        name: 'PRODUCT D',
                        data: [21, 7, 25, 13, 22, 8]
                    }],
                    xaxis: {
                        type: 'datetime',
                        categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT', '01/05/2011 GMT', '01/06/2011 GMT'],
                    },
                    legend: {
                        position: 'right',
                        offsetY: 40
                    },
                    fill: {
                        opacity: 1
                    },
                }
                var chart = new ApexCharts(
                    document.querySelector("#progres_publish"),
                    options
                );
                chart.render();
            });

            //progres_survey
            $(function() {
                var options = {
                    chart: {
                        height: 280,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ["#0e9e4a", "#4680ff", "#ff5252"],
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    series: [{
                        name: 'Net Profit',
                        data: [44, 55, 57, 56, 61, 58, 63]
                    }, {
                        name: 'Revenue',
                        data: [76, 85, 101, 98, 87, 105, 91]
                    }, {
                        name: 'Free Cash Flow',
                        data: [35, 41, 36, 26, 45, 48, 52]
                    }],
                    xaxis: {
                        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                    },
                    yaxis: {
                        title: {
                            text: '$ (thousands)'
                        }
                    },
                    fill: {
                        opacity: 1

                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "$ " + val + " thousands"
                            }
                        }
                    }
                }
                var chart = new ApexCharts(
                    document.querySelector("#progres_survey"),
                    options
                );
                chart.render();
            });
        })
    })

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
            url: '<?php echo base_url() ?>dashboard/status_proses/get_data',
            type: 'post',
            dataType: 'json',
            data: {'area' : area},
            success: function(data){
                $('#proses_5').html('Prosess : ' + data.progres_usulan_baru.proses_5);
                $('#selesai_5').html('Selesai : ' + data.progres_usulan_baru.selesai_5);
                $('#proses_6').html('Prosess : ' + data.progres_usulan_baru.proses_6);
                $('#selesai_6').html('Selesai : ' + data.progres_usulan_baru.selesai_6);

                extract_chart(data, area);
            },
            error: function(error){
                console.log("Error:");
                console.log(error);
            }
        });
    }

    function extract_chart(data, area) {
        console.log(data);
        var data_progres_publish = data.chart_progres_publish;
        var data_progres_verval = data.chart_progres_verval;
        var data_progres_invalid_musdes = data.chart_invalid_musdes;
        var data_penanganan_kembali = data.chart_penanganan_kembali;
        var data_musdes = data.chart_musdes;
        var data_verval = data.chart_verval;

        if ((area[0] < 1) && (area[1] < 1) && (area[2] < 1) && (area[3] < 1)) {
            $('#progres_publish').html('<div id="progres_publish_all"></div>');
            var source_progres_publish = document.querySelector("#progres_publish_all");
            $('#progres_survey').html('<div id="progres_survey_all"></div>');
            var source_progres_survey = document.querySelector("#progres_survey_all");
            $('#prelist_invalid').html('<div id="prelist_invalid_all"></div>');
            var source_prelist_invalid = document.querySelector("#prelist_invalid_all");
            $('#penangangan_kembali').html('<div id="penangangan_kembali_all"></div>');
            var source_penangangan_kembali = document.querySelector("#penangangan_kembali_all");
            $('#status_ruta_musdes').html('<div id="status_ruta_musdes_all"></div>');
            var source_status_ruta_musdes = document.querySelector("#status_ruta_musdes_all");
            $('#status_ruta_verval').html('<div id="status_ruta_verval_all"></div>');
            var source_status_ruta_verval = document.querySelector("#status_ruta_verval_all");

        } else if ((area[0] > 0) && (area[1] < 1) && (area[2] < 1) && (area[3] < 1)) {
            $('#progres_publish').html('<div id="progres_publish_prov"></div>');
            var source_progres_publish = document.querySelector("#progres_publish_prov");
            $('#progres_survey').html('<div id="progres_survey_prov"></div>');
            var source_progres_survey = document.querySelector("#progres_survey_prov");
            $('#prelist_invalid').html('<div id="prelist_invalid_prov"></div>');
            var source_prelist_invalid = document.querySelector("#prelist_invalid_prov");
            $('#penangangan_kembali').html('<div id="penangangan_kembali_prov"></div>');
            var source_penangangan_kembali = document.querySelector("#penangangan_kembali_prov");
            $('#status_ruta_musdes').html('<div id="status_ruta_musdes_prov"></div>');
            var source_status_ruta_musdes = document.querySelector("#status_ruta_musdes_prov");
            $('#status_ruta_verval').html('<div id="status_ruta_verval_prov"></div>');
            var source_status_ruta_verval = document.querySelector("#status_ruta_verval_prov");

        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] < 1) && (area[3] < 1)) {
            $('#progres_publish').html('<div id="progres_publish_kab"></div>');
            var source_progres_publish = document.querySelector("#progres_publish_kab");
            $('#progres_survey').html('<div id="progres_survey_kab"></div>');
            var source_progres_survey = document.querySelector("#progres_survey_kab");
            $('#prelist_invalid').html('<div id="prelist_invalid_kab"></div>');
            var source_prelist_invalid = document.querySelector("#prelist_invalid_kab");
            $('#penangangan_kembali').html('<div id="penangangan_kembali_kab"></div>');
            var source_penangangan_kembali = document.querySelector("#penangangan_kembali_kab");
            $('#status_ruta_musdes').html('<div id="status_ruta_musdes_kab"></div>');
            var source_status_ruta_musdes = document.querySelector("#status_ruta_musdes_kab");
            $('#status_ruta_verval').html('<div id="status_ruta_verval_kab"></div>');
            var source_status_ruta_verval = document.querySelector("#status_ruta_verval_kab");

        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] > 0) && (area[3] < 1)) {
            $('#progres_publish').html('<div id="progres_publish_kec"></div>');
            var source_progres_publish = document.querySelector("#progres_publish_kec");
            $('#progres_survey').html('<div id="progres_survey_kec"></div>');
            var source_progres_survey = document.querySelector("#progres_survey_kec");
            $('#prelist_invalid').html('<div id="prelist_invalid_kec"></div>');
            var source_prelist_invalid = document.querySelector("#prelist_invalid_kec");
            $('#penangangan_kembali').html('<div id="penangangan_kembali_kec"></div>');
            var source_penangangan_kembali = document.querySelector("#penangangan_kembali_kec");
            $('#status_ruta_musdes').html('<div id="status_ruta_musdes_kec"></div>');
            var source_status_ruta_musdes = document.querySelector("#status_ruta_musdes_kec");
            $('#status_ruta_verval').html('<div id="status_ruta_verval_kec"></div>');
            var source_status_ruta_verval = document.querySelector("#status_ruta_verval_kec");

        } else if ((area[0] > 0) && (area[1] > 0) && (area[2] > 0) && (area[3] > 0)) {
            $('#progres_publish').html('<div id="progres_publish_kel"></div>');
            var source_progres_publish = document.querySelector("#progres_publish_kel");
            $('#progres_survey').html('<div id="progres_survey_kel"></div>');
            var source_progres_survey = document.querySelector("#progres_survey_kel");
            $('#prelist_invalid').html('<div id="prelist_invalid_kel"></div>');
            var source_prelist_invalid = document.querySelector("#prelist_invalid_kel");
            $('#penangangan_kembali').html('<div id="penangangan_kembali_kel"></div>');
            var source_penangangan_kembali = document.querySelector("#penangangan_kembali_kel");
            $('#status_ruta_musdes').html('<div id="status_ruta_musdes_kel"></div>');
            var source_status_ruta_musdes = document.querySelector("#status_ruta_musdes_kel");
            $('#status_ruta_verval').html('<div id="status_ruta_verval_kel"></div>');
            var source_status_ruta_verval = document.querySelector("#status_ruta_verval_kel");
        }

        setTimeout(function() {

            //progres_publish
            $(function() {
                var options = {
                    chart: {
                        height: 280,
                        type: 'bar',
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    colors: ["#4680ff", "#0e9e4a", "#ffba57", "#ff5252"],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                        },
                    },
                    series: [{
                        name: 'On Progres',
                        data: data_progres_publish.chart_proses_publish
                    }, {
                        name: 'Selesai Proses',
                        data:  data_progres_publish.chart_selesai_publish
                    }],
                    xaxis: {
                        type: 'label',
                        categories: data_progres_publish.label_chart_selesai_publish,
                    },
                    legend: {
                        position: 'right',
                        offsetY: 40
                    },
                    fill: {
                        opacity: 1
                    },
                }
                var chart = new ApexCharts(
                    source_progres_publish,
                    options
                );
                chart.render();
            });

            //progres_survey
            $(function() {
                var options = {
                    chart: {
                        height: 280,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ["#0e9e4a", "#4680ff", "#ff5252"],
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    series: [{
                        name: 'On Progres',
                        data: data_progres_verval.chart_proses_verval
                    }, {
                        name: 'Selesai',
                        data: data_progres_verval.chart_selesai_verval
                    }],
                    xaxis: {
                        categories: data_progres_verval.label_chart_selesai_verval,
                    },
                    fill: {
                        opacity: 1

                    },
                    // tooltip: {
                    //     y: {
                    //         formatter: function(val) {
                    //             return "$ " + val + " thousands"
                    //         }
                    //     }
                    // }
                }
                var chart = new ApexCharts(
                    source_progres_survey,
                    options
                );
                chart.render();
            });

            //prelist_invalid
            $(function() {
                var options = {
                    chart: {
                        height: 280,
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
                    dataLabels: {
                        enabled: true,
                        offsetX: -6,
                        style: {
                            fontSize: '12px',
                            colors: ['#fff']
                        }
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ['#fff']
                    },
                    series: [{
                        name: 'On Progres',
                        data: data_progres_invalid_musdes.chart_proses_invalid_musdes
                    }, {
                        name: 'Selesai',
                        data: data_progres_invalid_musdes.chart_selesai_invalid_musdes
                    }],
                    xaxis: {
                        categories: data_progres_invalid_musdes.label_chart_selesai_invalid_musdes,
                    },

                }
                var chart = new ApexCharts(
                    source_prelist_invalid,
                    options
                );
                chart.render();
            });

            //penangangan_kembali
            $(function() {
                var options = {
                    chart: {
                        height: 350,
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
                    colors: ["#F93E36"],
                    dataLabels: {
                        enabled: true,
                        offsetX: -6,
                        style: {
                            fontSize: '12px',
                            colors: ['#fff']
                        }
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ['#fff']
                    },
                    series: [{
                        name: 'Total',
                        data:  data_penanganan_kembali.value_chart_penanganan_kembali
                    }],
                    xaxis: {
                        categories: data_penanganan_kembali.label_chart_penanganan_kembali,
                    },

                }
                var chart = new ApexCharts(
                    document.querySelector("#penangangan_kembali"),
                    options
                );
                chart.render();
            });

            //status_ruta_musdes
            $(function() {
                var options = {
                    chart: {
                        height: 275,
                        type: 'pie',
                    },
                    labels: data_musdes.label_chart_musdes,
                    series: data_musdes.value_chart_musdes,
                    colors: ["#4680ff", "#0e9e4a", "#00acc1", "#ffba57", "#ff5252"],
                    legend: {
                        show: true,
                        position: 'bottom',
                    },
                    dataLabels: {
                        enabled: true,
                        dropShadow: {
                            enabled: false,
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                }
                var chart = new ApexCharts(
                    source_status_ruta_musdes,
                    options
                );
                chart.render();
            });

            // status_ruta_verval
            $(function() {
                var options = {
                    chart: {
                        height: 280,
                        type: 'donut',
                    },
                    labels: data_verval.label_chart_verval,
                    series: data_verval.value_chart_verval,
                    colors: ["#4680ff", "#0e9e4a", "#00acc1", "#ffba57", "#ff5252", "#8E0DF9"],
                    legend: {
                        show: true,
                        position: 'bottom',
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '55%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true
                                    },
                                    value: {
                                        show: true
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        dropShadow: {
                            enabled: false,
                        }
                    },
                    responsive: [{
                        breakpoint: 300,
                        options: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                }
                var chart = new ApexCharts(
                    source_status_ruta_verval,
                    options
                );
                chart.render();
            });

        }, 700);

    }

});
</script>

<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
