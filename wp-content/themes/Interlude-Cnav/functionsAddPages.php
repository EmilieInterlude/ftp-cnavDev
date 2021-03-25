<?php function add_links_menu() {
  // add_menu_page( 'Mots Clés', 'Mots Clés', 'edit_pages', 'mots-cles', 'mots_cles', 'dashicons-search', 90 );
    add_menu_page('Statistiques Enquêtes', 'Statistiques Enquêtes', 'edit_pages', 'statistiques-interlude', 'page_generale', 'dashicons-chart-area', 20);
    add_menu_page('Statistiques MAJ fiches', 'Statistiques MAJ Fiches', 'edit_pages', 'statistiques-maj-fiches-interlude', 'page_stat_maj_fiche', 'dashicons-chart-area', 20);
}

$user = wp_get_current_user();
$user_ID = $user->ID;
$user_roles=$user->roles;
if(in_array('administrator',$user_roles) || in_array('editor',$user_roles)):
  add_action( 'admin_menu', 'add_links_menu' );
endif;
function page_generale() {
  include('script-stat.php');
}
function page_stat_maj_fiche(){
  include('script-stat-maj-fiche.php');
}
// function mots_cles() {
//   include('script-mots-cles.php');
// }
?>
