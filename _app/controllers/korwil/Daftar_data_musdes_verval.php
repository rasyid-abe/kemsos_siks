<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_data_musdes_verval extends Backend_Controller {
    public function __construct() {
        parent::__construct();
        $this->dir = base_url( 'korwil/daftar_data_musdes_verval/' );
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
            'col_id' => 'proses_id',
            'sort' => 'desc',
            'columns' => "
                { name:'status', display:'Status', width:40, sortable:false, align:'center', datasuorce: false},
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
                { name:'petugas_musdes', display:'Enum Musdes', width:60, sortable:true, align:'left', datasuorce: false},
                { name:'petugas_verivali', display:'Enum Verval', width:60, sortable:true, align:'left', datasuorce: false},
                { name:'last_update_data', display:'Last Update', width:90, sortable:true, align:'left', datasuorce: false},
                { name:'detail', display:'Detail', width:50, sortable:true, align:'center', datasuorce: false},
            ",
            'toolbars' => "
                { display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
                { separator: true },
                { display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
                { separator: true },
                { display:'Copy Id Prelist', name:'copy', bclass:'copy', onpress:copy_id, urlaction: '" . $this->dir . "copy_id'},
                { separator: true },
                { display:'Is In Prelist', name:'paste', bclass:'paste', onpress:paste_id, urlaction: '" . $this->dir . "paste_id'},
				{ separator: true },
                { display:'Not In Prelist', name:'not_in', bclass:'not_in', onpress:not_in_id, urlaction: '" . $this->dir . "not_in_id'},
				{ separator: true },
            ",
            'filters' => "
                { display:'ID Prelist', name:'id_prelist', type:'text', isdefault: true },
                { display:'Nama KRT', name:'nama_krt', type:'text', isdefault: true },
                { display:'NIK', name:'nomor_nik', type:'text', isdefault: true },
                { display:'Alamat', name:'alamat', type:'text', isdefault: true },
                { display:'Enum Musdes', name:'surveyor_musdes', type:'text', isdefault: true },
				{ display:'Enum Verval', name:'surveyor_verval', type:'text', isdefault: true },
            ",
        ];
        $data['grid']['title'] = 'Daftar Data Musdes dan Verval';
        $data['grid']['link_data'] = $this->dir . "get_show_data";
        $data['grid']['table_title'] = 'Daftar Data Musdes dan Verval';

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
        $this->template->content( "general/Table_grid_data", $data );
        $this->template->show( THEMES_BACKEND . 'index' );
    }

    function get_show_data() {
        $input = $this->input->post();
        $user_id = $this->user_info['user_id'];
        $location_user = $this->auth_model->ambil_location_get($user_id);
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
                } else if ( $field == 'stereotype' ) {
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
            LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id AND a1.stereotype = 'MUSDES'  AND a1.row_status = 'ACTIVE'
            LEFT JOIN dbo.ref_assignment a2 ON md.proses_id = a2.proses_id AND a2.stereotype = 'VERIVALI' AND a2.row_status = 'ACTIVE'
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
            LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id AND a1.stereotype = 'MUSDES'  AND a1.row_status = 'ACTIVE'
            LEFT JOIN dbo.ref_assignment a2 ON md.proses_id = a2.proses_id AND a2.stereotype = 'VERIVALI' AND a2.row_status = 'ACTIVE'
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

        // publish
        if ( isset( $in['publish'] ) && $in['publish'] ) {
            $arr_id = json_decode( $in['item'] );
            if ( is_array( $arr_id ) ) {
                $success = $failed = 0;
                $datetime = date( "Y-m-d H:i:s");
                foreach ( $arr_id as $id ) {
                    $params_get_cek = [
                        'table' => 'asset.master_data_proses',
                        'where' => [
                            'parent_id' => $id
                        ],
                    ];
                    $get_data_cek = get_data( $params_get_cek )->num_rows();
                    if ( $get_data_cek == '0' ) {
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
                            'table' => 'asset.master_data_proses',
                            'where' => [
                                'proses_id' => $id
                            ],
                            // 'select' => 'asset_id, stereotype, row_status'
                        ];
                        $get_data = get_data( $params_get )->row();
                        $get_data->stereotype = 'PROVINCE-PUBLISHED';
                        $get_data->parent_id = $get_data->proses_id;
                        unset( $get_data->proses_id );
                        unset( $get_data->tanggal_pemerikasaan );
                        unset( $get_data->nama_pemerika );
                        $get_data->row_status = 'COPY';
                        $get_data->lastupdate_on = $datetime;
                        $get_data->audit_trails = json_encode(
                            [
                                "ip" => $ip_address,
                                "on" => $datetime,
                                "act" => "COPY",
                                "user_id" => $this->user_info['user_id'],
                                "username" => $this->user_info['user_username'],
                                "column_data" => [
                                    "asset_id" => $id,
                                    "stereotype" => 'PROVINCE-PUBLISHED'
                                ],
                                "is_proxy_access" => $is_proxy
                            ]
                        );
                        save_data( 'asset.master_data_proses', $get_data);
                        $params_insert_master_data_log = [
                            'data_log_master_data_id' => $id,
                            'data_log_status' => 'sukses',
                            'data_log_description' => 'Publish Data proses_id ' . $id,
                            'data_log_stereotype' => $get_data->stereotype,
                            'data_log_row_status' => $get_data->row_status,
                            'data_log_created_by' => $this->user_info['user_id'],
                            'data_log_created_on' => $datetime,
                            'data_log_lastupdate_by' => null,
                            'data_log_lastupdate_on' => null,
                        ];
                        save_data( 'asset.master_data_log', $params_insert_master_data_log);

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

                        $success++;
                        $arr_output['message'] = $success .' data berhasil dipublish.';
                        $arr_output['message_class'] = 'response_confirmation alert alert-success';
                    } else {
                        $failed++;
                        $arr_output['message'] = $failed .' data gagal dipublish.';
                        $arr_output['message_class'] = 'response_confirmation alert alert-success';
                    }
                }
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        // batch
        if ( isset( $in['batch'] ) && $in['batch'] ) {
            $arr_id = json_decode( $in['item'] );
            if ( is_array( $arr_id ) ) {
                $success = $failed = 0;
                $datetime = date( "Y-m-d H:i:s");
                foreach ( $arr_id as $id ) {
                    $row = null;
                    $params_get = [
                        'table' => 'asset.master_data_proses',
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
                    $arr_stereotype = ['MUSDES-GRABBED', 'MUSDES-DOWNLOADED', 'MUSDES-SURVEY', 'VERIVALI-GRABBED', 'VERIVALI-DOWNLOADED', 'VERIVALI-SURVEY', 'MUSDES-GRAB-REVOKED', 'MUSDES-DOWNLOAD-REVOKED', 'MUSDES-SURVEY-REVOKED', 'VERIVALI-GRAB-REVOKED', 'VERIVALI-DOWNLOAD-REVOKED', 'VERIVALI-SURVEY-REVOKED'];
                    if ( $row != null && in_array( $row->stereotype, $arr_stereotype ) ) {

                        $data_update_mdp = [
                            'table' => 'asset.master_data_proses',
                            'data' => [],
                            'where' => [],
                        ];
                        if ( $row->stereotype == 'MUSDES-GRABBED' ) {
                            $data_update_mdp['data']['stereotype'] = 'MUSDES-GRAB-REVOKED';
                            $stereotype_assignment = 'MUSDES';
                        } else if ( $row->stereotype == 'MUSDES-DOWNLOADED' ) {
                            $data_update_mdp['data']['stereotype'] = 'MUSDES-DOWNLOAD-REVOKED';
                            $stereotype_assignment = 'MUSDES';
                        } else if ( $row->stereotype == 'MUSDES-SURVEY' ) {
                            $data_update_mdp['data']['stereotype'] = 'MUSDES-SURVEY-REVOKED';
                            $stereotype_assignment = 'MUSDES';
                        } else if ( $row->stereotype == 'VERIVALI-GRABBED' ) {
                            $data_update_mdp['data']['stereotype'] = 'VERIVALI-GRAB-REVOKED';
                            $stereotype_assignment = 'VERIVALI';
                        } else if ( $row->stereotype == 'VERIVALI-DOWNLOADED' ) {
                            $data_update_mdp['data']['stereotype'] = 'VERIVALI-DOWNLOAD-REVOKED';
                            $stereotype_assignment = 'VERIVALI';
                        } else if ( $row->stereotype == 'VERIVALI-SURVEY' ) {
                            $data_update_mdp['data']['stereotype'] = 'VERIVALI-SURVEY-REVOKED';
                            $stereotype_assignment = 'VERIVALI';
                        } else if ( $row->stereotype == 'MUSDES-GRAB-REVOKED' ) {
                            $data_update_mdp['data']['stereotype'] = 'PROVINCE-PUBLISHED';
                            $stereotype_assignment = null;
                        } else if ( $row->stereotype == 'MUSDES-DOWNLOAD-REVOKED' ) {
                            $data_update_mdp['data']['stereotype'] = 'PROVINCE-PUBLISHED';
                            $stereotype_assignment = null;
                        } else if ( $row->stereotype == 'MUSDES-SURVEY-REVOKED' ) {
                            $data_update_mdp['data']['stereotype'] = 'PROVINCE-PUBLISHED';
                            $stereotype_assignment = null;
                        } else if ( $row->stereotype == 'VERIVALI-GRAB-REVOKED' ) {
                            $data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
                            $stereotype_assignment = null;
                        } else if ( $row->stereotype == 'VERIVALI-DOWNLOAD-REVOKED' ) {
                            $data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
                            $stereotype_assignment = null;
                        } else if ( $row->stereotype == 'VERIVALI-SURVEY-REVOKED' ) {
                            $data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
                            $stereotype_assignment = null;
                        }

                        $user_ip = client_ip();
                        $audit_trails = json_decode( $row->audit_trails, true );
                        $audit_trails[] = [
                            "ip" => $user_ip['ip_address'],
                            "on" => $datetime,
                            "act" => "BATCH",
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
                            'data_log_description' => 'Revoke Data id_prelist ' . $row->id_prelist,
                            'data_log_stereotype' => $data_update_mdp['data']['stereotype'],
                            'data_log_row_status' => $row->row_status,
                            'data_log_lastupdate_by' => $this->user_info['user_id'],
                            'data_log_lastupdate_on' => $datetime,
                        ];
                        save_data( 'asset.master_data_log', $params_insert_master_data_log);

                        if ( $stereotype_assignment != null ) {
                            $params_update_assignment = [
                                'table' => 'dbo.ref_assignment',
                                'data' => [
                                    'row_status' => 'DELETED'
                                ],
                                'where' => [
                                    'proses_id' => $id,
                                    'stereotype' => $stereotype_assignment,
                                ],
                            ];
                            save_data( $params_update_assignment);
                        }

                        $success++;
                        $arr_output['message'] = $success .' data berhasil dibatch.';
                        $arr_output['message_class'] = 'response_confirmation alert alert-success';
                    } else {
                        $failed++;
                        $arr_output['message'] = $failed .' data gagal dibatch.';
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

        $option_propinsi = '<option value="0">Pilih Provinsi</option>';
        $option_kelurahan = '<option value="0">Pilih Kelurahan</option>';
        $option_kota = '<option value="0">Pilih Kota/Kabupaten</option>';
        $option_kecamatan = '<option value="0">Pilih Kecamatan</option>';
        $option_kelurahan = '<option value="0">Pilih Kelurahan</option>';

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


        $this->db->select('short_label, code, long_label');
        $status_data = $this->db->get('dbo.ref_references')->result_array();
        $option_status = '<option value="">Semua Status</option>';
        foreach ($status_data as $key => $value) {
            $option_status .= '<option value="' . $value['short_label'] . '">' . $value['code'] . $value['long_label'] . '</option>';
        }
        // echo "<pre>";
        // print_r($option_kelurahan);
        // die;

        $form_cari = '
        <div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
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
        <div class="form-group col-md-2">
        <select id="select-status" name="status" class="js-example-basic-single form-control">
        '.$option_status.'
        </select>
        </div>
        <div class="form-group col-md-2">
        <button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Refresh</button>
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
