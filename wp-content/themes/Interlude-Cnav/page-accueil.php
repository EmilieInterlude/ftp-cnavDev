<?php
/*
Template Name: Accueil
*/

$containerClass="Accueil Produits";
include("header.php");

?>

<main role="main" id="page" class="clearfix">
<?php
  $sliderAccueil=get_field('sliderAccueil');
  if($sliderAccueil):
?>
  <div class="sliderHeader">
    <h1 class="content"><span>Bien chez soi </span>Des équipements pour simplifier son quotidien</h1>
    <div class="sliderAccueil">
<?php
      while(have_rows('sliderAccueil')):the_row();
      $illustrationAccueil=get_sub_field('illustrationSliderAccueil');
?>
        <div class="blocImage">
          <img src="<?php echo $illustrationAccueil['url']?>" alt="<?php  echo $illustrationAccueil['alt']?>">
        </div>
<?php
      endwhile;
?>
    </div>
  </div>
<?php
  endif;
?>
  <div class="blocFiltre">
    <div class="content">
      <h2>Trouver un produit</h2>
      <div class="col3 flex">
        <div class="col">
          <?php wp_list_categories( array( 'taxonomy'=>'emplois', 'title_li'=>'<h3>Fonctions</h3>' ) );?>
        </div>
        <div class="col">
          <?php wp_list_categories( array( 'taxonomy'=>'activites', 'title_li'=>'<h3>Activités</h3>' ) );?>
        </div>
        <div class="col">
            <?php wp_list_categories( array( 'taxonomy'=>'lieux', 'title_li'=>'<h3>Lieux</h3>' ) );?>
        </div>
      </div>
      <a class="btnBleu" href="<?php bloginfo('url');?>/produits/">Voir tous les produits</a>
    </div>
  </div>
  <div class="noConnect">
    <div class="content flex">
      <img src="<?php bloginfo('template_directory');?>/img/illustrationNoConnect.svg">
      <div class="blocTexte">
        <p>
          <strong>Vous êtes non connecté ?</strong>
          Ce site est consultable sans accès à internet
        </p>
        <a class="btnBleu" href="<?php bloginfo('url');?>/consulter-le-site-sans-acces-a-internet/" titre="accéder à la page explicative pour accéder au site sans accès à internet">En savoir plus</a>
      </div>
    </div>
  </div>
  <div class="zoomProduit content">
<?php  $args = array(
    'post_type'  => 'produits',
    'posts_per_page'=>3,
    'orderby'=>"rand",
    'order'=>'asc'
  );
  $the_query = new WP_Query($args);
  if ( $the_query->have_posts() ) :
?>
    <h2>Zoom sur</h2>
    <div class="blocProduitsTaxoTerm">
<?php
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
      $sliderProduit=get_field('sliderProduit');
      $extraitDescriptionProduit=get_field('extrait_description');
      if($sliderProduit):
        $j=0;
        while ( have_rows('sliderProduit') ) :the_row();
         if($j==0):
            $photoProduit=get_sub_field('photo_Produit');
            $j++;
          endif;
        endwhile;
      endif;
?>
      <a class="blocProduitTaxoTerm" href="<?php the_permalink();?>" class="blocProduit" alt="consulter la fiche produit <?php the_title(); ?>">
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
            echo "<h3>".get_the_title()."</h3>$extraitDescriptionProduit...";
 ?>
          </div>
        </div>
        </div>
      </a>
<?php
    endwhile;?>
  </div>
<?php
  endif;
    ?>
  </div>
  <div class="explications content  flex">
    <img src="<?php bloginfo('template_directory');?>/img/accueilLien.svg">
    <div class="liens">
      <a class="flex" href="<?php bloginfo('url');?>/pourquoi-ce-site/">Pourquoi ce site ? <span class="btnBleu">découvrir</span></a>
      <a class="flex" href="<?php bloginfo('url');?>/newsletter/">Rester informé <br />des nouveautés <span class="btnBleu">découvrir</span></a>
    </div>
  </div>
<?php include('questionnaires.php');?>
</main>

<?php get_footer(); ?>
