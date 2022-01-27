function removeParams(sParam){

	var url = window.location.href.split('?')[0]+'?';
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] != sParam) {
			url = url + sParameterName[0] + '=' + sParameterName[1] + '&'
		}
	}

	return url.substring(0,url.length-1);

}

/***************
FUNCTION MSGBOX ET WINDOW
****************/

function closeMsgBox(){
	$.fancybox.close();
}

function closeWindow(){
	if(window.opener){ window.opener.location.reload(); }
	window.close();
}

//PARAMETRES PAR DEFAUT DE FANCYBOX
var fancyboxDefaults = Object(
{
	type:'ajax',
	dataType:'html',
	autoSize:true,
	modal:true,
	closeSpeed : 0,
	openSpeed : 200,	
	openOpacity : false,
	closeOpacity : false,
	helpers : {
		overlay : {
			speedOut   : 0,
			css : {
				'background' : 'rgba(58, 42, 45, 0.3)'
			},
			locked: false
		}
	}
});

// Ajoute une fonction permettant de désactiver le clic sur une fancybox
(function( $ ) {
	jQuery.extend($.fancybox,{
		disableClick: function(options) {
			var defauts = {
			   "loading" : true
			}; 
			var parametres = $.extend(defauts, options); 
			if(parametres.loading){	$.fancybox.showLoading() }
			
			var fb = $('.fancybox-opened');
			var fbc = $('.fancybox-skin');
			fb.append('<div class="disable-panel"><img src="/images/spacer.png"></div>')
				.find('div[class=disable-panel]')
					.height(fbc.outerHeight(true))
					.width(fbc.outerWidth(true))
					.css({
						'top' : fbc.position().top, 
						'left' : fbc.position().left,
						'position' : 'absolute',
						'z-index' : '9000'
					})
					.find('img')
						.height(fbc.outerHeight(true))
						.width(fbc.outerWidth(true))
    	},
		enableClick: function() {
			$('.fancybox-opened').find('div[class=disable-panel]').remove();
			$.fancybox.hideLoading();
		}
	});
})( jQuery );