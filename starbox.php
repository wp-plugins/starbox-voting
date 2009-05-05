<?php
/*
Plugin Name: Starbox Voting
Plugin URI: http://www.sealedbox.cn/
Description: A Post Voting Plugins , which use starbox.js

**** Change Log ****

1.1: Add plugins init setting , set display image as default image.

1.2: Repaire ajax Request ,no response .

1.3  Add so Style to choose In `Setting > Starbox`

1.4  You can set style by yourself In `Setting > Starbox`

1.5  Change error: no effect when change style in backend<br/>
     Add ghosing effect when mouse hover the stars<br/>
     Change Style Setting Page style.<br/>

1.6  Add Language Package

1.7 Rename every function . to avoid with other plugins 

1.8 Compatible with Windows And Linux 

2.0.2 Fix database create table only have 'wp_' prefix .

2.0.3 Clear code.

2.0.4 Fix Ie8 Bug:add this right after <head> : <meta http-equiv=¡±X-UA-Compatible¡± content=¡±IE=EmulateIE7¡å />

You can see more information at : http://www.sealedbox.cn/starbox/

***************************************************

Version: 2.0.4
Author: jigen.he
Author URI: http://www.sealedbox.cn/


*/


// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(_e('You are not allowed to call this page directly.')); }

if (!class_exists('Starbox')) {


    class Starbox {


            var $table = "" ;
            var $version = "2.0.4";


            /**
             * constructor
             * 
             * @author Administrator (2009-2-7)
             */
            function Starbox(){
                    
                    global $wpdb ;

                    $this->table = $wpdb->prefix . "starboxvoting";

                    $this->define_constant();


                    register_activation_hook( dirname(__FILE__) . '/starbox.php', array(&$this, 'activate') );
                    register_deactivation_hook( dirname(__FILE__) . '/starbox.php', array(&$this, 'deactivate') );   
        
                    // Start this plugin once all other plugins are fully loaded
                    add_action( 'plugins_loaded', array(&$this, 'start_plugin') );
            }

            /**
             * Start this plugin
             * 
             * @author Administrator (2009-2-7)
             */
            function start_plugin(){
                // load js script and css style sheet
                $this->load_styles();
                $this->load_script();


                
                load_plugin_textdomain('starbox', STARBOX_LANGUAGES_FOLDER);

                if ( is_admin() ) { 
                        add_action('admin_menu', array(&$this,'add_option_page'));
                        // do something
                }else{
                        require_once (dirname (__FILE__) . '/star_view.php');   
                        // do something
                }

            }

            /**
             * add a setting page to setting tab
             * 
             * @author jigen.he (2009-2-23)
             */
            function add_option_page(){
                        if (function_exists('add_options_page')) {
                                    add_options_page('Starbox', 'Starbox', 10 , "starbox" ,array(&$this,'starbox_option')) ;
                        }
            }

            /**
             * Show Options page
             * 
             * @author jigen.he (2009-2-23)
             */
            function starbox_option(){
                        require_once (dirname (__FILE__) . '/options.php');        
                        starbox_option_admin();
            }

            function load_styles() {
                     wp_enqueue_style( 'starboxcss', STARBOX_URLPATH .'css/starbox.css', false, '2.7.0', 'screen' );
                     if ( is_admin() ) { 
                             wp_enqueue_style( 'starboxoptioncss', STARBOX_URLPATH .'css/option_style.css');
                     }
            }

            function load_script(){

                    wp_register_script('starbox_p', STARBOX_URLPATH .'js/prototype.js', false, '1.6.0.3');
                    wp_enqueue_script('starbox_p', false, false , '1.6.0.3');

                    wp_register_script('starbox_s', STARBOX_URLPATH .'js/scriptaculous.js?load=effects', false, '1.8.0.1');
                    wp_enqueue_script('starbox_s', false, false , '1.8.0.1');

                    wp_enqueue_script('starbox', STARBOX_URLPATH.'js/starbox.js');

                    wp_enqueue_script('function', STARBOX_URLPATH.'js/function.js.php');                
           }


            function define_constant() {

                // define URL
                define('STARBOX_FOLDER', plugin_basename( dirname(__FILE__)) );

                define('STARBOX_LANGUAGES_FOLDER', '/wp-content/plugins/'.STARBOX_FOLDER.'/languages/' );
                
                define('STARBOX_ABSPATH', str_replace("\\","/", WP_PLUGIN_DIR . '/' . plugin_basename( dirname(__FILE__) ) . '/' ));
                define('STARBOX_URLPATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
        
                // get value for safe mode
                if ( (gettype( ini_get('safe_mode') ) == 'string') ) {
                    // if sever did in in a other way
                    if ( ini_get('safe_mode') == 'off' ) define('SAFE_MODE', FALSE);
                    else define( 'SAFE_MODE', ini_get('safe_mode') );
                } else
                define( 'SAFE_MODE', ini_get('safe_mode') );
                
            }

            /**
             * do something when plugins activate
             * 
             * @author Administrator (2009-2-7)
             */
            function activate() {

                    global $wpdb ;
                    
                    add_option("starbox_button", "5");
                    add_option("starbox_overlay", "default.png");
                    add_option("starbox_class", "default");
                    add_option("starbox_ghost", "false");
                    add_option("starbox_version", $this->version);


                    //$this->copy_js_script();


                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    // do activate
                    if($wpdb->get_var("show tables like '$this->table'") != $this->table){
                            $q = "CREATE TABLE `".$this->table."` (
                                  `id` int(11) NOT NULL auto_increment,
                                  `object_id` int(11) NOT NULL,
                                  `ip` varchar(64) character set latin1 NOT NULL,
                                  `vote` int(11) NOT NULL,
                                  PRIMARY KEY  (`id`)
                                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;" ;
                            dbDelta($q);
                    }
                    
            }

           
            
            /**
             * do something when plugins deactivate
             * 
             * @author Administrator (2009-2-7)
             */
            function deactivate() {
                    
                    wp_deregister_script('starbox_p');
                    wp_deregister_script('starbox_s');
                    
                    if(get_option('starbox_image')){
                            delete_option('starbox_image');
                    }
                    delete_option("starbox_button");
                    delete_option("starbox_overlay");
                    delete_option("starbox_class");
                    delete_option("starbox_ghost");
                    delete_option('starbox_version');
                    // do deactivate
            }

            function show_starbox_error($message){  
                            add_action(
                                'admin_notices', 
                                create_function(
                                    '', 
                                    'echo \'<div id="message" class="error"><p><strong>' . $message . '</strong></p></div>\';'
                                )
                            );
            }

            

            

    }
    // Let's start the plugin
    global $starbox;
    $starbox = new Starbox();
}
?>