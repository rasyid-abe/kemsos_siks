<link rel="stylesheet" type="text/css" href="<?php echo base_url( 'assets/addons/flexigrid/css/flexigrid.css' );?>">
<style>
#loader{display: none; opacity: 0.5; } .spin {position: absolute; left: 50%; top: 50%; z-index: 1; color: #fff; } .text {color:#fff; font-size: 20px; position: absolute; left: 49%; bottom: 30%; }.hasDateRange{z-index: 1100 !important;}

.hidden {display: none}
/* Absolute Center Spinner */
.load_page {
    position: fixed;
    z-index: 999;
    height: 2em;
    width: 2em;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
}

/* Transparent Overlay */
.load_page:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

    background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.load_page:not(:required) {
    /* hide "loading..." text */
    font: 0/0 a;
    color: transparent;
    text-shadow: none;
    background-color: transparent;
    border: 0;
}

.load_page:not(:required):after {
    content: '';
    display: block;
    font-size: 10px;
    width: 1em;
    height: 1em;
    margin-top: -0.5em;
    -webkit-animation: spinner 150ms infinite linear;
    -moz-animation: spinner 150ms infinite linear;
    -ms-animation: spinner 150ms infinite linear;
    -o-animation: spinner 150ms infinite linear;
    animation: spinner 150ms infinite linear;
    border-radius: 0.5em;
    -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
    box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
@-moz-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
@-o-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
@keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

/* .table-wrapper{
    margin: 10px 70px 70px;
    box-shadow: 0px 35px 50px rgba( 0, 0, 0, 0.2 );
} */

.fl-table {
    border-radius: 5px;
    font-size: 12px;
    font-weight: normal;
    border: none;
    border-collapse: collapse;
    width: 100%;
    max-width: 100%;
    white-space: nowrap;
    background-color: white;
}

.fl-table td, .fl-table th {
    text-align: center;
    padding: 8px;
}

.fl-table td {
    border-right: 1px solid #f8f8f8;
    font-size: 12px;
}

.fl-table thead th {
    color: #ffffff;
    background: #4FC3A1;
}


.fl-table thead th:nth-child(odd) {
    color: #ffffff;
    background: #324960;
}

.fl-table tr:nth-child(even) {
    background: #F8F8F8;
}

/* Responsive */

@media (max-width: 767px) {
    .fl-table {
        display: block;
        width: 100%;
    }
    /* .table-wrapper:before{
        content: "Scroll horizontally >";
        display: block;
        text-align: right;
        font-size: 11px;
        color: white;
        padding: 0 0 10px;
    } */
    .fl-table thead, .fl-table tbody, .fl-table thead th {
        display: block;
    }
    .fl-table thead th:last-child{
        border-bottom: none;
    }
    .fl-table thead {
        float: left;
    }
    .fl-table tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .fl-table td, .fl-table th {
        padding: 20px .625em .625em .625em;
        height: 60px;
        vertical-align: middle;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
        width: 120px;
        font-size: 13px;
        text-overflow: ellipsis;
    }
    .fl-table thead th {
        text-align: left;
        border-bottom: 1px solid #f7f7f9;
    }
    .fl-table tbody tr {
        display: table-cell;
    }
    .fl-table tbody tr:nth-child(odd) {
        background: none;
    }
    .fl-table tr:nth-child(even) {
        background: transparent;
    }
    .fl-table tr td:nth-child(odd) {
        background: #F8F8F8;
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tr td:nth-child(even) {
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tbody td {
        display: block;
        text-align: center;
    }
}

</style>
<div class="load_page" id="load_page">Loading&#8230;</div>
<?php
if ( isset( $extra_style ) ) {
    echo $extra_style;
}
?>
	<div class="card">
		<div class="card-body">
            <?php
            if ( isset( $cari ) ) {
            ?>
            	<?php echo $cari;?>
            <?php
            }
            ?>
            <!-- <div class="table-wrapper"> -->
            <div id="response_message" style="display:none;"></div>
            <table id="gridview" style="display:none;"></table>
                <div id="tabel_msign"></div>
            <!-- </div> -->
		</div>
	</div>


<script type="text/javascript" src="<?php echo base_url( 'assets/addons/daterangepicker/moment.js' );?>"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/select2/select2.js' );?>"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/daterangepicker/daterangepicker.js' );?>"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/flexigrid/js/flexigrid-ed.js' );?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>

<script type="text/javascript">

    $( document ).ready(function() {
        $("#load_page").addClass("hidden");
    });

    function generate_table(body, foot) {
        var table = `
        <table class="mt-3 fl-table">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center">No</th>
                    <th rowspan="2" class="text-center">Nama Kecamantan</th>
                    <th colspan="7" class="text-center">Status Hasil Verifikasi dan Validasi (Rumah Tangga)</th>
                </tr>
                <tr>
                    <th style="word-break: break-all;" class="text-center">Selesai Diverifikasi dan Divalidasi</th>
                    <th style="word-break: break-all;" class="text-center">Tidak Ditemukan</th>
                    <th style="word-break: break-all;" class="text-center">Pindah/Bangunan Tidak Ada</th>
                    <th style="word-break: break-all;" class="text-center">Data Ganda/Bagian dari Rumah Tangga</th>
                    <th style="word-break: break-all;" class="text-center">Menolak</th>
                    <th style="word-break: break-all;" class="text-center">Usulan Baru</th>
                    <th style="word-break: break-all;" class="text-center">Total Rumah Tangga Valid</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center">a</td>
                    <td class="text-center">b</td>
                    <td class="text-center">c</td>
                    <td class="text-center">d</td>
                    <td class="text-center">e</td>
                    <td class="text-center">f</td>
                    <td class="text-center">g = ( a + f )</td>
                </tr>
                ${body}
            </tbody>
            <thead>
                <tr>
                <th class="text-center" ></th>
                <th class="text-center" >TOTAL</th>
                <th class="text-right">${numFormat(foot[0])}</th>
                <th class="text-right">${numFormat(foot[1])}</th>
                <th class="text-right">${numFormat(foot[2])}</th>
                <th class="text-right">${numFormat(foot[3])}</th>
                <th class="text-right">${numFormat(foot[4])}</th>
                <th class="text-right">${numFormat(foot[5])}</th>
                <th class="text-right">${numFormat(foot[6])}</th>
                </tr>
            </thead>
        </tabel>
        `;
        $('#tabel_msign').html(table);
    }

    function generate_content(data) {
        content = '';
        a = b = c = d = e = f = g = 0;

        no = 1;
        $.each(data, function(i, val) {
            if (val.name != null) {
                content += `
                    <tr>
                        <td class="text-center">${no}</td>
                        <td>${val.name}</td>
                        <td class="text-right">${numFormat(val.a)}</td>
                        <td class="text-right">${numFormat(val.b)}</td>
                        <td class="text-right">${numFormat(val.c)}</td>
                        <td class="text-right">${numFormat(val.d)}</td>
                        <td class="text-right">${numFormat(val.e)}</td>
                        <td class="text-right">${numFormat(val.f)}</td>
                        <td class="text-right">${numFormat(val.a + val.f)}</td>
                    </tr>
                `;

                a += val.a;
                b += val.b;
                c += val.c;
                d += val.d;
                e += val.e;
                f += val.f;
                g += val.a + val.f;

                no++;
            }
        });

        foot = [a, b, c, d, e, f, g];
        generate_table(content, foot);
    }

    function ajax_req(type) {
        $.ajax({
            url: '<?php echo $url_ajax ?>',
            dataType : 'json',
            data : {
                regency: $( "#select-kabupaten ").val(),
                type: type,
            },
            type : 'post',
            success: function(res) {
                if (res != 1 && res != 2 && res != 3 && res != 4) {
                    generate_content(res);
                }
                if (res == 1) {
                    alert("Berhasil!, Dokumen PDF Berhasil di Generate");
                } else if (res == 2) {
                    alert("Gagal!, Dokumen PDF Gagal di Generate");
                } else if (res == 3) {
                    alert("Gagal!, Dokumen PDF Sudah Pernah di Generate");
                } else if (res == 4) {
                    alert("Gagal!, Seluruh Prelist harus mencapat status 14");
                }
                $("#load_page").addClass("hidden");
            }
        });
    }

    $( "button#cari" ).on( "click", function(){
        if ( $( "#select-kabupaten ").val() > 0 ) {
            $("#load_page").removeClass("hidden");
            ajax_req(0)
            $( "button#process" ).removeClass("hidden");
            $( "#grid_gridview" ).addClass("hidden");

        } else {
            alert('Anda harus memilih sampai provinsi.');
        }
    });

    $( "button#process" ).on( "click", function(){
        if ( $( "#select-kabupaten ").val() > 0 ) {
            ajax_req(1)
            $("#load_page").removeClass("hidden");
        } else {
            alert('Anda harus memilih sampai provinsi.');
        }
    });

    $( "button#history" ).on( "click", function(){
        $("#tabel_msign").html("");
        $( "#grid_gridview" ).removeClass("hidden");
        $("#gridview").flexigrid({
    		url: '<?php echo $grid['link_data']; ?>',
    		dataType: 'json',
    		colModel: [<?php echo $grid['columns'];?>],
    		buttons: [<?php echo $grid['toolbars'];?>],
    		searchitems: [<?php echo $grid['filters'];?>],
    		sortname: "<?php echo $grid['col_id'];?>",
    		sortorder: "<?php echo ( ( isset( $grid['sort'] ) ) ? $grid['sort'] : 'asc' );?>",
    		usepager: true,
    		title: '',
    		useRp: true,
    		rp: 50,
    		showTableToggleBtn: false,
    		showToggleBtn: true,
    		width: 'auto',
    		height: '500',
    		resizable: false,
    		singleSelect: false
    	});
    })


    function numFormat(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
