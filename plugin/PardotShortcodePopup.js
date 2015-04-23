var PardotShortcodePopup = {
	init:function() {},
	insert:function() {
		console.log("hello");
		if ( ( jQuery('#formshortcode').length != 0 ) && ( jQuery('#formshortcode').val() != '0' ) ) {
			var formval = jQuery('#formshortcode').val();
			var formheight = jQuery('#formh').val();
			if ( formheight ) {
				formval = formval.replace('pardot-form', 'pardot-form height="'+formheight+'"')
			}
			var formwidth = jQuery('#formw').val();
			if ( formwidth ) {
				formval = formval.replace('pardot-form', 'pardot-form width="'+formwidth+'"')
			}
			var formclass = jQuery('#formc').val();
			if ( formclass ) {
				formval = formval.replace('pardot-form', 'pardot-form class="'+formclass+'"')
			}
			tinyMCEPopup.editor.execCommand('mceInsertContent',false,formval);
		}
		if ( ( jQuery('#dcshortcode').length != 0 ) && ( jQuery('#dcshortcode').val() != '0' ) ) {
		    var dcval = jQuery('#dcshortcode').val();
			var dcheight = jQuery('#dch').val();
			if ( dcheight ) {
				dcval = dcval.replace('pardot-dynamic-content', 'pardot-dynamic-content height="'+dcheight+'"')
			}
			var dcwidth = jQuery('#dcw').val();
			if ( dcwidth ) {
				dcval = dcval.replace('pardot-dynamic-content', 'pardot-dynamic-content width="'+dcwidth+'"')
			}
			var dcclass = jQuery('#dcc').val();
			if ( dcclass ) {
				dcval = dcval.replace('pardot-dynamic-content', 'pardot-dynamic-content class="'+dcclass+'"')
			}
			tinyMCEPopup.editor.execCommand('mceInsertContent',false,dcval);
		}
		tinyMCEPopup.close();
	
	}
};
tinyMCEPopup.onInit.add(PardotShortcodePopup.init,tinymce.plugins.pardot);