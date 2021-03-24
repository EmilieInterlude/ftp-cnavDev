
<?php
if($term_parent == 0 && $taxo_name=="activites"):
   $activitesTaxo = $wpdb->get_results(
    "SELECT termTaxoActivite.`term_id`as IDTaxo,count(unionTaxo.`object_id`) as nbProduits
    FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
          ". $wpdb->prefix."term_taxonomy AS termTaxoActivite
    WHERE termTaxoActivite.`taxonomy` = 'activites'
      AND termTaxoActivite.`parent`=$term_id
      AND   unionTaxo.`term_taxonomy_id` = termTaxoActivite.`term_taxonomy_id`
      AND unionTaxo.`object_id` IN (SELECT unionTaxo.`object_id`
        FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
              ". $wpdb->prefix."term_taxonomy AS termTaxoFonction,
              ". $wpdb->prefix."posts AS posts
        WHERE
        unionTaxo.`object_id`=posts.`ID`
        AND posts.`post_type`='produits'
        AND posts.`post_status`='publish'
        AND termTaxoFonction.`parent`=$term_id
        AND   unionTaxo.`term_taxonomy_id` = termTaxoFonction.`term_taxonomy_id`
        GROUP BY unionTaxo.`object_id`)
    GROUP BY termTaxoActivite.`term_id`"
  );
elseif($taxo_name=="activites"):
  $activitesTaxo = $wpdb->get_results(
   "SELECT termTaxoActivite.`term_id`as IDTaxo,count(unionTaxo.`object_id`) as nbProduits
   FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
         ". $wpdb->prefix."term_taxonomy AS termTaxoActivite
   WHERE termTaxoActivite.`taxonomy` = 'activites'
     AND termTaxoActivite.`parent`=$term_parent
     AND   unionTaxo.`term_taxonomy_id` = termTaxoActivite.`term_taxonomy_id`
     AND unionTaxo.`object_id` IN (SELECT unionTaxo.`object_id`
       FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
             ". $wpdb->prefix."term_taxonomy AS termTaxoFonction,
             ". $wpdb->prefix."posts AS posts
       WHERE
       unionTaxo.`object_id`=posts.`ID`
       AND posts.`post_type`='produits'
       AND posts.`post_status`='publish'
       AND termTaxoFonction.`parent`=$term_parent
       AND   unionTaxo.`term_taxonomy_id` = termTaxoFonction.`term_taxonomy_id`
       GROUP BY unionTaxo.`object_id`)
   GROUP BY termTaxoActivite.`term_id`"
 );
else:
  $activitesTaxo = $wpdb->get_results(
    "SELECT termTaxoActivite.`parent`as IDTaxo,count(unionTaxo.`object_id`) as nbProduits
    FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
          ". $wpdb->prefix."term_taxonomy AS termTaxoActivite
    WHERE termTaxoActivite.`taxonomy` = 'activites'
      AND   unionTaxo.`term_taxonomy_id` = termTaxoActivite.`term_taxonomy_id`
      AND unionTaxo.`object_id` IN (SELECT unionTaxo.`object_id`
        FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
              ". $wpdb->prefix."term_taxonomy AS termTaxoFonction
              ". $wpdb->prefix."posts AS posts
        WHERE
        unionTaxo.`object_id`=posts.`ID`
        AND posts.`post_type`='produits'
        AND posts.`post_status`='publish'
        AND termTaxoFonction.`taxonomy` = '".$taxo_name."'
          AND termTaxoFonction.`term_id`=$term_id
        AND   unionTaxo.`term_taxonomy_id` = termTaxoFonction.`term_taxonomy_id`
        GROUP BY unionTaxo.`object_id`)
    GROUP BY termTaxoActivite.`parent`"
  );
endif;
  $activites='
  <div class="selectTaxo">
  <button>';
  if($taxo_name=='activites'):
    $activites.='Tous les produits';
  else:
    $activites.='Activité';
  endif;
  $activites.='</button>
  <div class="checkbox hidden">';
  $nbBoucle=0;
    foreach ($activitesTaxo as $value): /*var_dump($value);*/
      if($nbBoucle!=0):
        $idTermTaxo=$value->IDTaxo;
        $nbProduits=$value->nbProduits;
        $nameTaxo=get_term($idTermTaxo)->name;
        $activites.='<div>
          <input type="checkbox" id="'.$idTermTaxo.'" name="filtreProduit[]" value="'.$idTermTaxo.'"';
          if(($validation=="OK" && in_array($idTermTaxo,$filtreProduit))|| $idTermTaxo==$term_id):
              $activites.=' checked ';
          endif;
          $activites.='><label for="'.$idTermTaxo.'">'.$nameTaxo.' ('.$nbProduits.')</label>
        </div>';
      endif;
      $nbBoucle++;
    endforeach;
  $activites.='
  </div>
</div>';
$lieuxTaxo = $wpdb->get_results(
  "SELECT termTaxoActivite.`term_id`as IDTaxo,count(unionTaxo.`object_id`) as nbProduits
  FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
        ". $wpdb->prefix."term_taxonomy AS termTaxoActivite
  WHERE termTaxoActivite.`taxonomy` = 'lieux'
    AND   unionTaxo.`term_taxonomy_id` = termTaxoActivite.`term_taxonomy_id`
    AND unionTaxo.`object_id` IN (SELECT unionTaxo.`object_id`
      FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
            ". $wpdb->prefix."term_taxonomy AS termTaxoFonction
      WHERE termTaxoFonction.`taxonomy` = '".$taxo_name."'
      AND ( termTaxoFonction.`term_id`=$term_id OR
            termTaxoFonction.`term_id` IN (SELECT termTaxoFonction.`term_id`
              FROM ". $wpdb->prefix."term_taxonomy AS termTaxoFonction
              WHERE termTaxoFonction.`parent`= $term_id
              )
          )
      AND   unionTaxo.`term_taxonomy_id` = termTaxoFonction.`term_taxonomy_id`
      GROUP BY unionTaxo.`object_id`)
  GROUP BY termTaxoActivite.`term_id`"
);
$lieux='
<div class="selectTaxo">
  <button>Lieux de vie</button>
  <div class="checkbox hidden">';
    foreach ($lieuxTaxo as $value): /*var_dump($value);*/
      $idTermTaxo=$value->IDTaxo;
      $nbProduits=$value->nbProduits;
      $nameTaxo=get_term($idTermTaxo)->name;
      $lieux.='<div>
        <input type="checkbox" id="'.$idTermTaxo.'" name="filtreProduit[]" value="'.$idTermTaxo.'"';
        if(($validation=="OK" && in_array($idTermTaxo,$filtreProduit)) || $idTermTaxo==$term_id):
            $lieux.=' checked ';
        endif;
        $lieux.='>
        <label for="'.$idTermTaxo.'">'.$nameTaxo.' ('.$nbProduits.')</label>
      </div>';
    endforeach;
  $lieux.='
  </div>
</div>';
$fonctionsTaxo = $wpdb->get_results(
  "SELECT termTaxoActivite.`term_id`as IDTaxo,count(unionTaxo.`object_id`) as nbProduits
  FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
        ". $wpdb->prefix."term_taxonomy AS termTaxoActivite
  WHERE termTaxoActivite.`taxonomy` = 'emplois'
    AND   unionTaxo.`term_taxonomy_id` = termTaxoActivite.`term_taxonomy_id`
    AND unionTaxo.`object_id` IN (SELECT unionTaxo.`object_id`
      FROM  ". $wpdb->prefix."term_relationships AS unionTaxo,
            ". $wpdb->prefix."term_taxonomy AS termTaxoFonction
      WHERE termTaxoFonction.`taxonomy` = '".$taxo_name."'
      AND ( termTaxoFonction.`term_id`=$term_id OR
            termTaxoFonction.`term_id` IN (SELECT termTaxoFonction.`term_id`
              FROM ". $wpdb->prefix."term_taxonomy AS termTaxoFonction
              WHERE termTaxoFonction.`parent`= $term_id
              )
          )
      AND   unionTaxo.`term_taxonomy_id` = termTaxoFonction.`term_taxonomy_id`
      GROUP BY unionTaxo.`object_id`)
  GROUP BY termTaxoActivite.`term_id`"
);
$fonctions='
<div class="selectTaxo">
  <button>Fonctions</button>
  <div class="checkbox hidden">';
    foreach ($fonctionsTaxo as $value): /*var_dump($value);*/
      $idTermTaxo=$value->IDTaxo;
      $nbProduits=$value->nbProduits;
      $nameTaxo=get_term($idTermTaxo)->name;
      $fonctions.='<div>
        <input type="checkbox" id="'.$idTermTaxo.'" name="filtreProduit[]" value="'.$idTermTaxo.'"';
        if(($validation=="OK" && in_array($idTermTaxo,$filtreProduit)) || $idTermTaxo==$term_id):
            $fonctions.=' checked ';
        endif;
        $fonctions.='>
        <label for="'.$idTermTaxo.'">'.$nameTaxo.' ('.$nbProduits.')</label>
      </div>';
    endforeach;
  $fonctions.='
  </div>
</div>';
?>
<div class="filtreTaxo flex">
  <form class="flex" name="formFiltre" action="" method="post">
    <span>J'affine ma recherche : </span>
  <?php
    if ( is_tax( 'emplois') ) :
      echo $activites;
      echo $lieux;
    elseif(is_tax( 'lieux')):
      echo $activites;
      echo $fonctions;
    elseif(is_tax( 'activites')):
      echo $activites;
      echo $fonctions;
      echo $lieux;
    endif;
  ?>
  <input type="hidden" name="valid" value="OK">
  <button class="btnValue">Appliquer</button>
  </form>
  <span class="nbProduits">
<?php
    if($validation=="OK"):
      if ( $query->have_posts() ) :
          $nbProduitsTot=$query->post_count;
      else:
        $nbProduitsTot=0;
      endif;
    else:
      $nbProduitsTot=$nbResultat;
    endif;
    if($nbProduitsTot<2):
      echo $nbProduitsTot." produit";
    else:
      echo $nbProduitsTot." produits";
    endif;
?>
  </span>
  <div class="filtreChoisi flex">
  <?php
    if($validation=="OK" && $filtreProduit):
      $taxoFiltreName="";
      foreach ($filtreProduit as $value) {
        if($value!=$term_id):
          $taxoFiltreName=get_term($value)->name;
  ?>
          <span id="choix<?php echo $value;?>" data-taxo="<?php echo $value;?>" class='choixSelect btnBleu' title="cliquer pour supprimer ce filtre" onclick="deSelect(<?php echo $value;?>);"><?php echo $taxoFiltreName;?></span>
  <?php
        endif;
      }

    endif;
  ?>
  </div>
</div>
