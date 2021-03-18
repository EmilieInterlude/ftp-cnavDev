<?php
$containerClass="Page Single Enquetes";
include("header.php");
?>
<?php
while ( have_posts() ) : the_post();
  $intro=get_field('texteIntroEnquete');
  $questions=get_field('questionnaireEnquete');
  include('traitement-enquete.php');
?>
  <main role="main" id="page" class="clearfix">
  	<div id="corps" class="content">
      <h1>Aidez-nous !</h1>
      <div class="blocQuest flex">
        <div class='img'>
          <img src="<?php bloginfo('template_directory');?>/img/enquete.svg" class="aligncenter">
        </div>
        <div class="questionnaire">
<?php
          if($intro):
?>
            <div class="intro">
              <?php echo $intro;?>
            </div>
<?php
          endif;
          if($questions):?>
            <form class="questions" action="#" method="post">


<?php
            $nbQuest=1;
            while ( have_rows('questionnaireEnquete') ) :the_row();
              $typeInput="";
              $typeQuestion=get_sub_field('typeQuestionEnquete');
?>
              <div class="question">
                <strong class="quest"><?php the_sub_field('questionEnquete');?></strong>
<?php
                if($typeQuestion != "ouverte"):
                  if($typeQuestion =="choixUnique"):
                    $typeInput="radio";
                  else:
                    $typeInput="checkbox";
                  endif;
                  $itemChoix=get_sub_field('listeChoixPossiblesEnquete');
                  if($itemChoix):
                    $nbItem=1;?>
                    <div class="flex">
<?php
                    while ( have_rows('listeChoixPossiblesEnquete') ) :the_row();
                      $item=get_sub_field('ChoixPossiblesEnquete');?>
                      <div class="flex">
                        <input type="<?php echo $typeInput;?>" name="quest<?php echo $nbQuest; if($typeQuestion !="choixUnique"):echo '[]';endif;?>" value="item<?php echo $nbItem;?>">
                        <span><?php echo $item;?></span>
                      </div>
<?php
                        $nbItem++;
                    endwhile;?>
                    </div>
<?php
                  endif;
?>
<?php
                else:
?>
                  <textarea name="quest<?php echo $nbQuest; ?>" rows="8" cols="100" placeholder="Saisissez votre réponse"></textarea>
<?php
                endif;
?>
              </div>
<?php
              $nbQuest++;
            endwhile;
?>
              <input type="hidden" name="valid" value="ok">
              <span id="wpcf7-6051cead0334a-wrapper" class="wpcf7-form-control-wrap your-name-wrap" style="display:none !important; visibility:hidden !important;"><label for="wpcf7-6051cead0334a-field" class="hp-message">Veuillez laisser ce champ vide.</label><input id="wpcf7-6051cead0334a-field" class="wpcf7-form-control wpcf7-text" type="text" name="your-name" value="" size="40" tabindex="-1" autocomplete="new-password"></span>
              <input type="submit" value="Envoyer" class="btnBleu">
            </form>
<?php
          endif;
?>
        </div>
      </div>
    </div>
  </main>
<?php
endwhile; // end of the loop. ?>
<?php get_footer(); ?>
