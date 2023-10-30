'use strict';
$(document).ready(function() {
    var base_url = $("#base_url").val();  

    getAjaxRekapStatus(); 

    $("#cari").on("click",function(){  
    	var title = "";
    	if(
           $('#select-propinsi').select2('data')[0].id == 0 &&
           $('#select-kabupaten').select2('data')[0].id == 0 &&
           $('#select-kecamatan').select2('data')[0].id == 0
       ){
           title = "Propinsi";
       }else{
       		if($('#select-propinsi').select2('data')[0].id != 0){
               title = "Kabupaten";
           }
            if($('#select-kabupaten').select2('data')[0].id != 0){
               title = "Kecamatan";
           }
           if($('#select-kecamatan').select2('data')[0].id != 0){
             title = "Desa";
           } 
       }

       $("#rekap_status_txt").html(title);
       getAjaxRekapStatus();
   	});

    function getAjaxRekapStatus(){ 

    	var filter_area = {
	     	kd_prop:$('#select-propinsi').val(),
	     	kd_kab:$('#select-kabupaten').val(),
	     	kd_kec:$('#select-kecamatan').val()
	   	}
    	$.ajax({
	        url: base_url+"get_status_verval",
	        type: "POST",
	        data: filter_area,
	        dataType: "json",
	        beforeSend: function( xhr ) { 
	        	 $("#tbl_rekap_status").html("memuat ...");
	        },
	        success : function(data) { 
	        	$("#tbl_rekap_status").html("");
	            createHtmlTable(data);
	        }
	    });
    }
    function createHtmlTable(data){ 
    	var html = "";
    	var grand_total = 0;
    	var tot_selesai_cacah = 0; 
    	var tot_tidak_ditemukan = 0;
    	var tot_ruta_pindah = 0;
    	var tot_bagian_dr_dokumen = 0;
    	var tot_menolak = 0;
    	var tot_ganda = 0;
    	Object.keys(data).forEach(function(key) { 
			html += "<tr><td align='left'>"+data[key].NAME+"</td>";
			html += "<td align='right'>"+Number(data[key].jumlah_data).toLocaleString('id')+"</td>";
			html += "<td align='right'>"+Number(data[key].selesai_cacah).toLocaleString('id')+"</td>";
			html += "<td align='right'>"+Number(data[key].tidak_ditemukan).toLocaleString('id')+"</td>";
			html += "<td align='right'>"+Number(data[key].ruta_pindah).toLocaleString('id')+"</td>";
			html += "<td align='right'>"+Number(data[key].bagian_dr_dokumen).toLocaleString('id')+"</td>";
			html += "<td align='right'>"+Number(data[key].menolak).toLocaleString('id')+"</td>";
			html += "<td align='right'>"+Number(data[key].ganda).toLocaleString('id')+"</td>";  
			html += "</tr>";

			grand_total +=data[key].jumlah_data;
			tot_selesai_cacah += data[key].selesai_cacah;
			tot_tidak_ditemukan += data[key].tidak_ditemukan;
			tot_ruta_pindah += data[key].ruta_pindah;
			tot_bagian_dr_dokumen += data[key].bagian_dr_dokumen;
			tot_menolak += data[key].menolak;
			tot_ganda += data[key].ganda;
		}); 

		html += "<tr><th align='left'>TOTAL</th>"; 
			html += "<th class='text-right'>"+Number(grand_total).toLocaleString('id')+"</th>";
			html += "<th class='text-right'>"+Number(tot_selesai_cacah).toLocaleString('id')+"</th>";
			html += "<th class='text-right'>"+Number(tot_tidak_ditemukan).toLocaleString('id')+"</th>";
			html += "<th class='text-right'>"+Number(tot_ruta_pindah).toLocaleString('id')+"</th>";
			html += "<th class='text-right'>"+Number(tot_bagian_dr_dokumen).toLocaleString('id')+"</th>";
			html += "<th class='text-right'>"+Number(tot_menolak).toLocaleString('id')+"</th>";
			html += "<th class='text-right'>"+Number(tot_ganda).toLocaleString('id')+"</th>"; 
			html += "</tr>";
	 	
	 	$("#tbl_rekap_status").append(html);
    }
    
}); 
