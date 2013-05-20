var focusChat = false;

$(function(){
		
		var history = localStorage.getItem('tchat');
				
		try {
				if (history)
				{
						$('#slide-chat').html(history).children().fadeIn(600);
						$('#tchat').scrollTop($('#slide-chat').height());
				}
		} catch( ex ) {
				log('Impossible d\'afficher l\'historique du tchat (navigateur incorect) : '+ex.toString());
		}
});

function insert_tchat_socket( txt, id, username )
{
		show_tip( '<b>'+username+' : </b>'+HTMLentities(txt), '#otherUser-'+id );
}

function send_tchat()
{
		if( MySocket == false)
		{
				crea_socket();
				return;
		}

		var txt = $('#msgTchat').val();

		$('#msgTchat').val('');

		if( !txt || txt.substr(1,user_username.length) == user_username)
				return;

		var data = {
				type : 'tchat', 
				id_user : id_user, 
				id_region : id_region,
				avatar : user_avatar,
				username : user_username,
				txt : txt
		};

		send_socket( data );

		show_tip( '<b>'+user_username+' : </b>'+HTMLentities(txt), '#myUser' );
}

function show_tip( txt, div_id ) 
{
		if( !$(div_id).length )
				return;
				
		$('#slide-chat').append('<p>'+txt+'</p>').children().last().fadeIn(600);
		$('#tchat').scrollTop($('#slide-chat').height());
				
		try {
				localStorage.clear();
				localStorage.setItem('tchat', $('#slide-chat').html());
		} catch( ex ) {
				log('Impossible de sauvegarder le tchat (navigateur incorect) : '+ex.toString());
		}

		var tip = $('<div/>', {
				html: txt,
				'class': 'tip_map_tchat'
		}).prependTo( div_id ==  '#myUser' ? '#map' : '#tableMap').hide();

		var position = $(div_id).position(),
		top = Math.round( position.top - 30 ),
		left = Math.round( position.left - ( Math.round( tip.outerWidth() - size_character_x ) / 2 ) ),
		x_map = $('#mapContener').width();

		var class_css = {
				'position' : 'absolute',
				'z-index' : '8',
				'text-align' : 'center'
		};

		if( top < 0)
				class_css.top = '0px';
		else
				class_css.top = top+'px';

		if( left < 0)
				class_css.left = '0px';
		else if( ( tip.outerWidth() + position.left + size_character_x ) > x_map)
				class_css.right = '0px';
		else
				class_css.left = left+'px';

		tip.css(class_css).show().delay(1000).animate({
				top : '-=40'
		}, 3000 ).animate({
				opacity : 0, 
				top : '-=20'
		}, 2000, function() {
				$(this).remove();
		});
}