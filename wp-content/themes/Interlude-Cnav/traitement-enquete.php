<?php
$valid="";
$valid=$_POST['valid'];
$honeypot=$_POST['your-name'];
if($valid=="ok" && !$honeypot):
  $enqueteId=$post->ID;
  $titre= get_the_title().'-'.date('Ymd-His');
  $args=array(
    'post_title'    => $titre,
    'post_status'   => 'publish',
    'post_type'   => 'reponses',
  );
  $reponseId =  wp_insert_post( $args ) ;
  add_post_meta($reponseId, 'EnqueteReponse', "$enqueteId", true);
  if($questions):
    $nbQuestRep=1;
    while ( have_rows('questionnaireEnquete') ) :the_row();
      $nbQuestKey=$nbQuestRep-1;
      $typeQuestionRep=get_sub_field('typeQuestionEnquete');
      $metaKeyQuest='questionnaireEnqueteReponse_'.$nbQuestKey.'_questionEnqueteReponse';
      $metaValueQuest = get_sub_field('questionEnquete');
      add_post_meta($reponseId, $metaKeyQuest, $metaValueQuest, true);
      add_post_meta($reponseId, "_".$metaKeyQuest, "field_6051e1743e8bf", true);
      $metaKeyQuest='questionnaireEnqueteReponse_'.$nbQuestKey.'_typeQuestionEnqueteReponse';
      $metaValueQuest = get_sub_field('typeQuestionEnquete');
      add_post_meta($reponseId, $metaKeyQuest, $metaValueQuest, true);
      add_post_meta($reponseId, "_".$metaKeyQuest, "field_6051e3e67a261", true);
      $variablePost="quest".$nbQuestRep;
      $repQuest=$_POST["$variablePost"];
      $nbNSPVal=intval(get_sub_field('NSPEnquete'));
      if($typeQuestionRep != "ouverte"):
        $itemChoixRep=get_sub_field('listeChoixPossiblesEnquete');
        if($itemChoixRep):
          $nbItemRep=1;
          $nbOui=0;
          $nbNon=0;
          $nbNSP=0;
          while ( have_rows('listeChoixPossiblesEnquete') ) :the_row();
            $valeurInputQuest="item".$nbItemRep;
            $nbItemKey=$nbItemRep-1;
            $metaKeyQuest='questionnaireEnqueteReponse_'.$nbQuestKey.'_listeChoixPossiblesEnqueteReponse_'.$nbItemKey.'_ChoixPossiblesEnqueteReponse';
            $metaValueQuest = get_sub_field('ChoixPossiblesEnquete');
            add_post_meta($reponseId, $metaKeyQuest, $metaValueQuest, true);
            add_post_meta($reponseId, "_".$metaKeyQuest, "field_6051e17442f22", true);
            if($typeQuestionRep =="choixUnique" && $repQuest):
              $repQuest=htmlentities($repQuest);
              if($repQuest==$valeurInputQuest):
                $metaKeyEnq='questionnaireEnquete_'.$nbQuestKey.'_listeChoixPossiblesEnquete_'.$nbItemKey.'_reponseOuiTotaleEnquete';
                $metaValueQuest="Oui";
                $nbOui=intval(get_sub_field('reponseOuiTotaleEnquete'))+1;
                update_post_meta($enqueteId,$metaKeyEnq,$nbOui);
              else:
                $metaValueQuest="Non";
                $metaKeyEnq='questionnaireEnquete_'.$nbQuestKey.'_listeChoixPossiblesEnquete_'.$nbItemKey.'_reponseNonTotaleEnquete';
                $nbNon=intval(get_sub_field('reponseNonTotaleEnquete'))+1;
                update_post_meta($enqueteId,$metaKeyEnq,$nbNon);
              endif;
            elseif($typeQuestionRep =="choixMultiple" && $repQuest):
              if(in_array($valeurInputQuest,$repQuest)):
                $metaValueQuest="Oui";
                $metaKeyEnq='questionnaireEnquete_'.$nbQuestKey.'_listeChoixPossiblesEnquete_'.$nbItemKey.'_reponseOuiTotaleEnquete';
                $nbOui=intval(get_sub_field('reponseOuiTotaleEnquete'))+1;
                update_post_meta($enqueteId,$metaKeyEnq,$nbOui);
              else:
                $metaValueQuest="Non";
                $metaKeyEnq='questionnaireEnquete_'.$nbQuestKey.'_listeChoixPossiblesEnquete_'.$nbItemKey.'_reponseNonTotaleEnquete';
                $nbNon=intval(get_sub_field('reponseNonTotaleEnquete'))+1;
                update_post_meta($enqueteId,$metaKeyEnq,$nbNon);
              endif;
            else:
              $metaKeyEnq='questionnaireEnquete_'.$nbQuestKey.'_NSPEnquete';
              $metaValueQuest="NSP";
              $nbNSP=$nbNSPVal+1;
              update_post_meta($enqueteId,$metaKeyEnq,$nbNSP);
            endif;
            $metaKeyQuest='questionnaireEnqueteReponse_'.$nbQuestKey.'_listeChoixPossiblesEnqueteReponse_'.$nbItemKey.'_itemReponse';
            add_post_meta($reponseId, $metaKeyQuest, $metaValueQuest, true);
            add_post_meta($reponseId, "_".$metaKeyQuest, "field_6051e24f442bf", true);
            $nbItemRep++;
          endwhile;


          $metaKeyQuest='questionnaireEnqueteReponse_'.$nbQuestKey.'_listeChoixPossiblesEnqueteReponse';
          $metaValueQuest=$nbItemRep-1;
          add_post_meta($reponseId, $metaKeyQuest, $metaValueQuest, true);
          add_post_meta($reponseId, "_".$metaKeyQuest, "field_6051e1743e93c", true);
        endif;
      else:
        $metaKeyQuest='questionnaireEnqueteReponse_'.$nbQuestKey.'_textareaReponse';
        $metaValueQuest=htmlentities($_POST["quest$nbQuestRep"]);
        add_post_meta($reponseId, $metaKeyQuest, $metaValueQuest, true);
        add_post_meta($reponseId, "_".$metaKeyQuest, "field_6051e44a7a262", true);
      endif;
      $nbQuestRep++;
    endwhile;
    $metaKeyQuest='questionnaireEnqueteReponse';
    $metaValueQuest=$nbQuestRep-1;
    add_post_meta($reponseId, $metaKeyQuest, $metaValueQuest, true);
    add_post_meta($reponseId, "_".$metaKeyQuest, "field_6051e1743ba08", true);
  endif;



endif;

?>
