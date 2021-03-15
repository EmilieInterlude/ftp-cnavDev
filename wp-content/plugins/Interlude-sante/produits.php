<?php
/*
Plugin Name: Interlude Santé - Produits
Plugin URI: http://interludesante.com/
Description: Permet de gérer les Produits dans l'administration du site.
Version: 0.1
Author: Interlude Santé
Author URI: http://interludesante.com/
*/

////////// CREATION CUSTOM POST TYPE INFOS ///////////

add_action('init', 'creation_produits');
function creation_Produits(){
    $args = array(
        'labels' => array(
                    'name'=>__( 'Produits' ),
                    'singular_name' => __( 'Produit' ),
                    'add_new'=>__( "Ajouter un produit" ),
                    'add_new_item'=>__( "Ajouter un nouveau produit" ),
                    'edit_item'=>__("modifier un produit"),
                    'not_found'=>__("Aucun produit trouvé"),
                    ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'menu_position'      => 5,
        'supports' => array( 'title','author','revisions'),
        'rewrite' => array( 'slug' => 'produits', 'with_front' => false ),
        'menu_icon' =>'dashicons-products'
        );

    register_post_type( 'produits' , $args );
}

//// taxonomy

add_action('init','taxonomyProduit');
function taxonomyProduit(){
    register_taxonomy(
        'emplois',
        'produits',
        array(
            'label'=>__('Fonction'),
            'rewrite'=>array(
                'slug'=>'fonctions'
            ),
            'public' => true,
            'show_ui' => true,
            'hierarchical'=>true,
            'labels'=>array(
                'name'=>__('Fonctions'),
                'singular_name'=>__('Fonction'),
                'all_item'=>__('ajouter un fonction'),
                'add_new_item'=>__('ajouter une nouvelle fonction'),
                'edit_item'=>__('modifier une fonction'),
                'not_found'=>__('Aucune fonction trouvée'),
                'view_item'=>__('Voir une fonction'),
            ),
        )
    );
    register_taxonomy(
        'activites',
        'produits',
        array(
            'label'=>__('Activité'),
            'rewrite'=>array(
                'slug'=>'activites'
            ),
            'public' => true,
            'show_ui' => true,
            'hierarchical'=>true,
            'labels'=>array(
                'name'=>__('Activités'),
                'singular_name'=>__('Activité'),
                'all_item'=>__('ajouter une activité'),
                'add_new_item'=>__('ajouter une nouvelle activité'),
                'edit_item'=>__('modifier une activité'),
                'not_found'=>__('Aucune activité trouvée'),
                'view_item'=>__('Voir une activité'),
            ),
        )
    );
    register_taxonomy(
        'lieux',
        'produits',
        array(
            'label'=>__('Lieux'),
            'rewrite'=>array(
                'slug'=>'lieux'
            ),
            'public' => true,
            'show_ui' => true,
            'hierarchical'=>true,
            'labels'=>array(
                'name'=>__('Lieux'),
                'singular_name'=>__('Lieu'),
                'all_item'=>__('ajouter un lieu'),
                'add_new_item'=>__('ajouter une nouveau lieu'),
                'edit_item'=>__('modifier un lieu'),
                'not_found'=>__('Aucune lieu trouvé'),
                'view_item'=>__('Voir un lieu'),
            ),
        )
    );
    register_taxonomy_for_object_type( 'emplois', 'produits' );
    register_taxonomy_for_object_type( 'activites', 'produits' );
    register_taxonomy_for_object_type( 'lieux', 'produits' );

    // pour l'afficher
    // the_terms( $post->ID, 'Type');
}

?>
