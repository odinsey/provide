jQuery(document).ready(function() {
    jQuery('.form-horizontal .entity-collections .collection-field-row:before').css({
        'content': jQuery('input:first', this).val()
    });
    jQuery('div.entity-collections > .collection-fields > .collection-field-row > div.control-group').hide();
    jQuery('div.entity-collections > .collection-fields > .collection-field-row').bind('click',function(){
	    jQuery('div', this).show('slow');
	    jQuery('div.entity-collections > .collection-fields > .collection-field-row > div.control-group')
		    .not('div.control-group', this)
		    .hide('slow');
    }).css('cursor','pointer');
    
    jQuery('.add-collection-row:last').on('click',function(){
	var textarea_new = jQuery('textarea.tinymce:visible');
	tinyMCE.execCommand("mceAddControl", true, textarea_new.prop('id') );
    });
       
});
/************
 DEBUT DU SCRIPT POUR LE DRAG'N'DROP
 ************/
jQuery(document).ready(function() {
    var ul = jQuery(".list-photos");
    ul.sortable({
        placeholder: 'highlight',
        update: function() {
            jQuery('li', this).each(function(i) {
                jQuery("input[id$=_position]", this).val(i);
            });
        }
    });
    jQuery(".delete", ul).click(function() {
        jQuery(this).parent().parent().parent().remove();
        ul.sortable('refresh');
    });
    jQuery(".files .delete").click(function() {
        jQuery(this).parent().remove();
    });
});