<?php

$containerClass="Page Standard FAQ";
include("header.php");
$queried_object = get_queried_object();
$term_slug= $queried_object->slug;
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
	<h1 class="content">Glossaire</h1>
  <div id="corps" class="content">
<?php
		$tous='<a href="'.get_bloginfo('url').'/notre-glossaire/">Tous les mots</a>'
?>
    <div class="blocTaxoLettre flex">
<?php
			wp_list_categories( array( 'taxonomy'=>'lettre','title_li'=>$tous ) );
?>
		</div>
		<div class="accordeons">
<?php
$args = array(
	'post_type' => 'glossaire',
	'tax_query' => array(
        array(
            'taxonomy' => 'lettre',
            'field'    => 'slug',
            'terms'    => $term_slug,
        ),
    ),
    'orderby' => 'title',
    'order'   => 'ASC',
);
// Tous les produits de la taxonomy sans filtre
$the_query = new WP_Query($args);
if ( $the_query->have_posts() ) :?>
<?php
	while ( $the_query->have_posts() ) :
		$the_query->the_post();?>
					<h2><?php the_title();?></h2>
					<div class="">
						<?php the_content(); ?>
					</div>
<?php
				endwhile;
      endif;?>
    </div>
  </div>
</main>
<?php get_footer(); ?>
