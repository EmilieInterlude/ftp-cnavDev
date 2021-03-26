<?php
// mise à jour de la table des statMajProduits
// 1 seule mise à jour comptabilitée par jour
// seule les fiches brouillons validées par un éditeur ou administrateur est enregistrée en table
// Afin de faire les filtres nous avons besoin de la date de mise à jour, et d'un enregistrement par mise à jour
$auteurMaj=get_field('AuteurProduit', $post_id);

$argsStatMaj = array(
           'post_author' => $auteurMaj,
           'post_status' => "publish",
           'post_title' => $new_post_id,
           'post_type' => "produits-stat",
      );
      $dateMaj=date("Ymd");

      $verifSQL='SELECT  `ID` FROM '.$wpdb->posts.' WHERE `post_type`="produits-stat" and DATE_FORMAT(`post_modified`, "%Y%m%d")="'.$dateMaj.'" AND `post_title`="'.$new_post_id.'" GROUP BY `ID`';
      $verif=$wpdb->get_row($verifSQL);
      // $serialize=serialize($verifSQL);
      // $serialize2=serialize($verif[0]);
      $newProdStat=$verif->ID;
      if(!$verif):
        // wp_mail("erouviere@interludesante.com", "Publication", "verif : $serialize2 dont requete $serialize", "", array());
        $newProdStat=wp_insert_post($argsStatMaj);
        $taxonomies = get_object_taxonomies($post->post_type);
        if (!empty($taxonomies) && is_array($taxonomies)):
         foreach ($taxonomies as $taxonomy) {
             $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
             // mise à jour des taxonomies de la fiche produits publiée
             wp_set_object_terms($newProdStat, $post_terms, $taxonomy, false);
         }
        endif;
      else:
        // wp_mail("erouviere@interludesante.com", "Publication", "verif : $serialize2 dont valeur idStatMaj $newProdStat dont requete $serialize", "", array());

        $sql_DeleteTaxo="DELETE FROM $wpdb->term_relationships WHERE `object_id`=$newProdStat" ;
        $wpdb->query($sql_DeleteTaxo);
        $taxonomies = get_object_taxonomies($post->post_type);
        if (!empty($taxonomies) && is_array($taxonomies)):
         foreach ($taxonomies as $taxonomy) {
             $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
             // mise à jour des taxonomies de la fiche produits publiée
             wp_set_object_terms($newProdStat, $post_terms, $taxonomy, false);
         }
        endif;
      endif;

?>
