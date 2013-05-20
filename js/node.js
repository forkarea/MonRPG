function init_socket()
{		
		if(MySocket != false)
				send_info_socket( 'move');

		try {
				MySocket = io.connect(url_websocket+':'+port_websocket);

				MySocket.on('connect',function() {
						
						crea_socket();

						MySocket.on('message', function (data) {
								recup_info_socket(data);
						});

						MySocket.on('disconnected', function (data) {
								recup_info_socket(data);
						});
				});

		} catch( ex ) {
				log('Erreur init_socket() : '+ex.toString());
		}
}

function send_socket( data)
{
		if( MySocket == false)
				return;

		try {
				data.url = compte_game;
				MySocket.emit('envois', data);

		} catch( ex ) {
				log('Erreur send_socket() : '+ex.toString());
		}
}

function crea_socket( )
{
		if( MySocket == false)
				return;

		try {
				send_info_socket( 'add');
		} catch( ex ) {
				log('Erreur crea_socket( ): '+ex.toString());
		}
}
	
function recup_info_socket( data)
{
		if( data == null ||  data == undefined || data.url != compte_game || data.id_user == id_user )
				return;
		
		if( data.type == 'delete' || data.id_region != id_region) 
		{
				delete_user_socket( data.id_user );
				return;
		}
		
		switch(data.type)
		{
				case 'tchat' :
						insert_tchat_socket( data.txt, data.id_user, data.username);
						break;
				case 'add' :
						insert_user_socket( data.id_user, data.new_x, data.new_y, data.avatar, data.username );
						break;
				case 'move' :
						update_user_socket( data.id_user, data.new_x, data.new_y, data.avatar, data.old_x, data.old_y, data.username);
						break;
				case 'move-bot' :
						update_bot_socket( data.id, data.x_old, data.y_old, data.x, data.y);
				case 'kill-bot' :
						$( '#bot-'+data.id ).remove();
						break;
		}
}
	
/*USER*/	
function send_info_socket( type, Px, Py)
{
		if( MySocket == false)
				return;
						
		if(Px == null)
				Px = userX;
				
		if(Py== null)
				Py = userY;
				
		var data = {
				type : type, 
				id_user : id_user, 
				id_region : id_region,
				new_x : Px,
				new_y : Py,
				avatar : user_avatar,
				old_x : userX,
				old_y : userY,
				username : user_username
		};
				
		send_socket( data);
}

function update_user_socket( id, x, y, img , x_old, y_old, username)
{
		if(!$('#otherUser-'+id).length)
		{
				insert_user_socket( id, x, y, img, username );
				return;
		}
				
		$('#otherUser-'+id).stop().css({
				'background-image' : 'url(\''+img+'\')',
				'top' : ( y_old * 32),
				'left' : ( x_old * 32)
		});
										
		calculMove( [[x, y]], [x_old, y_old], '#otherUser-'+id, null, true );
}

function insert_user_socket( id, x, y, img, username)
{				
		if($('#otherUser-'+id).length)
				return;
				
		$('#tableMap').append('<div id="otherUser-'+id+'" class="otherUsers invis"><div class="usernameUsers">'+username+'</div></div>');
			
		$('#otherUser-'+id).css( {
				'background-image' : 'url(\''+img+'\')', 
				'top' : (y * size_case), 
				'left' : (x * size_case)
		} ).show();
				
		$('.tipsy').remove();
		$('.elements').tipsy({
				gravity : 's',
				delayIn : 0
		});
}

function delete_user_socket( id )
{
		var my_this = $('#otherUser-'+id);
				
		if(!my_this.length)
				return;
				
		my_this.stop().remove();
				
		$('.tipsy').remove();
		$('.elements').tipsy({
				gravity : 's',
				delayIn : 0
		});
}

/*BOT*/
function send_bot_socket( type, x_old, y_old, Px, Py, id)
{
		if( MySocket == false || Px == null || Py== null)
				return;

		if( 'bot-'+$('#idBot').html() == id)
				closeAction();
				
		var data = {
				type : type, 
				id_region : id_region,
				id : id,
				x : Px,
				y : Py,
				x_old : x_old,
				y_old : y_old
		};
				
		send_socket( data);
}

function update_bot_socket( id, x_old, y_old, x, y)
{
		if( 'bot-'+$('#idBot').html() == id)
				closeAction();
		
		$('#'+id).stop().css({
				'top' : ( y_old * 32),
				'left' : ( x_old * 32)
		});
										
		var startPoint = [x_old, y_old],
		result = AStar(obstacle, startPoint, [x, y], 'Manhattan');

		if(result.length)
				calculMove( result, startPoint, '#'+id, null, true );
}