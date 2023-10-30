<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stagging_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllData($table)
	{
		return $this->db->get($table);
	}

	public function getAllDataLimited($table, $limit, $offset)
	{
		return $this->db->get($table, $limit, $offset);
	}

	public function getSelectedDataLimited($table, $data, $limit, $offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}

	//select table
	public function getSelectedData($table, $data)
	{
		return $this->db->get_where($table, $data);
	}

	//update table
	function updateData($table, $data, $field_key)
	{
		return $this->db->update($table, $data, $field_key);
	}

	function deleteData($table, $data)
	{
		return $this->db->delete($table, $data);
	}

	function insertData($table, $data)
	{
		$db2 = $this->load->database('stagging', TRUE);
		$db2->insert($table, $data);
		return $db2->insert_id($table, $data);
	}

	function cekTabel($table)
	{
		$db2 = $this->load->database('stagging', TRUE);
		$sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES 
		WHERE TABLE_NAME LIKE '%" . $table . "%'";
		$query = $db2->query($sql);
		return $query;
	}

	function createTabelRT($table)
	{
		$db2 = $this->load->database('stagging', TRUE);
		$sql = "CREATE TABLE " . $table . " (
			IDBDT varchar(23) NULL,
			RUTA6 varchar(50) NULL,
			NoPesertaPBDT varchar(30) NULL,
			NoPBDTKemsos varchar(30) NULL,
			Vector1 bigint NULL,
			Vector2 bigint NULL,
			Vector3 bigint NULL,
			Vector4 bigint NULL,
			KDGabungan4 varchar(23) NULL,
			KDPROP varchar(4) NULL,
			KDKAB varchar(8) NULL,
			KDKEC varchar(16) NULL,
			KDDESA varchar(32) NULL,
			Alamat varchar(512) NULL,
			AdaPKH tinyint NULL,
			AdaPBDT tinyint NULL,
			AdaKKS2016 tinyint NULL,
			AdaKKS2017 tinyint NULL,
			AdaPBI tinyint NULL,
			AdaDapodik tinyint NULL,
			AdaBPNT tinyint NULL,
			NoPesertaPKH varchar(50) NULL,
			NoPesertaKKS2016 varchar(20) NULL,
			NoPesertaPBI varchar(20) NULL,
			PesertaKIP int NULL,
			NoKartuDebit varchar(16) NULL,
			Nama_SLS varchar(128) NULL,
			Nama_KRT varchar(100) NULL,
			Jumlah_ART smallint NULL,
			Jumlah_Keluarga smallint NULL,
			sta_bangunan tinyint NULL,
			sta_lahan tinyint NULL,
			luas_lantai real NULL,
			lantai tinyint NULL,
			dinding tinyint NULL,
			kondisi_dinding tinyint NULL,
			atap tinyint NULL,
			kondisi_atap tinyint NULL,
			jumlah_kamar tinyint NULL,
			sumber_airminum tinyint NULL,
			nomor_meter_air varchar(30) NULL,
			cara_peroleh_airminum tinyint NULL,
			sumber_penerangan tinyint NULL,
			daya tinyint NULL,
			nomor_pln varchar(30) NULL,
			bb_masak tinyint NULL,
			nomor_gas varchar(30) NULL,
			fasbab tinyint NULL,
			kloset tinyint NULL,
			buang_tinja tinyint NULL,
			ada_tabung_gas tinyint NULL,
			ada_lemari_es tinyint NULL,
			ada_ac tinyint NULL,
			ada_pemanas tinyint NULL,
			ada_telepon tinyint NULL,
			ada_tv tinyint NULL,
			ada_emas tinyint NULL,
			ada_laptop tinyint NULL,
			ada_sepeda tinyint NULL,
			ada_motor tinyint NULL,
			ada_mobil tinyint NULL,
			ada_perahu tinyint NULL,
			ada_motor_tempel tinyint NULL,
			ada_perahu_motor tinyint NULL,
			ada_kapal tinyint NULL,
			aset_tak_bergerak tinyint NULL,
			luas_atb varchar(30) NULL,
			rumah_lain tinyint NULL,
			jumlah_sapi tinyint NULL,
			jumlah_kerbau tinyint NULL,
			jumlah_kuda tinyint NULL,
			jumlah_babi tinyint NULL,
			jumlah_kambing tinyint NULL,
			sta_art_usaha tinyint NULL,
			sta_kks tinyint NULL,
			sta_kip tinyint NULL,
			sta_kis tinyint NULL,
			sta_bpjs_mandiri tinyint NULL,
			sta_jamsostek tinyint NULL,
			sta_asuransi tinyint NULL,
			sta_pkh tinyint NULL,
			sta_rastra tinyint NULL,
			sta_kur tinyint NULL,
			sta_keberadaan_RT tinyint NULL,
			percentile tinyint NULL,
			id_pengurus varchar(50) NULL,
			Nama_Pengurus varchar(64) NULL,
			NIK_Pengurus varchar(30) NULL,
			Alamat_Pengurus varchar(255) NULL,
			Nama_Gadis_Ibu_Kandung_Pengurus varchar(50) NULL,
			JnsKel_Pengurus varchar(10) NULL,
			TglLahir_Pengurus date NULL,
			HubKel_Pengurus varchar(20) NULL,
			InitData datetime NULL,
			LastUpdateData datetime NULL,
			kodewilayah varchar(20) NULL,
			IDver varchar(50) NULL,
			RID_RumahTangga varchar(30) NULL,
			typedta varchar(3) NULL,
			no_kks varchar(89) NULL,
			sumber_data varchar(255) NULL,
			uploaded_by varchar(100) NULL,
			kode_sls char(16) NULL,
			NOKK varchar(20) NULL,
			id_hh varchar(50) NULL,
			nourut_rt varchar(50) NULL,
			NoPBDTKemsos_2017 varchar(20) NULL,
			KDPROP_2017 varchar(4) NULL,
			KDKAB_2017 varchar(8) NULL,
			KDKEC_2017 varchar(16) NULL,
			KDDESA_2017 varchar(32) NULL,
			adadivektor bit NULL,
			KDPROP_OLD varchar(4) NULL,
			KDKAB_OLD varchar(8) NULL,
			KDKEC_OLD varchar(16) NULL,
			KDDESA_OLD varchar(32) NULL,
			id_periode int NULL,
			tgl_pindah datetime NULL,
			oleh_pindah varchar(255) NULL,
			KET_BDTMEI18 varchar(100) NULL,
			PERBAIKAN tinyint NULL,
			EXISTING bit NULL,
			NONAKTIF bit NULL,
			IDINC int NULL,
			foto_rumah varchar(255) NULL,
			foto_ktp varchar(255) NULL,
			foto_kk varchar(205) NULL,
			foto_kk1 varchar(255) NULL,
			foto_kk2 varchar(255) NULL,
			foto_kk3 varchar(255) NULL,
			foto_kk4 varchar(255) NULL,
			foto_kk5 varchar(255) NULL,
			lat varchar(50) NULL,
			long varchar(50) NULL,
			foto_kk6 varchar(255) NULL,
			TG_INPUTTED datetime NULL,
			start_at datetime NULL,
			end_at datetime NULL,
			flag_sk tinyint NULL,
			status_kesejahteraan int NULL,
			foto_dinding varchar(255) NULL,
			foto_lantai varchar(255) NULL,
			foto_jamban varchar(255) NULL,
			foto_dapur varchar(255) NULL,
			foto_atap varchar(255) NULL,
			foto_krt varchar(255) NULL,
			IDREPL int NOT NULL
			)";
		$query = $db2->query($sql);
		return $query;
	}

	function createTabelART($table)
	{
		$db2 = $this->load->database('stagging', TRUE);
		$sql = "CREATE TABLE " . $table . " (
			IDARTBDT varchar(25) NULL,
			IDBDT varchar(23) NULL,
			RUTA6 varchar(6) NULL,
			NoPesertaPBDT varchar(30) NULL,
			NoPesertaPBDTART varchar(20) NULL,
			NoPBDTKemsos varchar(29) NULL,
			NoArtPBDTKemsos varchar(31) NULL,
			Vector1 bigint NULL,
			Vector2 bigint NULL,
			Vector3 bigint NULL,
			Vector4 bigint NULL,
			KDGabungan4 varchar(23) NULL,
			KDPROP varchar(4) NULL,
			KDKAB varchar(8) NULL,
			KDKEC varchar(16) NULL,
			KDDESA varchar(32) NULL,
			NoPesertaPKH varchar(50) NULL,
			NoPesertaKKS2016 varchar(20) NULL,
			NoPesertaPBI_org varchar(20) NULL,
			NoArtPKH varchar(50) NULL,
			NoArtPBDT varchar(50) NULL,
			NoArtKKS2016 varchar(50) NULL,
			NoArtPBI_org varchar(50) NULL,
			Nama varchar(250) NULL,
			JnsKel tinyint NULL,
			TmpLahir varchar(250) NULL,
			TglLahir date NULL,
			HubKRT varchar(50) NULL,
			NIK varchar(30) NULL,
			NoKK varchar(20) NULL,
			Hub_KRT tinyint NULL,
			NUK tinyint NULL,
			Hubkel tinyint NULL,
			Umur tinyint NULL,
			Sta_kawin tinyint NULL,
			Ada_akta_nikah tinyint NULL,
			Ada_diKK tinyint NULL,
			Ada_kartu_identitas tinyint NULL,
			Sta_hamil tinyint NULL,
			Jenis_cacat tinyint NULL,
			Penyakit_kronis tinyint NULL,
			Partisipasi_sekolah tinyint NULL,
			Pendidikan_tertinggi tinyint NULL,
			Kelas_tertinggi tinyint NULL,
			Ijazah_tertinggi tinyint NULL,
			Sta_Bekerja tinyint NULL,
			Jumlah_jamkerja smallint NULL,
			Lapangan_usaha tinyint NULL,
			Status_pekerjaan tinyint NULL,
			Sta_keberadaan_art tinyint NULL,
			Sta_kepesertaan_pbi tinyint NULL,
			Ada_kks tinyint NULL,
			Ada_pbi tinyint NULL,
			Ada_kip tinyint NULL,
			Ada_pkh tinyint NULL,
			Ada_rastra tinyint NULL,
			Anak_diluar_rt varchar(255) NULL,
			namagadis_ibukandung varchar(250) NULL,
			sta_keberadaan_kks tinyint NULL,
			InitData datetime NULL,
			LastUpdateData datetime NULL,
			kodewilayah varchar(20) NULL,
			IDver varchar(50) NULL,
			RID_RumahTangga varchar(30) NULL,
			RID_Individu varchar(20) NULL,
			lapangan_usahaart varchar(50) NULL,
			jumlah_pekerja varchar(50) NULL,
			lokasi_usaha varchar(50) NULL,
			omset_usaha varchar(50) NULL,
			id bigint NULL,
			NU_RT int NULL,
			id_hh varchar(50) NULL,
			nourut_rt varchar(50) NULL,
			sumber_data varchar(100) NULL,
			NoPBDTKemsos_2017 varchar(30) NULL,
			KDPROP_2017 varchar(4) NULL,
			KDKAB_2017 varchar(8) NULL,
			KDKEC_2017 varchar(16) NULL,
			KDDESA_2017 varchar(32) NULL,
			DUK_NIK varchar(250) NULL,
			DUK_NO_KK varchar(250) NULL,
			DUK_NAMA_LGKP varchar(250) NULL,
			DUK_STAT_HBKEL varchar(250) NULL,
			DUK_NO_RW varchar(50) NULL,
			DUK_NO_RT varchar(50) NULL,
			DUK_NO_KEL varchar(250) NULL,
			DUK_ALAMAT varchar(250) NULL,
			DUK_TMPT_LHR varchar(250) NULL,
			DUK_TGL_LHR date NULL,
			DUK_JENIS_KLMIN varchar(250) NULL,
			DUK_STATUS_KAWIN varchar(250) NULL,
			DUK_NAMA_LGKP_AYAH varchar(250) NULL,
			DUK_JENIS_PKRJN varchar(250) NULL,
			DUK_PDDK_AKH varchar(250) NULL,
			DUK_NAMA_LGKP_IBU varchar(250) NULL,
			IDPENGURUS varchar(20) NULL,
			NOREKENING varchar(20) NULL,
			KDPROP_OLD varchar(4) NULL,
			KDKAB_OLD varchar(8) NULL,
			KDKEC_OLD varchar(16) NULL,
			KDDESA_OLD varchar(32) NULL,
			Alamat_Pengurus varchar(255) NULL,
			MasukKuota bit NULL,
			Nama_Pengurus varchar(100) NULL,
			tgl_pindah datetime NULL,
			oleh_pindah varchar(255) NULL,
			id_periode int NULL,
			KET_BDTMEI18 varchar(100) NULL,
			cek_kks tinyint NULL,
			NoArtPBDTKemsos_2017 varchar(31) NULL,
			id_periode_kks int NULL,
			data_pengurus_dari varchar(100) NULL,
			segmen_bpjs_old varchar(255) NULL,
			urut bigint NULL,
			urutcek float NULL,
			urutunik varchar(255) NULL,
			TMPBSP bit NULL,
			ket_bsp varchar(255) NULL,
			ID_INC bigint NULL,
			flag_sk tinyint NULL,
			flag_nik tinyint NULL,
			NOKARTU varchar(20) NULL,
			flag_cleansing char(1) NULL,
			NOKA_BPJS_OLD varchar(13) NULL,
			PSNOKA_BPJS_OLD varchar(13) NULL,
			ADA_PBI_BPJS bit NULL,
			SEGMEN_BPJS_OLD1 varchar(10) NULL,
			ADAPKH_NEW bit NULL,
			NOPESERTAPKH_NEW varchar(20) NULL,
			NOREKPKH_NEW varchar(20) NULL,
			NOARTPKH_NEW varchar(20) NULL,
			FLAG_NIK2 tinyint NULL,
			DUK_NIK2 varchar(250) NULL,
			DUK_NO_KK2 varchar(250) NULL,
			DUK_NAMA_LGKP2 varchar(250) NULL,
			DUK_STAT_HBKEL2 varchar(250) NULL,
			DUK_NO_RW2 varchar(50) NULL,
			DUK_NO_RT2 varchar(50) NULL,
			DUK_NO_KEL2 varchar(250) NULL,
			DUK_ALAMAT2 varchar(250) NULL,
			DUK_TMPT_LHR2 varchar(250) NULL,
			DUK_TGL_LHR2 date NULL,
			DUK_JENIS_KLMIN2 varchar(250) NULL,
			DUK_STATUS_KAWIN2 varchar(250) NULL,
			DUK_NAMA_LGKP_AYAH2 varchar(250) NULL,
			DUK_JENIS_PKRJN2 varchar(250) NULL,
			DUK_PDDK_AKH2 varchar(250) NULL,
			DUK_NAMA_LGKP_IBU2 varchar(250) NULL,
			KDWILCAPIL varchar(15) NULL,
			STA_KEBERADAAN_PBI_JULI varchar(50) NULL,
			id_keluarga numeric(19, 0) NULL,
			Ada_pkh_old tinyint NULL,
			NoPesertaPKH_old varchar(50) NULL,
			NoArtPKH_old varchar(50) NULL,
			NOREKENING_old varchar(50) NULL,
			NoPesertaPBI_old varchar(20) NULL,
			NoArtPBI_old varchar(50) NULL,
			flag_applied_nik tinyint NULL,
			NoPesertaPBI varchar(13) NULL,
			NoArtPBI varchar(13) NULL,
			KET_PADAN_PBI varchar(255) NULL,
			SEGMEN_BPJS varchar(13) NULL,
			dapodik varchar(10) NULL,
			PIP_dikbud varchar(10) NULL,
			PIP_menag varchar(10) NULL,
			ada_dapodik tinyint NULL,
			ada_menag tinyint NULL,
			CEKNIK tinyint NULL,
			ada_bst tinyint NULL,
			proses_bst varchar(50) NULL,
			penerima_bst varchar(150) NULL
			)";
		$query = $db2->query($sql);
		return $query;
	}
	function createTabelFoto($table)
	{
		$db2 = $this->load->database('stagging', TRUE);
		$sql = "CREATE TABLE " . $table . " (
			file_id int NOT NULL,
			IDBDT varchar(23) NULL,
			file_name varchar(250) NULL,
			file_size varchar(50) NULL,
			file_type varchar(50) NULL,
			internal_filename varchar(250) NULL,
			description varchar(50) NULL,
			download_count int  NULL,
			view_count int  NULL,
			revision int  NULL,
			status varchar(50) NULL,
			latitude varchar(50) NULL,
			longitude varchar(50) NULL,
			ip_user varchar(50) NULL,
			stereotype varchar(50) NULL,
			sort_order int  NULL,
			row_status varchar(50) NULL,
			created_by int  NULL,
			created_on datetime2(7) NULL,
			lastupdate_by int NULL,
			lastupdate_on datetime2(7) NULL
			)";
		$query = $db2->query($sql);
		return $query;
	}

	//Query manual
	function manualQuery($q)
	{
		return $this->db->query($q);
	}
}
