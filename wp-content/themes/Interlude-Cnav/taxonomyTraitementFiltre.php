<?php
$validation="";
$validation=htmlentities($_POST['valid']);
if($validation=="OK"):
  $filtreProduit=$_POST['filtreProduit'];
  if($filtreProduit):
    $itemsArgs=array(array(
      'taxonomy' => "$taxo_name",
      'field' => 'slug',
      'terms' =>"$term_slug",
    ));
    foreach ($filtreProduit as $items) {
      $term_slugFiltre=get_term($items)->slug;
      $taxo_nameFiltre=get_term($items)->taxonomy;
        $itemsChoix=array(array(
          'taxonomy' => "$taxo_nameFiltre",
          'field' => 'slug',
          'terms' => "$term_slugFiltre",
        ));
        array_push($itemsArgs,$itemsChoix);
    }
    $args = array(
      'post_type' => 'produits',
      'tax_query' => array(
          $itemsArgs
      ),
    );
  	$query = new WP_Query( $args );
  else:
    $validation="NO";
    $itemsArgs2=array(array(
      'taxonomy' => "$taxo_name",
      'field' => 'slug',
      'terms' =>"$term_slug",
    ));
    $args2 = array(
      'post_type' => 'produits',
      'tax_query' => array(
          $itemsArgs2
      ),
    );
    $query2 = new WP_Query( $args2 );
    $nbResultat=$query2->post_count;
  endif;
else:
  $itemsArgs=array(array(
    'taxonomy' => "$taxo_name",
    'field' => 'slug',
    'terms' =>"$term_slug",
  ));
  $args = array(
    'post_type' => 'produits',
    'tax_query' => array(
        $itemsArgs
    ),
  );
  $query2 = new WP_Query( $args );
  $nbResultat=$query2->post_count;
  $validation=="NO";
endif;

?>
