'use strict';
$(document).ready(function() {
    $("#loader").css({display:"block"});
    var map = null;
    var base_url =$("#base_url").val(); 

    
    if($('#select-propinsi').val() != 0){
        loadMap();
    }else{
        loadPropinsiMap(); 
    }
    $(".detail-map").hide();

    $("#cari").on("click",function(){
        if(map !== null) map.remove(); 
        if($('#select-propinsi').val() != 0){
            loadMap();
        }else{
            loadPropinsiMap();
        }
    });
    $(".close-bar").on("click",function(){ 
        $(".detail-map").css({display:"none"});
    });
    function loadMap(){
        map = L.map( 'map', {
         center: [-0.789275, 113.92132700000002],
         minZoom: 2,
         zoom: 4
        });

        L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        subdomains: ['a','b','c']
        }).addTo( map );


        var myIcon = L.icon({
         iconUrl: base_url + 'assets/style/maps/pin24.png',
         iconRetinaUrl: base_url + 'assets/style/maps/pin48.png',
         iconSize: [29, 24],
         iconAnchor: [9, 21],
         popupAnchor: [0, -14]
        });

        var markerClusters = L.markerClusterGroup({
            showCoverageOnHover: false, 
            spiderLegPolylineOptions: {opacity: 0}

        });
        var filter_area = {
          kd_prop:$('#select-propinsi').val(),
          kd_kab:$('#select-kabupaten').val(),
          kd_kec:$('#select-kecamatan').val()
        }
        
        $.ajax({
            url: base_url+"admin/maps/getLatLongPrelist",
            type: "POST",
            data:filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#loader").css({display:"block"});
            },
            success : function(data) {
                $("#loader").css({display:"none"});
                for ( var i = 0; i < data.length; ++i )
                { 
                    if(data[i].lat !== null && data[i].long !== null && data[i].lat !== '' && data[i].long !== ''){
                        var m = L.marker( [data[i].lat, data[i].long], {icon: myIcon,id: data[i].proses_id} );
                        m.on('click', function(e){
                            getDetailPrelist(e);
                        });
                        var arrayOfLatLngs = [];
                        arrayOfLatLngs.push([data[i].lat, data[i].long]); 
                        markerClusters.addLayer( m );
                    }
                   
                }

               
                console.log(map.getZoom());
                if($('#select-propinsi').val() > 0){
                    var bounds = new L.LatLngBounds(arrayOfLatLngs);
                    map.fitBounds(bounds);
                    map.setZoom(map.getZoom() - 10);
                }
                if($('#select-propinsi').val() > 0 && $('#select-kabupaten').val() > 0){
                    var bounds = new L.LatLngBounds(arrayOfLatLngs);
                    map.fitBounds(bounds);
                    map.setZoom(map.getZoom() - 5);
                }
            }
        }); 

        map.addLayer( markerClusters );
       
    }
    function loadPropinsiMap(){
        $("#loader").css({display:"none"});
        map = L.map( 'map', {
         center: [-0.789275, 113.92132700000002],
         minZoom: 2,
         zoom: 4
        });

        L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        subdomains: ['a','b','c']
        }).addTo( map ); 

         $.ajax({
            url: base_url+"admin/maps/getLatLongPropinsi",
            type: "POST", 
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#loader").css({display:"block"});
            },
            success : function(data) {
                $("#loader").css({display:"none"});
                for ( var i = 0; i < data.length; ++i )
                { 
                    var marker = L.marker([data[i].lat, data[i].long],{id: data[i].kode_propinsi,name: data[i].nm_propinsi,total: data[i].total}).addTo(map);
                    marker.on('click', function(e){
                        getDetailPropinsi(e);
                    });

                    marker.on('mouseover', function(e) { 
                        this.bindPopup(e.target.options.name+" :"+e.target.options.total+" RUTA").openPopup();
                    }) 
                } 
                
            }
        }); 
       
    }


    function getDetailPrelist(e){
        console.log(e);
        var filter_area = {
          kd_prop:$('#select-propinsi').val(),
          kd_kab:$('#select-kabupaten').val(),
          proses_id:e.target.options.id,
          kd_kec:$('#select-kecamatan').val()
        }
        $.ajax({
            url: base_url+"admin/maps/getDetailPrelist",
            type: "POST",
            data:filter_area,
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#loader").css({display:"block"});
            },
            success : function(data) {
                $("#loader").css({display:"none"});
                $(".detail-map").css({display:"block"});

                $("#nama_krt").html("Nama : "+data.rt.nama_krt);
                $("#alamat").html("Alamat : "+data.rt.alamat);
                var jk = "Laki-Laki";
                if(data.rt.jenis_kelamin_krt == 2){
                    jk = "Perempuan";
                }

                var status_rumahtangga = "Ditemukan";
                if(data.rt.status_rumahtangga == 4){
                    status_rumahtangga = "Usulan Baru";
                }
                var apakah_mampu = "Ya";
                if(data.rt.apakah_mampu == 2){
                    apakah_mampu = "Tidak";
                }
                $("#jenis_kelamin_krt").html(": "+jk);
                $("#nomor_nik").html(": "+data.rt.nomor_nik);
                $("#jumlah_keluarga").html(": "+data.rt.jumlah_keluarga);
                $("#jumlah_art").html(": "+data.rt.jumlah_art);
                $("#lat").html(": "+data.rt.lat);
                $("#long").html(": "+data.rt.long);
                $("#propinsi").html(": "+data.rt.propinsi);
                $("#kabupaten").html(": "+data.rt.kabupaten);
                $("#kecamatan").html(": "+data.rt.kecamatan);
                $("#kelurahan").html(": "+data.rt.kelurahan);
                $("#status_rumahtangga").html(": "+status_rumahtangga);
                $("#apakah_mampu").html(": "+apakah_mampu);     
                var date = new Date(data.rt.lastupdate_on);

                var year = date.getFullYear();
                var month = date.getMonth()+1;
                var indo_month = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']
                var day = date.getDate(); 
                $("#tgl_interview").html(": "+day+" "+indo_month[month-1]+" "+year);
                $("#interview_duration_ms").html(": "+data.rt.interview_duration);                 
                
                $("#status_kks").html(": "+data.rt.status_kks);
                $("#status_rastra").html(": "+data.rt.status_rastra);
                $("#status_kip").html(": "+data.rt.status_kip);
                $("#status_kis").html(": "+data.rt.status_kis);
                $("#status_pkh").html(": "+data.rt.status_pkh);

                if(data.kk.length > 1){

                    $("#no_kk").html(": "+data.kk[0].nokk);
                }else{
                    $("#no_kk").html(": - ");
                }
                var base_photo_url = $("#base_photo_url").val();
                var html_foto = "";
                for (var i = 0; i < data.foto.length; i++) {
                    if(i == 0){
                        html_foto += '<div class="carousel-item active">'+
                              '<img class="d-block w-100" src="'+base_photo_url+data.foto[i].internal_filename+'">'+
                                '<div class="carousel-caption d-md-block">'+
                                   '<h5>'+data.foto[i].stereotype+'</h5> '+
                                  '</div>'+
                            '</div>';
                    }else{
                        html_foto += '    <div class="carousel-item">'+
                              '<img class="d-block w-100" src="'+base_photo_url+data.foto[i].internal_filename+'">'+
                                '<div class="carousel-caption d-md-block">'+
                                   '<h5>'+data.foto[i].stereotype+'</h5> '+
                                  '</div>'+
                            '</div>';
                    }

                }

                $("#foto").html(html_foto);
            }
        });
    }

    function getDetailPropinsi(e){ 
        var kode_propinsi = e.target.options.id;
        // console.log(kode_propinsi);

        // $("#select-propinsi").val(kode_propinsi);
        // $("#select-propinsi").select2("val", kode_propinsi);

        $("#select-propinsi").val(kode_propinsi).trigger("change");
        if(map !== null) map.remove(); 
        loadMap();
    }
});
