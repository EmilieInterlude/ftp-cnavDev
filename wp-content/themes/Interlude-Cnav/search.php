<?php
$bodyClass="Pages Search";
include('header.php');
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
    <div class="contact-page">
        <div class="content">
		<h2> Résultats de la recherche :
        			<?php $mot=$_GET["s"]; echo $mot; ?>
        		</h2>
					<?php if(have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
						<div class="post" id="post-<?php the_ID(); ?>">
							<p class="large nomargin"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></p>
							<?php
							// Support for "Search Excerpt" plugin
							// http://fucoder.com/code/search-excerpt/
							if ( function_exists('the_excerpt') && is_search() ) {
								the_excerpt();
							} ?>
						</div>
						<div class="bordure"></div>
					<?php endwhile; ?>
				 <!-- réponse si pas de contenu -->
			                    <?php else : ?>
			                     <p>
			                         Votre recherche n'a produit aucun résultat.<br />
			                           <a href="<?php bloginfo('url') ?>">Cliquer ici pour retourner à l'accueil</a>
			                     </p>
			                    <!-- on ferme la boucle -->
					<?php endif; ?>
				</div>
        </div>
    </div>
</main>
<?php
include("footer.php");
?>
