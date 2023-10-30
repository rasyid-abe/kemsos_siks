<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_location extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'admin/master_location/' );
		$this->load->model('auth_model');
        $this->json = [];
	}

	function index() {
		$this->show();
	}

	function show() {
		$par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
		$data = array();
		$data['cari'] = $this->form_cari();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
        $data['grid'] = [
            'col_id' => 'location_id',
            'sort' => 'asc',
			'columns' => "
                { name:'location_id', display:'ID', width:70, sortable:true, align:'center', datasuorce: false},
                { name:'bps_province_code', display:'Kode Propinsi', width:110, sortable:true, align:'center', datasuorce: false},
				{ name:'bps_regency_code', display:'Kode Kabupaten', width:120, sortable:true, align:'center', datasuorce: false},
				{ name:'bps_district_code', display:'Kode Kecamatan', width:120, sortable:true, align:'center', datasuorce: false},
				{ name:'bps_village_code', display:'Kode Kelurahan', width:115, sortable:true, align:'center', datasuorce: false},
				{ name:'province_name', display:'Nama Propinsi', width:160, sortable:true, align:'center', datasuorce: false},
				{ name:'regency_name', display:'Nama Kabupaten', width:160, sortable:true, align:'center', datasuorce: false},
				{ name:'district_name', display:'Nama Kecamatan', width:160, sortable:true, align:'center', datasuorce: false},
				{ name:'village_name', display:'Nama Kelurahan', width:160, sortable:true, align:'center', datasuorce: false},
			",
			'toolbars' => "
			",
            'filters' => "
				{},
			",
		];
		$data['grid']['title'] = 'Master Data Lokasi';
		$data['grid']['link_data'] =  base_url( 'admin/master_location' ) . "/get_data";

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
							$( "#select-kabupaten ").html( "<option value=\'0\'>Semua Kota/Kabupaten</option>" );
						} else {
							get_location(params);
						}
						$( "#select-kecamatan ").html( "<option value=\'0\'>Semua Kecamatan</option>" );
						$( "#select-kelurahan ").html( "<option value=\'0\'>Semua Kelurahan</option>" );
					});

					$("#select-kabupaten").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "4",
							"title": "Kecamatan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kecamatan ").html( "<option value=\'0\'>Semua Kecamatan</option>" );
						} else {
							get_location(params);
						}
						$( "#select-kelurahan ").html( "<option value=\'0\'>Semua Kelurahan</option>" );
					});

					$("#select-kecamatan").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "5",
							"title": "Kelurahan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kelurahan ").html( "<option value=\'0\'>Semua Kelurahan</option>" );
						} else {
							get_location(params);
						}
					});

					$( "button#cari" ).on( "click", function(){
						$("#loader").modal("show");
						$( "#gridview" ).flexOptions({
							url: "' . $this->dir . 'get_data",
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

								let option = `<option value="0">Semua ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )}</option>`;
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
		$this->template->content( "general/Table_grid_popup", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_data(){
        $par = ( isset( $_GET['par'] ) ? dec( $_GET['par'] ) : '0' ) ;
		$input = $this->input->post();

		$user_id = $this->user_info['user_id'];
		$location_user = $this->auth_model->ambil_location_get($user_id);

		if ( ( ! empty( $this->user_info['user_location'] ) ) && ( in_array( 'root', $this->user_info['user_group'] ) ? FALSE :  TRUE ) ){
			$where['location_id' ." IN ({$location_user['village_codes']})"]  = null;
		} elseif ( ( ! empty( $this->user_info['user_location'] ) ) && ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE :  FALSE ) ){
			$user_location = $this->get_user_location();
			$jml_negara = ( ( ! empty( $user_location['country_id'] ) ) ? count( explode( ',', $user_location['country_id'] ) ) : '0' );
			if ( ! empty( $jml_negara) ) $where['country_id ' . ( ( $jml_negara >= '2' ) ? "IN ({$user_location['country_id']}) " : "= {$user_location['country_id']}" )] = null;

		} else {
			$where['country_id'] = '0';
			$where['province_id'] = '0';
			$where['regency_id'] = '0';
			$where['district_id'] = '0';
			$where['village_id'] = '0';
		}

		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {

				if ( $value > '0' ) $where[$field] = $value;
			}
		}

        $params = [
            'table' => 'dbo.vw_locations',
            'select' => '*',
            'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
            'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
			'where' => $where,
        ];

        $query = get_data( $params );
		$params_count = [
            'table' => 'dbo.vw_locations',
			'select' => 'count(location_id) jumlah',
			'where' => $where,
        ];
		$query_count = get_data( $params_count );
        header("Content-type: application/json");
        $data = [];
        foreach ( $query->result() as $par => $row ) {
            $row_data = [
				'id' => $row->location_id,
				'cell' => [
	                'location_id' => $row->location_id,
	                'bps_province_code' => $row->bps_province_code,
	                'bps_regency_code' => $row->bps_regency_code,
					'bps_district_code' => $row->bps_district_code,
					'bps_village_code' => $row->bps_village_code,
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

		$option_propinsi = '<option value="0">Semua Provinsi</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_kota = '<option value="0">Semua Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Semua Kecamatan</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';

		$where_propinsi = [];

		if ( ! empty( $user_location['province_id'] ) ) {
			if ( $jml_propinsi > '0' ) $where_propinsi['province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}" )] = null;
		}

		$params_propinsi = [
			'table' => 'dbo.vw_locations',
			'select' => 'DISTINCT province_id, province_name',
			'where' => $where_propinsi,
			'order_by' => 'province_id',
		];
		$query_propinsi = get_data( $params_propinsi );
		foreach ( $query_propinsi->result() as $key => $value ) {
				$option_propinsi .= '<option value="' . $value->province_id . '">' . $value->province_name . '</option>';
		}

		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
				<div class="row col-md-12">
					<div class="form-group col-md-2">
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
					<div class="form-group col-md-3">
						<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" >
							' . $option_kelurahan . '
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
					'table' => 'dbo.vw_locations',
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
		$user_location = $this->get_user_location();
		$regency_id = $user_location['regency_id'];
		$district_id = $user_location['district_id'];
		$village_id = $user_location['village_id'];
		$id_location = $_GET['location_id'];
		$level = $_GET['level'];
		if ($level == 3)
		{	$parent_id ='province_id';
			$parent = "province_id = $id_location";
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

		} elseif($level==4) {
			$parent_id='regency_id';
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
		}

		if ($level==5)	{
			$parent_id='district_id';
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
			'table' => 'dbo.vw_locations',
			'where' => [
				$parent_id => $_GET['location_id'],
				$child_id => null
			],
			'select' => 'DISTINCT regency_id, district_id, village_id, regency_name, district_name, village_name'
		];


		$query = get_data( $params );
		$data = [];
		foreach  ( $query->result() as $rows ) {
			if($level==3)
			{
				$location_id=$rows->regency_id;
				$name=$rows->regency_name;
			}elseif($level==4)
			{	$location_id=$rows->district_id;
				$name=$rows->district_name;
			}if($level==5)
			{	$location_id=$rows->village_id;
				$name=$rows->village_name;
			}
			$data[$location_id] = $name;
		}
		echo json_encode( $data );
	}

	function get_menu(){
		$params_menu = [
			'select' => 'menu_id, menu_parent_menu_id, menu_name, menu_class, menu_description, menu_action',
			'table' => 'core_menu',
			'where' => [
				'menu_is_active' => '1',
			],
		];
		$query_menu = get_data( $params_menu, 1 );
		$group_menu = [];
		if ( count( $query_menu ) > 1 ) {
			foreach ( $query_menu as $key => $menu ) {
				$group_menu[$menu['menu_parent_menu_id']][] = $menu;
			}
		}
		return $group_menu;
	}

	function struktur_data_menu( $data_menu ){
		$group_menu = [];
		foreach ( $data_menu as $key => $menu ) {
			$group_menu[$menu['user_role_menu_id']] = $menu;
		}
		return $group_menu;
	}

	function grouping_menu( $params = [] ){
		$data_menu = ( ( isset( $params['data_menu'] ) ) ? $params['data_menu'] : [] );
		$arr_menu = ( ( isset( $params['add_menu'] ) ) ? $params['add_menu'] : [] );
		$parent_id = ( ( isset( $params['parent_id'] ) ) ? $params['parent_id'] : 0 );
		$disp_menu = ( ( isset( $params['disp_menu'] ) ) ? $params['disp_menu'] : '' );
		if ( empty( $arr_menu ) ) $arr_menu = $this->get_menu();
		foreach ( $arr_menu[$parent_id] as $key => $value ) {
			$have_child = array_key_exists( $value['menu_id'], $arr_menu );
			$menu_act = json_decode( $value['menu_action'] );
			$data_menu_act = ( ( ( ! empty( $data_menu[$value['menu_id']] ) ) ) ? json_decode( $data_menu[$value['menu_id']]['user_role_menu_action'] ) : [] );
			$disp_menu .= '
				<li class="li-menu custom-checkbox col-12">
					<input name="menu[]" class="custom-control-input" type="checkbox" id="menu_' . ( $value["menu_id"] ) . '" value="' . ( ( ! empty( $row ) ) ? $value['menu_id'] : $value['menu_id'] ) . '" ' . ( ( array_key_exists( $value['menu_id'], $data_menu) ) ? 'checked' : '' ) . '>
					<label id="menu_' . ( $value['menu_id'] ) . '" for="menu_' . ( $value['menu_id'] ) . '" class="menu-label custom-control-label  ' . ( ( ( ! empty( $data_menu_act ) ) && ( is_array( $menu_act ) ) ) ? 'action-active' : '' ) . '"><span class="label-menu">' . $value['menu_name'] . '</span></label>';
				$disp_menu .= '
					<div class="action action-' . $value['menu_id'] . ' col-12">';
				if ( ! $have_child ) {
					$disp_menu .= '
						<ul class="ul-action-' . $value['menu_id'] . ' row col-12">';
					if ( ( is_array( $menu_act ) ) ) {
						foreach ( $menu_act as $k => $act ) {
							$disp_menu .= '
							<div class="action-' . $value['menu_id'] . ' custom-control custom-checkbox col-4"  style="display: ' . ( ( ( ! empty( $data_menu_act ) ) && ( in_array( $act, $data_menu_act ) ) ) ? 'block' : 'none' ) . ';">
								<input name="menu_action[' . $value['menu_id'] . '][]" class="action-' . $value['menu_id'] . ' custom-control-input" type="checkbox" id="' . $value['menu_id'] . '_' . $act . '" value="' . $act . '" ' . ( ( ( ! empty( $data_menu_act ) ) && ( in_array( $act, $data_menu_act ) ) ) ? 'checked' : '' ) . '>
								<label for="' . $value['menu_id'] . '_' . $act . '" class="custom-control-label"><span ="label-action">' . $act . '</span></label>
							</div>';
						}
					}
					$disp_menu .= '
						</ul>';
				}
				$disp_menu .= '
					</div>';
			if ( $have_child ) {
				$disp_menu .= '
					<ul class="ul-menu-' . $value['menu_id'] . ' col-12">';
				$par = [
					'data_menu' => $data_menu,
					'arr_menu' => $arr_menu,
					'parent_id' => $value['menu_id'],
					'disp_menu' => $disp_menu
				];
				$disp_menu = $this->grouping_menu( $par );
				$disp_menu .= '
					</ul>
				</li>';
			}
		}
		return $disp_menu;
	}
}
