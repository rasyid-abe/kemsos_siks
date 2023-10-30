<?php

 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=export_data.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?>
 
<style type="text/css">
    * {
        font-family: Arial;
        margin: 0px;
        padding: 0px;
    }

    @page {
        margin-left: 3cm 2cm 2cm 2cm;
    }

    table.grid {
        width: 29.7cm;
        font-size: 12px;
        border-collapse: collapse;
    }

    table.grid th {
        padding: 5px;
    }

    table.grid th {
        background: #F0F0F0;
        border-top: 0.2mm solid #000;
        border-bottom: 0.2mm solid #000;
        text-align: center;
        border: 1px solid #000;
    }

    table.grid tr td {
        padding: 2px;
        border-bottom: 0.2mm solid #000;
        border: 1px solid #000;
    }

    h1 {
        font-size: 18px;
    }

    h2 {
        font-size: 14px;
    }

    h3 {
        font-size: 12px;
    }

    p {
        font-size: 10px;
    }

    center {
        padding: 8px;
    }

    .atas {
        display: block;
        width: 29.7cm;
        margin: 0px;
        padding: 0px;
    }

    .kanan tr td {
        font-size: 12px;
    }

    .attr {
        font-size: 9pt;
        width: 100%;
        padding-top: 2pt;
        padding-bottom: 2pt;
        border-top: 0.2mm solid #000;
        border-bottom: 0.2mm solid #000;
    }

    .pagebreak {
        width: 29.7cm;
        page-break-after: always;
        margin-bottom: 10px;
    }

    .akhir {
        width: 29.7cm;
        font-size: 13px;
    }

    .page {
        width: 29.7cm;
        font-size: 12px;
        padding: 10px;
    }

</style>


    <table class="grid" width="100%" border="1">
        <tr>
            <th>No</th>
            <th>STATUS</th>
            <th>ID PRELIST</th>
            <th>NAMA KRT</th>
            <th>NIK</th>
            <th>ALAMAT</th>
            <th>PROVINSI</th>
            <th>KABUPATEN</th>
            <th>KECAMATAN</th>
            <th>KELURAHAN</th>
            <th>STATUS RUMAH TANGGA</th>
            <th>ALASAN TIDAK DI TEMUKAN</th>
            <th>APAKAH MAMPU</th>
            <th>JENIS KELAMIN KRT</th>
            <th>NAMA PASANGAN KRT</th>
            <th>HASIL VERIVALI</th>
            
        </tr>


<?php


    $no = 1;
   //$sub_bayar2 =0;
    $data = $data->result_array();
    foreach ($data as $key => $r){
    if($r['status_rumahtangga']=='1')
		$status_rumahtangga='Ditemukan';
	elseif($r['status_rumahtangga']=='2')
		$status_rumahtangga='Tidak Ditemukan';
	elseif($r['status_rumahtangga']=='3')
		$status_rumahtangga='Ganda';
	elseif($r['status_rumahtangga']=='4')
		$status_rumahtangga='Usulan Baru';
	else
		$status_rumahtangga='';
	
	if($r['alasan_tidak_ditemukan']=='1')
		$alasan_tidak_ditemukan='Pindah';
	elseif($r['alasan_tidak_ditemukan']=='2')
		$alasan_tidak_ditemukan='Meninggal';
	elseif($r['alasan_tidak_ditemukan']=='3')
		$alasan_tidak_ditemukan='Tidak Tahu';
	elseif($r['alasan_tidak_ditemukan']=='4')
		$alasan_tidak_ditemukan='Alamat tidak ada di Desa/Kelurahan Setempat';
	else
		$alasan_tidak_ditemukan='';
	
	if($r['apakah_mampu']=='1')
		$apakah_mampu='Ya';
	elseif($r['apakah_mampu']=='2')
		$apakah_mampu='Tidak';
	else
		$apakah_mampu='';
	
	if($r['jenis_kelamin_krt']=='1')
		$jenis_kelamin_krt='Laki-laki';
	elseif($r['jenis_kelamin_krt']=='2')
		$jenis_kelamin_krt='Perempuan';
	
	if($r['hasil_verivali']=='1')
		$hasil_verivali='Selesai Dicacah';
	elseif($r['hasil_verivali']=='2')
		$hasil_verivali='Rumah Tangga Tidak Ditemukan';
	elseif($r['hasil_verivali']=='3')
		$hasil_verivali='Rumah Tangga Pindah';
	elseif($r['hasil_verivali']=='4')
		$hasil_verivali='Bagian Dari Rumah Tangga';
	elseif($r['hasil_verivali']=='5')
		$hasil_verivali='Responden Menolak';
	elseif($r['hasil_verivali']=='6')
		$hasil_verivali='Data Ganda';
	else
		$hasil_verivali='';
	
	$prelist=$r['id_prelist'];
	$nik=$r['nomor_nik'];
	
?>
    <tr>
        <td align="center" width="40"><?php echo $no; ?></td>
        <td align="left" width="100"><?php echo $r['stereotype']; ?></td>
        <td align="left" width="100"><?php echo "=\"$prelist\""; ?></td>
		<td align="left" width="100"><?php echo $r['nama_krt']; ?></td>
		<td align="left" width="100"><?php echo "=\"$nik\""; ?></td>
		<td align="left" width="100"><?php echo $r['alamat']; ?></td>
		<td align="left" width="100"><?php echo $r['province_name']; ?></td>
		<td align="left" width="100"><?php echo $r['regency_name']; ?></td>
		<td align="left" width="100"><?php echo $r['district_name']; ?></td>
		<td align="left" width="100"><?php echo $r['village_name']; ?></td>
		<td align="left" width="100"><?php echo $status_rumahtangga; ?></td>
		<td align="left" width="100"><?php echo $alasan_tidak_ditemukan; ?></td>
		<td align="left" width="100"><?php echo $apakah_mampu; ?></td>
		<td align="left" width="100"><?php echo $jenis_kelamin_krt; ?></td>
		<td align="left" width="100"><?php echo $r['nama_pasangan_krt']; ?></td>
		<td align="left" width="100"><?php echo $hasil_verivali; ?></td>
		
    </tr>
<?php
       
     
    $no++;
    }


?>
</table>