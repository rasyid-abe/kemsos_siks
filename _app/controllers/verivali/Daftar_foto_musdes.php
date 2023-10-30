 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
#show status 0
class Daftar_foto_musdes extends Backend_Controller {

    public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'verivali/daftar_foto_musdes/' );
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
			'col_id' => 'file_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'status', display:'Status', width:50, sortable:false, align:'center', datasuorce: false},
				{ name:'internal_filename', display:'Foto', width:170, sortable:true, align:'left', datasuorce: false},
				{ name:'province_name', display:'Provinsi', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kabupaten', width:120, sortable:false, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Kelurahan', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'file_name', display:'Nama File',  width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'file_size', display:'Ukuran File', width:80, sortable:true, align:'right', datasuorce: false},
				{ name:'stereotype', display:'Jenis Foto', width:100, sortable:true, align:'center', datasuorce: false},
				{ name:'description', display:'Deskripsi', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'created_by', display:'Diupload Oleh', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'username', display:'Kontak', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'created_on', display:'Diupload Pada', width:120, sortable:true, align:'center', datasuorce: false},
			",
			'toolbars' => "
			",
			'filters' => "
				{ display:'Di Upload Oleh', name:'nama_depan', type:'text', isdefault: true },
				{ display:'Kontak', name:'username', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Daftar Foto Hasil Dokumentasi Musdes';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
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
							$( "#select-kabupaten ").html( "<option value=\'0\'>Pilih Kota/Kabupaten</option>" );
						} else {
							get_location(params);
						}
						$( "#select-kecamatan ").html( "<option value=\'0\'>Pilih Kecamatan</option>" );
						$( "#select-kelurahan ").html( "<option value=\'0\'>Pilih Kelurahan</option>" );
					});

					$("#select-kabupaten").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "4",
							"title": "Kecamatan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kecamatan ").html( "<option value=\'0\'>Pilih Kecamatan</option>" );
						} else {
							get_location(params);
						}
						$( "#select-kelurahan ").html( "<option value=\'0\'>Pilih Kelurahan</option>" );
					});

					$("#select-kecamatan").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "5",
							"title": "Kelurahan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kelurahan ").html( "<option value=\'0\'>Pilih Kelurahan</option>" );
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

								let option = `<option value="0">Pilih ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )}</option>`;
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

        $sql_where_in = '';
		if ( isset($where_in['md.id_prelist'])) {
			$data_in = "'" . implode("','", $where_in['md.id_prelist']) . "'";
			$in_where = preg_replace('/\s+/', '', $data_in);
			$sql_where_in = 'AND md.id_prelist IN (' .$in_where. ')';
		}

        $sql_query = "
            SELECT
                fl.file_id,
                fl.row_status,
                fl.internal_filename,
                fl.province_name,
                fl.regency_name,
                fl.district_name,
                fl.village_name,
                fl.file_name,
                fl.file_size,
                fl.stereotype,
                fl.description,
                fl.username,
                fl.nama_depan,
                fl.nama_belakang,
                fl.created_on
            FROM
                dbo.vw_file_location fl
            LEFT JOIN dbo.ref_locations l ON fl.location_id = l.location_id
    		WHERE $sql_where 1=1 $sql_where_in
    		ORDER BY fl.file_id ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		";

		$sql_count = "
            SELECT COUNT
                ( fl.file_id ) jumlah
            FROM
                dbo.vw_file_location fl
            LEFT JOIN dbo.ref_locations l ON fl.location_id = l.location_id
            WHERE $sql_where 1=1 $sql_where_in
		";

        $query = data_query( $sql_query );
        $query_count = data_query( $sql_count );

		// $params = [
		// 	'table' => [
		// 		'dbo.vw_file_locations fl' => '',
        //         'dbo.ref_locations l' => ['fl.location_id = l.location_id', 'left']
		// 	],
		// 	'select' => '
		// 		fl.file_id,
		// 		fl.row_status,
		// 		fl.internal_filename,
		// 		fl.province_name,
		// 		fl.regency_name,
		// 		fl.district_name,
		// 		fl.village_name,
		// 		fl.file_name,
		// 		fl.file_size,
		// 		fl.stereotype,
		// 		fl.description,
		// 		fl.username,
		// 		fl.nama_depan,
		// 		fl.nama_belakang,
		// 		fl.created_on,
		// 	',
		// 	'order_by' => 'fl.file_id ' . $input['sortorder'],
		// 	'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
		// 	'limit' => $input['rp'],
		// 	'where' => $where
		// ];
		// if ( ! empty( $input['filterRules'] ) ) {
		// 	$filterRules = filter_json( $input['filterRules'] );
		// 	$params = array_merge( $params, $filterRules );
		// }
		// $query = get_data( $params );
		// $params_count = [
		// 	'table' => [
		// 		'dbo.vw_file_location fl' => '',
        //         'dbo.ref_locations l' => ['fl.location_id = l.location_id', 'left']
		// 	],
		// 	'select' => 'count(fl.file_id) jumlah',
		// 	'where' => $where,
		// ];
		// $query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$status = $row->row_status == 'ACTIVE' ? '<img src="' . base_url('assets/style') . '/active.png">' : '<img src="' . base_url('assets/style') . '/nonactive.png">';
            $url = 'http://66.96.235.136:8080/apiverval/';
            $image = '<img src="'.$url.substr($row->internal_filename, 2).'" width=50px>';
            $image = '<a href="'.$url.substr($row->internal_filename, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
                <img src="'.$url.substr($row->internal_filename, 2).'" style="height:150px;width:150px">
            </a>';
			$row_data = [
				'id' => $row->file_id,
				'cell' => [
					'status' => $status,
					'internal_filename' => $image,
					'province_name' => $row->province_name,
					'regency_name' => $row->regency_name,
					'district_name' => $row->district_name,
					'village_name' => $row->village_name,
					'file_name' => $row->file_name,
					'file_size' => $row->file_size.' kb',
					'stereotype' => $row->stereotype,
					'description' => $row->description,
					'created_by' => $row->nama_depan. ' '.$row->nama_belakang,
					'username' => $row->username,
					'created_on' => convert_date($row->created_on),
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
