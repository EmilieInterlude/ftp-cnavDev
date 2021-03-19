<?php
// Register custom navigation walker
include('functionsAddPages.php');
function basic_widget_init() {
	register_nav_menus( array(
		'primary' => __( 'Navigation', 'Basic Responsive Theme' ),
    'menuFooter' => __( 'Menu footer', 'Basic Responsive Theme' )
	) );
}
add_action( 'widgets_init', 'basic_widget_init' );

//////////// CREATION DE LA LONGUEUR DE EXCERPT

function get_actus_excerpt(){
	$excerpt = get_the_content();
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$the_str = substr($excerpt, 0, 100).'...';
	return $the_str;
}

function get_emploi_excerpt(){
	$excerpt = get_field('posteEmploi');
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$the_str = substr($excerpt, 0, 100).'...';
	return $the_str;
}

function excerpt_title(){
	$tit = the_title('',FALSE,'');
	$nbCar=strlen($tit);
  if($nbCar>73){
    return substr($tit,0,70).'...';
  }else{
    return $tit;
  }
}

// recupérer le slug du parent
function the_parent_slug() {
  global $post;
  if($post->post_parent == 0) return '';
  $post_data = get_post($post->post_parent);
  return $post_data->post_name;
}

// initialiser les thumbnails
if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}

//initialiser la date en format français
function date_fr($format, $timestamp=false) {
  if ( !$timestamp ) $date_en = date($format);
  else               $date_en = date($format,$timestamp);
  $texte_en = array(
    "Monday", "Tuesday", "Wednesday", "Thursday",
    "Friday", "Saturday", "Sunday", "January",
    "February", "March", "April", "May",
    "June", "July", "August", "September",
    "October", "November", "December"
  );
  $texte_fr = array(
    "Lundi", "Mardi", "Mercredi", "Jeudi",
    "Vendredi", "Samedi", "Dimanche", "Janvier",
    "F&eacute;vrier", "Mars", "Avril", "Mai",
    "Juin", "Juillet", "Ao&ucirc;t", "Septembre",
    "Octobre", "Novembre", "D&eacute;cembre"
  );
  $date_fr = str_replace($texte_en, $texte_fr, $date_en);
  $texte_en = array(
    "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun",
    "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
    "Aug", "Sep", "Oct", "Nov", "Dec"
  );
  $texte_fr = array(
     "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim",
      "Janv", "F&eacute;v", "Mars", "Avr", "Mai", "Juin",
      "Juil", "Ao&ucirc;t", "Sept", "Oct", "Nov", "D&eacute;c"
  );
  $date_fr = str_replace($texte_en, $texte_fr, $date_fr);
  return $date_fr;
}

/* masquer menu généraux */
    function remove_menu_items() {
     global $menu;
     $restricted = array(__('Links'), __('Comments'), __('Articles'),__('Posts'));
     end ($menu);
     while (prev($menu)){
     $value = explode(' ',$menu[key($menu)][0]);
     if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
     unset($menu[key($menu)]);}
     }
     }
    add_action('admin_menu', 'remove_menu_items');

		//supprimer élément bar menu
		function shapeSpace_remove_toolbar_node($wp_admin_bar) {
			// replace 'updraft_admin_node' with your node id
			$wp_admin_bar->remove_node('cf7-style'); //contact form 7
			$wp_admin_bar->remove_node('new-post'); // créer article
			$wp_admin_bar->remove_node('new-reponses'); // créer cpt
			$wp_admin_bar->remove_node('new-user'); // créer nouvel utilisateur
			$wp_admin_bar->remove_node('comments'); // commentaires
	     // var_dump($wp_admin_bar->get_nodes());
		}
		add_action('admin_bar_menu', 'shapeSpace_remove_toolbar_node', 999);



/*//////////// CUSTOMISATION EDITEUR /////////////////////*/
function my_mce4_options( $init ) {
    $default_colours = '';
    $custom_colours = '
    "007BFF;", "Bleu","004b9a","Bleu foncé","ffa800","Orange", "ffffff",  "Blanc","434343","Texte"
';
    $init['textcolor_map'] = '['.$custom_colours.']'; // build colour grid default+custom colors
    $init['textcolor_rows'] = 1; // enable 6th row for custom colours in grid
    return $init;
}
add_filter('tiny_mce_before_init', 'my_mce4_options');

// pagination
function pagination(){
  global $wp_query;
  $big = 999999999;
  echo paginate_links(array(
      'base' => str_replace($big, '%#%', get_pagenum_link($big)),
      'format' => '?paged=%#%',
      'current' => max(1, get_query_var('paged')),
      'total' => $wp_query->max_num_pages
  ));
}

/// AFFICHE UNIQUEMENT LA PAGE "Travailler au CHRD" pour les DRH ///
function posts_for_current_author($query) {
	global $pagenow;
	if( 'edit.php' != $pagenow) {
	    return $query;
  }
	global $current_user;
  if($current_user->roles[0] == 'editeur_recrutement' && !in_array($query->get('post_type'), array('emplois'))) {
    $query->set('post__in', array(245, 247, 249)); //ID de la page "Travailler au CHRD"
  }
  else if($current_user->roles[0] == 'editeur_ifsi') {
    $query->set('post__in', array(243)); //ID de la page "Travailler au CHRD"
  }
}
add_filter('pre_get_posts', 'posts_for_current_author');

// chargement plugin slider
function interlude_script(){
	wp_enqueue_script( 'jquery',  get_template_directory_uri().'/js/jquery-3.1.1.min.js', array('jquery'), false, false );
  wp_enqueue_script( 'slickjs',  get_template_directory_uri().'/js/slick.min.js', array('jquery'), false, false );
	wp_enqueue_script( 'script',  get_template_directory_uri() .'/js/scripts.js', array('jquery'), false, false );
	wp_enqueue_script( 'jqueryuijs',  get_template_directory_uri() .'/js/jquery-ui.min.js', array('jquery'), false, false );
}
add_action( 'wp_enqueue_scripts', 'interlude_script');

function interlude_styles(){
	 wp_enqueue_style( 'slickcss', get_template_directory_uri() .'/css/slick.css', false );
	 wp_enqueue_style( 'jqueryuicss', get_template_directory_uri() .'/css/jquery-ui.min.css', false );
}
add_action( 'wp_enqueue_scripts', 'interlude_styles');

/* */
function wpse_custom_menu_order( $menu_ord ) {
    if ( !$menu_ord ) return true;

    return array(
        'index.php', // Dashboard
				'edit.php?post_type=page', // Pages
				'edit.php?post_type=produits', // Pages
				'edit.php?post_type=sondages', // Pages
				'edit.php?post_type=enquetes', // Pages
				'edit.php?post_type=faq', // Pages
        'separator1', // First separator
      	'upload.php', // Media
				'themes.php', // Appearance
        'plugins.php', // Plugins
        'users.php', // Users
        'separator2', // Second separator
        'tools.php', // Tools
        'options-general.php', // Settings
				'link-manager.php', // Links
				'edit-comments.php', // Comments
        'separator-last', // Last separator
				'edit.php', // Posts
    );
}
add_filter( 'custom_menu_order', 'wpse_custom_menu_order', 10, 1 );
add_filter( 'menu_order', 'wpse_custom_menu_order', 10, 1 );

/* Autoriser les fichiers SVG */
function wpc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'wpc_mime_types');

/* Création page option */
if( function_exists('acf_add_options_page') ) {
	// Page principale
	acf_add_options_page(array(
		'page_title'    => 'Options',
		'menu_title'    => 'Options',
		'menu_slug'     => 'options',
		'position'		=> 5,
		'capability'    => 'edit_posts',
		'redirect'      => true
	));
	acf_add_options_sub_page(array(
		'page_title'    => 'Réseaux sociaux',
		'menu_title'    => 'Réseaux sociaux',
		'parent_slug'   => 'options',
	));
	acf_add_options_sub_page(array(
		'page_title'    => 'Affichage Sondage/enquêtes',
		'menu_title'    => 'Affichage Sondage/enquêtes',
		'parent_slug'   => 'options',
	));
}
// WP MEMBERS
// Changement de destinataire des notifications de nouveaux inscrits
// add_filter( 'wpmem_notify_addr', 'my_admin_email' );
// function my_admin_email( $email ) {
//     $email = 'nbailly@ch-tourcoing.fr';
//     return $email;
// }

add_filter( 'wpmem_default_text_strings', function($text) {
	$text = array(
		'login_heading' => 'Connectez-vous',
		'login_password'=>'Mot de passe',
		'remember_me'=>"Se souvenir de moi",
		'sb_login_button'=>'Se connecter',
		'login_button'=>'Se connecter',
		'register_heading' => 'Créez votre compte',
		'sb_login_register'    => __( 's\'enregistrer'),
		'register_submit'=>'s\'enregistrer',
		'register_required'=>'<span class="req">*</span>Inscription requise',
	);
	return $text;
});
?>
