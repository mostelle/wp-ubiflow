<?php
/*
* Template Fiche Annonce immobilière
*/

//debug pour voir toutes les valeurs exploitables
/*
echo "<pre>";
echo var_dump($annonces_details);
echo "</pre>";
*/
?>
<div id="<?php echo $reference ?>" class="annnonce annonce_<?php echo $post->ID; ?>">

	<!-- Exclusivite -->
	<?php if(isset($mandat_type) && $mandat_type=='exclusif'){ ?>
	<span class="exclusivite">Exclusivité</span>
	<?php } ?>

	<!-- Photos -->
	<?php

	$ar_list_photos = array();
	foreach ( $photos as $photo ) {
		$ar_list_photos[]= $photo->ID;
	}
	$list_photos = implode( "," , $ar_list_photos );

	if( !empty($list_photos) ){
		echo do_shortcode( "[av_gallery ids='".$list_photos
							."' style='big_thumb'
								preview_size='full'
								crop_big_preview_thumbnail='avia-gallery-big-crop-thumb'
								thumb_size='portfolio'
								columns='5'
								imagelink='lightbox'
								lazyload='deactivate_avia_lazyload'
								custom_class=''
								admin_preview_bg='']" );
	}
	?>

	<!-- Description Principale -->
	<div>

		<?php if(!empty($mandat_numero)){ ?>
		<p>Mandat Numéro : <strong><?php echo $mandat_numero;?></strong></P>
		<?php } ?>

		<?php if(!empty($reference)){ ?>
		<p>Réf. : <strong><?php echo $reference; ?></strong></p>
		<?php } ?>

		<?php if(!empty($post->post_content)){ ?>
		<p><?php echo $post->post_content; ?></p>
		<?php } ?>

		<?php if(!empty($prix)){ ?>
		<p>Prix : <?php echo number_format( floatval( $prix ), 0, ",", " "); ?>&nbsp;€</p>
		<?php } ?>

		<?php if(!empty($loyer_mensuel_cc)){ ?>
		<p>Loyer : <?php echo number_format( floatval( $loyer_mensuel_cc ), 0, ",", " "); ?>&nbsp;€</p>
		<?php } ?>

	</div>

	<!-- Détail du bien -->
	<div>
		<h2>Détail</h2>
		<ul>
		<?php
			self::fiche_annonce_details();
		?>
		</ul>
	</div>

	<!-- Bilan énergétique -->
	<?php
	if ( isset($soumis_dpe ) && self::is_dpe_ok( $soumis_dpe ) === true ){ ?>
	<div>
		<h3>Bilan Energétique</h3>
		<ul>
		<?php
			self::fiche_annonce_diagnostic();
		?>
		</ul>
	</div>
	<?php
	}else{
	?>
	<div>
		<p>Bilan énergétique non disponible.</p>
	</div>
	<?php
	}
	?>

</div>

<div class="form-contact-annonce">
	<h3>Ce bien m'intéresse :</h3>
<?php
	echo do_shortcode( '[gravityform id="4" title="false" description="false" ajax="true" field_values="mandat_numero='.$mandat_numero.'"]' );
?>
</div>