<?php
/*
Plugin Name: Starbox Vote
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
1.6  Language Support

You can see more information at : http://www.sealedbox.cn/starbox/

***************************************************

Version: 1.6
Author: jigen.he
Author URI: http://www.sealedbox.cn/


*/


// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(_e('You are not allowed to call this page directly.')); }

if (!class_exists('Starbox')) {


    class Starbox {


            var $table = "" ;
            var $version = "1.6";

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
                if ( is_admin() ) { 
                        add_action('admin_menu', array(&$this,'add_option_page'));
                        // do something
                }else{
                        //add_action('wp_head',  array(&$this,'load_script'));
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
                        option_admin();
            }

            function load_styles() {
                     wp_enqueue_style( 'starboxcss', STARBOX_URLPATH .'css/starbox.css', false, '2.7.0', 'screen' );
                     if ( is_admin() ) { 
                             wp_enqueue_style( 'starboxoptioncss', STARBOX_URLPATH .'css/option_style.css');
                     }
            }

            function load_script(){


                    wp_enqueue_script('prototype', STARBOX_URLPATH .'js/prototype.js');
                    wp_enqueue_script('scriptaculous', STARBOX_URLPATH .'js/scriptaculous.js?load=effects');
                    wp_enqueue_script('starbox', STARBOX_URLPATH.'js/starbox.js');
                    wp_enqueue_script('function', STARBOX_URLPATH.'js/function.js.php');
/*
                    echo '<script src="'.STARBOX_URLPATH .'js/prototype.js" type="text/javascript"/></script>' ."\n";
                    echo '<script src="'.STARBOX_URLPATH .'js/scriptaculous.js?load=effects" type="text/javascript"/></script>' ."\n";
                    echo '<script src="'.STARBOX_URLPATH.'js/starbox.js" type="text/javascript"/></script>' ."\n";
                    echo '<script src="'.STARBOX_URLPATH.'js/function.js.php" type="text/javascript"/></script>' ."\n";
 */                   
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

                    
                    add_option("starbox_button", "5");
                    add_option("starbox_overlay", "default.png");
                    add_option("starbox_class", "default");
                    add_option("starbox_ghost", "false");
                    add_option("starbox_version", $this->version);


                    if(!$this->copy_js_script())
                            return false;

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

            function copy_js_script(){
                    $prototype_folder = ABSPATH . 'wp-includes\js/' ;
                    $scriptaculous_floder = $prototype_folder . 'scriptaculous/' ;
                    if(!is_writable($prototype_folder)){
                            echo '<div id="message" class="error"><p><strong>' . __('Sorry, Please Change The Folder ','starbox').$prototype_folder.__(' writeable!','starbox'). '</strong></p></div>';
                            return false;
                    }
                    if(!is_writable($scriptaculous_floder)){
                            echo '<div id="message" class="error"><p><strong>' . __('Sorry, Please Change The Folder ','starbox').$scriptaculous_floder.__(' writeable!','starbox') . '</strong></p></div>';
                            return false;
                    }
                    /*
                        backup 
                    */
                    if(!file_exists( $prototype_folder . 'prototype.js.bak')){
                            if(!@copy($prototype_folder . 'prototype.js' , $prototype_folder . 'prototype.js.bak')){
                                    echo '<div id="message" class="error"><p><strong>' . __("Sorry, Can't Backup  ",'starbox').$prototype_folder."prototype.js!</strong></p></div>";
                                    return false;
                            }
                    }if(!file_exists($scriptaculous_floder . 'wp-scriptaculous.js.bak')){
                            if(!@copy($scriptaculous_floder .'wp-scriptaculous.js',  $scriptaculous_floder . 'wp-scriptaculous.js.bak')){
                                    echo '<div id="message" class="error"><p><strong>' . __("Sorry, Can't Backup  ",'starbox').$scriptaculous_floder.'scriptaculous.js!</strong></p></div>';
                                    return false;
                            }
                    }if(!file_exists($scriptaculous_floder . 'effects.js.bak')){
                            if(!@copy($scriptaculous_floder .'effects.js',  $scriptaculous_floder . 'effects.js.bak')){
                                    echo '<div id="message" class="error"><p><strong>' .__("Sorry, Can't Backup  ",'starbox').$scriptaculous_floder.'effects.js!</strong></p></div>';
                                    return false;
                            }
                    }

                    /*
                        replace
                    */

                    if(!@copy(STARBOX_URLPATH .'js/prototype.js',  $prototype_folder . 'prototype.js')){
                            echo '<div id="message" class="error"><p><strong>' . __("Sorry, Can't Copy  ",'starbox').STARBOX_URLPATH.'js/prototype.js '.__('to','starbox') .$prototype_folder.'prototype.js!</strong></p></div>';
                            return false;
                    }
                    if(!@copy(STARBOX_URLPATH .'js/scriptaculous.js',  $scriptaculous_floder . 'wp-scriptaculous.js')){
                            echo '<div id="message" class="error"><p><strong>' . __("Sorry, Can't Copy  ",'starbox').STARBOX_URLPATH.'js/scriptaculous.js '. __('to','starbox') .$scriptaculous_floder.'wp-scriptaculous.js!</strong></p></div>';
                            return false;
                    }
                    if(!@copy(STARBOX_URLPATH .'js/effects.js',  $scriptaculous_floder . 'effects.js')){
                            echo '<div id="message" class="error"><p><strong>' . __("Sorry, Can't Copy  ",'starbox').STARBOX_URLPATH.'js/effects.js '.__('to','starbox') .$scriptaculous_floder.'effects.js!</strong></p></div>';
                            return false;
                    }

                    return true ;
            }
            
            /**
             * do something when plugins deactivate
             * 
             * @author Administrator (2009-2-7)
             */
            function deactivate() {
                    /*
                     replace
                    */
                    @copy($prototype_folder . 'prototype.js.bak' , $prototype_folder . 'prototype.js');
                    @copy($scriptaculous_floder .'wp-scriptaculous.js.bak',  $scriptaculous_floder . 'wp-scriptaculous.js');
                    @copy($scriptaculous_floder .'effects.js.bak',  $scriptaculous_floder . 'effects.js');

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

            

            

    }
    // Let's start the plugin
    global $starbox;
    $starbox = new Starbox();
}
?>