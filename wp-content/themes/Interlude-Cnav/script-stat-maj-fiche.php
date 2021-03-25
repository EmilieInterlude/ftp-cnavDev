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
    <h1>Statistiques des fiches mises à jour</h1>
    Calculer les statistiques :
    <form class="filtreStat" action="" method="post">
      <div class="flex">
        <span>de<sup>*</sup></span>
        <input type="date" name="dateDeb" min="2021-01-01" max="<?php $dateMax=date("Y-m-d"); echo $dateMax;?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
        <span>à<sup>*</sup></span>
        <input type="date" name="dateFin" min="2021-01-01" max="<?php $dateMax=date("Y-m-d"); echo $dateMax;?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
      </div>
      <input type="hidden" name="valid" value="OK">
      <input type="submit" name="envoi" value="Filtrer">
    </form>
    <div class="accordionStat">
      <?php
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
