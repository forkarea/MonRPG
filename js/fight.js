var n = 0,
encoursFigth = false,
id_sort = false,
id = false;

function initFight(obj)
{
		var info = obj.id.split('-');

		if(!encoursFigth && info[2] <= mpUser() ) 
		{
				encoursFigth = true;
		
				id = '#effectBot';
				$('.vignetteBot').css('background-position','-96px -96px');
				$('.vignetteUser').css('background-position','-96px 0');

				fight_animation( info[1] );
		
				$.getJSON(url_script+'fight/calcul/'+id_bot, {
						id_sort: info[0]
				}, function(data) {
						traitementFight(data, 'fightRed');
				});
		}
}

function autoBotAttack()
{
		var vitesse = 10;
	
		if(!encoursFigth)
		{
				encoursFigth = true;
				
				$('.buttonActiobSort').tipsy({
						gravity : 'n',
						delayIn : 0
				});
		
				vitesse = ( aleatoire(5) + 1 ) * 1000,
				divs = $('.buttonActiobSort').get().sort(function(){ 
						return Math.round(Math.random())-0.5;
				}).slice(0,4);
				id = '#effectUser';
				
				var sorts_select_bot = select_sort();
				
				if( sorts_select_bot )
				{
						fight_animation( sorts_select_bot.effect );
				
						$('.vignetteUser').css('background-position','-96px -96px');
						$('.vignetteBot').css('background-position','-96px 0');
		
						$.getJSON(url_script+'fight/calcul/'+id_bot+'/auto', {
								id_sort: sorts_select_bot.id
						}, function(data) {
								traitementFight(data, 'fightYellow');
						});
				}
				else
						encoursFigth = false;
		}
	
		setTimeout( "autoBotAttack()" , vitesse );
}

function fight_animation( image )
{	
		var nbr = image.split('_');
		nbr = nbr[1];

		if(n == 0)	
				$(id).css({
						'background-image' : 'url("'+dir_script+'images/sorts_animate/'+image+'.png")'
				});
		else
		{
				var verifActif = false,
				col = 1,
				row = 0;
		
				for( var i = 1; i < nbr; i++)
				{
						if(n == i)
						{				
								$(id).css('background-position', '-'+(col * 64)+'px -'+(row * 64)+'px');
								verifActif = true;
								break;
						}
				
						if( col == 4 )
						{
								row++;
								col = 0;
						}
						else
								col++;
				}
		
				if(!verifActif)
						$(id).css({
								'background-image' : 'none', 
								'background-position' : '0px 0px'
						});
		}
			
		if( n >= nbr)
		{
				n = 0;
				clearTimeout(window['time_'+image]);
				$('.vignette').css('background-position','0px 0px');
		}
		else
		{
				n++;
				window['time_'+image] = setTimeout( "fight_animation('"+image+"')" , 100 );
		}
}


function traitementFight(data, color)
{
		if(data.mpUser != null && data.mpUser > 0)
		{
				set_barre( '#infoUserMP', data.mpUser );
				set_barre( '#user_mp', data.mpUser );
		}
		
		if(data.hpUser != null && data.hpUser > 0)
		{
				set_barre( '#infoUserHP', data.hpUser );
				set_barre( '#user_hp', data.hpUser );
		}
		else if(data.hpUser != null && data.hpUser <= 0)
				loadAction( 'fight/end/'+id_bot );
		
		if(data.mpBot != null && data.mpBot > 0)
				set_barre( '#infoBotMP', data.mpBot );
		
		if(data.hpBot != null && data.hpBot > 0)
				set_barre( '#infoBotHP', data.hpBot );
		else if(data.hpBot != null && data.hpBot <= 0)
				loadAction( 'fight/end/'+id_bot );
		
		var now = new Date().getTime(),
		id = 'score_'+now;
	
		$('#contenerActionGlobal').append('<div id="'+id+'" class="scoreFight '+color+'">'+data.score+'</div>');
	
		$('#'+id).animate({ 
				opacity: 0,
				fontSize: '36px', 
				top: '-=150'
		}, 1000, function() {
				$(this).remove();
				encoursFigth = false;
		} );
	
		$('.buttonActiobSort').each(function() {
				var info = this.id.split('-');
		
				if(data.mpUser < info[2])
						$(this).html('<img src="'+dir_script+'images/sorts/no.png" width="30" height="30" />');
		});

}

function mpUser()
{
		return mp('#infoUserMP');
}

function mpBot()
{
		return mp('#infoBotMP');
}

function mp( id )
{
		return parseInt($(id).find('.valueMoyenneGraph').html());
}

function select_sort()
{
		var liste_sort = sort_bot;
		
		liste_sort.sort(function() {
				return 0.5 - Math.random()
		});
		
		var max_mp = mpBot();

		for(x in liste_sort)
		{
				row = liste_sort[x];
				
				if( max_mp >= row.mp)
						return row;
		}
		
		return false;
}