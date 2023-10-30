'use strict';
$(document).ready(function() {
   var base_url = $("#base_url").val();
   var rekapWilayahChart = null;
   var rekapTotalWilayahChart = null;
   var rekapMusdesHarianChart = null;
   var rekapMusdesAkumulasiChart = null;
   var rekapVervalHarianChart = null;
   var rekapVervalAkumulasiChart = null;
   var title = "";
   var isMusdesOpen = false;
   var isVervalOpen = true;

   showHidePanelProgressHarian();
   rekapitulasiLastDay();
   chartRekapWilayah();
   getAjaxMusdesProgress();
   getAjaxVervalProgress();

   rekapMusdesVerval();

   $("#cari").parent().on("click",function(){
      rekapitulasiLastDay();
      chartRekapWilayah();
      getAjaxMusdesProgress();
      getAjaxVervalProgress();

      rekapMusdesVerval();
   });
   function getWilayahName(){
       var propinsi = $('#select-propinsi').select2('data')[0].text.replace('Propinsi ', ' ');
       var kabupaten = $('#select-kabupaten').select2('data')[0].text.replace('Kabupaten ', ' ');
       kabupaten = $('#select-kabupaten').select2('data')[0].text.replace('Kota ', ' ');
       var kecamatan = $('#select-kecamatan').select2('data')[0].text.replace('Propinsi ', ' ');
       console.log( $('#select-propinsi').select2('data')[0].id);
       console.log( $('#select-kabupaten').select2('data')[0].id);
       console.log( $('#select-kecamatan').select2('data')[0].id);
       var title = "";
       if(
           $('#select-propinsi').select2('data')[0].id == 0 &&
           $('#select-kabupaten').select2('data')[0].id == 0 &&
           $('#select-kecamatan').select2('data')[0].id == 0
       ){
           title += "Seluruh Indonesia";
       }else{

           if($('#select-kecamatan').select2('data')[0].id != 0){
               title +=kecamatan+", ";
           }
           if($('#select-kabupaten').select2('data')[0].id != 0){
               title +=kabupaten+", ";
           }
           if($('#select-propinsi').select2('data')[0].id != 0){
               title += propinsi;
           }
       }

       return title;
   }
   function rekapitulasiLastDay(){
       console.log("REKAP LAST DAY");
       var filter_area = {
         kd_prop:$('#select-propinsi').val(),
         kd_kab:$('#select-kabupaten').val(),
         kd_kec:$('#select-kecamatan').val()
       }
       $.ajax({
           url: base_url+"rekapitulasiLastDay",
           type: "POST",
           data:filter_area,
           dataType: "json",
           beforeSend: function( xhr ) {
               $("#musdes_lastday").text("memuat ...");
               $("#musdes_now").text("memuat ...");
               $("#verval_lastday").text("memuat ...");
               $("#verval_now").text("memuat ...");
               $("#approval_lastday").text("memuat ...");
               $("#approval_now").text("memuat ...");
               $("#monev_lastday").text("memuat ...");
               $("#monev_now").text("memuat ...");
           },
           success : function(data) {
               console.log(data.tot_musdes_lastday);
               $("#musdes_lastday").text(data.tot_musdes_lastday);
               $("#musdes_now").text(data.tot_musdes_now);
               $("#verval_lastday").text(data.tot_verval_lastday);
               $("#verval_now").text(data.tot_verval_now);
               $("#approval_lastday").text(data.tot_approval_lastday);
               $("#approval_now").text(data.tot_approval_now);
               $("#monev_lastday").text(data.tot_monev_lastday);
               $("#monev_now").text(data.tot_monev_now);
           },
       });
   }
   function showHidePanelProgressHarian(){
       $("#musdes").hide();
       $("#verval").show();

       $("#verval_lastday").parent().on("click",function(){
            $("#musdes").hide();
           isMusdesOpen = false;
           if(!isVervalOpen){
               $("#verval").show();
               getAjaxVervalProgress();
               isVervalOpen = true;
           }else{
               $("#verval").hide();
               isVervalOpen = false;
           }
       });
       $("#musdes_lastday").parent().on("click",function(){
           $("#verval").hide();
           isVervalOpen = false;
           if(!isMusdesOpen){
               $("#musdes").show();
               getAjaxMusdesProgress();
               isMusdesOpen = true;
           }else{
               $("#musdes").hide();
               isMusdesOpen = false;
           }
       });
   }

   function getAjaxVervalProgress(){
       var filter_area = {
         kd_prop:$('#select-propinsi').val(),
         kd_kab:$('#select-kabupaten').val(),
         kd_kec:$('#select-kecamatan').val()
       }

       $.ajax({
           url: base_url+"rekapHarianVerval",
           type: "POST",
           data:filter_area,
           dataType: "json",
           beforeSend: function( xhr ) {

           },
           success : function(data) {
               chartRekapHarianVerval(data);
               chartRekapAkumulasiVerval(data);
           },
       });
   }

   function getAjaxMusdesProgress(){
       var filter_area = {
         kd_prop:$('#select-propinsi').val(),
         kd_kab:$('#select-kabupaten').val(),
         kd_kec:$('#select-kecamatan').val()
       }

       $.ajax({
           url: base_url+"rekapHarianMusdes",
           type: "POST",
           data:filter_area,
           dataType: "json",
           beforeSend: function( xhr ) {

           },
           success : function(data) {
               console.log(data);
               chartRekapHarianMusdes(data);
               chartRekapAkumulasiMusdes(data);
           },
       });
   }

   function chartRekapHarianMusdes(data){
       var wilayah = getWilayahName();
       $("#title_harian_musdes").text("Progress Harian Kegiatan Musdes "+wilayah);
       var options = {
          series: [ {
            name: 'REALISASI',
            data: data.realisasi_harian
          },{
          name: 'TARGET',
          data: data.target_harian
        }],
        chart: {
           type: 'line',
           height: 350,
           type: 'line',
           zoom: {
             enabled: false
           }
        },
        xaxis: {
          categories: data.tgl,
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
       if(rekapMusdesHarianChart) rekapMusdesHarianChart.destroy();
       rekapMusdesHarianChart = new ApexCharts(document.querySelector("#chart_harian_musdes"), options);
       rekapMusdesHarianChart.render();
   }

   function chartRekapAkumulasiMusdes(data){
       var wilayah = getWilayahName();
       $("#title_akumulasi_musdes").text("Progress Akumulasi Musdes "+wilayah);
       var options = {
          series: [ {
            name: 'REALISASI',
            data: data.realisasi_akumulasi
          },{
          name: 'TARGET',
          data: data.target_akumulasi
        }],
        chart: {
           type: 'line',
           height: 350,
           type: 'line',
           zoom: {
             enabled: false
           }
        },
        xaxis: {
          categories: data.tgl,
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
       if(rekapMusdesAkumulasiChart) rekapMusdesAkumulasiChart.destroy();
       rekapMusdesAkumulasiChart = new ApexCharts(document.querySelector("#chart_akumulasi_musdes"), options);
       rekapMusdesAkumulasiChart.render();
   }

   function chartRekapHarianVerval(data){
       var wilayah = getWilayahName();
       $("#title_harian_verval").text("Progress Harian Kegiatan Verval "+wilayah);
       var options = {
          series: [ {
            name: 'REALISASI',
            data: data.realisasi_harian
          },{
          name: 'TARGET',
          data: data.target_harian
        }],
        chart: {
           type: 'line',
           height: 350,
           type: 'line',
           zoom: {
             enabled: false
           }
        },
        xaxis: {
          categories: data.tgl,
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
       if(rekapVervalHarianChart) rekapVervalHarianChart.destroy();
       rekapVervalHarianChart = new ApexCharts(document.querySelector("#chart_harian_verval"), options);
       rekapVervalHarianChart.render();
   }

   function chartRekapAkumulasiVerval(data){
       var wilayah = getWilayahName();
       $("#title_akumulasi_verval").text("Progress Akumulasi Kegiatan Verval "+wilayah);
       var options = {
          series: [ {
            name: 'REALISASI',
            data: data.realisasi_akumulasi
          },{
          name: 'TARGET',
          data: data.target_akumulasi
        }],
        chart: {
           type: 'line',
           height: 350,
           type: 'line',
           zoom: {
             enabled: false
           }
        },
        xaxis: {
          categories: data.tgl,
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
       if(rekapVervalAkumulasiChart) rekapVervalAkumulasiChart.destroy();
       rekapVervalAkumulasiChart = new ApexCharts(document.querySelector("#chart_akumulasi_verval"), options);
       rekapVervalAkumulasiChart.render();
   }

   function chartRekapWilayah(){
       var filter_area = {
         kd_prop:$('#select-propinsi').val(),
         kd_kab:$('#select-kabupaten').val(),
         kd_kec:$('#select-kecamatan').val()
       }

       $.ajax({
           url: base_url+"rekapWilayah",
           type: "POST",
           data:filter_area,
           dataType: "json",
           beforeSend: function( xhr ) {

           },
           success : function(data) {
               var wilayah = getWilayahName();
               $("#title_rekap_wilayah").text("Rekapitulasi Prelist & Usulan Baru "+wilayah);
               $("#title_total_rekap_wilayah").text("Rekapitulasi Prelist & Usulan Baru "+wilayah);
               var options = {
                  series: [ {
                    name: 'REALISASI',
                    data: data.realisasi
                  },{
                  name: 'TARGET',
                  data: data.target
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
                  categories: data.wilayah,
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
                if(rekapWilayahChart) rekapWilayahChart.destroy();
                rekapWilayahChart = new ApexCharts(document.querySelector("#chart_rekap_wilayah"), options);
                rekapWilayahChart.render();
                console.log(data);
                var options2 = {
                  series: data.total,
                  chart: {
                  width: 380, 
                  type: 'pie',
                },
                labels: data.label,
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

                if(rekapTotalWilayahChart) rekapTotalWilayahChart.destroy();
                rekapTotalWilayahChart = new ApexCharts(document.querySelector("#chart_total_rekap_wilayah"), options2);
                rekapTotalWilayahChart.render();
           },
       });
   }

   function rekapMusdesVerval(){
       var filter_area = {
         kd_prop:$('#select-propinsi').val(),
         kd_kab:$('#select-kabupaten').val(),
         kd_kec:$('#select-kecamatan').val()
       }
       $.ajax({
           url: base_url+"rekapMusdesVerval",
           type: "POST",
           data:filter_area,
           dataType: "json",
           beforeSend: function( xhr ) {

           },
           success : function(data) {
               console.log(data);
               setTableMusdes(data);
               setTableVerval(data);
           }
       });
   }

   function setTableMusdes(data){
       if(
           $('#select-propinsi').select2('data')[0].id == 0 &&
           $('#select-kabupaten').select2('data')[0].id == 0 &&
           $('#select-kecamatan').select2('data')[0].id == 0
       ){
           $("#musdes_area_txt").html("Provinsi");
       }else{
           if($('#select-propinsi').select2('data')[0].id != 0){
              $("#musdes_area_txt").html("Kota/Kabupaten");
           }
           if($('#select-kabupaten').select2('data')[0].id != 0){
               $("#musdes_area_txt").html("Kecamatan");
           }
           if($('#select-kecamatan').select2('data')[0].id != 0){
            $("#musdes_area_txt").html("Kel/Desa");
        }
       }
       var html = "";
       var total_target_desa = 0;
       var total_real_desa = 0;
       var tot_prelist_awal = 0;
       var tot_ditemukan = 0;
       var tot_tdk_ditemukan = 0;
       var tot_ganda = 0;
       var tot_UB = 0;
       var tot_prelist_akhir = 0;

       var total_percent_desa = 0;
       var total_percent_verval = 0;
       for (var i = 0; i < data.result.length; i++) {
           var musdes = data.result; 
           var wilayah = musdes[i].PROPINSI;

           var percent_desa = ((musdes[i].tot_real_desa/musdes[i].tot_target_desa) * 100).toFixed(2);
           
           console.log(percent_desa);

           total_target_desa += musdes[i].tot_target_desa;
           total_real_desa += musdes[i].tot_real_desa; 
           tot_prelist_awal += musdes[i].tot_target_prelist; 
           tot_ditemukan += musdes[i].tot_ditemukan; 
           tot_tdk_ditemukan += musdes[i].tot_tdk_ditemukan; 
           tot_ganda += musdes[i].tot_ganda; 
           tot_UB += musdes[i].tot_UB;  
           var prelist_akhir = musdes[i].tot_UB + musdes[i].tot_ditemukan;
           var percent_verval = ((prelist_akhir/musdes[i].tot_target_prelist) * 100).toFixed(2);

           tot_prelist_akhir += prelist_akhir;

           var warning_desa = "background-color: green;";
           var warning_prelist = "background-color: green;";
           if(percent_desa < 100){
                warning_desa = "background-color: red;";
           }
           if(percent_verval < 100){
                warning_prelist = "background-color: red;";
           }

           if($('#select-propinsi').select2('data')[0].id != 0){
               wilayah = musdes[i].KABUPATEN;
           }
           if($('#select-kabupaten').select2('data')[0].id != 0){
              wilayah = musdes[i].KECAMATAN;
           }
           if($('#select-kecamatan').select2('data')[0].id != 0){
            wilayah = musdes[i].DESA;
         }
           html += '<tr>'+
               '<td>'+wilayah+'</td>'+
               '<td class="text-right">'+Number(musdes[i].tot_target_desa).toLocaleString('id')+'</td>'+
               '<td class="text-right">'+Number(musdes[i].tot_real_desa).toLocaleString('id')+'</td>'+
               '<td class="text-right">'+percent_desa+'</td>'+
               '<td class="text-right" style="vertical-align: middle;">'+
                    '<div style = "width: 10px; height: 10px; border-radius: 50%; '+warning_desa+'"></div>'+
               '</td>'+
               '<td class="text-right">'+Number(musdes[i].tot_target_prelist).toLocaleString('id')+'</td>'+
               '<td class="text-right">'+Number(musdes[i].tot_ditemukan).toLocaleString('id')+'</td>'+
               '<td class="text-right">'+Number(musdes[i].tot_tdk_ditemukan).toLocaleString('id')+'</td>'+
               '<td class="text-right">'+Number(musdes[i].tot_ganda).toLocaleString('id')+'</td>'+
               '<td class="text-right">'+Number(musdes[i].tot_UB).toLocaleString('id')+'</td>'+
               '<td class="text-right">'+Number(prelist_akhir).toLocaleString('id')+'</td>'+
               '<td>'+percent_verval+'</td>'+ 
               '</tr>';
       }
       total_percent_desa = ((total_real_desa/total_target_desa)*100).toFixed(2); 
       total_percent_verval = ((tot_prelist_akhir/tot_prelist_awal)*100).toFixed(2); 
            html += '<tr>'+
                   '<th >TOTAL</th>'+
                   '<th class="text-right">'+Number(total_target_desa).toLocaleString('id')+'</th>'+
                   '<th class="text-right">'+Number(total_real_desa).toLocaleString('id')+'</th>'+
                   '<th class="text-right">'+total_percent_desa+'</th>'+
                   '<th> </th>'+
                   '<th class="text-right">'+Number(tot_prelist_awal).toLocaleString('id')+'</th>'+
                   '<th class="text-right">'+Number(tot_ditemukan).toLocaleString('id')+'</th>'+
                   '<th class="text-right">'+Number(tot_tdk_ditemukan).toLocaleString('id')+'</th>'+
                   '<th class="text-right">'+Number(tot_ganda).toLocaleString('id')+'</th>'+
                   '<th class="text-right">'+Number(tot_UB).toLocaleString('id')+'</th>'+
                   '<th class="text-right">'+Number(tot_prelist_akhir).toLocaleString('id')+'</th>'+
                   '<th class="text-right">'+total_percent_verval+'</th>'+
                   '<th> </th>'+
           '</tr>';

       $("#tbl_rekapitulasi_musdes").html(html);
   }
   function setTableVerval(data){
       $("#verval_per_kabupaten").hide();
       $("#verval_per_kecamatan").hide();
       $("#verval_per_desa").hide();
       if(
           $('#select-propinsi').select2('data')[0].id == 0 &&
           $('#select-kabupaten').select2('data')[0].id == 0 &&
           $('#select-kecamatan').select2('data')[0].id == 0
       ){

       }else{
           if($('#select-propinsi').select2('data')[0].id != 0){
               $("#verval_per_propinsi").hide();
               $("#verval_per_kabupaten").show();
               $("#verval_per_kecamatan").hide();
               $("#verval_per_desa").hide();
           }
           if($('#select-kabupaten').select2('data')[0].id != 0){
               $("#verval_per_propinsi").hide();
               $("#verval_per_kabupaten").hide();
               $("#verval_per_kecamatan").show();
               $("#verval_per_desa").hide();
           }
           if($('#select-kecamatan').select2('data')[0].id != 0){
               $("#verval_per_propinsi").hide();
               $("#verval_per_kabupaten").hide();
               $("#verval_per_kecamatan").hide();
               $("#verval_per_desa").show();
           }
       }
       var html = ""; 
       var tot_prelist_akhir = 0;
       var tot_verivali_submit = 0;
       var tot_approval_pengawas = 0;
       var tot_approval_korkab = 0;
       for (var i = 0; i < data.result.length; i++) {
           var verval = data.result[i];
           var wilayah = verval.PROPINSI;
           if($('#select-propinsi').select2('data')[0].id != 0){
                var wilayah = verval.KABUPATEN;
           }
           if($('#select-kabupaten').select2('data')[0].id != 0){
                var wilayah = verval.KECAMATAN;
           }
           if($('#select-kecamatan').select2('data')[0].id != 0){
                var wilayah = verval.DESA;
           }
           var prelist_akhir = verval.tot_UB + verval.tot_ditemukan; 
           tot_prelist_akhir += prelist_akhir;  
           tot_verivali_submit += verval.verivali_submit;  
           tot_approval_pengawas += verval.approval_pengawas;  
           tot_approval_korkab += verval.approval_korkab;  

           html += '<tr>'+
                       '<td>'+wilayah+'</td>'+
                       '<td class="text-right">'+Number(prelist_akhir).toLocaleString('id')+'</td>'+ 
                       '<td class="text-right">'+Number(verval.verivali_submit).toLocaleString('id')+'</td>'+
                        '<td class="text-right">'+Number(verval.approval_pengawas).toLocaleString('id')+'</td>'+
                        '<td class="text-right">'+Number(verval.approval_korkab).toLocaleString('id')+'</td>'+ 
                   '</tr>';
       } 
       html += '<tr >'+
               '<th>TOTAL</th>'+
               '<th class="text-right">'+Number(tot_prelist_akhir).toLocaleString('id')+'</th>'+ 
               '<th class="text-right">'+Number(tot_verivali_submit).toLocaleString('id')+'</th>'+
                '<th class="text-right">'+Number(tot_approval_pengawas).toLocaleString('id')+'</th>'+
                '<th class="text-right">'+Number(tot_approval_korkab).toLocaleString('id')+'</th>'+ 
           '</tr>';
        $("#rekap_verval").find("tbody").html(html);


   }
   function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
});
