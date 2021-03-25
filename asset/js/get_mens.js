jQuery('#winsimul_submitCredit').on('click',
    function( event ){

    	event.preventDefault();

        apport = jQuery('#winsimul_apport').val();
        duree =   jQuery('#winsimul_duree').val();
        montant =  jQuery('#winsimul_montant').val();
        taux_assurance =  jQuery('#winsimul_taux_assurance').val();
        taux_credit =  jQuery('#winsimul_taux_credit').val();
        bckgrurl = jQuery('#winsimul_bckgurl').val();

        jQuery.ajax({
            type: "GET",
            url: ajaxurl,
            data: {
                'action': 'get_mensualite',
                'apport' : apport,
                'duree' : duree,
                'montant' : montant,
                'taux_assurance' : taux_assurance,
                'taux_credit' : taux_credit
            },
            dataType: 'html',
            beforeSend: function()  {
            							jQuery('#result_simul_credit').css( "background-image" , "url("+ bckgrurl +")" );
            							jQuery('#result_simul_credit div').empty();
                                    },

            complete:   function()  {
            							jQuery('#result_simul_credit').css( "background-image" , "none" );
                                    },

            success:    function( response )
                                    {	
                                        jQuery('#result_simul_credit div').empty().html(response);
                                        //console.log(response);
                                    },

            error:      function( error )
                                    {
                                        console.log(error);
                                    } 
        });
    }
);