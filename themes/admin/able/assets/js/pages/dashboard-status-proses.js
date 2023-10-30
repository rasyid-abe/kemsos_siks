'use strict';
$(document).ready(function() {
  var base_url = $("#base_url").val();
   var progresMusdesChart = null;
   var musdesUBChart = null;
   var statusRTMusdesChart = null;
   var rekapMusdesChart = null;
   var vervalValidChart = null;
   var vervalInValidChart = null;
  getPrelistByStatusRT();
  $("#cari").on("click",function(){
      //filter_area 
    getPrelistByStatusRT();
  });

  function getPrelistByStatusRT(){
   var filter_area = {
     kd_prop:$('#select-propinsi').val(),
     kd_kab:$('#select-kabupaten').val(),
     kd_kec:$('#select-kecamatan').val()
   }

   $.ajax({
       url: base_url+"getPrelistByStereotype",
       type: "POST",
       data:filter_area,
       dataType: "json",
       beforeSend: function( xhr ) {

       },
       success : function(data) {
         console.log(data); 
          $("#progress-publish").html("");
          $("#progress-usulan-baru").html("");
          $("#status_rt_musdes_table").html("");
          $("#verval_valid > tbody").html("");
          $("#verval_invalid > tbody").html("");
          $("#hasil_musdes  > tbody").html('<tr>'+
                    '<th colspan="4">Status Rumah Tangga Hasil Musdes/Muskel</th>'+
                   ' </tr>'+
                  
                    '<tr>'+
                        '<th colspan="4">Rekapitulasi Hasil Musdes/Muskel</th>'+
                    '</tr>'); 
          loadTable(data);
       },
    });
  }

   function loadTable(data){ 
       var legendChartProgressMusdes = []; 
       var dataChartProgressMusdes = []; 
       for (var i = 0; i < data.progressMusdes.length; i++) {
            addHtmlProgressPublish(data.progressMusdes[i]);
            if(i >= 1 && i <= 6){
              legendChartProgressMusdes.push(data.progressMusdes[i].status);
              dataChartProgressMusdes.push(data.progressMusdes[i].tot_dlm_proses);
            }

            if(i > 6){
              legendChartProgressMusdes.push(data.progressMusdes[i].status);
              dataChartProgressMusdes.push(data.progressMusdes[i].tot_selesai_proses);
            }
       } 
       loadChartProgressMusdes(legendChartProgressMusdes,dataChartProgressMusdes);

       
       var legendChartProgressUsulanbaru = []; 
       var dataChartProgressUsulanbaru = []; 
       for (var j = 0; j < data.progressUB.length; j++) {
            legendChartProgressUsulanbaru.push(data.progressUB[j].ket);
            dataChartProgressUsulanbaru.push(data.progressUB[j].tot_selesai_proses);
            
            addHtmlProgressUsulanbaru(data.progressUB[j]);
       } 
       loadChartProgressUsulanbaru(legendChartProgressUsulanbaru,dataChartProgressUsulanbaru);

       var legendChartStatusRTMusdes = []; 
       var dataChartStatusRTMusdes = []; 
       for (var h = 0; h < data.statusRTMusdes.length; h++) {
          if(h!=4){
            legendChartStatusRTMusdes.push(data.statusRTMusdes[h].ket);
            dataChartStatusRTMusdes.push(data.statusRTMusdes[h].tot_selesai_proses);
          }
         addHtmlStatusRTMusdes(data.statusRTMusdes[h],h);
          
       } 
       loadChartStatusRTMusdes(legendChartStatusRTMusdes,dataChartStatusRTMusdes);

       var legendChartRekapMusdes = []; 
       var dataChartRekapMusdes = []; 
       for (var k = 0; k < data.rekapMusdes.length; k++) {
          if(k >= 1 && k <= 3){
            legendChartRekapMusdes.push(data.rekapMusdes[k].ket);
            dataChartRekapMusdes.push(data.rekapMusdes[k].tot_selesai_proses);
          }
         addHtmlRekapMusdes(data.rekapMusdes[k],k);
       } 
       loadChartRekapMusdes(legendChartRekapMusdes,dataChartRekapMusdes);


       var legendChartVervalValid = []; 
       var dataChartVervalValid = []; 
       for (var l = 0; l < data.vervalValid.length; l++) {
          if(l >= 1){
            legendChartVervalValid.push(data.vervalValid[l].ket);
            dataChartVervalValid.push(data.vervalValid[l].tot_selesai_proses);
          }
         addHtmlVervalValid(data.vervalValid[l],l);
       } 
       loadChartVervalValid(legendChartVervalValid,dataChartVervalValid);


       var legendChartVervalInValid = []; 
       var dataChartVervalInValid = []; 
       for (var l = 0; l < data.vervalInValid.length; l++) {
          if(l >= 1){
            legendChartVervalInValid.push(data.vervalInValid[l].ket);
            dataChartVervalInValid.push(data.vervalInValid[l].tot_selesai_proses);
          }
         addHtmlVervalInValid(data.vervalInValid[l],l);
       } 
       loadChartVervalInValid(legendChartVervalInValid,dataChartVervalInValid);
   }

   function loadChartProgressMusdes(legend,data){
     var options = {
          series: [{
          name: 'Total',
          data: data
        }],
         chart: {
          type: 'bar',
          height: 350
        }, 
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded',
            distributed: true
          },
        },
        colors: ["#000000","#e2e5e8","#e6e142","#d22b2b","#f98f0c","#f4f575","#6afa60","#119108"],
        dataLabels: {
          enabled: false
        }, 
        xaxis: {
          categories: legend,
        } , 
        yaxis: {
          forceNiceScale: false,
        } 
        }; 

        if(progresMusdesChart) progresMusdesChart.destroy();
        progresMusdesChart = new ApexCharts(document.querySelector("#chart-publish-musdes"), options);
        progresMusdesChart.render();
   }
   function loadChartProgressUsulanbaru(legend,data){
      var options = {
        series: data,
        chart: {
        width: 380,
        type: 'pie',
      },
      labels: legend,
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

      
      if(musdesUBChart) musdesUBChart.destroy();
      musdesUBChart = new ApexCharts(document.querySelector("#chart-musdes-ub"), options);
      musdesUBChart.render();
   }
   function loadChartStatusRTMusdes(legend,data){
      var options = {
        series: data,
        chart: {
        width: 380,
        type: 'pie',
      },
      labels: legend,
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

      if(statusRTMusdesChart) statusRTMusdesChart.destroy();
      statusRTMusdesChart = new ApexCharts(document.querySelector("#chart-status-musdes"), options);
      statusRTMusdesChart .render();
   }
   function loadChartRekapMusdes(legend,data){
      var options = {
        series: data,
        chart: {
        width: 380,
        type: 'pie',
      },
      labels: legend,
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

      if(rekapMusdesChart) rekapMusdesChart.destroy();
      rekapMusdesChart = new ApexCharts(document.querySelector("#chart-rekap-musdes"), options);
      rekapMusdesChart .render();
   }
   function loadChartVervalValid(legend,data){
     var options = {
          series: [{
          name: 'Total',
          data: data
        }],
         chart: {
          type: 'bar',
          height: 350
        }, 
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded',
            distributed: true
          },
        },
        colors: ["#86ff93","#e9bf4c","#ff6a66","#ffae31","#ffff66","#86ff93","#78c6d3","#cc98ff","#f191bb"],
        dataLabels: {
          enabled: false
        }, 
        xaxis: {
          categories: legend,
        } , 
        yaxis: {
          forceNiceScale: false,
        } 
        }; 

        if(vervalValidChart) vervalValidChart.destroy();
        vervalValidChart = new ApexCharts(document.querySelector("#chart-verval-valid"), options);
        vervalValidChart.render();
   }
   function loadChartVervalInValid(legend,data){
     var options = {
          series: [{
          name: 'Total',
          data: data
        }],
         chart: {
          type: 'bar',
          height: 350
        }, 
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded',
            distributed: true
          },
        },
        colors: ["#1c6547", "#78c6d3","#cc98ff","#f191bb"],
        dataLabels: {
          enabled: false
        }, 
        xaxis: {
          categories: legend,
        } , 
        yaxis: {
          forceNiceScale: false,
        } 
        }; 

        if(vervalInValidChart) vervalInValidChart.destroy();
        vervalInValidChart = new ApexCharts(document.querySelector("#chart-verval-invalid"), options);
        vervalInValidChart.render();
   }

   function addHtmlProgressPublish(data){
       var html = '<tr>'+
           '<td class="text-left "><img src="'+data.icon+'"></td>'+
           '<td class="text-left ">'+data.ket+'</td>'+
           '<td class="text-right ">'+Number(data.tot_dlm_proses).toLocaleString('id')+'</td>'+
           '<td class="text-right ">'+data.p_tot_dlm_proses+' </td>'+
           '<td class="text-right ">'+Number(data.tot_selesai_proses).toLocaleString('id')+'</td>'+
           '<td class="text-right ">'+data.p_tot_selesai_proses+'</td>'+
       '</tr>';

       $("#progress-publish").append(html);
   }
   function addHtmlProgressUsulanbaru(data){ 
       var html = '<tr>'+
           '<td class="text-left "><img src="'+data.icon+'"></td>'+
           '<td class="text-left ">'+data.ket+'</td>'+
           '<td class="text-right "> </td>'+
           '<td class="text-right "> </td>'+
           '<td class="text-right ">'+Number(data.tot_selesai_proses).toLocaleString('id')+'</td>'+
           '<td class="text-right "> </td>'+
       '</tr>';

       $("#progress-usulan-baru").append(html);
   }
   function addHtmlStatusRTMusdes(data,j){  
       var html = '<tr>'+
           '<td class="text-right ">'+data.ket+'</td>'+
           '<td class="text-right ">:</td>'+ 
           '<td class="text-right ">'+Number(data.tot_selesai_proses).toLocaleString('id')+'</td>'+
           '<td class="text-center "></td>'+
       '</tr>';

       $("#hasil_musdes  > tbody > tr").eq(j).after(html);
   }

   function addHtmlRekapMusdes(data,k){ 
     // console.log(k);
       var html = '<tr>'+
           '<td class="text-right ">'+data.ket+'</td>'+
           '<td class="text-right ">:</td>'+ 
           '<td class="text-right ">'+Number(data.tot_selesai_proses).toLocaleString('id')+'</td>'+
           '<td class="text-center "></td>'+
       '</tr>';
       // console.log(k+6);
       $("#hasil_musdes  > tbody > tr").eq(k+7).after(html);
   } 
   function addHtmlVervalValid(data,l){ 
     // console.log(k);
     var icon ='B';
     if(l > 0) {
       icon = '<img src="'+data.icon+'"></td>';
     }
      var html = '<tr>'+
         '<td class="text-left ">'+icon+'</td>'+
         '<td class="text-left ">'+data.ket+'</td>'+
         '<td class="text-right ">'+Number(data.tot_dlm_proses).toLocaleString('id')+'</td>'+
         '<td class="text-right ">'+data.p_tot_dlm_proses+' </td>'+
         '<td class="text-right ">'+Number(data.tot_selesai_proses).toLocaleString('id')+'</td>'+
         '<td class="text-right ">'+data.p_tot_selesai_proses+'</td>'+
     '</tr>';
       $("#verval_valid  > tbody").append(html);
   } 
   function addHtmlVervalInValid(data,l){ 
     var icon ='C';
     if(l > 0) {
       icon = '<img src="'+data.icon+'"></td>';
     }
      var html = '<tr>'+
         '<td class="text-left ">'+icon+'</td>'+
         '<td class="text-left ">'+data.ket+'</td>'+
         '<td class="text-right ">'+Number(data.tot_dlm_proses).toLocaleString('id')+'</td>'+
         '<td class="text-right ">'+data.p_tot_dlm_proses+' </td>'+
         '<td class="text-right ">'+Number(data.tot_selesai_proses).toLocaleString('id')+'</td>'+
         '<td class="text-right ">'+data.p_tot_selesai_proses+'</td>'+
     '</tr>';
       $("#verval_invalid  > tbody").append(html);
   } 
});
