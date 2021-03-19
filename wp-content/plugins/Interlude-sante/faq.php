<?php
/*
Plugin Name: Interlude Santé - FAQ
Plugin URI: http://interludesante.com/
Description: Permet de gérer la FAQ dans l'administration du site.
Version: 0.1
Author: Interlude Santé
Author URI: http://interludesante.com/
*/

////////// CREATION CUSTOM POST TYPE INFOS ///////////

add_action('init', 'creation_faq');
function creation_faq(){
    $args = array(
        'labels' => array(
                    'name'=>__( 'FAQ' ),
                    'singular_name' => __( 'FAQ' ),
                    'add_new'=>__( "Ajouter une question/réponse" ),
                    'add_new_item'=>__( "Ajouter une nouvelle question/réponse" ),
                    'edit_item'=>__("modifier une question/réponse"),
                    'not_found'=>__("Aucune question/réponse trouvée"),
                    ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'menu_position'      => 100,
        'supports' => array( 'title', 'editor' ),
        'rewrite' => array( 'slug' => 'faq', 'with_front' => false ),
        'menu_icon' =>'dashicons-lightbulb'
        );

    register_post_type( 'faq' , $args );
}
?>
