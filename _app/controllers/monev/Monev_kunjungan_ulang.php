 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monev_kunjungan_ulang extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'monev/monev_kunjungan_ulang/' );
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
		$data['cari'] = $this->form_cari();
        $data['paste_url'] = $this->dir;
		$data['grid'] = [
			'col_id' => 'asset_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'status', display:'Status', width:50, sortable:false, align:'center', datasuorce: false},
				{ name:'detail', display:'Detail', width:60, sortable:false, align:'center', datasuorce: false},
				{ name:'id_prelist', display:'Id Prelist', width:140, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_krt', display:'Nama KRT', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'nomor_nik', display:'NIK', width:100, sortable:false, align:'center', datasuorce: false},
				{ name:'alamat', display:'Alamat', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'province_name', display:'Propinsi', width:130, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kabupaten',  width:130, sortable:true, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:130, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Kelurahan', width:130, sortable:true, align:'left', datasuorce: false},
				{ name:'jenis_kelamin_krt', display:'Gender', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_pasangan_krt', display:'Pasangan', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'status_rumahtangga', display:'Status Ruta', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'apakah_mampu', display:'Mampu', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'petugas_monev', display:'Petugas Monev', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:110, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Revoke', name:'revoke', bclass:'revoke', onpress:act_show, urlaction: '" . $this->dir . "act_show'},
				{ separator: true },
				{ display:'Convert [12]', name:'convert', bclass:'batch', onpress:act_show, urlaction: '" . $this->dir . "act_show'},
				{ separator: true },
				{ display:'Reject to monev [7a]', name:'reject', bclass:'publish', onpress:act_show, urlaction: '" . $this->dir . "act_show'},
				{ separator: true },
				{ display:'Revert to monev [7a]', name:'revert', bclass:'publish', onpress:act_show, urlaction: '" . $this->dir . "act_show'},
				{ separator: true },
                { display:'Copy Id Prelist', name:'copy', bclass:'copy', onpress:copy_id, urlaction: '" . $this->dir . "copy_id'},
                { separator: true },
                { display:'Is In Prelist', name:'paste', bclass:'paste', onpress:paste_id, urlaction: '" . $this->dir . "paste_id'},
				{ separator: true },
				{ display:'Not In Prelist', name:'not_in', bclass:'not_in', onpress:not_in_id, urlaction: '" . $this->dir . "not_in_id'},
				{ separator: true },
			",
			'filters' => "
                { display:'ID Prelist', name:'md.id_prelist', type:'text', isdefault: true },
                { display:'Nama KRT', name:'md.nama_krt', type:'text', isdefault: true },
                { display:'NIK', name:'md.nomor_nik', type:'text', isdefault: true },
                { display:'Petugas Monev', name:'u.user_profile_first_name', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Monitoring & Evaluasi Kunjungan Ulang Rumah Tangga';
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
									"hasil_verivali": $( "#select-hasil-verivali ").val(),
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
		$this->template->content( "general/Table_grid_view_monev", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data() {
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
                } else if ( $field == 'stereotype' || $field == 'status_rumahtangga' || $field == 'hasil_verivali' ) {
					if ( $value > '0' ) $where['md.' . $field] = $value;
                } else if ( $field == 'is_in'){
                    if ( $value > '-1' ) $is_in = $value;
				} else {
					if ( $value > '0' ) $where['l.' . $field] = $value;
				}
			}
		} else {
			if ( ( ! empty( $this->user_info['user_location'] ) ) || ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE ) ) {
				$user_location = $this->get_user_location();
				$jml_negara = ( ( ! empty( $user_location['country_id'] ) ) ? count( explode( ',', $user_location['country_id'] ) ) : '0' );
				$jml_propinsi = ( ( ! empty( $user_location['province_id'] ) ) ? count( explode( ',', $user_location['province_id'] ) ) : '0' );
				$jml_kota = ( ( ! empty( $user_location['regency_id'] ) ) ? count( explode( ',', $user_location['regency_id'] ) ) : '0' );
				$jml_kecamatan = ( ( ! empty( $user_location['district_id'] ) ) ? count( explode( ',', $user_location['district_id'] ) ) : '0' );
				$jml_kelurahan = ( ( ! empty( $user_location['village_id'] ) ) ? count( explode( ',', $user_location['village_id'] ) ) : '0' );


				if ( ! empty( $jml_negara) ) $where['l.country_id ' . ( ( $jml_negara >= '2' ) ? "IN ({$user_location['country_id']}) " : "= {$user_location['country_id']}" )] = null;
				if ( ! empty( $jml_propinsi) ) $where['l.province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : "= {$user_location['province_id']}" )] = null;
				if ( ! empty( $jml_kota) ) $where['l.regency_id ' . ( ( $jml_kota >= '2' ) ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}" )] = null;
				if ( ! empty( $jml_kecamatan) ) $where['l.district_id ' . ( ( $jml_kecamatan >= '2' ) ? "IN ({$user_location['district_id']}) " : " = {$user_location['district_id']}" )] = null;
				if ( ! empty( $jml_kelurahan) ) $where['l.village_id ' . ( ( $jml_kelurahan >= '2' ) ? "IN ({$user_location['village_id']}) " : " = {$user_location['village_id']}" )] = null;

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
			$sql_where .= $key." LIKE '%" .$value. "%' AND ";
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

        $sql_query = "
            SELECT
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
                r.icon,
                CONCAT ( u.user_profile_first_name, ' ', u.user_profile_last_name ) AS petugas_monev
            FROM monev.monev_data md
            LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
            LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
            LEFT JOIN dbo.ref_assignment a ON a.proses_id = md.proses_id
            AND a.stereotype = 'MONEV'
            AND a.row_status = 'ACTIVE'
            LEFT JOIN dbo.core_user_profile u ON a.user_id = u.user_profile_id
    		WHERE $sql_where 1=1 $sql_where_in
    		ORDER BY md.lastupdate_on ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		";

		$sql_count = "
            SELECT COUNT
                ( id_prelist ) jumlah
            FROM monev.monev_data md
            LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
            LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
            LEFT JOIN dbo.ref_assignment a ON a.proses_id = md.proses_id
            AND a.stereotype = 'MONEV'
            AND a.row_status = 'ACTIVE'
            LEFT JOIN dbo.core_user_profile u ON a.user_id = u.user_profile_id
            WHERE $sql_where 1=1 $sql_where_in
		";

        $query = data_query( $sql_query );
        $query_count = data_query( $sql_count );

		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$status = '<img src="' . base_url('assets/style/icon-status') . '/' . $row->icon . '">';
			if($row->status_rumahtangga == '1') {
				$status_ruta = "<span class='text-success font-weight-bold'>Ditemukan</span>";
			} else if ($row->status_rumahtangga == '2') {
				$status_ruta = "<span class='text-danger font-weight-bold'>Tidak Ditemukan</span>";
			} else if ($row->status_rumahtangga == '3') {
				$status_ruta = "<span class='text-warning font-weight-bold'>Data Ganda</span>";
			} else if ($row->status_rumahtangga == '4') {
				$status_ruta = "<span class='text-primary font-weight-bold'>Usulan Baru</span>";
			}

			if($row->jenis_kelamin_krt=='1')
				$jenis_kelamin_krt='Laki-laki';
			elseif($row->jenis_kelamin_krt=='2')
				$jenis_kelamin_krt='Perempuan';


			if($row->apakah_mampu == '1') {
				$mampu = "<span class='text-danger font-weight-bold'>Ya</span>";
			} else if ($row->apakah_mampu == '2') {
				$mampu = "<span class='text-success font-weight-bold'>Tidak</span>";
			}

			$detail = '<button act="' . base_url( 'monev/monev_kunjungan_ulang' ) . '/get_form_detail/' . enc( [ 'proses_id' => $row->proses_id ] ) . '" class="btn btn-warning btn-xs btn-edit" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';
			$lastupdate = date("d-m-Y H:i:s",strtotime($row->lastupdate_on));
			$row_data = [
				'id' => $row->proses_id,
				'cell' => [
					'detail' => $detail,
					'status' => $status,
					'status_rumahtangga' => $status_ruta,
					'jenis_kelamin_krt' => $jenis_kelamin_krt,
					'apakah_mampu' => $mampu,
					'nama_pasangan_krt' => $row->nama_pasangan_krt,
					'id_prelist' => $row->id_prelist,
					'nama_krt' => $row->nama_krt,
					'nomor_nik' => $row->nomor_nik,
					'alamat' => $row->alamat,
					'province_name' => $row->province_name,
					'regency_name' => $row->regency_name,
					'district_name' => $row->district_name,
					'village_name' => $row->village_name,
					'petugas_monev' => $row->petugas_monev,
					'last_update_data' => $lastupdate,
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

	function get_form_detail( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$proses_id = $params['proses_id'];
		$data = [];
		$data['proses_id'] = $params['proses_id'];
		$data['monev_detail'] = $this->get_monev_kunjung_ulang_information( $proses_id );

		$params_foto = [
			'select' => 'owner_id, row_status, internal_filename, file_name, description, file_size, latitude, longitude, created_on, created_by, file_type, user_account_username',
			'table' => [
				'dbo.files' => '',
				'dbo.core_user_account' => 'user_account_id = created_by'
			],
			'where' => [
				'owner_id' => $proses_id,
				"stereotype like 'MKU-%'" => null,
			],
		];
		$query_foto = get_data( $params_foto );
		$data['foto'] = $query_foto->result();


		$params_art = [
			'table' => 'monev.monev_data_detail',
			'where' => [
				'proses_id' => $proses_id,
				"row_status <> 'DELETED'" => null
			],
		];
		$query_art = get_data( $params_art );
		$data['art'] = $query_art->result();

		$params_kk = [
			'table' => 'monev.monev_data_detail_kk',
			'where' => [
				'proses_id' => $proses_id
			],
		];
		$query_kk = get_data( $params_kk );
		$data['kk'] = $query_kk->result();

		$this->load->view("monev/detail_monev_kunjung_ulang", $data);
	}

	function get_form_detail_art( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$id = $params['id'];
		$data = [];
		$params_art = [
			'table' => 'monev.monev_data_detail',
			'where' => [
				'id' => $id
			],
		];
		$query_art = get_data( $params_art );
		$data['art'] = $query_art->row();

		$this->load->view("monev/detail_monev_art", $data);
	}
	function get_form_detail_kk( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$id = $params['id'];
		$data = [];
		$params_kk = [
			'table' => 'monev.monev_data_detail_kk',
			'where' => [
				'id' => $id
			],
		];
		$query_kk = get_data( $params_kk );
		$data['kk'] = $query_kk->row();

		$this->load->view("monev/detail_monev_kk", $data);
	}


	function get_monev_kunjung_ulang_information( $proses_id ){
		$params_user = [
			'table' => [
				'monev.monev_data mb' => '',
				'dbo.ref_locations l' => ['mb.location_id = l.location_id', 'left'],
			],
			'where' => [
				'mb.proses_id' => $proses_id
			]
		];
		$query_user = get_data( $params_user );
		return $query_user->row();
	}

	function act_show() {
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();

		// convert
		if ( isset( $in['convert'] ) && $in['convert'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = $failed = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ( $arr_id as $id ) {
					$params_get_cek = [
						'table' => 'monev.monev_data',
						'where' => [
							'proses_id' => $id,
							"(stereotype = 'VERIVALI-SUBMITTED' or stereotype='VERIVALI-SUBMITTED-REJECT')" => null,
							"mku_hasil_verval_perbaikan <>'1'" => null
						],
					];
					$get_data_cek = get_data( $params_get_cek )->num_rows();
					if ( $get_data_cek > 0 ) {
						$is_proxy = false;
						if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
							$ip_address = $_SERVER['HTTP_CLIENT_IP'];
						} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
							//whether ip is from proxy
							$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
							$is_proxy = true;
						} else {
							//whether ip is from remote address
							$ip_address = $_SERVER['REMOTE_ADDR'];
						}
						$params_get = [
							'table' => 'monev.monev_data',
							'where' => [
								'proses_id' => $id
							],
							// 'select' => 'asset_id, stereotype, row_status'
						];
						$get_data = get_data( $params_get )->row();
						$parent_get = [
							'table' => 'asset.master_data_proses',
							'where' => [
								'proses_id' => $get_data->parent_id
							],
							// 'select' => 'asset_id, stereotype, row_status'
						];
						$get_parent = get_data( $parent_get )->row();
						unset( $get_data->proses_id );
						unset( $get_parent->proses_id );
						$get_data->stereotype = 'VERIVALI-SUPERVISOR-APPROVED';
						$get_data->server_monitoring_approval_timestamp = $datetime;
						$get_data->lastupdate_on = $datetime;
						$get_data->lastupdate_by = $this->user_info['user_id'];
						$audit_trails = json_decode( $get_data->audit_trails, true );
						$audit_trails[] = [
							"ip" => $ip_address,
							"on" => $datetime,
							"act" => "UPDATE",
							"user_id" => $this->user_info['user_id'],
							"username" => $this->user_info['user_username'],
							"column_data" => [
								"asset_id" => $id,
								"stereotype" => 'VERIVALI-SUPERVISOR-APPROVED'
							],
							"is_proxy_access" => $is_proxy
						];
						$get_data->audit_trails = json_encode($audit_trails);
						save_data( 'monev.monev_data', $get_data, [ 'proses_id' => $id ]);


						$data_baru = $this->perbaikanData( $get_data );
						save_data( 'asset.master_data_proses', $data_baru, [ 'proses_id' => $get_data->parent_id ]);

						$params_art = [
							'table' => 'monev.monev_data_detail',
							'where' => [
								'proses_id' => $id
							],
						];
						$query_art = get_data( $params_art );
						foreach ( $query_art->result() as $k => $v ) {
							$data_baru_art = $this->perbaikanDataDetail($v);
							save_data( 'asset.master_data_detail_proses', $data_baru_art, [ 'id' => $v->parent_id ]);

						}
						$params_kk = [
							'table' => 'monev.monev_data_detail_kk',
							'where' => [
								'proses_id' => $id
							],
						];
						$query_kk = get_data( $params_kk );
						foreach ( $query_kk->result() as $k => $v ) {
							$data_baru_kk = $this->perbaikanDataDetailKK($v);
							save_data( 'asset.master_data_detail_proses_kk', $data_baru_kk, [ 'id' => $v->parent_id ]);

						}
						$params_insert_master_data_log = [
							'data_log_master_data_id' => $id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'Data RT proses id ' .$get_data->parent_id.' telah lolos Verval',
							'data_log_stereotype' => $get_data->stereotype,
							'data_log_row_status' => $get_data->row_status,
							'data_log_created_by' => $this->user_info['user_id'],
							'data_log_created_on' => $datetime,
							'data_log_lastupdate_by' => null,
							'data_log_lastupdate_on' => null,
						];
						save_data( 'asset.master_data_log', $params_insert_master_data_log);

						/*
						$params_update_master_data = [
							'table' => 'asset.master_data_proses',
							'data' => [
								'stereotype' => 'PROVINCE-PUBLISHED'
							],
							'where' => [
								'proses_id' => $id
							],
						];
						save_data( $params_update_master_data);
						$this->move_detail( $id );
						*/
						$success++;

					} else {
						$failed++;
					}
				}
				$arr_output['message'] = $success .' data berhasil diconvert. <br>'.$failed .' data gagal diconvert.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		// reject
		if ( isset( $in['reject'] ) && $in['reject'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = $failed = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ( $arr_id as $id ) {
					$params_get_cek = [
						'table' => 'monev.monev_data',
						'where' => [
							'proses_id' => $id,
							'stereotype' => 'VERIVALI-SUBMITTED-REJECT'
						],
					];
					$get_data_cek = get_data( $params_get_cek )->num_rows();
					if ( $get_data_cek > 0 ) {
						$is_proxy = false;
						if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
							$ip_address = $_SERVER['HTTP_CLIENT_IP'];
						} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
							//whether ip is from proxy
							$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
							$is_proxy = true;
						} else {
							//whether ip is from remote address
							$ip_address = $_SERVER['REMOTE_ADDR'];
						}
						$params_update_assignment = [
							'table' => 'dbo.ref_assignment',
							'data' => [
								'row_status' => 'DELETED'
							],
							'where' => [
								'proses_id' => $id,
								'stereotype' => 'MONEV'
							],
						];
						save_data( $params_update_assignment);


						$params_get = [
							'table' => 'monev.monev_data',
							'where' => [
								'proses_id' => $id
							],
						];

						$get_data = get_data( $params_get )->row();
						/*
						unset( $get_data->proses_id );
						$data_baru = $this->perbaikanData( $get_data );
						*/
						$data_baru = array();
						$data_baru['stereotype'] = 'VERIVALI-REVOKED';
						$data_baru['lastupdate_on'] = $datetime;
						$data_baru['lastupdate_by'] = $this->user_info['user_id'];
						$audit_trails = json_decode( $get_data->audit_trails, true );
						$audit_trails[] = [
							"ip" => $ip_address,
							"on" => $datetime,
							"act" => "REJECT",
							"user_id" => $this->user_info['user_id'],
							"username" => $this->user_info['user_username'],
							"column_data" => [
								"asset_id" => $id,
								"stereotype" => 'VERIVALI-REVOKED'
							],
							"is_proxy_access" => $is_proxy
						];
						$data_baru['audit_trails'] = json_encode($audit_trails);
						save_data( 'monev.monev_data', $data_baru, [ 'proses_id' => $id ]);

						$params_insert_master_data_log = [
							'data_log_master_data_id' => $id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'Data Monitoring Kualitas RT ' .$get_data->id_prelist.' telah direject',
							'data_log_stereotype' => $get_data->stereotype,
							'data_log_row_status' => $get_data->row_status,
							'data_log_created_by' => $this->user_info['user_id'],
							'data_log_created_on' => $datetime,
							'data_log_lastupdate_by' => null,
							'data_log_lastupdate_on' => null,
						];
						save_data( 'asset.master_data_log', $params_insert_master_data_log);

						/*
						$params_update_master_data = [
							'table' => 'asset.master_data_proses',
							'data' => [
								'stereotype' => 'PROVINCE-PUBLISHED'
							],
							'where' => [
								'proses_id' => $id
							],
						];
						save_data( $params_update_master_data);
						$this->move_detail( $id );
						*/
						$success++;

					} else {
						$failed++;
					}
				}
				$arr_output['message'] = $success .' data berhasil direject. <br>'.$failed .' data gagal direject.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';

			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}
		// revert
		if ( isset( $in['revert'] ) && $in['revert'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = $failed = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ( $arr_id as $id ) {
					$params_get_cek = [
						'table' => 'monev.monev_data',
						'where' => [
							'proses_id' => $id,
							'stereotype' => 'VERIVALI-SUBMITTED-REJECT',
							'mku_hasil_verval_perbaikan' => 1,
							'hasil_verivali' => 1,
						],
					];
					$get_data_cek = get_data( $params_get_cek )->num_rows();
					if ( $get_data_cek > 0 ) {
						$is_proxy = false;
						if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
							$ip_address = $_SERVER['HTTP_CLIENT_IP'];
						} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
							//whether ip is from proxy
							$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
							$is_proxy = true;
						} else {
							//whether ip is from remote address
							$ip_address = $_SERVER['REMOTE_ADDR'];
						}
						$params_update_assignment = [
							'table' => 'dbo.ref_assignment',
							'data' => [
								'row_status' => 'DELETED'
							],
							'where' => [
								'proses_id' => $id,
								'stereotype' => 'MONEV'
							],
						];
						save_data( $params_update_assignment);

						$params_get = [
							'table' => 'monev.monev_data',
							'where' => [
								'proses_id' => $id
							],
						];

						$get_data = get_data( $params_get )->row();

						unset( $get_data->proses_id );
						$get_data->stereotype = 'VERIVALI-SUPERVISOR-APPROVED';
						$get_data->lastupdate_on = $datetime;
						$get_data->lastupdate_by = $this->user_info['user_id'];
						$audit_trails = json_decode( $get_data->audit_trails, true );
						$audit_trails[] = [
							"ip" => $ip_address,
							"on" => $datetime,
							"act" => "REVERT",
							"user_id" => $this->user_info['user_id'],
							"username" => $this->user_info['user_username'],
							"column_data" => [
								"asset_id" => $id,
								"stereotype" => 'VERIVALI-SUPERVISOR-APPROVED'
							],
							"is_proxy_access" => $is_proxy
						];
						$get_data->audit_trails = json_encode($audit_trails);
						save_data( 'monev.monev_data', $get_data, [ 'proses_id' => $id ]);

						$params_insert_master_data_log = [
							'data_log_master_data_id' => $id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'Data Monitoring Kualitas RT ' .$get_data->id_prelist.' telah direvert',
							'data_log_stereotype' => $get_data->stereotype,
							'data_log_row_status' => $get_data->row_status,
							'data_log_created_by' => $this->user_info['user_id'],
							'data_log_created_on' => $datetime,
							'data_log_lastupdate_by' => null,
							'data_log_lastupdate_on' => null,
						];
						save_data( 'asset.master_data_log', $params_insert_master_data_log);

						//VERVAL
						$params_update_assignment_verval = [
							'table' => 'dbo.ref_assignment',
							'data' => [
								'row_status' => 'DELETED'
							],
							'where' => [
								'proses_id' => $get_data->parent_id,
								'stereotype' => 'VERIVALI'
							],
						];
						save_data( $params_update_assignment_verval);


						$data_baru = array();
						$data_baru['stereotype'] = 'VERIVALI-REVOKED';
						$data_baru['lastupdate_on'] = $datetime;
						$data_baru['lastupdate_by'] = $this->user_info['user_id'];
						$audit_trails = json_decode( $get_data->audit_trails, true );
						$audit_trails[] = [
							"ip" => $ip_address,
							"on" => $datetime,
							"act" => "REVERT",
							"user_id" => $this->user_info['user_id'],
							"username" => $this->user_info['user_username'],
							"column_data" => [
								"asset_id" => $id,
								"stereotype" => 'VERIVALI-REVOKED'
							],
							"is_proxy_access" => $is_proxy
						];
						$data_baru['audit_trails'] = json_encode($audit_trails);
						save_data( 'asset.master_data_proses', $data_baru, [ 'proses_id' => $get_data->parent_id ]);

						$params_insert_master_data_log_verval = [
							'data_log_master_data_id' => $id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'Data Monitoring Kualitas RT ' .$get_data->id_prelist.' telah direvert',
							'data_log_stereotype' => $get_data->stereotype,
							'data_log_row_status' => $get_data->row_status,
							'data_log_created_by' => $this->user_info['user_id'],
							'data_log_created_on' => $datetime,
							'data_log_lastupdate_by' => null,
							'data_log_lastupdate_on' => null,
						];
						save_data( 'asset.master_data_log', $params_insert_master_data_log_verval);

						/*
						$params_update_master_data = [
							'table' => 'asset.master_data_proses',
							'data' => [
								'stereotype' => 'PROVINCE-PUBLISHED'
							],
							'where' => [
								'proses_id' => $id
							],
						];
						save_data( $params_update_master_data);
						$this->move_detail( $id );
						*/
						$success++;

					} else {
						$failed++;
					}
				}
				$arr_output['message'] = $success .' data berhasil direject. <br>'.$failed .' data gagal direject.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';

			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		// revoke-prelist
		if ( isset( $in['revoke'] ) && $in['revoke'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = $failed = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ( $arr_id as $id ) {
					$row = null;
					$params_get = [
						'table' => 'monev.monev_data',
						'where' => [
							'proses_id' => $id
						],
					];
					$query_data = get_data( $params_get );
					if ( $query_data->num_rows() == '0' ) {
						$params_get['where'] = [
							'parent_id' => $id
						];
						$query_data = get_data( $params_get );
						$row = ( ( $query_data->num_rows() >= 1 ) ? $query_data->row() : null );
					} else {
						$row = $query_data->row();
					}
					$arr_stereotype = ['VERIVALI-GRABBED', 'VERIVALI-DOWNLOADED', 'VERIVALI-SURVEY'];
					if ( $row != null && in_array( $row->stereotype, $arr_stereotype ) ) {

						$data_update_mdp = [
							'table' => 'monev.monev_data',
							'data' => [],
							'where' => [],
						];
						if ( $row->stereotype == 'VERIVALI-GRABBED' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
							$stereotype_assignment = 'MONEV';
						} else if ( $row->stereotype == 'VERIVALI-DOWNLOADED' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
							$stereotype_assignment = 'MONEV';
						} else if ( $row->stereotype == 'VERIVALI-SURVEY' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
							$stereotype_assignment = 'MONEV';
						}

						$user_ip = client_ip();
						$audit_trails = json_decode( $row->audit_trails, true );
						$audit_trails[] = [
							"ip" => $user_ip['ip_address'],
							"on" => $datetime,
							"act" => "REVOKE",
							"user_id" => $this->user_info['user_id'],
							"username" => $this->user_info['user_username'],
							"column_data" => [
								"asset_id" => $id,
								"stereotype" => $data_update_mdp['data']['stereotype']
							],
							"is_proxy_access" =>  $user_ip['is_proxy']
						];

						$data_update_mdp['data']['audit_trails'] = json_encode( $audit_trails );
						$data_update_mdp['data']['lastupdate_on'] = $datetime;
						$data_update_mdp['where'] = ( ( $row->row_status == 'COPY' ) ? [ 'parent_id' => $id ] : [ 'proses_id' => $id ] );
						save_data( $data_update_mdp );

						$params_insert_master_data_log = [
							'data_log_master_data_id' => $id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'revoke Data id_prelist ' . $row->id_prelist,
							'data_log_stereotype' => $data_update_mdp['data']['stereotype'],
							'data_log_row_status' => $row->row_status,
							'data_log_lastupdate_by' => $this->user_info['user_id'],
							'data_log_lastupdate_on' => $datetime,
						];
						save_data( 'asset.master_data_log', $params_insert_master_data_log);

						if ( $stereotype_assignment != null ) {
							$params_cek_assigment = [
								'table' => 'monev.monev_data',
								'where' => [
									'parent_id' => $id
								],
								'select' => 'proses_id'
							];
							$query_assignment = get_data( $params_cek_assigment );
							$proses_id = ( ( $query_assignment->num_rows() > 0 ) ? $query_assignment->row( 'proses_id' ) : $id );
							$params_update_assignment = [
								'table' => 'dbo.ref_assignment',
								'data' => [
									'row_status' => 'DELETED'
								],
								'where' => [
									'proses_id' => $proses_id,
									'stereotype' => $stereotype_assignment,
								],
							];
							save_data( $params_update_assignment);
						}

						$success++;
						$arr_output['message'] = $success .' data berhasil direvoke.';
						$arr_output['message_class'] = 'response_confirmation alert alert-success';
					} else {
						$failed++;
						$arr_output['message'] = $failed .' data gagal direvoke.';
						$arr_output['message_class'] = 'response_confirmation alert alert-success';
					}
				}
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		echo json_encode( $arr_output );
	}
	function coba()
	{
		$params_get = [
			'table' => 'monev.monev_data',
			'where' => [
				'proses_id' => 7
			],
		];
		$get_data = get_data( $params_get )->row();
		$data_baru = $this->perbaikanData( $get_data );
		$data_baru['stereotype'] = 'VERIVALI-REVOKED';
		echo json_encode($data_baru);


	}
	function perbaikanData($parent_properties)
	{
		$data = array();
		if(!empty($parent_properties->mku_nama_perbaikan))
		{
			$data['nama_sls'] = $parent_properties->mku_nama_perbaikan;
		}
		if(!empty($parent_properties->mku_alamat_art_perbaikan))
		{
			$data['alamat'] = $parent_properties->mku_alamat_art_perbaikan;
		}

		if(!empty($parent_properties->mku_tgl_wawancara_perbaikan))
		{
			$data['tanggal_verivali'] = $parent_properties->mku_tgl_wawancara_perbaikan;
		}
		if($parent_properties->mku_nama_krt_konfirmasi==2)
		{
			$data['nama_krt'] = $parent_properties->mku_nama_krt_perbaikan;
		}
		if($parent_properties->mku_jml_kel_konfirmasi==2)
		{
			$data['Jumlah_Keluarga'] = $parent_properties->mku_jml_kel_perbaikan;
		}
		if($parent_properties->mku_jml_anggota_konfirmasi==2)
		{
			$data['Jumlah_ART'] = $parent_properties->mku_jml_anggota_perbaikan;
		}
		if($parent_properties->mku_penguasaan_bangunan_konfirmasi==2)
		{
			$data['sta_bangunan'] = $parent_properties->mku_penguasaan_bangunan_perbaikan;
		}
		if($parent_properties->mku_status_lahan_konfirmasi==2)
		{
			$data['sta_lahan'] = $parent_properties->mku_status_lahan_perbaikan;
		}
		if($parent_properties->mku_jenis_lantai_konfirmasi==2)
		{
			$data['lantai'] = $parent_properties->mku_jenis_lantai_perbaikan;
		}
		if($parent_properties->mku_jenis_dinding_konfirmasi==2)
		{
			$data['dinding'] = $parent_properties->mku_jenis_dinding_perbaikan;
		}
		if($parent_properties->mku_jenis_atap_konfirmasi==2)
		{
			$data['atap'] = $parent_properties->mku_jenis_atap_perbaikan;
		}
		if($parent_properties->mku_sumber_penerangan==2)
		{
			$data['sumber_penerangan'] = $parent_properties->mku_sumber_penerangan_perbaikan;
		}
		if($parent_properties->mku_daya_terpasang_konfirmasi==2)
		{
			$data['daya'] = $parent_properties->mku_daya_terpasang_perbaikan;
		}

		$data['stereotype'] = 'VERIVALI-SUPERVISOR-APPROVED';
		$data['lastupdate_on'] = date( "Y-m-d H:i:s");
		$data['lastupdate_by'] = $this->user_info['user_id'];

		return $data;
	}

	function perbaikanDataDetail($parent_properties)
	{
		$data = array();
		if(!empty($parent_properties->mku_perbaikan_nama))
		{
			$data['nama'] = $parent_properties->mku_perbaikan_nama;
		}
		if(!empty($parent_properties->mku_perbaikan_nik))
		{
			$data['nik'] = $parent_properties->mku_perbaikan_nik;
		}
		if($parent_properties->mku_konfirmasi_hub_krt==2)
		{
			$data['hub_krt'] = $parent_properties->mku_perbaikan_hub_krt;
		}
		if($parent_properties->mku_konfirmasi_nuk==2)
		{
			$data['KK'] = $parent_properties->mku_perbaikan_nuk;
			$data['NUK'] = $parent_properties->mku_perbaikan_nuk;
			$nuk_perbaikan=explode(" ",$parent_properties->mku_perbaikan_nuk);
			$data['NoKK'] = $nuk_perbaikan[2];
		}
		if($parent_properties->mku_konfirmasi_hubkel==2)
		{
			$data['Hubkel'] = $parent_properties->mku_perbaikan_hubkel;
		}
		if($parent_properties->mku_korfirmasi_jnskel==2)
		{
			$data['JnsKel'] = $parent_properties->mku_perbaikan_jnskel;
		}
		if($parent_properties->mku_konfirmasi_umur==2)
		{
			$data['Umur'] = $parent_properties->mku_perbaikan_umur;
		}
		if($parent_properties->mku_konfirmasi_partisipasi_sekolah==2)
		{
			$data['Partisipasi_sekolah'] = $parent_properties->mku_perbaikan_partisipasi_sekolah;
		}
		if($parent_properties->mku_konfirmasi_jenjang_pendidikan==2)
		{
			$data['Pendidikan_tertinggi'] = $parent_properties->mku_perbaikan_jenjang_pendidikan;
		}
		if($parent_properties->mku_konfirmasi_kelas_tertinggi==2)
		{
			$data['Kelas_tertinggi'] = $parent_properties->mku_perbaikan_kelas_tertinggi;
		}
		if($parent_properties->mku_konfirmasi_ijazah_tertinggi==2)
		{
			$data['Ijazah_tertinggi'] = $parent_properties->mku_perbaikan_ijazah_tertinggi;
		}
		if($parent_properties->mku_konfirmasi_sta_bekerja==2)
		{
			$data['Sta_Bekerja'] = $parent_properties->mku_perbaikan_sta_bekerja;
		}
		if($parent_properties->mku_konfirmasi_lapangan_usaha==2)
		{
			$data['Lapangan_usaha'] = $parent_properties->mku_perbaikan_lapangan_usaha;
		}

		/*
		// perbaikan kk
		if($parent_properties['mku_hasil_kk_konfirmasi']['value']==2)
		{
			$parent_properties['NoKK'] = $parent_properties['NoKK_perbaikan'];
		}
		*/
		$data['lastupdate_on'] = date( "Y-m-d H:i:s");
		$data['lastupdate_by'] = $this->user_info['user_id'];
		return $data;
	}

	function perbaikanDataDetailKK($parent_properties)
	{
		$data = array();
		// perbaikan kk
		if($parent_properties->mku_hasil_kk_konfirmasi==2)
		{
			$data['NoKK'] = $parent_properties->NoKK_perbaikan;
		}
		$data['lastupdate_on'] = date( "Y-m-d H:i:s");
		$data['lastupdate_by'] = $this->user_info['user_id'];
		return $data;
	}

	function move_detail( $id = null ) {
		$params_get = [
			'table' => 'asset.master_data_detail',
			'where' => [
				'proses_id' => $id
			]
		];
		$get_data = get_data( $params_get )->result_array();

		foreach ( $get_data as $key => $value ) {
			$table = '';
			if ( $value['stereotype'] == 'NOKK' ) {
				$data_nokk = [
					'proses_id' => $value['proses_id'],
					'parent_id' => $value['parent_id'],
					'index' => $value['index'],
					'fiscal_year' => $value['fiscal_year'],
					'nuk' => $value['nuk'],
					'nokk' => $value['no_kk'],
					'stereotype' => $value['stereotype'],
					'sort_order' => $value['sort_order'],
					'row_status' => $value['row_status'],
					'created_by' => $value['created_by'],
					'created_on' => $value['created_on'],
					'lastupdate_by' => $value['lastupdate_by'],
					'lastupdate_on' => $value['lastupdate_on'],
				];
				save_data( "asset.master_data_detail_proses_kk", $data_nokk );
			} else if ( $value['stereotype'] == 'ART' ) {
				unset( $value['id'] );
				save_data( "asset.master_data_detail_proses", $value );
			}
		}
	}

	function act_save() {
		$input = $this->input->post();
		$sql = "
			SELECT max(menu_order) max_sort
			FROM sys_menu
			WHERE menu_parent_id = '" . $input['parent_menu'] . "'
		";
		$query = data_query( $sql );
		$last_sort = $query->row( 'max_sort' );
		$data_save = [
			'menu_parent_id' => $input['parent_menu'],
			'menu_name' => $input['menu_name'],
			'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
			'menu_link' => $input['menu_link'],
			'menu_description' => $input['menu_description'],
			'menu_class_icon' => $input['menu_class_icon'],
			'menu_activity' => json_encode( array_merge( ['show'], $input['menu_action'] ) ),
			'menu_order' => $last_sort + 1,
			'menu_is_active' => '1',
		];
		$menu_id = save_data( 'sys_menu', $data_save );
		if ( $menu_id ){
			$result = [
				'status' => 200,
				'msg' => 'Data Berhasil Disimpan !',
			];
		} else {
			$result = [
				'status' => 500,
				'msg' => 'Data Gagal Disimpan !',
			];
		}
		echo json_encode( $result );
	}

	function act_edit() {
		$input = $this->input->post();
		$arr_input_menu_action = ( ( isset( $input['menu_action'] ) ) ? $input['menu_action'] : [] );
		$data_save = [
			'menu_parent_id' => $input['parent_menu'],
			'menu_name' => $input['menu_name'],
			'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
			'menu_link' => $input['menu_link'],
			'menu_description' => $input['menu_description'],
			'menu_class_icon' => $input['menu_class_icon'],
			'menu_activity' => json_encode( array_merge( ['show'], $arr_input_menu_action ) ),
		];
		$menu_id = save_data( 'sys_menu', $data_save, [ 'menu_id' => $input['menu_id'] ] );
		if ( $menu_id ){
			$result = [
				'status' => 200,
				'msg' => 'Data Berhasil Disimpan !',
			];
		} else {
			$result = [
				'status' => 500,
				'msg' => 'Data Gagal Disimpan !',
			];
		}
		echo json_encode( $result );
	}

	function form_cari() {
		$user_location = $this->get_user_location();
		$jml_negara = count( explode( ',', $user_location['country_id'] ) );
		$jml_propinsi = count( explode( ',', $user_location['province_id'] ) );
		$jml_kota = count( explode( ',', $user_location['regency_id'] ) );
		$jml_kecamatan = count( explode( ',', $user_location['district_id'] ) );
		$jml_kelurahan = count( explode( ',', $user_location['village_id'] ) );

		$option_propinsi = '<option value="0">Semua Provinsi</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_kota = '<option value="0">Semua Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Semua Kecamatan</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_status = '<option value="0">Semua Status</option>';
		$option_hasil_musdes = '<option value="0">Semua Hasil Musdes</option>';
		$option_hasil_verivali = '<option value="0">Semua Hasil Verivali</option>';

		$where_propinsi = [];
		$where_propinsi['parent_id'] = '100000';
		$where_propinsi['level'] = '2';

		if ( ! empty( $user_location['province_id'] ) ) {
			if ( $jml_propinsi > '0' ) $where_propinsi['location_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}" )] = null;
		}

		$params_propinsi = [
			'table' => 'dbo.ref_locations',
			'select' => 'location_id, full_name',
			'where' => $where_propinsi,
		];
		$query_propinsi = get_data( $params_propinsi );
		foreach ( $query_propinsi->result() as $key => $value ) {
			if ( $jml_propinsi == '1' && ! empty( $user_location['province_id'] ) ) {
				$option_propinsi = '<option value="' . $value->location_id . '" selected>' . $value->full_name . '</option>';
			} else {
				$option_propinsi .= '<option value="' . $value->location_id . '">' . $value->full_name . '</option>';
			}
		}


		if ( $jml_propinsi == '1' ) {
			$where_kota = [];
			if ( ! empty( $user_location['regency_id'] ) ) {
				if ( $jml_kota > '0' ) $where_kota['location_id ' . ( ( $jml_kota >= '2' ) ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}" )] = null;
			} else {
				$where_kota['parent_id'] = $user_location['province_id'];
			}
			$params_kota = [
				'table' => 'dbo.ref_locations',
				'select' => 'location_id, full_name',
				'where' => $where_kota,
			];
			$query_kota = get_data( $params_kota );
			foreach ( $query_kota->result() as $key => $value ) {
				if ( $jml_kota == '1' && ! empty( $user_location['regency_id'] ) ) {
					$option_kota = '<option value="' . $value->location_id . '" selected>' . $value->full_name . '</option>';
				} else {
					$option_kota .= '<option value="' . $value->location_id . '">' . $value->full_name . '</option>';
				}
			}
		}

		if ( $jml_kota == '1' ) {
			$where_kecamatan = [];
			if ( ! empty( $user_location['district_id'] ) ) {
				if ( $jml_kecamatan > '0' ) $where_kecamatan['location_id ' . ( ( $jml_kecamatan >= '2' ) ? "IN ({$user_location['district_id']}) " : " = {$user_location['district_id']}" )] = null;
			} else {
				$where_kecamatan['parent_id'] = $user_location['regency_id'];
			}
			$params_kecamatan = [
				'table' => 'dbo.ref_locations',
				'select' => 'location_id, full_name',
				'where' => $where_kecamatan,
			];
			$query_kecamatan = get_data( $params_kecamatan );
			foreach ( $query_kecamatan->result() as $key => $value ) {
				if ( $jml_kecamatan == '1' && ! empty( $user_location['district_id'] ) ) {
					$option_kecamatan = '<option value="' . $value->location_id . '" selected>' . $value->full_name . '</option>';
				} else {
					$option_kecamatan .= '<option value="' . $value->location_id . '">' . $value->full_name . '</option>';
				}
			}
		}

		if (  $jml_kecamatan == '1' ) {
			$where_kelurahan = [];
			if ( ! empty( $user_location['village_id'] ) ) {
				if ( $jml_kelurahan > '0' ) $where_kelurahan['location_id ' . ( ( $jml_kelurahan >= '2' ) ? "IN ({$user_location['village_id']}) " : " = {$user_location['village_id']}" )] = null;
			} else {
				$where_kelurahan['parent_id'] = $user_location['district_id'];
			}
			$params_kelurahan = [
				'table' => 'dbo.ref_locations',
				'select' => 'location_id, full_name',
				'where' => $where_kelurahan,
			];
			$query_kelurahan = get_data( $params_kelurahan );
			foreach ( $query_kelurahan->result() as $key => $value ) {
				if ( $jml_kelurahan == '1' && ! empty( $user_location['village_id'] ) ) {
					$option_kelurahan = '<option value="' . $value->location_id . '" selected>' . $value->full_name . '</option>';
				} else {
					$option_kelurahan .= '<option value="' . $value->location_id . '">' . $value->full_name . '</option>';
				}
			}
		}

		$params_status = [
			'table' => 'ref_references',
			'select' => 'code, short_label, long_label',
		];
		$query_status = get_data( $params_status );
		foreach ( $query_status->result() as $key => $value) {
			$option_status .= '<option value="' . $value->short_label . '" >[' . $value->code . '] ' . $value->long_label . '</option>';
		}

		$arr_hasil_verivali = [
			'1' => 'Selesai Dicacah',
			'2' => 'Ruta Tidak Ditemukan',
			'3' => 'Ruta Pindah / Bangunan Tidak Ada',
			'4' => 'Bagian Dari Ruta Di Dokumen',
			'5' => 'Responden Menolak',
			'6' => 'Data Ganda',
		];
		foreach ( $arr_hasil_verivali as $kode => $verivali) {
			$option_hasil_verivali .= '<option value="' . $kode . '" >' . $verivali . '</option>';
		}

		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
				<div class="row col-md-12">
					<div class="form-group col-md-3">
						<select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" ' . ( ( ( $jml_propinsi == '1') && ( ! empty( $user_location['province_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_propinsi . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kabupaten" name="kabupaten" class="js-example-basic-single form-control" ' . ( ( ( $jml_kota == '1' ) && ( ! empty( $user_location['regency_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kota . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control" ' . ( ( ( $jml_kecamatan == '1' ) && ( ! empty( $user_location['district_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kecamatan . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" ' . ( ( ( $jml_kelurahan == '1' ) && ( ! empty( $user_location['village_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kelurahan . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-status" name="status" class="js-example-basic-single form-control">
							' . $option_status . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-hasil-verivali" name="hasil_verivali" class="js-example-basic-single form-control">
							' . $option_hasil_verivali . '
						</select>
					</div>
					<div class="form-group col-md-2">
						<button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Refresh</button>
					</div>
				</div>
			</div>
		';
		return $form_cari;
		// <div class="row">
		// 		<label>Propinsi</label>
		// 			<select id="select-propinsi" name="propinsi" class="form-control" ' . ( ( ( $jml_propinsi == '1') && ( ! empty( $user_location['province_id'] ) ) ) ? 'disabled ' : '' ) . '>
		// 				' . $option_propinsi . '
		// 			</select>
		// 	</div>
	}

	function get_user_location() {
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '0';
		$province_id = '0';
		$regency_id = '0';
		$district_id = '0';
		$village_id = '0';
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
				$province_id = $query->row( 'province_id' ) . ( ( $no < $count ) ? ',' : '' );
				$regency_id = $query->row( 'regency_id' ) . ( ( $no < $count ) ? ',' : '' );
				$district_id = $query->row( 'district_id' ) . ( ( $no < $count ) ? ',' : '' );
				$village_id = $query->row( 'village_id' ) . ( ( $no < $count ) ? ',' : '' );
				$no++;
			}
		}
		$res_loc = [
			'country_id' => $country_id,
			'province_id' => $province_id,
			'regency_id' => $regency_id,
			'district_id' => $district_id,
			'village_id' => $village_id,
		];
		return $res_loc;
	}

	function get_show_location(){
		$params = [
			'table' => 'ref_locations',
			'where' => [
				'parent_id' => $_GET['location_id'],
				'level' => $_GET['level']
			],
			'select' => 'location_id, full_name'
		];
		$query = get_data( $params );
		$data = [];
		foreach  ( $query->result() as $rows ) {
			$data[$rows->location_id] = $rows->full_name;
		}
		echo json_encode( $data );
	}

}
