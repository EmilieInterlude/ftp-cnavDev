<?php
/*
Template Name: Archive FAQ
*/

$containerClass="Page Archive FAQ";
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
  <h1 class="content">Foire aux questions</h1>
	<div id="corps" class="content">
	  <div class="blocFAQ accordeons">
			<?php $args = array(
				'post_type'  => 'faq',
				'orderby'=>"title",
				'order'=>'asc'
			);
			$the_query = new WP_Query($args);
			if ( $the_query->have_posts() ) {?>
<?php
				while ( $the_query->have_posts() ) {
					$the_query->the_post();?>
          <h2><?php the_field('questionFAQ');?></h2>
          <div class="reponses">
            <?php the_field('contenuFAQ');?>
          </div>

<?php
				} // endwhile
			} // endif
			wp_reset_postdata();?>
  	</div>
	</div>
</main>

<?php get_footer(); ?>
