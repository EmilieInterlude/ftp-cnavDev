<form class="search" role="search" method="get" id="recherche" action="<?php bloginfo('url'); ?>">
  <input type="text" name="s" value="<?php the_search_query(); ?>" class="search rounded" placeholder="Rechercher"/>
  <button type="submit" class="btn btnBleu" id="search-box"><span class='accessibilite'>Cliquer pour lancer la recherche</span><img src="<?php bloginfo('template_directory'); ?>/img/pictoRecherche.svg" alt="" /></button>
</form>
