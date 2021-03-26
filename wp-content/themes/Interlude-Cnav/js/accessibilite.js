
$(document).ready(function() {
  var accessCookie = 'font'; //Le nom du cookie
  function getSavedSize(){
    var taille = parseFloat($('html').css('font-size'));//On va chercher la taille actuelle
    var cookieTaille = $_COOKIE(accessCookie);
    if(cookieTaille){   //Si la valeur existe, nous l'affectons à la variable
        taille = cookieTaille;
    }
    return taille;
  }

  function saveSize(size){
    $_COOKIE(accessCookie, size, { expires: 1 }); //Expires dans 1 an
  }


  //Ensuite, nous devons ajouter le code pour la modification de la taille de police. C'est plutôt facile avec jQuery;

  var originalSize = $('html').css('font-size'); //Pour revenir à la taille en tout temps,
  //même si celle-ci est modifié par l'utilisateur (qui utilise IE par exemple)
  function modifyFont(increase){
   var nouvelleTaille = parseFloat($('html').css('font-size')) + increase;
   setFont(nouvelleTaille);
  }

  function setFont(size){
   $('html').animate({fontSize:size},300);
   saveSize(size);
  }


  //Finalement, on ajoute le code pour que les différents boutons utilisent le code;


  $('#APlus').click(function(){
    modifyFont(1); //Normalement, les gens veulent grossir la police rapidement
    $('header #headerMenu .container nav ul li a').css('marginLeft','0px');
    $('header #headerMenu .container nav').css('marginLeft','0px').css('marginTop','20px');
    return false;
  });
  $('#reset').click(function(){
     setFont(originalSize);
     $('header #headerMenu .container nav ul li a').css('marginLeft','12px');
     if($('body').width()<=930){
       $('header #headerMenu .container nav').css('marginLeft','195px').css('marginTop','0px');
     }
     return false;
  });
  $('#AMoins').click(function(){
    modifyFont(-0.5); //Ou ils veulent la réduire lentement, afin d'être précis
    return false;
  });

  //Afin de modifier la taille de la police au chargement (ainsi l'utilisateur ne voit
  //pas que la police est modifié à chaque nouvelle page)
  var size = getSavedSize() + '';
  $("html").css({fontSize : size + (size.indexOf("px")!=-1 ? "" : "px")});
});
