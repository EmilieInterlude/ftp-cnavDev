<?php //fichier permettant d'afficher les statistiques globales dans l'administration ?>
<?php
    require_once ('admin.php');
    include_once ('./admin-header.php');
?>
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
</style>
<div class="wrap nosubsub">
  <div id="stat">
    <h1>Statistiques des enquêtes</h1>
    <div class="accordionStat">
      <?php
      global $wpdb;
      $reqEnquete = "SELECT `ID`
      FROM $wpdb->posts
      WHERE `post_status`='publish' AND `post_type`='enquetes'";
      $enquetes = $wpdb->get_results($reqEnquete);
$contentGlobStat="";
      foreach ($enquetes as $value) {

        while ( have_rows('questionnaireEnquete',$value->ID) ) :the_row();
          $typeInput="";
          $typeQuestion=get_sub_field('typeQuestionEnquete',$value->ID);
          $contentGlobStat.='<h3>'.get_sub_field('questionEnquete',$value->ID).'</h3>';
            if($typeQuestion != "ouverte"):
              $itemChoix=get_sub_field('listeChoixPossiblesEnquete',$value->ID);
              if($itemChoix):
                $nbItemRep=1;
                $contentGlobStat.="<table><thead><th></th><th>Oui</th><th>Non</th><th>NSP</th></thead><tbody>";
                $nbOui=0;
                $nbNon=0;
                $nbNSP=get_sub_field('NSPEnquete',$value->ID);
                while ( have_rows('listeChoixPossiblesEnquete',$value->ID) ) :the_row();
                  $item=get_sub_field('ChoixPossiblesEnquete',$value->ID);
                  $itemRep=get_sub_field('item',$value->ID);
                  $nbOui=get_sub_field('reponseOuiTotaleEnquete',$value->ID);
                  $nbNon=get_sub_field('reponseNonTotaleEnquete',$value->ID);
                  $contentGlobStat.='<tr><td>'.$item.'</td><td>'.$nbOui.'</td><td>'.$nbNon.'</td><td>'.$nbNSP.'</td></tr>';
                  $nbItemRep++;
                endwhile;
                $contentGlobStat.='</tbody></table>';
              endif;
            else:
              $contentGlobStat.="<p>Question ouverte : Voir le détail</p>";
            endif;
        endwhile;

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
          $contentDetail="<table>";
          $contentDetailContent="<tbody>";
          $contentDetailHead="<thead>";
          $nbRep=1;
          while ( $the_query->have_posts() ):
            $the_query->the_post();
            $contentGlob="<strong>Nombre de participations : $nbParticipants</strong>";
            $questions=get_field('questionnaireEnqueteReponse');
            $nbQuestRep=1;
            $contentDetailContent.="<tr>";
            if($nbRep==1):$contentDetailHead.="<tr>";endif;
            while ( have_rows('questionnaireEnqueteReponse') ) :the_row();
              $typeInput="";
              $typeQuestion=get_sub_field('typeQuestionEnqueteReponse');
              $contentDetailContent.='<td>'.get_sub_field('questionEnqueteReponse').'</td>';
              if($nbRep==1):$contentDetailHead.='<th>Question'.$nbQuestRep.'</th>';endif;
                if($typeQuestion != "ouverte"):
                  $itemChoix=get_sub_field('listeChoixPossiblesEnqueteReponse');
                    $nbItemRep=1;
                    while ( have_rows('listeChoixPossiblesEnqueteReponse') ) :the_row();
                      $item=get_sub_field('ChoixPossiblesEnqueteReponse');
                      $itemRep=get_sub_field('itemReponse');
                      $contentDetailContent.='<td>'.$item.'</td><td>'.$itemRep.'</td>';
                      if($nbRep==1):$contentDetailHead.='<th>Item '.$nbItemRep.'</th><th>Reponse '.$nbItemRep.'</th>';endif;
                      $nbItemRep++;
                    endwhile;
                else:
                  $itemRep=get_sub_field('textareaReponse');
                  $contentDetailContent.="<td>$itemRep</td>";
                  if($nbRep==1):$contentDetailHead.='<th>Réponse ouverte quest'.$nbQuestRep.'</th>';endif;
                endif;
              $nbQuestRep++;
            endwhile;
            $contentDetailContent.="</tr>";
            if($nbRep==1):$contentDetailHead.="</tr>";endif;
            $nbRep++;
          endwhile;
          $contentDetailHead.="</thead>";?>
          <div class="stat_test accordionStat">
            <h3>Global</h3>
            <div class="glob">
<?php
              echo $contentGlob.  $contentGlobStat;?>
            </div>
            <h3>Détails</h3>
            <div class="">
<?php
              echo $contentDetail. $contentDetailHead. $contentDetailContent."</tbody></table>";
?>
            </div>
          </div>
          <?php
        endif;
      }?>
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
