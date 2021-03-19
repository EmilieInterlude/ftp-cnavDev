jQuery( document ).ready(function() {
  $('.sliderProduit-for').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   arrows: true,
   fade: true,
 });
 $('.sliderProduit-nav').slick({
   slidesToShow: 5,
   slidesToScroll: 0,
   asNavFor: '.sliderProduit-for',
   dots: false,
   centerMode: true,
   focusOnSelect: true
 });


  $('.sliderProduitsPlusLoin').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    adaptiveHeight: false,
    arrows: true,
    dots: false,
    autoplay: false,
    autoplaySpeed: 2000,
  });
  $('.sliderAccueil').slick({
    dots: false,
    arrows:false,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear'
  });

  maxHauteur=1;
  $('.blocProduitLoin.slick-slide .bloc').each(function(){
    hauteurBloc=$(this).height();
    if(hauteurBloc>500){
      $('.sliderProduitsPlusLoin .slick-track').css('height',hauteurBloc + 'px');
    }
  });
  $('.btnVideo').click(function(e){
    $('.PopUpVideo').removeClass('hidden');
  })
  $('.contenuVideo .btnVideoClosed').click(function(e){
    $('.PopUpVideo').addClass('hidden');
    $('.PopUpVideo iframe').attr('src', $('.contenuVideo iframe').attr('src'));
  })
  $( ".accordeons").accordion({
    collapsible: true,
    active: false,
    animate: 200,
    heightStyle: "content"
  });

 $('.slick-arrow').text('');
});

function deSelect(idAnnule){
  $('span[data-taxo="'+idAnnule+'"]').remove();
  $('input[id="'+idAnnule+'"]').attr("checked",false);
  document.forms['formFiltre'].submit();
			// 	jQuery(this).attr("checked",false);
			// 	alert('test');
			// });
}
function submitSondage(reponse){
	jQuery('input[type=radio][name=sondage]').attr('checked', false);
	jQuery('input[type=radio][name=sondage][value=' + reponse + ']').attr('checked', true);
	jQuery('#sondageForm').submit();
}
