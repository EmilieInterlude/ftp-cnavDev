<?php function add_links_menu() {
  add_menu_page( 'Mots Clés', 'Mots Clés', 'edit_pages', 'mots-cles', 'mots_cles', 'dashicons-welcome-widgets-menus', 90 );
    add_menu_page('Statistiques', 'Statistiques', 'edit_pages', 'statistiques-interlude', 'page_generale', 'images/marker.png', 20);
	// add_submenu_page(
	//    "statistiques-interlude",  // slug du menu parent
	//    __( "Interlude - stat apprenant", "Statistiques" ),  // texte de la balise <title>
	//    __( "Apprenants", "Statistiques" ),  // titre de l'option de sous-menu
	//    "edit_pages",  // droits requis pour voir l'option de menu
	//    "statApprListe", // slug
	//    "page_apprenant_Liste"  // fonction de rappel pour créer la page
	// );
	// add_submenu_page(
	// 	 "statistiques-interlude",  // slug du menu parent
	// 	 __( "Interlude - stat pro", "Statistiques" ),  // texte de la balise <title>
	// 	 __( "Professionnels", "Statistiques" ),  // titre de l'option de sous-menu
	// 	 "edit_pages",  // droits requis pour voir l'option de menu
	// 	 "statProListe", // slug
	// 	 "page_pro"  // fonction de rappel pour créer la page
	// );
  // add_submenu_page(
  //    "statistiques-interlude",  // slug du menu parent
  //    __( "Interlude - stat apprenant", "Statistiques" ),  // texte de la balise <title>
  //    __( "Download Apprenants", "Statistiques" ),  // titre de l'option de sous-menu
  //    "edit_pages",  // droits requis pour voir l'option de menu
  //    "statApprListeDown", // slug
  //    "page_apprenant_Download"  // fonction de rappel pour créer la page
  // );
}
add_action( 'admin_menu', 'add_links_menu' );
function page_generale() {
  include('script-stat.php');
}
function mots_cles() {
  include('script-mots-cles.php');
}
?>
