<?php /*
Template Name: Plan site
*/
?>
<?php
$containerClass="Page Standard";
include("header.php");

?>
<div id="fil-ariane" class="content breadcrumbs">
	<div class="content">
		<?php if(function_exists('bcn_display'))
		{
				bcn_display();
		}?>
	</div>
</div>
<main role="main" id="page" class="clearfix">
<?php
	while ( have_posts() ) : the_post();
		// $allerPlusLoinProduit=get_field('allerPlusLoinProduit')/* Relation */
?>

		<h1 class="content"><?php the_title();?></h1>
		<div id="corps" class="content ">
			<div class="flex col2">
				<div>
          <div class="">
            <h2>Menu principal</h2>
            <a href="<?php bloginfo('url');?>">Accueil</a>
            <?php   wp_nav_menu( array( 'theme_location' => 'primary' ) );?>
            <ul><li><a href="<?php bloginfo('url');?>/produits/">Tous les produits</a></li></ul>
          </div>
          <div class="">
            <h2>Menu secondaire</h2>
              <?php wp_nav_menu( array( 'theme_location' => 'menuFooter' ) );?>
          </div>
          <div class="">
            <h2>Menu filtre glossaire</h2>
            	<?php wp_list_categories( array( 'taxonomy'=>'lettre','title_li'=>$tous ) );?>
          </div>
          <div class="">
            <h2>Autres</h2>
              <ul>
                <li><a href="<?php bloginfo('url');?>/consulter-le-site-sans-acces-a-internet/">Consulter le site sans accès à internet</a></li>
                <li><a href="<?php bloginfo('url');?>/newsletter/">Vous souhaitez être informé des nouveautés ? C’est par ici !</a></li>
                <li><a href="<?php bloginfo('url');?>/pourquoi-ce-site/">Pourquoi ce site ?</a></li>
                <li><a href="<?php $idEnquete=get_field('AfficheEnqueteFooter','options')[0];the_permalink($idEnquete);?>">Enquête en cours : <?php echo get_the_title($idEnquete);?></a></li>
              </ul>
          </div>
        </div>
				<div>
          <h2>Menu fiche produits</h2>
<?php       $args = array(
    				'post_type'  => 'produits',
    				'orderby'=>"title",
    				'order'=>'asc'
    			);
    			$the_query = new WP_Query($args);
    			if ( $the_query->have_posts() ) {
    				while ( $the_query->have_posts() ) {
    					$the_query->the_post(); ?>
              <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
<?php       }
          }?>
        </div>
			</div>
		</div>
<?php
	endwhile; // end of the loop. ?>

</main>
<?php get_footer(); ?>
