<?php //setcookie('font', '18', time() + 1*24*3600, null, null, false, true); // On écrit un cookie ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="imagetoolbar" content="no">

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/favicon.png" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php // font
 ?>
<link rel="preconnect" href="https://fonts.gstatic.com"><link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<script src="<?php bloginfo('template_url'); ?>/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_url'); ?>/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_url'); ?>/js/scripts.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



<!--[if gte IE 9]>
  <style type="text/css">
  </style>
<![endif]-->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?php bloginfo('template_directory'); ?>/js/html5shiv.js"></script>
      <script src="<?php bloginfo('template_directory'); ?>/js/respond.min.js"></script>
    <![endif]-->

<?php
wp_head(); ?>
</head>
<body class="<?php echo $containerClass; ?>">
  <header id="sticky">

<?php
$idPost = $post->ID;
$getIframe = htmlentities($_GET['iframe']);
if (!$getIframe): ?>
    <ul id="evitement">
       <li>
          <a href="#page">Aller au contenu</a>
       </li>
       <li>
          <a href="#menuHeader">Aller au menu</a>
       </li>
       <li>
          <a href="#recherche">Aller à la recherche</a>
       </li>
    </ul>
    <div class="containerMenu">
      <div id="menuHeader" class="flex">
        <div class="blocImage">
          <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/logo.svg" alt="logo couleur de la sécurité sociale de l'assurance retraite"></a>
        </div>
        <div class="menuPrincipal">
          <?php wp_nav_menu(array(
                  'theme_location' => 'primary'
              )); ?>
                </div>
          <div class="recherche-accessibilite">
            <?php
                include ('searchform.php');
            ?>
            <div id="accessibilites">
              <div class="headerAccess flex">
                <div id="reset" class="A">
                  <span class="accessibilite">
                    Cliquer pour revenir à la taille de police initiale
                  </span>

                  <img src="<?php bloginfo('template_directory'); ?>/img/a.svg" alt="bouton retour police initiale">
                </div>
                <div id="APlus" class="APlus">
                  <span class="accessibilite">
                    Cliquer pour augmenter la taille de la police
                  </span>
                  <img src="<?php bloginfo('template_directory'); ?>/img/aPlus.svg" alt="Bouton augmentation de la police">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
    if ($idPost != 7):
?>
      <div id="fil-ariane" class="breadcrumbs">
        <div class="fdHeader"></div>
      	<div class="content">
      		<?php
        if (is_singular('enquetes')): ?>
            <span property="itemListElement" typeof="ListItem">
              <a property="item" typeof="WebPage" title="Retourner sur la page d'accueil" href="<?php bloginfo('url'); ?>" class="home">
                <span property="name">Accueil</span>
              </a>
              <meta property="position" content="1">
            </span> &gt; <span property="itemListElement" typeof="ListItem"><span property="name" class="post post-page current-item">Aidez-nous !</span>
            <meta property="url" content="http://bwuvaqh.cluster030.hosting.ovh.net/preprod/boite-a-idees/"><meta property="position" content="2"></span>      	</div>
						<?php
        else:
            if (function_exists('bcn_display'))
            {
                bcn_display();
            }
        endif; ?>
      	</div>
      </div>
<?php
    else: ?>
      <div id="fil-ariane" class="breadcrumbs">
        <div class="fdHeader"></div>
      </div><?php
    endif;
endif;
?>
</header>
