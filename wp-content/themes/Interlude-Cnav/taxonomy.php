<?php
/*
Template Name: Taxo Produits
*/

$containerClass="Page Archive Produits";
include("header.php");
$queried_object = get_queried_object();
$term_id = $queried_object->term_id;
$term_parent = $queried_object->parent;
$term_slug= $queried_object->slug;
$taxo_name=$queried_object->taxonomy;

?>

<main role="main" id="page" class="clearfix">
	<h1 class="content"><?php single_term_title(); ?></h1>
  <div id="corps" class="content">

    <?php include("taxonomyTraitementFiltre.php"); ?>
    <?php include("taxonomyBlocFiltre.php"); ?>


    <div class="blocProduitsTaxoTerm">
<?php
// Tous les produits de la taxonomy sans filtre
if($validation!="OK"):
    	while ( have_posts() ) : the_post();
        $idProduitTaxoTerm=$post->ID;
        $photoProduitTaxoTerm="";
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
	endwhile; // end of the loop.
else:
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) {
					$query->the_post();
					$idProduitTaxoTerm=$post->ID;
	        $photoProduitTaxoTerm="";
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
				}
			endif;
endif;?>
    </div>
  </div>
	<?php include('questionnaires.php');?>
</main>
<?php get_footer(); ?>
