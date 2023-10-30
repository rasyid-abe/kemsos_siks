<!-- [ Main Content ] start -->
<style>
  .tab-content h5{
      text-align: center !important;
  }
</style>
<div class="row">
	<div class="col-12 filter-bar invoice-list">	
		<div class="card">
			<div class="card-header m-t-8" style="margin-bottom: -15px">
			  <?php if ( isset( $cari ) ) {
					 echo $cari;
			   }?>
			</div>
		</div>
		<input type="hidden" id="base_url" value="<?php echo $base_url;?>">	
	</div>
</div>
<div class="row">

    <!-- [ variant-chart ] start -->
    <div class="col-md-4">	
        <div class="card card-border-c-blue" style="height:800px;overflow-x:auto;">
			<div class="card-header">
				<h5>Filter Penyajian Data</h5>
			</div>
            <div class="card-body">
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-1-tab" data-toggle="pill" href="#v-1" role="tab" aria-controls="v-1" aria-selected="true">
                    1. Ruta By status penguasaan bangunan
                </a>
                <a class="nav-link" id="v-2-tab" data-toggle="pill" href="#v-2" role="tab" aria-controls="v-2" aria-selected="false">
                    2. Ruta By status penguasaan lahan
                </a>
                <a class="nav-link" id="v-3-tab" data-toggle="pill" href="#v-3" role="tab" aria-controls="v-3" aria-selected="false">
                    3. Ruta By jenis lantai terluas
                </a>
                <a class="nav-link" id="v-4-tab" data-toggle="pill" href="#v-4" role="tab" aria-controls="v-4" aria-selected="false">
                    4. Ruta By dinding terluas dan kondisi
                </a>
                <a class="nav-link" id="v-5-tab" data-toggle="pill" href="#v-5" role="tab" aria-controls="v-5" aria-selected="false">
                    5. Ruta By jenis atap terluas dan kondisi
                </a>
                <a class="nav-link" id="v-6-tab" data-toggle="pill" href="#v-6" role="tab" aria-controls="v-6" aria-selected="false">
                    6. Ruta By sumber air minum
                </a>
                <a class="nav-link" id="v-7-tab" data-toggle="pill" href="#v-7" role="tab" aria-controls="v-7" aria-selected="false">
                    7. Ruta By cara memperoleh air minum
                </a>
                <a class="nav-link" id="v-8-tab" data-toggle="pill" href="#v-8" role="tab" aria-controls="v-8" aria-selected="false">
                    8. Ruta By sumber penerangan utama
                </a>
                <a class="nav-link" id="v-9-tab" data-toggle="pill" href="#v-9" role="tab" aria-controls="v-9" aria-selected="false">
                    9. Ruta By penerangan utama PLN dan daya terpasang
                </a>
                <a class="nav-link" id="v-10-tab" data-toggle="pill" href="#v-10" role="tab" aria-controls="v-10" aria-selected="false">
                    10. Ruta By bahan bakar energi untuk memasak
                </a>
                <a class="nav-link" id="v-11-tab" data-toggle="pill" href="#v-11" role="tab" aria-controls="v-11" aria-selected="false">
                    11. Ruta By penggunaan fasilitas tempat BAB
                </a>
                <a class="nav-link" id="v-12-tab" data-toggle="pill" href="#v-12" role="tab" aria-controls="v-12" aria-selected="false">
                    12. Ruta By tempat pembuangan akhir tinja
                </a>
                <a class="nav-link" id="v-13-tab" data-toggle="pill" href="#v-13" role="tab" aria-controls="v-13" aria-selected="false">
                    13. Ruta By rasio jumlah kamar tidur dan jumlah art
                </a>
                <a class="nav-link" id="v-14-tab" data-toggle="pill" href="#v-14" role="tab" aria-controls="v-14" aria-selected="false">
                    14. Ruta By kepemilikan jenis asset bergerak
                </a>
                <a class="nav-link" id="v-15-tab" data-toggle="pill" href="#v-15" role="tab" aria-controls="v-15" aria-selected="false">
                    15. Ruta By KRT perempuan
                </a>
                <a class="nav-link" id="v-16-tab" data-toggle="pill" href="#v-16" role="tab" aria-controls="v-16" aria-selected="false">
                    16. Ruta By kehamilan berstatus kawin
                </a>
                <a class="nav-link" id="v-17-tab" data-toggle="pill" href="#v-17" role="tab" aria-controls="v-17" aria-selected="false">
                    17. Ruta By status perkawinan
                </a>
                <a class="nav-link" id="v-18-tab" data-toggle="pill" href="#v-18" role="tab" aria-controls="v-18" aria-selected="false">
                    18. Ruta By jenis disabilitas
                </a>
                <a class="nav-link" id="v-19-tab" data-toggle="pill" href="#v-19" role="tab" aria-controls="v-19" aria-selected="false">
                    19. Ruta By jenis penyakit kronis/menahun
                </a>
                <a class="nav-link" id="v-20-tab" data-toggle="pill" href="#v-20" role="tab" aria-controls="v-20" aria-selected="false">
                    20. Ruta By status kesejahteraan
                </a>
                <a class="nav-link" id="v-21-tab" data-toggle="pill" href="#v-21" role="tab" aria-controls="v-21" aria-selected="false">
                    21. Ruta By kepemilikan jenis ternak
                </a>
                <a class="nav-link" id="v-22-tab" data-toggle="pill" href="#v-22" role="tab" aria-controls="v-22" aria-selected="false">
                    22. Ruta By asset tak bergerak
                </a>
                <a class="nav-link" id="v-23-tab" data-toggle="pill" href="#v-23" role="tab" aria-controls="v-23" aria-selected="false">
                    23. Ruta By jenis jaminan sosial
                </a>
                <a class="nav-link" id="v-24-tab" data-toggle="pill" href="#v-24" role="tab" aria-controls="v-24" aria-selected="false">
                    24. Ruta By kelompok umur tidak tercantum dalam KK
                </a>
                <a class="nav-link" id="v-25-tab" data-toggle="pill" href="#v-25" role="tab" aria-controls="v-25" aria-selected="false">
                    25. Ruta By kelompok umur berdasarkan jenis identitas
                </a>
                <a class="nav-link" id="v-26-tab" data-toggle="pill" href="#v-26" role="tab" aria-controls="v-26" aria-selected="false">
                    27. Ruta By kelompok umur berdasarkan status sekolah
                </a>
                <a class="nav-link" id="v-27-tab" data-toggle="pill" href="#v-27" role="tab" aria-controls="v-27" aria-selected="false">
                    27. Ruta By partisipasi sekolah
                </a>
                <a class="nav-link" id="v-28-tab" data-toggle="pill" href="#v-28" role="tab" aria-controls="v-28" aria-selected="false">
                    28. Ruta By kelompok umur berdasarkan status kerja
                </a>
                <a class="nav-link" id="v-29-tab" data-toggle="pill" href="#v-29" role="tab" aria-controls="v-29" aria-selected="false">
                    29. Ruta By lapangan pekerjaan
                </a>
              </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
      <div class="card card-border-c-blue" style="height:800px;overflow-x:auto;">         
          <div class="card-body">
              <div class="table">
                <div class="tab-content" id="v-pills-tabContent">
                  <div class="tab-pane fade show active" id="v-1" role="tabpanel" aria-labelledby="v-1-tab">
                      <h5 >Ruta By status penguasaan bangunan</h5>
                      <table class="table table-bordered">
                        <tr>
                            <th>Status Bangunan</th>
                            <th>Total</td>
                        </tr>
                        <tr>
                            <td>Milik Sendiri</td>
                            <td id="sendiri">0</td>
                        </tr>
                        <tr>
                            <td>Kontrak / Sewa</td>
                            <td id="kontrak">0</td>
                        </tr>
                        <tr>
                            <td>Bebas Sewa</td>
                            <td id="bebasSewa">0</td>
                        </tr>
                        <tr>
                            <td>Dinas</td>
                            <td id="dinas">0</td>
                        </tr>
                        <tr>
                            <td>Lainnya</td>
                            <td id="statusBangunanLainnya">0</td>
                        </tr>
                      </table>
                      <div id="status_bangunan" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-2" role="tabpanel" aria-labelledby="v-2-tab">
                      <h5 >Ruta By status penguasaan lahan</h5>
                      <table class="table table-bordered">
                          <tr>
                            <th width="400px">Status Lahan</th>
                            <th>Total</th>
                          </tr>
                          <tr>
                            <td>Milik Sendiri</td>
                            <td id="lahan_sendiri"></td>
                          </tr>
                          <tr>
                            <td>Milik Orang Lain</td>
                            <td id="orangLain"></td>
                          </tr>
                          <tr>
                            <td>Tanah Negara</td>
                            <td id="tanahNegara"></td>
                          </tr>
                          <tr>
                            <td>Lainnya</td>
                            <td id="lainnya"></td>
                          </tr>
                      </table>
                      <div id="status_lahan" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-3" role="tabpanel" aria-labelledby="v-3-tab">
                      <h5 >Ruta By jenis lantai terluas</h5>
                      <table class="table table-bordered">
                          <tr>
                            <th width="400px">Jenis Lantai</th>
                            <th>Total</th>
                          </tr>
                          <tr>
                            <td width="400px">Marmer/Granit</td>
                            <td id="marmer"></td>
                          </tr>
                          <tr>
                            <td>Keramik</td>
                            <td id="keramik"></td>
                          </tr>
                           <tr>
                            <td>Parket/vinil</td>
                            <td id="parket"></td>
                          </tr>
                          <tr>
                            <td>Ubin/tegel/teraso</td>
                            <td id="ubin"></td>
                          </tr>
                          <tr>
                            <td>Kayu/kualitas tinggi</td>
                            <td id="kayu"></td>
                          </tr>
                          <tr>
                            <td>Sementara/bata merah</td>
                            <td id="bata"></td>
                          </tr>
                          <tr>
                            <td>Bambu</td>
                            <td id="bambu"></td>
                          </tr>
                          <tr>
                            <td>Kayu/kualitas rendah</td>
                            <td id="papan"></td>
                          </tr>
                          <tr>
                            <td>Tanah</td>
                            <td id="tanah"></td>
                          </tr>
                          <tr>
                            <td>Lainnya</td>
                            <td id="lantaiLainnya"></td>
                          </tr>
                      </table>
                      <div id="jenis_lantai" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-4" role="tabpanel" aria-labelledby="v-3-tab">
                      <h5 >Ruta By dinding terluas dan kondisi</h5>
                      <table class="table table-bordered">
                        <tr>
                            <th>Jenis Dinding</th>
                            <th>Bagus/Kualitas Tinggi</th>
                            <th>Jelek/Kualitas Rendah</th>
                            <th >Total</th>
                        </tr>
                        <tr>
                            <td>Tembok</td>
                            <td id="tembokBagus"></td>
                            <td id="tembokJelek"></td>
                            <td id="totalTembok"></td>
                        </tr>
                        <tr>
                            <td>Plesteran bambu/kawat</td>
                            <td id="plesteranBagus"></td>
                            <td id="plesteranJelek"></td>
                            <td id="totalPlesteran"></td>
                        </tr>
                        <tr>
                            <td>kayu</td>
                            <td id="kayuBagus"></td>
                            <td id="kayuJelek"></td>
                            <td id="totalKayu"></td>
                        </tr>
                        <tr>
                            <td colspan='3'>Anyaman Bambu</td>
                            <td id="anyamanBambu"></td>
                        </tr>
                        <tr>
                            <td colspan='3'>Batang Kayu</td>
                            <td id="batangKayu"></td>
                        </tr>
                        <tr>
                             <td colspan='3'>Bambu</td>
                             <td id="bambu_dinding"></td>
                         </tr>
                         <tr>
                             <td colspan='3'>Lainnya</td>
                             <td id="dindingLainnya"></td>
                         </tr>
                      </table>
                      <div id="status_dinding" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-5" role="tabpanel" aria-labelledby="v-5-tab">
                      <h5 >Ruta By jenis atap terluas dan kondisi</h5>
                      <table class="table table-bordered">
                          <tr>
                              <th>Jenis Atap</th>
                              <th>Bagus/Kualitas Tinggi</th>
                              <th>Jelek/Kualitas Rendah</th>
                              <th>Total</th>
                          </tr>
                          <tr>
                              <td>Beton/Genteng</td>
                              <td id="betonBagus"></td>
                              <td id="betonJelek"></td>
                              <td id="totalBeton"></td>
                          </tr>
                          <tr>
                              <td>Genteng Keramik</td>
                              <td id="gKeramikBagus"></td>
                              <td id="gKeramikJelek"></td>
                              <td id="totalGKeramik"></td>
                          </tr>
                          <tr>
                              <td>Genteng Metal</td>
                              <td id="gMetalBagus"></td>
                              <td id="gMetalJelek"></td>
                              <td id="totalGMetal"></td>
                          </tr>
                          <tr>
                              <td>Genteng Tanah Liat</td>
                              <td id="gTanahLiatBagus"></td>
                              <td id="gTanahLiatJelek"></td>
                              <td id="totalTanahLiat"></td>
                          </tr>
                          <tr>
                              <td>Asbes</td>
                              <td id="asbesBagus"></td>
                              <td id="asbesJelek"></td>
                              <td id="totalAsbes"></td>
                          </tr>
                          <tr>
                              <td>Seng</td>
                              <td id="sengBagus"></td>
                              <td id="sengJelek"></td>
                              <td id="totalSeng"></td>
                          </tr>
                          <tr>
                              <td>Sirap</td>
                              <td id="sirapBagus"></td>
                              <td id="sirapJelek"></td>
                              <td id="totalSirap"></td>
                          </tr>
                          <tr>
                              <td colspan="3">Bambu</td>
                              <td id="atapBambu"></td>
                          </tr>
                          <tr>
                              <td colspan="3">Jerami/Ijuk</td>
                              <td id="atapJerami"></td>
                          </tr>
                          <tr>
                              <td colspan="3">Lainnya</td>
                              <td id="atapLainnya"></td>
                          </tr>
                      </table>
                      <div id="status_atap" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-6" role="tabpanel" aria-labelledby="v-6-tab">
                      <h5 >Ruta By sumber air minum</h5>
                      <table class="table table-bordered">
                            <tr>
                            	<th width="400px">Sumber Air Minum</th>
                            	<th>Total</th>
                            </tr>
                            <tr>
                            	<td width="400px">Air Kemasan bermerk</td>
                            	<td id="airKemasan"></td>
                            </tr>
                            <tr>
                            	<td>Air isi ulang</td>
                            	<td id="airIsiUlang"></td>
                            </tr>
                            <tr>
                            	<td>Ledeng Meteran</td>
                            	<td id="meteran"></td>
                            </tr>
                            <tr>
                            	<td>Ledeng eceran</td>
                            	<td id="eceran"></td>
                            </tr>
                            <tr>
                            	<td>Sumur bor/pompa</td>
                            	<td id="bor"></td>
                            </tr>
                            <tr>
                            	<td>Sumur Terlindung</td>
                            	<td id="sumurTerlindung"></td>
                            </tr>
                            <tr>
                            	<td>Sumur tak Terlindung</td>
                            	<td id="sumurTakTerlindung"></td>
                            </tr>
                            <tr>
                            	<td>Mata air terlindung</td>
                            	<td id="mataAirTerlindung"></td>
                            </tr>
                            <tr>
                            	<td>Mata air tak terlindung</td>
                            	<td id="mataAirTakTerlindung"></td>
                            </tr>
                            <tr>
                            	<td>Air sungai/danau/waduk</td>
                            	<td id="airSungai"></td>
                            </tr>
                            <tr>
                            	<td>Air Hujan</td>
                            	<td id="airHujan"></td>
                            </tr>
                            <tr>
                            	<td>Lainnya</td>
                            	<td id="airLainnya"></td>
                            </tr>
                      </table>
                       <div id="sumber_airminum" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-7" role="tabpanel" aria-labelledby="v-7-tab">
                      <h5 >Ruta By cara memperoleh air minum</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th>Membeli Eceran</th>
                            <th>Langganan</th>
                            <th>Tidak Membeli</th>

                          </tr>
                          <tr>
                            <td id="membeli"></td>
                            <td id="langganan"></td>
                            <td id="tidakMembeli"></td>
                          </tr>
                        </table>
                        <div id="cara_peroleh" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-8" role="tabpanel" aria-labelledby="v-8-tab">
                      <h5 >Ruta By sumber penerangan utama</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th>Listrik PLN</th>
                            <th>Listrik Non PLN</th>
                            <th>Bukan Listrik</th>

                          </tr>
                          <tr>
                            <td id="pln"></td>
                            <td id="nonPln"></td>
                            <td id="bukanListrik"></td>
                          </tr>
                        </table>
                        <div id="sumber_penerangan" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-9" role="tabpanel" aria-labelledby="v-9-tab">
                      <h5 >Ruta By penerangan utama PLN dan daya terpasang</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">450 watt</th>
                            <td id="pln450watt"></td>
                          </tr>
                          <tr>
                            <th>900 watt</th>
                            <td id="pln900watt"></td>
                          </tr>
                          <tr>
                            <th>1.300 watt</th>
                            <td id="pln1300watt"></td>
                          </tr>
                          <tr>
                            <th>2.200 watt</th>
                            <td id="pln2200watt"></td>
                          </tr>
                          <tr>
                            <th>>2.200 watt</th>
                            <td id="plnLebih2200watt"></td>
                          </tr>
                          <tr>
                            <th>Tanpa Meteran</th>
                            <td id="tanpaMeteran"></td>
                          </tr>
                      </table>
                      <div id="daya_terpasang" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-10" role="tabpanel" aria-labelledby="v-10-tab">
                      <h5 >Ruta By bahan bakar energi untuk memasak</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Listrik </th>
                            <td id="listrik"></td>
                          </tr>
                          <tr>
                            <th>Gas >  3 Kg </th>
                            <td id="gas3KgLebih"></td>
                          </tr>
                          <tr>
                            <th>gas 3 Kg </th>
                            <td id="gas3Kg"></td>
                          </tr>

                          <tr>
                            <th>Gas Kota/biogas</th>
                            <td id="biogas"></td>
                          </tr>
                          <tr>
                            <th>Minya Tanah </th>
                            <td id="minyakTanah"></td>
                          </tr>
                          <tr>
                            <th>Briket</th>
                            <td id="briket"></td>
                          </tr>
                          <tr>
                            <th>Arang</th>
                            <td id="arang"></td>
                          </tr>
                          <tr>
                            <th>Kayu Bakar</th>
                            <td id="kayuBakar"></td>
                          </tr>

                          <tr>
                            <th>Tidak Memasak dirumah</th>
                            <td id="tidakMasak"></td>
                          </tr>
                      </table>
                      <div id="bahan_bakar" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-11" role="tabpanel" aria-labelledby="v-11-tab">
                      <h5 >Ruta By penggunaan fasilitas tempat BAB</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Sendiri</th>
                            <td id="sendiri20"></td>
                          </tr>
                          <tr>
                            <th>Bersama</th>
                            <td id="bersama"></td>
                          </tr>
                          <tr>
                            <th>Umum</th>
                            <td id="umum"></td>
                          </tr>
                          <tr>
                            <th>Tidak ada</th>
                            <td id="tidakAda"></td>
                          </tr>
                      </table>
                      <div id="fasilitas_bab" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-12" role="tabpanel" aria-labelledby="v-12-tab">
                      <h5 >Ruta By tempat pembuangan akhir tinja</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Tangki</th>
                            <td id="tangki"></td>
                          </tr>
                          <tr>
                            <th>SPAL</th>
                            <td id="spal"></td>
                          </tr>
                          <tr>
                            <th>Lubang Tanah</th>
                            <td id="lubangTanah"></td>
                          </tr>
                          <tr>
                            <th>Kolam/sawah</th>
                            <td id="kolam"></td>
                          </tr>
                          <tr>
                            <th>Pantai/kebun</th>
                            <td id="pantai"></td>
                          </tr>
                          <tr>
                            <th>Lainnya</th>
                            <td id="tinjaLainnya"></td>
                          </tr>
                      </table>
                      <div id="tempat_tinja" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-13" role="tabpanel" aria-labelledby="v-13-tab">
                      <h5 >Ruta By rasio jumlah kamar tidur dan jumlah art</h5>
                      <table class="table table-bordered table-hover" >
                          <thead>
                            <th>Rasio Kamar Tidur</th>
                            <th>Anggota Rumah Tangga</th>
                          </thead>
                          <tbody id="rasio_kamar">
                          </tbody>

                      </table>
                  </div>
                  <div class="tab-pane fade" id="v-14" role="tabpanel" aria-labelledby="v-14-tab">
                      <h5 >Ruta By kepemilikan jenis asset bergerak</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Kepemilikan Aset</th>
                            <th>Ya</th>
                            <th>Tidak</th>
                          </tr>
                          <tr>
                            <th>Tabung gas >= 5.5 Kg</th>
                            <td id="tabungGasYa"></td>
                            <td id="tabungGasTidak"></td>
                          </tr>
                          <tr>
                            <th>Lemari es/kulkas</th>
                            <td id="kulkasYa"></td>
                            <td id="kulkasTidak"></td>
                          </tr>
                          <tr>
                            <th>AC</th>
                            <td id="acYa"></td>
                            <td id="acTidak"></td>
                          </tr>
                          <tr>
                            <th>Pemanas air</th>
                            <td id="pemanasAirYa"></td>
                            <td id="pemanasAirTidak"></td>
                          </tr>
                          <tr>
                            <th>Telepon rumah (PSTN)</th>
                            <td id="teleponRumahYa"></td>
                            <td id="teleponRumahTidak"></td>
                          </tr>
                          <tr>
                            <th>Televisi</th>
                            <td id="tvYa"></td>
                            <td id="tvTidak"></td>
                          </tr>
                          <tr>
                            <th>Emas & tabungan</th>
                            <td id="emasYa"></td>
                            <td id="emasTidak"></td>
                          </tr>
                          <tr>
                            <th>Komputer/laptop</th>
                            <td id="laptopYa"></td>
                            <td id="laptopTidak"></td>
                          </tr>
                          <tr>
                            <th>sepeda</th>
                            <td id="sepedaYa"></td>
                            <td id="sepedaTidak"></td>
                          </tr>
                          <tr>
                            <th>sepeda motor</th>
                            <td id="motorYa"></td>
                            <td id="motorTidak"></td>
                          </tr>
                          <tr>
                            <th>Mobil</th>
                            <td id="mobilYa"></td>
                            <td id="mobilTidak"></td>
                          </tr>
                          <tr>
                            <th>Perahu</th>
                            <td id="perahuYa"></td>
                            <td id="perahuTidak"></td>
                          </tr>
                          <tr>
                            <th>Motor tempel</th>
                            <td id="motorTempelYa"></td>
                            <td id="motorTempelTidak"></td>
                          </tr>
                          <tr>
                            <th>Perahu Motor</th>
                            <td id="perahuMotorYa"></td>
                            <td id="perahuMotorTidak"></td>
                          </tr>

                          <tr>
                            <th>Kapal</th>
                            <td id="kapalYa"></td>
                            <td id="kapalTidak"></td>
                          </tr>
                        </table>
                  </div>
                  <div class="tab-pane fade" id="v-15" role="tabpanel" aria-labelledby="v-15-tab">
                      <h5 >Ruta By KRT perempuan</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th>Kepala Rumah Tangga Perempuan</th>
                            </tr>
                          <tr>
                            <td id="KrtPerempuan"></td>
                          </tr>
                       </table>
                  </div>
                  <div class="tab-pane fade" id="v-16" role="tabpanel" aria-labelledby="v-16-tab">
                      <h5>Ruta By kehamilan berstatus kawin</h5>
                      <table class="table table-bordered table-hover">
						  <tr>
							<th>Status Kawin</th>
							<th>Belum Kawin</th>
							<th>Kawin/Nikah</th>
							<th>Cerai Mati</th>
							<th>Cerai Hidup</th>
							<!-- <th>Total Rumah Tangga</th> -->
						  </tr>
						  <tr>
							<th>Sedang Hamil</th>
							<td id="belumKawin_1"></td>
							<td id="kawin_1"></td>
							<td id="ceraiMati_1"></td>
							<td id="ceraiHidup_1"></td>
						  </tr>
						  <tr>
							<th>Tidak Hamil</th>
							<td id="belumKawin_2"></td>
							<td id="kawin_2"></td></td>
							<td id="ceraiMati_2"></td>
							<td id="ceraiHidup_2"></td>
						  </tr>
					  </table>
					<div id="kehamilan_kawin" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-17" role="tabpanel" aria-labelledby="v-17-tab">
                      <h5 >Ruta By status perkawinan</h5>
                      <table class="table table-bordered table-hover">
                        <tr>
                          <th>Kepemilikan Buku Nikah</th>
                          <th>Tidak</th>
                          <th>Ya, Dapat Menunjukan</th>
                          <th>Tidak Dapat Menunjukan</th>
                          <!-- <th>Total Rumah Tangga</th> -->
                        </tr>
                        <tr>
                          <th>Belum Kawin</th>
                          <td id="belum_kawin0"></td>
                          <td id="belum_kawin1"></td>
                          <td id="belum_kawin2"></td>
                        </tr>
                        <tr>
                          <th>Kawin/Nikah</th>
                          <td id="kawin0"></td>
                          <td id="kawin1"></td>
                          <td id="kawin2"></td>
                        </tr>
                        <tr>
                          <th>Cerai Mati</th>
                          <td id="ceraiMati0"></td>
                          <td id="ceraiMati1"></td>
                          <td id="ceraiMati2"></td>
                        </tr>
                         <tr>
                          <th>Cerai Hidup</th>
                          <td id="ceraiHidup0"></td>
                          <td id="ceraiHidup1"></td>
                          <td id="ceraiHidup2"></td>
                        </tr>

                      </table>
                      <div id="status_perkawinan" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-18" role="tabpanel" aria-labelledby="v-18-tab">
                      <h5 >Ruta By jenis disabilitas</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Tidak cacat</th>
                            <td id="disabilitas_0"></td>
                          </tr>
                          <tr>
                            <th>Tuna daksa/ cacat tubuh</th>
                            <td id="disabilitas_1"></td>
                          </tr>
                           <tr>
                            <th>Tuna Netra/buta</th>
                            <td id="disabilitas_2"></td>
                          </tr>
                          <tr>
                            <th>Tuna Wicara</th>
                            <td id="disabilitas_3"></td>
                          </tr>
                          <tr>
                            <th>Tuna rungu & wicara</th>
                            <td id="disabilitas_4"></td>
                          </tr>
                          <tr>
                            <th>Tuna netra & cacat tubuh</th>
                            <td id="disabilitas_5"></td>
                          </tr>
                          <tr>
                            <th>Tuna netra, rungu, & wicara</th>
                            <td id="disabilitas_6"></td>
                          </tr>
                          <tr>
                            <th>Tuna rungu, wicara, & cacat tubuh</th>
                            <td id="disabilitas_7"></td>
                          </tr>
                          <tr>
                            <th>Tuna rungu, wicara, netra, & cacat tubuh</th>
                            <td id="disabilitas_8"></td>
                          </tr>
                          <tr>
                            <th>Cacat mental mental retardasi</th>
                            <td id="disabilitas_9"></td>
                          </tr>
                          <tr>
                            <th>Mantan penderita gangguan jiwa</th>
                            <td id="disabilitas_10"></td>
                          </tr>
                          <tr>
                            <th>Cacat fisik & mental</th>
                            <td id="disabilitas_11"></td>
                          </tr>
                        </table>
                        <div id="jenis_disabilitas" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-19" role="tabpanel" aria-labelledby="v-19-tab">
                      <h5 >Ruta By jenis penyakit kronis/menahun</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Tidak Ada</th>
                            <td id="penyakit_0"></td>
                          </tr>
                          <tr>
                            <th>Hipertensi</th>
                            <td id="penyakit_1"></td>
                          </tr>
                           <tr>
                            <th>Rematik</th>
                            <td id="penyakit_2"></td>
                          </tr>
                           <tr>
                            <th>Asma</th>
                            <td id="penyakit_3"></td>
                          </tr>
                          <tr>
                            <th>Masalah Jantung</th>
                            <td id="penyakit_4"></td>
                          </tr>
                          <tr>
                            <th>Diabetes</th>
                            <td id="penyakit_5"></td>
                          </tr>
                          <tr>
                            <th>Tuberculosis (TBC)</th>
                            <td id="penyakit_6"></td>
                          </tr>
                          <tr>
                            <th>Stroke</th>
                            <td id="penyakit_7"></td>
                          </tr>
                          <tr>
                            <th>Kanker/tumor ganas</th>
                            <td id="penyakit_8"></td>
                          </tr>
                          <tr>
                            <th>Lainnya(gagal ginjal, & sejenisnya)</th>
                            <td id="penyakit_9"></td>
                          </tr>
                        </table>
                        <div id="status_kronis" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-20" role="tabpanel" aria-labelledby="v-20-tab">
                      <h5 >Ruta By status kesejahteraan</h5>
                  </div>
                  <div class="tab-pane fade" id="v-21" role="tabpanel" aria-labelledby="v-21-tab">
                      <h5 >Ruta By kepemilikan jenis ternak</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Sapi</th>
                            <td id="sapi"></td>
                          </tr>
                          <tr>
                            <th>Kerbau</th>
                            <td id="kerbau"></td>
                          </tr>
                          <tr>
                            <th>Kuda</th>
                            <td id="kuda"></td>
                          </tr>
                          <tr>
                            <th>Babi</th>
                            <td id="babi"></td>
                          </tr>
                          <tr>
                            <th>Kambing/</th>
                            <td id="domba"></td>
                          </tr>
                      	</table>
                        <div id="jenis_ternak" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-22" role="tabpanel" aria-labelledby="v-22-tab">
                      <h5 >Ruta By asset tak bergerak</h5>
                      <table class="table table-bordered table-hover">
                         <tr>
                            <th width="400px">Kepemilikan Aset</th>
                            <th>Ya</th>
                            <th>Tidak</th>
                            </tr>
                          <tr>
                            <th>Lahan</th>
                            <td id="lahanYa"></td>
                            <td id="lahanTidak"></td>
                          </tr>
                          <tr>
                            <th>Rumah di tempat lain</th>

                            <td id="rumahYa"></td>
                            <td id="rumahTidak"></td>
                          </tr>

                       </table>
                       <div id="asset_tak_bergerak" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-23" role="tabpanel" aria-labelledby="v-23-tab">
                      <h5 >Ruta By jenis jaminan sosial</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Jaminan Sosial</th>
                            <th>Ya </th>
                            <th>Tidak</th>
                          </tr>
                          <tr>
                            <th>KPS/KKS</th>
                            <td id="kpsYa"></td>
                            <td id="kpsTidak"></td>
                          </tr>
                          <tr>
                            <th>KISI/PBI JKN</th>
                            <td id="kisYa"></td>
                            <td id="kisTidak"></td>
                          </tr>
                          <tr>
                            <th>KIP/BSM</th>
                            <td id="kipYa"></td>
                            <td id="kipTidak"></td>
                          </tr>
                          <tr>
                            <th>PKH</th>
                            <td id="pkhYa"></td>
                            <td id="pkhTidak"></td>
                          </tr>
                          <tr>
                            <th>Raskin/Rastra</th>
                            <td id="raskinYa"></td>
                            <td id="raskinTidak"></td>
                          </tr>
                      </table>
                  </div>
                  <div class="tab-pane fade" id="v-24" role="tabpanel" aria-labelledby="v-24-tab">
                      <h5 >Ruta By kelompok umur tidak tercantum dalam KK</h5>
                      <table class="table table-bordered table-hover">
                        <tr>
                          <th>Kelompok Umur</th>
                          <th>Total Rumah Tangga</th>
                        </tr>
                        <tr>
                          <th>10-20</th>
                          <td id="ada_di_kk1"></td>
                        </tr>
                        <tr>
                          <th>20-40</th>
                          <td id="ada_di_kk2"></td>
                        </tr>
                         <tr>
                          <th>40-60</th>
                          <td id="ada_di_kk3"></td>
                        </tr>
                         <tr>
                          <th>60+</th>
                          <td id="ada_di_kk4"></td>
                        </tr>
                    </table>
                    <div id="ada_di_kk" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-25" role="tabpanel" aria-labelledby="v-25-tab">
                        <h5 >Ruta By kelompok umur berdasarkan jenis identitas</h5>
                        <table class="table table-bordered table-hover">
                          <tr>
                            <th>Kelompok Umur</th>
                            <th>0-20</th>
                            <th>21-40</th>
                            <th>41-60</th>
                            <th>>61</th>

                          </tr>
                            <tr>
                              <th>Tidak Memiliki</th>
                              <td id="umur20_0"></td>
                              <td id="umur40_0"></td>
                              <td id="umur60_0"></td>
                              <td id="umur61_0"></td>
                            </tr>
                            <tr>
                            <th>Akta Kelahiran</th>
                              <td id="umur20_1"></td>
                              <td id="umur40_1"></td>
                              <td id="umur60_1"></td>
                              <td id="umur61_1"></td>
                            </tr>
                            <tr>
                                <th>KTP</th>
                                <td id="umur20_4"></td>
                                <td id="umur40_4"></td>
                                <td id="umur60_4"></td>
                                <td id="umur61_4"></td>
                            </tr>
                            <tr>
                              <th>SIM</th>
                              <td id="umur20_8"></td>
                              <td id="umur40_8"></td>
                              <td id="umur60_8"></td>
                              <td id="umur61_8"></td>
                            </tr>
                            <tr>
                              <th>Akta+KTP</th>
                              <td id="umur20_5"></td>
                              <td id="umur40_5"></td>
                              <td id="umur60_5"></td>
                              <td id="umur61_5"></td>
                            </tr>
                            <tr>
                              <th>KTP+SIM</th>
                              <td id="umur20_12"></td>
                              <td id="umur40_12"></td>
                              <td id="umur60_12"></td>
                              <td id="umur61_12"></td>
                            </tr>
                            <tr>
                              <th>Akta+SIM</th>
                              <td id="umur20_9"></td>
                              <td id="umur40_9"></td>
                              <td id="umur60_9"></td>
                              <td id="umur61_9"></td>
                            </tr>
                            <tr>
                              <th>Akta+SIM+KTP</th>
                              <td id="umur20_13"></td>
                              <td id="umur40_13"></td>
                              <td id="umur60_13"></td>
                              <td id="umur61_13"></td>
                            </tr>
                          </tr>
                     	</table>
                  </div>
                  <div class="tab-pane fade" id="v-26" role="tabpanel" aria-labelledby="v-26-tab">
                      <h5 >Ruta By kelompok umur berdasarkan status sekolah</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th>Kelompok Umur</th>
                            <th>6-12</th>
                            <th>13-19</th>
                            <th>20-24</th>
                            <th>>24</th>

                          </tr>
                          <tr>
                            <th>Belum Pernah Sekolah</th>
                            <td id="belumSekolah_u6"></td>
                            <td id="belumSekolah_u13"></td>
                            <td id="belumSekolah_u20"></td>
                            <td id="belumSekolah_u25"></td>
                          </tr>
                          <tr>
                            <th>Masih Sekolah</th>
                            <td id="sekolah_u6"></td>
                            <td id="sekolah_u13"></td>
                            <td id="sekolah_u20"></td>
                            <td id="sekolah_u25"></td>
                          </tr>
                          <tr>
                            <th>Tidak Bersekolah</th>
                            <td id="tidakSekolah_u6"></td>
                            <td id="tidakSekolah_u13"></td>
                            <td id="tidakSekolah_u20"></td>
                            <td id="tidakSekolah_u25"></td>
                          </tr>
                      </table>
                  </div>
                  <div class="tab-pane fade" id="v-27" role="tabpanel" aria-labelledby="v-27-tab">
                      <h5 >Ruta By partisipasi sekolah</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Tidak/belum pernah sekolah</th>
                            <td id="tidakSekolah"></td>
                          </tr>
                          <tr>
                            <th>Masih sekolah</th>
                            <td id="masihSekolah"></td>
                          </tr>
                          <tr>
                            <th>Tidak bersekolah lagi</th>
                            <td id="tidakSekolahLagi"></td>
                          </tr>
                      </table>
                      <div id="partisipasi_sekolah" style="margin-left:25%;"></div>
                  </div>
                  <div class="tab-pane fade" id="v-28" role="tabpanel" aria-labelledby="v-28-tab">
                      <h5 >Ruta By kelompok umur berdasarkan status kerja</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Berusaha Sendiri</th>
                            <td id="statusKerja1"></td>
                          </tr>
                          <tr>
                            <th>Berusaha dibantu buruh tidak tetap/tidak bayar</th>
                            <td id="statusKerja2"></td>
                          </tr>
                          <tr>
                            <th>berusaha dibantu tetap/dibayar</th>
                            <td id="statusKerja3"></td>
                          </tr>
                          <tr>
                            <th>Buruh/Karyawan/pegawai swasta/</th>
                            <td id="statusKerja4"></td>
                          </tr>
                          <tr>
                            <th>PNS/TNI/Polri/BUMN/BUMD/anggota legislatif</th>
                            <td id="statusKerja5"></td>
                          </tr>
                          <tr>
                            <th>Pekerja bebas pertanian</th>
                            <td id="statusKerja6"></td>
                          </tr>
                          <tr>
                            <th>Pekerja bebas non pertanian</th>
                            <td id="statusKerja7"></td>
                          </tr>
                          <tr>
                            <th>Pekerja keluarga tidak di bayar</th>
                            <td id="statusKerja8"></td>
                          </tr>
                      	</table>
                  </div>
                  <div class="tab-pane fade" id="v-29" role="tabpanel" aria-labelledby="v-29-tab">
                      <h5 >Ruta By Lapangan Usaha</h5>
                      <table class="table table-bordered table-hover">
                          <tr>
                            <th width="400px">Pertanian tanaman padai & palawija</th>
                            <td id="pekerjaan1"></td>
                          </tr>
                          <tr>
                            <th>Hortikultura</th>
                            <td id="pekerjaan2"></td>
                          </tr>
                          <tr>
                            <th>Perkebunan</th>
                            <td id="pekerjaan3"></td>
                          </tr>
                          <tr>
                            <th>Perikanan tangkap</th>
                            <td id="pekerjaan4"></td>
                          </tr>
                          <tr>
                            <th>Perikanan budidaya</th>
                            <td id="pekerjaan5"></td>
                          </tr>
                          <tr>
                            <th>Peternakan</th>
                            <td id="pekerjaan6"></td>
                          </tr>
                          <tr>
                            <th>Kehutanan & pertanian lainnnya</th>
                            <td id="pekerjaan7"></td>
                          </tr>
                          <tr>
                            <th>Pertambangan/penggalian</th>
                            <td id="pekerjaan8"></td>
                          </tr>
                          <tr>
                            <th>Industri pengolahan</th>
                            <td id="pekerjaan9"></td>
                          </tr>
                          <tr>
                            <th>Listrik dan gas</th>
                            <td id="pekerjaan10"></td>
                          </tr>
                          <tr>
                            <th>Bangunan /kontruksi</th>
                            <td id="pekerjaan11"></td>
                          </tr>
                          <tr>
                            <th>Perdagangan</th>
                            <td id="pekerjaan12"></td>
                          </tr>
                          <tr>
                            <th>Hotel & rumah makan</th>
                            <td id="pekerjaan13"></td>
                          </tr>
                          <tr>
                            <th>Transportasi & pergudangan</th>
                            <td id="pekerjaan14"></td>
                          </tr>
                          <tr>
                            <th>Informasi & komunikasi</th>
                            <td id="pekerjaan15"></td>
                          </tr>
                          <tr>
                            <th>Keuangan & asuransi</th>
                            <td id="pekerjaan16"></td>
                          </tr>
                          <tr>
                            <th>Jasa pendidikan</th>
                            <td id="pekerjaan17"></td>
                          </tr>
                          <tr>
                            <th>Jasa kesehatan</th>
                            <td id="pekerjaan18"></td>
                          </tr>
                          <tr>
                            <th>Jasa kemasyarakatan pemerintah & perorangan</th>
                            <td id="pekerjaan19"></td>
                          </tr>
                          <tr>
                            <th>Pemulung</th>
                            <td id="pekerjaan20"></td>
                          </tr>
                          <tr>
                            <th>Lainnya</th>
                            <td id="pekerjaan21"></td>
                          </tr>
                        </table>
                        <div id="lapangan_kerja" style="margin-left:25%;"></div>
                  </div>
              </div>
          </div>
      
    <!-- [ variant-chart ] end -->
	
</div>
<!-- [ Main Content ] end -->

<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/plugins/apexcharts.min.js"></script>
<script src="<?php echo base_url( THEMES_BACKEND );?>assets/js/pages/dashboard-penyajian-data.js"></script>
