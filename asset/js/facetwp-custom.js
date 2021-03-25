(function($) {

	var num_max;
	var target_value;
	var toggle_state;
	var invert=1;
	var nb_plus = 6;

    $(document).ready( function($) {
	    $('body').click(function(e) {
		    target = $(e.target);
		    target_value = target.data("value");

		    /* tri*/
		    parent_target = target.parent();

		    if( (target.length > 0) && (parent_target.hasClass('facetwp-sort-radio') ) ){

		    	class_attr 		= String( target.attr("for") ); // convertir en string
		    	rest_class_attr = class_attr.split('_');
		    	name_attr 		= rest_class_attr[0];
		    	asc_or_desc 	= rest_class_attr[1];

	    		sibling 		= name_attr+'_asc';
	    		desibling 		= name_attr+'_desc';

		    	if(asc_or_desc=='desc' || asc_or_desc=='asc'){

		    		// supression toutes les classes OFF
		    		$('.facetwp-sort-radio label,.facetwp-sort-radio input').removeClass("choosen");

		    		if( invert===1 ){

			    		// ajout classe choix ON
			    		$('.facetwp-sort-radio label[for="' + desibling + '"]' ).addClass("choosen");
			    		$('.facetwp-sort-radio input#' + desibling ).addClass("choosen");
			    		// masquage
			    		$('.facetwp-sort-radio label[for="' + desibling + '"]' ).show();
			    		$('.facetwp-sort-radio input#' + desibling ).show();
			    		// affichage
			    		$('.facetwp-sort-radio label[for="' + sibling + '"]' ).hide();
			    		$('.facetwp-sort-radio input#' + sibling ).hide();

			    		invert = 0;

		    		}else{

			    		// ajout classe choix ON
			    		$('.facetwp-sort-radio label[for="' + sibling + '"]' ).addClass("choosen");
			    		$('.facetwp-sort-radio input#' + sibling ).addClass("choosen");
			    		// masquage
			    		$('.facetwp-sort-radio label[for="' + desibling + '"]' ).hide();
			    		$('.facetwp-sort-radio input#' + desibling ).hide();
			    		// affichage
			    		$('.facetwp-sort-radio label[for="' + sibling + '"]' ).show();
			    		$('.facetwp-sort-radio input#' + sibling ).show();

			    		invert = 1;
		    		} // invert

		    	}// asc or desc

		    }// target

	    });
	});

    $(document).on('facetwp-loaded', function() {

    	// le nombre ci-dessous correspond en fait au nombre de variantes trouvées 
    	// donc si variantes sont 1 - 2 - 3 - 4 - 5 - 10 : ça donnera 6 et le 10 sera visible
    	//num_max = parseInt(FWP.settings.num_choices.nombre_de_pieces);
    	num_max = 50;

    	for ( var i= num_max ; i > nb_plus; i--) {
   	    	$('.facetwp-checkbox[data-value="'+i+'"]').hide();
   	    }

    });

    $(document).on('facetwp-refresh', function() {

    	/**
    	NOMBRE DE PIECES
    	*/
    	// fonction de tri par ordre grandeur
    	// sort() seul tri 40,1,5,20 par 1,200,40,5 et non 1,5,40,200
    	function compareNombres(a, b) {
  			return a - b;
		}

		// supprime les doublons indépedemment int ou string
		function uniq(a) {
		    var seen = {};
		    return a.filter(function(item) {
		        return seen.hasOwnProperty(item) ? false : (seen[item] = true);
		    });
		}

    	var facet_nb_pieces = FWP.facets['nombre_de_pieces'].sort(compareNombres); // trier par order numérique
    	var num_current_max = facet_nb_pieces[facet_nb_pieces.length-1];

    	if( parseInt(target_value)>=6 && num_current_max >= nb_plus ){

    		if( toggle_state==1 ){
    			// décocher les cases
    			FWP.facets['nombre_de_pieces'] = jQuery.grep( facet_nb_pieces, function(value) {
				 	return value < nb_plus;
				});

				FWP.facets['nombre_de_pieces'] = uniq( FWP.facets['nombre_de_pieces'] );

				toggle_state=0;

	    	}else{
	    		// cocher les cases
	    		for ( var i= num_max ; i >= nb_plus; i--) {
	    			FWP.facets['nombre_de_pieces'].push( i );
	    		};

	    		FWP.facets['nombre_de_pieces'] = uniq( FWP.facets['nombre_de_pieces'] );

	    		toggle_state=1;

	    	}

    	}

    	/**
    	LOUER / ACHETER
    	*/
    	console.log(FWP );
    	var categories_annonces = FWP.facets['categories_annonces'];
    	if( categories_annonces=='vente'){
    		FWP.facets['budget_annonce_location']='';
    		var $parent = $('.facetwp-facet-budget_annonce_location').hide();
    	}else{
    		$('.facetwp-facet-budget_annonce_location').show();
    	}

	});

})(jQuery);
