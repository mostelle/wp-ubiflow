<?php defined( 'ABSPATH' ) OR exit; //disallow direct file access when core isn't loaded

    if ( ! class_exists( 'wpubflw_Redux_Framework_Config' ) ) {

        class wpubflw_Redux_Framework_Config {

            public $args = array();
            public $sections = array();
            public $ReduxFramework;
            public static $version = '1.0';
            public static $name = 'WP Ubiflow Flux';

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {	
                    return;
                }
                add_action( 'wp_loaded', array( $this, 'initSettings' ), 10 );
            }

            public function initSettings() {

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

        }

        global $reduxConfig;
        $reduxConfig = new wpubflw_Redux_Framework_Config();

    }
