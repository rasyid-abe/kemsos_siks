<link rel="stylesheet" href="<?php echo base_url( THEMES_BACKEND );?>assets/css/plugins/select2.min.css">
<link href='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.css' rel='stylesheet' />
<style>
body { margin:0; padding:0; }
code { display: inline-block; line-height: 1;}
#map { position:absolute; top:0; bottom:0; width:100%; }
.leaflet-popup-content-wrapper .leaflet-popup-content table { font-size: 8pt; display: inline-block;}
.leaflet-popup-content-wrapper .leaflet-popup-content table td { height: 5px !important; }
.leaflet-popup-content-wrapper .leaflet-popup-content {
    width: 500px !important;
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
                <div id="response_message" style="display:none;"></div>
                <table id="gridview" style="display:none;"></table>

                <div id="loader" class="modal-backdrop">
                    <div class="spin">
                        <span class="fa fa-spinner fa-spin fa-4x"></span>
                    </div>
                    <span class="text">Loading...</span>
                </div>
    </div>
</div>
</div>
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-uppercase" id="maps-tab" data-toggle="tab" href="#maps" role="tab" aria-controls="maps" aria-selected="true">Maps</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="musdes-tab" data-toggle="tab" href="#musdes" role="tab" aria-controls="musdes" aria-selected="false">Grafik Musdes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="verval-tab" data-toggle="tab" href="#verval" role="tab" aria-controls="verval" aria-selected="false">Grafik Verval</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="maps" role="tabpanel" aria-labelledby="maps-tab" style="min-height: 620px">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-lg-12 col-xl-6">
                                <div id="weathermap"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="musdes" role="tabpanel" aria-labelledby="musdes-tab">
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <div id="chart-highchart-musdes" style="width: 100%; height: 350px;"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-border-style">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="4" style="text-align: center;">
                                                    Status Rumah Tangga Hasil Musdes/Muskel
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Ditemukan "Tidak Mampu"</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="tidak_mampu">memuat ...</span></td>
                                                <td style="text-align: right"><span id="tidak_mampu_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td>Ditemukan "Mampu"</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="mampu">memuat ...</span></td>
                                                <td style="text-align: right"><span id="mampu_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td>Tidak Ditemukan</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="tidak_ditemukan_musdes">memuat ...</span></td>
                                                <td style="text-align: right"><span id="tidak_ditemukan_musdes_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td>Data Ganda</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="ganda_musdes">memuat ...</span></td>
                                                <td style="text-align: right"><span id="ganda_musdes_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;">Prelist Awal</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="prelist_awal">memuat ...</span></td>
                                                <td style="text-align: right"><span id="prelist_awal_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right; color: blue">Valid Musdes</td>
                                                <td style="color: blue">:</td>
                                                <td style="text-align: right"><span id="valid_musdes">memuat ...</span></td>
                                                <td style="text-align: right"><span id="valid_musdes_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right; color: red">Invalid Musdes</td>
                                                <td style="color: red">:</td>
                                                <td style="text-align: right"><span id="invalid_musdes">memuat ...</span></td>
                                                <td style="text-align: right"><span id="invalid_musdes_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right; color: green">Usulan Baru</td>
                                                <td style="color: green">:</td>
                                                <td style="text-align: right"><span id="usulan_baru">memuat ...</span></td>
                                                <td style="text-align: right"><span id="usulan_baru_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;">Prelist Akhir</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="prelist_akhir_musdes">memuat ...</span></td>
                                                <td style="text-align: right"><span id="prelist_akhir_musdes_percent">memuat ...</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="verval" role="tabpanel" aria-labelledby="verval-tab">
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <div id="chart-highchart-verval" style="width: 100%; height: 350px;"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-border-style">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="4" style="text-align: center;">
                                                    Status Rumah Tangga Hasil Verval
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: right"><b>Prelist Akhir</b></td>
                                                <td><b>:</b></td>
                                                <td style="text-align: right"><b><span id="prelist_akhir">memuat ...</span></b></td>
                                                <td style="text-align: right"><b>100.00%</b></td>
                                            </tr>
                                            <tr>
                                                <td>1. Selesai Dicacah</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="selesai_dicacah">memuat ...</span></td>
                                                <td style="text-align: right"><span id="selesai_dicacah_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td>2. Tidak Ditemukan</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="tidak_ditemukan">memuat ...</span></td>
                                                <td style="text-align: right"><span id="tidak_ditemukan_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td>3. Rumah Tangga Pindah</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="rt_pindah">memuat ...</span></td>
                                                <td style="text-align: right"><span id="rt_pindah_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td>4. Bagian dari Dokumen</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="bagian_dokumen">memuat ...</span></td>
                                                <td style="text-align: right"><span id="bagian_dokumen_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td>5. Responden Menolak</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="menolak">memuat ...</span></td>
                                                <td style="text-align: right"><span id="menolak_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td>6. Data Ganda</td>
                                                <td>:</td>
                                                <td style="text-align: right"><span id="ganda">memuat ...</span></td>
                                                <td style="text-align: right"><span id="ganda_percent">memuat ...</span></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right"><b>Total Survey Verivali</b></td>
                                                <td><b>:</b></td>
                                                <td style="text-align: right"><b><span id="total_verval">memuat ...</span></b></td>
                                                <td style="text-align: right"><b><span id="total_verval_percent">memuat ...</span></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/highcharts.js"></script>
<script src='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.js'></script>
<script>
// 'use strict';
$(document).ready(function() {
    show_map(data = '');
    $('#panel_header').on( 'click', function(){
        $('.search-arrow').toggleClass('fa-caret-square-right fa-caret-square-down')
        $('#search_body').slideToggle( "slow", function() {
        });
        $('#search_footer').slideToggle( "slow", function() {
        });
    });
    get_data(['','','','']);
});

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
}

$( "button#cari" ).on( "click", function(){
    if ($( "#select-kecamatan ").val() != 0) {
        $("#loader").modal("show");

        var area =[
            $( "#select-propinsi ").val(),
            $( "#select-kabupaten ").val(),
            $( "#select-kecamatan ").val(),
            $( "#select-kelurahan ").val()
        ];

        get_data(area);
    } else {
        alert('Anda harus memilih sampai Kecamatan!');
    }
});

function data_chart(data) {
    final_prelist = data.data_prelist_akhir;
    hasil_verval = data.chart_hasil_verval;

    $('#selesai_dicacah').html(hasil_verval.selesai_dicacah);
    $('#tidak_ditemukan').html(hasil_verval.tidak_ditemukan);
    $('#rt_pindah').html(hasil_verval.rt_pindah);
    $('#bagian_dokumen').html(hasil_verval.bagian_dokumen);
    $('#menolak').html(hasil_verval.menolak);
    $('#ganda').html(hasil_verval.ganda);
    $('#total_verval').html(hasil_verval.total);

    $('#selesai_dicacah_percent').html((hasil_verval.selesai_dicacah / final_prelist * 100).toFixed(2) + " %");
    $('#tidak_ditemukan_percent').html((hasil_verval.tidak_ditemukan / final_prelist * 100).toFixed(2) + " %");
    $('#rt_pindah_percent').html((hasil_verval.rt_pindah / final_prelist * 100).toFixed(2) + " %");
    $('#bagian_dokumen_percent').html((hasil_verval.bagian_dokumen / final_prelist * 100).toFixed(2) + " %");
    $('#menolak_percent').html((hasil_verval.menolak / final_prelist * 100).toFixed(2) + " %");
    $('#ganda_percent').html((hasil_verval.ganda / final_prelist * 100).toFixed(2) + " %");
    $('#total_verval_percent').html((hasil_verval.total / final_prelist * 100).toFixed(2) + " %");

    data_musdes = data.chart_musdes;

    $('#tidak_mampu').html(data_musdes.ditemukan_tidak_mampu);
    $('#mampu').html(data_musdes.ditemukan_mampu);
    $('#tidak_ditemukan_musdes').html(data_musdes.tidak_ditemukan);
    $('#ganda_musdes').html(data_musdes.data_ganda);
    $('#prelist_awal').html(data_musdes.prelist_awal);
    $('#valid_musdes').html(data_musdes.valid_musdes);
    $('#invalid_musdes').html(data_musdes.invalid_musdes);
    $('#usulan_baru').html(data_musdes.usulan_baru);
    $('#prelist_akhir_musdes').html(data_musdes.prelist_akhir);

    $('#tidak_mampu_percent').html((data_musdes.ditemukan_tidak_mampu / data_musdes.total_prelist * 100).toFixed(2) + " %");
    $('#mampu_percent').html((data_musdes.ditemukan_mampu / data_musdes.total_prelist * 100).toFixed(2) + " %");
    $('#tidak_ditemukan_musdes_percent').html((data_musdes.tidak_ditemukan / data_musdes.total_prelist * 100).toFixed(2) + " %");
    $('#ganda_musdes_percent').html((data_musdes.data_ganda / data_musdes.total_prelist * 100).toFixed(2) + " %");
    $('#prelist_awal_percent').html('100.00 %');
    $('#valid_musdes_percent').html((data_musdes.ditemukan_tidak_mampu / data_musdes.prelist_awal * 100).toFixed(2) + " %");
    $('#invalid_musdes_percent').html((data_musdes.invalid_musdes / data_musdes.prelist_awal * 100).toFixed(2) + " %");
    $('#usulan_baru_percent').html((data_musdes.usulan_baru / data_musdes.ditemukan_tidak_mampu * 100).toFixed(2) + " %");
    $('#prelist_akhir_musdes_percent').html((data_musdes.prelist_akhir / data_musdes.ditemukan_tidak_mampu * 100).toFixed(2) + " %");

    setTimeout(function() {
        Highcharts.chart('chart-highchart-musdes', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            colors: ['#green', '#blue', 'violet', 'pink'],
            title: {
                text: 'Status Rumah Tangga Hasil Musdes/Muskel'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Presentase',
                colorByPoint: true,
                data: [{
                    name: 'Ditemukan - Tidak Mampu',
                    y: data_musdes.ditemukan_tidak_mampu
                }, {
                    name: 'Ditemukan - Mampu',
                    y: data_musdes.ditemukan_mampu
                }, {
                    name: 'Tidak Ditemukan',
                    y: data_musdes.tidak_ditemukan
                }, {
                    name: 'Data Ganda',
                    y: data_musdes.data_ganda
                }]
            }]
        });

        Highcharts.chart('chart-highchart-verval', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            colors: ['#4680ff', '#536dfe', '#ff5252', '#ffba57', '#00bcd4', '#9ccc65'],
            title: {
                text: 'Status Rumah Tangga Hasil Verval'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Presentase',
                colorByPoint: true,
                data: [{
                    name: 'Selesai Dicacah',
                    y: hasil_verval.selesai_dicacah
                }, {
                    name: 'Tidak Ditemukan',
                    y: hasil_verval.tidak_ditemukan
                }, {
                    name: 'Rumah Tangga Pindah',
                    y: hasil_verval.rt_pindah
                }, {
                    name: 'Bagian dari Dokumen',
                    y: hasil_verval.bagian_dokumen
                }, {
                    name: 'Responden Menolak',
                    y: hasil_verval.menolak
                }, {
                    name: 'Data Ganda',
                    y: hasil_verval.ganda
                }]
            }]
        });
    }, 700);

}

function get_data(area) {
    $.ajax({
        url: '<?php echo base_url() ?>admin/maps/data_content',
        type: 'post',
        dataType: 'json',
        // async: false,
        data: {'area' : area},
        success: function(data){

            if (area[2] > 0) {
                show_map(data);
            }

            $('#prelist_akhir').html(formatNumber(data.data_prelist_akhir));
            data_chart(data);



            $("#loader").modal("hide");
        },
        error: function(error){
            console.log("Error:");
            console.log(error);
        }
    });
}

function show_map(data) {

    var lat = -0.453046;
    var lang = 117.123999;
    var zoom = 5;

    if (data != '') {
        lat = data.lat;
        lang = data.lang;
        zoom = 10;
    }

    document.getElementById('weathermap').innerHTML = "<div id='map' class='map' style='height:600px; width:1225px'></div>";

    L.mapbox.accessToken = 'pk.eyJ1IjoicmF6eWlkNzIiLCJhIjoiY2s1Z2g1Z3NvMDc0YTNmcGVubmgzd2l5bCJ9.6jAMfgoFlE4HVP-BYqEFPw';
    var map = L.mapbox.map('map')
    .setView([lat, lang], zoom) //lat lang
    .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));
    map.scrollWheelZoom.disable();

    var myLayer = L.mapbox.featureLayer().addTo(map);

    var musdes = [];
    var ruta = [];

    if (data != '') {
        if (data.musdes.length > 0) {
            var arr_musdes = data.musdes;
            $.each(arr_musdes, function(i, v) {
                musdes.push({"type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [v.longitude, v.latitude],
                },
                "properties": {
                    "title": "Data Foto Musdes",
                    "icon": {
                        "iconUrl": "../assets/style/pin_musdes.png",
                        "iconSize": [30, 30],
                        "iconAnchor": [20, 20],
                        "popupAnchor": [-9, 0],
                        "className": "dot"
                    },
                    'description':`
                        <code>
        					Nama Enum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtNama">ASWAR HABIBI</span><br>
        					NIK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtNIK">1213140106960003</span><br>
        					Kelurahan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtKelurahan">${v.kelurahan}</span><br>
        					Kecamatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtKecamatan">${v.kecamatan}</span><br>
        					Kabupaten/Kota : <span id="txtKabupaten">${v.kabupaten}</span><br>
        					Propinsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtPropinsi">${v.propinsi}</span><br>
        					&nbsp;<br>
        					Tgl. Photo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtTglPhoto">Wednesday, 13 November 2019, 08:50:08 WIB</span><br>
        					Tgl. Upload&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtTglUpload">Thursday, 14 November 2019, 07:51:44 WIB</span><br>
        					&nbsp;<br>
        					Lintang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtLatitude">&nbsp;${v.latitude}</span><br>
        					Bujur&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtLongitude">${v.longitude}</span><br>
        				</code>
                    `,
                }});
            })
        }
        if (data.ruta.length > 0) {
            var arr_ruta = data.ruta;
            $.each(arr_ruta, function(i, v) {
                ruta.push({"type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [v.long, v.lat],
                },
                "properties": {
                    "title": "Data Rumah Tangga",
                    "icon": {
                        "iconUrl": "../assets/style/pin_ruta.png",
                        "iconSize": [30, 30],
                        "iconAnchor": [20, 20],
                        "popupAnchor": [-9, 0],
                        "className": "dot"
                    },
                    'description': `
                        <code>
        					ID PRELIST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtBDTID">${v.id_prelist}</span><br>
        					Nama KRT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtNamaKRT">${v.nama_krt}</span><br>
        					NIK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtNIKKRT">${v.nomor_nik}</span><br>
        					Kelurahan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtKelurahanRuta">${v.kelurahan}</span><br>
        					Kecamatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtKecamatanRuta">${v.kecamatan}</span><br>
        					Kabupaten/Kota&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtKabupatenRuta">${v.kabupaten}</span><br>
        					Propinsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtPropinsiRuta">${v.propinsi}</span><br>
        					&nbsp;<br>
        					Mulai Interview&nbsp;&nbsp;&nbsp;: <span id="txtStartSurvey">Tuesday, 12 November 2019, 11:10:03 WIB</span><br>
        					Selesai Interview : <span id="txtEndSurvey">Tuesday, 12 November 2019, 11:11:24 WIB</span><br>
        					Durasi Interview&nbsp;&nbsp;: <span id="txtSurveyDuration">00:07:19</span><br>
        					&nbsp;<br>
        					Hasil Musdes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtHasilMusdes">1 = Ditemukan</span><br>
        					Hasil Verivali&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtHasilVerivali">1. Selesai dicacah</span><br>
        					&nbsp;<br>
        					Lintang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtLatitudeRuta">&nbsp;${v.lat}</span><br>
        					Bujur&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="txtLongitudeRuta">${v.long}</span><br>
        				</code>
                    `,
                }});
            })
        }
    }

    var koordinat = [];
    var res_koor =  koordinat.concat(musdes, ruta);

    var geoJson = {
        type: 'FeatureCollection',
        features: res_koor
    };

    myLayer.on('layeradd', function(e) {
        var marker = e.layer,
        feature = marker.feature;

        marker.setIcon(L.icon(feature.properties.icon));
    });

    myLayer.setGeoJSON(geoJson);
}
</script>

<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
