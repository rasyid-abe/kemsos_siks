<?php
if ( isset( $extra_style ) ) {
    echo $extra_style;
}
    echo '
<div class="modal-header">
    <h5 id="modelHeader" class="modal-title">' . $form_title . '</h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div id="modalBody" class="modal-body">
    <div class="col-12">
    ';
    if ( isset( $form_is_multi ) ) {
        echo '
        <form id="form-data" action="' . $form_action . '" enctype="multipart/form-data" accept-charset="utf-8" method="post">';
    } else {
        echo '
        <form id="form-data" action="' . $form_action . '" accept-charset="utf-8" method="post">';
    }

    echo ( ( isset( $form_data ) ) ? $form_data : '' );

    echo '
        </form>
    </div>
    <div class="modal-footer">
        <button id="btn_save" type="button" class="btn btn-primary btn-sm">Simpan</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
    </div>
</div>';
if ( isset( $extra_script ) ) {
    echo $extra_script;
}
?>
