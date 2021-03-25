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

      $verifSQL='SELECT  DATE_FORMAT(`post_modified`, "%Y%m%d") FROM '.$wpdb->posts.' WHERE `post_type`="produits-stat" and DATE_FORMAT(`post_modified`, "%Y%m%d")="'.$dateMaj.'" AND `post_title`="'.$new_post_id.'"';
      $verif=$wpdb->query($verifSQL);
      $serialize=serialize($verifSQL);
      $serialize2=serialize($verif);
      if(!$verif):
          // wp_mail("erouviere@interludesante.com", "Publication", "verif : $serialize2 dont requete $serialize", "", array());
          wp_insert_post($argsStatMaj);
      endif;
?>
