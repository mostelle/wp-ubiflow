<?php defined( 'ABSPATH' ) OR exit; //disallow direct file access when core isn't loaded
/*
Plugin Name: WP Ubiflow Flux
Plugin URI: http://winsiders.com
Description: Récupération Flux Ubiflow Immobilier
Version: 2.1
Author: William Loiseau pour Winsiders
Author URI: http://winsiders.com
*/

define ( 'WPUBIPATH', plugin_dir_path( __FILE__ ) );
define ( 'WPUBIURL', plugin_dir_url( __FILE__ ) );

class wpubflw
{
	public function __construct()
	{
		// add_action( 'admin_menu', array($this, 'add_admin_menu') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_wpubflw_css'), 11 );
		add_action( 'wp_enqueue_scripts', array($this, 'client_wpubflw_css'), 11 );
		add_action( 'wp_enqueue_scripts', array($this, 'client_wpubflw_js'), 11 );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_wpubflw_js') );
		add_filter( 'mce_external_plugins', array($this, 'add_buttons') );
		add_filter( 'mce_buttons', array($this, 'register_buttons') );
		add_action( 'admin_print_footer_scripts', array($this,'add_quicktags' ));
		add_action( 'admin_init', array($this,'remove_redux_menu' ));


		// Load the embedded Redux Framework
	    if ( !class_exists( 'ReduxFramework' )
	    	&&  file_exists( WPUBIPATH . 'core/redux-framework/redux-framework.php' ) )
	    {
			require_once WPUBIPATH . 'core/redux-framework/redux-framework.php';
	    }

	    if ( !isset( $redux_demo )
	    	&& file_exists( WPUBIPATH . 'core/wpubflw-admin-redux.php' ) )
	    {
			require_once( WPUBIPATH . 'core/wpubflw-admin-redux.php' );
		}

	    if ( !isset( $redux_demo )
	    	&& file_exists( WPUBIPATH . 'core/wpubflw-config.php' ) )
	    {
	    	require_once WPUBIPATH . 'core/wpubflw-config.php';
	    }

	    require_once WPUBIPATH.'core/wpubflw-functions-posts.php';
	    require_once WPUBIPATH.'class/wpubflw-create-post.php';
	}

	public function remove_redux_menu(){
		remove_submenu_page( 'tools.php', 'redux-about' );
	}

	/**
	 * Ajout de la css du front
	 * 
	 * @return Void
	 */
	public function client_wpubflw_css()
	{
		$client_handle = 'front_wpubflw_css';
		$client_stylesheet =  WPUBIURL . 'views/css/front-wpubflw.css';
		wp_enqueue_style( $client_handle, $client_stylesheet);
	}

	/**
	 * Ajout de la css d'admin
	 * 
	 * @return Void
	 */
	public function admin_wpubflw_css()
	{
		$admin_handle = 'admin_wpubflw_css';
		$admin_stylesheet = WPUBIURL . 'views/css/admin-wpubflw.css';
		wp_enqueue_style( $admin_handle, $admin_stylesheet );
	}

	/**
	 * Ajout de la js de front
	 * 
	 * @return Void
	 */
	public function client_wpubflw_js()
	{
		$front_handle = 'front_wpubflw_js';
		$front_js = WPUBIURL . 'asset/js/wpubflw_main.js';
		wp_enqueue_script( $front_handle, $front_js );
	}

	/**
	 * Ajout de la js d'admin
	 * 
	 * @return Void
	 */
	public function admin_wpubflw_js()
	{
		$admin_handle = 'admin_wpubflw_js';
		$admin_js = WPUBIURL . 'asset/js/wpubflw_admin.js';
		wp_enqueue_script( $admin_handle, $admin_js );
		// récupérer l'url du plugin sous forme de variable js 
		wp_localize_script('admin_wpubflw_js', 'WPURLS', array( 'plugin_url' => WPUBIURL ));

	}

	/**
     * Rajout dans l'éditeur Tiny du bouton d'insertion de wpubflw
     * 
     */
    public static function add_buttons($plugin_array)
    {
        $plugin_array['wpubflw_insert_button'] = plugins_url('/asset/js/wpubflw_tinymce_plugin.js',__file__);
        return $plugin_array;
    }
    public static function register_buttons($buttons)
    {
        array_push($buttons, 'wpubflw_insert_button');
        return $buttons;
    }


    /**
     * Méthode pour insérer le bouton dans l'éditeur de texte
     */
    public static function add_quicktags(){
        if (wp_script_is('quicktags')){
            ?>
            <script type="text/javascript">
            QTags.addButton( 'wpubflw_insert_tree', 'wpubflw', wpubflw_insert_prompt, null, null, 'wpubflw', 500 );
            function wpubflw_insert_prompt(e, c, ed){
                wpubflw_Insert.wpubflw_init(ed, e, c);
                wpubflw_Insert.wpubflw_prompt_and_insert('text');
            }
            </script>
            <?php
        }
    }

}

new wpubflw();

include_once WPUBIPATH. 'core/wpubflw-functions-core.php';

?>