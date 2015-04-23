(function() {
    tinymce.create('tinymce.plugins.pardot', {

        init : function(ed, url) {
            var self = this;

            ed.addButton ('pardot', {
                'title' : 'My plugin',
                'image' : url+'/pardot-button.png',
                'onclick' : function () {
                    alert('Congratulations! Your plugin works!');
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