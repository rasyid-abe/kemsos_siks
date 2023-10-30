 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_data extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'korkab/export_data/' );
	}

	function index() {
		$this->show();
	}
	function export_data()
    {
		$kode = $this->uri->segment(4);
		$status = $this->uri->segment(5);
		
		if($status!='0')
			$where_status=" and md.stereotype='$status'";
		else
			$where_status="";
		$data = $this->db->query("SELECT				
				md.*,l.province_name,
				l.regency_name,
				l.district_name,
				l.village_name
				FROM asset.master_data_proses md
				left join dbo.ref_locations l on md.location_id = l.location_id
				where md.location_id=$kode $where_status");
		
		$d['data'] = $data;
		$this->load->view('korkab/export_data', $d);
    }

	function show() {
		$data = array();
		$data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
		$data['cari'] = $this->form_cari();
		$data['grid'] = [
			'col_id' => 'asset_id',
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
				{ name:'status_rumahtangga', display:'Status', width:70, sortable:true, align:'left', datasuorce: false},
				{ name:'apakah_mampu', display:'Mampu', width:50, sortable:true, align:'left', datasuorce: false},
				{ name:'hasil_verivali', display:'Hasil Vervali', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'petugas_musdes', display:'Enum Musdes', width:60, sortable:true, align:'left', datasuorce: false},
				{ name:'petugas_verivali', display:'Enum Verval', width:60, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:90, sortable:true, align:'left', datasuorce: false},
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
		$data['grid']['title'] = 'Export Data';
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
					
					$( "button#export" ).on( "click", function(){
						var kelurahan = $( "#select-kelurahan ").val();
						var status = $( "#select-status ").val();
						if (kelurahan == 0) {
							alert("Maaf, Anda harus mengisi data sampai tingkat kelurahan");
							return false;
						}
						window.open("' . $this->dir . 'export_data/"+ kelurahan + "/" + status);
		
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
		$this->template->content( "general/Table_grid_export", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data() {
		$input = $this->input->post();
		$where = [];
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ( $field == 'stereotype') {
					if ( $value > '0' ) $where['md.' . $field] = $value;
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
			
				
				if ( ! empty( $jml_negara) ) $where['l.country_id ' . ( ( $jml_negara >= '2' ) ? "IN ({$user_location['country_id']}) " : "= {$user_location['country_id']}" )] = null; 
				if ( ! empty( $jml_propinsi) ) $where['l.province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : "= {$user_location['province_id']}" )] = null; 
				if ( ! empty( $jml_kota) ) $where['l.regency_id ' . ( ( $jml_kota >= '2' ) ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}" )] = null; 
			
			} else {
				$where['l.country_id'] = '0';
				$where['l.province_id'] = '0';
				$where['l.regency_id'] = '0';
			}
		}
		
		$params = [
			'table' => [
				'asset.master_data_proses md' => '',
				'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left'],
				'dbo.ref_references r' => ['r.short_label = md.stereotype', 'left'],
				'dbo.ref_assignment a1' => ["md.proses_id = a1.proses_id and a1.stereotype='MUSDES' and a1.row_status='ACTIVE'", 'left'],
				'dbo.ref_assignment a2' => ["md.proses_id = a2.proses_id and a2.stereotype='VERIVALI' and a2.row_status='ACTIVE'", 'left'],
				'dbo.core_user_profile u1' => ['a1.user_id=u1.user_profile_id', 'left'],
				'dbo.core_user_profile u2' => ['a2.user_id=u2.user_profile_id', 'left']
			],
			'select' => "
				md.proses_id,
				md.stereotype,
				md.row_status,
				md.status_rumahtangga,
				md.jenis_kelamin_krt,
				md.nama_pasangan_krt,
				md.alasan_tidak_ditemukan,
				md.apakah_mampu,
				md.hasil_verivali,
				concat(u1.user_profile_first_name,' ',u1.user_profile_last_name) as surveyor_musdes,
				concat(u2.user_profile_first_name,' ',u2.user_profile_last_name) as surveyor_verval,
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
			$hasil_verivali = "";
			$status_ruta = "";
			$mampu = "";
			
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

			
			if($row->alasan_tidak_ditemukan=='1')
				$alasan_tidak_ditemukan='Pindah';
			elseif($row->alasan_tidak_ditemukan=='2')
				$alasan_tidak_ditemukan='Meninggal';
			elseif($row->alasan_tidak_ditemukan=='3')
				$alasan_tidak_ditemukan='Tidak Tahu';
			elseif($row->alasan_tidak_ditemukan=='4')
				$alasan_tidak_ditemukan='Alamat tidak ada di Desa/Kelurahan Setempat';
			else
				$alasan_tidak_ditemukan='';		
			
			
			if($row->jenis_kelamin_krt=='1')
				$jenis_kelamin_krt='Laki-laki';
			elseif($row->jenis_kelamin_krt=='2')
				$jenis_kelamin_krt='Perempuan';
				
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
					'status_rumahtangga' => $status_ruta,
					'alasan_tidak_ditemukan' => $alasan_tidak_ditemukan,
					'apakah_mampu' => $mampu,
					'hasil_verivali' => $hasil_verivali,
					'petugas_musdes' => $row->surveyor_musdes,
					'petugas_verivali' => $row->surveyor_verval,
					'province_name' => $row->province_name,
					'regency_name' => $row->regency_name,
					'district_name' => $row->district_name,
					'village_name' => $row->village_name,
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
		$option_status = '<option value="0">Semua Status</option>';
		

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
		
		
		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
				<div class="row col-md-12">
					<div class="form-group col-md-3">
						<select id="select-propinsi" name="propinsi" class="form-control" ' . ( ( ( $jml_propinsi == '1') && ( ! empty( $user_location['province_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_propinsi . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kabupaten" name="kabupaten" class="form-control" ' . ( ( ( $jml_kota == '1' ) && ( ! empty( $user_location['regency_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kota . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kecamatan" name="kecamatan" class="form-control" ' . ( ( ( $jml_kecamatan == '1' ) && ( ! empty( $user_location['district_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kecamatan . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kelurahan" name="kelurahan" class="form-control" ' . ( ( ( $jml_kelurahan == '1' ) && ( ! empty( $user_location['village_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kelurahan . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-status" name="status" class="form-control">
							' . $option_status . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<button type="button" id="cari" class="btn btn-info btn-sm"><i class="fa fa-search"></i>&nbsp;Cari</button>
						<button type="button" id="export" class="btn btn-info btn-sm"><i class="fa fa-download"></i>&nbsp;Export Data</button>
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
