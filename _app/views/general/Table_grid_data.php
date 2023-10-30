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

    #myProgress {
        background-color: #1a1a1a;
        height: 55px;
        padding: 3px;
        width: 100%;
        margin: 50px 0;
        border-radius: 5px;
        box-shadow: 0 1px 5px #000 inset, 0 1px 0 #444;
    }

    #myProgress  #myBar {
        display: inline-block;
        height: 100%;
        border-radius: 3px;
        box-shadow: 0 1px 0 rgba(255, 255, 255, .5) inset;
        transition: width .4s ease-in-out;
    }

    #myBar {
        background-color: #34c2e3;
        width: 100%;
        height: 30px;
        background-size: 30px 30px;
        background-image: linear-gradient(135deg, rgba(255, 255, 255, .15) 25%,
        transparent 25%,
        transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%,
        transparent 75%, transparent);
        animation: animate-stripes 3s linear infinite;
    }

    @keyframes animate-stripes {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 60px 0;
        }
    }

    .center {
        position: absolute;
        left: 50%;
        top: 75%;
        transform: translate(-50%, -50%);
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
			<div id="response_message" style="display:none;"></div>
			<table id="gridview" style="display:none;"></table>

			<div id="loader" class="modal-backdrop">
				<div class="spin">
					<span class="fa fa-spinner fa-spin fa-4x"></span>
				</div>
				<span class="text">Loading...</span>
			</div>
		</div>
	</div>

<div class="modal" id="modalForm">
	<div class="modal-dialog modal-lg">
		<div id="modalContent" class="modal-content">
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade center" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5>Direvoke dengan foto ?</h5>
                <!-- <textarea name="arr_id" id="arr_id"></textarea><br> -->
                <p>

                    <p>Keterangan alur revoke : </p><br />
                    <img src="<?=base_url('assets/style/icon-status/hex-10-yellow.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-10a-red-white.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-07-brown.png')?>"><br /><br />
                    <img src="<?=base_url('assets/style/icon-status/hex-09-orange.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-09a-red-white.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-07-brown.png')?>"<br /><br /><br />
                    <img src="<?=base_url('assets/style/icon-status/hex-08-maroon.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-08a-red-white.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-07-brown.png')?>"<br /><br /><br />
                    <img src="<?=base_url('assets/style/icon-status/hex-05-yellow.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-05a-red-white.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-01-gray.png')?>"<br /><br /><br />
                    <img src="<?=base_url('assets/style/icon-status/hex-04-orange.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-04a-red-white.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-01-gray.png')?>"<br /><br /><br />
                    <img src="<?=base_url('assets/style/icon-status/hex-03-maroon.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-03a-red-white.png')?>"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="<?=base_url('assets/style/icon-status/hex-01-gray.png')?>"<br />
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-info" data-dismiss="modal" onclick="revoke_foto('ya')">Ya</button>
                <button class="btn btn-sm btn-info" data-dismiss="modal" onclick="revoke_foto('tidak')">Tidak</button>


                <input type="hidden" name="arr_id" id="arr_id">
                <input type="hidden" name="gridid" id="gridid">
                <input type="hidden" name="comid" id="comid">
            </div>
        </div>

    </div>
</div>
<div class="modal fade center" id="modalLoaderabe" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

        <div id="myProgress">
            <div id="myBar" class="text-center p-2"></div>
        </div>

    </div>
</div>
<textarea value="Hello World" id="myInput" readonly style="width:1px;height:1px;overflow:auto;"></textarea>

<script type="text/javascript" src="<?php echo base_url( 'assets/addons/daterangepicker/moment.js' );?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/select2/select2.js' );?>"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/daterangepicker/daterangepicker.js' );?>"></script>
<script type="text/javascript" src="<?php echo base_url( 'assets/addons/flexigrid/js/flexigrid-ed.js' );?>"></script>

<script>
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

	function add(com, grid, urlaction) {
		show_form( urlaction );
	}

	function show_form( url ){
		window.open(url);
        return false;
	}

	$(document).ready(function() {
		$(document).on( 'click', '#btn_save', function() {
			$.ajax({
				url: $( '#form-data' ).attr( 'action' ),
				type: 'POST',
				dataType: 'json',
				data: $('#form-data').serialize(),
				beforeSend: function( xhr ) {
					$('#modalLoader').modal('show');
				},
				success : function(data) {
					if ( data.status == 200 ) {
						$('#modalForm').modal('hide');
						$('#gridview').flexReload();
						$('#response_message').html(data.msg).show().addClass('alert alert-success');
					} else {
						alert(data.msg);
					}
				},
			});
		});

		$(document).on( 'click', 'button.btn-edit', function(){
			show_form( $(this).attr('act') );
		});

		$("#response_message").fadeTo(2000, 500).slideUp(500, function(){
			$("#response_message").slideUp(500);
		});

        <?php if ( isset( $cari ) ) { ?>
    		$('#panel_header').on( 'click', function(){
    			$('.search-arrow').toggleClass('fa-caret-square-right fa-caret-square-down')
    			$('#search_body').slideToggle( "slow", function() {
    			});
    			$('#search_footer').slideToggle( "slow", function() {
    			});
    		});
        <?php } ?>
	});

    function paste_id() {
        var text = prompt("Cari is in ...", "");
        if (text != null) {
            $("#load_page").removeClass("hidden");
            $("#loader").modal("show");
            $( "#gridview" ).flexOptions({
                url: "<?php echo $paste_url ?>get_show_data",
                params: [
                    {
                        "province_id": $( "#select-propinsi ").val(),
                        "regency_id": $( "#select-kabupaten ").val(),
                        "district_id": $( "#select-kecamatan ").val(),
                        "village_id": $( "#select-kelurahan ").val(),
                        "stereotype": $( "#select-status ").val(),
                        "status_rumahtangga": $( "#select-hasil-musdes ").val(),
                        "hasil_verivali": $( "#select-hasil-verivali ").val(),
                        "id_prelist": text,
                        "is_in" : 1,
                    },
                ],
            }).flexReload();
            $("#loader").modal("hide");
        }
    }

    function not_in_id() {
        var text = prompt("Cari not in ...", "");
        if (text != null) {
            $("#load_page").removeClass("hidden");
            $("#loader").modal("show");
            $( "#gridview" ).flexOptions({
                url: "<?php echo $paste_url ?>get_show_data",
                params: [
                    {
                        "province_id": $( "#select-propinsi ").val(),
                        "regency_id": $( "#select-kabupaten ").val(),
                        "district_id": $( "#select-kecamatan ").val(),
                        "village_id": $( "#select-kelurahan ").val(),
                        "stereotype": $( "#select-status ").val(),
                        "status_rumahtangga": $( "#select-hasil-musdes ").val(),
                        "hasil_verivali": $( "#select-hasil-verivali ").val(),
                        "id_prelist": text,
                        "is_in" : 0,
                    },
                ],
            }).flexReload();
            $("#loader").modal("hide");
        }
    }

    function copy_id(com, grid, urlaction) {
    	var grid_id = $(grid).attr('id');
    	grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
    	if (urlaction == '') {
    		urlaction = 'copy_id';
    	}
        if ($('.trSelected', grid).length > 0) {
            var arr_id = [];
            var i = 0;
            $('.trSelected', grid).each(function () {
                var id = $(this)[0].cells[1].innerText;
                arr_id.push(id);
                i++;
            });
            bdt_id = '';
            data_where = '';
            for(a=0;a<arr_id.length;a++)
            {
                row = arr_id[a];
                data_where = data_where + '"' + row + '",';
                bdt_id = bdt_id + row + "\n";
            }

            $('#myInput').val(bdt_id);
            myFunction();

            alert("ID PRELIST berikut berhasil di copy: \n\n"+bdt_id);
        }
    }

    function myFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");

    }

</script>
<?php
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
