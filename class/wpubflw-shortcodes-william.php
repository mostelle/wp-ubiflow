<?php
defined( 'ABSPATH' ) OR exit; //disallow direct file access when core isn't loaded

class UBFLW_annonces {

	public function __construct() {

		require_once WPUBIPATH	. 'core/wpubflw-functions-posts.php';
		require_once WPUBIPATH	. 'views/code_type.php';
		add_shortcode( "ubiflow_annonces", array( $this, "run_shortcode_annnonces" ) );
		//add_shortcode( "ubiflow_fiche_annonce", array( $this, "run_shortcode_fiche_annnonce" ) );
		add_filter( "the_content", array( $this, "run_template_fiche_annnonce" ), 20 );
		// no sidebar
		add_filter( 'avf_sidebar_position', array( $this, 'ubflw_avia_remove_sidebar') );
		//add_filter('avia_layout_filter', array( $this, 'ubflw_avia_change_post_layout'), 10, 2);

		// supression de la big image d'enfold
		add_filter( 'post-format-standard', array( $this, 'remove_big_image_blog' ) );
		// lien sociaux suppression
		add_filter( 'avia_social_share_link_arguments', array( $this, 'remove_ubflw_share_links_args') );

		add_filter( 'facetwp_index_row', array( $this, 'render_unit_m2') , 10, 2 );
		add_filter( 'facetwp_sort_options', array( $this, 'render_sort_otpions_modify') , 10, 2 );
		add_filter( 'facetwp_sort_html', array( $this, 'modify_render_html_facetwp'), 10, 2);
		add_action( 'wp_enqueue_scripts', array( $this, 'add_js_custom_facetwp'));

		//add_action( 'pre_get_posts',  array( $this, 'custom_query_vars_wpublfw' ) );

		add_filter( 'avf_exclude_taxonomies', array( $this, 'exclude_annonce_immo_taxs'), 10, 2 );

		add_filter( 'avf_title_args', array( $this, 'return_to_previous_page')  );

		add_filter( 'post-format-standard', array( $this, 'ubiflow_avia_default_title_filter') );

	}

	/**
	 * Suppression du titre dans l'annnonce
	 *
	 * @param    array    $current_post
	 *
	 * @return   array    $current_post
	 */
	public function ubiflow_avia_default_title_filter($current_post){
		global $post;
		if( is_singular('annonce_immo') ){
			$current_post['title']='';
		}
		return $current_post;
	}

	/**
	 * changer à la volée le titre par retour sur les fiches annonce
	 *
	 * @param    array    $args
	 *
	 * @return   array    $args
	 */
	public function return_to_previous_page( $args ){
		global $post;
		if( is_singular('annonce_immo') ){
			global $wp;
			if( !empty( $link = wp_get_referer() ) ){
				$args['link'] 		= $link;
				$args['title'] 		= 'Retour';
				$args['class'] 		= $args['class'].' annonce_seule ';
				$args['breadcrumb'] = false;
				$args['additions'] 	= '<h1 class="post-title">'.$post->post_title.'</h1>';
			}else{
				$args['link'] 		= false;
				$args['title'] 		= '';
				$args['class'] 		= $args['class'].' annonce_seule ';
				$args['breadcrumb'] = false;
				$args['additions'] 	= '<h1 class="post-title">'.$post->post_title.'</h1>';
			}
		}
		return $args;
	}

	/**
	 * suppression des taxonomies lié à annonce_immo
	 *
	 * @param    array    $excluded_taxonomies
	 * @param    string    $post_type
	 *
	 * @return   array    $excluded_taxonomies
	 */
	public function exclude_annonce_immo_taxs( $excluded_taxonomies, $post_type ){

		$taxonomies = get_object_taxonomies( 'annonce_immo' );
		foreach ($taxonomies as $key => $taxonomy) {
			$excluded_taxonomies[$key] = $taxonomy;
		}
		return $excluded_taxonomies;
	}

	/*
	// Incompréhensible mais ça marche pas....
	public function custom_query_vars_wpublfw( $query ) {
		if ( !is_admin() && $query->is_main_query() ){
			// récupération des taxonomies de annonce_immo (type et annonces)
			$taxonomies = get_object_taxonomies( 'annonce_immo' );
			$nb_posts  = get_option('initial_posts_per_page' );

			// parcours pour savoir si la taxonomie est utilisé dans la requête
			foreach ($taxonomies as $key => $taxonomy) {
				if( isset($query->query_vars[$taxonomy]) ){
					$tax = true;
					break;
				}
			}
			// si cpt "annonce_immo" ou une taxo de "annonce_immo" est utilisé
			if ( get_post_type() == 'annonce_immo' || isset($tax) ) {

				global $wpubflw_option;

				$nb_initial  = get_option('posts_per_page' );
				update_option('initial_posts_per_page', $nb_initial );

				$nb_posts_ubi = $wpubflw_option['annonces-par-page'];
				// très grand mystère, impossible de trouver dans enfold
				// l'appel à l'option du nombre d'article par page,
				// je les ai toutes modifiées, dans tous les fichiers....
				// la requête par défaut se base sur le nombre déclaré en administration,
				// je suis contraint de la modifier
				if( intval($nb_initial)!=intval($nb_posts_ubi) ){
					update_option('posts_per_page', $nb_posts_ubi);
				}
				// parce que ci dessous cela ne fonctionne pas, alors que cea devrait marcher
				// encore un coup d'enfold........
				//$query->set( 'posts_per_page', $nb_posts );
				//set_query_var( 'posts_per_page', $nb_posts );
				return $query;
			}else{
				if($nb_posts) update_option('posts_per_page', $nb_posts );
			}
		}

		return $query;
	}
	*/

	/**
	 * ajout javascript pour modifier comportement facetwp
	 *
	 * 	autre manière de faire :
	 *  add_filter( 'facetwp_assets', function( $assets ) {
	 *    $assets['custom.js'] = 'URL/TO/YOUR/custom.js';
	 *    return $assets;
	 *	});
	 *
	 */
	public function add_js_custom_facetwp( ){
		global $wpubflw_option, $post;
		if( !empty($post) && $post->ID==intval($wpubflw_option['page-des-annonces']) ){
			wp_enqueue_script( 'facetwp-custom-js', WPUBIURL . 'asset/js/facetwp-custom.js' );
		}
	}

	/**
	 * affichage HTML des options de tri de biens
	 *
	 * @param    string    $html
	 * @param    array    $params
	 *
	 * @return   string    $html
	 */
	public function modify_render_html_facetwp( $html, $params ) {

		$html  = '<div class="facetwp_select_wrapper">Tri : <div class="facetwp-sort-radio">';
	    foreach ( $params['sort_options'] as $key => $atts ) {

	    	$wrapper = 'default';

	    	if($key=='date_desc' || $key =='date_asc'){ $wrapper='date'; }
	    	if($key=='price_desc' || $key =='price_asc'){ $wrapper='price'; }
	    	if($key=='surface_desc' || $key =='surface_asc'){ $wrapper='surface'; }

	    	$html .= '<span class="wrapper_'.$wrapper.'">';
	        $html .= '<input type="radio" name="sort" id="' . $key . '" value="' . $key . '"><label for="'.$key.'">' . $atts['label'].'</label>';
	        $html .= '</span>';
	    }
	    $html .= '</div>';

		/*
		$html = '<div class="facetwp_select_wrapper">
					<select id="tri_select" class="facetwp-sort-select">';
	    foreach ( $params['sort_options'] as $key => $atts ) {
	        $html .= '<option value="' . $key . '">' . $atts['label'] . '</option>';
	    }
	    $html.= 	'</select>';
	    $html.= '</div>';
		*/

	   	/*
		$html ='';
		$html_date_start = '<div class="facetwp_select_wrapper"><label for="date_select">Tri par date :</label>
							<select id="date_select" class="facetwp-sort-select">';
		$html_date = '';
	    foreach ( $params['sort_options'] as $key => $atts ) {
	    	if($key=='date_desc' || $key =='date_asc'){
	        	$html_date .= '<option value="' . $key . '">' . $atts['label'] . '</option>';
	    	}
	    }
	   	$html_date_end = '</select></div>';
	   	if(!empty($html_date)){ $html.= $html_date_start . $html_date . $html_date_end; }
		*/

	   	/* PRIX */
		/*
		$html_price_start = '<div class="facetwp_select_wrapper"><label for="prix_select">Tri par prix :</label>
							<select id="prix_select" class="facetwp-sort-select">';
		$html_price = '';
	    foreach ( $params['sort_options'] as $key => $atts ) {
	    	if($key=='price_desc' || $key =='price_asc'){
		        $html_price .= '<option value="' . $key . '">' . $atts['label'] . '</option>';
	    	}
	    }
	    $html_price_end = '</select></div>';

	    if(!empty($html_price)){ $html.= $html_price_start . $html_price . $html_price_end; }

	   	/* SURFACE */
	   	/*
		$html_surface_start = '<div class="facetwp_select_wrapper"><label for="surface_select">Tri par surface :</label>
							<select id="surface_select" class="facetwp-sort-select">';
		$html_surface = '';
	    foreach ( $params['sort_options'] as $key => $atts ) {
	    	if($key=='surface_desc' || $key =='surface_asc'){
		        $html_surface .= '<option value="' . $key . '">' . $atts['label'] . '</option>';
	    	}
	    }
	    $html_surface_end = '</select></div>';

	    if(!empty($html_surface)){ $html.= $html_surface_start . $html_surface . $html_surface_end; }
		*/

	    /* HTML */
	    return $html;
	}

	/**
	 * redéfinition des tri de biens
	 *
	 * @param    array    $options
	 * @param    array    $params
	 *
	 * @return   array    $options
	 */
	public function render_sort_otpions_modify( $options, $params ) {

		unset( $options['title_asc'] );
		unset( $options['title_desc'] );

		if(isset($_GET['fwp_categories_annonces'])){ $cat_annonces = $_GET['fwp_categories_annonces']; }

		if( isset($cat_annonces) && $cat_annonces=='location' ){

			$options['price_desc'] = array(
								        'label' => 'Prix décroissant',
								        'query_args' => array(
								            'orderby' => 'meta_value_num',
								            'meta_key' => 'loyer_mensuel_cc',
								            'order' => 'DESC',
								        )
								    );
			$options['price_asc'] = array(
								        'label' => 'Prix croissant',
								        'query_args' => array(
								            'orderby' => 'meta_value_num',
								            'meta_key' => 'loyer_mensuel_cc',
								            'order' => 'ASC',
								        )
								    );

		}elseif( isset($cat_annonces) && $cat_annonces=='vente' ){

			$options['price_desc'] = array(
								        'label' => 'Prix décroissant',
								        'query_args' => array(
								            'orderby' => 'meta_value_num',
								            'meta_key' => 'prix',
								            'order' => 'DESC',
								        )
								    );
			$options['price_asc'] = array(
								        'label' => 'Prix croissant',
								        'query_args' => array(
								            'orderby' => 'meta_value_num',
								            'meta_key' => 'prix',
								            'order' => 'ASC',
								        )
								    );
		}

		$options['surface_desc'] = array(
								        'label' => 'Surface décroissante',
								        'query_args' => array(
								            'orderby' => 'meta_value_num',
								            'meta_key' => 'annonce_surface',
								            'order' => 'DESC',
								        )
								    );
		$options['surface_asc'] = array(
								        'label' => 'Surface croissante',
								        'query_args' => array(
								            'orderby' => 'meta_value_num',
								            'meta_key' => 'annonce_surface',
								            'order' => 'ASC',
								        )
								    );

		return $options;
	}

	/**
	 * Suppression des m2 lors de l'insertion dans l'index
	 *
	 * @param    array    $params
	 * @param    array    $class
	 *
	 * @return   array    $params
	 */
	public function render_unit_m2( $params, $class ) {
		if('surface_annonce'==$params['facet_name']){
			$raw_value = $params['facet_display_value'];
			$new_value = str_replace('<span class="surface_m2">m&sup2;</span>', '', $raw_value);
        	$params['facet_value'] = $new_value;
        	$params['facet_display_value'] = $new_value;
		}
	    return $params;
	}

	/**
	 * Suppression des liens sociaux sur fiche annonce
	 *
	 * @param    array    $args    liste liens sociaux
	 *
	 * @return   array    $args    liste liens sociaux
	 */
	public function remove_ubflw_share_links_args( $args ){
		if( is_singular('annonce_immo') ){
			$args=array();
		}
		return $args;
	}

	/**
	 * Suppression de la grande image d'article
	 *
	 * @param    array    $current_post    current_post used
	 *
	 * @return   array    $current_post    new current_post
	 */
	public function remove_big_image_blog($current_post){
		if( is_singular('annonce_immo') ){
			//unset( $current_post['slider'] );
			$current_post['slider'] = '';
		}
		return $current_post;
	}

	/**
	 * Change template Enflod, passant en fullsize
	 *
	 * @param    int    $post_id    ID post
	 * @param    array    $layout    layout used
	 *
	 * @return   array    $layout    new layout
	 */
	public function ubflw_avia_change_post_layout($layout, $post_id) {
		if( is_singular('annonce_immo') ) {
		    $layout['current'] = $layout['fullsize'];
		    $layout['current']['main'] = 'fullsize';
		}
		return $layout;
	}

	/**
	 * remove sidebar
	 *
	 * @param    int    $post_id    ID post
	 * @param    array    $layout    layout used
	 *
	 * @return   array    $layout    new layout
	 */
	public function ubflw_avia_remove_sidebar($sidebar ) {
		if( is_singular('annonce_immo') ) {
			return false;
		}
		return $sidebar;
	}


	/**
	 * Run the shortcode [ubiflow_annonces].
	 *
	 * @param   array
	 *
	 * @return 	string
	 */
	public function run_shortcode_annnonces( $atts ) {

		global $wpubflw_option;

		$colonnes_explode 	= explode( '_', $wpubflw_option['colonnes'] );
		$nb_colonnes 		= intval( end( $colonnes_explode ) );

		unset( $colonnes_explode[3] );
		$colonnes 			= implode( '_', $colonnes_explode );

		// Define the query
		$paged = ubflw_get_page_number();

		$args = array(
			'post_type'      => 'annonce_immo',
			'post_status'    => 'publish',
			'posts_per_page' => (int) $wpubflw_option['annonces-par-page'],
			'paged'          => $paged,
	  	);

		$query_args = apply_filters( 'shortcode_args_ubflw', $args );

		$ubflw_query = new WP_Query( $query_args );

		// Start the Loop
		global $post;

		// Process output
		if( $ubflw_query->have_posts() ) {

			ob_start();
			echo '<div class="facetwp-template">';
			foreach ($ubflw_query->posts as $key => $annonce) {

				$key++;// pour éviter le 0

				$photo 	=	wp_get_attachment_image_src(
								get_post_thumbnail_id(  $annonce->ID ),
								'portfolio_small'
							);

				// extraire toutes les infos de l'annonce
				$annonces_details 	= get_post_meta($annonce->ID, '' , true);
				$lien_annonce 		= 'href="'.get_permalink($annonce->ID).'"';

				// fin de row
				$row_annonce_sw = $key%$nb_colonnes;
				switch ($row_annonce_sw) {
					case 0:
						$annonce_row = "last_annonce";
						break;

					case 1:
						$annonce_row = "first_annonce";
						break;

					default:
						$annonce_row = "";
						break;
				}

				// destroy old variables
				// j'avais un problème avec extract() : (que j'aime pas d'ailleurs)
				// les anciennes variables restent actives et cela pose un problème d'affichage
				// $$key c'est énorme ça créé une variable…
				// https://stackoverflow.com/questions/24855266/unset-extract-variables-in-php-from-within-class-method
				if( isset($details_annonce) && $details_annonce ){
					foreach ($details_annonce as $old => $old_value) {
						unset($$old); // détruire la variable
					}
				}

				//"first_annonce"
				foreach ($annonces_details as $detail => $value) {
					$details_annonce[$detail]=end($value);
					$$detail=end($value); // truc génial pour créer une variable =)
				}

				include( ubflw_get_front_template( "template-annonces.php" ) );

			}
			// récupération valeur du bouton radio pour filtrer
			// https://gist.github.com/djrmom/1321763f4e600456de371f3801824733
			echo'
			<script>
		        (function($) {
		            $(document).on(\'facetwp-loaded\', function() {
		                if (\'undefined\' !== typeof FWP.extras.sort ) {
		                    $( \'.facetwp-sort-radio input:radio[name="sort"]\').filter(\'[value="\'+FWP.extras.sort+\'"]\').prop("checked", true);
		                }
		            });
		            // Sorting
		            $(document).on(\'change\', \'.facetwp-sort-radio input\', function() {
		                FWP.extras.sort = $(this).val();
		                FWP.soft_refresh = true;
		                FWP.autoload();
		            });
		        })(jQuery);
			</script>';

			// pagination
			$big = 999999;
			$pagination = paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, $paged ),
				'total' => $ubflw_query->max_num_pages,
				'prev_text' => '&#171 ',
				'next_text' => ' &#187',
				//'type' => 'list'
			) );

			echo '<div class="pagination">'.$pagination.'</div>';
			echo '</div>';

			return ob_get_clean();

		}else{
			return '<p>Aucune annonce !</p>';
		}
	}

	/**
	 * return template fiche annonce seul
	 *
	 * @param   object
	 *
	 * @return 	string
	 */
	public function run_template_fiche_annnonce( $content ) {

		if( is_singular('annonce_immo') ){

			global $post;

			ob_start();
			// extraire toutes les infos de l'annonce
			$annonces_details 	= get_post_meta($post->ID, '' , true);
			$lien_annonce 		= 'href="'.get_permalink($post->ID).'"';
			$photos 			= get_attached_media('image', $post->ID);

			$details_annonce = array();

			foreach ($annonces_details as $detail => $value) {
				$details_annonce[$detail]=end($value);
			}

			extract($details_annonce);

			include( ubflw_get_front_template( "template-fiche-annonce.php" ) );

			$content = ob_get_clean();

		}
		return $content;
	}

	/**
	* Ajout immo détails
	*
	* @return html
 	**/
    public function fiche_annonce_details(){

        global $post;
        if($post->post_type=='annonce_immo'){

			global $description_WPublfwParser;
	        $meta_bien 		= get_post_custom($post->ID);
	        $keys_to_swap 	= array( 'ville', 'code_insee', 'pays', 'departement', 'zone_geo' );
	        ?>
	        <ul>
	        <?php
	        foreach ($meta_bien as $key => $value) {

	        	$meta_expl = explode( 'annonce_' ,$key);
	        	if( empty($meta_expl[0]) ){
	        		//chaine vie : champ trouvé
	        		$key_field = $meta_expl[1];

		            if( in_array( $key_field, $keys_to_swap ) ) { continue; }

		            if( array_key_exists( $key_field, $description_WPublfwParser ) ){

		                // la dernière valeur du tableau est forcément la bonne on peut mettre [0] aussi
		                $value = end($value);

		                if(  $value == 'true' ){
		                    $value = 'Oui';
		                }elseif( $value == 'false'){
		                    $value = '';
		                }

		                if( !empty($value) ) :

		                    $field = $description_WPublfwParser[$key_field]; //nom du champ

		                    // ajout unité de mesure au champ si nécessaire et autre
		                    if( is_array($field) ){

		                        $field_name = $field["name"];
		                        $unit       = $field["unit"];

		                        switch ($unit) {
		                            case 'PRICE': // c'est un prix
		                                $value .'&nbsp;€';
		                                break;

		                            case false: // ne pas afficher
		                                $value = false;
		                                break;

		                            default: // valeur avec unité de mesure
		                                $value . $field["unit"];
		                                break;
		                        }

		                    }else{
		                        $field_name=$field;
		                    }

		                    if( $value !== false ) {
		                    ?>
		                    <li class="<?php echo ' field_'. $key_field ;?>">
		                        <?php
		                        echo '<mark>'.mb_ucfirst($field_name) .'</mark> '.
		                        mb_ucfirst($value);
		                        ?>
		                    </li>
		                    <?php
		                    }
		                endif;
		            }
	        	}
	        }
	        ?>
	    	</ul>
	    <?php
    	}
    }


	/**
	* Ajout immo diagnostic
	*
	* @return html
 	**/
    public static function fiche_annonce_diagnostic(){

    	global $post;
        if($post->post_type=='annonce_immo'){

			global $diagnostic_WPublfwParser;
			$meta_bien 		= get_post_custom($post->ID);

	        foreach ( $diagnostic_WPublfwParser as $description => $value) {

	        	if($description == 'soumis_dpe'){

	        		if( !isset($meta_bien[$description])
	        			|| end($meta_bien[$description])=='false' ){
	        			?>
                        <div class="no_dpe">
                        	Non Soumis au DPE !
                        </div>
                        <?php
	        			break;
	        		}

	        	}

                $value_meta = end($meta_bien[$description]);

                // ajout unité de mesure pour DPE et GES
                if( is_array( $value ) ){
                    $value_meta = $value_meta .'&nbsp;'.$value["unit"];
                    $value      = $value["name"];
                }

                // ajout de la classe
                $class_add = sanitize_text_field($description);

                //chercher si dpe ou ges
                $seek_to_dpe_ges = strtolower($value);

                $dpe_etiquette_conso =  $meta_bien['dpe_etiquette_conso'];
                $dpe_etiquette_ges   =  $meta_bien['dpe_etiquette_ges'];

                // passer à l'itération suivante si vide
				if( empty($dpe_etiquette_conso) || empty($dpe_etiquette_ges) ){ continue; }

                if(  ($seek_to_dpe_ges=='dpe' || $seek_to_dpe_ges=='ges')){

                    if( $seek_to_dpe_ges=='dpe'){

						$letter_conso = end($dpe_etiquette_conso);

                    ?>
                        <div class="grille_dpe dpe_<?php echo strtolower($letter_conso); ?>">
                            <ul>
                                <li class="dpe_tableau" >
                                    <div class="dpe_fleche dpe_consommation_a">
                                        <span class="info">&lt;51</span>
                                        <span class="lettre"> A</span>
                                    </div>
                                    <div class="dpe_fleche dpe_consommation_b">
                                        <span class="info">51 à 90</span>
                                        <span class="lettre"> B</span>
                                    </div>
                                    <div class="dpe_fleche dpe_consommation_c">
                                        <span class="info">91 à 150</span>
                                        <span class="lettre"> C</span>
                                    </div>
                                    <div class="dpe_fleche dpe_consommation_d">
                                        <span class="info">151 à 230</span>
                                        <span class="lettre"> D</span>
                                    </div>
                                    <div class="dpe_fleche dpe_consommation_e">
                                        <span class="info">231 à 330</span>
                                        <span class="lettre"> E</span>
                                    </div>
                                    <div class="dpe_fleche dpe_consommation_f">
                                        <span class="info">331 à 450</span>
                                        <span class="lettre"> F</span>
                                    </div>
                                    <div class="dpe_fleche dpe_consommation_g">
                                        <span class="info">&gt;450</span>
                                        <span class="lettre"> G</span>
                                    </div>
                                </li>

                                <li class="dpe_logement <?php echo $class .' field_'.$class_add ;?>">
                                    <input class="dpe_etiquette_conso" type="hidden" value="<?php echo $letter_conso; ?>">
                                <?php
                                    echo '<mark>' . $value . '</mark>' .
                                         '<span class="value_' . $class_add .'">' .
                                         '<strong> ' . $value_meta . '</strong>' .
                                         '</span>';
                                ?>
                                </li>
                            </ul>
                        </div>
                    <?php
                    }// DPE

                    if( $seek_to_dpe_ges=='ges'){

						$letter_ges = end($dpe_etiquette_ges);
                    ?>
                        <div class="grille_ges ges_<?php echo strtolower($letter_ges); ?>">
                            <ul>
                                <li class="ges_tableau" >
                                    <div class="ges_fleche ges_consommation_a">
                                        <span class="info">&lt;6</span>
                                        <span class="lettre"> A</span>
                                    </div>
                                    <div class="ges_fleche ges_consommation_b">
                                        <span class="info">6 à 10</span>
                                        <span class="lettre"> B</span>
                                    </div>
                                    <div class="ges_fleche ges_consommation_c">
                                        <span class="info">11 à 20</span>
                                        <span class="lettre"> C</span>
                                    </div>
                                    <div class="ges_fleche ges_consommation_d">
                                        <span class="info">21 à 35</span>
                                        <span class="lettre"> D</span>
                                    </div>
                                    <div class="ges_fleche ges_consommation_e">
                                        <span class="info">36 à 55</span>
                                        <span class="lettre"> E</span>
                                    </div>
                                    <div class="ges_fleche ges_consommation_f">
                                        <span class="info">56 à 80</span>
                                        <span class="lettre"> F</span>
                                    </div>
                                    <div class="ges_fleche ges_consommation_g">
                                        <span class="info">&gt;80</span>
                                        <span class="lettre"> G</span>
                                    </div>
                                </li>

                                <li class="ges_logement <?php echo $class .' field_'.$class_add ;?>">
                                    <input class="dpe_etiquette_ges" type="hidden" value="<?php echo $letter_ges; ?>">
                                <?php
                                    echo '<mark>' . $value . '</mark>' .
                                         '<span class="value_' . $class_add .'">' .
                                         '<strong> ' . $value_meta . '</strong>' .
                                         '</span>';
                                ?>
                                </li>
                            </ul>
                        </div>
                    <?php
                    }// GES

                }// test GES DPE

	        } // for each
    	}// post annonce_immmo
    }

    /**
     *
     *  test elégibilité DPE
     *
     *  @param int $id - id du noeud parent
     *  @param xml $annonce - l'annonce
     *
     *  @return bool
     *
     **/
    public static function is_dpe_ok( $soumis_dpe ){

        if( !empty($soumis_dpe) ){

            $soumis_dpe == 'true' ? $soumis_dpe : $soumis_dpe = false;

            if($soumis_dpe===false){
                return false;
            }else{
                return true;
            }

        }else{
            return false;
        }
    }


}

new UBFLW_annonces();