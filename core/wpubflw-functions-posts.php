<?php
/**
* Récupérer le type parent de l'annonce
*
* @param string
* @return string
	**/
function get_code_type_parent($code_type){

	require_once WPUBIPATH . 'views/code_type.php';
	global $code_type_immo;

	$int_code_type = intval($code_type);
	$code_type_parent = '';
	// type principal
	if ( $int_code_type < 1200 || $int_code_type === 1500 ){

		$code_type_parent = $code_type_immo["1100"]; //appartement

	}elseif( 1200 <= $int_code_type && $int_code_type < 1300 ){

		$code_type_parent = $code_type_immo["1200"]; //maison

	}elseif( 1300 <= $int_code_type && $int_code_type < 1400 ){

		$code_type_parent = $code_type_immo["1300"]; //terrain

	}elseif( 1400 <= $int_code_type && $int_code_type < 1900 ){

		$code_type_parent = $code_type_immo["1400"]; //stationnement

	}/*elseif( 2430 == $int_code_type ){

		$code_type_parent = $code_type_immo["2430"]; //local commercial

	}*/elseif( $int_code_type >= 1900 ){

		$code_type_parent = $code_type_immo["2000"]; //commerce
	}
	return $code_type_parent;
}

/**
*
*  retourne une chaîne de caractère avec la première lettre en majuscule même si c'est un accent
*
*  @param string $s
*
*  @return string
*
**/
function mb_ucfirst( $s ){
    mb_internal_encoding( "UTF-8" );
    return mb_strtoupper(mb_substr( $s, 0, 1 )).mb_substr( $s, 1 );
}


/**
 * return template
 *
 * @param   string
 * 
 * @return 	string
 */
function ubflw_get_front_template($template){

	$templates = array( "wpubflw/$template" );

	if( ! $template_file = locate_template( $templates ) ) {
		$template_file = WPUBIPATH . "views/front/".$template;
	}

	return apply_filters( 'wpubflw_template', $template_file, $template );
}

/**
 * Get current page number.
 *
 * @return    int    $paged    The current page number.
 */
function ubflw_get_page_number() {

	global $paged;

	if( get_query_var('paged') ) {
    	$paged = get_query_var('paged');
	} else if( get_query_var('page') ) {
    	$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	return absint( $paged );
}
?>