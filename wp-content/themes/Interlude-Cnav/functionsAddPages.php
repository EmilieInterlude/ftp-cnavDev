<?php function add_links_menu() {
  add_menu_page( 'Mots Clés', 'Mots Clés', 'edit_pages', 'mots-cles', 'mots_cles', 'dashicons-search', 90 );
    add_menu_page('Statistiques', 'Statistiques', 'edit_pages', 'statistiques-interlude', 'page_generale', 'dashicons-chart-area', 20);
}
add_action( 'admin_menu', 'add_links_menu' );
function page_generale() {
  include('script-stat.php');
}
function mots_cles() {
  include('script-mots-cles.php');
}
?>
