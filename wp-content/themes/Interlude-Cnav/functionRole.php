<?php
add_action('save_post', 'post_produitsMaj', 10, 3);
function post_produitsMaj($post_id, $post, $update){

  // Mise en attente de toute publication du contributeur sur les fiches produits
  if(current_user_can('contributeurfiche')):
    if($post->post_status == "publish" && $post->post_type == "produits-maj" ) {
      //  Si contributeur à fait une mise à jour d'une fiche publier par un éditeur ou administrateur
        $my_post = array(
            'post_status' => 'pending',
          );
          wp_update_post( $my_post );
    }
  endif;

  global $wpdb;
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;
  $userRole=$current_user->roles;
  /* id de la fiche à mettre à jour ou à créer car validée par l éditeur ou l'admistrateur */
  $new_post_id=get_field('MAJproduit',$post_id);
  if (!$new_post_id && $post->post_status == "publish" && $post->post_type == "produits-maj" && (current_user_can('editor') || current_user_can('administrator')|| current_user_can('administrateurcnav'))) {
    // wp_mail("erouviere@interludesante.com", "Publication", "idPostT ".$new_post_id." old : ".$old ." | new : ".$new, "", array());
    // le post_type produits-maj représente les fiches produits brouillon pour la création de sa fiche produits publiée associée
    // Le traitement ci-dessous est effectué uniquement par la publication réalisée par un éditeur ou un administrateur
    // si le champ MAJproduit n'est pas renseigné sur la fiche, c'est une fiche produit à créer
    // Création de la fiche produit publiée associée + mise à jour des ses taxonomies, de ses champs ACF et de son champ MAJProduit afin d'associer les 2 fiches
    $args = array(
               'comment_status' => $post->comment_status,
               'ping_status' => $post->ping_status,
               'post_author' => $new_post_author,
               'post_content' => $post->post_content,
               'post_excerpt' => $post->post_excerpt,
               //'post_name' => $post->post_name,
               'post_parent' => $post->post_parent,
               'post_password' => $post->post_password,
               'post_status' => "publish",
               'post_title' => $post->post_title,
               'post_type' => "produits",
               'to_ping' => $post->to_ping,
               'menu_order' => $post->menu_order,
          );
          /*
          * création de la fiche produit publiée associée à cette fiche brouillon.
          */
          $new_post_id = wp_insert_post($args);
          /*
          * récupération des taxonomies de la fiche brouillon créée
          */

          $taxonomies = get_object_taxonomies($post->post_type);
          if (!empty($taxonomies) && is_array($taxonomies)):
           foreach ($taxonomies as $taxonomy) {
               $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
               // mise à jour des taxonomies de la fiche produits publiée
               wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
           }
          endif;
          /*
          * récupération des champs ACF de la fiche brouillon créée
          */
          $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
          if (count($post_meta_infos)!=0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
              $meta_key = sanitize_text_field($meta_info->meta_key);
              $meta_value = addslashes($meta_info->meta_value);
              $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query.= implode(" UNION ALL ", $sql_query_sel);
            // mise à jour des champs ACF de la fiche produit publiée
            $wpdb->query($sql_query);
          }
            // mise à jour du champ ACF MAJProduit de la fiche produit brouillon pour l'associer à sa fiche produit publiée
            $sql_query2 = "UPDATE $wpdb->postmeta SET `meta_value`=$new_post_id WHERE `post_id`=$post_id AND `meta_key`='MAJproduit'";
            $wpdb->query($sql_query2);
            $sql_query3 =  "UPDATE $wpdb->postmeta SET `meta_value`='field_6058c9a42df72' WHERE `post_id`=$post_id AND `meta_key`='_MAJproduit'";
            $wpdb->query($sql_query3);
            // Mise à jour stat fiche produits mise à jour
            include('function-role-stat-maj.php');

  }elseif($new_post_id && ($post->post_status == "publish") && $post->post_type == "produits-maj" && (in_array('editor',$userRole) || in_array('administrator',$userRole))){
    // Traitement de mise à jour des fiches produits publiées associées uniquement par la publication d'un editeur ou un administrateur.
    // Le champ MAJProduit est renseigné cela signifie que la fiche brouillon a une fiche associée publiée
    // 1. Mise à jour de la date de dernière mise à jour et du statut en publié ( possibilité que la fiche soit en brouillon, si une fiche produit brouillon a été supprimée puis rétablie.)
    // 2. Suppression de la valeur de toutes les taxonomies et de tous les champs ACF de la fiche produit publiée associée
    // 3. Puis mise à jour des taxonomies et champs ACF en fonction des valeurs de la fiche brouillon.

    // etape 1. récupération de la date de dernière mise à jour puis mise à jour de la fiche publier
    $post_modified_gmt = $post->post_modified_gmt;
    $post_modified= $post->post_modified;
    $sql_UpdatePost= 'UPDATE '.$wpdb->posts.' SET `post_status`= "publish",`post_modified`="'.$post_modified.'",`post_modified_gmt`="'.$post_modified_gmt.'" WHERE `ID`='.$new_post_id;
    $wpdb->query($sql_UpdatePost);

// wp_mail("erouviere@interludesante.com", "Publication", "post->status ".$post->post_status." post_type: ".$post->post_type." requete - ".$serialize, "", array());
    // etape 2.
    $sql_DeleteMeta="DELETE FROM $wpdb->postmeta WHERE `post_id`=$new_post_id" ;
    $wpdb->query($sql_DeleteMeta);
    $sql_DeleteTaxo="DELETE FROM $wpdb->term_relationships WHERE `object_id`=$new_post_id" ;
    $wpdb->query($sql_DeleteTaxo);

    // etape 3.
    // récupération des taxonomies de la fiche brouillon
    $taxonomies = get_object_taxonomies($post->post_type);
    if (!empty($taxonomies) && is_array($taxonomies)):
     foreach ($taxonomies as $taxonomy) {
         $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
         // mise à jour de la fiche produit publiée associée
         wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
     }
    endif;
    /*
    récupération des champs ACF de la fiche brouillon créée
    */
    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
    if (count($post_meta_infos)!=0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
      foreach ($post_meta_infos as $meta_info) {
        $meta_key = sanitize_text_field($meta_info->meta_key);
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
      }
      $sql_query.= implode(" UNION ALL ", $sql_query_sel);
      // mise à jour des champs ACF de la fiche produit publiée associée
      $wpdb->query($sql_query);
    }
    // Mise à jour stat fiche produits mise à jour
    include('function-role-stat-maj.php');
  }

}

// Action à mener si la fiche poduit brouillon est mise à la poubelle -> mettre à la poubelle la fiche produit publiée associée
add_action('trashed_post', 'poubellePost', 10, 3);
function poubellePost($post_id){
  // wp_mail("erouviere@interludesante.com", "Publication", "post_id ".$post_id, "", array());
  $post=get_post($post_id);
  if($post->post_type=="produits-maj" && $post->post_status=="trash"):
    $new_post_id=get_field('MAJproduit',$post_id);
    // wp_mail("erouviere@interludesante.com", "Publication", "post->status ".$post->post_status." post_type: ".$post->post_type." postSuppr - ".$new_post_id, "", array());
    if($new_post_id):
      // mise à la corbeille de la fiche produit publiée associée.
      wp_trash_post($new_post_id);
    endif;
  endif;
}

// Action à mener si la fiche poduit brouillon mise à la poubelle est rétablie -> rétalir la fiche produit publiée associée
add_action('untrash_post', 'retablirPost', 10, 3);
function retablirPost($post_id){
  // wp_mail("erouviere@interludesante.com", "Publication", "post_id ".$post_id, "", array());
  $post=get_post($post_id);
  if($post->post_type=="produits-maj" && $post->post_status=="trash"):
    $new_post_id=get_field('MAJproduit',$post_id);
    // wp_mail("erouviere@interludesante.com", "Publication", "post->status ".$post->post_status." post_type: ".$post->post_type." postSuppr - ".$new_post_id, "", array());
    if($new_post_id):
      // rétabli la fiche produit publiée associée.
      wp_untrash_post($new_post_id);
    endif;
  endif;
}

// Action à mener si la fiche poduit brouillon mise à la poubelle est supprimée définitivement -> supprimer définitivement la fiche produit publiée associée
add_action('before_delete_post', 'suppressionPost', 10, 3);
function suppressionPost($post_id,$post){
  if($post->post_type=="produits-maj"):
    $new_post_id=get_field('MAJproduit',$post_id);
    // wp_mail("erouviere@interludesante.com", "Publication", "post->status ".$post->post_status." post_type: ".$post->post_type." postSuppr - ".$new_post_id, "", array());
    if($new_post_id):
      // supprime définitivement la fiche produit publiée associée
      wp_delete_post($new_post_id);
    endif;
  endif;
}

// Gestion affichage rubrique du back-office

$user = wp_get_current_user();
$user_ID = $user->ID;
$user_roles=$user->roles;
if (!in_array('administrator',$user_roles) && !in_array('editor',$user_roles) && !in_array('administrateurcnav',$user_roles)){ // si pas Interlude
	function remove_menu_items() {
        global $menu;
        // var_dump($menu);
		$restricted = array(__('Links'), __('Comments'),__('Posts'),__('Articles'));
		end ($menu);
	 	while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
		 		unset($menu[key($menu)]);
             }// fin if
             unset($menu[30]);/* contact form 7 */
		}// fin while
		remove_menu_page('tools.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('edit.php?post_type=acf-field-group'); // Advanced Custom Fields
		remove_menu_page('shortcodes-ultimate');//shortcodes-ultimate
    remove_menu_page('plugins.php');
    // remove_menu_page('themes.php');  //Section Apparence
	}// fin function remove_menu_items() {
		add_action('admin_menu', 'remove_menu_items');
		function remove_submenus() {
		 global $submenu;
     // var_dump($submenu);
		 unset($submenu['index.php'][10]); // Supprimer 'Mises à jour'.
		 unset($submenu['themes.php'][5]); // Supprimer 'Thèmes'..
		 }
		add_action('admin_menu', 'remove_submenus');
		add_action( 'admin_menu', 'adjust_the_wp_menu', 999 );
		function adjust_the_wp_menu() {
		$page = remove_submenu_page( 'themes.php', 'theme-editor.php' ); //Menu Edition de theme
		}

    function shapeSpace_remove_toolbar_node($wp_admin_bar) {
    	// replace 'updraft_admin_node' with your node id
    	$wp_admin_bar->remove_node('cf7-style'); //contact form 7
    	$wp_admin_bar->remove_node('new-post'); // créer article
    	$wp_admin_bar->remove_node('new-user'); // créer nouvel utilisateur
    	$wp_admin_bar->remove_node('comments'); // commentaires
    	$wp_admin_bar->remove_node('wpseo-menu');
    	$wp_admin_bar->remove_node('exactmetrics_frontend_button');
    	$wp_admin_bar->remove_node('updates'); // update wp
    //  var_dump($wp_admin_bar->get_nodes());
    }
    add_action('admin_bar_menu', 'shapeSpace_remove_toolbar_node', 999);
}elseif(in_array('editor',$user_roles)||in_array('administrateurcnav',$user_roles)){
  // var_dump($user_roles);
	function remove_menu_items() {
		global $menu;
		$restricted = array(__('Links'), __('Comments'),__('Posts'),__('Articles'),__('Tools'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
				unset($menu[key($menu)]);
			}// fin if
       unset($menu[30]);/* contact form 7 */
		}// fin while
    remove_menu_page('tools.php');
    remove_menu_page('edit.php?post_type=acf-field-group'); // Advanced Custom Fields
    remove_menu_page('shortcodes-ultimate');//shortcodes-ultimate
  }
	add_action('admin_menu', 'remove_menu_items');

  function remove_submenus() {
   global $submenu;
   // var_dump($submenu['options-general.php']);
   unset($submenu['index.php'][10]); // Supprimer 'Mises à jour'.
   unset($submenu['themes.php'][5]); // Supprimer 'Thèmes'..
   unset($submenu['options-general.php'][10]); // Supprimer 'Thèmes'..
   unset($submenu['options-general.php'][15]); // Supprimer 'Thèmes'..
   unset($submenu['options-general.php'][20]); // Supprimer 'Thèmes'..
   unset($submenu['options-general.php'][25]); // Supprimer 'Thèmes'..
   unset($submenu['options-general.php'][30]); // Supprimer 'Thèmes'..
   unset($submenu['options-general.php'][40]); // Supprimer 'Thèmes'..
   unset($submenu['options-general.php'][45]); // Supprimer 'Thèmes'..
   unset($submenu['options-general.php'][46]); // Supprimer 'Thèmes'..
   }
  add_action('admin_menu', 'remove_submenus');
}else{
  function remove_menu_items() {
    global $menu;
    $restricted = array(__('Links'), __('Comments'),__('Posts'),__('Articles'));
    end ($menu);
    while (prev($menu)){
      $value = explode(' ',$menu[key($menu)][0]);
      if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
        unset($menu[key($menu)]);
      }// fin if
    }// fin while
  }// fin function remove_menu_items() {
    add_action('admin_menu', 'remove_menu_items');
}



//
// function wpse_custom_menu_order( $menu_ord ) {
//     if ( !$menu_ord ) return true;
//     return array(
//         'index.php', // Dashboard
// 		'edit.php?post_type=page', // Pages
//         'separator1', // First separator
//       	'upload.php', // Media
// 		'themes.php', // Appearance
//         'plugins.php', // Plugins
//         'users.php', // Users
//         'separator2', // Second separator
//         'tools.php', // Tools
//         'options-general.php', // Settings
//         'separator-last', // Last separator
// 		'edit.php', // Posts
//     );
// }
// add_filter( 'custom_menu_order', 'wpse_custom_menu_order', 10, 1 );
// add_filter( 'menu_order', 'wpse_custom_menu_order', 10, 1 );
//




/// AFFICHE UNIQUEMENT LA PAGE "Travailler au CHRD" pour les DRH ///
// function posts_for_current_author($query) {
// 	global $pagenow;
// 	if( 'edit.php' != $pagenow) {
// 	    return $query;
//   }
// 	global $current_user;
//   if($current_user->roles[0] == 'editeur_recrutement' && !in_array($query->get('post_type'), array('emplois'))) {
//     $query->set('post__in', array(245, 247, 249)); //ID de la page "Travailler au CHRD"
//   }
//   else if($current_user->roles[0] == 'editeur_ifsi') {
//     $query->set('post__in', array(243)); //ID de la page "Travailler au CHRD"
//   }
// }
// add_filter('pre_get_posts', 'posts_for_current_author');
?>
