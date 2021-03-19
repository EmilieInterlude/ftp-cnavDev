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
	<h1 class="content"><?php the_title();?></h1>
	<div id="corps" class="content ">
		<div class="flex col2">
			<div><img src="<?php bloginfo('template_directory');?>/img/illustrationNoConnect.svg" class="aligncenter"></div>
			<div><p>La page que vous recherchez n'existe pas.<br />Pour la retrouver, aidez-vous du module de recherche, du menu ou  <a href="<?php bloginfo('siteurl'); ?>/plan-du-site"> utilisez le plan du site</a></p></div>
		</div>
	</div>
</main>
<?php get_footer(); ?>
