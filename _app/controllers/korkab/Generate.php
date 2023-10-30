<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->json = [];
		$this->dir = "korkab/generate/";
		$this->load->model('auth_model');
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['grid'] = [
			'col_id' => 'user_account_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'user_account_id', display:'User Id', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'user_account_username', display:'Username', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'user_full_name', display:'Nama Lengkap', width:180, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
			",
			'filters' => "
				{ display:'User Id', name:'user_account_id', type:'text', isdefault: true },
				{ display:'Username', name:'user_account_username', type:'text', isdefault: true },
				{ display:'Nama Lengkap', name:'user_profile_first_name', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Generate Example Data';
		$data['grid']['link_data'] =  base_url( $this->dir ) . "get_show_data";

		$data['grid2'] = [
			'col_id' => 'location_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'location_id', display:'Id', width:40, sortable:true, align:'left', datasuorce: false},
				{ name:'province_name', display:'Propinsi', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kab/Kota', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Desa', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'hitung', display:'prelist', width:50, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
			",
			'filters' => "
				{ display:'Nama Menu', name:'menu_name', type:'text', isdefault: true },
				{ display:'Status', name:'menu_is_active', type:'select', option: '1:Aktif|0:Tidak Aktif' },
			",
		];
		$data['grid2']['title'] = 'User Management';
		$data['grid2']['link_data'] =  base_url( $this->dir ) . "get_show_location";
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "korkab/Generate", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data(){
		$input = $this->input->post();
		$where['user_group_group_id'] = 4;

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

        $sql_query = "
			SELECT DISTINCT
				user_account_id,
				user_group_group_id,
				user_account_username,
				user_profile_first_name,
				user_profile_last_name
			FROM dbo.core_user_account cua
			LEFT JOIN dbo.user_group ug ON cua.user_account_id = ug.user_group_user_account_id
			LEFT JOIN dbo.core_user_profile cup ON cua.user_account_id = cup.user_profile_id
    		WHERE $sql_where 1=1
    		ORDER BY user_account_id ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		";

		$sql_count = "
            SELECT COUNT
                ( DISTINCT user_account_id ) jumlah
			FROM dbo.core_user_account cua
			LEFT JOIN dbo.user_group ug ON cua.user_account_id = ug.user_group_user_account_id
			LEFT JOIN dbo.core_user_profile cup ON cua.user_account_id = cup.user_profile_id
			WHERE $sql_where 1=1
		";

        $query = data_query( $sql_query );
        $query_count = data_query( $sql_count );

		// $params = [
		// 	'table' => [
		// 		'dbo.core_user_accounta cua' => '',
        //         'dbo.user_group ug' => ['cua.user_account_id = ug.user_group_user_account_id', 'left'],
        //         'dbo.core_user_profile cup' => ['cua.user_account_id = cup.user_profile_id', 'left']
		// 	],
		// 	'select' => 'DISTINCT  user_account_id, user_group_group_id,   user_account_username, user_profile_first_name, user_profile_last_name',
		// 	'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
		// 	'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
		// 	'limit' => $input['rp'],
		// 	'where' => $where
		// ];
		// $params_count = [
		// 	'table' => [
		// 		'core_user_account' => '',
		// 		'core_user_profile' => ['user_account_id = user_profile_id', 'LEFT'],
		// 		'dbo.user_group ug' => ['user_account_id = ug.user_group_user_account_id', 'left'],
		// 	],
		// 	'select' => 'count(DISTINCT user_account_id) jumlah',
		// 	'where' => $where
		// ];
		// $user_location = $this->user_info['user_location'];
		// $in_location = '';
		// if ( ! in_array( '100000', $user_location ) ) {
		// 	$params['where'] = [
		// 		'user_account_create_by' => $this->user_info['user_id'],
		// 	];
		// 	$params_count['where'] = [
		// 		'user_account_create_by ' => $this->user_info['user_id'],
		// 	];
		// }
		//
		// $query = get_data( $params );
		// $query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$user_full_name = $row->user_profile_first_name . ' ' .$row->user_profile_last_name;
			$row_data = [
				'id' => $row->user_account_id,
				'cell' => [
					'user_account_id' => $row->user_account_id,
					'user_account_username' => $row->user_account_username,
					'user_full_name' => $user_full_name,
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
	function get_show_location(){
		$input = $this->input->post();
		$where = 0;
		$where2['monev'] = 0;
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ( $value > '0' ) $where = $value;
			}
		} else {
			$where = 0;
		}
		$params = [
			'table' => [
				'asset.get_sel_location_by_user2('.$where.')' => ''
			],
			'select' => '*',
			'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
			'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
			'where' => $where2
		];
		$params_count = [
			'table' => [
				'asset.get_sel_location_by_user2('.$where.')' => ''
			],
			'select' => 'count(location_id) jumlah',
			'where' => $where2
		];
		$user_location = $this->user_info['user_location'];
		$in_location = '';

		$query = get_data( $params );
		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$row_data = [
				'id' => $row->location_id,
				'cell' => [
					'location_id' => $row->location_id,
					'location_name' => $row->location_name,
					'village_name' => $row->village_name,
					'district_name' => $row->district_name,
					'regency_name' => $row->regency_name,
					'province_name' => $row->province_name,
					'hitung' => $row->hitung,
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
	function get_data_location(){
		$item = $this->input->post('item');
		$val_gen = $this->input->post('val_gen');
		$item= json_decode($item);
		$ids_mampu = array();
		foreach ($item as $v) {
			$ids_mampu2 = $this->auth_model->getAssetIDVerval($v);
			$ids_mampu=array_merge($ids_mampu,$ids_mampu2->result());
		}
		$res_ids_mampu=$this->pickRandomAssetID($ids_mampu, round($val_gen));
		if($res_ids_mampu)
		{
			$this->copyMonevDataByAssetID($res_ids_mampu);
			die(
				json_encode(
					[
						'status' => 200,
						'message' => ' Data Berhasil Digenerate !.',
					]
				)
			);
		}
		else
		{
			die(
				json_encode(
					[
						'status' => 400,
						'message' => 'Nilai generate lebih besar dari data yang tersedia',
					]
				)
			);
		}

	//	$json->is_ok = true;
	//	print_r(json_encode($json));
	}
	function pickRandomAssetID($data, $count){
		$res_asset_id = array();
		$c = $count;
		$max_random = count($data);
		if($c<=$max_random)
		{
			while ($c > 0)
			{
				$rand_num = rand(0,$max_random-1);
				$c--;
				$asset_id = $data[$rand_num]->proses_id;
				$res_asset_id[] = $asset_id;
				array_splice($data, $rand_num, 1);

				$max_random--;

			}
			return($res_asset_id);
		}
		else
			return false;
	}

	function copyMonevDataByAssetID($asset_ids)
	{
		$datetime = date( "Y-m-d H:i:s");
		foreach ($asset_ids as $key => $val)
		{
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
			$id = $val;
			$params_get = [
				'table' => 'asset.master_data_proses',
				'where' => [
					'proses_id' => $id
				],
				// 'select' => 'asset_id, stereotype, row_status'
			];
			$get_data = get_data( $params_get )->row();
			$get_data->stereotype = 'VERIVALI-PUBLISHED';
			$get_data->row_status = 'MONITORING-RESPONDENT-ALGORITHM';
			$get_data->parent_id = $get_data->proses_id;
			$get_data->proses_id;
			unset( $get_data->dengan_foto );
			unset( $get_data->flag_sync );
			unset( $get_data->asset_id );
			unset( $get_data->jenis_pelanggan_gas_lainnya );
			$get_data->row_status = 'COPY';
			$get_data->audit_trails = json_encode(
				[
					[
						"ip" => $ip_address,
						"on" => $datetime,
						"act" => "COPY",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"proses_id" => $id,
							"stereotype" => 'VERIVALI-PUBLISHED'
						],
						"is_proxy_access" => $is_proxy
					],
				]
			);
			save_data( 'monev.monev_data', $get_data);
			
			$params_update_master_data = [
				'table' => 'asset.master_data_proses',
				'data' => [
					'row_status' => 'RESPONDENT'
				],
				'where' => [
					'proses_id' => $id
				],
			];
			save_data( $params_update_master_data);

			$params_detail = [
				'table' => [
					'asset.master_data_detail_proses' => ''
				],
				'select' => '*',
				'where' => [
					'proses_id' => $id
				],
			];
			$query_detail = get_data( $params_detail );
			header("Content-type: application/json");
			$data = [];
			foreach ( $query_detail->result() as $par => $row ) {
				save_data( 'monev.monev_data_detail', $row);
			}

			$params_kk = [
				'table' => [
					'asset.master_data_detail_proses_kk' => ''
				],
				'select' => '*',
				'where' => [
					'proses_id' => $id
				],
			];
			$query_kk = get_data( $params_kk );
			header("Content-type: application/json");
			$data = [];
			foreach ( $query_kk->result() as $par => $row ) {
				save_data( 'monev.monev_data_detail_kk', $row);
			}
			
		}
	}


}
