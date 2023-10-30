<div class="col-md-12">
    <table id="grid"></table>
    <div id="dialog" style="width:60%;height:480px;max-width:90%;display:none;"></div>
</div>

<div id="detail-image" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div id="content-body"></div>
            </div>
        </div>
    </div>
</div>
<div id="loading" style="display: none;position: fixed;top:0;left:0;width:100%;height:100%;background: #000000b5;z-index: 9999;">
    <i class="fa fa-spinner fa-spin" style="font-size: 6em;color:#fff;top:50%;left:50%;position:absolute;"></i>
</div>

<script type="text/javascript">
class Tabel {
    constructor(table) {
        this.table = table;
        self = this;
        this.gd = $('#'+this.table).datagrid();
    }

    generate(){
        var a = $('#'+this.table).datagrid({
            url: '<?php echo $grid['link_data'];?>',
            columns:[[<?php echo $grid['columns'];?>]],
            toolbar: [
            <?php if ( in_array( 'add', $grid['toolbar'] ) ) { ?>
                {text:'<i class="fa fa-plus"></i>&nbsp;Tambah',
                handler: function(){
                    let params = {
                        'formTitle':'<i class="fa fa-plus-square"></i>&nbsp;Tambah <?php echo $grid['title'];?>',
                        '<?php echo $grid['col_id'];?>': '',
                    };
                    self.form( params );
                }},'-',
            <?php } ?>
            <?php if ( in_array( 'edit', $grid['toolbar'] ) ) { ?>
                {text:'<i class="fa fa-edit"></i>&nbsp;Ubah', handler: function(){
                    let row = $('#grid').datagrid('getSelections');
                    if ( row.length == 1 ) {
                        let params = {
                            'formTitle':'<i class="fa fa-edit"></i>&nbsp;Ubah <?php echo $grid['title'];?>',
                            '<?php echo $grid['col_id'];?>': row[0][<?php echo $grid['col_id'];?>],
                        };
                        self.form(params);
                    } else {
                        $.messager.alert({
                            title: 'Error',
                            msg: 'Please select one row data!',
                            icon:' fa fa-exclamation-circle fa-2x',
                            style:{
                                right:'',
                                bottom:'',
                                color:'red'
                            }
                        });
                    }
                }},'-',
            <?php } ?>
            <?php if ( in_array( 'enable', $grid['toolbar'] ) ) { ?>
                {text:'<i class="mdi mdi-lightbulb-on" style="color:#d6cb22;"></i>&nbsp;Enable',
                handler: function() {
                    self.changeStatus('1');
                }},'-',
            <?php } ?>
            <?php if ( in_array( 'disable', $grid['toolbar'] ) ) { ?>
                {text:'<i class="mdi mdi-lightbulb"></i>&nbsp;Disable',
                handler: function() {
                    self.changeStatus('0');
                }},'-',
            <?php } ?>
            <?php if ( in_array( 'order_up', $grid['toolbar'] ) ) { ?>
                {text:'<i class="fa fa-arrow-up"></i>&nbsp;Up',
                handler: function() {
                    self.changeOrder('up');
                }},'-',
            <?php } ?>
            <?php if ( in_array( 'order_down', $grid['toolbar'] ) ) { ?>
                {text:'<i class="fa fa-arrow-down"></i>&nbsp;Down',
                handler: function() {
                    self.changeOrder('down');
                }},'-',
            <?php } ?>
            <?php if ( in_array( 'remove', $grid['toolbar'] ) ) { ?>
                {text:'<i class="fa fa-trash"></i>&nbsp;Delete',
                handler:function(){
                    self.removeData();
                }},'-',
            <?php } ?>
            ],
            method:'POST',
            fitColumns:false,
            remoteFilter: true,
            clientPaging: false,
            singleSelect: <?php echo ( ( isset( $grid['single_select'] ) ) ? $grid['single_select'] : 'false' );?>,
            collapsible:true,
            pagination: true,
            rownumbers: true,
            idField:'<?php echo $grid['col_id'];?>',
            sortName:'<?php echo $grid['col_sort'];?>',
            sortOrder:'<?php echo ( ( isset( $grid['order_type'] ) ) ? $grid["order_type"] : "asc" );?>',
            // pageSize:5,
            pageList:[10,25,50,100],
            title: '<i class="fa fa-table"></i>&nbsp;Tabel <?php echo ( ( isset( $grid['title'] ) ) ? $grid["title"] : "" );?>',
            autoRowHeight:true,
            height:450,
            width:'100%',
            queryParams: {
            	filterRules: '',
            },
        });
        self.filtering();
    }

    filtering(){
        this.gd.datagrid('enableFilter', [
            {
                field:'menu_is_active',
                type:'combobox',
                options:{
                    panelHeight:'auto',
                    data:[{value:'',text:'All'},{value:'1',text:'Active'},{value:'0',text:'Inactive'}],
                    onChange:function(value){
                        if (value == ''){
                            gd.datagrid('removeFilterRule', 'menu_is_active');
                        } else {
                            gd.datagrid('addFilterRule', {
                                field: 'menu_is_active',
                                op: 'equal',
                                value: value
                            });
                        }
                        gd.datagrid('doFilter');
                    }
                }
            },
            {
                field:'theme_created_at',
                type:'datebox',
                options:{precision:1},
                op:['less','greater']
            },{
                field:'theme_updated_at',
                type:'datebox',
                options:{precision:1},
                op:['less','greater']
            }
        ]);
    }

    form(params){
        let width = $(window).width() * 0.75;
        console.log(width * 0.5);
        $('#dialog').dialog({
            title: params.formTitle,
            width: width,
            closed: false,
            cache: false,
            href: '<?php echo base_url();?>admin/config/menu/get_form/'+params['<?php echo $grid['col_id'];?>'],
            modal: true,
            resizable:true,
            toolbar: '#toolbar',
            buttons:[{
				text:'<i class="fa fa-save"></i>&nbsp;Save',
				handler:  function(){
                    self.saveData(params['<?php echo $grid['col_id'];?>']);
                }
			},{
				text:'<i class="fa fa-close"></i>&nbsp;Close',
				handler:function(){$('#dialog').dialog('close');}
			}]
        });
    }
/*

    saveData( theme_id = '' ){
        var link;
        if ( theme_id === '') {
            link = '<?php //echo base_url();?>admin/theme/act_add';
        } else {
            link = '<?php //echo base_url();?>admin/theme/act_update/' + theme_id;
        }
        // e.preventDefault();
        //var formData = new FormData('#form-data');
        // $('#form-data').form('submit', function(e) {
        $('#form-data').form('submit', {
            url: link,
            onSubmit:function(){
                $('#loading').show();
                let validate = $(this).form('enableValidation').form('validate');
                if (!validate) {
                    $('#loading').hide();
                    $.messager.alert({
                        title: 'Error',
                        msg: "Isian belum lengkap!<br>Silahkan periksa semua isian.",
                        icon:' fa fa-exclamation-circle fa-2x',
                        style:{
                            right:'',
                            bottom:'',
                            color:'red'
                        }
                    });
                }
                return validate;
            },
            beforeSend:function(){
            },
            success:function( result ) {
                result = result.replace(/(<([^>]+)>)/ig,"");
                var result = eval('('+result+')');
                $('#loading').hide();
                if (result.errorMsg){
                    var errorMsg = $('<div/>').html(result.errorMsg).text();
                    $.messager.alert({
                        title: 'Error',
                        msg: errorMsg,
                        icon:' fa fa-exclamation-circle fa-2x',
                        style:{
                            right:'',
                            bottom:'',
                            color:'red'
                        }
                    });
                } else {
                    var msg = $('<div/>').html(result.msg).text();
                    $.messager.alert({
                        title: 'Information',
                        msg: msg,
                        icon:' fa fa-info-circle fa-2x',
                        style:{
                            right:'',
                            bottom:'',
                            color:'blue'
                        }
                    });
                    $('#dialog').dialog('close');
                    $('#grid').datagrid('reload');
                }
            }
        });
    }

    changeStatus( status ){
        var row = $('#grid').datagrid('getSelections');
        if ( row.length > 0 ) {
            var arr_id = {};
            $.each( row, function( index, value ) {
                arr_id[value.theme_id] = status;
            });
            $.ajax({
                url: '<?php //echo site_url('admin/theme/act_update_status'); ?>',
                method: 'POST',
                data: {
                    'arr_id': arr_id
                },
                dataType: 'json',
                success: function (result) {
                    var errorMsg = $('<div/>').html(result.errorMsg).text();
                    if (result.errorMsg){
                        $.messager.alert({
                            title: 'Error',
                            msg: errorMsg,
                            icon:' fa fa-exclamation-circle fa-2x',
                            style:{
                                right:'',
                                bottom:'',
                                color:'red'
                            }
                        });
                    } else {
                        var msg = $('<div/>').html(result.msg).text();
                        $.messager.show({
                            title: 'Information',
                            msg: msg,
                            icon:' fa fa-info-circle fa-2x',
                            style:{
                                right:'',
                                bottom:'',
                                color:'blue'
                            }
                        });
                        $('#grid').datagrid('reload');
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
            $('#datagrid').datagrid('reload');
        } else{
            $.messager.alert({
                title: 'Error',
                msg: 'Anda belum memilih data!',
                icon:' fa fa-exclamation-circle fa-2x',
                style:{
                    right:'',
                    bottom:'',
                    color:'red'
                }
            });
        }
    }

    removeData(){
        var rows = $('#grid').datagrid('getSelections');
        if (rows.length){
            $.messager.confirm('Confirm','Are you sure to remove ?',function(r){
                if (r){
                    var arr_id = [];
                    for(var i=0; i<rows.length; i++){
                        var row = rows[i];
                        arr_id.push(row.theme_id);
                    }
                    $.ajax({
                        url: '<?php //echo site_url('admin/theme/act_delete'); ?>',
                        method: 'POST',
                        data: {
                            'type': 'delete',
                            'arr_id': arr_id
                        },
                        dataType: 'json',
                        success: function (result) {
                            if (result.errorMsg){
                                var errorMsg = $('<div/>').html(result.errorMsg).text();
                                $.messager.alert({
                                    title: 'Error',
                                    msg: errorMsg,
                                    icon:' fa fa-exclamation-circle fa-2x',
                                    style:{
                                        right:'',
                                        bottom:'',
                                        color:'red'
                                    }
                                });
                            } else {
                                var msg = $('<div/>').html(result.msg).text();
                                $.messager.show({
                                    title: 'Information',
                                    msg: msg,
                                    icon:' fa fa-info-circle fa-2x',
                                    style:{
                                        right:'',
                                        bottom:'',
                                        color:'blue'
                                    }
                                });
                                $('#grid').datagrid('reload');
                            }
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                    $('#datagrid').datagrid('reload');
                }
            });
        }else{
            $.messager.alert('Info', "Pilih data yang ingin dihapus");
        }
    }

    act_hover(){
        $(document).on( 'click', '.thumbnail-theme', function(){
            let src = $(this).attr('src');
            $('#content-body').html(`<img src="${src}" width="100%">`);
            $('#detail-image').modal('show');
        });
    }*/
}

$(document).ready(function () {
    let table = new Tabel('grid');
    table.generate();
    // table.act_hover();
});
</script>
