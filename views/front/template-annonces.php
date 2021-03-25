<?php
/*
* Template Annonces immobilière
*/
global $code_type_immo;
// type de bien parent
$type = get_code_type_parent($code_type);
// pluriel
if( isset($annonce_nb_pieces) ){
	intval($annonce_nb_pieces)==1 ? $s="" : $s="s";
}
//debug pour voir toutes les valeurs exploitables
/*
echo "<pre>";
echo var_dump($annonces_details);
echo "</pre>";
*/

?>

<article id="<?php echo $reference ?>" class="annonce flex_column <?php echo $colonnes; ?> annonce_<?php echo $key; ?> <?php echo $annonce_row; ?>">

	<a href="<?php echo $lien_annonce . $reference; ?>" >
		<!-- Exclusivite -->
		<?php if(isset($mandat_type) && $mandat_type=='exclusif'){ ?>
		<span class="exclusivite">Exclusivité</span>
		<?php } ?>
		<!-- Photo -->
		<img height="<?php echo $photo[2]; ?>" width="<?php echo $photo[1]; ?>" src="<?php echo $photo[0]; ?>"/>
	</a>
		<!-- Description Principale -->
		<div class="desc-annonce">
			<!-- type + nombre de pièces -->
			<h3 class="titre-annonce">
				<a href="<?php echo $lien_annonce . $reference; ?>" ><?php if(isset($type) && !empty($type)){ ?>
				<span><?php echo $type; ?>
				<?php } ?>

				<?php if( isset($annonce_nb_pieces) && !empty($annonce_nb_pieces)){ ?></span>
				<span><strong><?php echo $annonce_nb_pieces; ?></strong> pièce<?php echo $s; ?></span>
				<?php } ?>

			<!-- surface et prix -->

				<?php if( isset($annonce_surface) && !empty($annonce_surface)){ ?>
				<span class="surface-prix"><?php echo $annonce_surface; ?>
				<?php } ?>

				<?php

				// Note : c'est soit l'un soit l'autre les deux ensemble n'existent pas sur un même bien
				if( isset($prix) && !empty($prix)){ ?>
				<mark><?php echo number_format( floatval( $prix ), 0, ",", " "); ?>&nbsp;€</mark>
				<?php }elseif( isset($loyer_mensuel_cc) && !empty($loyer_mensuel_cc)){ ?>
				<mark><?php echo number_format( floatval( $loyer_mensuel_cc ), 0, ",", " "); ?>&nbsp;€</mark></span>
				<?php }

					?></a>
			</h3>
				<!-- ville -->
			<span class="localite"><?php echo $annonce_ville; ?></span>

		</div>

</article>