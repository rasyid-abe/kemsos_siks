'use strict';
$(document).ready(function() {
   var base_url = $("#base_url").val();
   var target = "#v-1";
   var filter_area = {
     kd_prop:$('#select-propinsi').val(),
     kd_kab:$('#select-kabupaten').val(),
     kd_kec:$('#select-kecamatan').val()
   }
   var adaDikKKchart = null;
   getStatusPenguasaanBangungan(filter_area);
   $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
      //reset filter wilayah
      $('#select-propinsi').val(0);
      $('#select-propinsi').select2().trigger('change');

      target = $(e.target).attr("href") // activated tab
      //filter_area
      var filter_area = {
        kd_prop:$('#select-propinsi').val(),
        kd_kab:$('#select-kabupaten').val(),
        kd_kec:$('#select-kecamatan').val()
      }
      changeContent(target,filter_area);
   });

   $("#cari").on("click",function(){
      //filter_area
      var filter_area = {
        kd_prop:$('#select-propinsi').val(),
        kd_kab:$('#select-kabupaten').val(),
        kd_kec:$('#select-kecamatan').val()
      }
      changeContent(target,filter_area);
   });

   function changeContent(target,filter_area){
      console.log(target);
      if(target === "#v-1"){
        getStatusPenguasaanBangungan(filter_area);
      }else if (target === "#v-2") {
          getStatusLahan(filter_area);
      }else if (target === "#v-3") {
          getStatusJenisLantai(filter_area);
      }else if (target === "#v-4") {
          getStatusDinding(filter_area);
      }else if (target === "#v-5") {
          getStatusAtap(filter_area);
      }else if (target === "#v-6") {
          getStatusSumberAir(filter_area);
      }else if (target === "#v-7") {
           getStatusCaraPeroleh(filter_area);
      }else if (target === "#v-8") {
          getStatusSumberPenerangan(filter_area);
      }else if (target === "#v-9") {
          getStatusDayaTerpasang(filter_area);
      }else if (target === "#v-10") {
          getStatusBahanBakar(filter_area);
      }else if (target === "#v-11") {
          getStatusFasilitasBAB(filter_area);
      }else if (target === "#v-12") {
          getStatusTempatTinja(filter_area);
      }else if (target === "#v-13") {
          getStatusRasioKamarTidur(filter_area);
      }else if (target === "#v-14") {
      }else if (target === "#v-15") {
          getStatusKRTPerempuan(filter_area);
      }else if (target === "#v-16") {
          getStatusKehamilan(filter_area);
      }else if (target === "#v-17") {
          getStatusPerkawinan(filter_area);
      }else if (target === "#v-18") {
          getStatusJenisCacat(filter_area);
      }else if (target === "#v-19") {
          getStatusKronis(filter_area);
      }else if (target === "#v-20") {
      }else if (target === "#v-21") {
          getStatusJenisTernak(filter_area);
      }else if (target === "#v-22") {
          getStatusAssetTakBergerak(filter_area);
      }else if (target === "#v-23") {
      }else if (target === "#v-24") {
          getStatusTidakTercantumKK(filter_area);
      }else if (target === "#v-25") {
      }else if (target === "#v-26") {
      }else if (target === "#v-27") {
          getStatusPartisipasiSekolah(filter_area);
      }else if (target === "#v-28") {
      }else if (target === "#v-29") {
          getStatusLapanganKerja(filter_area);
      }else{
        console.log("NOTHING");
      }
   }

    function getStatusPenguasaanBangungan(filter_area){
        $.ajax({
            url: base_url+"getStatusPenguasaanBangungan",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#sendiri").html(Number(data.total[0]).toLocaleString('id'));
                $("#kontrak").html(Number(data.total[1]).toLocaleString('id'));
                $("#bebasSewa").html(Number(data.total[2]).toLocaleString('id'));
                $("#dinas").html(Number(data.total[3]).toLocaleString('id'));
                $("#statusBangunanLainnya").html(Number(data.total[4]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#status_bangunan"), options);
                chart.render();
            }
        });
    }
    function getStatusLahan(filter_area){
        $.ajax({
            url: base_url+"getStatusLahan",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#lahan_sendiri").html(Number(data.total[0]).toLocaleString('id'));
                $("#orangLain").html(Number(data.total[1]).toLocaleString('id'));
                $("#tanahNegara").html(Number(data.total[2]).toLocaleString('id'));
                $("#statusBangunanLainnya").html(Number(data.total[3]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#status_lahan"), options);
                chart.render();
            }
        });
    }
    function getStatusJenisLantai(filter_area){
        $.ajax({
            url: base_url+"getStatusJenisLantai",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#marmer").html(Number(data.total[0]).toLocaleString('id'));
                $("#keramik").html(Number(data.total[1]).toLocaleString('id'));
                $("#parket").html(Number(data.total[2]).toLocaleString('id'));
                $("#ubin").html(Number(data.total[3]).toLocaleString('id'));
                $("#kayu").html(Number(data.total[4]).toLocaleString('id'));
                $("#bata").html(Number(data.total[5]).toLocaleString('id'));
                $("#bambu").html(Number(data.total[6]).toLocaleString('id'));
                $("#papan").html(Number(data.total[7]).toLocaleString('id'));
                $("#tanah").html(Number(data.total[8]).toLocaleString('id'));
                $("#lantaiLainnya").html(Number(data.total[9]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#jenis_lantai"), options);
                chart.render();
            }
        });
    }
    function getStatusDinding(filter_area){
        $.ajax({
            url: base_url+"getStatusDinding",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data.kondisi);
                $("#tembokBagus").html(Number(data.kondisi[1][1]).toLocaleString('id'));
                $("#tembokJelek").html(Number(data.kondisi[1][2]).toLocaleString('id'));
                $("#totalTembok").html(Number(data.total[0]).toLocaleString('id'));
                $("#plesteranBagus").html(Number(data.kondisi[2][1]).toLocaleString('id'));
                $("#plesteranJelek").html(Number(data.kondisi[2][2]).toLocaleString('id'));
                $("#totalPlesteran").html(Number(data.total[1]).toLocaleString('id'));
                $("#kayuBagus").html(Number(data.kondisi[3][1]).toLocaleString('id'));
                $("#kayuJelek").html(Number(data.kondisi[3][2]).toLocaleString('id'));
                $("#totalKayu").html(Number(data.total[2]).toLocaleString('id'));
                $("#anyamanBambu").html(Number(data.total[3]).toLocaleString('id'));
                $("#batangKayu").html(Number(data.total[4]).toLocaleString('id'));
                $("#bambu_dinding").html(Number(data.total[5]).toLocaleString('id'));
                $("#dindingLainnya").html(Number(data.total[6]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#status_dinding"), options);
                chart.render();
            }
        });
    }
    function getStatusAtap(filter_area){
        $.ajax({
            url: base_url+"getStatusAtap",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data.kondisi);
                $("#betonBagus").html(Number(data.kondisi[1][1]).toLocaleString('id'));
                $("#betonJelek").html(Number(data.kondisi[1][2]).toLocaleString('id'));
                $("#totalBeton").html(Number(data.total[0]).toLocaleString('id'));
                $("#gKeramikBagus").html(Number(data.kondisi[2][1]).toLocaleString('id'));
                $("#gKeramikJelek").html(Number(data.kondisi[2][2]).toLocaleString('id'));
                $("#totalGKeramik").html(Number(data.total[1]).toLocaleString('id'));
                $("#gMetalBagus").html(Number(data.kondisi[3][1]).toLocaleString('id'));
                $("#gMetalJelek").html(Number(data.kondisi[3][2]).toLocaleString('id'));
                $("#totalGMetal").html(Number(data.total[2]).toLocaleString('id'));
                $("#gTanahLiatBagus").html(Number(data.kondisi[4][1]).toLocaleString('id'));
                $("#gTanahLiatJelek").html(Number(data.kondisi[4][2]).toLocaleString('id'));
                $("#totalTanahLiat").html(Number(data.total[3]).toLocaleString('id'));
                $("#asbesBagus").html(Number(data.kondisi[5][1]).toLocaleString('id'));
                $("#asbesJelek").html(Number(data.kondisi[5][2]).toLocaleString('id'));
                $("#totalAsbes").html(Number(data.total[4]).toLocaleString('id'));
                $("#sengBagus").html(Number(data.kondisi[6][1]).toLocaleString('id'));
                $("#sengJelek").html(Number(data.kondisi[6][2]).toLocaleString('id'));
                $("#totalSeng").html(Number(data.total[5]).toLocaleString('id'));
                $("#sirapBagus").html(Number(data.kondisi[7][1]).toLocaleString('id'));
                $("#sirapJelek").html(Number(data.kondisi[7][2]).toLocaleString('id'));
                $("#totalSirap").html(Number(data.total[6]).toLocaleString('id'));
                $("#atapBambu").html(Number(data.total[7]).toLocaleString('id'));
                $("#atapJerami").html(Number(data.total[8]).toLocaleString('id'));
                $("#atapLainnya").html(Number(data.total[9]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#status_atap"), options);
                chart.render();
            }
        });
    }
    function getStatusSumberAir(filter_area){
        $.ajax({
            url: base_url+"getStatusSumberAir",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#airKemasan").html(Number(data.total[0]).toLocaleString('id'));
                $("#airIsiUlang").html(Number(data.total[1]).toLocaleString('id'));
                $("#meteran").html(Number(data.total[2]).toLocaleString('id'));
                $("#eceran").html(Number(data.total[3]).toLocaleString('id'));
                $("#bor").html(Number(data.total[4]).toLocaleString('id'));
                $("#sumurTerlindung").html(Number(data.total[5]).toLocaleString('id'));
                $("#sumurTakTerlindung").html(Number(data.total[6]).toLocaleString('id'));
                $("#mataAirTerlindung").html(Number(data.total[7]).toLocaleString('id'));
                $("#mataAirTakTerlindung").html(Number(data.total[8]).toLocaleString('id'));
                $("#airSungai").html(Number(data.total[9]).toLocaleString('id'));
                $("#airHujan").html(Number(data.total[10]).toLocaleString('id'));
                $("#airLainnya").html(Number(data.total[11]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#sumber_airminum"), options);
                chart.render();
            }
        });
    }
    function getStatusCaraPeroleh(filter_area){
        $.ajax({
            url: base_url+"getStatusCaraPeroleh",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#membeli").html(Number(data.total[0]).toLocaleString('id'));
                $("#langganan").html(Number(data.total[1]).toLocaleString('id'));
                $("#tidakMembeli").html(Number(data.total[2]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#cara_peroleh"), options);
                chart.render();
            }
        });
    }
    function getStatusSumberPenerangan(filter_area){
        $.ajax({
            url: base_url+"getStatusSumberPenerangan",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#pln").html(Number(data.total[0]).toLocaleString('id'));
                $("#nonPln").html(Number(data.total[1]).toLocaleString('id'));
                $("#bukanListrik").html(Number(data.total[2]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#sumber_penerangan"), options);
                chart.render();
            }
        });
    }
    function getStatusDayaTerpasang(filter_area){
        $.ajax({
            url: base_url+"getStatusDayaTerpasang",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#pln450watt").html(Number(data.total[0]).toLocaleString('id'));
                $("#pln900watt").html(Number(data.total[1]).toLocaleString('id'));
                $("#pln1300watt").html(Number(data.total[2]).toLocaleString('id'));
                $("#pln2200watt").html(Number(data.total[3]).toLocaleString('id'));
                $("#plnLebih2200watt").html(Number(data.total[4]).toLocaleString('id'));
                $("#tanpaMeteran").html(Number(data.total[5]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#daya_terpasang"), options);
                chart.render();
            }
        });
    }
    function getStatusBahanBakar(filter_area){
        $.ajax({
            url: base_url+"getStatusBahanBakar",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#listrik").html(Number(data.total[0]).toLocaleString('id'));
                $("#gas3KgLebih").html(Number(data.total[1]).toLocaleString('id'));
                $("#gas3Kg").html(Number(data.total[2]).toLocaleString('id'));
                $("#biogas").html(Number(data.total[3]).toLocaleString('id'));
                $("#minyakTanah").html(Number(data.total[4]).toLocaleString('id'));
                $("#briket").html(Number(data.total[5]).toLocaleString('id'));
                $("#arang").html(Number(data.total[6]).toLocaleString('id'));
                $("#kayuBakar").html(Number(data.total[7]).toLocaleString('id'));
                $("#tidakMasak").html(Number(data.total[8]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#bahan_bakar"), options);
                chart.render();
            }
        });
    }
    function getStatusFasilitasBAB(filter_area){
        $.ajax({
            url: base_url+"getStatusFasilitasBAB",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#sendiri20").html(Number(data.total[0]).toLocaleString('id'));
                $("#bersama").html(Number(data.total[1]).toLocaleString('id'));
                $("#umum").html(Number(data.total[2]).toLocaleString('id'));
                $("#tidakAda").html(Number(data.total[3]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#fasilitas_bab"), options);
                chart.render();
            }
        });
    }
    function getStatusTempatTinja(filter_area){
        $.ajax({
            url: base_url+"getStatusTempatTinja",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#tangki").html(Number(data.total[0]).toLocaleString('id'));
                $("#spal").html(Number(data.total[1]).toLocaleString('id'));
                $("#lubangTanah").html(Number(data.total[2]).toLocaleString('id'));
                $("#kolam").html(Number(data.total[3]).toLocaleString('id'));
                $("#pantai").html(Number(data.total[4]).toLocaleString('id'));
                $("#tinjaLainnya").html(Number(data.total[5]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#tempat_tinja"), options);
                chart.render();
            }
        });
    }
    function getStatusRasioKamarTidur(filter_area){
        $.ajax({
            url: base_url+"getStatusRasioKamarTidur",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                $("#rasio_kamar").html("");
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>'+
                      '<th>'+data[i].jumlah_kamar+'</th>'+
                      '<th>'+data[i].total+'</th>'+
                    '</tr>';
                }
                $("#rasio_kamar").append(html);
            }
        });
    }
    function getStatusKRTPerempuan(filter_area){
        $.ajax({
            url: base_url+"getStatusKRTPerempuan",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                 console.log(data);
                 $("#KrtPerempuan").html(Number(data.total).toLocaleString('id'));
            }
        });
    }
    function getStatusJenisCacat(filter_area){
        $.ajax({
            url: base_url+"getStatusJenisCacat",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#disabilitas_0").html(Number(data.total[0]).toLocaleString('id'));
                $("#disabilitas_1").html(Number(data.total[1]).toLocaleString('id'));
                $("#disabilitas_2").html(Number(data.total[2]).toLocaleString('id'));
                $("#disabilitas_3").html(Number(data.total[3]).toLocaleString('id'));
                $("#disabilitas_4").html(Number(data.total[4]).toLocaleString('id'));
                $("#disabilitas_5").html(Number(data.total[5]).toLocaleString('id'));
                $("#disabilitas_6").html(Number(data.total[6]).toLocaleString('id'));
                $("#disabilitas_7").html(Number(data.total[7]).toLocaleString('id'));
                $("#disabilitas_8").html(Number(data.total[8]).toLocaleString('id'));
                $("#disabilitas_9").html(Number(data.total[9]).toLocaleString('id'));
                $("#disabilitas_10").html(Number(data.total[10]).toLocaleString('id'));
                $("#disabilitas_11").html(Number(data.total[11]).toLocaleString('id'));
                var options = {
                  series: [{
                    name: "jenis disabilitas",
                    data: data.total
                }],
                  chart: {
                  height: 350,
                  type: 'line',
                  zoom: {
                    enabled: false
                  }
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  curve: 'straight'
                },
                grid: {
                  row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                  },
                },
                xaxis: {
                  categories: data.label,
                }
                };

                var chart = new ApexCharts(document.querySelector("#jenis_disabilitas"), options);
                chart.render();

            }
        });
    }
    function getStatusKronis(filter_area){
        $.ajax({
            url: base_url+"getStatusKronis",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#penyakit_0").html(Number(data.total[0]).toLocaleString('id'));
                $("#penyakit_1").html(Number(data.total[1]).toLocaleString('id'));
                $("#penyakit_2").html(Number(data.total[2]).toLocaleString('id'));
                $("#penyakit_3").html(Number(data.total[3]).toLocaleString('id'));
                $("#penyakit_4").html(Number(data.total[4]).toLocaleString('id'));
                $("#penyakit_5").html(Number(data.total[5]).toLocaleString('id'));
                $("#penyakit_6").html(Number(data.total[6]).toLocaleString('id'));
                $("#penyakit_7").html(Number(data.total[7]).toLocaleString('id'));
                $("#penyakit_8").html(Number(data.total[8]).toLocaleString('id'));
                $("#penyakit_9").html(Number(data.total[9]).toLocaleString('id'));
                var options = {
                  series: [{
                    name: "jenis disabilitas",
                    data: data.total
                }],
                  chart: {
                  height: 350,
                  type: 'line',
                  zoom: {
                    enabled: false
                  }
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  curve: 'straight'
                },
                grid: {
                  row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                  },
                },
                xaxis: {
                  categories: data.label,
                }
                };

                var chart = new ApexCharts(document.querySelector("#status_kronis"), options);
                chart.render();

            }
        });
    }
    function getStatusJenisTernak(filter_area){
        $.ajax({
            url: base_url+"getStatusJenisTernak",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#sapi").html(Number(data.total[0]).toLocaleString('id'));
                $("#kerbau").html(Number(data.total[1]).toLocaleString('id'));
                $("#kuda").html(Number(data.total[2]).toLocaleString('id'));
                $("#babi").html(Number(data.total[3]).toLocaleString('id'));
                $("#kambing").html(Number(data.total[4]).toLocaleString('id'));
                var options = {
                  series: [{
                    name: "jenis Ternak",
                    data: data.total
                }],
                  chart: {
                  height: 350,
                  type: 'line',
                  zoom: {
                    enabled: false
                  }
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  curve: 'straight'
                },
                grid: {
                  row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                  },
                },
                xaxis: {
                  categories: data.label,
                }
                };

                var chart = new ApexCharts(document.querySelector("#jenis_ternak"), options);
                chart.render();

            }
        });
    }
    function getStatusAssetTakBergerak(filter_area){
        $.ajax({
            url: base_url+"getStatusAssetTakBergerak",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#lahanYa").html(Number(data.data_lahan[0]).toLocaleString('id'));
                $("#lahanTidak").html(Number(data.data_lahan[1]).toLocaleString('id'));
                $("#rumahYa").html(Number(data.data_rumah_lainnya[0]).toLocaleString('id'));
                $("#rumahTidak").html(Number(data.data_rumah_lainnya[1]).toLocaleString('id'));
                var options = {
                      series: [{
                      name: 'YA',
                      data: [data.data_lahan[0],data.data_rumah_lainnya[0]]
                    }, {
                      name: 'Tidak',
                      data:[data.data_lahan[1],data.data_rumah_lainnya[1]]
                    }],
                  chart: {
                  type: 'bar',
                  height: 350,
                  stacked: true,
                  stackType: '100%'
                },
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
                xaxis: {
                  categories: data.label,
                },
                fill: {
                  opacity: 1
                },
                legend: {
                  position: 'right',
                  offsetX: 0,
                  offsetY: 50
                },
                };

                var chart = new ApexCharts(document.querySelector("#asset_tak_bergerak"), options);
                chart.render();

            }
        });
    }
    function getStatusKehamilan(filter_area){
        $.ajax({
            url: base_url+"getStatusKehamilan",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#belumKawin_1").html(Number(data.data_hamil[0]).toLocaleString('id'));
                $("#kawin_1").html(Number(data.data_hamil[1]).toLocaleString('id'));
                $("#ceraiMati_1").html(Number(data.data_hamil[2]).toLocaleString('id'));
                $("#ceraiHidup_1").html(Number(data.data_hamil[3]).toLocaleString('id'));
                $("#belumKawin_2").html(Number(data.data_tidak_hamil[0]).toLocaleString('id'));
                $("#kawin_2").html(Number(data.data_tidak_hamil[1]).toLocaleString('id'));
                $("#ceraiMati_2").html(Number(data.data_tidak_hamil[2]).toLocaleString('id'));
                $("#ceraiHidup_2").html(Number(data.data_tidak_hamil[3]).toLocaleString('id'));

               var options = {
                 series: [{
                 name: 'Hamil',
                 data: data.data_hamil
               }, {
                 name: 'Tidak Hamil',
                 data:data.data_tidak_hamil
               }],
                 chart: {
                 type: 'bar',
                 height: 350,
                 stacked: true,
                 stackType: '100%'
               },
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
               xaxis: {
                 categories: data.label,
               },
               fill: {
                 opacity: 1
               },
               legend: {
                 position: 'right',
                 offsetX: 0,
                 offsetY: 50
               },
               };

               var chart = new ApexCharts(document.querySelector("#kehamilan_kawin"), options);
               chart.render();

            }
        });
    }
    function getStatusPartisipasiSekolah(filter_area){
        $.ajax({
            url: base_url+"getStatusPartisipasiSekolah",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#tidakSekolah").html(Number(data.total[0]).toLocaleString('id'));
                $("#masihSekolah").html(Number(data.total[1]).toLocaleString('id'));
                $("#tidakSekolahLagi").html(Number(data.total[2]).toLocaleString('id'));
                var options = {
                  series: data.total,
                  chart: {
                  width: 380,
                  type: 'pie',
                },
                labels:data.label,
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 200
                    },
                    legend: {
                      position: 'bottom'
                    }
                  }
                }]
                };

                var chart = new ApexCharts(document.querySelector("#partisipasi_sekolah"), options);
                chart.render();
            }
        });
    }
    function getStatusLapanganKerja(filter_area){
        $.ajax({
            url: base_url+"getStatusLapanganKerja",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#pekerjaan1").html(Number(data.total[0]).toLocaleString('id'));
                $("#pekerjaan2").html(Number(data.total[1]).toLocaleString('id'));
                $("#pekerjaan3").html(Number(data.total[2]).toLocaleString('id'));
                $("#pekerjaan4").html(Number(data.total[3]).toLocaleString('id'));
                $("#pekerjaan5").html(Number(data.total[4]).toLocaleString('id'));
                $("#pekerjaan6").html(Number(data.total[5]).toLocaleString('id'));
                $("#pekerjaan7").html(Number(data.total[6]).toLocaleString('id'));
                $("#pekerjaan8").html(Number(data.total[7]).toLocaleString('id'));
                $("#pekerjaan9").html(Number(data.total[8]).toLocaleString('id'));
                $("#pekerjaan10").html(Number(data.total[9]).toLocaleString('id'));
                $("#pekerjaan11").html(Number(data.total[10]).toLocaleString('id'));
                $("#pekerjaan12").html(Number(data.total[11]).toLocaleString('id'));
                $("#pekerjaan13").html(Number(data.total[12]).toLocaleString('id'));
                $("#pekerjaan14").html(Number(data.total[13]).toLocaleString('id'));
                $("#pekerjaan15").html(Number(data.total[14]).toLocaleString('id'));
                $("#pekerjaan16").html(Number(data.total[15]).toLocaleString('id'));
                $("#pekerjaan17").html(Number(data.total[16]).toLocaleString('id'));
                $("#pekerjaan18").html(Number(data.total[17]).toLocaleString('id'));
                $("#pekerjaan19").html(Number(data.total[18]).toLocaleString('id'));
                $("#pekerjaan20").html(Number(data.total[19]).toLocaleString('id'));
                $("#pekerjaan21").html(Number(data.total[20]).toLocaleString('id'));
                var options = {
                  series: [{
                      name: 'Total',
                      data: data.total
                    }],
                  chart: {
                  type: 'bar',
                  height: 350
                },
                plotOptions: {
                  bar: {
                    horizontal: true,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                  },
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  show: true,
                  width: 2,
                  colors: ['transparent']
                },
                xaxis: {
                  categories:data.label,
                },
                fill: {
                  opacity: 1
                },
                tooltip: {
                  y: {
                    formatter: function (val) {
                      return val
                    }
                  }
                }
                };

                var chart = new ApexCharts(document.querySelector("#lapangan_kerja"), options);
                chart.render();
            }
        });
    }
    function getStatusTidakTercantumKK(filter_area){
        $.ajax({
            url: base_url+"getStatusTidakTercantumKK",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#ada_di_kk1").html(Number(data.total[0]).toLocaleString('id'));
                $("#ada_di_kk2").html(Number(data.total[1]).toLocaleString('id'));
                $("#ada_di_kk3").html(Number(data.total[2]).toLocaleString('id'));
                $("#ada_di_kk4").html(Number(data.total[3]).toLocaleString('id'));
                var options = {
                  series: [{
                      name: 'Total',
                      data: data.total
                    }],
                  chart: {
                  type: 'bar',
                  height: 350
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
                stroke: {
                  show: true,
                  width: 2,
                  colors: ['transparent']
                },
                xaxis: {
                  categories:data.label,
                },
                fill: {
                  opacity: 1
                },
                tooltip: {
                  y: {
                    formatter: function (val) {
                      return "Kelompok Umur "+val
                    }
                  }
                }
                };
                if(adaDikKKchart) adaDikKKchart.destroy();
                adaDikKKchart = new ApexCharts(document.querySelector("#ada_di_kk"), options);
                adaDikKKchart.render();
            }
        });
    }
    function getStatusPerkawinan(filter_area){
        $.ajax({
            url: base_url+"getStatusPerkawinan",
            type: "POST",
            data: filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                $("#belum_kawin0").html(Number(data.data_belum_kawin[0]).toLocaleString('id'));
                $("#belum_kawin1").html(Number(data.data_belum_kawin[1]).toLocaleString('id'));
                $("#belum_kawin2").html(Number(data.data_belum_kawin[2]).toLocaleString('id'));
                $("#kawin0").html(Number(data.data_kawin[0]).toLocaleString('id'));
                $("#kawin1").html(Number(data.data_kawin[1]).toLocaleString('id'));
                $("#kawin2").html(Number(data.data_kawin[2]).toLocaleString('id'));
                $("#ceraiMati0").html(Number(data.data_cerai_mati[0]).toLocaleString('id'));
                $("#ceraiMati1").html(Number(data.data_cerai_mati[1]).toLocaleString('id'));
                $("#ceraiMati2").html(Number(data.data_cerai_mati[2]).toLocaleString('id'));
                $("#ceraiHidup0").html(Number(data.data_cerai_hidup[0]).toLocaleString('id'));
                $("#ceraiHidup1").html(Number(data.data_cerai_hidup[1]).toLocaleString('id'));
                $("#ceraiHidup2").html(Number(data.data_cerai_hidup[2]).toLocaleString('id'));
                var options = {
                     series: [{
                     name: 'Tidak',
                     data: [data.data_belum_kawin[0],data.data_kawin[0],data.data_cerai_mati[0],data.data_cerai_hidup[0]]
                   }, {
                     name: 'Ya,',
                     data: [data.data_belum_kawin[1],data.data_kawin[1],data.data_cerai_mati[1],data.data_cerai_hidup[1]]
                   }, {
                     name: 'Tidak Dapat Menunjukan',
                     data: [data.data_belum_kawin[2],data.data_kawin[2],data.data_cerai_mati[2],data.data_cerai_hidup[2]]
                   }],
                     chart: {
                     type: 'bar',
                     height: 350,
                     stacked: true,
                     stackType: '100%'
                   },
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
                   xaxis: {
                     categories: data.label,
                   },
                   fill: {
                     opacity: 1
                   },
                   legend: {
                     position: 'right',
                     offsetX: 0,
                     offsetY: 50
                   },
                   };

                   var chart = new ApexCharts(document.querySelector("#status_perkawinan"), options);
                   chart.render();
            }
        });
    }
});
