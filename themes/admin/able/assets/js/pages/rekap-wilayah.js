'use strict';
$(document).ready(function() {
    var base_url = $("#base_url").val();  

    getAjaxRekapWilayah(); 

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

       $("#rekap_txt").html(title);
       getAjaxRekapWilayah();
   	});

    function getAjaxRekapWilayah(){ 

    	var filter_area = {
	     	kd_prop:$('#select-propinsi').val(),
	     	kd_kab:$('#select-kabupaten').val(),
	     	kd_kec:$('#select-kecamatan').val()
	   	}
    	$.ajax({
	        url: base_url+"get_rekap_wilayah",
	        type: "POST",
	        data: filter_area,
	        dataType: "json",
	        beforeSend: function( xhr ) { 
	        	 $("#tbl_rekap_wilayah").html("memuat ...");
	        },
	        success : function(data) { 
	        	$("#tbl_rekap_wilayah").html("");
	            createHtmlTable(data);
	        }
	    });
    }
    function createHtmlTable(data){
    	console.log("HTMl"); 
    	console.log(typeof data);
    	var html = "";
    	var tot_status0 = 0;
    	var tot_status1 = 0;
    	var tot_status2 = 0;
    	var tot_status2a = 0;
    	var tot_status3 = 0;
    	var tot_status3a = 0;
    	var tot_status4 = 0;
    	var tot_status4a = 0;
    	var tot_status5 = 0;
    	var tot_status5a = 0;
    	var tot_status6 = 0;
    	var tot_status6a = 0;
    	var tot_status7 = 0;
    	var tot_status7a = 0;
    	var tot_status8 = 0;
    	var tot_status8a = 0;
    	var tot_status9 = 0;
    	var tot_status9a = 0;
    	var tot_status10 = 0;
    	var tot_status10a = 0;
    	var tot_status11 = 0;
    	var tot_status11a = 0;
    	var tot_status12 = 0;
    	var tot_status12a = 0;
    	var tot_status13 = 0;
    	var tot_status13a = 0;
    	var tot_status13b = 0;
    	var tot_status14 = 0; 
    	Object.keys(data).forEach(function(key) { 
			var status_0 = data[key].status_0 - 
			(
				data[key].status_1 + 
				data[key].status_2 +
				data[key].status_2a +
				data[key].status_3 +
				data[key].status_3a +
				data[key].status_4 +
				data[key].status_4a +
				data[key].status_5 +
				data[key].status_5a +
				data[key].status_6 +
				data[key].status_6a +
				data[key].status_7 +
				data[key].status_7a +
				data[key].status_8 +
				data[key].status_8a +
				data[key].status_9 +
				data[key].status_9a +
				data[key].status_10 +
				data[key].status_10a  +				
				data[key].status_11  +
				data[key].status_12 +
				data[key].status_13  +				
				data[key].status_14   
			);
			html += "<tr><td align='left'>"+data[key].NAME+"</td>";
			html += "<td align='center'>"+Number(status_0).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_1).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_2).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_2a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_3).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_3a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_4).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_4a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_5).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_5a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_6).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_6a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_7).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_7a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_8).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_8a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_9).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_9a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_10).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_10a).toLocaleString('id')+"</td>";
			html += "<td align='center'>"+Number(data[key].status_11).toLocaleString('id')+"</td>"; 
			html += "<td align='center'>"+Number(data[key].status_11a).toLocaleString('id')+"</td>"; 
			html += "<td align='center'>"+Number(data[key].status_12).toLocaleString('id')+"</td>"; 
			html += "<td align='center'>"+Number(data[key].status_12a).toLocaleString('id')+"</td>"; 
			html += "<td align='center'>"+Number(data[key].status_13).toLocaleString('id')+"</td>"; 
			html += "<td align='center'>"+Number(data[key].status_13a).toLocaleString('id')+"</td>"; 
			html += "<td align='center'>"+Number(data[key].status_13b).toLocaleString('id')+"</td>"; 
			html += "<td align='center'>"+Number(data[key].status_14).toLocaleString('id')+"</td>"; 
			 
			html += "</tr>";

			tot_status0 += data[key].status_0;
			tot_status1 += data[key].status_1; 
			tot_status2 += data[key].status_2;
			tot_status2a += data[key].status_2a;
			tot_status3 += data[key].status_3;
			tot_status3a += data[key].status_3a;
			tot_status4 += data[key].status_4;
			tot_status4a += data[key].status_4a;
			tot_status5 += data[key].status_5;
			tot_status5a += data[key].status_5a;
			tot_status6 += data[key].status_6;
			tot_status6a += data[key].status_6a;
			tot_status7 += data[key].status_7;
			tot_status7a += data[key].status_7a;
			tot_status8 += data[key].status_8;
			tot_status8a += data[key].status_8a;
			tot_status9 += data[key].status_9;
			tot_status9a += data[key].status_9a;
			tot_status10 += data[key].status_10;
			tot_status10a += data[key].status_10a;
			tot_status11 += data[key].status_11;
			tot_status11a += data[key].status_11a;
			tot_status12 += data[key].status_12;
			tot_status12a += data[key].status_12a;
			tot_status13 += data[key].status_13;
			tot_status13a += data[key].status_13a;
			tot_status13b += data[key].status_13b;
			tot_status14 += data[key].status_14; 
		}); 

		html += "<tr><th align='right'>TOTAL</th>"; 
			html += "<th align='center'>"+Number(tot_status0).toLocaleString('id')+"</th>";
			html += "<th align='center'>"+Number(tot_status1).toLocaleString('id')+"</th>";  
			html += "<th align='center'>"+Number(tot_status2).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status2a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status3).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status3a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status4).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status4a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status5).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status5a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status6).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status6a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status7).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status7a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status8).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status8a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status9).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status9a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status10).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status10a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status11).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status11a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status12).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status12a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status13).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status13a).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status13b).toLocaleString('id')+"</th>"; 
			html += "<th align='center'>"+Number(tot_status14).toLocaleString('id')+"</th>";  
			html += "</tr>";
	 	
	 	$("#tbl_rekap_wilayah").append(html);
    }
    
}); 
