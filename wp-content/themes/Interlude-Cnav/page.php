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
<?php $blocGaucheStandard=get_field('blocGaucheStandard');
			$blocDroitStandard=get_field('blocDroitStandard');
			if($blocGaucheStandard && $blocDroitStandard):?>
				<div class="flex col2">
					<div><?php the_field('blocGaucheStandard')?></div>
					<div><?php the_field('blocDroitStandard');?></div>
				</div>
<?php else:?>
				<div class="standPage"><?php the_field('blocGaucheStandard')?></div>
<?php endif;?>
		</div>
<?php
	endwhile; // end of the loop. ?>

</main>
<?php get_footer(); ?>
