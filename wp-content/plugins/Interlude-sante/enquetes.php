<?php
/*
Plugin Name: Interlude Santé - Enquêtes
Plugin URI: http://interludesante.com/
Description: Permet de gérer les enquêtes dans l'administration du site.
Version: 0.1
Author: Interlude Santé
Author URI: http://interludesante.com/
*/

////////// CREATION CUSTOM POST TYPE INFOS ///////////

add_action('init', 'creation_enquetes');
function creation_enquetes(){
    $args = array(
        'labels' => array(
                    'name'=>__( 'Enquêtes' ),
                    'singular_name' => __( 'Enquête' ),
                    'add_new'=>__( "Ajouter une enquête" ),
                    'add_new_item'=>__( "Ajouter une nouvelle enquête" ),
                    'edit_item'=>__("modifier une enquête"),
                    'not_found'=>__("Aucune enquête trouvée"),
                    ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'menu_position'      => 5,
        'supports' => array( 'title'),
        'rewrite' => array( 'slug' => 'enquetes', 'with_front' => false ),
        'menu_icon' =>'dashicons-chart-area'
        );

    register_post_type( 'enquetes' , $args );
}
?>
