<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msign extends Backend_Controller {
    public function __construct() {
        parent::__construct();
        $this->dir = base_url( 'korwil/msign/' );
        $this->load->model('auth_model');
        $this->load->library('pdf');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data = array();
        $data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
        $data['cari'] = $this->form_cari();
        $data['paste_url'] = $this->dir;
        $data['url_ajax'] = $this->dir . 'get_show_data';

        $data['grid'] = [
			'col_id' => 'file_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'file', display:'File', width:100, sortable:false, align:'center', datasuorce: false},
				{ name:'provinsi', display:'Provinsi', width:120, sortable:false, align:'left', datasuorce: false},
				{ name:'kabupaten', display:'Kabupaten', width:150, sortable:false, align:'left', datasuorce: false},
				{ name:'file_name', display:'File', width:250, sortable:false, align:'left', datasuorce: false},
				{ name:'status', display:'Status', width:180, sortable:false, align:'center', datasuorce: false},
			",
			'toolbars' => "
			",
			'filters' => "
				{ display:'Daerah', name:'file_name', type:'text', isdefault: true },
				{ display:'Status', name:'row_status', type:'select', option: 'signed:Signed|unsigned:Unsigned' },
			",
		];
		$data['grid']['title'] = 'Sudah M-Sign';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$this->template->title( $data['grid']['title'] );

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

        $this->template->content( "korwil/msign_view", $data );
        $this->template->show( THEMES_BACKEND . 'index' );
    }

    public function get_show_data() {
        $user_info = $_SESSION['user_info'];
        $input = $this->input->post();

        if (isset($input['type'])) {
            $ids = $this->db->get_where('dbo.ref_locations', ['location_id' => $input['regency']])->row_array();
            $province = $ids['bps_province_code'];
            $regency = $ids['bps_regency_code'];

            $sql = $this->_query_msign($province, $regency);
            $query = $this->db->query($sql)->result_array();

            $generate = [
                'data' => $query,
                'area' => $ids,
                'name_user' => $user_info['user_name'],
                'id_user' => $user_info['user_id'],
            ];

            if ($input['type'] > 0) {
                $signed = $this->db->get_where('dbo.files_msign', ['kode_propinsi' => $province, 'kode_kabupaten' =>$regency ])->row_array();
                if ($signed == '') {
                    $sql_14 = $this->_query_hasil14($province, $regency);
                    $query_14 = $this->db->query($sql_14)->row('total');
                    if ($query_14 > 1) {
                        echo json_encode(4);
                    } else {
                        $pdf = $this->generate_pdf($generate);
                        echo json_encode($pdf);
                    }
                } else {
                    echo json_encode(3);
                }
            } else {
                echo json_encode($query);
            }
        } else {
            $params = json_decode( $input['querys'], true );
            $sql_where = '';
            if (isset($params)) {
                foreach ($params as $v) {
                    if ($v['filter_field'] == "file_name") {
                        $sql_where .= $v['filter_field'] ." LIKE '%" .$v['filter_value']. "%' AND ";
                    } else {
                        $sql_where .= $v['filter_field'] ." = '" .$v['filter_value']. "' AND ";
                    }
                }
            }

            $sql_query = "
                SELECT fm.*, cua.user_account_username FROM dbo.files_msign fm
                LEFT JOIN dbo.core_user_account cua ON fm.created_by = cua.user_account_id
                WHERE $sql_where 1=1
                ORDER BY fm.created_on ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
    		";

            $sql_count = "
    			SELECT count(file_id) jumlah FROM dbo.files_msign fm
                LEFT JOIN dbo.core_user_account cua ON fm.created_by = cua.user_account_id
                WHERE $sql_where 1=1
    		";

            $query = data_query( $sql_query );
    		$query_count = data_query( $sql_count );

            header("Content-type: application/json");
    		$data = [];
    		foreach ( $query->result() as $par => $row ) {
                $lok = explode("-",$row->file_name);
                $provin = str_replace("_", " ", $lok[0]);
                $kabup = str_replace(".pdf","",str_replace("_", " ", $lok[1]));

    			$lastupdate = date("d-m-Y H:i:s",strtotime($row->lastupdate_on));
    			$file = '<a href="'.base_url('korwil/msign/download_file/'.$row->file_id).'" class="btn-edit" ><i class="fa fa-download"></i> Download</a>';
    			$row_data = [
    				'id' => $row->file_id,
    				'cell' => [
    					'file' => $file,
    					'provinsi' => $provin,
    					'kabupaten' =>$kabup,
    					'file_name' => $row->file_name,
    					'status' => ucfirst($row->row_status),
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
    }

    function generate_pdf($data)
    {
        $insert = [
            'kode_propinsi' => $data['area']['bps_province_code'],
            'kode_kabupaten' => $data['area']['bps_regency_code'],
            'file_name' => str_replace(' ', '_', $data['area']['province_name']).'-'.str_replace(' ', '_', $data['area']['regency_name']).'.pdf',
            'internal_filename' => './assets/uploads/msign/'.str_replace(' ', '_', $data['area']['province_name']).'-'.str_replace(' ', '_', $data['area']['regency_name']).'.pdf',
            'row_status' => 'unsigned',
            'created_by' => $data['id_user'],
            'created_on' => date('Y-m-d H:i:s'),
        ];

        $result = $this->db->insert('dbo.files_msign', $insert);

        if ($result) {
            $pdf = new FPDF();
            $pdf->AddPage('P','A4','C');

            $pdf->SetFont('Times','B',12);
            $pdf->Image(FCPATH . '/assets/uploads/images/logos/siks.png',10,10,20,20);
            $pdf->Cell(35);
            $pdf->Cell(30,5,' ',0,1,'L');
            $pdf->Cell(78);
            $pdf->Cell(30,5,'VERIFIKASI DAN VALIDASI',0,1,'L');
            $pdf->Cell(55);
            $pdf->Cell(30,10,'DATA TERPADU KESEJAHTERAAN SOSIAL (DTKS)',0,1,'L');
            $pdf->Cell(190,1,'','B',1,'L');
            $pdf->Cell(190,1,'','B',1,'L');

            $pdf->Cell(190,5,' ',0,1,'C');
            $pdf->Cell(190,5,'BERITA ACARA HASIL VERIFIKASI DAN VALIDASI',0,1,'C');
            $pdf->Cell(190,5,'DATA TERPADU KESEJAHTERAAN SOSIAL',0,1,'C');
            $pdf->Cell(190,5,'TINGKAT KABUPATEN/KOTA',0,1,'C');

            $pdf->Cell(190,5,' ',0,1,'C');
            $pdf->SetFont('Times','',12);
            $pdf->SetFillColor(255, 255, 255);
            $txt = 'Dengan ini menyatakan dan menetapkan hasil kegiatan Verifikasi dan Validasi Data Terpadu Kesejahteraan Sosial di wilayah :';
            $pdf->MultiCell(190, 5, $txt."\n", 0, 'J', 1, 1, '' ,'', true);

            $pdf->Cell(190,5,' ',0,1,'C');

            $pdf->setFont('Times','',11);
            $pdf->Cell(6,5,'Provinsi',0,0,'L');
            $pdf->Cell(6,5,'                                  : '.$data['area']['province_name'],0,0, 'L');
            $pdf->Cell(85);
            $pdf->Cell(10,5,$data['area']['bps_province_code'],1,1, 'C');

            $pdf->Cell(190,3,' ',0,1,'C');

            $pdf->setFont('Times','',11);
            $pdf->Cell(6,5,'Kabupaten/Kota',0,0,'L');
            $pdf->Cell(6,5,'                                  : '.$data['area']['regency_name'],0,0, 'L');
            $pdf->Cell(85);
            $pdf->Cell(10,5,$data['area']['bps_regency_code'],1,1, 'C');

            $pdf->Cell(190,3,' ',0,1,'C');

            $tgl = $this->db->get('asset.periode')->row_array();
            $pdf->setFont('Times','',11);
            $pdf->Cell(6,5,'Periode Pelaksanaan',0,0,'L');
            $pdf->Cell(6,5,'                                  : '.convert_date($tgl['tanggal_mulai']).' s/d '.convert_date($tgl['tanggal_selesai']),0,0, 'L');

            $pdf->Cell(190,5,' ',0,1,'C');
            $pdf->Cell(190,5,' ',0,1,'C');

            $txt = 'Dengan rekapitulasi hasilnya adalah sebagai berikut :';
            $pdf->MultiCell(190, 5, $txt."\n", 0, 'J', 1, 1, '' ,'', true);

            $pdf->Cell(190,5,' ',0,1,'C');
            $pdf->SetFont('Times','B','9');
            $pdf->SetFillColor(211,214,219);
            $pdf->Cell(10,5,' ','LTR',0,'L',true);   // empty cell with left,top, and right borders
            $pdf->Cell(40,5,' ','LTR',0,'L',true);   // empty cell with left,top, and right borders
            $pdf->Cell(140,5,'Status Hasil Verifikasi dan Validasi (Rumah Tangga)',1,0,'C',true);

            $pdf->Ln();

            $pdf->Cell(10,5,' ','LR',0,'C',true);  // cell with left and right borders
            $pdf->Cell(40,5,' ','LR',0,'C',true);  // cell with left and right borders
            $pdf->Cell(20,5,'Selesai','LR',0,'C',true);
            $pdf->Cell(20,5,' ','LR',0,'C',true);
            $pdf->Cell(20,5,'Pindah/','LR',0,'C',true);
            $pdf->Cell(23,5,'Data','LR',0,'C',true);
            $pdf->Cell(19,5,' ','LR',0,'C',true);
            $pdf->Cell(19,5,' ','LR',0,'C',true);
            $pdf->Cell(19,5,'Total','LR',0,'C',true);

            $pdf->Ln();

            $pdf->Cell(10,5,'NO','LR',0,'C',true);   // empty cell with left,bottom, and right borders
            $pdf->Cell(40,5,'Nama Kecamatan','LR',0,'C',true);   // empty cell with left,bottom, and right borders
            $pdf->Cell(20,4,'Diverifikasi','LR',0,'C',true);
            $pdf->Cell(20,4,'Tidak','LR',0,'C',true);
            $pdf->Cell(20,4,'Bangunan','LR',0,'C',true);
            $pdf->Cell(23,4,'Ganda/Bagian','LR',0,'C',true);
            $pdf->Cell(19,4,'Menolak','LR',0,'C',true);
            $pdf->Cell(19,4,'Usulan','LR',0,'C',true);
            $pdf->Cell(19,4,'Rumah','LR',0,'C',true);

            $pdf->Ln();

            $pdf->Cell(10,4,' ','LR',0,'L',true);   // empty cell with left,bottom, and right borders
            $pdf->Cell(40,4,' ','LR',0,'L',true);   // empty cell with left,bottom, and right borders
            $pdf->Cell(20,4,'dan','LR',0,'C',true);
            $pdf->Cell(20,4,'Ditemukan','LR',0,'C',true);
            $pdf->Cell(20,4,'Tidak','LR',0,'C',true);
            $pdf->Cell(23,4,'dari Rumah','LR',0,'C',true);
            $pdf->Cell(19,4,' ','LR',0,'C',true);
            $pdf->Cell(19,4,'Baru','LR',0,'C',true);
            $pdf->Cell(19,4,'Tangga','LR',0,'C',true);

            $pdf->Ln();

            $pdf->Cell(10,5,' ','LB',0,'L',true);   // empty cell with left,bottom, and right borders
            $pdf->Cell(40,5,' ','LB',0,'L',true);   // empty cell with left,bottom, and right borders
            $pdf->Cell(20,5,'Validasi','LRB',0,'C',true);
            $pdf->Cell(20,5,' ','LRB',0,'C',true);
            $pdf->Cell(20,5,'Ada','LRB',0,'C',true);
            $pdf->Cell(23,5,'Tangga','LRB',0,'C',true);
            $pdf->Cell(19,5,' ','LRB',0,'C',true);
            $pdf->Cell(19,5,' ','LRB',0,'C',true);
            $pdf->Cell(19,5,'Valid','LRB',0,'C',true);

            $pdf->Ln();

            $pdf->SetFont('Times','','9');
            $pdf->Cell(10,3.5,'','LBR',0,'L',0);   // empty cell with left,bottom, and right borders
            $pdf->Cell(40,3.5,'','LBR',0,'L',0);   // empty cell with left,bottom, and right borders
            $pdf->Cell(20,3.5,'a','LRB',0,'C',0);
            $pdf->Cell(20,3.5,'b','LRB',0,'C',0);
            $pdf->Cell(20,3.5,'c','LRB',0,'C',0);
            $pdf->Cell(23,3.5,'d','LRB',0,'C',0);
            $pdf->Cell(19,3.5,'e','LRB',0,'C',0);
            $pdf->Cell(19,3.5,'f','LRB',0,'C',0);
            $pdf->Cell(19,3.5,'g = (a + f)','LRB',0,'C',0);

            $no = 1;
            $a = $b = $c = $d = $e = $f = $g = 0;
            foreach ($data['data'] as $key => $value) {
                if ($value['name'] != null) {
                    $pdf->Ln();
                    $pdf->Cell(10,5,$no,'LBR',0,'C',0);   // empty cell with left,bottom, and right borders
                    $pdf->Cell(40,5,$value['name'],'LBR',0,'L',0);   // empty cell with left,bottom, and right borders
                    $pdf->Cell(20,5,number_format($value['a']),'LRB',0,'R',0);
                    $pdf->Cell(20,5,number_format($value['b']),'LRB',0,'R',0);
                    $pdf->Cell(20,5,number_format($value['c']),'LRB',0,'R',0);
                    $pdf->Cell(23,5,number_format($value['d']),'LRB',0,'R',0);
                    $pdf->Cell(19,5,number_format($value['e']),'LRB',0,'R',0);
                    $pdf->Cell(19,5,number_format($value['f']),'LRB',0,'R',0);
                    $pdf->Cell(19,5,number_format($value['a'] + $value['f']),'LRB',0,'R',0);

                    $no++;
                    $a = $a + $value['a'];
                    $b = $b + $value['b'];
                    $c = $c + $value['c'];
                    $d = $d + $value['d'];
                    $e = $e + $value['e'];
                    $f = $f + $value['f'];
                    $g = $g + $value['a'] + $value['f'];
                }
            }

            $pdf->Ln();

            $pdf->SetFont('Times','B','9');
            $pdf->Cell(50,5,'TOTAL','LBR',0,'C',true);   // empty cell with left,bottom, and right borders
            $pdf->Cell(20,5,number_format($a),'LRB',0,'R',0);
            $pdf->Cell(20,5,number_format($b),'LRB',0,'R',0);
            $pdf->Cell(20,5,number_format($c),'LRB',0,'R',0);
            $pdf->Cell(23,5,number_format($d),'LRB',0,'R',0);
            $pdf->Cell(19,5,number_format($e),'LRB',0,'R',0);
            $pdf->Cell(19,5,number_format($f),'LRB',0,'R',0);
            $pdf->Cell(19,5,number_format($g),'LRB',0,'R',0);

            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(190,5,' ',0,1,'C');
            $pdf->Cell(190,5,' ',0,1,'C');
            $pdf->SetFont('Times','','11');

            $txt = 'Demikian Berita Acara ini dibuat untuk digunakan sebagaimana mestinya.';
            $pdf->MultiCell(190, 5, $txt."\n", 0, 'J', 1, 1, '' ,'', 0);

            $pdf->SetFont('Times','','11');
            $pdf->Cell(190,5,' ',0,1,'C');
            $pdf->Cell(190,5,' ',0,1,'C');

            $pdf->Cell(120);
            $pdf->Cell(60,5,'',0,1, 'C'); //ttd

            $pdf->SetFont('Times','B','11');
            $pdf->Cell(190,5,' ',0,1,'C');
            $pdf->Cell(190,5,' ',0,1,'C');

            $pdf->Cell(120);
            $pdf->Cell(60,5,$data['name_user'],0,1, 'C');

            $pdf->Output(FCPATH . '/assets/uploads/msign/'.str_replace(' ', '_', $data['area']['province_name']).'-'.str_replace(' ', '_', $data['area']['regency_name']).'.pdf','F');

            return 1;
        } else {
            return 2;
        }

    }

    function download_file($id)
    {
        $file = $this->db->get_where('dbo.files_msign', ['file_id' => $id])->row('internal_filename');
        force_download($file,NULL);
    }

    private function _query_msign($province, $regency)
    {
        $sql = "
            SELECT
                DISTINCT(rl.district_name) name,
                SUM ( CASE WHEN ( md.hasil_verivali = '1' AND LEN(md.id_prelist) = 23 ) THEN 1 ELSE 0 END ) AS a,
                SUM ( CASE WHEN ( md.status_rumahtangga = '2' ) THEN 1 ELSE 0 END ) AS b,
                SUM ( CASE WHEN ( md.hasil_verivali = '3' ) THEN 1 ELSE 0 END ) AS c,
                SUM ( CASE WHEN ( md.hasil_verivali = '4' ) THEN 1 ELSE 0 END ) AS d,
                SUM ( CASE WHEN ( md.hasil_verivali = '5' ) THEN 1 ELSE 0 END ) AS e,
                SUM ( CASE WHEN ( md.status_rumahtangga = '4' OR LEN(md.id_prelist) < 23 AND md.hasil_verivali = 1 ) THEN 1 ELSE 0 END ) AS f
            FROM dbo.ref_locations rl
            LEFT JOIN asset.master_data_proses md ON md.location_id = rl.location_id
            WHERE rl.bps_province_code = '$province' AND rl.bps_regency_code = '$regency'
            GROUP BY rl.district_name ORDER BY rl.district_name
        ";

        return $sql;
    }

    private function _query_hasil14($province, $regency)
    {
        $sql = "
            SELECT
                COUNT(md.proses_id) total
            FROM dbo.ref_locations rl
            LEFT JOIN asset.master_data_proses md ON md.location_id = rl.location_id
            WHERE rl.bps_province_code = '$province' AND rl.bps_regency_code = '$regency' AND md.stereotype <> 'VERIVALI-FINAL'
        ";

        return $sql;
    }

    function form_cari() {
        $user_location = $this->get_user_location();
        $jml_negara = count( explode( ',', $user_location['country_id'] ) );
        $jml_propinsi = count( explode( ',', $user_location['province_id'] ) );
        $jml_kota = count( explode( ',', $user_location['regency_id'] ) );

        $option_propinsi = '<option value="0">Pilih Provinsi</option>';
        $option_kelurahan = '<option value="0">Pilih Kelurahan</option>';
        $option_kota = '<option value="0">Pilih Kota/Kabupaten</option>';

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

        $form_cari = '
        <div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
        <div class="row col-md-12">
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
            <button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Refresh</button>
            <button type="button" id="process" class="btn btn-success btn-sm hidden"><i class="fa fa-print"></i>&nbsp;Process</button>
        </div>
        <div class="form-group col-md-3 text-right">
            <button type="button" id="history" class="btn btn-dark btn-sm"><i class="fa fa-list"></i>&nbsp;Sudah M-Sign</button>
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
