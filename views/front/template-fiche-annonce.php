<?php
/*
 * Template Fiche Annonce immobilière
 */

//debug pour voir toutes les valeurs exploitables
/*
if(current_user_can('administrator')){
echo "<pre>";
echo var_dump($annonces_details);
echo "</pre>";
echo $type;
}
*/


$photo_fond = wp_get_attachment_image_src(
	get_post_thumbnail_id( $post->ID ),
	'large'
);

global $wpubflw_option;

$link_annonces = $wpubflw_option[ 'page-des-annonces' ];
$url_link = get_permalink( intval( $link_annonces ) );
isset( $_GET['retour'] ) && !empty($_GET['retour']) ? $anchor_back = '#'.$_GET['retour'] : $anchor_back = '';

if ( !empty( $link_retour = wp_get_referer() ) ) {
	$link_retour = do_shortcode( "[av_button label='Retour' link='" . $link_retour.$anchor_back . "' link_target='' size='large' position='left' icon_select='yes' icon='ue87c' font='entypo-fontello' color='light' custom_bg='#444444' custom_font='#ffffff' custom_class='btn-retour-annonces' admin_preview_bg='']" );
} else {
	$link_retour = do_shortcode( "[av_button label='Faire une recherche' link='" . $url_link . "' link_target='' size='large' position='left' icon_select='yes' icon='ue87c' font='entypo-fontello' color='light' custom_bg='#444444' custom_font='#ffffff' custom_class='btn-retour-annonces' admin_preview_bg='']" );
}

$link_contact = do_shortcode( "[av_button label='Cette annonce m&apos;intéresse' link='#contact' link_target='' size='large' position='left' icon_select='yes-right-icon' icon='ue913' font='parismer-font' color='custom' custom_bg='#d20023' custom_font='#ffffff' custom_class='btn-contact' admin_preview_bg='']" );

?>

<div id="accueil-annonce" class="avia-section alternate_color avia-section-default avia-no-shadow avia-full-stretch av-parallax-section av-section-color-overlay-active avia-bg-style-parallax el_before_av_one_half  avia-builder-el-first    av-minimum-height av-minimum-height-50 container_wrap bas " data-section-bg-repeat="stretch">
	<div class="av-parallax enabled-parallax  active-parallax" data-avia-parallax-ratio="0.3" style="top: auto; transform: translate3d(0px, 311px, 0px); height: 994px;">
		<div class="av-parallax-inner alternate_color  avia-full-stretch" style="background-repeat: no-repeat; background-image: url(<?php echo $photo_fond[0];	 ?>); background-attachment: scroll; background-position: center center; "></div>
	</div>
	<div class="av-section-color-overlay-wrap">
		<div class="av-section-color-overlay" style="opacity: 0.5; background-color: #000000; "></div>
		<div class="container">
			<main role="main" itemprop="mainContentOfPage" class="template-page content  av-content-small alpha units">
				<div class="post-entry post-entry-type-page ">
					<div class="entry-content-wrapper clearfix">
						<?php
						if( !empty($link_retour) ){
							echo $link_retour;
						}
						?>
						<div class="flex_column_table av-equal-height-column-flextable -flextable" style="margin-bottom: 100px">
							<div class="flex_column av_three_fifth  no_margin flex_column_table_cell av-equal-height-column av-align-bottom first  avia-builder-el-1  el_before_av_two_fifth  avia-builder-el-first   " style="padding:30px 30px 0 0; border-radius:0px; ">
									<!-- Link -->

													<!-- Exclusivite -->
													<?php if(isset($mandat_type) && $mandat_type=='exclusif'){ ?>
													<span class="exclusivite">Exclusivité</span>
													<?php } ?>


													<div class="av-special-heading av-special-heading-h1  blockquote modern-quote   avia-builder-el-no-sibling  titre_annonce ">
														<h1 class="av-special-heading-tag " itemprop="headline">
															<?php echo $post->post_title ?> 
														</h1>
														<div class="special-heading-border">
															<div class="special-heading-inner-border"></div>
														</div>
													</div>
							</div>
							<div class="flex_column av_two_fifth  no_margin flex_column_table_cell av-equal-height-column av-align-bottom av-zero-column-padding   avia-builder-el-3  el_after_av_three_fifth  avia-builder-el-last  " style="border-radius:0px; ">

							<!-- Photos -->
							<?php

							$ar_list_photos = array();
							foreach ( $photos as $photo ) {
								$ar_list_photos[] = $photo->ID;
							}
							$list_photos = implode( ",", $ar_list_photos );

							if ( !empty( $list_photos ) ) {
								echo do_shortcode( "[av_gallery ids='" . $list_photos
									. "' style='thumbnails'
								preview_size='square'
								thumb_size='square'
								columns='4'
								imagelink='lightbox'
								lazyload='deactivate_avia_lazyload'
								custom_class=''
								admin_preview_bg='']" );
							}
							?>

							</div>
						</div>

					</div>
				</div>
			</main>
			<!-- close content main element -->
		</div>
		<div class="av-extra-border-element border-extra-diagonal border-extra-diagonal-inverse ">
			<div class="av-extra-border-outer">
				<div class="av-extra-border-inner" style="background-color:#f6f6f6;"></div>
			</div>
		</div>
	</div>
</div>

<!--Section avec les information du bien-->

<div id="info-bien" class="avia-section main_color avia-section-default avia-no-shadow avia-bg-style-scroll  el_after_av_section  el_before_av_section    container_wrap fullsize">
	<div class="container">
		<div class="template-page content  av-content-full alpha units">
			<div class="post-entry post-entry-type-page">
				<div class="entry-content-wrapper clearfix">
					<div class="flex_column_table av-equal-height-column-flextable -flextable" style="margin-top:-150px; margin-bottom:0; ">
						<div class="flex_column av_one_half  no_margin flex_column_table_cell av-equal-height-column av-align-top av-zero-column-padding first el_before_av_one_half  avia-builder-el-first  carte shadow " style="border-radius:0px; ">
							<section class="av_textblock_section " itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
								<div class="avia_textblock  " style="font-size:18px; " itemprop="text">
									<h3>Description   <?php echo do_shortcode("[wpsr_button id='8156']"); ?></h3>
									<?php if(!empty($post->post_content)){ ?>
									<p>
										<?php echo $post->post_content; ?>
									</p>




									<?php if(!empty($prix)){ ?>
									<p class="prix-loyer">Prix :&nbsp;
										<mark>
											<?php echo number_format( floatval( $prix ), 0, ",", " "); ?>&nbsp;€</mark>
										<?php } ?>

										<?php if(!empty($loyer_mensuel_cc)){ ?>
										<p class="prix-loyer">Loyer :&nbsp;
											<mark>
												<?php echo number_format( floatval( $loyer_mensuel_cc ), 0, ",", " "); ?>&nbsp;€<sup>/mois</sup>
											</mark>
											<?php } ?>
											
											<?php if($type=='L'){ ?>
											<br>
											<small><a class="avia-button bouton-baremes" href="/wp-content/uploads/2018/04/piece-fournir-locataire.pdf" target="_blank">Pièces à fournir par le locataire</a></small>
											
											<?php } ?>
											
										</p>

										<?php }

									echo $link_contact; ?>


										<p style="text-align: right; font-size: 0.8em">
											<?php if(!empty($mandat_numero)){ ?>
											<span>Mandat Numéro :&nbsp;<strong><?php echo $mandat_numero;?></strong></span> •
											<?php } ?>

											<?php if(!empty($reference)){ ?>
											<span>Réf. :&nbsp;<strong><?php echo $reference; ?></strong></span>
											<?php } ?>
										</p>

										<!-- contact agence -->
										<p class="contact-agence">
											<?php if(!empty($contact_a_afficher)){ ?>
											<span><?php echo $contact_a_afficher;?></span><br>
											<?php } ?>

											<?php if(!empty($email_a_afficher)){ ?>
											<span><?php echo $email_a_afficher;?></span><br>
											<?php } ?>

											<?php if(!empty($telephone_a_afficher)){ ?>
											<span><?php echo $telephone_a_afficher;?></span><br>
											<?php } ?>
										</p>

								</div>
							</section>
						</div>
						<div class="flex_column av_one_half  no_margin flex_column_table_cell av-equal-height-column av-align-top av-zero-column-padding  el_after_av_one_half  avia-builder-el-last  carte gris shadow " style="border-radius:0px; ">
							<article class="iconbox iconbox_top av-no-box    avia-builder-el-no-sibling   av-icon-style-no-border details-bien" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
								<div class="iconbox_content">
									<header class="entry-content-header">
										<div class="iconbox_icon heading-color " aria-hidden="true" data-av_icon="" data-av_iconfont="parismer-font"></div>
										<h3 class="iconbox_content_title " itemprop="headline">Ce bien en détails :</h3>
									</header>
									<div class="iconbox_content_container  " itemprop="text">
										<ul class="list-check" style="text-align: left;">
											<?php
											self::fiche_annonce_details();
											?>
										</ul>
									</div>
								</div>
								<footer class="entry-footer"></footer>
							</article>
						</div>
					</div>
					<!--close column table wrapper. Autoclose: 1 -->

				</div>
			</div>
		</div>
		<!-- close content main div -->
	</div>
</div>

<div id="section-dpe" class="avia-section main_color avia-section-default avia-no-shadow avia-bg-style-scroll  avia-builder-el-10  el_after_av_section  el_before_av_section    container_wrap fullsize">
	<div class="container">
		<div class="template-page content  av-content-full alpha units">
			<div class="post-entry post-entry-type-page post-entry-3672">
				<div class="entry-content-wrapper clearfix">
					<div class="flex_column av_one_full  flex_column_div av-zero-column-padding first  avia-builder-el-11  avia-builder-el-no-sibling  " style="border-radius:0px; margin: 0 0 150px 0;">


						<!-- Bilan énergétique -->
						<?php
						if ( isset( $soumis_dpe ) && self::is_dpe_ok( $soumis_dpe ) === true ) {
							?>
						<div>
							<h3>Bilan Energétique</h3>
							<ul>
								<?php
								self::fiche_annonce_diagnostic();
								?>
							</ul>
						</div>
						<?php
						} else {
							?>
						<div>
							<p>Bilan énergétique non disponible.</p>
						</div>
						<?php
						}
						?>

					</div>

				</div>
			</div>
		</div>
		<!-- close content main div -->
	</div>
	<div class="av-extra-border-element border-extra-diagonal  ">
		<div class="av-extra-border-outer">
			<div class="av-extra-border-inner" style="background-color:#d20023;"></div>
		</div>
	</div>
</div>


<div id="contact" class="avia-section main_color avia-section-default avia-no-shadow avia-bg-style-scroll  avia-builder-el-12  el_after_av_section  avia-builder-el-last    container_wrap fullsize" style="background-color: #d20023; ">
	<div class="container">
		<div class="template-page content  av-content-full alpha units">
			<div class="post-entry post-entry-type-page post-entry-3672">
				<div class="entry-content-wrapper clearfix">
					<div class="flex_column av_one_full  flex_column_div av-zero-column-padding first  avia-builder-el-13  avia-builder-el-no-sibling  carte shadow " style="border-radius:0px; margin-top: -150px;">
						<section class="av_textblock_section " itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
							<div class="avia_textblock  " itemprop="text">
								<h2>Ce bien vous intéresse?<br>
<small>Veuillez remplir le formulaire ci-dessous :</small></h2>

								<?php
								echo do_shortcode( '[gravityform id="4" title="false" description="false" ajax="true" field_values="mandat_numero=' . $mandat_numero . '&email_agence='.$email_a_afficher. '"]' );
								?>


							</div>
						</section>

					</div>
				</div>
			</div>
			<!-- close content main div -->
			<!-- section close by builder template -->
		</div>
		<!--end builder template-->
	</div>
</div>
<?php

?>