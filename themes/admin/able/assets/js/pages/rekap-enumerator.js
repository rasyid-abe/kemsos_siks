'use strict';
$(document).ready(function() {

	var base_url = $("#base_url").val();  
	var tableMusdes = null;
	var tableVerval = null;
	initTableMusdes();
	initTableVerval();
	$("#cari").on("click",function(){  
		console.log("cari");
    	$( "#enum_rekap_musdes").flexOptions({
			url: base_url+'get_show_data_musdes',
			params: [
				{
					"province_id": $( "#select-propinsi ").val(),
					"regency_id": $( "#select-kabupaten ").val(),
					"district_id": $( "#select-kecamatan ").val(),
					"village_id": $( "#select-kelurahan ").val() 
			}]
		}).flexReload();

		$( "#enum_rekap_verval").flexOptions({
			url: base_url+'get_show_data_verval',
			params: [
				{
					"province_id": $( "#select-propinsi ").val(),
					"regency_id": $( "#select-kabupaten ").val(),
					"district_id": $( "#select-kecamatan ").val(),
					"village_id": $( "#select-kelurahan ").val() 
			}]
		}).flexReload();
   	});
	function initTableMusdes(){
		tableMusdes = $("#enum_rekap_musdes").flexigrid({
			url: base_url+'get_show_data_musdes',
			dataType: 'json',
			colModel: [{ name:'user_id', display:'ID USER', width:60, sortable:false, align:'left', datasuorce: false},
				{ name:'surveyor_verivali', display:'Nama Enum', width:300, sortable:true, align:'left', datasuorce: false},
				{ name:'surveyor_verivali_phone', display:'No Telp', width:300, sortable:true, align:'left', datasuorce: false},
				{ name:'status_3', display:'<img src="'+base_url+'../../assets/style/icon-status/hex-03-maroon.png">', width:100, sortable:false, align:'center', datasuorce: false},
				{ name:'status_4', display:'<img src="'+base_url+'../../assets/style/icon-status/hex-04-orange.png">', width:100, sortable:true, align:'center', datasuorce: false},
				{ name:'status_5', display:'<img src="'+base_url+'../../assets/style/icon-status/hex-05-yellow.png">', width:100, sortable:true, align:'center', datasuorce: false},
				{ name:'status_6', display:'<img src="'+base_url+'../../assets/style/icon-status/hex-06-green.png">',  width:100, sortable:true, align:'center', datasuorce: false},
				{ name:'total_data', display:'Total',  width:100, sortable:false, align:'center', datasuorce: false},
			], 
			// searchitems: [<?php echo $grid['filters'];?>],
			sortname: "user_id",
			sortorder: "desc",
			usepager: true,
			title: '',
			useRp: true,
			rp: 50,
			showTableToggleBtn: false,
			showToggleBtn: true,
			width: 'auto',
			height: '500',
			resizable: false,
			singleSelect: false,
			params: [{
                "province_id": $( "#select-propinsi ").val(),
                "regency_id": $( "#select-kabupaten ").val(),
                "district_id": $( "#select-kecamatan ").val(),
                "village_id": $( "#select-kelurahan ").val()
            }]
		});
	}

	function initTableVerval(){
		tableVerval = $("#enum_rekap_verval").flexigrid({
			url: base_url+'get_show_data_verval',
			dataType: 'json',
			colModel: [{ name:'user_id', display:'ID USER', width:60, sortable:false, align:'left', datasuorce: false},
				{ name:'surveyor_verivali', display:'Nama Enum', width:250, sortable:true, align:'left', datasuorce: false},
				{ name:'surveyor_verivali_phone', display:'No Telp', width:250, sortable:true, align:'left', datasuorce: false},
				{ name:'status_8', display:'<img src="'+base_url+'../../assets/style/icon-status/hex-08-maroon.png">', width:100, sortable:false, align:'center', datasuorce: false},
				{ name:'status_9', display:'<img src="'+base_url+'../../assets/style/icon-status/hex-09-orange.png">',  width:100, sortable:true, align:'center', datasuorce: false},
				{ name:'status_10', display:'<img src="'+base_url+'../../assets/style/icon-status/hex-10-yellow.png">',  width:100, sortable:true, align:'center', datasuorce: false},
				{ name:'status_11', display:'<img src="'+base_url+'../../assets/style/icon-status/hex-11-green.png">',   width:100, sortable:true, align:'center', datasuorce: false},
				{ name:'total_data', display:'TOTAL',  width:100, sortable:true, align:'center', datasuorce: false},
			], 
			// searchitems: [<?php echo $grid['filters'];?>],
			sortname: "user_id",
			sortorder: "desc",
			usepager: true,
			title: '',
			useRp: true,
			rp: 50,
			showTableToggleBtn: false,
			showToggleBtn: true,
			width: 'auto',
			height: '500',
			resizable: false,
			singleSelect: false,
			params: [{
                "province_id": $( "#select-propinsi ").val(),
                "regency_id": $( "#select-kabupaten ").val(),
                "district_id": $( "#select-kecamatan ").val(),
                "village_id": $( "#select-kelurahan ").val()
            }]
		});
	}
   	

	
}); 
