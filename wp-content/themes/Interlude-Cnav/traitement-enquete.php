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
      if($typeQuestionRep != "ouverte"):
        $itemChoixRep=get_sub_field('listeChoixPossiblesEnquete');
        $variablePost="quest".$nbQuestRep;
        $repQuest=$_POST["$variablePost"];
        if($itemChoixRep):
          $nbItemRep=1;
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
                $metaValueQuest="Oui";
              else:
                $metaValueQuest="Non";
              endif;
            elseif($typeQuestionRep =="choixMultiple" && $repQuest):
              if(in_array($valeurInputQuest,$repQuest)):
                $metaValueQuest="Oui";
              else:
                $metaValueQuest="Non";
              endif;
            else:
              $metaValueQuest="NSP";
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
