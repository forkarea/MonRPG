$(function(){
		
		$(window).resize(function() {
				heigthAuto( 0 );
		});
		
		$('.blank').attr('target','_blank');

		$('#logo').click(function(){
				redirect(url_script);
		});

		heigthAuto();
		msg();

});

function heigthAuto( time ) {
		
		var a = $(window).height(),
		b = $('#my_body').height(),
		c = (a - b) / 2;
				
		if(c <0 ) 
				c = 0;
		
		$('#my_body').animate({
				top:c
		}, time);
}

function changer_nbr_resultat( val )
{
		window.location.replace(document.location.pathname+'?limit='+val);
}

function redirect( url )
{
		$(location).attr('href',url);
}

function regenArray (array)
{
		if(!array.length)
				return new Array();

		var newArray = new Array();

		for (v in array) {
				newArray.push(array[v]);
		} 

		return newArray;
}

function firstArray( array )
{
		if(!array.length)
				return false;

		for (index in array) {
				return index;
		}
}

function position ( obj, position )
{
		if( $(obj).length )
				return parseInt($(obj).css(position).replace('px',''));

		return 0;
}

function start_loading()
{
		$('body').prepend('<div id="laoding_page"></div>');
}

function stop_loading()
{
		$('#laoding_page').remove();
}

function encode( data )
{
		return encodeURIComponent(data);
}

function aleatoire(i) 
{
		if (!i)
				i = 100 ;

		return parseInt(Math.round(Math.random()*i));
}

function msg() 
{
		if($('.msg').length)
				$('.msg').delay(1000).animate({
						opacity: 0, 
						fontSize: '50px', 
						top: '-=200'
				}, 2000, function() {
						$(this).remove();
				} );
}

function HTMLentities(texte) 
{
		texte = texte.replace(/"/g,'&quot;'); // 34 22
		texte = texte.replace(/&/g,'&amp;'); // 38 26
		texte = texte.replace(/\'/g,'&#39;'); // 39 27
		texte = texte.replace(/</g,'&lt;'); // 60 3C
		texte = texte.replace(/>/g,'&gt;'); // 62 3E
		texte = texte.replace(/\^/g,'&circ;'); // 94 5E
		return texte;
}

function log( txt ) 
{
		if( debug )
				console.log(txt);
}

function set_barre( id, value )
{
		var max_valeur = parseInt($(id).find('.valueMaxGraph').html());

		$(id).find('.valueMoyenneGraph').html( value );

		$(id).find('.ContenuGraphique').animate({
				width: ( Math.round( 100 - ( (max_valeur - value) / max_valeur * 100 ) ) )+'%'
		});
}

function isset( variable ) 
{
		return (typeof variable != 'undefined');
}


function refresh()
{
		$('#map').empty().load(url_script+'map/word', function () {
				initMap();
				if($('#commandActionContent').html() == '')
						closeAction();
		});
		
		refresh_user();			
}
	
function refresh_user( inventaire)
{
		$.getJSON(url_script+'user/information', function(data) {
				$.each(data, function(key, val) {
						$('#user_'+key).html(val);
				});
		});		
		
		if(inventaire != null)
				$('#content_footer').load( url_script+'user/inventaire' );
}


/* ACTION */
function closeAction( )	
{
		if($('.infoVS').length && music != '')
				audio(music);
				
		$('#commandAction').fadeOut( 100, function() {
				$('#commandActionContent').empty();
		});
}

function openAction( data )	
{
		$('#commandActionContent').html( data );
		$('#commandAction').fadeIn( 100 );
}

function loadAction( url, callback )	
{
		$('#commandActionContent').load(url_script+url, callback);
		if( $('#commandAction').is(':hidden'))
				$('#commandAction').fadeIn( 100 );
		$('.tipsy').remove();
}