 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verval_list extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'verivali/verval_list/' );
		$this->load->model('auth_model');
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
				{ name:'status', display:'Status', width:40, sortable:false, align:'center', datasuorce: false},
				{ name:'status_code', display:'Kode Status', width:50, sortable:true, align:'center', datasuorce: false, hide: true},
				{ name:'id_prelist', display:'Id Prelist', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_krt', display:'Nama KRT', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'nomor_nik', display:'NIK', width:80, sortable:false, align:'center', datasuorce: false},
				{ name:'alamat', display:'Alamat', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'province_name', display:'Propinsi', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kabupaten',  width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Kelurahan', width:90, sortable:true, align:'left', datasuorce: false},
				{ name:'jenis_kelamin_krt', display:'Gender', width:40, sortable:true, align:'left', datasuorce: false},
				{ name:'status_rumahtangga', display:'Status', width:50, sortable:true, align:'left', datasuorce: false},
				{ name:'apakah_mampu', display:'Mampu', width:50, sortable:true, align:'left', datasuorce: false},
				{ name:'hasil_verivali', display:'Hasil Vervali', width:60, sortable:true, align:'left', datasuorce: false},
				{ name:'petugas_verivali', display:'Enum Musdes', width:60, sortable:true, align:'left', datasuorce: false},
				{ name:'petugas_verivali', display:'Enum Verval', width:60, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:90, sortable:true, align:'left', datasuorce: false},
				{ name:'detail', display:'Detail', width:50, sortable:true, align:'center', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },

				{ display:'Approve ke Status 12', name:'approve', bclass:'publish', onpress:act_show, hidden: true, urlaction: '" . $this->dir . "act_show' },
				{ separator: true },
				{ display:'Reject ke Status 7a', name:'reject', bclass:'reject13a', onpress:act_reject, hidden: true, urlaction: '" . $this->dir . "act_show' },
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
                { display:'Alamat', name:'md.alamat', type:'text' },
                { display:'Enum Musdes', name:'u1.user_profile_first_name', type:'text', isdefault: true },
                { display:'Enum Verval', name:'u2.user_profile_first_name', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Data Verval';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$data['grid']['table_title'] = 'Daftar Data Verval';

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
						var status = $( "#select-status ").val();
						if(status=="MUSDES-NOT-FOUND")
						{
							$(".publish").show();
							$(".publish").parent().parent().nextAll(".btnseparator").show();
							$(".reject13a").hide();
							$(".reject13a").parent().parent().nextAll(".btnseparator").hide();
						}
						else if(status=="VERIVALI-SUBMITTED")
						{
							$(".publish").show();
							$(".publish").parent().parent().nextAll(".btnseparator").show();
							$(".reject13a").show();
							$(".reject13a").parent().parent().nextAll(".btnseparator").show();
						}
						else if(status=="VERIVALI-KORKAB-REJECTED")
						{
							$(".publish").hide();
							$(".publish").parent().parent().nextAll(".btnseparator").show();
							$(".reject13a").show();
							$(".reject13a").parent().parent().nextAll(".btnseparator").hide();
						}
						else
						{
							$(".publish").hide();
							$(".publish").parent().parent().nextAll(".btnseparator").hide();
							$(".reject13a").hide();
							$(".reject13a").parent().parent().nextAll(".btnseparator").hide();
						}

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
				$(".bDiv").ready( function(){
					$(".publish").parent().parent().nextAll(".btnseparator").hide();
				});
			</script>
		';
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_view", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data() {
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
                } else if ( $field == 'stereotype' || $field == 'hasil_verivali' ) {
					if ( $value > '0' ) $where['md.' . $field] = $value;
					else $where["md.stereotype IN ('MUSDES-NOT-FOUND', 'VERIVALI-SUBMITTED', 'VERIVALI-SUPERVISOR-APPROVED', 'VERIVALI-KORKAB-REJECTED', 'VERIVALI-KORKAB-APPROVED', 'VERIVALI-KORWIL-REJECTED', 'VERIVALI-PENDING-QC-PUSAT', 'VERIVALI-FINAL') "] = null;
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
			$where["md.stereotype IN ('MUSDES-NOT-FOUND', 'VERIVALI-SUBMITTED', 'VERIVALI-SUPERVISOR-APPROVED', 'VERIVALI-KORKAB-REJECTED', 'VERIVALI-KORKAB-APPROVED', 'VERIVALI-KORWIL-REJECTED', 'VERIVALI-PENDING-QC-PUSAT', 'VERIVALI-FINAL') "] = null;

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
                md.id_prelist,
                md.nomor_nik,
                md.nama_krt,
                md.alamat,
                md.jenis_kelamin_krt,
                md.nama_pasangan_krt,
                md.status_rumahtangga,
                md.apakah_mampu,
                md.hasil_verivali,
                concat ( u1.user_profile_first_name, ' ', u1.user_profile_last_name ) AS surveyor_musdes,
                concat ( u2.user_profile_first_name, ' ', u2.user_profile_last_name ) AS surveyor_verval,
                md.lastupdate_on,
                l.province_name,
                l.regency_name,
                l.district_name,
                l.village_name,
                r.icon
            FROM asset.master_data_proses md
            LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
            LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
            LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id
            AND a1.stereotype = 'MUSDES'
            AND a1.row_status = 'ACTIVE'
            LEFT JOIN dbo.ref_assignment a2 ON md.proses_id = a2.proses_id
            AND a2.stereotype = 'VERIVALI'
            AND a2.row_status = 'ACTIVE'
            LEFT JOIN dbo.core_user_profile u1 ON a1.user_id = u1.user_profile_id
            LEFT JOIN dbo.core_user_profile u2 ON a2.user_id = u2.user_profile_id
    		WHERE $sql_where 1=1 $sql_where_in
    		ORDER BY md.lastupdate_on ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		";

		$sql_count = "
            SELECT COUNT
                ( id_prelist ) jumlah
            FROM asset.master_data_proses md
            LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
            LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
            LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id
            AND a1.stereotype = 'MUSDES'
            AND a1.row_status = 'ACTIVE'
            LEFT JOIN dbo.ref_assignment a2 ON md.proses_id = a2.proses_id
            AND a2.stereotype = 'VERIVALI'
            AND a2.row_status = 'ACTIVE'
            LEFT JOIN dbo.core_user_profile u1 ON a1.user_id = u1.user_profile_id
            LEFT JOIN dbo.core_user_profile u2 ON a2.user_id = u2.user_profile_id
            WHERE $sql_where 1=1 $sql_where_in
		";

        $query = data_query( $sql_query );
        $query_count = data_query( $sql_count );

		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$gender = "";
			$status_ruta = "";
			$mampu = "";
			$hasil_verivali = "";

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

			if($row->hasil_verivali == '1') {
				$hasil_verivali = "<span class='text-success font-weight-bold'>Selesai Dicacah</span>";
			} else if ($row->hasil_verivali == '2') {
				$hasil_verivali = "<span class='text-danger font-weight-bold'>Ruta Tidak Ditemukan</span>";
			} else if ($row->hasil_verivali == '3') {
				$hasil_verivali = "<span class='text-info font-weight-bold'>Ruta Pindah/Bangunan Tidak Ada</span>";
			} else if ($row->hasil_verivali == '4') {
				$hasil_verivali = "<span class='text-primary font-weight-bold'>Bagian Dari Dokumen Ruta</span>";
			} else if ($row->hasil_verivali == '5') {
				$hasil_verivali = "<span class='text-warning font-weight-bold'>Responden Menolak</span>";
			} else if ($row->hasil_verivali == '6') {
				$hasil_verivali = "<span class='text-danger font-weight-bold'>Data Ganda</span>";
			}

			$lastupdate = date("d-m-Y H:i:s",strtotime($row->lastupdate_on));
			$status = '<img src="' . base_url('assets/style/icon-status') . '/' . $row->icon . '">';
			$detail = '<button class="btn-edit" act="' . base_url( "verivali/detail_data/get_form_detail/" . enc( ['proses_id' => $row->proses_id, 'stereotype' => $row->stereotype] ) ) . '"><i class="fa fa-search"></i></button>';
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
					'hasil_verivali' => $hasil_verivali,
					'petugas_musdes' => $row->surveyor_musdes,
					'petugas_verivali' => $row->surveyor_verval,
					'last_update_data' => $lastupdate,
					'detail' => $detail,
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

	function act_show() {
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();

		// approve
		if ( isset( $in['approve'] ) && $in['approve'] ) {
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
						"act" => "UPDATED",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"asset_id" => $id,
							"stereotype" => 'VERIVALI-SUPERVISOR-APPROVED'
						],
						"is_proxy_access" => $user_ip['is_proxy']
					];
					$params_update_master_data = [
						'table' => 'asset.master_data_proses',
						'data' => [
							'stereotype' => 'VERIVALI-SUPERVISOR-APPROVED',
							'audit_trails' => json_encode( $audit_trails ),
							'lastupdate_on' => $datetime,
						],
						'where' => [
							'proses_id' => $id
						],
					];
					save_data( $params_update_master_data);
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'proses_id, stereotype, row_status'
					];
					$get_data = get_data( $params_get )->row();
					$params_insert_master_data_log = [
						'data_log_master_data_id' => $get_data->proses_id,
						'data_log_status' => 'sukses',
						'data_log_description' => 'Data proses id ' . $get_data->proses_id . ' diubah status menjadi VERIVALI-SUPERVISOR-APPROVED',
						'data_log_stereotype' => $get_data->stereotype,
						'data_log_row_status' => $get_data->row_status,
						'data_log_lastupdate_by' => $this->user_info['user_id'],
						'data_log_lastupdate_on' => date( "Y-m-d H:i:s"),
					];
					save_data( 'asset.master_data_log', $params_insert_master_data_log);

					$success++;
				}

				$arr_output['message'] = $success .' data berhasil approve ke status 12.';
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
						"act" => "REJECT",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"asset_id" => $id,
							"stereotype" => 'VERIVALI-REVOKED',
							"approval_note" => $in['note']
						],
						"is_proxy_access" => $user_ip['is_proxy']
					];
					$params_update_master_data = [
						'table' => 'asset.master_data_proses',
						'data' => [
							'stereotype' => 'VERIVALI-REVOKED',
							'audit_trails' => json_encode( $audit_trails ),
							'lastupdate_on' => $datetime,
							"approval_note" => $in['note']
						],
						'where' => [
							'proses_id' => $id
						],
					];
					save_data( $params_update_master_data);
					$params_update_assignment = [
						'table' => 'dbo.ref_assignment',
						'data' => [
							'row_status' => 'DELETED'
						],
						'where' => [
							'proses_id' => $id,
							'stereotype' => 'VERIVALI',
						],
					];
					save_data( $params_update_assignment);
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'proses_id, stereotype, row_status'
					];
					$get_data = get_data( $params_get )->row();
					$params_insert_master_data_log = [
						'data_log_master_data_id' => $get_data->proses_id,
						'data_log_status' => 'sukses',
						'data_log_description' => 'Data proses id ' . $get_data->proses_id . ' diubah status menjadi VERIVALI-REVOKED',
						'data_log_stereotype' => $get_data->stereotype,
						'data_log_row_status' => $get_data->row_status,
						'data_log_lastupdate_by' => $this->user_info['user_id'],
						'data_log_lastupdate_on' => date( "Y-m-d H:i:s"),
					];
					save_data( 'asset.master_data_log', $params_insert_master_data_log);

					$success++;
				}

				$arr_output['message'] = $success .' data berhasil reject ke status 7a.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		echo json_encode( $arr_output );
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
		$option_kota = '<option value="0">Semua Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Semua Kecamatan</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
        $option_hasil_verivali = '<option value="0">Semua Hasil Verivali</option>';

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
			<div class="row">
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
				<div class="form-group col-md-3">
					<select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control">
						' . $option_kecamatan . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" >
						' . $option_kelurahan . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-status" name="status" class="js-example-basic-single form-control">
						<option value="">Semua Status</option>
						<option value="MUSDES-NOT-FOUND">6a.DATA INVALID Hasil Musdes</option>
						<option value="VERIVALI-SUBMITTED">11.SELESAI VERIVALI Rumah Tangga</option>
						<option value="VERIVALI-SUPERVISOR-APPROVED">12.Data APPROVED PENGAWAS</option>
						<option value="VERIVALI-KORKAB-REJECTED">12a.Data REJECTED KORKAB</option>
						<option value="VERIVALI-KORKAB-APPROVED">13.Data APPROVED KORKAB</option>
						<option value="VERIVALI-KORWIL-REJECTED">13a.Data REJECTED QC Pusat</option>
						<option value="VERIVALI-PENDING-QC-PUSAT">13b.Proses QC Pusat</option>
						<option value="VERIVALI-FINAL">14.Data APPROVED KORWIL</option>
					</select>
				</div>
                <div class="form-group col-md-3">
                    <select id="select-hasil-verivali" name="hasil_verivali" class="js-example-basic-single form-control">
                        ' . $option_hasil_verivali . '
                    </select>
                </div>
				<div class="form-group col-md-3">
					<button type="button" id="cari" class="btn btn-info btn-sm"><i class="fa fa-search"></i>&nbsp;Cari</button>
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
