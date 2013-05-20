var block = {},
pageX = false,
pageY = false,
pos_x_start = false,
pos_y_start = false,
pos_timer = false;

$(function() {
		
		$('#contentMenu').live('mousedown', function() {
				selection_mouse_start();
		}).live('mouseup', function() {
				selection_mouse_stop();
		});
	
		$(document).bind('mousemove',function(e){ 
				pageX = e.pageX;
				pageY = e.pageY; 
		});
	
		$('.listeBlock').each(function() {
				ElementMulti(this) ;
		});
	
		$('.bullMulti').live('mouseover', function() {
				$('#'+this.id.replace('bloc-','')).addClass('hover_bloc');
		})
		.live('mouseout', function() {
				$('#'+this.id.replace('bloc-','')).removeClass('hover_bloc');
		});
	
		$('.listeBlock').live('mouseover', function() {
				$('#bloc-'+this.id).css('background-color', '#900');
		})
		.live('mouseout', function() {
				$('#bloc-'+this.id).css('background-color', '#A4C58F');
		});
									
		$('#annul_block').click(function() {
				$('#block_action').hide();
				$('.selectionne').remove();
		});
	
		$('#save_block').click(function() {
				save_select();
		});
	
		$('.delete-tileset').live('click', function() {
				delete_select( this );
		});
	
		$('#listTilesets').change(function() {
				$('.content-site-center').html('');
				redirect(url_script+'tilesets/show/'+$(this).val())
		});
		
		$('#change').click(function(){
				$.facebox({
						ajax: url_script+'editeur/vignette/'+$('#tilesets').val()
				});
		});
		
		$('.vign_mod').live('click', function() {
				redirect(url_script+'tilesets/show/'+this.id);
		});
	
		jeditable();

});

function selection_mouse_start()
{
		start_loading();
		$('body').css({
				'-webkit-user-select':'none', 
				'-moz-user-select':'none'
		});
		$('#block_action').hide();
	
		$('#msg').show().html(loading_traitement);
	
		$('.selectionne').remove();
	
		if(pos_x_start === false)				
				pos_x_start = pageX;
		
		if(pos_y_start === false)				
				pos_y_start = pageY;
	
		clearInterval(pos_timer);
	
		if(!$('#blockSelector').length)
				$('#main').prepend('<div class="blockSelector" id="blockSelector" style="top:'+pageY+'px; left:'+pageX+'px">&nbsp;</div>');
	
		pos_timer = setInterval ("effectSelect()", 0);
}

function selection_mouse_stop()
{
		start_loading();
	
		$('#blockSelector').remove();
		
		if( pos_x_start && pos_y_start && !( pos_x_start == pageX && pos_y_start == pageY ))
		{
				var x_max,
				y_max,
				x_min,
				y_min,
				posMap = $('#contentMenu').position();		
				
				if( pos_x_start > pageX )
				{
						x_max = pos_x_start;
						x_min = pageX;
				}
				else
				{
						x_max = pageX;
						x_min = pos_x_start;
				}
		
				if( pos_y_start > pageY )
				{
						y_max = pos_y_start;
						y_min = pageY;
				}
				else
				{
						y_max = pageY;
						y_min = pos_y_start;
				}
				
				$('.elements').each(function() {

						var posCellule = $(this).position(),
						top = parseInt(posMap.top)+parseInt(posCellule.top),
						left = parseInt(posMap.left)+parseInt(posCellule.left),
						bottom = top + position(this, 'height'),
						right = left + position(this, 'width');
			
						if( ( bottom > y_min && right > x_min && bottom < y_max && right < x_max )
								|| ( top < y_max && right > x_min && top > y_min && right < x_max ) 
								|| ( bottom > y_min && left < x_max && bottom < y_max && left > x_min ) 
								|| ( top < y_max && right < x_max && top > y_min && right > x_min ) 
								|| ( top < y_max && top > y_min && left < x_max && left > x_min && bottom > y_max && bottom > y_min && right > x_max && right > x_min ) 
								|| ( top < y_max && top < y_min &&  bottom > y_max && bottom > y_min && ( ( right > x_min && right < x_max ) || ( left > x_min && left < x_max ) ) ) 
								|| ( left < x_max && left < x_min &&  right > x_max && right > x_min && ( ( top > y_min && top < y_max ) || ( bottom > y_min && bottom < y_max ) ) ) 
								)
								{
								if(!$('.selectionne:first', this).length)
								{
										$(this).prepend('<div id="select_'+this.id+'" class="selectionne"></div>');
								}
				
								if( top < y_max && top > y_min && left < x_max && left > x_min && bottom > y_max && bottom > y_min && right > x_max && right > x_min )
										return;
						}
				});
				$('#block_action').show();
		}

		clearInterval(pos_timer);	
		pos_timer = false;
		pos_x_start = false;
		pos_y_start = false;
		$('#msg').fadeOut(500);
		$('body').css({
				'-webkit-user-select':'auto', 
				'-moz-user-select':'auto'
		});
	
		stop_loading();
}

function effectSelect()
{
		var obj = $('#blockSelector');
	
		if( pos_y_start < pageY && pos_x_start < pageX )
				obj.css({
						'width' : ( pageX - pos_x_start - 2 )+'px', 
						'height' : ( pageY - pos_y_start - 2 )+'px'
				});

		else if( pos_y_start > pageY && pos_x_start < pageX )
				obj.css({
						'width' : ( pageX - pos_x_start )+'px', 
						'height' : ( pos_y_start - pageY - 2 )+'px', 
						'top' :( pageY + 2 )+'px'
				});

		else if( pos_y_start < pageY && pos_x_start > pageX )
				obj.css({
						'width' : ( pos_x_start - pageX - 2 )+'px', 
						'height' : ( pageY - pos_y_start )+'px', 
						'left' : ( pageX + 2 )+'px'
				});

		else if( pos_y_start > pageY && pos_x_start > pageX )
				obj.css({
						'width' : ( pos_x_start - pageX - 2 )+'px', 
						'height' : ( pos_y_start - pageY - 2 )+'px', 
						'top' : ( pageY + 2 )+'px', 
						'left' : ( pageX + 2 )+'px'
				});
}

function ElementMulti(target) 
{
		var id = target.id.split('-'),
		xMin = parseInt(id[0]),
		yMin = parseInt(id[1]),
		xMax = parseInt(id[2]),
		yMax = parseInt(id[3]),
		position = $('#'+xMin+'_'+yMin).position();

		display = '<div class="bullMulti" style="height:'+((yMax-yMin)*33)+'px; width:'+((xMax-xMin)*33)+'px; top:'+( parseInt(position.top)-2 )+'px; left:'+( parseInt(position.left)-2 )+'px;" id="bloc-'+target.id+'"></div>';
		
		$('#contentMenu').prepend(display);
}

function save_select() 
{
		var first = $('.selectionne:first').attr('id').split('_'),
		last = $('.selectionne:last').attr('id').split('_'),
		title = $('#title_block').val(),
		valeur = {
				x_min : first[1], 
				y_min : first[2], 
				x_max : last[1], 
				y_max : last[2], 
				image : $('#image').val(), 
				title : title
		},
		id = valeur.x_min+'-'+valeur.y_min+'-'+(parseInt(valeur.x_max)+1)+'-'+(parseInt(valeur.y_max)+1);
	
		if( !title || title == '' )
				title = 'Aucun titre';
	
		$.post(url_script+'tilesets/insert',valeur);
	
		$.ajax({
				type: 'POST',
				url: url_script+'tilesets/insert',
				data: valeur,
				success: function(msg){
			
						html = '<div class="listeBlock" id="'+id+'"><span id="'+msg+'" class="jedit">'+valeur.title+'</span>';
						html += '<div class="deleteTileset"><a href="javascript:;" class="delete-tileset" id="delete_'+id+'">'+lang_delete+'</a></div>';
						html += '</div>';
							
						$('#contentDetail').append(html);
			
						$('#block_action').hide(); 
			
						$('.selectionne, .bullMulti').remove();
				
						$('.listeBlock').each(function() {
								ElementMulti(this) ;
						});
			
						jeditable();
				}
		});
}

function delete_select( obj ) 
{
		var id = obj.id.replace('delete_',''),
		valeur = id.split('-');
	
		$.post(url_script+'tilesets/delete',{
				x_min : valeur[0], 
				y_min : valeur[1], 
				x_max : parseInt(valeur[2])-1, 
				y_max : parseInt(valeur[3])-1, 
				image : $('#image').val()
		});
	
		$('#bloc-'+id+', #'+id).remove();
}

function jeditable()
{
		$('.jedit').editable(url_script+'tilesets/update', {
				indicator : laoding_edit,        
				cancel    : annul_edit,
				submit    : sauv_edit
		});
}