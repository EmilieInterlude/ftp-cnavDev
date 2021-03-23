<?php
// $user = wp_get_current_user();
// $userRole=$user->roles;

add_action( 'transition_post_status', 'post_status_update', 10, 3 );
function post_status_update( $new, $old, $post ) {

  if (get_post_type($post) == 'produits-maj') : // vérification que nous sommes sur le post-type des mises à jour


    if(current_user_can('contributeurfiche')):
      if($old == "publish" && $new == "publish") {
        //  Si contributeur à fait une mise à jour d'une fiche publier par un éditeur ou administrateur
          $my_post = array(
              'post_status' => 'pending',
            );
            // Update the post into the database
            wp_update_post( $my_post );
      }
    endif;
  endif;
}
add_action('save_post', 'post_produitsMaj', 10, 3);
function post_produitsMaj($post_id, $post, $update){
  global $wpdb;
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;
  /* id de la fiche à mettre à jour car validée */
  $new_post_id=get_field('ficheMajProduits',$post_id);
  if (!$new_post_id && $post->post_status == "publish" && $post->post_type == "produits-maj" && (current_user_can('editor') || current_user_can('administrator'))) {
    // wp_mail("erouviere@interludesante.com", "Publication", "idPostT ".$new_post_id." old : ".$old ." | new : ".$new, "", array());
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
          * insert the post by wp_insert_post() function
          */
          $new_post_id = wp_insert_post($args);
          /*
          * get all current post terms ad set them to the new post draft
          */

          $taxonomies = get_object_taxonomies($post->post_type);
          if (!empty($taxonomies) && is_array($taxonomies)):
           foreach ($taxonomies as $taxonomy) {
               $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
               wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
           }
          endif;
          /*
          * duplicate all post meta
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
            $wpdb->query($sql_query);
          }
          update_field("_MAJProduits","field_6058c9a42df72",  $post_id);
          update_field("MAJProduits",$new_post_id, $post_id);
          $getField=get_field('MAJProduits');
          wp_mail("erouviere@interludesante.com", "Publication", "idPostTest".$getField." old : ".$old ." | new : ".$new, "", array());
  }
    // }  /* fin if (!$customUpdate) { */
}
// add_filter('acf/prepare_field/key=field_6058c9a42df72', 'so37111468_hide_field'); // old_theme_id
// function so37111468_hide_field($field)
// {
//     // hide the field if the current user is not able to save options within the admin
//     // if (!current_user_can('manage_options')) {
//         return false;
//     // }
//     // return $field;
// }

//
// global $wpdb;
// $current_user = wp_get_current_user();
// $new_post_author = $current_user->ID;
// if(current_user_can('editor') || current_user_can('administrator')):
//
//   if($new == "publish"):
//     /* id de la fiche original (celle qui a été mise à jour) */
//     $post_id =$post->ID;
//     /* id de la fiche à mettre à jour car validée */
//     $new_post_id=get_field('ficheMajProduits',$idPost);
//     if($new_post_id):
//
//     else:
//
//     endif;
//   endif;
// endif;
?>
