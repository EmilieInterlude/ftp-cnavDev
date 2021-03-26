<?php //fichier permettant d'afficher les statistiques globales dans l'administration ?>
<?php
    require_once ('admin.php');
    include_once ('./admin-header.php');
?>
<?php
global $wpdb;
// STAT globales
    $sqlNBFiches="SELECT COUNT(`ID`) as NB FROM $wpdb->posts
    WHERE `post_status`='publish' AND `post_type`='produits'";
    $nbFiches=$wpdb->get_row($sqlNBFiches);
    $sqlNBFicheSup='SELECT `post_title` as NB FROM `cnavE_posts` WHERE `post_title` NOT IN (SELECT `ID` FROM `cnavE_posts` WHERE `post_type`="produits" AND `post_status`="publish") AND `post_type`="produits-stat" AND `post_status`="publish" GROUP BY `post_title`';
    $NBFicheSup=$wpdb->get_results($sqlNBFicheSup);
    // var_dump($sqlNBFicheSup);echo "<br />";
    $sqlNBFicheSupMAJ='SELECT `post_title` as NB FROM `cnavE_posts` WHERE `post_title` NOT IN (SELECT `ID` FROM `cnavE_posts` WHERE `post_type`="produits" AND `post_status`="publish") AND `post_type`="produits-stat"  AND `post_status`="publish" ';
    $NBFicheSupMAJ=$wpdb->get_results($sqlNBFicheSupMAJ);
    // var_dump($sqlNBFicheSupMAJ);echo "<br />";
    $sqlFicheMAJ='SELECT `post_title` as titre, count(`post_title`)  as nbval FROM `cnavE_posts` WHERE `post_type`="produits-stat" AND `post_status`="publish" AND `post_title` IN (SELECT `ID` FROM `cnavE_posts` WHERE `post_type`="produits" AND `post_status`="publish") GROUP BY `post_title`';
    $FicheMAJ=$wpdb->get_results($sqlFicheMAJ);
    // var_dump($sqlFicheMAJ);echo "<br />";
    $sqlFichesMAJ='SELECT `post_title` as NB FROM `cnavE_posts` WHERE `post_type`="produits-stat" AND `post_status`="publish" AND `post_title` IN (SELECT `ID` FROM `cnavE_posts` WHERE `post_type`="produits" AND `post_status`="publish")';
    $FichesMAJ=$wpdb->get_results($sqlFichesMAJ);
    // var_dump($sqlFichesMAJ);echo "<br />";
    // traitement filtres stats
    $filtreEmploi=get_terms('emplois');
    $filtreActivite=get_terms('activites');
    $filtreLieux=get_terms('lieux');
    $filtreTH="";
    $filtreTD="";
    $filtreTR="";
  // var_dump(  $filtreActivite);
    foreach ($filtreEmploi as $value) {
      $filtreTH.="<th>$value->name</th>";
      $sqlNBFichesTaxo="SELECT COUNT(`ID`) as NB
      FROM $wpdb->posts, $wpdb->term_relationships
      WHERE `object_id`=`ID`
      AND `term_taxonomy_id`=$value->term_taxonomy_id
      AND `post_status`='publish' AND `post_type`='produits'";
      $nbFichesTaxo=$wpdb->get_row($sqlNBFichesTaxo);
      // var_dump(  $nbFichesTaxo);
      $filtreTD.="<td>$nbFichesTaxo->NB</td>";
      $filtreTR.="<tr><th>$value->name</th><td>$nbFichesTaxo->NB</td></tr>";
    }
    foreach ($filtreActivite as $value) {
      $filtreTH.="<th>$value->name</th>";
      $sqlNBFichesTaxo="SELECT COUNT(`ID`) as NB
      FROM $wpdb->posts, $wpdb->term_relationships
      WHERE `object_id`=`ID`
      AND `term_taxonomy_id`=$value->term_taxonomy_id
      AND `post_status`='publish' AND `post_type`='produits'";
      $nbFichesTaxo=$wpdb->get_row($sqlNBFichesTaxo);
      if($nbFichesTaxo->NB==0):
        $itemsArgs=array(array(
          'taxonomy' => "$value->taxonomy",
          'field' => 'slug',
          'terms' =>"$value->slug",
        ));
        $args = array(
          'post_type' => 'produits',
          'tax_query' => array(
              $itemsArgs
          ),
        );
        $query2 = new WP_Query( $args );
        $filtreTD.="<td>$query2->post_count</td>";
        $filtreTR.="<tr><th>$value->name</th><td>$nbFichesTaxo->NB</td></tr>";
      else:
        $filtreTD.="<td>$nbFichesTaxo->NB</td>";
        $filtreTR.="<tr><th>$value->name</th><td>$nbFichesTaxo->NB</td></tr>";
      endif;
    }
    foreach ($filtreLieux as $value) {
      $filtreTH.="<th>$value->name</th>";
      $sqlNBFichesTaxo="SELECT COUNT(`ID`) as NB
      FROM $wpdb->posts, $wpdb->term_relationships
      WHERE `object_id`=`ID`
      AND `term_taxonomy_id`=$value->term_taxonomy_id
      AND `post_status`='publish' AND `post_type`='produits'";
      $nbFichesTaxo=$wpdb->get_row($sqlNBFichesTaxo);
      // var_dump(  $nbFichesTaxo);
      $filtreTD.="<td>$nbFichesTaxo->NB</td>";
      $filtreTR.="<tr><th>$value->name</th><td>$nbFichesTaxo->NB</td></tr>";
    }
    // var_dump($FicheMAJ);
    foreach ($FicheMAJ as  $value) {
      $idtitre=intval($value->titre);
      $titre=get_the_title($idtitre);
      $nbMAJ=$value->nbval;
      $detailResult.="<tr>
        <td>$idtitre</td>
        <td>$titre</td>
        <td>$nbMAJ</td>
      </tr>";
    }

// Traitement du formulaire
    $filtreStatForm=$_POST['valid'];
    if($filtreStatForm=="OK"):
      $dateDebForm=$_POST['dateDeb'];
      $dateFinForm=$_POST['dateFin'];
      $dateDeb=date('Y-m-d', strtotime($dateFinForm. ' - 1 days'));
      $dateFin=date('Y-m-d', strtotime($dateFinForm. ' + 1 days'));
      $dateDebT=date_format(date_create($dateDebForm), 'd-m-Y');
      $dateFinT=date_format(date_create($dateFinForm), 'd-m-Y');
      ?>
<?php
      $sqlNBFichesForm="SELECT COUNT(`ID`) as NB FROM $wpdb->posts
      WHERE `post_status`='publish' AND `post_type`='produits'";
      $nbFichesForm=$wpdb->get_row($sqlNBFichesForm);

      $sqlNBFichesCreesForm='SELECT COUNT(`ID`) as NB FROM '.$wpdb->posts.'
      WHERE `post_status`="publish" AND `post_type`="produits" AND `post_date` BETWEEN "'.$dateDeb.'" AND "'.$dateFin.'"';
      $nbFichesCreesForm=$wpdb->get_row($sqlNBFichesCreesForm);
// var_dump($sqlNBFichesCreesForm);echo "<br />";
      $sqlNBFicheSupForm='SELECT `post_title` as NB FROM `cnavE_posts` WHERE `post_title` NOT IN (SELECT `ID` FROM `cnavE_posts` WHERE `post_type`="produits" AND `post_status`="publish") AND `post_type`="produits-stat" AND `post_status`="publish" AND `post_modified` BETWEEN "'.$dateDeb.'" AND "'.$dateFin.'" GROUP BY `post_title`';
      $NBFicheSupForm=$wpdb->get_results($sqlNBFicheSupForm);
      // var_dump($sqlNBFicheSupForm);echo "<br />";
      $sqlNBFicheSupMAJForm='SELECT `post_title` as NB FROM `cnavE_posts` WHERE `post_title` NOT IN (SELECT `ID` FROM `cnavE_posts` WHERE `post_type`="produits" AND `post_status`="publish") AND `post_type`="produits-stat"  AND `post_status`="publish" AND `post_modified` BETWEEN "'.$dateDeb.'" AND "'.$dateFin.'"';
      $NBFicheSupMAJForm=$wpdb->get_results($sqlNBFicheSupMAJForm);
      // var_dump($sqlNBFicheSupMAJForm);echo "<br />";
      $sqlFicheMAJForm='SELECT `post_title` as titre, count(`post_title`)  as nbval FROM `cnavE_posts` WHERE `post_type`="produits-stat" AND `post_status`="publish" AND `post_modified` BETWEEN "'.$dateDeb.'" AND "'.$dateFin.' " AND `post_title` IN (SELECT `ID` FROM `cnavE_posts` WHERE `post_type`="produits" AND `post_status`="publish") GROUP BY `post_title`';
      $FicheMAJForm=$wpdb->get_results($sqlFicheMAJForm);
      $sqlFichesMAJForm='SELECT `post_title` as NB FROM `cnavE_posts` WHERE `post_type`="produits-stat" AND `post_status`="publish" AND `post_title` IN (SELECT `ID` FROM `cnavE_posts` WHERE `post_type`="produits" AND `post_status`="publish") AND `post_modified` BETWEEN "'.$dateDeb.'" AND "'.$dateFin.'"';
      $FichesMAJForm=$wpdb->get_results($sqlFichesMAJForm);

      foreach ($FicheMAJForm as  $value) {
        $idtitreForm=intval($value->titre);
        $titreForm=get_the_title($idtitreForm);
        $nbMAJForm=$value->nbval;
        $detailResultForm.="<tr>
          <td>$idtitreForm</td>
          <td>$titreForm</td>
          <td>$nbMAJForm</td>
        </tr>";
      }
    endif;
?>

<div class="wrap nosubsub">

  <div id="stat">
    <h1>Statistiques des fiches mises à jour</h1>
    <div class="description">
      <h3>A savoir :</h3>
      <p>Une fiche qui vient d'être créée est comptabilisée comme fiche mise à jour</p>
      <p>Les fiches supprimées sont les fiches définitivement supprimées ou mises à la corbeille lors de la consultation des statistiques mais dont au moins une mise à jour apparaît.<br />
      Lors d'un filtre réalisé par date, seules les fiches mises à jour et non publiées sur la période sont comptabilisées parmi les fiches produits supprimées<br />
    <strong>Les fiches supprimées ne sont pas comptabilisées parmi le nombre de fiches produit mises à jour et le nombre de mises à jour totales</strong></p>
    </div>
    <h2>Choisissez une plage de dates pour vos statistiques :</h2>
    <form class="filtreStat" action="" method="post">
      <div class="flex">
        <span>de<sup>*</sup></span>
        <input type="date" name="dateDeb" min="2021-01-01" max="<?php $dateMax=date("Y-m-d"); echo $dateMax;?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
        <span>à<sup>*</sup></span>
        <input type="date" name="dateFin" min="2021-01-01" max="<?php $dateMax=date("Y-m-d"); echo $dateMax;?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
      <input type="hidden" name="valid" value="OK">
      <input class="btnBleu" type="submit" name="envoi" value="Filtrer">
      </div>
    </form>
    <div class="stat_test accordionStat">
<?php
    if($filtreStatForm=="OK"):?>
      <h3>Résultat statistique entre <?php echo $dateDebT;?> et <?php echo $dateFinT;?></h3>
      <div class="glob">
        <div class="accordionStat">
          <h4>Statistiques</h4>
          <div class="">
            <table>
              <tbody>
                  <tr><th>Nombre de fiches <br /> publiées</th><td><?php echo $nbFichesForm->NB; ?></td></tr>
                  <tr><th>Nombre de fiches <br /> créées</th>  <td> <?php echo $nbFichesCreesForm->NB;?></td></tr>
                  <tr><th>Nombre de fiches <br /> supprimées définitivement</th>  <td><?php echo count($NBFicheSupForm); ?></td></tr>
                  <tr><th>Nombre de fiches <br /> mises à jour</th>  <td><?php echo count($FicheMAJForm) ; ?></td></tr>
                  <tr><th>Nombre de <br /> mises à jour totales</th>  <td><?php echo count($FichesMAJForm) ; ?></td></tr>
              </tbody>
            </table>
          </div>
          <h4>Détails par fiche mise à jour</h4>
          <div>
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Titre</th>
                  <th>Nb de fois mises à jour</th>
                </tr>
              </thead>
              <tbody>
                <?php echo $detailResultForm;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
<?php
    endif;
?>
      <h3>Statistiques Globales</h3>
      <div class="glob">
        <div class="accordionStat">
          <h4>Statistiques</h4>
          <div class="">
            <table>
              <tbody>
                  <tr><th>Nombre de fiches <br /> publiées</th><td><?php echo $nbFiches->NB; ?></td></tr>
                  <tr><th>Nombre de fiches <br /> créées</th>  <td> <?php echo $nbFiches->NB + count($NBFicheSup);?></td></tr>
                  <tr><th>Nombre de fiches <br /> supprimées définitivement</th>  <td><?php echo count($NBFicheSup); ?></td></tr>
                  <tr><th>Nombre de fiches <br /> mises à jour</th>  <td><?php echo count($FicheMAJ); ?></td></tr>
                  <tr><th>Nombre de <br /> mises à jour totales</th>  <td><?php echo count($FichesMAJ) ; ?></td></tr>
                  <?php echo $filtreTR;?>
              </tbody>
            </table>
          </div>
          <h4>Détails par fiche mise à jour</h4>
          <div>
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Titre</th>
                  <th>Nb de fois mises à jour</th>
                </tr>
              </thead>
              <tbody>
                <?php echo $detailResult;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style media="screen">
  .ui-accordion-header-icon{
    display:inline-block;
    width:20px;
    height:20px;
    margin-right: 10px;
    background-image: url('<?php bloginfo('template_directory');?>/img/btnPlus.svg');
    background-repeat: no-repeat;
    background-size: contain;
  }
  .ui-state-active .ui-accordion-header-icon{
    background-image: url('<?php bloginfo('template_directory');?>/img/btnMoins.svg');
  }
  .ui-widget-content{
    padding-left: 30px;
  }
  .filtreStat input{
    margin-left: 10px;
    margin-right: 10px;
  }
  .description{
    width:60%;
    margin:30px auto;
    border-radius:8px;
    border:1px solid #000;
    padding:10px 20px 20px 20px;
  }
  .stat_test{
    margin-top:50px;
  }
</style>
<script
  src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
  integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
  crossorigin="anonymous">
</script>
<script type="text/javascript">
  jQuery(function($){
    $(document).ready(function(){
      $( ".accordionStat").accordion({
        collapsible: true,
        active: false,
        animate: 200,
        heightStyle: "content"
      });
    })
  })
</script>
<?php
    include_once ('./admin-footer.php');
?>
