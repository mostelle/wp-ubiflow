<?php defined( 'ABSPATH' ) OR exit; //disallow direct file access when core isn't loaded

function func_short_winsimul( $atts ) {

    global $wpubflw_option;
    $apport =           $wpubflw_option['apport-text-numeric'];
    $duree =            $wpubflw_option['temps-spinner'];
    $montant =          $wpubflw_option['montant-text-numeric'];
    $taux_assurance =   $wpubflw_option['assurance-slider-float'];
    $taux_credit =      $wpubflw_option['interet-slider-float'];

    $atts = shortcode_atts(
                array(
                    'apport'            => $apport,
                    'duree'             => $duree,
                    'montant'           => $montant,
                    'taux_assurance'    => $taux_assurance,
                    'taux_credit'       => $taux_credit
                ),
                $atts,
                'shortcode_wpubflw'
            );

    $html = '';
    $html .= '
    	<form id="winsimul_form" class="winsimul_form" method="get">
		    <div class="input-text-wrap">
		    	<label>Apport</label>
		    	<input type="text" value="'. $apport .'" name="winsimul_apport" id="winsimul_apport"/>
		    	<span> €</span>
		    </div>
		    <div class="input-text-wrap">
		    	<label>Montant d\'achat</label> 
		    	<input type="text" value="'. $montant .'" name="winsimul_montant" id="winsimul_montant"/>
		    	<span> €</span>
		    </div>
		    <div class="input-text-wrap">
		    	<label>Durée</label>
		        <select name="winsimul_duree" id="winsimul_duree">';
	for ($i=1; $i <= 30 ; $i++) {
					$i==$duree ? $selected = 'selected' : $selected = '';
	$html .= 		'<option value="'.$i.'" '. $selected .' >'. $i .'</option>';
	}
	$html .= '
		        </select>
		        <span> ans</span>
		    </div>
		    <div class="input-text-wrap">
		    	<label>Taux d\'Intérêt</label>
		    	<input type="text" value="'. $taux_credit .'" name="winsimul_taux_credit" id="winsimul_taux_credit"/>
		    	<span> %</span>
		    </div>
		    <div class="input-text-wrap">
		    	<label>Taux d\'Assurance</label>
		    	<input type="text" value="'. $taux_assurance .'" name="winsimul_taux_assurance" id="winsimul_taux_assurance"/>
		    	<span> %</span>
		    </div>
		    <div class="input-text-wrap">
		    	<a class="button" name="winsimul_submitCredit" id="winsimul_submitCredit">Valider</a>
		    </div>
		</form>
		<div id="result_simul_credit">
			<input type="hidden" name="winsimul_bckgurl" id="winsimul_bckgurl" value=" '. WPUBIURL . 'views/ajax_loader.gif"/>
			<div></div>
		</div>
    ';

    return $html;
}
add_shortcode( 'shortcode_wpubflw','func_short_winsimul' );


add_action('wp_enqueue_scripts', 'add_wpsimulcredit_js_scripts');
function add_wpsimulcredit_js_scripts() {
    wp_enqueue_script( 'script', WPUBIURL .'asset/js/get_mens.js', array('jquery'), '1.0', true );
    wp_localize_script('script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}


add_action( 'wp_ajax_get_mensualite', 'get_mensualite' );
add_action( 'wp_ajax_nopriv_get_mensualite', 'get_mensualite' );
function get_mensualite(){
    
    if ( isset($_GET['apport']) &&
    	 isset($_GET['duree']) &&
    	 isset($_GET['montant']) &&
    	 isset($_GET['taux_assurance']) &&
    	 isset($_GET['taux_credit']) &&
    	 $_GET['taux_credit'] != 0 )
    {
    	
	    require( WPUBIPATH.'class/wpubflw_simulateur.php');

	    $apport =           $_GET['apport'];
	    $duree =            $_GET['duree'];
	    $montant =          $_GET['montant'];
	    $taux_assurance =   $_GET['taux_assurance'];
	    $taux_credit =      $_GET['taux_credit'];

		$data = array(
	                'apport'         => (int)trim(str_replace(' ', '', $apport)),
	                'duree'          => (int)$duree,
	                'montant'        => (int)trim(str_replace(' ', '', $montant)),
	                'taux_assurance' => (float)trim(str_replace(',', '.', $taux_assurance)),
	                'taux_credit'    => (float)trim(str_replace(',', '.', $taux_credit))
	            );

	    $simulateur = new Simulateur($data);

	    $getDuree               = $simulateur->getDuree();
	    $getApport              = $simulateur->getApport();
	    $emprunt                = $simulateur->getEmprunt();
	    $calcul_mens_credit     = $simulateur->calcul_mens_credit_format();
	    $calcul_mens_assurance  = $simulateur->calcul_mens_assurance_format();
	    $calcul_mens_globale    = $simulateur->calcul_mens_globale();

	    $cout_credit    = number_format( ((($simulateur->calcul_mens_credit() + $simulateur->calcul_mens_assurance() )*12*$getDuree)-$emprunt), 2, ',' , '&nbsp;');
	    $cout_assurance = number_format( $simulateur->calcul_mens_assurance()*12*$duree, 2, ',' , '&nbsp;');

	    $result = "";
	        
	    $result .= 		'<p class="result_simul_emprunt">Emprunt de <strong>' . number_format($emprunt, 0, ',' , '&nbsp;') . ' €</strong></p>';
	    $result .= 		'<p class="result_simul_mensualite"> Mensualité
	    					<span class="big mensualite">' . $calcul_mens_globale . ' €</span>
	    					 dont <span>' . $calcul_mens_assurance . ' €</span> d\'assurance.
	    				</p>';
	    $result .= 		'<p class="result_simul_cout">  Durée <span class="big duree_credit">' . $duree . ' ans</span></span>';
	    $result .= 		'<p class="result_simul_cout"> Coût total du crédit <span class="big cout_credit">'. $cout_credit . ' €</span> dont <span>' . $cout_assurance . ' €</span> d\'assurance.
	    				</p>';
		
		echo $result;
	}
	wp_die();
}