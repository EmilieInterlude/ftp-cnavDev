<?php
$containerClass="Page Single Produits";
include("header.php");
$preview=htmlentities($_GET['preview_id']);
var_dump($preview);
?>

<main role="main" id="page" class="clearfix">
<?php
if(!$preview):
	while ( have_posts() ) : the_post();
		$sliderProduit=get_field('sliderProduit');/* Répéteur */
		$videoProduit=get_field('videoProduit');
		$descriptionProduit=get_field('descriptionProduit');
		$utilisationProduit=get_field('utilisationProduit');
		$installationProduit=get_field('installationProduit');
		$extraitDescriptionProduit=get_field('extrait_description');
		$destinataireProduit=get_field('destinataireProduit');
		$utileAidantsProduit=get_field('utileAidantsProduit');
		$prixMoyenProduit=get_field('prixMoyenProduit');
		$financementPossibleProduit=get_field('financementPossibleProduit');
		$lieuxVenteProduit=get_field('lieuxVenteProduit');
		$oeilErgoProduit=get_field('oeilErgoProduit');
		$alternativeProduit=get_field('alternativeProduit');/* Répéteur */
		$allerPlusLoinProduit=get_field('allerPlusLoinProduit');/* Relation */
?>
		<div class="blocTitre content">
				<h1><?php the_title();?></h1><?php echo do_shortcode('[print-me target="body"]'); ?>
		</div>
		<div id="corps" class="content">
<?php //the_taxonomies();?>
			<div id="presentation">
<?php // Répéteur pour récupérer les diapos de la fiche produit
				if($sliderProduit):?>
				<div class="sliderProduit">
					<div class="sliderProduit-for">
<?php
						while ( have_rows('sliderProduit') ) :the_row();
							$photoProduit=get_sub_field('photo_Produit');
?>
							<div class="blocPhoto">
								<img src="<?php echo $photoProduit['url']; ?>" alt="<?php echo $photoProduit['alt']; ?>">
							</div>
<?php
						endwhile;
?>
					</div><?php // fin sliderProduit-for ?>
					<div class="navSlider">
						<div class="sliderProduit-nav">
	<?php
							while ( have_rows('sliderProduit') ) :the_row();
								$photoProduit=get_sub_field('photo_Produit');
	?>
								<div class="blocPhoto">
									<img src="<?php echo $photoProduit['url']; ?>" alt="<?php echo $photoProduit['alt']; ?>">
								</div>
	<?php
							endwhile;?>
						</div>
<?php
							if($videoProduit):?>
								<button class="btnVideo" role="button" type="button" name="button">Vidéo Explicative</button>
								<div class="PopUpVideo hidden" aria-hidden="true">
									<div class="contenuVideo">
	<?php 						echo $videoProduit;?>
										<button class="btnVideoClosed" >Fermer la fenêtre</btn>
									</div>
								</div>
	<?php 			endif;?>

					</div>
				</div><?php // fin sliderProduit ?>
<?php
				endif;
		/* Fin répéteur diapo fiche produit*/
				if($descriptionProduit || $destinataireProduit):
?>
					<div class="description">
						<h2>Pour quoi ?</h2>
<?php 			echo $descriptionProduit;
						if($utilisationProduit):
							echo "<p><strong>Utilisation : </strong>$utilisationProduit</p>";
						endif;
						if($installationProduit):
							echo "<p><strong>Installation : </strong>$installationProduit</p>";
						endif;
						if($destinataireProduit):
							echo "<h2>Pour qui ?</h2>"."<p>".$destinataireProduit."</p>";
						endif;
						if($utileAidantsProduit=="oui"):
							echo "<p>Également utile pour la sécurité et le confort des aidants.</p>";
						endif;?>
					</div>
<?php
				endif;
?>
			</div>
			<div id="detailsErgo">
<?php
				if($prixMoyenProduit || $lieuxVenteProduit || $financementPossibleProduit):?>
					<div class="details">
<?php
					if($prixMoyenProduit):
						echo "<h2 class='icn prix'>Prix</h2><span class='prix'>$prixMoyenProduit</span>";
					endif;
					if($lieuxVenteProduit):
						echo "<h2 class='icn lieux'>Lieux de vente</h2><div>".$lieuxVenteProduit."</div>";
					endif;
					if($financementPossibleProduit):
						echo "<h2 class='icn finance'>Aides financières possibles*</h2><div><span>*sous conditions d’éligibilités</span>".$financementPossibleProduit."</div>";
					endif;
?>
				</div>
<?php
				endif;
				if($oeilErgoProduit):?>
					<div class="ergo">
<?php
						echo "<div class='italic'><h2>L’avis de l’ergothérapeute
						<span class='pictoInfo'>
						<div class='blocInfoErgo'>
							<h3>Ergothérapeute : </h3>
							<p>Professionnel paramédical qui fonde sa pratique sur le lien entre l'activité humaine et la santé en tenant compte des interactions entre la personne, son environnement et ses activités.
							</p>
							<p>Il peut intervenir pour une personne ou un groupe de personnes quel que soit le type d'environnement (médical, professionnel, éducatif...)</p>
						</div></span></h2>« $oeilErgoProduit »</div>";
						if(!$alternativeProduit):?>
							<p class=""><i>Mise à jour fiche produit : <?php echo get_the_modified_date('d/m/Y');?></i></p>
<?php
						endif;
?>
					</div>
<?php   endif;
?>
			</div>
		</div>
<?php
			if($alternativeProduit):?>
				<div class="blocProduitsAlter">
					<h2>Alternatives</h2>
					<div class="content">
<?php
					while ( have_rows('alternativeProduit') ) :the_row();
						$nomAlternatifProduit=get_sub_field('nomAlternatifProduit');
						$caracteristiquesAlternatifProduit=get_sub_field('caracteristiquesAlternatifProduit');
						$prixAlternatifProduit=get_sub_field('prixAlternatifProduit');
						$photoAlternatifProduit=get_sub_field('photoAlternatifProduit');
?>
						<div class="blocProduitAlter">
							<h3><?php echo $nomAlternatifProduit;?></h3>
							<div class="precision">
								<div class="blocPhoto">
									<img src="<?php echo $photoAlternatifProduit['url']; ?>" alt="<?php echo $photoAlternatifProduit['alt']; ?>">
								</div>
								<div class="caracteristique">
									<h4>Caractéristiques</h4>
<?php
										echo $caracteristiquesAlternatifProduit;
?>
								</div>
								<div class="prix">
									<h4>Prix</h4>
<?php
										echo "<span class='prix'>$prixAlternatifProduit</span>";
?>
								</div>

							</div>
						</div>
<?php
					endwhile;
?>
						<p class="maj"><i>Mise à jour fiche produit : <?php echo get_the_modified_date('d/m/Y');?></i></p>
					</div>
				</div>
<?php endif;?>
<?php
		if($allerPlusLoinProduit):?>
			<div class="blocProduitsPlusloin">
				<h2>Pour aller plus loin</h2>
				<div class="produitsPlusLoin">
					<div class="sliderProduitsPlusLoin">
<?php
				foreach ($allerPlusLoinProduit as $value) :
					$idProduitLoin=$value->ID;
					$sliderProduitLoin=get_field('sliderProduit',$idProduitLoin);
					if($sliderProduitLoin):
						$j=0;
						while ( have_rows('sliderProduit',$idProduitLoin) ) :the_row();
							if($j==0):
								$photoProduitLoin=get_sub_field('photo_Produit',$idProduitLoin);
								$j++;
							endif;
						endwhile;
					endif;
					$nomProduitLoin=get_the_title($idProduitLoin);
					$extraitDescriptionProduit=get_field('extrait_description',$idProduitLoin);
					$lienProduitLoin=get_permalink($idProduitLoin);
?>
						<a href="<?php echo $lienProduitLoin;?>" class="blocProduitLoin" alt="consulter la fiche produit <?php echo $nomProduitLoin; ?>">
							<div class="bloc">
							<div class="precision">
								<div class="blocPhoto <?php if(!$sliderProduitLoin): echo 'pasImage';endif;?>">
<?php
							if($sliderProduitLoin):?>
								<img src="<?php echo $photoProduitLoin['url']; ?>" alt="<?php echo $photoProduitLoin['alt']; ?>">
<?php
							 else:?>
							 <img src="<?php bloginfo('template_directory');?>/img/noImage.svg" alt="Pas de photo disponible">
<?php
							 endif;?>

						</div>
								<div class="description">
<?php
									echo "<h3>$nomProduitLoin</h3>$extraitDescriptionProduit...";
?>
								</div>
							</div>
							</div>
						</a>
<?php
				endforeach;
?>
					</div>
				</div>
			</div>
<?php
		endif;?>
<?php
	endwhile; // end of the loop.
else:
	echo "toto";
endif;?>

</main>
<?php get_footer(); ?>
