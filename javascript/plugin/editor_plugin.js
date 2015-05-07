(function() {

	var each = tinymce.each;

	jQuery('body').on('click', '#pardot-submit-form', function(e){
		e.preventDefault();
		output = jQuery("#selected_form").val();
		height = jQuery("#form-height").val();
		width = jQuery("#form-width").val();
		classes = jQuery("#form-classes").val();
		if(height.length > 0)
			output += ", height='"+height+"'";
		if(width.length > 0)
			output += ", width='"+width+"'";
		if(classes.length > 0)
			output += ", class='"+classes+"'";
		output += "]";
		tinymce.execCommand('mceReplaceContent', false, output);
		jQuery('.htmleditorfield-pardotdialog').remove();

		return false;
	});

	jQuery('body').on('click', '#pardot-submit-dynamic', function(e){
		e.preventDefault();
		output = jQuery("#selected_content").val();
		height = jQuery("#content-height").val();
		width = jQuery("#content-width").val();
		classes = jQuery("#content-classes").val();
		if(height.length > 0)
			output += ", height='"+height+"'";
		if(width.length > 0)
			output += ", width='"+width+"'";
		if(classes.length > 0)
			output += ", class='"+classes+"'";
		output += "]";
		tinymce.execCommand('mceReplaceContent', false, output);
		jQuery('.htmleditorfield-pardotdialog').remove();

		return false;
	});

	tinymce.create('tinymce.plugins.pardot', {

		init : function(ed, url) {
			var self = this;

			ed.addButton ('pardot', {
				'title' : 'Pardot',
				'image' : url+'/pardot-button.png',
				'onclick' : function () {
					dialog = '<div class="htmleditorfield-dialog htmleditorfield-pardotdialog loading">';
					jQuery('body').append(dialog);
					jQuery.ajax({
						url: '/pardot',
						complete: function() {
							jQuery('.htmleditorfield-pardotdialog').removeClass('loading');
						},
						success: function(html) {
							jQuery('.htmleditorfield-pardotdialog').html(html);
						}
					});
				}
			});
		},

		getInfo : function() {
			return {
				longname  : 'pardot',
				author    : 'Bluehouse Group',
				authorurl : 'https://github.com/bluehousegroup/',
				infourl   : 'https://github.com/bluehousegroup/silverstripe-pardot',
				version   : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('pardot', tinymce.plugins.pardot);
})();