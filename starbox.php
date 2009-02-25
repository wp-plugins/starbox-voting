<?php
/*
Plugin Name: Starbox Vote
Plugin URI: http://www.sealedbox.cn/
Description: A Post Voting Plugins , which use starbox.js
Version: 1.0
Author: jigen.he
Author URI: http://www.sealedbox.cn/


*/


// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

if (!class_exists('Starbox')) {


    class Starbox {


            var $table = "" ;

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
                if ( is_admin() ) { 
                        add_action('admin_menu', array(&$this,'add_option_page'));
                        // do something
                }else{
                        add_action('wp_head',  array(&$this,'load_script'));
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
                                    add_options_page(__('Starbox', 'starbox'), __('Starbox', 'starbox'), 10 , "starbox" ,array(&$this,'starbox_option')) ;
                        }
            }

            /**
             * Show Options page
             * 
             * @author jigen.he (2009-2-23)
             */
            function starbox_option(){
                        require_once (dirname (__FILE__) . '/options.php');        
                        option_admin();
            }

            function load_styles() {
                     wp_enqueue_style( 'starboxcss', STARBOX_URLPATH .'css/starbox.css', false, '2.7.0', 'screen' );
            }

            function load_script(){
                    echo '<script src="'.STARBOX_URLPATH .'js/prototype.js" type="text/javascript"/></script>' ."\n";
                    echo '<script src="'.STARBOX_URLPATH .'js/scriptaculous.js?load=effects" type="text/javascript"/></script>' ."\n";
                    echo '<script src="'.STARBOX_URLPATH.'js/starbox.js" type="text/javascript"/></script>' ."\n";
                    echo '<script src="'.STARBOX_URLPATH.'js/function.js.php" type="text/javascript"/></script>' ."\n";
           }

            function define_constant() {

                // define URL
                define('STARBOX_FOLDER', plugin_basename( dirname(__FILE__)) );
                
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


                    add_option("starbox_image", "");
                
                    add_option("starbox_version", "1.1.0");

                    global $wpdb ;

                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    // do activate
                    if($wpdb->get_var("show tables like '$this->table'") != $this->table){
                            $q = "CREATE TABLE `wp_starboxvoting` (
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
                    // do deactivate
            }

            

            

    }
    // Let's start the plugin
    global $starbox;
    $starbox = new Starbox();
}
?>