$(function() {
		$('ul#accordion a.heading').click(function() {
				$(this).css('outline','none');
				if($(this).parent().hasClass('current')) {
						$(this).siblings('ul').slideUp('slow',function() {
								$(this).parent().removeClass('current');
						});
				} else {
						$('ul#accordion li.current ul').slideUp('slow',function() {
								$(this).parent().removeClass('current');
						});
						$(this).siblings('ul').slideToggle('slow',function() {
								$(this).parent().toggleClass('current');
						});
				}
				return;
		});
		
		$('#reset').click(function(){
				reset_vign();
		});
		
		$('#generate').click(function(){
				generate_vign();
		});
});

function generate_vign()
{
		var url = url_script+'character/generate/?';
		
		$('#ym').children('img').each(function()
		{
				url += 'img[]='+$(this).attr('src')+'&';	
		});
		
		redirect( url );
}

function reset_vign()
{
		$('#body').attr('src', dir_script+'images/character/none.png');
		$('.sup_character').each(function()
		{
				$(this).attr('src', dir_script+'images/character/default.png');	
		});
}

function set_hair(front, back,top) 
{
		change_vignette( 'hair_f', 'front', 'hair', front);
		change_vignette( 'hair_b', 'back', 'hair', back);
		change_vignette( 'hair_t', 'top', 'hair', top);
}

function set_body(front) 
{
		change_vignette( 'body', 'front', 'body', front);
}


function set_mante(front, back) 
{
		change_vignette( 'mante_f', 'front', 'mante', front);
		change_vignette( 'mante_b', 'back', 'mante', back);
}

function set_hairop(front, back) 
{
		change_vignette( 'hairop_f', 'front', 'hairop', front);
		change_vignette( 'hairop_b', 'back', 'hairop', back);
}

function set_acce1(front, back, top) 
{
		change_vignette( 'acce1_f', 'front', 'acce1', front);
		change_vignette( 'acce1_t', 'back', 'acce1', back);
		change_vignette( 'acce1_b', 'top', 'acce1', top);
}

function set_acce2(front,back) 
{
		change_vignette( 'acce2_f', 'front', 'acce2', front);
		change_vignette( 'acce2_b', 'back', 'acce2', back);
}

function set_option(front, back) 
{
		change_vignette( 'option_f', 'front', 'option', front);
		change_vignette( 'option_b', 'back', 'option', back);
}

function change_vignette( id, type, dir, file)
{
		if( file == 'none.png')
				$('#'+id).attr('src', dir_script+'images/character/default.png');
		else
				$('#'+id).attr('src', dir_script+'images/character/'+dir+'/'+type+'/'+ file);
}