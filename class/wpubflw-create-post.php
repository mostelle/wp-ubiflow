<?php

defined( 'ABSPATH' ) OR exit; //disallow direct file access when core isn't loaded

require_once WPUBIPATH	. 'core/wpubflw-functions-posts.php';
require_once WPUBIPATH	. 'class/wpubflw-categories-no-deletion.php';
require_once WPUBIPATH	. 'views/datafields_immo.php';
require_once WPUBIPATH	. 'class/wpubflw-shortcodes.php';

class WPUBI_post
{
	public $annonces 	= 'annonces';
	public $annonce 	= 'annonce';

	public $vente 		= 'vente';
	public $location 	= 'location';

	public $cats_vente 	= array( 'viager', 'vente de neuf', 'vente de fonds de commerce' );
	public $cats_loca 	= array( 'location saisonnière', 'cession de bail' );

	public $remplacement = 3928; // ID photo remplacement

	public function __construct( ){

		add_action( 'init', array( $this, 'cpt_annonce_immo'), 1 );
		add_filter( 'init', array( $this, 'register_annonce_immo_taxonomy'), 2 );
		add_filter( 'init', array( $this, 'create_code_type_taxonomies'), 3 );
    	add_action( 'admin_init', array( $this, 'admin_init_meta_box_annonce') );
    	//add_action( 'save_post', array( $this, 'save_meta_box_annonce' ) );

		add_action( 'init', array( $this, 'no_categories_deletion') );

		add_action( 'template_redirect', array( $this, 'redirection_annonce') );

		add_action( 'init', array( $this, 'ubflw_create_cat' ) );

		add_filter( 'manage_annonce_immo_posts_columns', array( $this, 'ubflw_photo_ref_id_column'), 15 );
		add_action( 'manage_annonce_immo_posts_custom_column', array( $this, 'ubflw_photo_ref_id_column_content'), 10, 2 );
		add_filter( 'manage_edit-annonce_immo_sortable_columns', array($this, 'sortable_column_annonce_ville') );
		add_action( 'pre_get_posts', array($this, 'annonce_immo_orderby') );

		//add_action( 'admin_init', array( $this, 'insert_annonce_immo_db' ) );

		add_action( 'wp_ajax_wpubflw_launch_flux', array($this, 'wpubflw_launch_flux') );

		add_action( 'trashed_post',  array($this, 'cpt_delete_attached_trashed_annonces'), 20, 1 );

	}

	/**
	* suppression des fichiers attaché lors de la mise à la corbeille de l'annonce
	* cette fonction supprime les fichiers
	* @return bool / void
	**/
	public function cpt_delete_attached_trashed_annonces( $post_id ) {

		// gets ID of post being trashed
		$post_type = get_post_type( $post_id );

		// does not run on other post types { $post }
		if ( $post_type != 'annonce_immo' ) {
			return true;
		}

		$media = get_children( array(
					        'post_parent' => $post_id,
					        'post_type'   => 'attachment'
					    ) );

	    if( !empty( $media ) ) {
	        foreach( $media as $file ) {
		        wp_trash_post( $file->ID );
		        //wp_delete_attachment( $file->ID, true );
		        //delete_post_meta( $file->ID, '_wp_attached_file' );
		        //delete_post_meta( $file->ID, '_wp_attachment_metadata' );
		    }
	    }
	}

	/**
	* lancement du flux
	* @return string (ajax "OK")
	**/
	public function wpubflw_launch_flux(){
		$insert_annonce_immo_db = $this->insert_annonce_immo_db();
		return $insert_annonce_immo_db;
	}

	/**
	* Création des catégories
	*
	* @return Void
 	**/
	public function ubflw_create_cat(){

		$get_cat_ids = $this->get_cat_ids();
		// si vide = première fois
		// lancement de la création des catégories : vente + location
		if ( empty($get_cat_ids) ){

			$get_terms_annonces = $this->get_terms_annonces();

			// suppression des catégories
			if( !empty($get_terms_annonces) ){
				foreach ($get_terms_annonces as $key => $term) {
					wp_delete_term( $term->term_id, $this->annonces );
				}
			}

			$arr_id_cat = array();

			//création des catégories parentes
			$vente 		= wp_insert_term(
							$this->vente,
							$this->annonces, array( 'slug' => $this->vente )
						);

			$arr_id_cat[ $this->vente ] = $vente['term_id'];


			$location 	= wp_insert_term(
							$this->location,
							$this->annonces,
							array( 'slug' => $this->location )
						);

			$arr_id_cat[ $this->location ] = $location['term_id'];

			// sous catégories vente
			foreach ($this->cats_vente as $name_cat_vente) {
				$vente_sscat_id = 
					wp_insert_term(
						$name_cat_vente,
						$this->annonces,
						array(
							'slug' => $name_cat_vente,
							'parent'=> $vente['term_id']
						)
					);

				$arr_id_cat[ $name_cat_vente ] = $vente_sscat_id['term_id'];
			}

			// sous catégories location
			foreach ($this->cats_loca as $name_cat_loca) {
				$loca_sscat_id = 
					wp_insert_term(
						$name_cat_loca,
						$this->annonces,
						array(
							'slug' => $name_cat_loca,
							'parent'=> $location['term_id']
						)
					);

				$arr_id_cat[ $name_cat_loca ] = $loca_sscat_id['term_id'];
			}

			// update option catégories
			$this->set_cat_ids( $arr_id_cat );

		}

    }

    /**
	* récupération des catégories d'annonces
	*
	* @return array
 	**/
    private function get_terms_annonces(){
	    $terms = get_terms  ( 	array(
									'taxonomy' => $this->annonces,
						    		'hide_empty' => false
						    	)
							);
	    return $terms;
	}

    /**
     *
     *  update option liste catégories ID et Nom
     *
     *  @param  array
     *	@return Void
     **/
    protected function set_cat_ids( $arr_id_cat )
    {
        update_option( 'id_name_cats_immo', $arr_id_cat);
    }

    /**
     *
     *  get option liste catégories ID et Nom
     *
     *	@return array
     **/
    protected function get_cat_ids()
    {
        return get_option( 'id_name_cats_immo' );
    }

	/**
	* Custom Post Type des annonces immo
	*
	* @return Void
 	**/
	public function cpt_annonce_immo() {

		$labels = array(
			'name'                => __( 'Annonces' ),
			'singular_name'       => __( 'Annonce' ),
			'menu_name'           => __( 'Annonces' ),
			'parent_item_colon'   => __( 'Parent Annonce' ),
			'all_items'           => __( 'Annonces' ),
			'view_item'           => __( 'Voir Annonce' ),
			'add_new_item'        => __( 'Ajouter Nouvelle Annonce' ),
			'add_new'             => __( 'Ajouter Nouvelle' ),
			'edit_item'           => __( 'Editer Annonce' ),
			'update_item'         => __( 'Mettre à Jour Annonce' ),
			'search_items'        => __( 'Chercher Annonce' ),
			'not_found'           => __( 'Non Trouvé' ),
			'not_found_in_trash'  => __( 'Non Trouvé dans la poubelle' ),
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-admin-home',
			'rewrite' => array('slug' => $this->annonce),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		);

		register_post_type( 'annonce_immo', $args );

	}

	/**
	* Taxonomie des annonces immo ( Catégorie )
	*
	* @return Void
 	**/
	public function register_annonce_immo_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Catégories Annonces', 'Taxonomy General Name' ),
			'singular_name'              => _x( 'Catégorie Annonce', 'Taxonomy Singular Name' ),
			'menu_name'                  => __( 'Catégories Annonces' ),
			'all_items'                  => __( 'Catégories' ),
			'parent_item'                => __( 'Catégorie Parente' ),
			'parent_item_colon'          => __( 'Catégorie Parente :' ),
			'new_item_name'              => __( 'Nom Catégorie' ),
			'add_new_item'               => __( 'Ajout Catégorie' ),
			'edit_item'                  => __( 'Editer Catégorie' ),
			'update_item'                => __( 'Maj. Catégorie' ),
			'view_item'                  => __( 'Voir Catégorie' ),
			'separate_items_with_commas' => __( 'Catégories séparées par virgule' ),
			'add_or_remove_items'        => __( 'Ajouter ou Supprimer Catégories' ),
			'choose_from_most_used'      => __( 'Les + utilisées' ),
			'popular_items'              => NULL,
			'search_items'               => __( 'Chercher Catégories' ),
			'not_found'                  => __( 'Non Trouvé' ),
			'most_used'                  => __( 'Les + utilisées' ),
		);

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'query_var'                  => true,
			'capabilities'               => array(
				'manage_terms' => 'edit_posts',
				'edit_terms'   => 'edit_posts',
				'delete_terms' => 'edit_posts',
				'assign_terms' => 'edit_posts'
			),

		);
		// changer le nom ici pour changer le slug plutot que de faire un rewrite
		register_taxonomy( $this->annonces, array( 'annonce_immo' ), $args );
	}


	// create two taxonomies, genres and writers for the post type "book"
	public function create_code_type_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Types de bien', 'taxonomy general name' ),
			'singular_name'     => _x( 'Type de bien', 'taxonomy singular name' ),
			'search_items'      => __( 'Chercher Types' ),
			'all_items'         => __( 'Tous Types' ),
			'parent_item'       => __( 'Parent Type' ),
			'parent_item_colon' => __( 'Parent Type:' ),
			'edit_item'         => __( 'Editer Type' ),
			'update_item'       => __( 'Maj. Type' ),
			'add_new_item'      => __( 'Ajouter Nouveau Type' ),
			'new_item_name'     => __( 'Nom Type' ),
			'menu_name'         => __( 'Type' ),
			'most_used'         => __( 'Les + utilisées' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'type' ),
		);

		register_taxonomy( 'type', array( 'annonce_immo' ), $args );

	}

	/**
	* Ajout colonnes photo référence Id annnonce
	*
	* @return array
	**/
	public function ubflw_photo_ref_id_column($columns){

		$myCustomColumns = array(
		   'link_annonce' => '',
		   'photo_annonce' => __( 'Photo'),
		   'annonce_ville' => __( 'Ville'),
		   'ref_annonce' => __( 'Réf.'),
		   'id_annonce' => __( 'ID Ubiflow')
	   	);
		// tri colonnes
		$column_0   = array_slice( $columns, 0, 1 ); // je coupe les cases à cocher
		$column_1   = array_slice( $columns, 1 ); // la position de la colonne se trouve là
		$columns = array_merge( $column_0, $myCustomColumns, $column_1 );

	   return $columns;
	}

	/**
	* Contenu colonnes photo référence Id annnonce
	*
	* @return array
	**/
	public function ubflw_photo_ref_id_column_content($column_name, $post_ID){
		if ($column_name == 'link_annonce') {
			echo '<a href="' . get_permalink( $post_ID ) . '" title="Voir annonce ' . esc_attr( get_the_title( $post_ID ) ) . '" target="_blank">';
			echo '<span class="dashicons dashicons-visibility"></span>';
			echo '</a>';
		}
		if ($column_name == 'photo_annonce') {
			echo '<a href="' . get_edit_post_link( $post_ID ) .'">';
			echo get_the_post_thumbnail( $post_ID, 'thumbnail' );
			echo '</a>';
		}
		if ($column_name == 'ref_annonce') {
			echo '<a href="' . get_edit_post_link( $post_ID ) .'">';
			echo get_post_meta( $post_ID, 'reference', true );
			echo '</a>';
		}
		if ($column_name == 'id_annonce') {
			echo '<a href="' . get_edit_post_link( $post_ID ) .'">';
			echo get_post_meta( $post_ID, 'id_annonce', true );
			echo '</a>';
		}
		if ($column_name == 'annonce_ville') {
			echo get_post_meta( $post_ID, 'annonce_ville', true );
		}
	}

	/**
	* Rendre filtrable par nom la colonne des villes
	*
	* @param object
	* @return void
 	**/
	public function sortable_column_annonce_ville( $columns ) {

		$columns['annonce_ville'] = 'annonce_ville';
		//To make a column 'un-sortable' remove it from the array
		//unset($columns['annonce_ville']);
		return $columns;
	}

	/**
	* Modifier la requete query des custom post pour les villes
	*
	* @param object
	* @return void
 	**/
	public function annonce_immo_orderby( $query ) {
		if( ! is_admin() )
		    return;

		$orderby = $query->get( 'orderby');

		if( 'annonce_ville' == $orderby ) {
		    $query->set('meta_key','annonce_ville');
		    $query->set('orderby','meta_value');
		}
	}

	/**
	* Redirection vers accueil si page toutes annonce
	*
	* @return void
 	**/
	public function redirection_annonce(){

		global $post, $wpubflw_option;

		if( is_archive() && $post->post_type=='annonce_immo' ){

			$url = $_SERVER["REQUEST_URI"];
			$slugs = explode( '/',  $url );
			$clean_slugs = array_filter($slugs);

			if( end($clean_slugs)==$this->annonce ){
				$link = $wpubflw_option['page-des-annonces'];
				$url_link = get_permalink( intval($link) );
				wp_safe_redirect( $url_link, 301 );
			}
		}
	}

	/**
	* Ajout immo meta-box
	*
	* @return Void
 	**/
    public function admin_init_meta_box_annonce(){
        add_meta_box(	"infos-meta",
	        			"Infos",
	        			array($this,"meta_box_annonce_infos"),
	        			"annonce_immo",
	        			"side",
	        			"high" );

        add_meta_box(	"images-meta",
        				"Images",
        				array($this,"meta_box_annonce_images"),
        				"annonce_immo",
        				"normal",
        				"low" );

        add_meta_box(	"details-meta",
        				"Détail",
        				array($this,"meta_box_annonce_details"),
        				"annonce_immo",
        				"normal",
        				"low" );

        add_meta_box(	"diagnostic-meta",
        				"Diagnostic",
        				array($this,"meta_box_annonce_diagnostic"),
        				"annonce_immo",
        				"normal",
        				"low" );
    }

	/**
	* Ajout immo meta-box infos
	*
	* @return html
 	**/
    public function meta_box_annonce_infos(){

        global $post;
        if( $post->post_type=='annonce_immo' ){

	        $meta_bien = get_post_custom($post->ID);

	        $prix 				= end($meta_bien["prix"]);
	        $loyer 				= end($meta_bien["loyer_mensuel_cc"]);
	        $id_annonce 		= end($meta_bien["id_annonce"]);
	        $reference 			= end($meta_bien["reference"]);
	        $mandat_numero 		= end($meta_bien["mandat_numero"]);
	        $mandat_type 		= end($meta_bien["mandat_type"]);
	        $code_type 			= end($meta_bien["code_type"]);
	        $type 				= end($meta_bien["type"]);
	        $date_integration 	= end($meta_bien["date_integration"]);

		?>
			<p>
				<span class="tag_field">Date d'intégration </span>
				<strong><?php echo $date_integration; ?></strong>
			</p>
			<p>
				<span class="tag_field">ID annonce </span>
				<strong><?php echo $id_annonce; ?></strong>
			</p>
			<p>
				<span class="tag_field">Référence </span>
				<strong><?php echo $reference; ?></strong>
			</p>
			<p>
				<span class="tag_field">Mandat n° </span>
				<strong><?php echo $mandat_numero; ?></strong>
			</p>
			<p>
				<span class="tag_field">Type Mandat </span>
				<strong><?php echo $mandat_type; ?></strong>
			</p>
			<p>
				<span class="tag_field">Type & Code Type </span>
				<strong><?php echo $type . ' ' . $code_type; ?></strong>
			</p>
			<p>
			<?php
			if(empty($loyer)){ ?>
				<span class="tag_field">Prix </span>
				<?php /*<input name="prix" value="<?php echo number_format( floatval( $prix ), 2, ",", " "); ?>" />&nbsp;€ */?>
				<strong name="prix"><?php echo number_format( floatval( $prix ), 2, ",", " "); ?>&nbsp;€</strong>
			<?php
			}else{ ?>
				<span class="tag_field">Loyer </span>
				<?php /* <input name="loyer" value="<?php echo number_format( floatval( $loyer) , 2, ",", " "); ?>" />&nbsp;€ */ ?>
				<strong name="loyer"><?php echo number_format( floatval( $loyer) , 2, ",", " "); ?>&nbsp;€</strong>
			<?php
			}
			?>
			</p>
	    <?php
    	}
    }

	/**
	* Ajout immo meta-box images
	*
	* @return html
 	**/
    public function meta_box_annonce_images(){
    	global $post;
        if($post->post_type=='annonce_immo'){
        	add_thickbox();
        	$images = get_attached_media( 'image', $post->ID );
        	foreach ( $images as $attachment_id => $attachment ) {
				$thumbnail 	= wp_get_attachment_image( $attachment_id, 'thumbnail' );
				$imglarge 	= wp_get_attachment_image( $attachment_id, 'large' );
				$large 		= wp_get_attachment_image_src( $attachment_id, 'large' );
				$width 		= $large[1];
				$height 	= $large[2];

				?>
				<div id="<?php echo $attachment_id; ?>" style="display:none">
					<?php echo $imglarge; ?>
				</div>
				<a href="#TB_inline?<?php echo 'width='.$width.'&height='.$height.'&inlineId='.$attachment_id; ?>" class="thickbox">
				<?php
					echo $thumbnail;
				?>
				</a>
				<?php
			}
			?>
			<script>
			jQuery( 'thickbox' ).on('click', function( ) {
				$("#TB_ajaxContent .attachment-large.size-large").height("auto");
			} );
			</script>
			<?php

        }
    }

	/**
	* Ajout immo meta-box détails
	*
	* @return html
 	**/
    public function meta_box_annonce_details(){

        global $post;
        if($post->post_type=='annonce_immo'){

			global $description_WPublfwParser;
	        $meta_bien 		= get_post_custom($post->ID);
	        ?>
	        <ul>
	        <?php
	        foreach ($meta_bien as $key => $value) {

	        	$meta_expl = explode( 'annonce_' ,$key);
	        	if( empty($meta_expl[0]) ){
	        		//chaine vie : champ trouvé
	        		$key_field = $meta_expl[1];

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
	* Ajout immo meta-box diagnostic
	*
	* @return html
 	**/
    public function meta_box_annonce_diagnostic(){

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
                    $value_meta_ok = $value_meta .'&nbsp;'.$value["unit"];
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
                        <div class="grille_dpe dpe <?php echo strtolower($letter_conso); ?>">
                            <strong class="title">Consommation énergétique</strong>
                            <div class="row">
                            	<em class="left information">Logement économe</em>
                            	<em class="right information">Logement</em>
                            </div>
							<div class="letters">
								<div class="letter-a">
								  <div class="line"><em>&lt; 50</em><strong>A</strong></div>
								  <div class="sticker"><?php if( $value_meta <= 50 ){ $sticker = "A"; }else{ $sticker = $value_meta; } echo $sticker; ?></div>
								</div>
								<div class="letter-b">
								  <div class="line"><em>51 à 90</em><strong>B</strong></div>
								  <div class="sticker"><?php if( $value_meta >=51 && $value_meta <=90 ){ $sticker = $value_meta; }else{ $sticker = "B"; } echo $sticker; ?></div>
								</div>
								<div class="letter-c">
								  <div class="line"><em>91 à 150</em><strong>C</strong></div>
								  <div class="sticker"><?php if( $value_meta >=91 && $value_meta <=150 ){ $sticker = $value_meta; }else{ $sticker = "C"; } echo $sticker; ?></div>
								</div>
								<div class="letter-d">
								  <div class="line"><em>151 à 230</em><strong>D</strong></div>
								  <div class="sticker"><?php if( $value_meta >=151 && $value_meta <=230 ){ $sticker = $value_meta; }else{ $sticker = "D"; } echo $sticker; ?></div>
								</div>
								<div class="letter-e">
								  <div class="line"><em>231 à 330</em><strong>E</strong></div>
								  <div class="sticker"><?php if( $value_meta >=231 && $value_meta <=330 ){ $sticker = $value_meta; }else{ $sticker = "E"; } echo $sticker; ?></div>
								</div>
								<div class="letter-f">
								  <div class="line"><em>331 à 450</em><strong>F</strong></div>
								  <div class="sticker"><?php if( $value_meta >=331 && $value_meta <=450 ){ $sticker = $value_meta; }else{ $sticker = "F"; } echo $sticker; ?></div>
								</div>
								<div class="letter-g">
								  <div class="line"><em>&gt; 450</em><strong>G</strong></div>
								  <div class="sticker"><?php if( $value_meta <=450 ){ $sticker = $value_meta; }else{ $sticker = "G"; } echo $sticker; ?></div>
								</div>
							</div>
							<em class="information">Logement énergivore</em><br/>
							<em class="information">Valeur exprimée en kWhEP/m².an</em>
						</div>

                    <?php
                    }// DPE

                    if( $seek_to_dpe_ges=='ges'){

						$letter_ges = end($dpe_etiquette_ges);
                    ?>
            			<div class="grille_ges ges <?php echo strtolower($letter_ges); ?>">
                            <strong class="title">Consommation énergétique</strong>
                            <div class="row">
                            	<em class="left information">Faible émission de GES</em>
                            	<em class="right information">Logement</em>
                            </div>
							<div class="letters">
								<div class="letter-a">
								  <div class="line"><em>&lt; 6</em><strong>A</strong></div>
								  <div class="sticker"><?php if( $value_meta <= 6 ){ $sticker = "A"; }else{ $sticker = $value_meta; } echo $sticker; ?></div>
								</div>
								<div class="letter-b">
								  <div class="line"><em>6 à 10</em><strong>B</strong></div>
								  <div class="sticker"><?php if( $value_meta >6 && $value_meta <=10 ){ $sticker = $value_meta; }else{ $sticker = "B"; } echo $sticker; ?></div>
								</div>
								<div class="letter-c">
								  <div class="line"><em>11 à 20</em><strong>C</strong></div>
								  <div class="sticker"><?php if( $value_meta >11 && $value_meta <=20 ){ $sticker = $value_meta; }else{ $sticker = "C"; } echo $sticker; ?></div>
								</div>
								<div class="letter-d">
								  <div class="line"><em>21 à 35</em><strong>D</strong></div>
								  <div class="sticker"><?php if( $value_meta >21 && $value_meta <=35 ){ $sticker = $value_meta; }else{ $sticker = "D"; } echo $sticker; ?></div>
								</div>
								<div class="letter-e">
								  <div class="line"><em>36 à 55</em><strong>E</strong></div>
								  <div class="sticker"><?php if( $value_meta >36 && $value_meta <=55 ){ $sticker = $value_meta; }else{ $sticker = "E"; } echo $sticker; ?></div>
								</div>
								<div class="letter-f">
								  <div class="line"><em>56 à 80</em><strong>F</strong></div>
								  <div class="sticker"><?php if( $value_meta >56 && $value_meta <=80 ){ $sticker = $value_meta; }else{ $sticker = "F"; } echo $sticker; ?></div>
								</div>
								<div class="letter-g">
								  <div class="line"><em>&gt; 80</em><strong>G</strong></div>
								  <div class="sticker"><?php if( $value_meta <80 ){ $sticker = $value_meta; }else{ $sticker = "G"; } echo $sticker; ?></div>
								</div>
							</div>
							<em class="information">Forte émission de GES</em><br/>
							<em class="information">Valeur exprimée en KgeqCO2/m².an</em>
						</div>

                    <?php
                    }// GES

                }// test GES DPE

	        } // for each
    	}// post annonce_immmo
    }

	/**
	* Save annonce immo meta-box
	*
	* @return Void
 	**/
	public function save_meta_box_annonce(){
	    global $post;
	    if ( isset($post) && $post->post_type=='annonce_immo' && isset($_POST["prix"] ) ){
	    	update_post_meta($post->ID, "prix", $_POST["prix"]);
	    }
	}

	/**
	* Insertion d'une annonces immo dans la base de données
	* La magie opère ici : création et insertion des annonces
	*
	* @return void
 	**/
	public function insert_annonce_immo_db(){

		// définir temps éxécution script
		set_time_limit(0); // 0 = pas de limite

		require_once WPUBIPATH . 'class/wpubflw-url-parser.php';
		require_once WPUBIPATH . 'views/code_type.php';

		// mise en mode maintenance ON
		/*
		if( !file_exists( ABSPATH.'.maintenance' ) ){
			copy(WPUBIPATH . 'views/.maintenance', ABSPATH.'.maintenance');
		}
		*/
		global $wpubflw_option;

		$url_brut 		 = $wpubflw_option['flux-url-text'];
		$number_annonces = intval($wpubflw_option['number-annonce-min']);
		$url_array 		 = explode("|", $url_brut);
		$id_annonces 	 = array();

		foreach ($url_array as $url) {

			$trim_url = trim($url);
			$WPublfwParser  = new WPublfwParser($trim_url);
			$annonces_xml  	= $WPublfwParser->annonces_flux_XML();

			if( $annonces_xml && count($annonces_xml)>=$number_annonces ){

				foreach ( $annonces_xml as $key => $annonce ) {

					// récupère l'attribut ID et le transforme en chaîne et en entier
					$id_annonce 	  = intval( $annonce->attributes()->id->__toString() );

					// stockage dans un tableau des ID annonces,
					// pour supprimer les annonces obsolètes plus tard
					$id_annonces[] = $id_annonce;

					// date intégration
					$date_integration = $WPublfwParser::to_string_node_value(
											$annonce->xpath("//*[@id='$id_annonce']//date_integration")
										  );

					/**
					*  l'annonce existe-t-elle ?
					*	https://wordpress.stackexchange.com/questions/121154/check-if-meta-key-value-already-exists
					**/
					$args = array(
						'post_type' => 'annonce_immo',
						'meta_query' => array(
							array(
								'key' => 'id_annonce',
								'value' => $id_annonce
							)
						),
						'fields' => 'ids'
					);
					$query = new WP_Query( $args );
					$duplicates = $query->posts;

					// si annonce existe déjà
					if ( ! empty( $duplicates ) ) {
						// en toute logique il ne peut y en avoir q'une seule identique
						$post_id = intval($duplicates[0]);
						// récupérer date existante
						$date_int_post = get_post_meta( $post_id, 'date_integration', true );

						if( $date_int_post == $date_integration){
							// si date identique on passe à l'annonce suivante
							continue;

						}else{
							// sinon on supprime tout - l'annonce sera réintégré
							$media = get_children( array(
						        'post_parent' => $post_id,
						        'post_type'   => 'attachment'
						    ) );

						    if( !empty( $media ) ) {
						        foreach( $media as $file ) {
							        wp_delete_attachment( $file->ID, true );
							        delete_post_meta( $file->ID, '_wp_attached_file' );
							        delete_post_meta( $file->ID, '_wp_attachment_metadata' );
							    }
						    }
						    // effacement du post apres car sinon on perds le lien de l'attachment
						    wp_delete_post( $post_id, true );
						}
					}

					// texte annonce
					$texte_brut 	= $WPublfwParser::to_string_node_value(
										$annonce->xpath("//*[@id='$id_annonce']//texte")
									  );
					$texte 			= $WPublfwParser::clean_description( $texte_brut );

					// titre
					$titre_brut 	= $WPublfwParser::to_string_node_value(
										$annonce->xpath("//*[@id='$id_annonce']//titre")
									  );
					$titre 			= $WPublfwParser::clean_titre( $titre_brut );

					// Vente ou Location
					$type 			= $WPublfwParser::to_string_node_value(
											$annonce->xpath("//*[@id='$id_annonce']//type")
									  );

					$location = get_terms( array(
						'taxonomy' 		=> $this->annonces,
						'slug' 			=> $this->location,
						'hide_empty' 	=> false,
					) );

					$vente = get_terms( array(
						'taxonomy' 		=> $this->annonces,
						'slug' 			=> $this->vente,
						'hide_empty' 	=> false,
					) );

					// deux parents principaux les autres sont des sous-catégories
					switch ($type) {
						case 'V': // "Vente" -- parent
						case 'W': // "Viager"
						case 'G': // "Vente de neuf"
						case 'F': // "Vente de Fonds de commerce"
							$category_id = $vente[0]->term_id;
							break;
						case 'L': // "Location" -- parent
						case 'S': // "Location Saisonnière"
						case 'B': // "Cession de Bail"
							$category_id = $location[0]->term_id;
							break;
						default:
							$category_id = false;
							break;
					}

					if( $category_id != false ){

						$annonce_post = array(
						    'post_title'    => $titre,
						    'post_name'     => sanitize_title( $titre ),
						    'post_content'  => $texte,
						    'post_status'   => 'publish',
						    'tax_input' 	=> array( $this->annonces => $category_id ),
						    'post_type' 	=> 'annonce_immo',
						);

						// Insertion post database.
						$post_id = wp_insert_post( $annonce_post ); // 0 = pas de post créé
						// Heureusement qu'il y avait ce post :
						// https://ryansechrest.com/2012/07/wordpress-taxonomy-terms-dont-insert-when-cron-job-executes-wp_insert_post/
						// en fait y'a un current_user_can qui empêche l'insertion des catégories par le CRON...!!!!
						$terms = array( $category_id );
						wp_set_object_terms( $post_id, $terms, $this->annonces );

						// liste des metas à ajouter au post en ayant récupéré au préalable son Id
						if( $post_id!=0 ){

							/**
							* récupération tableau photo + attachment dans le post
							* ce git m'a aidé : https://gist.github.com/hissy/7352933
							**/
							$photos 		= $annonce->xpath("//*[@id='$id_annonce']//photo"); // array
							if( !empty($photos) ){
								foreach ($photos as $photo=>$photo_link) {

									$good_photo_link 	= explode('?',$photo_link);
									$photo_link 		= $good_photo_link[0];
									$filename 			= $id_annonce.'_'.basename( $photo_link );

									$upload_file = wp_upload_bits($filename, null, file_get_contents($photo_link));
									if ($upload_file['error']==true){ break; }
									//repris de https://codex.wordpress.org/Function_Reference/wp_insert_attachment
									// et du git plus haut

									// Check the type of file. We'll use this as the 'post_mime_type'.
									$filetype 		= wp_check_filetype( basename( $photo_link ), null );
									if( $filetype['type']!='image/jpeg' ){
										// mettre logo orpi si pas de photos
										set_post_thumbnail( $post_id, $this->remplacement );
										break;
									}
									// Get the path to the upload directory.
									$wp_upload_dir 	= wp_upload_dir();

									// Prepare an array of post data for the attachment.
									$attachment = array(
										'guid'           => $wp_upload_dir['url'] . '/' . $filename,
										'post_mime_type' => $filetype['type'],
										'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename),
										'post_content'   => '',
										'post_status'    => 'inherit',
										'post_parent' 	 => $post_id,
									);

									// Insert the attachment.
									$attach_id = wp_insert_attachment( $attachment, $upload_file['file'], $post_id );

									if ( $attach_id!=0 ) {
										// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
										require_once ABSPATH . 'wp-admin/includes/image.php';

										// Generate the metadata for the attachment, and update the database record.
										$attach_data = wp_generate_attachment_metadata( $attach_id, $upload_file['file'], $post_id );

										wp_update_attachment_metadata( $attach_id, $attach_data );

										// premiere photo en mise en avant
										if( $photo==0 ){
											set_post_thumbnail( $post_id, $attach_id );
										}
									}

								} // fin photos
							}else{
								// mettre logo orpi si pas de photos
								set_post_thumbnail( $post_id, $this->remplacement );
							}

							$code_type 		= $WPublfwParser::to_string_node_value(
												$annonce->xpath("//*[@id='$id_annonce']//code_type")
											  );
							$prix 			= $WPublfwParser::to_string_node_value(
												$annonce->xpath("//*[@id='$id_annonce']//prix")
											  );
							$loyer_cc 		= $WPublfwParser::to_string_node_value(
												$annonce->xpath("//*[@id='$id_annonce']//loyer_mensuel_cc")
											  );
							if( empty($loyer_cc) ){ // pas le même tag des fois…
								$loyer_cc 	= $WPublfwParser::to_string_node_value(
												$annonce->xpath("//*[@id='$id_annonce']//loyer")
											  );
							}
							$mandat_numero 	= $WPublfwParser::to_string_node_value(
												$annonce->xpath("//*[@id='$id_annonce']//mandat_numero")
											  );
							$mandat_type 	= $WPublfwParser::to_string_node_value(
												$annonce->xpath("//*[@id='$id_annonce']//mandat_type")
											  );
							$reference 		= $WPublfwParser::to_string_node_value(
												$annonce->xpath("//*[@id='$id_annonce']//reference")
											  );

							// contact agence
							$contact_a_afficher = $WPublfwParser::to_string_node_value(
													$annonce->xpath("//*[@id='$id_annonce']//contact_a_afficher")
											  );

							// email agence
							$email_a_afficher = $WPublfwParser::to_string_node_value(
													$annonce->xpath("//*[@id='$id_annonce']//email_a_afficher")
											  );

							// téléphone agence
							$telephone_a_afficher = $WPublfwParser::to_string_node_value(
													$annonce->xpath("//*[@id='$id_annonce']//telephone_a_afficher")
											  );

							$meta_keys = array(
												'type'				=> $type,
												'code_type'			=> $code_type,
												'id_annonce' 		=> $id_annonce,
												'mandat_numero' 	=> $mandat_numero,
												'mandat_type' 		=> $mandat_type,
												'reference' 		=> $reference,
												'prix' 				=> $prix,
												'loyer_mensuel_cc' 	=> $loyer_cc,
												'date_integration' 	=> $date_integration,
												'contact_a_afficher' 	=> $contact_a_afficher,
												'email_a_afficher' 		=> $email_a_afficher,
												'telephone_a_afficher' 	=> $telephone_a_afficher,
											  );

							// insertion metas
							foreach ($meta_keys as $meta_key => $meta_value) {
								if ( ! add_post_meta( $post_id, $meta_key, $meta_value, true ) ) {
								   update_post_meta( $post_id, $meta_key, $meta_value );
								}
							}

							global $description_WPublfwParser;

							$details_bien = end($annonce->xpath("//*[@id='$id_annonce']//bien"));
							foreach ($details_bien as $key => $value) {

								if( array_key_exists( $key, $description_WPublfwParser ) ){
									// la dernière valeur du tableau est forcément la bonne
									// NB : on peut mettre [0] aussi
									$value = end($value);

									if(  $value == 'true' ){
										$value = 'Oui';
									}elseif( $value == 'false'){
										$value = '';
									}

									if( !empty($value) ) :

										$field = $description_WPublfwParser[$key]; //nom du champ

										// ajout unité de mesure au champ si nécessaire et autre
										if( is_array($field) ){

											$unit	   = $field["unit"];

											switch ($unit) {
												case 'PRICE': // c'est un prix
													$value = number_format( $value, 2, ',', ' ' ).'&nbsp;€';
													break;

												case false: // ne pas afficher
													$value = false;
													break;

												default: // valeur avec unité de mesure
													$value = number_format( $value, 0, ' ', ' ' ). $field["unit"];
													break;
											}
										}

										if( $value !== false ) {
											if ( ! add_post_meta( $post_id, 'annonce_'.$key, $value, true ) ) {
											   update_post_meta( $post_id, 'annonce_'.$key, $value );
											}
										}
									endif;
								}
							} // $details_bien

							global $diagnostic_WPublfwParser;
					        foreach ( $diagnostic_WPublfwParser as $meta_key => $value) {

					        	$meta_value = $annonce->xpath("//*[@id='$id_annonce']//".$meta_key);

								if( !empty($meta_value) ){

									$meta_value = $WPublfwParser::to_string_node_value($meta_value);

						            if ( ! add_post_meta( $post_id, $meta_key, $meta_value, true ) ) {
									   update_post_meta( $post_id, $meta_key, $meta_value );
									}
					        	}
					        }// diagnostic


					        // insertion type de bien
							global $code_type_immo;
							$this->insert_code_type_term( $post_id, $code_type, $code_type_immo );

						} // POST METAS
					} // if category_id

				sleep(4);// pause du serveur

				} // for each
			}
		} // $url_array

		// suppresion annonces osbolètes
		if( !empty($id_annonces) ){
			$this->remove_old_annonces($id_annonces);
		}
		// reindex annonces
		FWP()->indexer->index();

		/*
		// Mise en mode maintenance OFF
		if( !file_exists( ABSPATH.'.maintenance' ) ){
			unlink( ABSPATH.'.maintenance' );
		}
		*/
		// ajax
		echo "OK";
		wp_die();
	}

	/**
	* Insertion code type du bien
	*
	* @param int
	* @param string
	* @param array $code_type_immo global array
	* @return Void
 	**/
	private function insert_code_type_term( $post_id, $code_type, $code_type_immo ){

		$appartement = $code_type_immo["1100"];
		$parent = term_exists( $appartement, 'type' ); //appartement
		if( $parent==0 || $parent==NULL ){
			wp_insert_term(
				$appartement,
				'type',
				array(
					'slug' => sanitize_title( $appartement ),
				)
			);
		}

		$maison = $code_type_immo["1200"];
		$parent = term_exists( $maison, 'type' ); //maison
		if( $parent==0 || $parent==NULL ){
			wp_insert_term(
				$maison,
				'type',
				array(
					'slug' => sanitize_title( $maison ),
				)
			);
		}

		$terrain = $code_type_immo["1300"];
		$parent = term_exists( $terrain, 'type' ); //terrain
		if( $parent==0 || $parent==NULL ){
			wp_insert_term(
				$terrain,
				'type',
				array(
					'slug' => sanitize_title( $terrain ),
				)
			);
		}

		$stationnement = $code_type_immo["1400"];
		$parent = term_exists( $stationnement, 'type' ); //stationnement
		if( $parent==0 || $parent==NULL ){
			wp_insert_term(
				$stationnement,
				'type',
				array(
					'slug' => sanitize_title( $stationnement ),
				)
			);
		}

/*
		$local_pro = $code_type_immo["2430"];
		$parent = term_exists( $divers, 'type' ); //Local professionnel
		if( $parent==0 || $parent==NULL ){
			wp_insert_term(
				$divers,
				'type',
				array(
					'slug' => sanitize_title( $local_pro ),
				)
			);
		}

		$divers = $code_type_immo["1900"];
		$parent = term_exists( $divers, 'type' ); //divers
		if( $parent==0 || $parent==NULL ){
			wp_insert_term(
				$divers,
				'type',
				array(
					'slug' => sanitize_title( $divers ),
				)
			);
		}
*/

		$commerce = $code_type_immo["2000"];
		$parent = term_exists( $commerce, 'type' ); //commerce
		if( $parent==0 || $parent==NULL ){
			wp_insert_term(
				$commerce,
				'type',
				array(
					'slug' => sanitize_title( $commerce ),
				)
			);
		}

		// code type existe ?
		$term_status = term_exists( $code_type_immo[$code_type], 'type' );

		$code_type_parent = get_code_type_parent($code_type);

		if( $term_status==0 || $term_status==NULL ){

			$code_type_parent_ok = term_exists( $code_type_parent, 'type' );
			$code_type_term =
				wp_insert_term(
					$code_type_immo[$code_type],
					'type',
					array(
						'slug' 		=> sanitize_title( $code_type_immo[$code_type] ),
						'parent'	=> intval($code_type_parent_ok['term_taxonomy_id'])
					)
				);

			$term_id = $code_type_term['term_id'];
			$arr_term_ids = array( intval($code_type_parent_ok['term_taxonomy_id']), $term_id );

		}else{

			$term_id = $term_status['term_taxonomy_id'];

			if( $code_type_parent==$code_type ){
				$arr_term_ids = array( $term_id );
			}else{
				$code_type_parent_ok = term_exists( $code_type_parent, 'type' );
				$arr_term_ids = array( intval($code_type_parent_ok['term_taxonomy_id']), $term_id );
			}
		}
		/*
		$upd_post = array(
						'ID' 			=> $post_id,
						'tax_input' 	=> array( 'type' => $arr_term_ids ),
					);

		wp_update_post( $upd_post );
		*/
		// voir plus haut : nécessaire pour la tâche CRON mais cette fois avec set_post et non set_object
		wp_set_post_terms( $post_id, $arr_term_ids, 'type' );
	}

	/**
	* Suppression des annonces périmées
	*
	* @param array
	* @return Void
 	**/
	private function remove_old_annonces($id_annonces){

		global $wpdb;

		$post_types = $wpdb->get_col(  "SELECT      tata.meta_value
										FROM        {$wpdb->prefix}posts AS toto
										INNER JOIN  {$wpdb->prefix}postmeta AS tata
										            ON toto.ID = tata.post_id
										            AND tata.meta_key = 'id_annonce'
										WHERE       toto.post_type = 'annonce_immo'
										"
									);
		// différence entre les posts et les nouvelles annonces
		$to_delete = array_diff( $post_types, $id_annonces);

		foreach ($to_delete as $key => $id_annonce) {

			$post_id = 	$wpdb->get_var(
							$wpdb->prepare(
								"SELECT     tata.ID
								FROM        {$wpdb->prefix}postmeta AS toto
								INNER JOIN  {$wpdb->prefix}posts AS tata
								            ON tata.ID = toto.post_id
								WHERE 		toto.meta_key = 'id_annonce'
								AND 		toto.meta_value = %d
								"
								, intval($id_annonce)
							)
						);
			// get_var sort du string
			$post_id = intval($post_id);
			// sinon on supprime tout - l'annonce sera réintégré
			$media = get_children( array(
			    'post_parent' => $post_id,
			    'post_type'   => 'attachment'
			) );

			if( !empty( $media ) ) {
			    foreach( $media as $file ) {
			        wp_delete_attachment( $file->ID, true );
			        delete_post_meta( $file->ID, '_wp_attached_file' );
			        delete_post_meta( $file->ID, '_wp_attachment_metadata' );
			    }
			}
			// effacement du post apres car sinon on perds le lien de l'attachment
			wp_delete_post( $post_id, true );
		}

	}

	/**
	* Blocage de la suppression catégorie déclarée dans annonce
	*
	* @return Void / Error
 	**/
	public function no_categories_deletion(){

		$cats_to_keep = array();
		$get_cat_ids = $this->get_cat_ids();
		foreach ($get_cat_ids as $id_cat) {
			$cats_to_keep[] = $id_cat;// tableau des ID à garder
		}

		return blockCategoriesDeletionPlugin::bootstrap( $cats_to_keep );
	}

}

new WPUBI_post();

?>