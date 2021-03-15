<?php
/*
Template Name: Taxo Produits à supprimer
*/

$containerClass="Page Archive Produits";
include("header.php");



?>
<main role="main" id="page" class="clearfix">
<?php
	while ( have_posts() ) : the_post();
$taxoProduitsTerm = $wpdb->get_results(
  "SELECT `object_id`as ID , termTaxo.`taxonomy`
  FROM ". $wpdb->prefix."term_relationships AS unionTaxo, ". $wpdb->prefix."term_taxonomy AS termTaxo
  WHERE termTaxo.`taxonomy` = '".$post->post_name."'
  AND unionTaxo.`term_taxonomy_id` = termTaxo.`term_taxonomy_id`
  GROUP BY `object_id` , termTaxo.`taxonomy`"
  );
?>

		<h1 class="content"><?php the_title();?></h1>
		<div id="corps" class="content">
<?php
      if($taxoProduitsTerm):?>
        <div class="blocProduitsTaxoTerm">
<?php
        foreach($taxoProduitsTerm as $value):
           $photoProduitTaxoTerm="";
          $idProduitTaxoTerm=$value->ID;
          $sliderProduitTaxoTerm=get_field('sliderProduit',$idProduitTaxoTerm);
          if($sliderProduitTaxoTerm):
            $j=0;
            while ( have_rows('sliderProduit',$idProduitTaxoTerm) ) :the_row();
              if($j==0):
                $photoProduitTaxoTerm=get_sub_field('photo_Produit',$idProduitTaxoTerm);
                $j++;
              endif;
            endwhile;
          endif;
          $nomProduitTaxoTerm=get_the_title($idProduitTaxoTerm);
          $extraitDescriptionProduit=get_field('extrait_description',$idProduitTaxoTerm);
          $lienProduitTaxoTerm=get_permalink($idProduitTaxoTerm);
        ?>
            <a href="<?php echo $lienProduitTaxoTerm;?>" class="blocProduitTaxoTerm" alt="consulter la fiche produit <?php echo $nomProduitTaxoTerm; ?>">
              <div class="bloc">
              <div class="precision">
                <div class="blocPhoto <?php if(!$sliderProduitTaxoTerm): echo 'pasImage';endif;?>">
<?php
									if($sliderProduitTaxoTerm):?>
										<img src="<?php echo $photoProduitTaxoTerm['url']; ?>" alt="<?php echo $photoProduitTaxoTerm['alt']; ?>">
<?php
									 else:?>
									 <img src="<?php bloginfo('template_directory');?>/img/noImage.svg" alt="Pas de photo disponible">
<?php
									 endif;?>
                </div>
                <div class="description">
        <?php
                  echo "<h3>$nomProduitTaxoTerm</h3>$extraitDescriptionProduit...";
        ?>
                </div>
              </div>
              </div>
            </a>
        <?php
        endforeach;?>
      </div>
<?php
      endif;
      ?>
		</div>
<?php
	endwhile; // end of the loop. ?>

</main>
<?php get_footer(); ?>
