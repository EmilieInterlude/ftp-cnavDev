<?php
/*
Template Name: Archive Produits
*/

$containerClass="Page Archive Produits";
include("header.php");
?>
<main role="main" id="page" class="clearfix">
	<div class="blocPage">
    <div class="content">
			<h1>Tous les produits</h1>
		  <div class="blocProduitsTaxoTerm">
			<?php $args = array(
				'post_type'  => 'produits',
				'orderby'=>"title",
				'order'=>'asc'
			);
			$the_query = new WP_Query($args);
			if ( $the_query->have_posts() ) {?>
<?php
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$idProduit=$post->ID;
					$photoProduit="";
					$sliderProduit=get_field('sliderProduit',$idProduit);
					if($sliderProduit):
						$j=0;
						while ( have_rows('sliderProduit',$idProduit) ) :the_row();
						 if($j==0):
								$photoProduit=get_sub_field('photo_Produit',$idProduit);
								$j++;
							endif;
						endwhile;
					endif;
					$nomProduit=get_the_title($idProduit);
					$extraitDescriptionProduit=get_field('extrait_description',$idProduit);
					$lienProduit=get_permalink($idProduit);
					?>
					 <a href="<?php echo $lienProduit;?>" class="blocProduitTaxoTerm" alt="consulter la fiche produit <?php echo $nomProduit; ?>">
						 <div class="bloc">
						 <div class="precision">
							 <div class="blocPhoto <?php if(!$sliderProduit): echo 'pasImage';endif;?>">
	<?php
								 if($sliderProduit):?>
									 <img src="<?php echo $photoProduit['url']; ?>" alt="<?php echo $photoProduit['alt']; ?>">
	<?php
									else:?>
									<img src="<?php bloginfo('template_directory');?>/img/noImage.svg" alt="Pas de photo disponible">
	<?php
									endif;?>
							 </div>
							 <div class="description">
	<?php
								 echo "<h3>$nomProduit</h3>$extraitDescriptionProduit...";
	?>
							 </div>
						 </div>
						 </div>
					 </a>
<?php
				} // endwhile
			} // endif
			wp_reset_postdata();?>
		</div>
  	</div>
	</div>
<?php include('questionnaires.php');?>
</main>

<?php get_footer(); ?>
