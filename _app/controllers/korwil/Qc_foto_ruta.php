<?php
defined('BASEPATH') or exit('No direct script access allowed');
// show status 14
class Qc_foto_ruta extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->dir = base_url('korwil/qc_foto_ruta/');
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
		$data['is_superuser'] = (in_array('root', $this->user_info['user_group']) ? TRUE : FALSE);
		$data['cari'] = $this->form_cari();
		$data['paste_url'] = $this->dir;
		$data['grid'] = [
			'col_id' => 'proses_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'status', display:'Status', width:50, sortable:false, align:'center', datasuorce: false},
				{ name:'status_code', display:'Kode Status', width:50, sortable:true, align:'center', datasuorce: false, hide: true},
				{ name:'jenis', display:'Jenis', width:50, sortable:false, align:'center', datasuorce: false},
				{ name:'detail', display:'Detail', width:50, sortable:true, align:'left', datasuorce: false},
				{ name:'id_prelist', display:'Id Prelist', width:170, sortable:true, align:'left', datasuorce: false},
				{ name:'informasi_data', display:'Informasi Data', width:220, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_ktp', display:'Foto KTP', width:120, sortable:false, align:'center', datasuorce: false},
				{ name:'foto_kk', display:'Foto KK', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_responden', display:'Foto Responden', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_rumah', display:'Foto Rumah',  width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_atap', display:'Foto Atap', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_lantai', display:'Foto Lantai', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_dinding', display:'Foto Dinding', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_dapur', display:'Foto Dapur', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_kloset', display:'Foto Kloset', width:120, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Approve', name:'approve', bclass:'publish', onpress:act_approve13, hidden: true, urlaction: '" . $this->dir . "act_show' },
				{ separator: true },
				{ display:'Reject ke Status 13a', name:'reject13a', bclass:'reject13a', onpress:act_reject, hidden: true, urlaction: '" . $this->dir . "act_show' },
				{ separator: true },
				{ display:'Move ke Status 13b', name:'reject13b', bclass:'reject13b', onpress:act_reject, hidden: true, urlaction: '" . $this->dir . "act_show' },
				{ separator: true },
				{ display:'Copy Id Prelist', name:'copy', bclass:'copy', onpress:copy_id, urlaction: '" . $this->dir . "copy_id'},
				{ separator: true },
				{ display:'Paste Id Prelist', name:'paste', bclass:'paste', onpress:paste_id, urlaction: '" . $this->dir . "paste_id'},
				{ separator: true },
			",
			'filters' => "
				{ display:'ID Prelist', name:'id_prelist', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Quality Control Foto Rumah Tangga';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$data['grid']['table_title'] = 'Daftar Data Pre-List SIKS-NG';
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
						var status = $( "#select-status ").val();
						if(status=="VERIVALI-KORKAB-APPROVED")
						{
							$(".publish").show();
							$(".publish").parent().parent().nextAll(".btnseparator").show();
							$(".reject13a").show();
							$(".reject13a").parent().parent().nextAll(".btnseparator").show();
							$(".reject13b").show();
						}
						else if(status=="VERIVALI-KORWIL-REJECTED")
						{
							$(".publish").show();
							$(".publish").parent().parent().nextAll(".btnseparator").hide();
							$(".reject13a").hide();
							$(".reject13a").parent().parent().nextAll(".btnseparator").show();
							$(".reject13b").show();
						}
						else if(status=="VERIVALI-PENDING-QC-PUSAT")
						{
							$(".publish").show();
							$(".publish").parent().parent().nextAll(".btnseparator").show();
							$(".reject13a").show();
							$(".reject13a").parent().parent().nextAll(".btnseparator").hide();
							$(".reject13b").hide();
						}
						else
						{
							$(".publish").hide();
							$(".publish").parent().parent().nextAll(".btnseparator").hide();
							$(".reject13a").hide();
							$(".reject13a").parent().parent().nextAll(".btnseparator").hide();
							$(".reject13b").hide();
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
									"row_status": $( "#select-jenis ").val(),
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

				$(".bDiv").ready( function(){
					$(".publish").parent().parent().nextAll(".btnseparator").hide();
				});


			</script>
		';
		$this->template->breadcrumb($this->breadcrumb);

		$this->template->title($data['grid']['title']);
		$this->template->content("general/Table_grid_view_qc_foto", $data);
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
				} else if ($field == 'stereotype' || $field == 'row_status') {
					if ($value > '0') $where['md.' . $field] = $value;
					else $where["md.stereotype IN ('VERIVALI-SUBMITTED',
								'VERIVALI-SUPERVISOR-APPROVED',
								'VERIVALI-KORKAB-REJECTED',
								'VERIVALI-KORKAB-APPROVED',
								'VERIVALI-KORWIL-REJECTED',
								'VERIVALI-PENDING-QC-PUSAT',
								'VERIVALI-FINAL') "] = null;
				} else {
					if ($value > '0') $where['l.' . $field] = $value;
				}
			}
			if ((in_array('root', $this->user_info['user_group']) ? FALSE :  TRUE)) {
				$where['l.location_id' . " IN ({$location_user['village_codes']})"]  = null;
			}
		} else {
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
			$where["md.stereotype IN ('VERIVALI-SUBMITTED',
								'VERIVALI-SUPERVISOR-APPROVED',
								'VERIVALI-KORKAB-REJECTED',
								'VERIVALI-KORKAB-APPROVED',
								'VERIVALI-KORWIL-REJECTED',
								'VERIVALI-PENDING-QC-PUSAT',
								'VERIVALI-FINAL') "] = null;
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
			$sql_where .= $key . " LIKE '%" . $value . "%' AND ";
		}

		foreach ($where as $key => $value) {
			if ($value == '') {
				$sql_where .= $key . ' AND ';
			} else if ($key == 'md.stereotype' || $key == 'md.row_status') {
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
				md.*,
				l.province_name,
				l.regency_name,
				l.district_name,
				l.village_name,
				r.icon,
				r.code
			FROM asset.vw_all_data md
			LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
			LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
    		WHERE $sql_where 1=1 $sql_where_in
    		ORDER BY md.lastupdate_on " . $input['sortorder'] . " OFFSET " . (($input['page'] - 1) * $input['rp']) . " ROWS FETCH NEXT " . $input['rp'] . " ROWS ONLY
		";

		$sql_count = "
            SELECT COUNT
                ( id_prelist ) jumlah
			FROM asset.vw_all_data md
			LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
			LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
            WHERE $sql_where 1=1 $sql_where_in
		";
		$query = data_query($sql_query);
		$query_count = data_query($sql_count);

		// $params = [
		// 	'table' => [
		// 		'asset.vw_all_dataA md' => '',
		// 		'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left'],
		// 		'dbo.ref_references r' => ['r.short_label = md.stereotype', 'left']
		// 	],
		// 	'select' => '
		// 		md.*,
		// 		l.province_name,
		// 		l.regency_name,
		// 		l.district_name,
		// 		l.village_name,
		// 		r.icon,
		// 		r.code',
		// 	'order_by' => 'md.lastupdate_on ' . $input['sortorder'],
		// 	'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
		// 	'limit' => $input['rp'],
		// 	'where' => $where,
		// ];
		// $params_count = [
		// 	'table' => [
		// 		'asset.vw_all_data md' => '',
		// 		'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left']
		// 	],
		// 	'select' => 'count(id_prelist) jumlah',
		// 	'where' => $where,
		// ];
		// if ( ! empty( $input['querys'] ) ) {
		// 	$filterRules = filter_json( $input['querys'] );
		// 	$params = array_merge( $params, $filterRules );
		// 	$params_count = array_merge( $params_count, $filterRules );
		// }
		// $query = get_data( $params );
		// $query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ($query->result() as $par => $row) {
			if ($row->status_rumahtangga == '1')
				$status_rumahtangga = 'Ditemukan';
			elseif ($row->status_rumahtangga == '2')
				$status_rumahtangga = 'Tidak Ditemukan';
			elseif ($row->status_rumahtangga == '3')
				$status_rumahtangga = 'Data Ganda';
			elseif ($row->status_rumahtangga == '4')
				$status_rumahtangga = 'Usulan Baru';
			else
				$status_rumahtangga = '';

			if ($row->jenis_kelamin_krt == '1')
				$jenis_kelamin_krt = 'Laki-laki';
			elseif ($row->jenis_kelamin_krt == '2')
				$jenis_kelamin_krt = 'Perempuan';
			else
				$jenis_kelamin_krt = '';

			if ($row->hasil_verivali == '1')
				$hasil_verivali = 'Selesai Dicacah';
			elseif ($row->hasil_verivali == '2')
				$hasil_verivali = 'Rumah tangga tidak ditemukan';
			elseif ($row->hasil_verivali == '3')
				$hasil_verivali = 'Rumah tangga pindah/bangunan sudah tidak ada';
			elseif ($row->hasil_verivali == '4')
				$hasil_verivali = 'Bagian dari rumah tangga di dokumen';
			elseif ($row->hasil_verivali == '5')
				$hasil_verivali = 'Responden Menolak';
			elseif ($row->hasil_verivali == '6')
				$hasil_verivali = 'Data Ganda';
			else
				$hasil_verivali = '';

			if ($row->jenis_kelamin_krt == '1')
				$jenis_kelamin_krt = 'Laki-laki';
			elseif ($row->jenis_kelamin_krt == '2')
				$jenis_kelamin_krt = 'Perempuan';
			else
				$jenis_kelamin_krt = '';


			if ($row->apakah_mampu == '1')
				$apakah_mampu = 'Ya';
			elseif ($row->apakah_mampu == '2')
				$apakah_mampu = 'Tidak';
			else
				$apakah_mampu = '';
			if ($row->row_status == 'COPY')
				$jenis = '<img src="' . base_url('assets/style/package-blue.png') . '" title="Prelist Awal" alt="Prelist Awal">';
			else
				$jenis = '<img src="' . base_url('assets/style/package-green.png') . '" title="Usulan Baru" alt="Usulan Baru">';

			$url = ' http://66.96.235.136:8080/apiverval/asset/';
			$path_foto = base_url('assets/style/icon-status');
			$status = '<img src="' . $path_foto . '/' . $row->icon . '">';
			$foto_ktp = '<a href="' . $url . $row->f_ktp . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url . $row->f_ktp . '" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_kk = '<a href="' . $url .$row->f_kk . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url .$row->f_kk . '" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_responden = '<a href="' . $url .$row->f_krt . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url .$row->f_krt . '" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_rumah = '<a href="' . $url .$row->f_rumah . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url .$row->f_rumah . '" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_atap = '<a href="' . $url .$row->f_atap . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url .$row->f_atap . '" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_lantai = '<a href="' . $url .$row->f_lantai . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url .$row->f_lantai . '" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_dinding = '<a href="' . $url .$row->f_dinding . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url .$row->f_dinding . '" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_dapur = '<a href="' . $url .$row->f_dapur . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url .$row->f_dapur . '" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_kloset = '<a href="' . $url .$row->f_jamban . '" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="' . $url .$row->f_jamban . '" class="img-fluid m-b-10" alt="">
						</a>';
			$informasi_data = '
				<span>
					Kecamatan: ' . $row->district_name . '</br>
					Kelurahan: ' . $row->village_name . '</br>
					Nama KRT: ' . $row->nama_krt . '</br>
					Kelamin KRT: ' . (($row->jenis_kelamin_krt == "1") ? "1 = Laki-Laki" : "2 = Perempuan") . '</br>
					NIK KRT: ' . $row->nomor_nik . '</br>
					No. KK KRT: ' . $row->nomor_kk_krt . ' </br>
					</br>
					Hasil Musdes: ' . $status_rumahtangga . ' </br>
					Keluarga Mampu:  ' . $apakah_mampu . ' </br>
					Hasil Verivali: ' . $hasil_verivali . '</br>
					</br>
					Jumlah No KK: ' . $row->jml_no_kk . ' </br>
					Jumlah ART: ' . $row->jml_art . ' </br>
					Jumlah NIK: ' . $row->jml_nik . ' </br>
					Jumlah Keberadaan ART: ' . $row->jml_keberadaan_art . ' </br>
					Total Foto: ' . $row->jml_foto . ' </br>
					Jumlah Anak Dalam Tanggungan: ' . $row->jml_anak_dlm_tanggungan . ' </br>
					Jumlah Usaha ART: ' . $row->jml_usaha_art . ' </br>
					</br>
					Jumlah ART Status KRT: ' . $row->jml_kepala_rumah_tangga . ' </br>
					Jumlah ART Status KK: ' . $row->jml_kepala_keluarga . ' </br>
					Jumlah ART Status Istri: ' . $row->jml_art_istri . ' </br>
					Jumlah ART Status Anak: ' . $row->jml_art_anak . ' </br>
					Jumlah Nama Ibu Kandung: ' . $row->jml_nama_ibu_kandung . ' </br>
					</br>
					Peserta KKS/KPS: ' . $row->jml_kks . ' </br>
					Peserta KIS/PBI JKN: ' . $row->jml_pbi . ' </br>
					Peserta KIP/BSM: ' . $row->jml_kip . ' </br>
					Peserta PKH: ' . $row->jml_pkh . ' </br>
					Peserta Raskin/Rastra: ' . $row->jml_rastra . ' </br>
					</br>
					Ruta Peserta KKS/KPS: ' . $row->status_kks . '</br>
					Ruta Peserta KIP/BSM: ' . $row->status_kip . ' </br>
					Ruta Peserta KIS/PBI JKN:  ' . $row->status_kis . '</br>
					Ruta Peserta BPJS Mandiri:  ' . $row->status_bpjs_mandiri . '</br>
					Ruta Peserta Jamsostek: ' . $row->status_jamsostek . '</br>
					Ruta Peserta Asuransi: ' . $row->status_asuransi . '</br>
					Ruta Peserta PKH: ' . $row->status_pkh . '</br>
					Ruta Peserta Raskin/Rastra: ' . $row->status_rastra . '</br>
					Ruta Peserta KUR: ' . $row->status_kur . '</br>
					</br>
					Durasi Interview:  ' . $row->interview_duration . '
				</span>';
			$detail = '<button class="btn btn-sm btn-edit btn-danger" act="' . base_url("verivali/detail_data/get_form_detail/" . enc(['proses_id' => $row->proses_id, 'stereotype' => $row->stereotype])) . '"><i class="fa fa-list"></i></button>';

			$row_data = [
				'id' => $row->proses_id,
				'cell' => [
					'status' => $status,
					'status_code' => $row->code,
					'jenis' => $jenis,
					'id_prelist' => $row->id_prelist,
					'informasi_data' => $informasi_data,
					'foto_ktp' => $foto_ktp,
					'foto_kk' => $foto_kk,
					'foto_responden' => $foto_responden,
					'foto_rumah' => $foto_rumah,
					'foto_atap' => $foto_atap,
					'foto_lantai' => $foto_lantai,
					'foto_dinding' => $foto_dinding,
					'foto_dapur' => $foto_dapur,
					'foto_kloset' => $foto_kloset,
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

		// approve
		if (isset($in['approve']) && $in['approve']) {
			$arr_id = json_decode($in['item']);
			
			if (is_array($arr_id)) {
				$success = 0;
				$datetime = date("Y-m-d H:i:s");
				foreach ($arr_id as $id) {
					$params_get_audit_trail = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'audit_trails'
					];
					$user_ip = client_ip();
					$audit_trails = json_decode(get_data($params_get_audit_trail)->row('audit_trails'), true);
					$audit_trails[] = [
						"ip" => $user_ip['ip_address'],
						"on" => $datetime,
						"act" => "UPDATED",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"asset_id" => $id,
							"stereotype" => 'VERIVALI-FINAL'
						],
						"is_proxy_access" => $user_ip['is_proxy']
					];
					$params_update_master_data = [
						'table' => 'asset.master_data_proses',
						'data' => [
							'stereotype' => 'VERIVALI-FINAL',
							'audit_trails' => json_encode($audit_trails),
							'lastupdate_on' => $datetime,
						],
						'where' => [
							'proses_id' => $id
						],
					];
					save_data($params_update_master_data);
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],

					];
					$get_data = get_data($params_get)->row();
					$params_insert_master_data_log = [
						'data_log_master_data_id' => $get_data->proses_id,
						'data_log_status' => 'sukses',
						'data_log_description' => 'Data proses id ' . $get_data->proses_id . ' diubah status menjadi VERIVALI-FINAL',
						'data_log_stereotype' => $get_data->stereotype,
						'data_log_row_status' => $get_data->row_status,
						'data_log_lastupdate_by' => $this->user_info['user_id'],
						'data_log_lastupdate_on' => date("Y-m-d H:i:s"),
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
				}

				$arr_output['message'] = $success . ' data berhasil approve ke status 14.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		// reject13a
		if (isset($in['reject13a']) && $in['reject13a']) {
			$arr_id = json_decode($in['item']);
			if (is_array($arr_id)) {
				$success = 0;
				$datetime = date("Y-m-d H:i:s");
				foreach ($arr_id as $id) {
					$params_get_audit_trail = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'audit_trails'
					];
					$user_ip = client_ip();
					$audit_trails = json_decode(get_data($params_get_audit_trail)->row('audit_trails'), true);
					$audit_trails[] = [
						"ip" => $user_ip['ip_address'],
						"on" => $datetime,
						"act" => "REJECT",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"asset_id" => $id,
							"stereotype" => 'VERIVALI-KORWIL-REJECTED',
							"approval_note" => $in['note']
						],
						"is_proxy_access" => $user_ip['is_proxy']
					];
					$params_update_master_data = [
						'table' => 'asset.master_data_proses',
						'data' => [
							'stereotype' => 'VERIVALI-KORWIL-REJECTED',
							'audit_trails' => json_encode($audit_trails),
							"approval_note" => $in['note'],
							'lastupdate_on' => $datetime,
						],
						'where' => [
							'proses_id' => $id
						],
					];
					save_data($params_update_master_data);
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'proses_id, stereotype, row_status'
					];
					$get_data = get_data($params_get)->row();
					$params_insert_master_data_log = [
						'data_log_master_data_id' => $get_data->proses_id,
						'data_log_status' => 'sukses',
						'data_log_description' => 'Data proses id ' . $get_data->proses_id . ' diubah status menjadi VERIVALI-KORWIL-REJECTED',
						'data_log_stereotype' => $get_data->stereotype,
						'data_log_row_status' => $get_data->row_status,
						'data_log_lastupdate_by' => $this->user_info['user_id'],
						'data_log_lastupdate_on' => date("Y-m-d H:i:s"),
					];
					save_data('asset.master_data_log', $params_insert_master_data_log);

					$success++;
				}

				$arr_output['message'] = $success . ' data berhasil reject ke status 13a.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		// reject13b
		if (isset($in['reject13b']) && $in['reject13b']) {
			$arr_id = json_decode($in['item']);
			if (is_array($arr_id)) {
				$success = 0;
				$datetime = date("Y-m-d H:i:s");
				foreach ($arr_id as $id) {
					$params_get_audit_trail = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'audit_trails'
					];
					$user_ip = client_ip();
					$audit_trails = json_decode(get_data($params_get_audit_trail)->row('audit_trails'), true);
					$audit_trails[] = [
						"ip" => $user_ip['ip_address'],
						"on" => $datetime,
						"act" => "REJECT",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"asset_id" => $id,
							"stereotype" => 'VERIVALI-PENDING-QC-PUSAT',
							"approval_note" => $in['note']
						],
						"is_proxy_access" => $user_ip['is_proxy']
					];
					$params_update_master_data = [
						'table' => 'asset.master_data_proses',
						'data' => [
							'stereotype' => 'VERIVALI-PENDING-QC-PUSAT',
							'audit_trails' => json_encode($audit_trails),
							'lastupdate_on' => $datetime,
							"approval_note" => $in['note']
						],
						'where' => [
							'proses_id' => $id
						],
					];
					save_data($params_update_master_data);
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'proses_id, stereotype, row_status'
					];
					$get_data = get_data($params_get)->row();
					$params_insert_master_data_log = [
						'data_log_master_data_id' => $get_data->proses_id,
						'data_log_status' => 'sukses',
						'data_log_description' => 'Data proses id ' . $get_data->proses_id . ' diubah status menjadi VERIVALI-PENDING-QC-PUSAT',
						'data_log_stereotype' => $get_data->stereotype,
						'data_log_row_status' => $get_data->row_status,
						'data_log_lastupdate_by' => $this->user_info['user_id'],
						'data_log_lastupdate_on' => date("Y-m-d H:i:s"),
					];
					save_data('asset.master_data_log', $params_insert_master_data_log);

					$success++;
				}

				$arr_output['message'] = $success . ' data berhasil reject ke status 13b.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
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
						<option value="VERIVALI-SUBMITTED">11. SELESAI VERIVALI Rumah Tangga</option>
						<option value="VERIVALI-SUPERVISOR-APPROVED">12. Data APPROVED PENGAWAS</option>
						<option value="VERIVALI-KORKAB-REJECTED">12a. Data REJECTED KORKAB</option>
						<option value="VERIVALI-KORKAB-APPROVED">13. Data APPROVED KORKAB</option>
						<option value="VERIVALI-KORWIL-REJECTED">13a.Data REJECTED QC Pusat</option>
						<option value="VERIVALI-PENDING-QC-PUSAT">13b. Proses QC Pusat</option>
						<option value="VERIVALI-FINAL">14. Data APPROVED KORWIL</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-jenis" name="jenis" class="js-example-basic-single form-control">
						<option value="">Semua Jenis</option>
						<option value="COPY">Prelist Awal</option>
						<option value="NEW">Usulan Baru</option>
					</select>
				</div>
				<div class="form-group col-md-3">
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
}
