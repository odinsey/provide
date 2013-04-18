jQuery(function() {
    jQuery('.form-horizontal .entity-collections .collection-field-row:before').css({
        'content': jQuery('input:first',this).val()
    });
});
