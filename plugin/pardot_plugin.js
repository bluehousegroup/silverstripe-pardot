(function() {
    tinymce.create('tinymce.plugins.pardot', {

        init : function(ed, url) {
            var self = this;

            ed.addButton ('pardot', {
                'title' : 'Drop-in form',
                'image' : url+'/pardot-button.png',
                'onclick' : function () {
                    ed.windowManager.open({
                        title: 'Edit image',
                        url: url + '/popup.ss'
                    });
                }
            });

        },

        getInfo : function() {
            return {
                longname  : 'pardot',
                author      : 'Bluehouse Group',
                authorurl : 'http://me.org.nz/',
                infourl   : 'http://me.org.nz/pardot/',
                version   : "1.0"
            };
        }
    });

    tinymce.PluginManager.add('pardot', tinymce.plugins.pardot);
})();