<footer>
  <div class="content">
    <div class="flex">
      <div class="blocLogoFooter">
        <img src="<?php bloginfo('template_directory');?>/img/logo-blanc.svg" alt="logo blanc de la sécurité sociale de l'assurance retraite'">
      </div>
<?php
      $rsxScx=get_field('rsxScx','options');
      if($rsxScx):
?>
        <div class="rsxScx flex" >
          <p>Suivre l'assurance retraite :</p>
          <div class="pictoRsxScx">
<?php
            while(have_rows('rsxScx','options')):the_row();
              $nomRsx=get_sub_field('nomRsxScx');
              $urlRsx=get_sub_field('urlRsxScx');
              $pictoRsx=get_sub_field('pictoRsxScx');
?>
              <a href="<?php echo $urlRsx;?>" target="_blank" title="accéder à notre page <?php echo $nomRsx;?>">
                <img src="<?php echo $pictoRsx;?>">
              </a>
<?php
            endwhile;
?>
        </div>
      </div>
<?php
      endif;
?>
    </div>
    <div class="menuFooter">
      <?php wp_nav_menu( array( 'theme_location' => 'menuFooter' ) );?>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
