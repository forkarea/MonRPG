var enCours = false,
time_move = false,
tailleMaxMapX = false,
tailleMaxMapY = false,
touchdown = false,
deplacementTime = 300,
userX = false,
userY = false,
MySocket = false,
tableMap = false,
divMap = false,
widthMap = false,
heightMap = false,
widthContener = false,
heightContener = false,
audioElement = document.getElementById('audio'),
audioElementSystem = document.getElementById('audio_other'),
history_sound_no = localStorage.getItem('sound');

$(function() {
		initMap();
		init_socket();
	
		$(window).keydown(function(e) {
				if(e.keyCode == 13 && !focusChat && $('#commandAction').is(":hidden") )
				{
						module();
						action();
				}
						
				startMoveAuto(e.keyCode);
		}).keyup(function(e) {
				stopAutoMove(e.keyCode);
		});
});

function initMap()
{
		enCours = true;
		
		tableMap = $('#tableMap');
		divMap = $('#map');
		widthMap = tableMap.width();
		heightMap = tableMap.height();
		widthContener = divMap.width();
		heightContener = divMap.height();						
		tailleMaxMapX = Math.floor( parseInt(widthMap) / size_case );
		tailleMaxMapY = Math.floor( parseInt(heightMap) / size_case );		
		
		audio(music);
		
		if(maxBot != 0 && !$('.bots').length)
		{
				$.getJSON(url_script+'bot/list_map',
						function(data) {
								if(data)
								{
										$.each(data, function(i,item){
												tableMap.append('<div id="bot-'+item.id+'" class="bots dispo invis"></div>');
			
												$('#bot-'+item.id).css( {
														'background-image' : 'url("'+dir_script+'images/character/'+item.image+'")', 
														'top' : (item.y * size_character_y), 
														'left' : (item.x * size_character_x)
												} ).show();
										});
								}
						});
		}
		
		positionUser();
		moveBots();
		module();
		action();

		$('.elements').tipsy({
				gravity : 's',
				delayIn : 0
		});
				
		$('#myUser').tipsy({
				gravity: 's', 
				trigger: 'manual'
		});
				
		enCours = false;
}
	
function calculMove( result, startPoint, id, myPerso, other_user )
{
		var Px = startPoint[0],
		Py = startPoint[1],
		direction = new Array();
		
		for( var x, y, i = 0, j = result.length; i < j; i++ ) 
		{
				x = result[i][0];
				y = result[i][1];
					
				if( x > Px && y == Py) direction.push('e');
				else if( x < Px && y == Py) direction.push('o');
				else if( x == Px && y < Py) direction.push('n');
				else if( x == Px && y > Py) direction.push('s');
			
				Px = x;
				Py = y;
		}
				
		if( direction.length )
		{
				clearTimeout(window[id]);
						
				$('.tipsy').remove();
								
				move( direction, id, myPerso, other_user );
		}
}
	
function move( direction, id, myPerso, other_user )
{
		var type = direction[0],
		plusX = '-', 
		moinsX = '+', 
		plusY = '-', 
		moinsY = '+',
		id_deplacement = id;
		
		delete direction[0];
		
		if( myPerso )
		{
				plusX = '+';
				moinsX = '-'; 
				plusY = '+';
				moinsY = '-';
				id_deplacement = '#tableMap';

				var  topMap = position('#tableMap', 'top'),
				leftMap = position('#tableMap', 'left');

				if( topMap == 0 && type == 'n' )
						plusY = '-';
				
				else if( topMap == 0 && type == 's' && position(id, 'top') < Math.round( ( heightContener - 32 ) / 2 ) )
						moinsY = '+';
				
				else if( leftMap == 0 && type == 'o' )
						plusX = '-';
				
				else if( leftMap == 0 && type == 'e' && position(id, 'left') < Math.round( ( widthContener - 32 ) / 2 ) )
						moinsX = '+';
				
				else if( ( widthMap - widthContener + leftMap ) == 0 && type == 'e')
						moinsX = '+';
				
				else if( ( widthMap - widthContener + leftMap ) <= 0 && type == 'o' && position(id, 'left') > Math.round( ( widthContener - 32 ) / 2 ) )
						plusX = '-';
				
				else if( ( heightMap - heightContener + topMap ) == 0 && type == 's')
						moinsY = '+';
				
				else if( ( heightMap - heightContener + topMap ) == 0 && type == 'n' && position(id, 'top') > Math.round( ( heightContener - 32 ) / 2 ) )
						plusY = '-';
			
				if( plusX != '+' || moinsX != '-' || plusY != '+' || moinsY != '-' )
						id_deplacement = id;
		}
		
		direction = regenArray( direction );
		
		switch( type )
		{
				case 'n' :
						valeur = {
								'top': plusY+'='+size_case+'px'
						};								
						break;
				case 'e' :
						valeur = {
								'left': moinsX+'='+size_case+'px'
						};								
						break;
				case 's' :
						valeur = {
								'top': moinsY+'='+size_case+'px'
						};								
						break;
				case 'o' :
						valeur = {
								'left': plusX+'='+size_case+'px'
						};								
						break;
		}
				
		personnage( id, type, parseInt( '-'+size_character_x), parseInt( '-'+size_character_y) );
				
		$(id_deplacement).animate(
				valeur
				, {
						duration: deplacementTime,
						easing : 'linear',
						complete : function() {
										
								clearTimeout(window[id]);

								if(!touchdown || !myPerso)	
										$(id).css('background-position-x','-'+size_character_x+'px');

								if( direction.length > 0 )
										move( direction, id, myPerso, other_user );
								else
								{
										if( myPerso )
										{	
												positionUser();

												if(!touchdown)
														module();
												else
														enCours = false;
										}
										else
												$(id).addClass('dispo');

										if( ( !touchdown || !myPerso ) && other_user == null)	
												action();
								}
						}
				});
}
	
function personnage( id, direction, largeur, hauteur, position )
{
		var obj = $(id),
		psb;
		
		if(!position) position = 0;
			
		switch(direction) 
		{
				case 'o':
						if(position == 1) psb = cssMove( largeur, hauteur );
						else if(position == 2) psb = cssMove( (largeur*2), hauteur );
						else if(position == 3) psb = cssMove( largeur, hauteur );
						else psb = cssMove( 0, hauteur );
						break;
			
				case 'n':
						if(position == 1) psb = cssMove( largeur, (hauteur*3) );
						else if(position == 2) psb = cssMove( (largeur*2), (hauteur*3) );
						else if(position == 3) psb = cssMove( largeur, (hauteur*3) );
						else psb = cssMove( 0, (hauteur*3) );
						break;
			
				case 's':
						if(position == 1) psb = cssMove( (largeur*2), 0);
						else if(position == 2) psb = cssMove( 0, 0);
						else if(position == 3) psb = cssMove( (largeur*2), 0);
						else psb = cssMove( largeur, 0);
						break;
			
				case 'e':
						if(position == 1) psb = cssMove( largeur, (hauteur*2) );
						else if(position == 2) psb = cssMove( (largeur*2), (hauteur*2) );
						else if(position == 3) psb = cssMove( largeur, (hauteur*2) );
						else psb = cssMove( 0, (hauteur*2) );
						break;
		}
		
		obj.css('background-position',psb);
		
		position++;
			
		window[id] = setTimeout( function() {
				personnage(id, direction, largeur, hauteur, position)
		}, Math.round(deplacementTime/4) );
}
	
function cssMove( x, y )
{
		return x+'px '+y+'px';
}
	
function moveBots()
{
		if(maxBot == 0 || !$('.bots').length) return;
								
		$('.bots').each(function()
		{
				var obj = $(this),
				startX = Math.floor(parseInt(obj.css('left'))/size_character_x),
				startY = Math.floor(parseInt(obj.css('top'))/size_character_y);
				
				if(obj.is('.dispo') && aleatoire(5) == 0 && startX+'-'+startY != userX+'-'+userY )
				{			
						var startPoint = [startX, startY],
						getBotPosition = getPosition(),
						endX = getBotPosition.x,
						endY = getBotPosition.y;
				
						if( ( startX != endX || startY != endY ) && obstacle[endY][endX] == 0 )
						{
								var result = AStar(obstacle, startPoint, [endX, endY], 'Manhattan');
					
								if(result.length)
								{					
										obj.removeClass('dispo');
	
										calculMove(result, startPoint, '#'+this.id);
										
										send_bot_socket( 'move-bot', startX, startY, endX, endY, this.id);
						
										$.post(url_script+'bot/move_map', {
												x: endX, 
												y: endY, 
												id: this.id
										} );
						
										return;
								}
						}
				}
		});
		
		setTimeout( function() {
				moveBots()
		}, 5000 );
}
	
function getPosition()
{
		var endX = aleatoire(tailleMaxMapX - 1),
		endY = aleatoire(tailleMaxMapY - 1);
			
		if( testPosBot( endX+'-'+endY ) )
				return getPosition();
		
		return {
				x : endX, 
				y : endY
		};
}
	
function action( )
{
		if(enCours || !$('.bots').length || !$('#commandAction').is(':hidden')) 
				return;
		
		var verifBot = testPosBot( userX+'-'+userY );
		
		if( verifBot )
		{
				$.get(url_script+'bot/action/'+verifBot, function(data) {
						if( data )
								openAction( data );
				});
		}
		else
				closeAction();	
}
	
function startMoveAuto( direction )	
{
		if (focusChat || $('#content_pwd').is(':visible'))
				return;
				
		if(direction != 90 
				&& direction != 81 
				&& direction != 68 
				&& direction != 83 
				&& direction != 37 
				&& direction != 38 
				&& direction != 39 
				&& direction != 40)
				return;
		
		closeAction();
			
		clearTimeout(window[37]);
		clearTimeout(window[38]);
		clearTimeout(window[39]);
		clearTimeout(window[40]);
		clearTimeout(window[90]);
		clearTimeout(window[81]);
		clearTimeout(window[68]);
		clearTimeout(window[83]);
			
		if( !enCours )
		{
				clearTimeout(time_move);
				
				var endX = userX,
				endY = userY,
				moveDirection = new Array();
						
				if(direction == 90 || direction == 38 ) 
				{
						moveDirection.push('n');
						endY--;
				}
				else if(direction == 81 || direction == 37) 
				{
						moveDirection.push('o');
						endX--;
				}
				else if(direction == 68 || direction == 39)
				{
						moveDirection.push('e');
						endX++;
				}
				else if(direction == 83 || direction == 40) 
				{
						moveDirection.push('s');
						endY++;
				}
				else return;
					
				if( endY >= 0 && endX >= 0 && endY < tailleMaxMapY && endX < tailleMaxMapX)
				{
						touchdown = true;
					
						if( obstacle[endY][endX] != 1 )
						{
								enCours = true;
								
								if(MySocket != false)
										send_info_socket( 'move',  endX, endY);
										
								$('.tipsy').remove();
								move( moveDirection, '#myUser', true );
						}
				}
				else
						$('#myUser').css('background-position-x','-'+size_character_x+'px');
		}
			
		window[direction] = setTimeout( function() {
				startMoveAuto( direction )
		}, 40 );
}
	
function stopAutoMove( direction )	
{
		if(direction == 90 
				|| direction == 81 
				|| direction == 68 
				|| direction == 83 
				|| direction == 37 
				|| direction == 38 
				|| direction == 39 
				|| direction == 40)
				{
				touchdown = false;
				
				clearTimeout(window[direction]);
			
				if( !enCours && !focusChat )
				{
						action(); 
						module();
				}
		}
}
	
function positionUser()	
{
		userY = Math.floor( ( position('#myUser', 'top') - position('#tableMap', 'top') ) / size_character_y );
		userX = Math.floor( ( position('#myUser', 'left') - position('#tableMap', 'left') ) / size_character_x );
				
		$('#coordonne_x_y').html(userX+' - '+userY);
}
	
function testPosBot( position )	
{
		var bot = false;
		$('.bots').each(function()
		{
				if( Math.floor(parseInt($(this).css('left'))/size_character_x)+'-'+Math.floor(parseInt($(this).css('top'))/size_character_y) == position )
						bot = this.id;	
		});
		
		return bot;
}
	
function module()	
{	
		if($('#action-'+userX+'-'+userY).length)
		{
				var module = $('#action-'+userX+'-'+userY).attr('data-rel');

				enCours = true;
						
				$.post(url_script+'actions/'+module, {
						'x': userX, 
						'y': userY
				}, function(data) {
						if( data )
						{
								if(module == 'move' && ( data == 'change-no' || data == 'change-porte' || data == 'change-teleporte'))
								{
										if( data == 'change-porte' )
												audio('porte.ogg', true);
										else if( data == 'change-teleporte' )
												audio('teleportation.ogg', true);
												
										$('#myUser').hide();
										$('#map').empty().load(url_script+'map/word', function () {
												log('initialisation map');
												initMap();
												recup_info_socket(data);
										});
										
										return;
								}
								
								openAction( data );
						}
						else
								closeAction();

						enCours = false;
				});
		}
		else
		{
				time_move = setTimeout( function() {
						$.post(url_script+'user/move', {
								x :userX, 
								y:userY
						});
				}, 400 );
		
				enCours = false;
		}
}

function audio(data, id) 
{
		if(id == null)
		{			
				if(data)
				{
						audioElement.src = dir_script+'audio/'+data;
						audioElement.volume = volume_sound;
								
						control_audio( true );
		
						audioElement.play(); 
		
						$('#control_sound').show();
				}
				else
						audioElement.pause(); 
		}
		else
		{
				audioElementSystem.src = dir_script+'audio/system/'+data;
				audioElementSystem.volume = volume_sound;	
				audioElementSystem.play(); 
		}
}

function control_audio( no_save ) 
{	
		try {		
				if (history_sound_no == ( no_save != null ? 0 : 1)) 
				{
						history_sound_no = 0;
						
						audioElement.volume = volume_sound;
						audioElement.play();
				
						$('#control_sound').attr('src', dir_script+'images/orther/sound.png');
				}
				else 
				{
						history_sound_no = 1;
						
						audioElement.volume = 0;
						audioElement.pause();
				
						$('#control_sound').attr('src', dir_script+'images/orther/mute.png');
				}
				
				if( no_save == null)
						localStorage.setItem('sound', history_sound_no);
				
		} catch( ex ) {
				log('Impossible save the sound: '+ex.toString());
		}
}
