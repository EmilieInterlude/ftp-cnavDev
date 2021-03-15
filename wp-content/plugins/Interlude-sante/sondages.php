<?php
/*
Plugin Name: Interlude Santé - Sondages
Plugin URI: http://interludesante.com/
Description: Permet de gérer les sondages dans l'administration du site.
Version: 0.1
Author: Interlude Santé
Author URI: http://interludesante.com/
*/

////////// CREATION CUSTOM POST TYPE INFOS ///////////

add_action('init', 'creation_sondages');
function creation_sondages(){
    $args = array(
        'labels' => array(
                    'name'=>__( 'Sondages' ),
                    'singular_name' => __( 'Sondage' ),
                    'add_new'=>__( "Ajouter un sondage" ),
                    'add_new_item'=>__( "Ajouter un nouveau sondage" ),
                    'edit_item'=>__("modifier un sondage"),
                    'not_found'=>__("Aucun sondage trouvé"),
                    ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'menu_position'      => 5,
        'supports' => array( 'title'),
        'rewrite' => array( 'slug' => 'sondages', 'with_front' => false ),
        'menu_icon' =>'dashicons-chart-pie'
        );

    register_post_type( 'sondages' , $args );
}
