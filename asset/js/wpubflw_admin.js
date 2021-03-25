jQuery(document).ready( function($) {

	var url = WPURLS.plugin_url;
	var submit_flux = $('a#import_flux_xml');
	var message = '<div class="notice notice-error"><img src="'+url+'asset/images/preloader-box.gif"><p>Veuillez attendre la fin de l\'importation SVP<br><strong>NE PAS QUITTER LA PAGE</strong></p></div>';
	var message_success = '<div class="notice notice-success"><p>Le flux a été mis à jour !</p></div>';
	var message_fail = '<p>Un problème a été rencontré…<br><strong>Veuillez contacter le webmaster</strong></p>';

	submit_flux.on( 'click', function(e){
		e.preventDefault();

		// appel ajax pour lancer la création des annonces
		jQuery.ajax(
			{
			    type: "post",
			    url: ajaxurl,
			    dataType: "text",
			    data: {
			        action: "wpubflw_launch_flux"
			    },
			    beforeSend: function(){
			    	$('div.notice.notice-error').remove();
	    			submit_flux.css({'opacity':'0.8'}).attr("disabled", 'disabled');
					submit_flux.text("En cours d'importation veuillez patientez SVP…");
					$('div.import_flux_xml').append(message);
			    },
			    complete: function(){
	    			submit_flux.removeAttr("disabled").css({'opacity':'1'});
					submit_flux.text("Importer / Mettre à jour les annonces");
			    },
			    error: function(jqXHR, textStatus, errorThrown){
			        alert(errorThrown.stack + ' : ' + jqXHR.responseText);
			        return;
			    },
			    success: function( response ) {
			        if ( response == "OK" ) {
						$('div.notice.notice-error').remove();
						$('div.import_flux_xml').append(message_success);
			        }else{
						$('div.notice.notice-error').html(message_fail);
			        }
			    }
			}
		);

	});

});