<?php 
require_once('../../../../wp-load.php');
require_once('../../../../wp-admin/includes/admin.php');
do_action('admin_init');

if ( ! is_user_logged_in() )
    die('You must be logged in to access this script.');
?>
(function() {
    tinymce.create('tinymce.plugins.bella', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            ed.addButton('bella_slider', {
                type: 'listbox',
                text: 'Select a slider',
                icon: false,
                onselect: function(e) {}, 
                values: [
                    <?php $query = new WP_Query(array(
                        'post_type'=>'ris_gallery',
                        'posts_per_page'=>-1,
                    ));
                    if($query->have_posts()): 
                        while($query->have_posts()):$query->the_post();
                            $title = get_the_title();
                            $id = get_the_ID();
                            echo "{text: '{$title}', onclick : function() {
                                tinymce.execCommand('mceInsertContent', 0, '[URIS id={$id}]');
                            }},";
                        endwhile;
                    endif;?>
                ]
            });
            ed.addButton('signup', {
                title : 'Signup',
                cmd : 'signup',
                image : url + '/q.jpg'
            });
            ed.addCommand('signup', function() {
                var return_text = '';
                return_text = '[signup-embed]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });
        },
 
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Bella TinyMCE Buttons',
                author : 'Fritz Healy',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'bella', tinymce.plugins.bella );
})();