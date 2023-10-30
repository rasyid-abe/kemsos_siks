 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prelist_print extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'korkab/prelist_print/' );
		$this->load->model('auth_model');
	}

	function index() {
		$this->show();
	}
	function print_data()
    {
        $this->load->library('PdfGenerator');
		$kode = $this->uri->segment(4);
		$data = $this->db->query("SELECT				
				*
				FROM asset.master_data_proses				
				where location_id=$kode and stereotype='PROVINCE-PUBLISHED'");
		$max_new= 0.1 * $data->num_rows();
		$location = $this->db->query("SELECT				
				*
				FROM dbo.ref_locations				
				WHERE  location_id=$kode");
		foreach ($location->result() as $db) {
            $province_name = $db->province_name;
		    $regency_name = $db->regency_name;
		    $district_name = $db->district_name;
		    $village_name = $db->village_name;
		    $bps_province_code = $db->bps_province_code;
		    $bps_regency_code = $db->bps_regency_code;
		    $bps_district_code = $db->bps_district_code;
		    $bps_village_code = $db->bps_village_code;
		}
		$html ='<head>
		  <title>Report Table</title>
		  <style type="text/css">
			@page { margin: 15px; }
			body {
				margin-top: 10px;
				margin-bottom: 10px;
			}
			#outtable{
			  padding: 0px;
			  border:1px solid #e3e3e3;
			  width:600px;
			  border-radius: 5px;
			}
		 
			.short{
			  width: 50px;
			}
		 
			.normal{
			  width: 150px;
			}
		 
			table{
			  top: 20px;
			  border-collapse: collapse;
			  font-family: helvetica;
			  font-size: 8px;
			}
		 
			thead th{
			  text-align: left;
			}
			
			tbody td{
			  padding: 3px;
			}
			.page_break { 
				page-break-before: always; 
			}
			.header{
				width: 100%;
				font-family: helvetica;
				font-size: 7px;
				text-align: left;
				position: fixed;
			}
			.footer {
				width: 100%;
				text-align: center;
				position: fixed;
				font-style: italic;
				font-family: helvetica;
				font-size: 8px;
			}
			.header {
				top: 0px;
			}
			.footer {
				bottom: 10px;
			}
			.pagenum:before {
				content: counter(page);
			}
		 
		  </style>
		</head>';
		$html .= 
		'
			<div class="header">
				Pusat Data & Informasi Kesejahteraan Sosial - Kementerian Sosial R.I</span>
			</div>
			<div class="footer">
				Provinsi '.ucwords(strtoupper($province_name)).' / '.ucwords(strtoupper($regency_name)).' / '.ucwords(strtoupper($district_name)).' / '.ucwords(strtoupper($village_name)).'  [Hal - <span class="pagenum">]</span>
			</div>
			<table cellpadding="2" cellspacing="0" border="0" width="100%"  align="center" >
				<tr align="center"  padding="0">
					<td padding="0"><h1>VERIFIKASI DAN VALIDASI DATA</h1></td>
				</tr>
				<tr align="center">
					<td><h2>DAFTAR SASARAN VERIFIKASI RUMAH TANGGA (PRELIST)</h2></td>
				</tr>
			</table>';
		$html .= 
			'			
			<table cellpadding="2" cellspacing="0" border="0" width="100%"  align="center" >
			<tr align="left">
			  <td width="70px"><h3>PROVINSI</h3></td>	
			  <td width="10px">:</td>			  
			  <td width="200px" align="left"><h3>'.ucwords(strtoupper($province_name)).'</h3></td>
			  <td width="50px"  align="left"><h3>[ '.ucwords(strtoupper($bps_province_code)).' ]</h3></td>
			  <td width="135px">&nbsp;</td>	
			  <td width="70px"><h3>KECAMATAN</h3></td>	
			  <td width="10px">:</td>			  
			  <td width="200px" align="left"><h3>'.ucwords(strtoupper($regency_name)).'</h3></td>
			  <td width="50px" align="right"><h3>[ '.ucwords(strtoupper($bps_regency_code)).' ]</h3></td>
			</tr>
			<tr align="left">
			  <td width="70px"><h3>KABUPATEN</h3></td>	
			  <td width="10px">:</td>			  
			  <td width="200px" align="left"><h3>'.ucwords(strtoupper($district_name)).'</h3></td>
			  <td width="50px" align="left"><h3>[ '.ucwords(strtoupper($bps_district_code)).' ]</h3></td>
			  <td width="135px">&nbsp;</td>	
			  <td width="70px"><h3>KELURAHAN</h3></td>	
			  <td width="10px">:</td>			  
			  <td width="200px" align="left"><h3>'.ucwords(strtoupper($village_name)).'</h3></td>
			  <td width="50px" align="right"><h3>[ '.ucwords(strtoupper($bps_village_code)).' ]</h3></td>
			</tr>	
			<tr><td colspan=9></td></tr>
			</table>';
		$html.= 
			   '<table cellpadding="2" cellspacing="0" border="1" >
			   <thead>
			   <tr align="center" style="background-color:#EFC497">
					<td rowspan="2" width="20px">NO</td>
					<td rowspan="2" width="100"> NAMA KEPALA RT</td>
					<td rowspan="2" width="50px">JENIS KELAMIN<BR><BR>1=Laki-laki <BR>2=Perempuan</td> 
					<td rowspan="2" width="100">NAMA PASANGAN KEPALA RT</td>	
					<td rowspan="2" width="100px" style="vertical-align: middle">ALAMAT</td>	
					<td rowspan="2" width="80px">NIK</td>	
					<td rowspan="2" width="60px">STATUS RUMAH TANGGA?<BR><BR>1=Ditemukan<BR>2=Tidak Ditemukan<BR>3=Data Ganda<BR>4=Usulan Baru</td>
					<td rowspan="2" width="60px">JIKA TIDAK DITEMUKAN APA ALASANNYA?<BR> <BR>1=Pindah<BR>2=Meninggal<BR>3=Tidak Tahu</td>	
					<td colspan="4" width="230px">JIKA DITEMUKAN ATAU USULAN BARU</td>
				</tr>
				<tr align="center" style="background-color:#EFC497">
					<td width="50px">APAKAH RUMAH TANGGA MAMPU? <BR><BR>1=Ya <BR>2=Tidak</td>	
					<td width="60px">APAKAH ADA ANGGOTA RUMAH TANGGA YG BEKERJA? <BR><BR>1=Ya<BR> 2=Tidak</td>	
					<td width="60px">JIKA ADA, SEBUTKAN STATUS KEDUDUKAN DALAM PEKERJAAN ?</td>	
					<td width="60px">APAKAH ADA ANGGOTA RUMAH TANGGA YG CACAT?<BR><BR>1=Ya<br> 2=Tidak</td>
				</tr>
				</thead>';
				$j=1;
		foreach ($data->result() as $db) {
			$html.= 
			   '
			   <tbody>
			 <tr>
				  <td class="datarow-cell" width="20px" align="center"  valign="top">'.$j.'</td>
				  <td width="100px" align="left">'.$db->nama_krt.'</td>
				  <td width="50px" align="center">'.$db->jenis_kelamin_krt.'</td>
				  <td width="100px">'.$db->nama_pasangan_krt.'</td>
				  <td width="100px">'.$db->alamat.'</td>
				  <td width="80px" align="center">'.$db->nomor_nik.'</td>
				  <td width="60px">'.$db->status_rumahtangga.'</td>
				  <td width="60px">'.$db->alasan_tidak_ditemukan.'</td>
				  <td width="50px">'.$db->apakah_mampu.'</td>
				  <td width="60px">'.$db->ada_art_bekerja.'</td>
				  <td width="60px">'.$db->status_pekerjaan.'</td>
				  <td width="60px">'.$db->ada_art_cacat.'</td>
				</tr>
				</tbody>';
				$j++;
		}
		$html.=
			'	
			</table>
			<div class="page_break"></div>';
		 $html .= 
		   '
			<table cellpadding="2" cellspacing="0" border="0" width="100%"  align="center" >
				<tr align="center">
					<td><h1>VERIFIKASI DAN VALIDASI DATA </h1></td>
				</tr>
				<tr align="center">
					<td><h2>DAFTAR SASARAN VERIFIKASI RUMAH TANGGA (USULAN)</h2></td>
				</tr>
			</table>';
		$html .= 
			'			
			<table cellpadding="2" cellspacing="0" border="0" width="100%"  align="center" >
			<tr align="left">
			  <td width="70px"><h3>PROVINSI</h3></td>	
			  <td width="10px">:</td>			  
			  <td width="200px" align="left"><h3>'.ucwords(strtoupper($province_name)).'</h3></td>
			  <td width="50px"  align="left"><h3>[ '.ucwords(strtoupper($bps_province_code)).' ]</h3></td>
			  <td width="135px">&nbsp;</td>	
			  <td width="70px"><h3>KECAMATAN</h3></td>	
			  <td width="10px">:</td>			  
			  <td width="200px" align="left"><h3>'.ucwords(strtoupper($regency_name)).'</h3></td>
			  <td width="50px" align="right"><h3>[ '.ucwords(strtoupper($bps_regency_code)).' ]</h3></td>
			</tr>
			<tr align="left">
			  <td width="70px"><h3>KABUPATEN</h3></td>	
			  <td width="10px">:</td>			  
			  <td width="200px" align="left"><h3>'.ucwords(strtoupper($district_name)).'</h3></td>
			  <td width="50px" align="left"><h3>[ '.ucwords(strtoupper($bps_district_code)).' ]</h3></td>
			  <td width="135px">&nbsp;</td>	
			  <td width="70px"><h3>KELURAHAN</h3></td>	
			  <td width="10px">:</td>			  
			  <td width="200px" align="left"><h3>'.ucwords(strtoupper($village_name)).'</h3></td>
			  <td width="50px" align="right"><h3>[ '.ucwords(strtoupper($bps_village_code)).' ]</h3></td>
			</tr>	
			<tr><td colspan=9></td></tr>
			</table>';
		$html.= 
			'
			<table cellpadding="2" cellspacing="0" border="1" >
			<thead>
			<tr align="center" style="background-color:#EFC497">
				<td rowspan="2" width="20px">NO</td>
				<td rowspan="2" width="100"> NAMA KEPALA RT</td>
				<td rowspan="2" width="50px">JENIS KELAMIN<BR><BR>1=Laki-laki <BR>2=Perempuan</td> 
				<td rowspan="2" width="100">NAMA PASANGAN KEPALA RT</td>	
				<td rowspan="2" width="100px" style="vertical-align: middle">ALAMAT</td>	
				<td rowspan="2" width="80px">NIK</td>	
				<td rowspan="2" width="60px">STATUS RUMAH TANGGA?<BR><BR>1=Ditemukan<BR>2=Tidak Ditemukan<BR>3=Data Ganda<BR>4=Usulan Baru</td>
				<td rowspan="2" width="60px">JIKA TIDAK DITEMUKAN APA ALASANNYA?<BR> <BR>1=Pindah<BR>2=Meninggal<BR>3=Tidak Tahu</td>	
				<td colspan="4" width="230px">JIKA DITEMUKAN ATAU USULAN BARU</td>
			</tr>
			<tr align="center" style="background-color:#EFC497">
				<td width="50px">APAKAH RUMAH TANGGA MAMPU? <BR><BR>1=Ya <BR>2=Tidak</td>	
				<td width="60px">APAKAH ADA ANGGOTA RUMAH TANGGA YG BEKERJA? <BR><BR>1=Ya<BR> 2=Tidak</td>	
				<td width="60px">JIKA ADA, SEBUTKAN STATUS KEDUDUKAN DALAM PEKERJAAN ?</td>	
				<td width="60px">APAKAH ADA ANGGOTA RUMAH TANGGA YG CACAT?<BR><BR>1=Ya<br> 2=Tidak</td>
			</tr>
			</thead>';
		$jn=1;
		for ($i=0;$i<$max_new;$i++) {
			$html.= 
			   '
				<tbody>
					<tr>
					  <td class="datarow-cell" width="20px" align="center"  valign="top">'.$jn.'</td>
					  <td width="100px" align="left"></td>
					  <td width="50px" align="center"></td>
					  <td width="100px"></td>
					  <td width="100px"></td>
					  <td width="80px" align="center"></td>
					  <td width="60px"></td>
					  <td width="60px"></td>
					  <td width="50px"></td>
					  <td width="60px"></td>
					  <td width="60px"></td>
					  <td width="60px"></td>
					</tr>
				</tbody>';
				$jn++;
			}
			$html.=
				'	
				</table>
				';
			$this->pdfgenerator->createPDF($html, 'mypdf', false);
    }

	function show() {
		$data = array();
		$data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
		$data['cari'] = $this->form_cari();
		$data['grid'] = [
			'col_id' => 'asset_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'status', display:'Status', width:50, sortable:false, align:'center', datasuorce: false},
				{ name:'id_prelist', display:'Id Prelist', width:170, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_krt', display:'Nama KRT', width:160, sortable:true, align:'left', datasuorce: false},
				{ name:'nomor_nik', display:'NIK', width:120, sortable:false, align:'center', datasuorce: false},
				{ name:'alamat', display:'Alamat', width:250, sortable:true, align:'left', datasuorce: false},
				{ name:'province_name', display:'Propinsi', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kabupaten',  width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Kelurahan', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'jenis_kelamin_krt', display:'Jenis kelamin', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:80, sortable:true, align:'left', datasuorce: false},
			",
			
			'toolbars' => "
			",
			'filters' => "
				{ display:'ID Prelist', name:'id_prelist', type:'text', isdefault: true },
				{ display:'Nama KRT', name:'nama_krt', type:'text', isdefault: true },
				{ display:'NIK', name:'nomor_nik', type:'text', isdefault: true },
				{ display:'Alamat', name:'alamat', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Cetak Data Pre-List Awal';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$data['grid']['table_title'] = 'Daftar Semua Data';

		 $data['extra_script'] = '
			<script>
				$(document).ready( function(){
					$("#select-propinsi").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "3",
							"title": "Kabupaten",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kabupaten ").html( "<option value=\'0\'> -- Semua Kota/Kabupaten -- </option>" );
						} else {
							get_location(params);
						}
						$( "#select-kecamatan ").html( "<option value=\'0\'> -- Semua Kecamatan -- </option>" );
						$( "#select-kelurahan ").html( "<option value=\'0\'> -- Semua Kelurahan -- </option>" );
					});

					$("#select-kabupaten").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "4",
							"title": "Kecamatan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kecamatan ").html( "<option value=\'0\'> -- Semua Kecamatan -- </option>" );
						} else {
							get_location(params);
						}
						$( "#select-kelurahan ").html( "<option value=\'0\'> -- Semua Kelurahan -- </option>" );
					});

					$("#select-kecamatan").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "5",
							"title": "Kelurahan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kelurahan ").html( "<option value=\'0\'> -- Semua Kelurahan -- </option>" );
						} else {
							get_location(params);
						}
					});

					$( "button#cari" ).on( "click", function(){
						$("#loader").modal("show");
						$( "#gridview" ).flexOptions({
							url: "' . $this->dir . 'get_show_data",
							params: [
								{
									"province_id": $( "#select-propinsi ").val(),
									"regency_id": $( "#select-kabupaten ").val(),
									"district_id": $( "#select-kecamatan ").val(),
									"village_id": $( "#select-kelurahan ").val(),
									"stereotype": $( "#select-status ").val(),
									"status_rumahtangga": $( "#select-hasil-musdes ").val(),
									"hasil_verivali": $( "#select-hasil-verivali ").val(),
								},
							],
						}).flexReload();
						$("#loader").modal("hide");
					});
					
					$( "button#print" ).on( "click", function(){
						var kelurahan = $( "#select-kelurahan ").val();
						if (kelurahan == 0) {
							alert("Maaf, Anda harus mengisi data sampai tingkat kelurahan");
							return false;
						}
						window.open("' . $this->dir . 'print_data/"+ kelurahan, "", "top=10,left=600,width=500, height=600");
		
					});

					var get_location = ( params ) => {
						$.ajax({
							url: "' . $this->dir . 'get_show_location",
							type: "GET",
							data: $.param(params),
							dataType: "json",
							beforeSend: function( xhr ) {
								$("#modalLoader").modal("show");
							},
							success : function(data) {

								let option = `<option value="0"> -- Semua ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )} -- </option>`;
								$.each( data, function(k,v) {
									option += `<option value="${k}">${v}</option>`;
								});
								$("#select-" + params.title.toLowerCase() ).html( option );
							},
						});
					};
				});
			</script>
		';
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_print", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data() {
		$user_id = $this->user_info['user_id'];
		$location_user = $this->auth_model->ambil_location_get($user_id);
		$input = $this->input->post();
		$where = [];
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ( $value > '0' ) $where['l.' . $field] = $value;
			}
			if ( ( in_array( 'root', $this->user_info['user_group'] ) ? FALSE :  TRUE) ) {
				$where['l.location_id' ." IN ({$location_user['village_codes']})"]  = null;
			}
		} else {
			if ( ( ! empty( $this->user_info['user_location'] ) ) && ( in_array( 'root', $this->user_info['user_group'] ) ? FALSE :  TRUE ) ){
				$where['l.location_id' ." IN ({$location_user['village_codes']})"]  = null;
			}elseif ( ( ! empty( $this->user_info['user_location'] ) ) && ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE :  FALSE ) ){
				$user_location = $this->get_user_location();
				$jml_negara = ( ( ! empty( $user_location['country_id'] ) ) ? count( explode( ',', $user_location['country_id'] ) ) : '0' );
				if ( ! empty( $jml_negara) ) $where['l.country_id ' . ( ( $jml_negara >= '2' ) ? "IN ({$user_location['country_id']}) " : "= {$user_location['country_id']}" )] = null;

			} else {
				$where['l.country_id'] = '0';
				$where['l.province_id'] = '0';
				$where['l.regency_id'] = '0';
			}
		}
		$where['md.stereotype'] = 'PROVINCE-PUBLISHED';
		
		$params = [
			'table' => [
				'asset.master_data_proses md' => '',
				'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left'],
				'dbo.ref_references r' => ['r.short_label = md.stereotype', 'left'],
			],
			'select' => "
				md.proses_id,
				md.stereotype,
				md.row_status,
				md.status_rumahtangga,
				md.jenis_kelamin_krt,
				md.nama_pasangan_krt,
				md.apakah_mampu,
				md.id_prelist,
				md.nomor_nik,
				md.nama_krt,
				md.alamat,
				md.lastupdate_on,
				l.province_name,
				l.regency_name,
				l.district_name,
				l.village_name,
				r.icon",
			'order_by' => 'md.lastupdate_on ' . $input['sortorder'],
			'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
			'where' => $where
		];
		
		$params_count = [
			'table' => [
				'asset.master_data_proses md' => '',
				'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left'],
			],
			'select' => 'count(proses_id) jumlah',
			'where' => $where,
		];
		if ( ! empty( $input['querys'] ) ) {
			$filterRules = filter_json( $input['querys'] );
			$params = array_merge( $params, $filterRules );
			$params_count = array_merge( $params_count, $filterRules );
		}
		$query = get_data( $params );
		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$status = '<img src="' . base_url('assets/style/icon-status') . '/' . $row->icon . '">';
			$jenis_kelamin_krt='';
			if($row->jenis_kelamin_krt=='1')
				$jenis_kelamin_krt='Laki-laki';
			elseif($row->jenis_kelamin_krt=='2')
				$jenis_kelamin_krt='Perempuan';
			
			$row_data = [
				'id' => $row->proses_id,
				'cell' => [
					'status' => $status,
					'nama_pasangan_krt' => $row->nama_pasangan_krt,
					'jenis_kelamin_krt' => $jenis_kelamin_krt,
					'id_prelist' => $row->id_prelist,
					'nama_krt' => $row->nama_krt,
					'nomor_nik' => $row->nomor_nik,
					'alamat' => $row->alamat,
					'province_name' => $row->province_name,
					'regency_name' => $row->regency_name,
					'district_name' => $row->district_name,
					'village_name' => $row->village_name,
					'last_update_data' => $row->lastupdate_on,
				]
			];
			$data[] = $row_data;
		}
		$result = [
			'status' => 200,
			'total' => $query->num_rows(),
			'rows' => $data,
			'page' => $input['page'],
			'total' => $query_count->row('jumlah')
		];
		echo json_encode( $result );
	}
	
	

	function form_cari() {
		$user_location = $this->get_user_location();
		$jml_negara = count( explode( ',', $user_location['country_id'] ) );
		$jml_propinsi = count( explode( ',', $user_location['province_id'] ) );
		$jml_kota = count( explode( ',', $user_location['regency_id'] ) );
		$jml_kecamatan = count( explode( ',', $user_location['district_id'] ) );
		$jml_kelurahan = count( explode( ',', $user_location['village_id'] ) );
		
		$option_propinsi = '<option value="0">-- Semua Provinsi --</option>';
		$option_kelurahan = '<option value="0">-- Semua Kelurahan --</option>';
		$option_kota = '<option value="0">-- Semua Kota/Kabupaten --</option>';
		$option_kecamatan = '<option value="0">-- Semua Kecamatan --</option>';
		$option_kelurahan = '<option value="0">-- Semua Kelurahan --</option>';
		

		$where_propinsi = [];
		if ( ! empty( $user_location['province_id'] ) ) {
			if ( $jml_propinsi > '0' ) $where_propinsi['province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}" )] = null;
		}

		$params_propinsi = [
			'table' => 'asset.vw_administration_regions',
			'select' => 'DISTINCT province_id, propinsi',
			'where' => $where_propinsi,
			'order_by' => 'propinsi',
		];
		$query_propinsi = get_data( $params_propinsi );
		foreach ( $query_propinsi->result() as $key => $value ) {
				$option_propinsi .= '<option value="' . $value->province_id . '">' . $value->propinsi . '</option>';
		}
		
		
		$form_cari = '
			<div class="row">
				<div class="row col-md-12">
				<div class="form-group col-md-2">
					<select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" >
						' . $option_propinsi . '
					</select>
				</div>
				<div class="form-group col-md-2">
					<select id="select-kabupaten" name="kabupaten" class="js-example-basic-single form-control" >
						' . $option_kota . '
					</select>
				</div>
				<div class="form-group col-md-2">
					<select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control">
						' . $option_kecamatan . '
					</select>
				</div>
				<div class="form-group col-md-2">
					<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" >
						' . $option_kelurahan . '
					</select>
				</div>
				<div class="form-group col-md-3 float-right">
					<button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Cari</button>
					<button type="button" id="print" class="btn btn-info btn-sm"><i class="fa fa-print"></i>&nbsp;Cetak Data</button>
				</div>
				</div>
			</div>

			
		';
		return $form_cari;
		
	}

	function get_user_location() {
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '';
		$province_id = '';
		$regency_id = '';
		$district_id = '';
		$village_id = '';
		if ( ! empty( $user_location ) ) {
			$count = count( $user_location );
			$no = 1;
			foreach ( $user_location as $loc ) {
				$params_location = [
					'table' => 'dbo.ref_locations',
					'where' => [
						'location_id' => $loc
					]
				];
				$query = get_data( $params_location );
				$country_id = $query->row( 'country_id' ) . ( ( $no < $count ) ? ',' : '' );
				$province_id = $province_id.''.$query->row( 'province_id' ) . ( ( !empty($query->row( 'province_id' )) && $no < $count ) ? ',' : '' );
				$regency_id = $regency_id.''.$query->row( 'regency_id' ) . ( ( !empty($query->row( 'regency_id' )) && $no < $count ) ? ',' : '' );
				$district_id = $district_id.''.$query->row( 'district_id' ) . ( ( !empty($query->row( 'district_id' )) && $no < $count ) ? ',' : '' );
				$village_id = $village_id.''.$query->row( 'village_id' ) . ( ( !empty($query->row( 'village_id' )) && $no < $count ) ? ',' : '' );
				$no++;
			}
		}
		$res_loc = [
			'country_id' => $country_id,
			'province_id' => $this->merge_location($province_id),
			'regency_id' => $this->merge_location($regency_id),
			'district_id' =>  $this->merge_location($district_id),
			'village_id' =>  $this->merge_location($village_id),
		];
		return($res_loc);

	}

	function merge_location($location_id)
	{
		$tes =explode(',', $location_id);
		sort($tes);
		$str = implode(',',array_unique($tes));
		$str=ltrim($str,',');
		return $str;
	}

	function get_show_location(){
		$user_location = $this->get_user_location();
		$regency_id= $user_location['regency_id'];
		$district_id= $user_location['district_id'];
		$village_id= $user_location['village_id'];
		$id_location=$_GET['location_id'];
		//die;
		$level=$_GET['level'];
		if($level==3)
		{	$parent_id='province_id';
			$parent = "province_id=$id_location";
			if( in_array( 'root', $this->user_info['user_group'] ) ? FALSE : TRUE )
			{
				if(empty($regency_id))
				{
					$child_id ="1=1";
				}
				else
				{
					$child = "regency_id in ($regency_id)";
					if($this->cek_location($parent,$child)>0)
						$child_id ="regency_id in ($regency_id)";
					else
						$child_id ="regency_id not in ($regency_id)";
				}
			}
			else
			{
				$child_id ="1=1";
			}
		}elseif($level==4)
		{	$parent_id='regency_id';
			$parent = "regency_id=$id_location";
			if( in_array( 'root', $this->user_info['user_group'] ) ? FALSE : TRUE )
			{
				if(empty($district_id))
				{
					$child_id ="1=1";
				}
				else
				{
					$child = "district_id in ($district_id)";
					if($this->cek_location($parent,$child)>0)
						$child_id ="district_id in ($district_id)";
					else
						$child_id ="district_id not in ($district_id)";
				}
			}
			else
			{
				$child_id ="1=1";
			}
		}if($level==5)
		{	$parent_id='district_id';
			$parent = "district_id=$id_location";
			if( in_array( 'root', $this->user_info['user_group'] ) ? FALSE : TRUE )
			{
				if(empty($village_id))
				{
					$child_id ="1=1";
				}
				else
				{
					$child = "village_id in ($village_id)";
					if($this->cek_location($parent,$child)>0)
						$child_id ="village_id in ($village_id)";
					else
						$child_id ="village_id not in ($village_id)";
				}
			}
			else
			{
				$child_id ="1=1";
			}
		}

		$params = [
			'table' => 'asset.vw_administration_regions',
			'where' => [
				$parent_id => $_GET['location_id'],
				$child_id => null
			],
			'select' => 'DISTINCT regency_id, district_id, village_id, kabupaten, kecamatan, kelurahan'
		];
		$query = get_data( $params );
		$data = [];
		foreach  ( $query->result() as $rows ) {
			if($level==3)
			{
				$location_id=$rows->regency_id;
				$name=$rows->kabupaten;
			}elseif($level==4)
			{	$location_id=$rows->district_id;
				$name=$rows->kecamatan;
			}if($level==5)
			{	$location_id=$rows->village_id;
				$name=$rows->kelurahan;
			}
			$data[$location_id] = $name;
		}
		echo json_encode( $data );
	}

	function cek_location($parent, $child){
		$params = [
			'table' => 'asset.vw_administration_regions',
			'where' => [
				$parent => null,
				$child => null
			],
			'select' => 'DISTINCT regency_id, district_id, village_id, kabupaten, kecamatan, kelurahan'
		];
		$query = get_data( $params );
		return $query->num_rows();
	}

}
