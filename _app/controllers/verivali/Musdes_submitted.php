<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// show status 6
class Musdes_submitted extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'verivali/musdes_submitted/' );
		$this->load->model('auth_model');
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
		$data['cari'] = $this->form_cari();
		$data['paste_url'] = $this->dir;
		$data['grid'] = [
			'col_id' => 'proses_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'status', display:'Status', width:40, sortable:false, align:'center', datasuorce: false},
				{ name:'id_prelist', display:'Id Prelist', width:110, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_krt', display:'Nama KRT', width:110, sortable:true, align:'left', datasuorce: false},
				{ name:'nomor_nik', display:'NIK', width:110, sortable:false, align:'center', datasuorce: false},
				{ name:'alamat', display:'Alamat', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'province_name', display:'Propinsi', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kabupaten',  width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Kelurahan', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'detail', display:'Detail', width:50, sortable:true, align:'center', datasuorce: false},
				{ name:'jenis_kelamin_krt', display:'Gender', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_pasangan_krt', display:'Pasangan', width:90, sortable:true, align:'left', datasuorce: false},
				{ name:'status_rumahtangga', display:'Status', width:80, sortable:true, align:'center', datasuorce: false},
				{ name:'apakah_mampu', display:'Mampu', width:50, sortable:true, align:'center', datasuorce: false},
				{ name:'petugas_musdes', display:'Enum Musdes', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:100, sortable:true, align:'left', datasuorce: false},
				",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Publish', name:'publish', bclass:'publish', onpress:act_show, urlaction: '" . $this->dir . "act_show'},
				{ separator: true },
				{ display:'Assign Data to Enum', name:'assign', bclass:'publish', onpress:act_assign, urlaction: '" . $this->dir . "act_assign'},
				{ display:'Copy Id Prelist', name:'copy', bclass:'copy', onpress:copy_id, urlaction: '" . $this->dir . "copy_id'},
                { separator: true },
				{ display:'Is In Prelist', name:'paste', bclass:'paste', onpress:paste_id, urlaction: '" . $this->dir . "paste_id'},
				{ separator: true },
				{ display:'Not In Prelist', name:'not_in', bclass:'not_in', onpress:not_in_id, urlaction: '" . $this->dir . "not_in_id'},
				{ separator: true },
			",
			'filters' => "
				{ display:'ID Prelist', name:'md.id_prelist', type:'text', isdefault: true },
				{ display:'Nama KRT', name:'md.nama_krt', type:'text' },
				{ display:'NIK', name:'md.nomor_nik', type:'text' },
				{ display:'Alamat', name:'md.alamat', type:'text' },
				{ display:'Pasangan', name:'md.nama_pasangan_krt', type:'text' },
				{ display:'Mampu', name:'md.apakah_mampu', type:'select', option: '1:Ya|2:Tidak' },
				{ display:'Enum Musdes', name:'surveyor_musdes', type:'text', isdefault: true },
				{ display:'Last Update', name:'md.last_update_data', type:'date' },

			",
		];
		$data['grid']['title'] = 'Publish Pre-List Akhir Musdes';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$data['extra_script'] = '
		<div id="dlgChooseUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dlgChooseUser" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div id="modalContentEnum" class="modal-content">
				</div>
			</div>
		</div>
			<script>
				$(document).ready( function(){
					$("#select-propinsi").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "3",
							"title": "Kabupaten",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kabupaten ").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
							$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );							 
							$( "#select-kabupaten").select2();
							$( "#select-kecamatan").select2();
							$( "#select-kelurahan").select2();

						} else {
							$( "#select-kabupaten").html( "<option value=\'0\'>Loading... </option>" );  
							$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );							 
							$( "#select-kabupaten").select2();
							$( "#select-kecamatan").select2();
							$( "#select-kelurahan").select2();
							get_location(params);
						}
						$( "#select-kabupaten").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
						$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
						$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
					});

					$("#select-kabupaten").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"select-propinsi": $("#select-propinsi").val(),
							"level": "4",
							"title": "Kecamatan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kecamatan ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );							 
							$( "#select-kecamatan").select2();
							$( "#select-kelurahan").select2();

						} else {
							$( "#select-kecamatan").html( "<option value=\'0\'>Loading... </option>" );   
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
							$( "#select-kecamatan").select2();
							$( "#select-kelurahan").select2();
							get_location(params);
						}
						$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
						$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
					});

					$("#select-kecamatan").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"select-propinsi": $("#select-propinsi").val(),
							"select-kabupaten": $("#select-kabupaten").val(),
							"level": "5",
							"title": "Kelurahan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
							$( "#select-kelurahan").select2();

						} else {
							$( "#select-kelurahan").html( "<option value=\'0\'>Loading... </option>" );     
							$( "#select-kelurahan").select2();
							get_location(params);
						}
						$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
					});

					$( "button#cari" ).on( "click", function(){
						$("#load_page").removeClass("hidden");
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
								},
							],
						}).flexReload();
						$("#loader").modal("hide");
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

								let option = `<option value="0"> -- Pilih ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )} -- </option>`;
								$.each( data, function(k,v) {
									option += `<option value="${k}">${v}</option>`;
								});
								$( "#select-" + params.title.toLowerCase() ).select2();
								$("#select-" + params.title.toLowerCase() ).html( option );
							},
						});
					};
				});
			</script>
		';
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_data", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data(){
		$user_id = $this->user_info['user_id'];
		$location_user = $this->auth_model->ambil_location_get($user_id);
		$input = $this->input->post();
		$where = [];
		$where_in = [];
		$is_in = '';
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ($field == 'id_prelist') {
                    if ( $value > '0' )
                    $pre_arr = explode("\n", $value);
                    $val_prelist = [];
                    for ($i=0; $i < count($pre_arr); $i++) {
                        $val_prelist[] = $pre_arr[$i];
                    }
                    $where_in['md.' . $field] = $val_prelist;
                } else if ( $field == 'stereotype' || $field == 'status_rumahtangga' ) {
					if ( $value > '0' ) $where['md.' . $field] = $value;
				} else if ( $field == 'is_in'){
					if ( $value > '-1' ) $is_in = $value;
				} else {
					if ( $value > '0' ) $where['l.' . $field] = $value;
				}
			}
			if ( ( in_array( 'root', $this->user_info['user_group'] ) ? FALSE :  TRUE) ) {
				$where['l.location_id' ." IN ({$location_user['village_codes']})"]  = null;
			}
		} else {
			$where['md.stereotype'] = 'MUSDES-SUBMITTED';
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
				$where['l.district_id'] = '0';
				$where['l.village_id'] = '0';
			}
		}

		$par = $input['querys'];
		$where_querys = [];
		if ( !empty($par) ) {
			$params = json_decode( $par, true );
			foreach ($params as $key => $value) {
				$where_querys[$value['filter_field']] = $value['filter_value'];
			}
		}
        $sql_where = '';

        foreach ($where_querys as $key => $value) {
            if ($key == 'surveyor_musdes') {
				$sql_where .= "u1.user_profile_first_name LIKE '%" .$value. "%' AND ";
			} else if ($key == 'surveyor_verval') {
				$sql_where .= "u2.user_profile_first_name LIKE '%" .$value. "%' AND ";
			} else {
				$sql_where .= $key." LIKE '%" .$value. "%' AND ";
			}
		}

        foreach ($where as $key => $value) {
			if ($value == '') {
				$sql_where .= $key.' AND ';
			} else if ($key == 'md.stereotype') {
				$sql_where .= $key." = '" .$value. "' AND ";
			} else {
				$sql_where .= $key.' = ' .$value .' AND ';
			}
		}

		$in_opt = $is_in > 0 ? 'IN' : 'NOT IN';
		$sql_where_in = '';
		if ( isset($where_in['md.id_prelist'])) {
			$data_in = "'" . implode("','", $where_in['md.id_prelist']) . "'";
			$in_where = preg_replace('/\s+/', '', $data_in);
			$sql_where_in = 'AND md.id_prelist '.$in_opt.' (' .$in_where. ')';
		}

		$sort = $input['sortorder'];
		$offset = ( ( $input['page'] - 1 ) * $input['rp'] );		
		$rp = $input['rp'];
		$list = 'id_prelist';
		$stereotype = $where["md.stereotype"];

		if ( !isset( $where["l.province_id"] )) 	
		{
			// $sql_query = "exec [dbo].[stp_stereotype_published] 1,0,0,0,0,'''$stereotype''','$sort',$offset,$rp";
			// $sql_count = "exec [dbo].[stp_count_published] 1,0,0,0,0";
			$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0,0,'''$stereotype''','$sort',$offset,$rp";
			$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 1,'" . $this->user_info['text'] . "',$list,0,0,0,0,'''$stereotype'''";
		}
		else
		{
			if ( isset( $where["l.province_id"] )) 
			{
				$province = (int)$where["l.province_id"];
				// $sql_query = "exec [dbo].[stp_stereotype_published] 2,$province,0,0,0,'''$stereotype''','$sort',$offset,$rp";
				// $sql_count = "exec [dbo].[stp_count_published] 2,$province,0,0,0";
				$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 2,'" . $this->user_info['text'] . "',$province,0,0,0,'''$stereotype''','$sort',$offset,$rp";
				$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 2,'" . $this->user_info['text'] . "',$list,$province,0,0,0,'''$stereotype'''";
			}
			if ( isset( $where["l.regency_id"] )) 
			{
				$province = (int)$where["l.province_id"];
				$regency = (int)$where["l.regency_id"];
				// $sql_query = "exec [dbo].[stp_stereotype_published] 3,$province,$regency,0,0,'''$stereotype''','$sort',$offset,$rp";
				// $sql_count = "exec [dbo].[stp_count_published] 3,$province,$regency,0,0";
				$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 3,'" . $this->user_info['text'] . "',$province,$regency,0,0,'''$stereotype''','$sort',$offset,$rp";
				$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 3,'" . $this->user_info['text'] . "',$list,$province,$regency,0,0,'''$stereotype'''";
			}
			if ( isset( $where["l.district_id"] )) 
			{
				$province = (int)$where["l.province_id"];
				$regency = (int)$where["l.regency_id"];
				$district = (int)$where["l.district_id"];
				// $sql_query = "exec [dbo].[stp_stereotype_published] 4,$province,$regency,$district,0,'''$stereotype''','$sort',$offset,$rp";
				// $sql_count = "exec [dbo].[stp_count_published] 4,$province,$regency,$district,0";
				$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 4,'" . $this->user_info['text'] . "',$province,$regency,$district,0,'''$stereotype''','$sort',$offset,$rp";
				$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 4,'" . $this->user_info['text'] . "',$list,$province,$regency,$district,0,'''$stereotype'''";
			}
			if ( isset( $where["l.village_id"] )) 
			{
				$province = (int)$where["l.province_id"];
				$regency = (int)$where["l.regency_id"];
				$district = (int)$where["l.district_id"];
				$village = (int)$where["l.village_id"];
				// $sql_query = "exec [dbo].[stp_stereotype_published] 5,$province,$regency,$district,$village,'''$stereotype''','$sort',$offset,$rp";
				// $sql_count = "exec [dbo].[stp_count_published] 5,$province,$regency,$district,$village";
				$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 5,'" . $this->user_info['text'] . "',$province,$regency,$district,$village,'''$stereotype''','$sort',$offset,$rp";
				//$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 5,'" . $this->user_info['text'] . "',$list,$province,$regency,$district,$village,'''$stereotype'''";
			}

		}

		// $sql_query = "
		// 	SELECT
		// 	DISTINCT
		// 		md.proses_id,
		// 		md.stereotype,
		// 		md.row_status,
		// 		md.id_prelist,
		// 		md.nomor_nik,
		// 		md.nama_krt,
		// 		md.alamat,
		// 		md.jenis_kelamin_krt,
		// 		md.nama_pasangan_krt,
		// 		md.status_rumahtangga,
		// 		md.apakah_mampu,
		// 		concat ( u1.user_profile_first_name, ' ', u1.user_profile_last_name ) AS surveyor_musdes,
		// 		md.lastupdate_on,
		// 		l.propinsi province_name,
		// 		l.kabupaten regency_name,
		// 		l.kecamatan district_name,
		// 		l.kelurahan village_name,
		// 		r.icon
		// 	FROM
		// 		asset.master_data_proses md
		// 		LEFT join
		// 		master_location2 l
		// 					on
		// 					md.kode_propinsi = l.bps_province_code
		// 					and md.kode_kabupaten = l.bps_regency_code
		// 					and md.kode_kecamatan = l.bps_district_code
		// 					and md.kode_desa = l.bps_village_code
		// 		LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
		// 		LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id 
		// 		AND a1.stereotype = 'MUSDES'	AND a1.row_status = 'ACTIVE'
		// 		LEFT JOIN dbo.core_user_profile u1 ON a1.user_id = u1.user_profile_id
				
		// 		WHERE " . $this->user_info['text'] . " AND 1=1 and md.stereotype IN ('MUSDES-SUBMITTED','VERIVALI-PUBLISHED')
		// 		ORDER BY md.lastupdate_on ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		// ";

		$sql_count = "
			SELECT COUNT
				( id_prelist ) jumlah
			FROM
				asset.master_data_proses md
				LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
				LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
				LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id AND a1.stereotype = 'MUSDES'	AND a1.row_status = 'ACTIVE'
				LEFT JOIN dbo.core_user_profile u1 ON a1.user_id = u1.user_profile_id
			WHERE $sql_where 1=1 $sql_where_in
		";

		$query = data_query( $sql_query );
		$query_count = data_query( $sql_count );

		header("Content-type: application/json");
		
		$data = [];

		$_counter = 0;

		foreach ( $query->result() as $par => $row ) {
			$status = '<img src="' . base_url('assets/style/icon-status') . '/' . $row->icon . '">';
			$status_ruta = '';
			$mampu = '';
			$gender = "";

			if($row->jenis_kelamin_krt == '1') {
				$gender = "Laki-laki";
			} else if ($row->jenis_kelamin_krt == '2') {
				$gender = "Perempuan";
			}
			if($row->status_rumahtangga == '1') {
				$status_ruta = "<span class='text-success font-weight-bold'>Ditemukan</span>";
			} else if ($row->status_rumahtangga == '2') {
				$status_ruta = "<span class='text-danger font-weight-bold'>Tidak Ditemukan</span>";
			} else if ($row->status_rumahtangga == '3') {
				$status_ruta = "<span class='text-warning font-weight-bold'>Data Ganda</span>";
			} else if ($row->status_rumahtangga == '4') {
				$status_ruta = "<span class='text-primary font-weight-bold'>Usulan Baru</span>";
			}

			if($row->apakah_mampu == '1') {
				$mampu = "<span class='text-danger font-weight-bold'>Ya</span>";
			} else if ($row->apakah_mampu == '2') {
				$mampu = "<span class='text-success font-weight-bold'>Tidak</span>";
			}

			$detail = '<button class="btn-edit" act="' . base_url( "verivali/detail_data/get_form_detail/" . enc( ['proses_id' => $row->proses_id] ) ) . '"><i class="fa fa-search"></i></button>';

			$lastupdate = date("d-m-Y H:i:s",strtotime($row->lastupdate_on));

			$row_data = [
				'id' => $row->proses_id,
				'cell' => [
					'status' => $status,
					'id_prelist' => $row->id_prelist,
					'nama_krt' => $row->nama_krt,
					'nomor_nik' => $row->nomor_nik,
					'alamat' => $row->alamat,
					'province_name' => $row->province_name,
					'regency_name' => $row->regency_name,
					'district_name' => $row->district_name,
					'village_name' => $row->village_name,
					'jenis_kelamin_krt' => $gender,
					'nama_pasangan_krt' => $row->nama_pasangan_krt,
					'status_rumahtangga' => $status_ruta,
					'apakah_mampu' => $mampu,
					'petugas_musdes' => $row->surveyor_musdes,
					'last_update_data' => $row->lastupdate_on,
					'detail' => $detail,

				]
			];
			$data[] = $row_data;
			$_counter++;
		}

		$result = [
			'status' => 200,
			'total' => $_counter,
			'rows' => $data,
			'page' => $input['page'],
		];
		echo json_encode( $result );
	}

	function act_show(){
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();

		// publish
		if ( isset( $in['publish'] ) && $in['publish'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ($arr_id as $id) {
					$params_get_audit_trail = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'audit_trails'
					];
					$user_ip = client_ip();
					$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );
					$audit_trails[] = [
						"ip" => $user_ip['ip_address'],
						"on" => $datetime,
						"act" => "COPY",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"asset_id" => $id,
							"stereotype" => 'VERIVALI-PUBLISHED'
						],
						"is_proxy_access" => $user_ip['is_proxy']
					];
					$params_update_master_data = [
						'table' => 'asset.master_data_proses',
						'data' => [
							'stereotype' => 'VERIVALI-PUBLISHED',
							'audit_trails' => json_encode( $audit_trails ),
							'lastupdate_on' => $datetime,
						],
						'where' => [
							'proses_id' => $id
						],
					];
					// save_data( $params_update_master_data);
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'proses_id, stereotype, row_status'
					];
					$get_data = get_data( $params_get )->row();
					// $params_insert_master_data_log = [
					// 	'data_log_master_data_id' => $get_data->proses_id,
					// 	'data_log_status' => 'sukses',
					// 	'data_log_description' => $get_data->proses_id,
					// 	'data_log_stereotype' => $get_data->stereotype,
					// 	'data_log_row_status' => $get_data->row_status,
					// 	'data_log_lastupdate_by' => $this->user_info['user_id'],
					// 	'data_log_lastupdate_on' => $datetime,
					// ];
					// save_data( 'asset.master_data_log', $params_insert_master_data_log);


					$stereotype = 'VERIVALI-PUBLISHED';
					$audit = json_encode( $audit_trails );
					$lastupdate = $datetime;
					$this->db->query("exec [update_publish_korkab] 1, '''$stereotype''', '''$audit''', '''$lastupdate''','$id'");

					// insert master_data_log					
					$user_id = $this->user_info['user_id'];
					$this->db->query("exec [update_master_data_log] 1,'$user_id','$datetime', '$get_data->proses_id','','$datetime','$id','$get_data->row_status','sukses','$get_data->stereotype'");


					$success++;
				}

				$arr_output['message'] = $success .' data berhasil dipublish.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}
		echo json_encode( $arr_output );
	}

	function form_cari() {

		$option_propinsi = '<option value="0">Pilih Provinsi</option>';
		$option_kelurahan = '<option value="0">Pilih Kelurahan</option>';
		$option_kota = '<option value="0">Pilih Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Pilih Kecamatan</option>';
		$option_kelurahan = '<option value="0">Pilih Kelurahan</option>';

		$params_propinsi = "exec [dbo].[get_level_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
		$query_propinsi = $this->db->query($params_propinsi);
		// $query_propinsi = get_data( $params_propinsi );
		foreach ( $query_propinsi->result() as $key => $value ) {
				$option_propinsi .= '<option value="' . $value->province_id . '">' . $value->propinsi . '</option>';
		}


		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
				<div class="form-group col-md-3">
					<select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" >
						' . $option_propinsi . '
					</select>
				</div>
				<div class="form-group col-md-3">
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
				<div class="form-group col-md-3">
					<select id="select-status" name="status" class="js-example-basic-single form-control">
						<option value="MUSDES-SUBMITTED">6.DATA VALID Hasil Musdes</option>
						<option value="VERIVALI-PUBLISHED">7.Prelist Akhir DIPUBLISH KORKAB</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-hasil-musdes" name="hasil_musdes" class="js-example-basic-single form-control">
						<option value="0">Semua Hasil Musdes</option>
						<option value="1">Ditemukan</option>
						<option value="2">Tidak Ditemukan</option>
						<option value="4">Usulan Baru</option>
					</select>
				</div>
				<div class="form-group col-md-2">
					<button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Refresh</button>
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
		{	
			$params = "exec [dbo].[get_level_new_v1] 2,'" . $this->user_info['text'] . "'," . $id_location . ",0,0";
			
		}elseif($level==4)
		{	
			$select_propinsi=$_GET['select-propinsi'];
			$params = "exec [dbo].[get_level_new_v1] 3,'" . $this->user_info['text'] . "',". $select_propinsi . "," . $id_location . ",0";
			
		}else //if($level==5)
		{	
			$select_propinsi=$_GET['select-propinsi'];
			$select_kabupaten=$_GET['select-kabupaten'];
			$params = "exec [dbo].[get_level_new_v1] 4,'" . $this->user_info['text'] . "',". $select_propinsi . "," . $select_kabupaten . "," . $id_location ;
		}

		$query = $this->db->query($params);
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
		$params = "exec [dbo].[get_level_new_v1] 5,0,0,0";
		$query = $this->db->query($params_propinsi);
		return $query->num_rows();
	}


	function act_enum(){
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();

		// publish
		if ( isset( $in['assign'] ) && $in['assign'] ) {
			$arr_id = json_decode( $in['item'] );
			$prelist = json_decode( $in['prelist'] );
			if ( is_array( $arr_id ) ) {
				$success = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ( $arr_id as $id ) {
					foreach ( $prelist as $id_prelist ) {
						$params_get_audit_trail = [
							'table' => 'asset.master_data_proses',
							'where' => [
								'proses_id' => $id_prelist
							],
							'select' => 'audit_trails'
						];
						$user_ip = client_ip();
						$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );
						$audit_trails[] = [
							"ip" => $user_ip['ip_address'],
							"on" => $datetime,
							"act" => "COPY",
							"user_id" => $this->user_info['user_id'],
							"username" => $this->user_info['user_username'],
							"column_data" => [
								"asset_id" => $id_prelist,
								"stereotype" => 'VERIVALI-GRABBED'
							],
							"is_proxy_access" => $user_ip['is_proxy']
						];
						$params_update_master_data = [
							'table' => 'asset.master_data_proses',
							'data' => [
								'stereotype' => 'VERIVALI-GRABBED',
								'audit_trails' => json_encode( $audit_trails ),
								'lastupdate_on' => $datetime,
							],
							'where' => [
								'proses_id' => $id_prelist
							],
						];
						// save_data( $params_update_master_data );
						$params_get = [
							'table' => 'asset.master_data_proses',
							'where' => [
								'proses_id' => $id_prelist
							],
							'select' => 'proses_id, stereotype, row_status'
						];
						$get_data = get_data( $params_get )->row();
						$params_insert_master_data_log = [
							'data_log_master_data_id' => $get_data->proses_id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'Assign Data proses_id ' . $get_data->proses_id,
							'data_log_stereotype' => $get_data->stereotype,
							'data_log_row_status' => $get_data->row_status,
							'data_log_lastupdate_by' => $this->user_info['user_id'],
							'data_log_lastupdate_on' => $datetime,
						];
						// save_data( 'asset.master_data_log', $params_insert_master_data_log);


						$stereotype = $update_master_data_proses[0]['stereotype'];
						$audit = json_encode( $audit_trails );
						$lastupdate = $update_master_data_proses[0]['lastupdate_on'];
						$this->db->query("exec [update_publish_korkab] 1, '''$stereotype''', '''$audit''', '''$lastupdate''','$id'");
	
						// insert master_data_log					
						$user_id = $this->user_info['user_id'];
						$this->db->query("exec [update_master_data_log] 1,'$user_id','$datetime', '$get_data->proses_id','','$datetime','Assign Data proses_id $id','$get_data->row_status','sukses','$get_data->stereotype'");

						$params_insert_assignment = [
							'proses_id' => $id_prelist,
							'user_id' => $id,
							'stereotype' => 'VERIVALI',
							'row_status' => 'ACTIVE',
							'flag' => 'assign'
						];
						save_data( 'dbo.ref_assignment', $params_insert_assignment);

						$success++;
					}
				}

				$arr_output['message'] = $success .' data berhasil assign.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}
		echo json_encode( $arr_output );
	}

	function act_assign(){
		$in = $this->input->post();
		$data['grid'] = [
			'col_id' => 'user_account_id',
			'sort' => 'asc',
			'columns' => "
				{ name:'user_account_id', display:'User Id', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'user_account_username', display:'Username', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'user_group_title', display:'Group', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'user_full_name', display:'Nama Lengkap', width:180, sortable:true, align:'left', datasuorce: false},
				{ name:'user_profile_nik', display:'NIK', width:180, sortable:true, align:'left', datasuorce: false},
				{ name:'user_account_email', display:'Email', width:180, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Assign Data to Enum', name:'assign', bclass:'publish', onpress:act_enum, urlaction: '" . $this->dir . "act_enum'},
			",
			'filters' => "
				{ display:'User Id', name:'user_account_id', type:'text', isdefault: true },
				{ display:'Username', name:'user_account_username', type:'text', isdefault: true },
				{ display:'Group', name:'user_group_id', type:'select', option: '2:Korwil|3:Enumerator|4:Supervisor|5:Monitoring-Kualitas|1003:Korkab' },
				{ display:'NIK', name:'user_profile_nik', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Publish/Assign Pre-List Awal Musdes';
		$data['grid']['link_data'] = $this->dir . "get_show_data_user";
		$data['grid']['location_id'] = $in['location_id'];
		$data['prelist'] = $in['item'];


		$this->load->view("verivali/Detail_user", $data);
		//echo json_encode( $arr_output );
	}

	function get_show_data_user(){
		$input = $this->input->post();
		$where = [];
		$par = $input['querys'];
		if ( !empty($par) ) {
			$params = json_decode( $par, true );
			foreach ($params as $key => $value) {
				if ($value['filter_field'] == 'user_account_id') {
					$where['cua.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_account_username') {
					$where['cua.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_group_id') {
					$where['cug.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_profile_nik') {
					$where['cup.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_profile_first_name') {
					$where['cup.'.$value['filter_field']] = $value['filter_value'];
				}				
			}
		}	

		$where2 = [];
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ( $value > '0' ) $where2['l.' . $field] = $value;

			}
		}

		$loc = $where2['l.location_id'];

		$sql_where = '';	

		if (!empty($where)) {
			foreach ($where as $key => $value) {
				if ($key == 'cua.user_account_id') {
					$sql_where .= "cua.user_account_id LIKE '%" .$value. "%' AND ";
				} else if ($key == 'cua.user_account_username') {
					$sql_where .= "cua.user_account_username LIKE '%" .$value. "%' AND ";
				} else if ($key == 'cug.user_group_id') {
					$sql_where .= "cug.user_group_id LIKE '%" .$value. "%' AND ";
				} else if ($key == 'cup.user_profile_nik') {
					$sql_where .= "cup.user_profile_nik LIKE '%" .$value. "%' AND ";
				} else {
					$sql_where .= "cup.user_profile_first_name LIKE '%" .$value. "%' AND ";
				}
			}
		}

		$user_location = $this->user_info['user_location'];
		$in_location = '';

		if ( ! in_array( '100000', $user_location ) ) {
			$user_id = $this->user_info['user_id'];
			$params = "
				SELECT 
				DISTINCT user_group_title, 
				user_group_group_id, 
				user_profile_nik, 
				user_account_email, 
				user_account_id, 
				user_account_username, 
				user_account_is_active, 
				user_profile_first_name, 
				user_profile_last_name 
				FROM dbo.core_user_account cua 
				LEFT JOIN dbo.user_group ug ON cua.user_account_id = ug.user_group_user_account_id 
				LEFT JOIN dbo.core_user_profile cup ON cua.user_account_id = cup.user_profile_id 
				LEFT JOIN dbo.core_user_group cug ON ug.user_group_group_id = cug.user_group_id 
				LEFT JOIN dbo.user_location ul ON cua.user_account_id = ul.user_location_user_account_id 
				LEFT JOIN dbo.ref_locations l ON ul.user_location_location_id = l.location_id
				WHERE $sql_where 1=1	
				AND user_account_create_by = $user_id
				AND cug.user_group_id = 3	
				AND l.location_id = $loc
				ORDER BY user_account_id ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
			";

			$params_count = "
				SELECT count(DISTINCT user_account_id) jumlah FROM dbo.core_user_account cua LEFT JOIN dbo.user_group ug ON cua.user_account_id = ug.user_group_user_account_id LEFT JOIN dbo.core_user_profile cup ON cua.user_account_id = cup.user_profile_id LEFT JOIN dbo.core_user_group cug ON ug.user_group_group_id = cug.user_group_id LEFT JOIN dbo.user_location ul ON cua.user_account_id = ul.user_location_user_account_id LEFT JOIN dbo.ref_locations l ON ul.user_location_location_id = l.location_id WHERE $sql_where 1=1
				AND cug.user_group_id = 3
				AND user_account_create_by = $user_id
				AND l.location_id = $loc
			";
		} else {
			$params = "
				SELECT 
				DISTINCT user_group_title, 
				user_group_group_id, 
				user_profile_nik, 
				user_account_email, 
				user_account_id, 
				user_account_username, 
				user_account_is_active, 
				user_profile_first_name, 
				user_profile_last_name 
				FROM dbo.core_user_account cua 
				LEFT JOIN dbo.user_group ug ON cua.user_account_id = ug.user_group_user_account_id 
				LEFT JOIN dbo.core_user_profile cup ON cua.user_account_id = cup.user_profile_id 
				LEFT JOIN dbo.core_user_group cug ON ug.user_group_group_id = cug.user_group_id 
				LEFT JOIN dbo.user_location ul ON cua.user_account_id = ul.user_location_user_account_id 
				LEFT JOIN dbo.ref_locations l ON ul.user_location_location_id = l.location_id
				WHERE $sql_where 1=1	
				AND cug.user_group_id = 3	
				AND l.location_id = $loc
				ORDER BY user_account_id ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
			";

			$params_count = "
				SELECT count(DISTINCT user_account_id) jumlah FROM dbo.core_user_account cua LEFT JOIN dbo.user_group ug ON cua.user_account_id = ug.user_group_user_account_id LEFT JOIN dbo.core_user_profile cup ON cua.user_account_id = cup.user_profile_id LEFT JOIN dbo.core_user_group cug ON ug.user_group_group_id = cug.user_group_id LEFT JOIN dbo.user_location ul ON cua.user_account_id = ul.user_location_user_account_id LEFT JOIN dbo.ref_locations l ON ul.user_location_location_id = l.location_id WHERE $sql_where 1=1
				AND cug.user_group_id = 3
				AND l.location_id = $loc
			";
		}

		$query = data_query( $params );
		$query_count = data_query( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$user_full_name = $row->user_profile_first_name;
			$row_data = [
				'id' => $row->user_account_id,
				'cell' => [
					'user_account_id' => $row->user_account_id,
					'user_account_username' => $row->user_account_username,
					'user_full_name' => $user_full_name,
					'user_group_group_id' => $row->user_group_group_id,
					'user_account_email' => $row->user_account_email,
					'user_profile_nik' => $row->user_profile_nik,
					'user_group_title' => $row->user_group_title,
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
}
