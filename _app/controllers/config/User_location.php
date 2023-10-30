<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#show status 0
class User_Location extends Backend_Controller {

    public function __construct() {
        parent::__construct();
        $this->dir = base_url( 'config/user_location/' );
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
            'col_id' => 'id',
			'sort' => 'desc',
            'columns' => "
                { name:'account_id', display:'UID', width:50, sortable:false, align:'center', datasuorce: false},
                { name:'username', display:'Username', width:120, sortable:true, align:'left', datasuorce: false},
                { name:'fullname', display:'Nama Lengkap', width:170, sortable:true, align:'left', datasuorce: false},
                { name:'email', display:'Email', width:120, sortable:false, align:'left', datasuorce: false},
                { name:'hp', display:'No Handphone', width:120, sortable:true, align:'left', datasuorce: false},
                { name:'android_id', display:'Android ID', width:120, sortable:true, align:'left', datasuorce: false},
                { name:'group_title', display:'Grup',  width:150, sortable:true, align:'left', datasuorce: false},
                { name:'village_name', display:'Kelurahan',  width:150, sortable:true, align:'left', datasuorce: false},
                { name:'district_name', display:'Kecamatan',  width:150, sortable:true, align:'left', datasuorce: false},
                { name:'regency_name', display:'Kabupaten',  width:150, sortable:true, align:'left', datasuorce: false},
                { name:'province_name', display:'Provinsi',  width:150, sortable:true, align:'left', datasuorce: false},

            ",
            'toolbars' => "
            ",
            'filters' => "
                { display:'Nama Lengkap', name:'user_profile_first_name', type:'text', isdefault: true },
                { display:'Username', name:'user_account_username', type:'text', isdefault: true },
                { display:'Grup', name:'user_group_id', type:'select', option: '2:Korwil|3:Enumerator|4:Supervisor|5:Monitoring-Kualitas|1003:Korkab' },
                { display:'Status', name:'user_account_is_active', type:'select', option: '1:Aktif|0:Tidak Aktif' },
            ",
        ];
        $data['grid']['title'] = 'User Grup & Lokasi';
        $data['grid']['link_data'] = $this->dir . "get_show_data";
        $data['grid']['table_title'] = 'Daftar Foto Dokumensi Hasil Musyawarah Desa/Musyawarak Kelurahan';
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
                    $( "#select-kabupaten ").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
                } else {
                    get_location(params);
                }
                $( "#select-kecamatan ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
                $( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
            });

            $("#select-kabupaten").on( "change", function(){
                let params = {
                    "location_id": $(this).val(),
                    "level": "4",
                    "title": "Kecamatan",
                }
                if ( $(this).val() == "0" ) {
                    $( "#select-kecamatan ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
                } else {
                    get_location(params);
                }
                $( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
            });

            $("#select-kecamatan").on( "change", function(){
                let params = {
                    "location_id": $(this).val(),
                    "level": "5",
                    "title": "Kelurahan",
                }
                if ( $(this).val() == "0" ) {
                    $( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
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
                        $("#select-" + params.title.toLowerCase() ).html( option );
                    },
                });
            };
        });
        </script>
        ';
        $this->template->breadcrumb( $this->breadcrumb );

        $this->template->title( $data['grid']['title'] );
        $this->template->content( "general/Table_grid_view", $data );
        $this->template->show( THEMES_BACKEND . 'index' );
    }

    function get_show_data() {
        $input = $this->input->post();
        $where = [];
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

            if ( isset( $input['params'] ) ) {
                $par = $input['params'];
                $params = json_decode( $par, true );
                foreach ( $params[0] as $field => $value ) {
                    if ( $value > '0' ) $where['l.' . $field] = $value;
                }
            }
        } else {
            $where['l.country_id'] = '0';
            $where['l.province_id'] = '0';
            $where['l.regency_id'] = '0';
            $where['l.district_id'] = '0';
            $where['l.village_id'] = '0';
        }

        $par = $input['querys'];
		if ( !empty($par) ) {
			$params = json_decode( $par, true );
			foreach ($params as $key => $value) {
				if ($value['filter_field'] == 'user_account_is_active') {
					$where['cua.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_account_username') {
					$where['cua.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_group_id') {
					$where['cug.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_profile_first_name') {
					$where['cup.'.$value['filter_field']] = $value['filter_value'];
				}
			}
		}

        $params = [
            'table' => [
                'dbo.core_user_account cua' => '',
                'dbo.user_group ug' => ['cua.user_account_id = ug.user_group_user_account_id', 'left'],
                'dbo.core_user_profile cup' => ['cua.user_account_id = cup.user_profile_id', 'left'],
                'dbo.core_user_group cug' => ['ug.user_group_group_id = cug.user_group_id', 'left'],
                'dbo.user_location ul' => ['cua.user_account_id = ul.user_location_user_account_id', 'left'],
                'dbo.ref_locations l' => ['ul.user_location_location_id = l.location_id', 'left']
            ],
            'select' => '
                cua.user_account_id id,
                cua.user_account_username username,
                cup.user_profile_first_name fn,
                cup.user_profile_last_name ln,
                cua.user_account_email email,
                cup.user_profile_no_hp hp,
                cup.user_profile_android_id android_id,
                cug.user_group_title group_title,
                l.province_name,
                l.regency_name,
                l.district_name,
                l.village_name
                ',
            'order_by' => 'cua.user_account_id ' . $input['sortorder'],
            'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
            'limit' => $input['rp'],
            'where' => $where
        ];
        // print_r($params);
        // die;
        if ( ! empty( $input['filterRules'] ) ) {
            $filterRules = filter_json( $input['filterRules'] );
            $params = array_merge( $params, $filterRules );
        }
        $query = get_data( $params );
        $params_count = [
            'table' => [
                'dbo.core_user_account cua' => '',
                'dbo.user_group ug' => ['cua.user_account_id = ug.user_group_user_account_id', 'left'],
                'dbo.core_user_profile cup' => ['cua.user_account_id = cup.user_profile_id', 'left'],
                'dbo.core_user_group cug' => ['ug.user_group_group_id = cug.user_group_id', 'left'],
                'dbo.user_location ul' => ['cua.user_account_id = ul.user_location_user_account_id', 'left'],
                'dbo.ref_locations l' => ['ul.user_location_location_id = l.location_id', 'left']
            ],
            'select' => 'count(cua.user_account_id) jumlah',
            'where' => $where,
        ];
        $query_count = get_data( $params_count );
        header("Content-type: application/json");
        $data = [];
        foreach ( $query->result() as $par => $row ) {
            $fullname = $row->fn .' '. $row->ln;
            $row_data = [
                'id' => $row->id,
                'cell' => [
                    'account_id' =>  $row->id,
                    'username' => $row->username,
                    'fullname' => $fullname,
                    'email' => $row->email,
                    'hp' => $row->hp,
                    'android_id' => $row->android_id,
                    'group_title' => $row->group_title,
                    'province_name' => $row->province_name,
                    'regency_name' => $row->regency_name,
                    'district_name' => $row->district_name,
                    'village_name' => $row->village_name,
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

        $option_propinsi = '<option value="0">Pilih Provinsi</option>';
        $option_kelurahan = '<option value="0">Pilih Kelurahan</option>';
        $option_kota = '<option value="0">Pilih Kota/Kabupaten</option>';
        $option_kecamatan = '<option value="0">Pilih Kecamatan</option>';
        $option_group = '<option value="0">Semua Group</option>';

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

        $params_group = [
			'table' => 'ref_references',
			'select' => 'code, short_label, long_label',
		];
		$query_group = get_data( $params_group );
		foreach ( $query_group->result() as $key => $value) {
			$option_group .= '<option value="' . $value->short_label . '" >[' . $value->code . '] ' . $value->long_label . '</option>';
		}


        $form_cari = '
        <div class="row">
        <div class="form-group col-md-2">
        <select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" ' . ( ( ( $jml_propinsi == '1') && ( ! empty( $user_location['province_id'] ) ) ) ? 'disabled ' : '' ) . '>
        ' . $option_propinsi . '
        </select>
        </div>
        <div class="form-group col-md-3">
        <select id="select-kabupaten" name="kabupaten" class="js-example-basic-single form-control" ' . ( ( ( $jml_kota == '1' ) && ( ! empty( $user_location['regency_id'] ) ) ) ? 'disabled ' : '' ) . '>
        ' . $option_kota . '
        </select>
        </div>
        <div class="form-group col-md-2">
        <select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control" ' . ( ( ( $jml_kecamatan == '1' ) && ( ! empty( $user_location['district_id'] ) ) ) ? 'disabled ' : '' ) . '>
        ' . $option_kecamatan . '
        </select>
        </div>
        <div class="form-group col-md-3">
        <select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" ' . ( ( ( $jml_kelurahan == '1' ) && ( ! empty( $user_location['village_id'] ) ) ) ? 'disabled ' : '' ) . '>
        ' . $option_kelurahan . '
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
		$level=$_GET['level'];
		if($level==3)
			$parent_id='province_id';
		elseif($level==4)
			$parent_id='regency_id';
		if($level==5)
			$parent_id='district_id';


		$params = [
			'table' => 'asset.vw_administration_regions',
			'where' => [
				$parent_id => $_GET['location_id']
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

}
