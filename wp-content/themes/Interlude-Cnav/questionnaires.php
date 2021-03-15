<?php
/* -------    Traitement sondage    -------*/
$sondageId=get_field('AfficheSondageFooter','options')[0];
$titreSondage=get_the_title($sondageId);
$affichageSonde=get_field('affichageSonde',$sondageId);
$nbSondesSondage=get_field('nbSondesSondage',$sondageId);
$nbOuiSondage=get_field('nbOuiSondage',$sondageId);
$nbNonSondage=get_field('nbNonSondage',$sondageId);
$resultSondage="";
$valid=htmlentities($_POST['Valid']);
if($valid=="ok"):
  update_post_meta($sondageId, 'nbSondesSondage', $nbSondesSondage+1);
  $resultSondage=$_POST['sondage'];
  if($resultSondage=="Oui"):
    update_post_meta($sondageId, 'nbOuiSondage', $nbOuiSondage+1);
    $nbOuiSondage=$nbOuiSondage+1;
  elseif($resultSondage=="Non"):
    update_post_meta($sondageId, 'nbNonSondage', $nbNonSondage+1);
    $nbNonSondage=$nbNonSondage+1;
  endif;
  $nbSondesSondage=$nbSondesSondage+1;
endif;
$resultatSondageGlob="";
if($nbSondesSondage!=0):
  if($affichageSonde=="nbOui"):
    if($nbOuiSondage==0):
      $pourcentOui=0;
    else:
      $pourcentOui=ceil(($nbOuiSondage/$nbSondesSondage)*100);
    endif;
    $resultatSondageGlob="<p>$pourcentOui% des participants ont répondu oui</p>";
  else:
    if($nbNonSondage==0):
      $pourcentNon=0;
    else:
      $pourcentNon=ceil(($nbNonSondage/$nbSondesSondage)*100);
    endif;
    $resultatSondageGlob="<p>$pourcentNon% des participants ont répondu non</p>";
  endif;
endif;
/* -------    Traitement enquête    -------*/
$enqueteId=get_field('AfficheEnqueteFooter','options')[0];
$titreEnquete=get_the_title($enqueteId);
$lienEnquete=get_permalink($enqueteId);


/* -------    Affichage bloc   -------*/
?>
<div class="questionnaires">
  <div class="content flex">
<?php
    if($sondageId):
?>
      <div class="sondage flex">
        <h2>Sondage</h2>
        <form id="sondageForm" action="#sondageForm" method="post">

          <p><?php echo $titreSondage;?></p>
          <input class="hidden" type="radio" name="sondage" value="Oui">
          <input class="hidden" type="radio" name="sondage" value="Non">
          <input type="hidden" name="Valid" value="ok">
        </form>
        <div class="flex blocBtn">
          <span class="<?php if($resultSondage=="Oui"):echo "btnBleu";else:echo 'btnBlanc';endif;?>" onclick="submitSondage('Oui');"><span class="accessibilite">Cliquer pour répondre</span> Oui</span>
          <span class="<?php if($resultSondage=="Non"):echo "btnBleu";else:echo 'btnBlanc';endif;?>" onclick="submitSondage('Non');"><span class="accessibilite">Cliquer pour répondre</span> Non</span>
        </div>
        <?php echo $resultatSondageGlob;?>
      </div>
<?php
    endif;
    if($enqueteId):
?>
      <div class="enquete flex">
        <h2>Aidez-nous !</h2>
        <p>Nous menons une enquête sur <br /><?php echo $titreEnquete;?>.</p>
        <a class="btnBleu" href="<?php echo $lienEnquete;?>">Participer</a>
      </div>
<?php
    endif;
?>
  </div>
</div>
