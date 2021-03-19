<?php
/*
Plugin Name: Interlude Santé - glossaire
Plugin URI: http://interludesante.com/
Description: Permet de gérer le glossaire dans l'administration du site.
Version: 0.1
Author: Interlude Santé
Author URI: http://interludesante.com/
*/

////////// CREATION CUSTOM POST TYPE INFOS ///////////

add_action('init', 'creation_glossaire');
function creation_glossaire(){
    $args = array(
        'labels' => array(
                    'name'=>__( 'glossaire' ),
                    'singular_name' => __( 'Glossaire' ),
                    'add_new'=>__( "Ajouter un mot" ),
                    'add_new_item'=>__( "Ajouter un nouveau mot" ),
                    'edit_item'=>__("modifier un mot"),
                    'not_found'=>__("Aucun mot trouvé"),
                    ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'menu_position'      => 5,
        'supports' => array( 'title','author','revisions','editor'),
        'rewrite' => array( 'slug' => 'glossaire', 'with_front' => false ),
        'menu_icon' =>'dashicons-editor-spellcheck'
        );

    register_post_type( 'glossaire' , $args );
}

//// taxonomy

add_action('init','taxonomyGlossaire');
function taxonomyGlossaire(){
    register_taxonomy(
        'lettre',
        'glossaire',
        array(
            'label'=>__('Lettre'),
            'rewrite'=>array(
                'slug'=>'lettre'
            ),
            'public' => true,
            'show_ui' => true,
            'hierarchical'=>true,
            'labels'=>array(
                'name'=>__('Lettres'),
                'singular_name'=>__('Lettre'),
                'all_item'=>__('ajouter une lettre'),
                'add_new_item'=>__('ajouter une nouvelle lettre'),
                'edit_item'=>__('modifier une lettre'),
                'not_found'=>__('Aucune lettre trouvée'),
                'view_item'=>__('Voir une lettre'),
            ),
        )
    );
    register_taxonomy_for_object_type( 'lettre', 'glossaire' );
    // pour l'afficher
    // the_terms( $post->ID, 'lettre');
}

?>
