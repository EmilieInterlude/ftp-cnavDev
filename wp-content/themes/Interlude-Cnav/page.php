<?php
$containerClass="Page Single Produits";
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
		$allerPlusLoinProduit=get_field('allerPlusLoinProduit')/* Relation */
?>

		<h1 class="content"><?php the_title();?></h1>
		<div id="corps" class="content">
      <img src="<?php echo get_field('test_crop')['url'];?>" alt="">
      <?php the_content();?>
      ?>
		</div>
<?php
	endwhile; // end of the loop. ?>

</main>
<?php get_footer(); ?>
