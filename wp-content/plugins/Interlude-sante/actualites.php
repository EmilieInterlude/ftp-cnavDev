<?php
/*
Plugin Name: Interlude Santé - Actualités
Plugin URI: http://interludesante.com/
Description: Permet de gérer les actualités dans l'administration du site.
Version: 0.1
Author: Interlude Santé
Author URI: http://interludesante.com/
*/

////////// CREATION CUSTOM POST TYPE INFOS ///////////

add_action('init', 'creation_actualites');
function creation_actualites(){
    $args = array(
        'labels' => array(
                    'name'=>__( 'Actualités' ),
                    'singular_name' => __( 'Actualité' ),
                    'add_new'=>__( "Ajouter une actualité" ),
                    'add_new_item'=>__( "Ajouter une nouvelle actualité" ),
                    'edit_item'=>__("modifier une actualité"),
                    'not_found'=>__("Aucune actualité trouvée"),
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
        'rewrite' => array( 'slug' => 'actualites', 'with_front' => false ),
        'menu_icon' =>'dashicons-megaphone'
        );

    register_post_type( 'actualites' , $args );
}
?>
