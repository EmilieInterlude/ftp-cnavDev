<?php //fichier permettant d'afficher les statistiques globales dans l'administration ?>
<?php
    require_once ('admin.php');
    include_once ('./admin-header.php');
?>
<div class="wrap nosubsub">
  <div id="stat">
    <h1>Statistiques des enquêtes</h1>
    <div class="<?php/*accordionStat*/?>">
      <?php
      global $wpdb;
      $reqEnquete = "SELECT `ID`
      FROM $wpdb->posts
      WHERE `post_status`='publish' AND `post_type`='enquetes'";
      $enquetes = $wpdb->get_results($reqEnquete);

      foreach ($enquetes as $value) {
        ?>
        <h2><?php echo get_the_title($value->ID);?></h2>
        <?php
        $args = array(
          'post_type'  => 'reponses',
          'post_status'  => 'publish',
          'posts_per_page' => -1,
          'meta_query'	=> array(
        		array(
        			'key'	  	=> 'EnqueteReponse',
        			'value'	  	=> $value->ID,
        			'compare' 	=> '=',
        		),
	        ),
          'order' => 'DESC'
        );
        $the_query = new WP_Query($args);
        $nbParticipants=$the_query->post_count;

        if ( $the_query->have_posts() ):
          while ( $the_query->have_posts() ):
            $the_query->the_post();
            $contentGlob="<strong>Nombre de participations : $nbParticipants</strong>";
            $questions=get_field('questionnaireEnqueteReponse');
            $nbQuestRep=1;
            while ( have_rows('questionnaireEnqueteReponse') ) :the_row();
              $typeInput="";
              $typeQuestion=get_sub_field('typeQuestionEnqueteReponse');
              $contentGlob.='<h3>'.get_sub_field('questionEnqueteReponse').'</h3>';
                if($typeQuestion != "ouverte"):
                  $itemChoix=get_sub_field('listeChoixPossiblesEnqueteReponse');
                  if($itemChoix):
                    $nbItemRep=1;
                    $contentGlob.="<table><thead><th></th><th>Oui</th><th>Non</th><th>NSP</th></thead><tbody>";
                    while ( have_rows('listeChoixPossiblesEnqueteReponse') ) :the_row();
                      $item=get_sub_field('ChoixPossiblesEnqueteReponse');
                      $contentGlob.='<tr><td>'.$item.'</td><td>nbOui</td><td>nbNon</td><td>nbNSP</td></tr>';
                      $nbItemRep++;
                    endwhile;
                    $contentGlob.='</tbody></table>';
                  endif;
                else:
                  $contentGlob.="<p>Question ouverte : Voir le détail</p>";
                endif;
              $nbQuestRep++;
            endwhile;
          endwhile;?>
          <div class="stat_test accordionStat">
            <h3>Global</h3>
            <div class="glob">
<?php
              echo $contentGlob;?>
            </div>
            <h3>Détails</h3>
            <div class="">
              content detail
            </div>
          </div>
          <?php
        endif;
      }?>


<?php
      // 
      // $variablePost="quest".$nbQuestRep;
      // $repQuest=$_POST["$variablePost"];
      // if($itemChoixRep):
      //   $nbItemRep=1;
      //   while ( have_rows('listeChoixPossiblesEnquete') ) :the_row();
      //     $valeurInputQuest="item".$nbItemRep;
      //     if($typeQuestionRep =="choixUnique" && $repQuest):
      //       $repQuest=htmlentities($repQuest);
      //       if($repQuest==$valeurInputQuest):
      //         $metaValueQuest="Oui";
      //       else:
      //         $metaValueQuest="Non";
      //       endif;
      //     elseif($typeQuestionRep =="choixMultiple" && $repQuest):
      //       if(in_array($valeurInputQuest,$repQuest)):
      //         $metaValueQuest="Oui";
      //       else:
      //         $metaValueQuest="Non";
      //       endif;
      //     else:
      //       $metaValueQuest="NSP";
      //     endif;


?>



    </div>
  </div>
</div>
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
