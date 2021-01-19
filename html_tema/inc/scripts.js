(function($){

var w = $( window ).width();	
	
var swiper = new Swiper('.swiper-container', {
  pagination: {
	el: '.swiper-pagination',
  },
  navigation: {
	nextEl: '.swiper-button-next',
	prevEl: '.swiper-button-prev',
  },
});	
	
$(window).scroll(function () {
	
		if ($(this).scrollTop() > 2 ) {
			
			$('.sayfa-basina-git').fadeIn();


		} else {
			$('.sayfa-basina-git').fadeOut();
		}
	

});
	
$('.sayfa-basina-git').click(function(){
    $('html, body').animate({
        scrollTop: $( $(this).attr('href') ).offset().top
    }, 500);
    return false;
});	  

	
$('.drawer').drawer();	
$('.drawer-menu').find('li a').addClass('drawer-menu-item');
	


$(".mobil-menu .ust-oge a").click(function(){

		$(".ust-oge").children('.alt-menu').slideToggle('fast');
		 return false;
});

	

$('.renkli-baslik').html(function(){	
		var ayirma= $(this).text().split(' ');
		var sonkelime = ayirma.pop();
		return ayirma.join(" ") + (ayirma.length > 0 ? ' <span class="kirmizi">'+sonkelime+'</span>' : sonkelime);   
});	



	
	

	
})(jQuery);