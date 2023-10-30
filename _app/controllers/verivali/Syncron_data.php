<?php
defined('BASEPATH') or exit('No direct script access allowed');
// show status 14
class Syncron_data extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->dir = base_url('verivali/syncron_data/');
		$this->load->model('auth_model');
		$this->load->model('stagging_model');
	}

	function index()
	{
		$this->show();
	}

	function show()
	{
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['is_superuser'] = (in_array('root', $this->user_info['user_group']) ? TRUE : FALSE);
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
				{ name:'jenis_kelamin_krt', display:'Gender', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_pasangan_krt', display:'Pasangan', width:90, sortable:true, align:'left', datasuorce: false},
				{ name:'status_rumahtangga', display:'Status', width:80, sortable:true, align:'center', datasuorce: false},
				{ name:'apakah_mampu', display:'Mampu', width:50, sortable:true, align:'center', datasuorce: false},
				{ name:'petugas_musdes', display:'Enum Musdes', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'flag_sync', display:'Syncron', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'detail', display:'Detail', width:50, sortable:true, align:'center', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Syncron', name:'syncron', bclass:'syncron', onpress:act_syncron, urlaction: '" . $this->dir . "act_show'},
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
		$data['grid']['title'] = 'Syncron Data Status 14';
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
										"flag_sync": $( "#select-sync ").val(),
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
		$this->template->breadcrumb($this->breadcrumb);

		$this->template->title($data['grid']['title']);
		$this->template->content("general/Table_grid_data", $data);
		$this->template->show(THEMES_BACKEND . 'index');
	}

	function get_show_data()
	{
		$user_id = $this->user_info['user_id'];
		$location_user = $this->auth_model->ambil_location_get($user_id);
		$input = $this->input->post();
		$where = [];
		$where_in = [];
		if (isset($input['params'])) {
			$par = $input['params'];
			$params = json_decode($par, true);
			foreach ($params[0] as $field => $value) {
				if ($field == 'id_prelist') {
					if ($value > '0')
						$pre_arr = explode("\n", $value);
					$val_prelist = [];
					for ($i = 0; $i < count($pre_arr); $i++) {
						$val_prelist[] = $pre_arr[$i];
					}
					$where_in['md.' . $field] = $val_prelist;
				} else if ($field == 'flag_sync') {
					if ($value > '0') $where['md.' . $field] = $value;
				} else {
					if ($value > '0') $where['l.' . $field] = $value;
				}
			}
			if ((in_array('root', $this->user_info['user_group']) ? FALSE :  TRUE)) {
				$where['l.location_id' . " IN ({$location_user['village_codes']})"]  = null;
			}
			$where['md.stereotype'] = 'VERIVALI-FINAL';
		} else {
			$where['md.stereotype'] = 'VERIVALI-FINAL';
			$where['md.flag_sync'] = '1';
			if ((!empty($this->user_info['user_location'])) && (in_array('root', $this->user_info['user_group']) ? FALSE :  TRUE)) {
				$where['l.location_id' . " IN ({$location_user['village_codes']})"]  = null;
			} elseif ((!empty($this->user_info['user_location'])) && (in_array('root', $this->user_info['user_group']) ? TRUE :  FALSE)) {
				$user_location = $this->get_user_location();
				$jml_negara = ((!empty($user_location['country_id'])) ? count(explode(',', $user_location['country_id'])) : '0');
				if (!empty($jml_negara)) $where['l.country_id ' . (($jml_negara >= '2') ? "IN ({$user_location['country_id']}) " : "= {$user_location['country_id']}")] = null;
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
		if (!empty($par)) {
			$params = json_decode($par, true);
			foreach ($params as $key => $value) {
				$where_querys[$value['filter_field']] = $value['filter_value'];
			}
		}
		$sql_where = '';

		foreach ($where_querys as $key => $value) {
			if ($key == 'surveyor_musdes') {
				$sql_where .= "u1.user_profile_first_name LIKE '%" . $value . "%' AND ";
			} else if ($key == 'surveyor_verval') {
				$sql_where .= "u2.user_profile_first_name LIKE '%" . $value . "%' AND ";
			} else {
				$sql_where .= $key . " LIKE '%" . $value . "%' AND ";
			}
		}

		foreach ($where as $key => $value) {
			if ($value == '') {
				$sql_where .= $key . ' AND ';
			} else if ($key == 'md.stereotype') {
				$sql_where .= $key . " = '" . $value . "' AND ";
			} else {
				$sql_where .= $key . ' = ' . $value . ' AND ';
			}
		}

		$sql_where_in = '';
		if (isset($where_in['md.id_prelist'])) {
			$data_in = "'" . implode("','", $where_in['md.id_prelist']) . "'";
			$in_where = preg_replace('/\s+/', '', $data_in);
			$sql_where_in = 'AND md.id_prelist IN (' . $in_where . ')';
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
				md.flag_sync,
				concat ( u1.user_profile_first_name, ' ', u1.user_profile_last_name ) AS surveyor_musdes,
				md.lastupdate_on,
				l.province_name,
				l.regency_name,
				l.district_name,
				l.village_name,
				r.icon
			FROM
				asset.master_data_proses md
				LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
				LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
				LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id AND a1.stereotype = 'MUSDES'	AND a1.row_status = 'ACTIVE'
				LEFT JOIN dbo.core_user_profile u1 ON a1.user_id = u1.user_profile_id
			WHERE $sql_where 1=1 $sql_where_in
			ORDER BY md.lastupdate_on " . $input['sortorder'] . " OFFSET " . (($input['page'] - 1) * $input['rp']) . " ROWS FETCH NEXT " . $input['rp'] . " ROWS ONLY
		";

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

		$query = data_query($sql_query);
		$query_count = data_query($sql_count);

		header("Content-type: application/json");
		$data = [];
		foreach ($query->result() as $par => $row) {
			$status = '<img src="' . base_url('assets/style/icon-status') . '/' . $row->icon . '">';
			$status_ruta = '';
			$mampu = '';
			$gender = "";

			if ($row->jenis_kelamin_krt == '1') {
				$gender = "Laki-laki";
			} else if ($row->jenis_kelamin_krt == '2') {
				$gender = "Perempuan";
			}
			if ($row->status_rumahtangga == '1') {
				$status_ruta = "<span class='text-success font-weight-bold'>Ditemukan</span>";
			} else if ($row->status_rumahtangga == '2') {
				$status_ruta = "<span class='text-danger font-weight-bold'>Tidak Ditemukan</span>";
			} else if ($row->status_rumahtangga == '3') {
				$status_ruta = "<span class='text-warning font-weight-bold'>Data Ganda</span>";
			} else if ($row->status_rumahtangga == '4') {
				$status_ruta = "<span class='text-primary font-weight-bold'>Usulan Baru</span>";
			}

			if ($row->apakah_mampu == '1') {
				$mampu = "<span class='text-danger font-weight-bold'>Ya</span>";
			} else if ($row->apakah_mampu == '2') {
				$mampu = "<span class='text-success font-weight-bold'>Tidak</span>";
			}

			if ($row->flag_sync == '2') {
				$flag_sync = "<span class='text-danger font-weight-bold'>Syncron</span>";
			} else {
				$flag_sync = "<span class='text-success font-weight-bold'>Belum Syncron</span>";
			}

			$detail = '<button class="btn-edit" act="' . base_url("verivali/detail_data/get_form_detail/" . enc(['proses_id' => $row->proses_id])) . '"><i class="fa fa-search"></i></button>';

			$lastupdate = date("d-m-Y H:i:s", strtotime($row->lastupdate_on));

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
					'flag_sync' => $flag_sync,
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
		echo json_encode($result);
	}

	function act_show()
	{
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();

		// syncron
		if (isset($in['syncron']) && $in['syncron']) {
			$arr_id = json_decode($in['item']);
			if (is_array($arr_id)) {
				$success = $failed = 0;
				$datetime = date("Y-m-d H:i:s");
				foreach ($arr_id as $id) {
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
					];
					$get_data = get_data($params_get)->row();
					if ($get_data->flag_sync != '2') {
						$user_ip = client_ip();
						$audit_trails = json_decode(get_data($params_get)->row('audit_trails'), true);
						$audit_trails[] = [
							"ip" => $user_ip['ip_address'],
							"on" => $datetime,
							"act" => "COPY",
							"user_id" => $this->user_info['user_id'],
							"username" => $this->user_info['user_username'],
							"column_data" => [
								"asset_id" => $id,
								"stereotype" => 'VERIVALI-FINAL',
								"flag_sync" => '2',
							],
							"is_proxy_access" => $user_ip['is_proxy']
						];
						$params_update_master_data = [
							'table' => 'asset.master_data_proses',
							'data' => [
								'flag_sync' => '2',
								'audit_trails' => json_encode($audit_trails),
								'lastupdate_on' => $datetime,
							],
							'where' => [
								'proses_id' => $id
							],
						];
						save_data($params_update_master_data);

						$params_insert_master_data_log = [
							'data_log_master_data_id' => $get_data->proses_id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'Syncron data',
							'data_log_stereotype' => $get_data->stereotype,
							'data_log_row_status' => $get_data->row_status,
							'data_log_lastupdate_by' => $this->user_info['user_id'],
							'data_log_lastupdate_on' => $datetime,
						];
						save_data('asset.master_data_log', $params_insert_master_data_log);

						$kd_propinsi = $get_data->kode_propinsi;
						$cek_tabel = $this->stagging_model->cekTabel('UDRT_' . $kd_propinsi);
						if ($cek_tabel->num_rows() == 0) {
							$this->stagging_model->createTabelRT('dbo.UDRT_' . $kd_propinsi);
							$this->stagging_model->createTabelART('dbo.UDART_' . $kd_propinsi);
							$this->stagging_model->createTabelFoto('dbo.FOTO_' . $kd_propinsi);
						}
						$this->move_rt($id, $kd_propinsi);
						$this->move_detail_art($id, $kd_propinsi);
						$this->move_foto($id, $kd_propinsi);
						$success++;
						$arr_output['message'] = $success . ' data berhasil disyncron.';
						$arr_output['message_class'] = 'response_confirmation alert alert-success';
					} else {
						$failed++;
						$arr_output['message'] = $failed . ' data gagal disyncron.';
						$arr_output['message_class'] = 'response_confirmation alert alert-success';
					}
				}
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		echo json_encode($arr_output);
	}


	function get_foto($id = null)
	{
		$sql = "SELECT * FROM (
			SELECT
				internal_filename,
				stereotype
			FROM
				dbo.files f
						where f.owner_id='$id'
		) t
		PIVOT(
			max(internal_filename)
			FOR stereotype IN (
				[F-DINDING],
				[F-JAMBAN],
				[F-KK],
				[F-KRT],
				[F-KTP],
				[F-LANTAI],
				[F-ATAP],
				[F-DAPUR],
				[F-RUMAH])
		) AS pivot_table";
		return data_query($sql);
	}

	function move_rt($id = null, $kd_propinsi)
	{
		$get_foto = $this->get_foto($id)->result_array();
		$get_foto_cek = $this->get_foto($id)->num_rows();
		if ($get_foto_cek == '0') {
			$dinding = '';
			$jamban = '';
			$kk = '';
			$krt = '';
			$ktp = '';
			$lantai = '';
			$atap = '';
			$dapur = '';
			$rumah = '';
		} else {
			foreach ($get_foto as $key => $value) {
				$dinding = $value['F-DINDING'];
				$jamban = $value['F-JAMBAN'];
				$kk = $value['F-KK'];
				$krt = $value['F-KRT'];
				$ktp = $value['F-KTP'];
				$lantai = $value['F-LANTAI'];
				$atap = $value['F-ATAP'];
				$dapur = $value['F-DAPUR'];
				$rumah = $value['F-RUMAH'];
			}
		}
		$params_get = [
			'table' => 'asset.master_data_proses',
			'where' => [
				'proses_id' => $id
			]
		];
		$get_data = get_data($params_get)->result_array();
		foreach ($get_data as $key => $value) {
			$data_rt = [
				'IDBDT' => $value['id_prelist'],
				'NoPBDTKemsos' => $value['no_pbdt_kemsos'],
				'Vector1' => $value['vector1'],
				'Vector2' => $value['vector2'],
				'Vector3' => $value['vector3'],
				'Vector4' => $value['vector4'],
				'KDGabungan4' => $value['kode_gabungan'],
				'KDPROP' => $value['kode_propinsi'],
				'KDKAB' => $value['kode_kabupaten'],
				'KDKEC' => $value['kode_kecamatan'],
				'KDDESA' => $value['kode_desa'],
				'Alamat' => $value['alamat'],
				'AdaPKH' => $value['ada_pkh'],
				'AdaPBDT' => $value['ada_pbdt'],
				'AdaKKS2016' => $value['ada_kks_2016'],
				'AdaKKS2017' => $value['ada_kks_2017'],
				'AdaPBI' => $value['ada_pbi'],
				'AdaDapodik' => $value['ada_dapodik'],
				'NoPesertaPKH' => $value['no_peserta_pkh'],
				'NoPesertaKKS2016' => $value['no_peserta_kks_2016'],
				'NoPesertaPBI' => $value['no_peserta_pbi'],
				'PesertaKIP' => $value['peserta_kip'],
				'Nama_SLS' => $value['nama_sls'],
				'Nama_KRT' => $value['nama_krt'],
				'Jumlah_ART' => $value['jumlah_art'],
				'Jumlah_Keluarga' => $value['jumlah_keluarga'],
				'sta_bangunan' => $value['status_bangunan'],
				'sta_lahan' => $value['status_lahan'],
				'luas_lantai' => $value['luas_lantai'],
				'lantai' => $value['lantai'],
				'dinding' => $value['dinding'],
				'kondisi_dinding' => $value['kondisi_dinding'],
				'atap' => $value['atap'],
				'kondisi_atap' => $value['kondisi_atap'],
				'jumlah_kamar' => $value['jumlah_kamar'],
				'sumber_airminum' => $value['sumber_airminum'],
				'nomor_meter_air' => $value['nomor_meter_air'],
				'cara_peroleh_airminum' => $value['cara_peroleh_airminum'],
				'sumber_penerangan' => $value['sumber_penerangan'],
				'daya' => $value['daya'],
				'nomor_pln' => $value['nomor_pln'],
				'bb_masak' => $value['bb_masak'],
				'nomor_gas' => $value['nomor_gas'],
				'fasbab' => $value['fasbab'],
				'kloset' => $value['kloset'],
				'buang_tinja' => $value['buang_tinja'],
				'ada_tabung_gas' => $value['ada_tabung_gas'],
				'ada_lemari_es' => $value['ada_lemari_es'],
				'ada_ac' => $value['ada_ac'],
				'ada_pemanas' => $value['ada_pemanas'],
				'ada_telepon' => $value['ada_telepon'],
				'ada_tv' => $value['ada_tv'],
				'ada_emas' => $value['ada_emas'],
				'ada_laptop' => $value['ada_laptop'],
				'ada_sepeda' => $value['ada_sepeda'],
				'ada_motor' => $value['ada_motor'],
				'ada_mobil' => $value['ada_mobil'],
				'ada_perahu' => $value['ada_perahu'],
				'ada_motor_tempel' => $value['ada_motor_tempel'],
				'ada_perahu_motor' => $value['ada_perahu_motor'],
				'ada_kapal' => $value['ada_kapal'],
				'aset_tak_bergerak' => $value['aset_tak_bergerak'],
				'luas_atb' => $value['luas_atb'],
				'rumah_lain' => $value['rumah_lain'],
				'jumlah_sapi' => $value['jumlah_sapi'],
				'jumlah_kerbau' => $value['jumlah_kerbau'],
				'jumlah_kuda' => $value['jumlah_kuda'],
				'jumlah_babi' => $value['jumlah_babi'],
				'jumlah_kambing' => $value['jumlah_kambing'],
				'sta_art_usaha' => $value['status_art_usaha'],
				'sta_kks' => $value['status_kks'],
				'sta_kip' => $value['status_kip'],
				'sta_kis' => $value['status_kis'],
				'sta_bpjs_mandiri' => $value['status_bpjs_mandiri'],
				'sta_jamsostek' => $value['status_jamsostek'],
				'sta_asuransi' => $value['status_asuransi'],
				'sta_pkh' => $value['status_pkh'],
				'sta_rastra' => $value['status_rastra'],
				'sta_kur' => $value['status_kur'],
				'sta_keberadaan_RT' => $value['status_keberadaan_rt'],
				'percentile' => $value['percentile'],
				'InitData' => $value['init_data'],
				'LastUpdateData' => $value['last_update_data'],
				'foto_rumah' => $rumah,
				'foto_ktp' => $ktp,
				'foto_kk' => $kk,
				'foto_kk1' => $value['foto_kk1'],
				'foto_kk2' => $value['foto_kk2'],
				'foto_kk3' => $value['foto_kk3'],
				'foto_kk4' => $value['foto_kk4'],
				'foto_kk5' => $value['foto_kk5'],
				'foto_kk6' => $value['foto_kk6'],
				'lat' => $value['lat'],
				'long' => $value['long'],
				'status_kesejahteraan' => $value['status_rumahtangga'],
				'foto_dinding' => $dinding,
				'foto_lantai' => $lantai,
				'foto_jamban' => $jamban,
				'foto_dapur' => $dapur,
				'foto_atap' => $atap,
				'foto_krt' => $krt,
				'nourut_rt' => $value['nomor_urut_rt'],
				'IDREPL' => $value['proses_id'],
			];
			$this->stagging_model->insertData('dbo.UDRT_' . $kd_propinsi, $data_rt);
		}
	}

	function move_detail_art($id = null, $kd_propinsi)
	{
		$params_get = [
			'table' => 'asset.master_data_detail_proses',
			'where' => [
				'proses_id' => $id
			]
		];
		$get_data = get_data($params_get)->result_array();
		foreach ($get_data as $key => $value) {
			$data_art = [
				'IDBDT' => $value['id_prelist'],
				'IDARTBDT' => $value['id_art_prelist'],
				'NoPesertaPBDT' => $value['no_art_pbdt'],
				'NoPesertaPBDTART' => $value['no_art_pbdt'],
				'NoPBDTKemsos' => $value['no_pbdt_kemsos'],
				'NoArtPBDTKemsos' => $value['no_art_pbdt_kemsos'],
				'Vector1' => $value['vector1'],
				'Vector2' => $value['vector2'],
				'Vector3' => $value['vector3'],
				'Vector4' => $value['vector4'],
				'KDGabungan4' => $value['kode_gabungan'],
				'KDPROP' => $value['kode_propinsi'],
				'KDKAB' => $value['kode_kabupaten'],
				'KDKEC' => $value['kode_kecamatan'],
				'KDDESA' => $value['kode_desa'],
				'NoPesertaPKH' => $value['no_peserta_pkh'],
				'NoPesertaKKS2016' => $value['no_peserta_kks_2016'],
				'NoPesertaPBI_org' => $value['no_peserta_pbi'],
				'NoArtPKH' => $value['no_art_pkh'],
				'NoArtPBDT' => $value['no_art_pbdt'],
				'NoArtKKS2016' => $value['no_art_kks_2016'],
				'NoArtPBI_org' => $value['no_art_pbi'],
				'Nama' => $value['nama'],
				'JnsKel' => $value['jenis_kelamin'],
				'TmpLahir' => $value['tempat_lahir'],
				'TglLahir' => $value['tanggal_lahir'],
				'HubKRT' => $value['hubungan_krt'],
				'NIK' => $value['nik'],
				'NoKK' => $value['no_kk'],
				'Hub_KRT' => $value['hubungan_krt'],
				'NUK' => $value['nuk'],
				'Hubkel' => $value['hubungan_keluarga'],
				'Umur' => $value['umur'],
				'Sta_kawin' => $value['status_kawin'],
				'Ada_akta_nikah' => $value['ada_akta_nikah'],
				'Ada_diKK' => $value['ada_di_kk'],
				'Ada_kartu_identitas' => $value['ada_kartu_identitas'],
				'Sta_hamil' => $value['status_hamil'],
				'Jenis_cacat' => $value['jenis_cacat'],
				'Penyakit_kronis' => $value['penyakit_kronis'],
				'Partisipasi_sekolah' => $value['partisipasi_sekolah'],
				'Pendidikan_tertinggi' => $value['pendidikan_tertinggi'],
				'Kelas_tertinggi' => $value['kelas_tertinggi'],
				'Ijazah_tertinggi' => $value['ijazah_tertinggi'],
				'Sta_Bekerja' => $value['status_bekerja'],
				'Jumlah_jamkerja' => $value['jumlah_jam_kerja'],
				'Lapangan_usaha' => $value['lapangan_usaha'],
				'Status_pekerjaan' => $value['status_pekerjaan'],
				'Sta_keberadaan_art' => $value['status_keberadaan_art'],
				'Sta_kepesertaan_pbi' => $value['status_kepesertaan_pbi'],
				'Ada_kks' => $value['ada_kks'],
				'Ada_pbi' => $value['ada_pbi'],
				'Ada_kip' => $value['ada_kip'],
				'Ada_pkh' => $value['ada_pkh'],
				'Ada_rastra' => $value['ada_rastra'],
				'Anak_diluar_rt' => $value['anak_diluar_rt'],
				'namagadis_ibukandung' => $value['nama_gadis_ibu_kandung'],
				'sta_keberadaan_kks' => $value['status_keberadaan_kks'],
				'InitData' => $value['init_data'],
				'LastUpdateData' => $value['last_update_data'],
			];
			$this->stagging_model->insertData('dbo.UDART_' . $kd_propinsi, $data_art);
		}
	}

	function move_foto($id = null, $kd_propinsi)
	{
		$sql = "SELECT f.*, md.id_prelist FROM dbo.files f left join asset.master_data_proses md on f.owner_id=md.proses_id where f.owner_id='$id'";
		$get_data = data_query($sql)->result_array();
		foreach ($get_data as $key => $value) {
			$data_foto = [
				'file_id' => $value['file_id'],
				'IDBDT' => $value['id_prelist'],
				'file_name' => $value['file_name'],
				'file_size' => $value['file_size'],
				'file_type' => $value['file_type'],
				'internal_filename' => $value['internal_filename'],
				'description' => $value['description'],
				'download_count' => $value['download_count'],
				'view_count' => $value['view_count'],
				'revision' => $value['revision'],
				'status' => $value['status'],
				'latitude' => $value['latitude'],
				'longitude' => $value['longitude'],
				'ip_user' => $value['ip_user'],
				'stereotype' => $value['stereotype'],
				'sort_order' => $value['sort_order'],
				'row_status' => $value['row_status'],
				'created_by' => $value['created_by'],
				'created_on' => $value['created_on'],
				'lastupdate_by' => $value['lastupdate_by'],
				'lastupdate_on' => $value['lastupdate_on'],
			];
			$this->stagging_model->insertData('dbo.FOTO_' . $kd_propinsi, $data_foto);
		}
	}

	function form_cari()
	{
		$user_location = $this->get_user_location();
		$jml_negara = count(explode(',', $user_location['country_id']));
		$jml_propinsi = count(explode(',', $user_location['province_id']));
		$jml_kota = count(explode(',', $user_location['regency_id']));
		$jml_kecamatan = count(explode(',', $user_location['district_id']));
		$jml_kelurahan = count(explode(',', $user_location['village_id']));

		$option_propinsi = '<option value="0">Pilih Provinsi</option>';
		$option_kelurahan = '<option value="0">Pilih Kelurahan</option>';
		$option_kota = '<option value="0">Pilih Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Pilih Kecamatan</option>';
		$option_kelurahan = '<option value="0">Pilih Kelurahan</option>';

		$where_propinsi = [];

		if (!empty($user_location['province_id'])) {
			if ($jml_propinsi > '0') $where_propinsi['province_id ' . (($jml_propinsi >= '2') ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}")] = null;
		}

		$params_propinsi = [
			'table' => 'asset.vw_administration_regions',
			'select' => 'DISTINCT province_id, propinsi',
			'where' => $where_propinsi,
			'order_by' => 'propinsi',
		];
		$query_propinsi = get_data($params_propinsi);
		foreach ($query_propinsi->result() as $key => $value) {
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
					<select id="select-sync" name="syncron" class="js-example-basic-single form-control">
						<option value="0">Pilih Status Syncron </option>
						<option value="1">Belum Syncron</option>
						<option value="2">Syncron</option>
					</select>
				</div>
				<div class="form-group col-md-2">
					<button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Refresh</button>
				</div>
			</div>
		';
		return $form_cari;
	}

	function get_user_location()
	{
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '';
		$province_id = '';
		$regency_id = '';
		$district_id = '';
		$village_id = '';
		if (!empty($user_location)) {
			$count = count($user_location);
			$no = 1;
			foreach ($user_location as $loc) {
				$params_location = [
					'table' => 'dbo.ref_locations',
					'where' => [
						'location_id' => $loc
					]
				];
				$query = get_data($params_location);
				$country_id = $query->row('country_id') . (($no < $count) ? ',' : '');
				$province_id = $province_id . '' . $query->row('province_id') . ((!empty($query->row('province_id')) && $no < $count) ? ',' : '');
				$regency_id = $regency_id . '' . $query->row('regency_id') . ((!empty($query->row('regency_id')) && $no < $count) ? ',' : '');
				$district_id = $district_id . '' . $query->row('district_id') . ((!empty($query->row('district_id')) && $no < $count) ? ',' : '');
				$village_id = $village_id . '' . $query->row('village_id') . ((!empty($query->row('village_id')) && $no < $count) ? ',' : '');
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
		return ($res_loc);
	}

	function merge_location($location_id)
	{
		$tes = explode(',', $location_id);
		sort($tes);
		$str = implode(',', array_unique($tes));
		$str = ltrim($str, ',');
		return $str;
	}

	function get_show_location()
	{
		$user_location = $this->get_user_location();
		$regency_id = $user_location['regency_id'];
		$district_id = $user_location['district_id'];
		$village_id = $user_location['village_id'];
		$id_location = $_GET['location_id'];
		//die;
		$level = $_GET['level'];
		if ($level == 3) {
			$parent_id = 'province_id';
			$parent = "province_id=$id_location";
			if (in_array('root', $this->user_info['user_group']) ? FALSE : TRUE) {
				if (empty($regency_id)) {
					$child_id = "1=1";
				} else {
					$child = "regency_id in ($regency_id)";
					if ($this->cek_location($parent, $child) > 0)
						$child_id = "regency_id in ($regency_id)";
					else
						$child_id = "regency_id not in ($regency_id)";
				}
			} else {
				$child_id = "1=1";
			}
		} elseif ($level == 4) {
			$parent_id = 'regency_id';
			$parent = "regency_id=$id_location";
			if (in_array('root', $this->user_info['user_group']) ? FALSE : TRUE) {
				if (empty($district_id)) {
					$child_id = "1=1";
				} else {
					$child = "district_id in ($district_id)";
					if ($this->cek_location($parent, $child) > 0)
						$child_id = "district_id in ($district_id)";
					else
						$child_id = "district_id not in ($district_id)";
				}
			} else {
				$child_id = "1=1";
			}
		}
		if ($level == 5) {
			$parent_id = 'district_id';
			$parent = "district_id=$id_location";
			if (in_array('root', $this->user_info['user_group']) ? FALSE : TRUE) {
				if (empty($village_id)) {
					$child_id = "1=1";
				} else {
					$child = "village_id in ($village_id)";
					if ($this->cek_location($parent, $child) > 0)
						$child_id = "village_id in ($village_id)";
					else
						$child_id = "village_id not in ($village_id)";
				}
			} else {
				$child_id = "1=1";
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
		$query = get_data($params);
		$data = [];
		foreach ($query->result() as $rows) {
			if ($level == 3) {
				$location_id = $rows->regency_id;
				$name = $rows->kabupaten;
			} elseif ($level == 4) {
				$location_id = $rows->district_id;
				$name = $rows->kecamatan;
			}
			if ($level == 5) {
				$location_id = $rows->village_id;
				$name = $rows->kelurahan;
			}
			$data[$location_id] = $name;
		}
		echo json_encode($data);
	}

	function cek_location($parent, $child)
	{
		$params = [
			'table' => 'asset.vw_administration_regions',
			'where' => [
				$parent => null,
				$child => null
			],
			'select' => 'DISTINCT regency_id, district_id, village_id, kabupaten, kecamatan, kelurahan'
		];
		$query = get_data($params);
		return $query->num_rows();
	}

	function get_show_data_user()
	{
		$input = $this->input->post();
		$where = [];
		if (isset($input['params'])) {
			$par = $input['params'];
			$params = json_decode($par, true);
			foreach ($params[0] as $field => $value) {
				if ($value > '0') $where['l.' . $field] = $value;
			}
		}
		$where['cug.user_group_id'] = 3;

		$params = [
			'table' => [
				'dbo.core_user_account cua' => '',
				'dbo.user_group ug' => ['cua.user_account_id = ug.user_group_user_account_id', 'left'],
				'dbo.core_user_profile cup' => ['cua.user_account_id = cup.user_profile_id', 'left'],
				'dbo.core_user_group cug' => ['ug.user_group_group_id = cug.user_group_id', 'left'],
				'dbo.user_location ul' => ['cua.user_account_id = ul.user_location_user_account_id', 'left'],
				'dbo.ref_locations l' => ['ul.user_location_location_id = l.location_id', 'left']
			],
			'select' => 'DISTINCT user_group_title, user_group_group_id, user_profile_nik, user_account_email, user_account_id, user_account_username, user_account_is_active, user_profile_first_name, user_profile_last_name',
			'where' => $where,
			'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
			'offset' => (($input['page'] - 1) * $input['rp']),
			'limit' => $input['rp'],
		];
		$params_count = [
			'table' => [
				'dbo.core_user_account cua' => '',
				'dbo.user_group ug' => ['cua.user_account_id = ug.user_group_user_account_id', 'left'],
				'dbo.core_user_profile cup' => ['cua.user_account_id = cup.user_profile_id', 'left'],
				'dbo.core_user_group cug' => ['ug.user_group_group_id = cug.user_group_id', 'left'],
				'dbo.user_location ul' => ['cua.user_account_id = ul.user_location_user_account_id', 'left'],
				'dbo.ref_locations l' => ['ul.user_location_location_id = l.location_id', 'left']
			],
			'select' => 'count(DISTINCT user_account_id) jumlah',
			'where' => $where,
		];
		$user_location = $this->user_info['user_location'];
		$in_location = '';
		if (!in_array('100000', $user_location)) {
			$params['where'] = [
				'user_account_create_by' => $this->user_info['user_id'],
			];
			$params_count['where'] = [
				'user_account_create_by ' => $this->user_info['user_id'],
			];
		}

		$query = get_data($params);
		$query_count = get_data($params_count);
		header("Content-type: application/json");
		$data = [];
		foreach ($query->result() as $par => $row) {
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
		echo json_encode($result);
	}
}
