<?php 
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    };

    // This is your option name where all the Redux data is stored.
    $opt_name = "wpubflw_option";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => wpubflw_Redux_Framework_Config::$name,
        // Name that appears at the top of your panel
        'display_version'      => wpubflw_Redux_Framework_Config::$version,
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => false,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'WP Ubiflow Flux', 'wpubflw' ),
        'page_title'           => __( 'WP Ubiflow Flux', 'wpubflw' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        //'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'delete_others_posts',
        // Permissions needed to access the options panel.
        //'menu_icon'            => plugins_url( '../asset/images/ico-wpubflw.png',__FILE__ ),
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => false,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'footer_credit'        => __( ' | Pour toutes suggestions concernant cette application : <a href="http://winsiders.fr/contact/">Contactez-nous</a>','wpubflw'),
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // quand il n'y a qu'un seul onglet, afficher directement celui-ci et masquer la rétraction du choix des onglets
        'open_expanded'             => true,
        'hide_expand'               => true,
        // Masquer Tab Object javascript
        'show_options_object' => false,


        'hide_reset' => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    $args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => 'http://winsiders.fr/',
        'title' => __( 'Documentation', 'wpubflw' ),
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/WINSIDERS/',
        'title' => 'Suivez-nous sur Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://twitter.com/winsiders?lang=fr',
        'title' => 'Suivez-nous sur Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.linkedin.com/company/winsiders',
        'title' => 'Nous trouvers sur LinkedIn',
        'icon'  => 'el el-linkedin'
    );

/*
    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'wpubflw' ), $v );
    } else {
        $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'wpubflw' );
    }
*/

    // Add content after the form.
    $args['footer_text'] = __( '<p><strong>©</strong> <a href="http://winsiders.fr">Winsiders</a></p>', 'wpubflw' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /**
    
     WINSIDERS
    
    */
    $pages_annonces = get_pages(array('post_type'=>'page'));
    $pages_list_annonces = array();
    foreach ($pages_annonces as $key => $value) {
        $pages_list_annonces[$pages_annonces[$key]->ID] = $pages_annonces[$key]->post_title;
    }

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Flux XML UBIFLOW', 'wpubflw' ),
        'id'         => 'flux_url_wpubflw-slider',
        'icon'       => 'el el-adjust-alt',
        'fields'     => array(

            array(
                'id'       => 'page-des-annonces',
                'type'     => 'select',
                'title'    => __( 'Page des annonces', 'wpubflw' ),
                'subtitle' => __( 'Veuillez sélectionner la page où s\'affichent toutes les annonces', 'wpubflw' ),
                'options'  => $pages_list_annonces,
            ),
            array(
                'id'       => 'annonces-par-page',
                'type'     => 'text',
                'title'    => __( 'Annonces par page', 'wpubflw' ),
                'subtitle' => __( 'Indiquez ici le nombre d\'annonces par page.', 'wpubflw' ),
                'validate' => 'numeric',
                'desc'     => __( 'Cette valeur doit être numérique.', 'wpubflw' ),
                'default'  => '12',
            ),
            array(
                'id'       => 'number-annonce-min',
                'type'     => 'text',
                'title'    => __( 'Nombre Annonces Minimum', 'wpubflw' ),
                'subtitle' => __( 'Indiquez ici le nombre d\'annonces minimum pour que la lecture du flux distant soit pris en compte.', 'wpubflw' ),
                'validate' => 'numeric',
                'desc'     => __( 'Cette valeur doit être numérique.', 'wpubflw' ),
                'default'  => '5',
            ),
            array(
                'id'       => 'colonnes',
                'type'     => 'select',
                'options'  => array(
                                    'av_one_half'  => '2',
                                    'av_one_third_3'  => '3',
                                    'av_one_fourth_4' => '4',
                                    'av_one_fifth_5'  => '5'
                                ),
                'title'    => __( 'colonnes par page', 'wpubflw' ),
                'subtitle' => __( 'Indiquez ici le nombre de colonnes par page', 'wpubflw' ),
                'default'  => 'av_one_third_3',
            ),
            array(
                'id'       => 'flux-url-text',
                'type'     => 'textarea',
                'rows'     => 3,
                'title'    => __( 'URL du fichier xml', 'wpubflw' ),
                'subtitle' => __( 'Indiquez ici les url des flux de données XML envoyé par Ubiflow. Séparer les flux par le caractère |', 'wpubflw' ),
                'desc'     => __( 'L\'url doit être valide.', 'wpubflw' ),
            ),
            array( 
                'id'       => 'flux-import-now',
                'type'     => 'raw',
                'full_width' => false,
                'title'    => __('Importer le flux', 'redux-framework-demo'),
                'desc'     => __('En cliquant sur le bouton vous allez mettre à jour ou importer les annonces du flux ci-dessus.', 'redux-framework-demo'),
                'content'  => '<div class="import_flux_xml"><a href="#" name="import_flux_xml" id="import_flux_xml" class="button button-primary" >Importer / Mettre à jour les annonces</a></div>'
            )

        ),
        'subsection' => false,
    ) );

/*
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Catégories des annnonces', 'wpubflw' ),
        'id'         => 'list_categories_immo_ubflw-slider',
        'icon'       => 'el el-adjust-alt',
        'fields'     => array(

            array(
                'id'       => 'list-categories-immo',
                'type'     => 'multi_text',
                'title'    => __( 'Liste des catégories', 'wpubflw' ),
                'subtitle' => __( 'Indiquez ici les noms des catégories à utiliser pour la catégorisation des annonces', 'wpubflw' ),
                'validate' => 'Ajouter'
            ),
        ),
        'subsection' => false,
    ) );
*/
/*
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Valeurs par défaut du simulateur de crédit', 'wpubflw' ),
        'id'         => 'default_values_wpubflw-slider',
        'icon'       => 'el el-adjust-alt',
        'fields'     => array(

            array(
                'id'       => 'apport-text-numeric',
                'type'     => 'text',
                'title'    => __( 'Apport', 'wpubflw' ),
                'subtitle' => __( 'Cette valeur gère le montant en € de l\'apport affiché par défaut.', 'wpubflw' ),
                'desc'     => __( 'Cette valeur doit être numérique.', 'wpubflw' ),
                'validate' => 'numeric',
                'default'  => '0',
            ),
            array(
                'id'       => 'montant-text-numeric',
                'type'     => 'text',
                'title'    => __( 'Montant du crédit', 'wpubflw' ),
                'subtitle' => __( 'Cette valeur gère le montant en € du crédit affiché par défaut.', 'wpubflw' ),
                'desc'     => __( 'Cette valeur doit être numérique.', 'wpubflw' ),
                'validate' => 'numeric',
                'default'  => '300000',
            ),
            array(
                'id'      => 'temps-spinner',
                'type'    => 'spinner',
                'title'   => __( 'Durée du crédit en années', 'wpubflw' ),
                'subtitle'      => __('Cette valeur gère la durée du crédit en années affichée par défaut.', 'wpubflw'),
                'desc'    => 'Min:1, max: 30, valeur par défaut : 15.',
                'default' => '15',
                'min'     => '1',
                'step'    => '1',
                'max'     => '30',
            ),
            array(
                'id'            => 'interet-slider-float',
                'type'          => 'slider',
                'title'         => __( 'Taux d\'intérêt', 'wpubflw' ),
                'subtitle'      => __( 'Cette valeur gère le taux d\'intérêt affiché par défaut. Vous pouvez rentrer la valeur directement ou utiliser la tirette.', 'wpubflw' ),
                'desc'          => __( 'Min: 0, max: 15, incrémentation: 0.05,  valeur par défaut : 1', 'wpubflw' ),
                'default'       => 1,
                'min'           => 0,
                'step'          => .05,
                'max'           => 15,
                'resolution'    => 0.01,
                'display_value' => 'text'
            ),
            array(
                'id'            => 'assurance-slider-float',
                'type'          => 'slider',
                'title'         => __( 'Taux d\'assurance', 'wpubflw' ),
                'subtitle'      => __( 'Cette valeur gère le taux d\'assurance affiché par défaut. Vous pouvez rentrer la valeur directement ou utiliser la tirette.', 'wpubflw' ),
                'desc'          => __( 'Min: 0, max: 15, incrémentation: 0.05,  valeur par défaut : 0.5', 'wpubflw' ),
                'default'       => 0.5,
                'min'           => 0,
                'step'          => .05,
                'max'           => 15,
                'resolution'    => 0.01,
                'display_value' => 'text'
            ),

        ),
        'subsection' => false,
    ) );
    */
    /**
    
     /END WINSIDERS
    
    */


    if ( ! function_exists( 'redux_disable_dev_mode_plugin' ) ) {
        function redux_disable_dev_mode_plugin( $redux ) {
            if ( $redux->args['opt_name'] != 'redux_demo' ) {
                $redux->args['dev_mode'] = false;
                $redux->args['forced_dev_mode_off'] = false;
            }
        }

        add_action( 'redux/construct', 'redux_disable_dev_mode_plugin' );
    }

    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'Erreur !';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'Attention !';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'wpubflw' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'wpubflw' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }