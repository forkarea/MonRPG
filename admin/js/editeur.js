var isCtrl = false,
isShit = false,
pageX = false,
pageY = false,
pos_x_start = false,
pos_y_start = false,
pos_timer = false;

$(function(){
		var main_map = $('#main').height() - $('#toolMap').height(), height_menu = $('#sidebar').height();
		
		if( main_map < height_menu )
			main_map = height_menu;	
				
		$('.map').height(main_map);
		$('#menu').height(main_map);
		$('.map').width($('#td_map').width());
		
		$(window).resize(function() {
				$('.map').width(500).width($('#td_map').width());
		});

		$('#map').load(url_script+'editeur/word', function() { 

				menu();
		
				init_command(); 
	
				modif_choix_selector(0);
		
				slider_niveau_opacite();
		
				niveau(); 
		
		}).contextMenu('myMenu1', {
				onContextMenu: function(e) {
						$('.numberNiveau').hide();
						selection_mouse_stop();
			
						if($('.selectionne').length)
								$('.titleContextuelNiveau, #choixNiveau, #niveauSup, #niveauInf, #noSelect, #deleteSelect, #addObstacle, #deleteObstacle, #addBot, #deleteBot').show();
						else
								$('.titleContextuelNiveau, #choixNiveau, #niveauSup, #niveauInf, #noSelect, #deleteSelect, #addObstacle, #deleteObstacle, #addBot, #deleteBot').hide();
						return true;
				},
				bindings: {
						'masqueGrille': function(t) {
								aff_grille( '#button_select_5' );
						},
						'noSelect': function(t) {
								choix_option_selection( '#button_select_4' );
						},
						'deleteSelect': function(t) {
								choix_option_selection( '#button_select_3' );
						},
						'niveauSup': function(t) {
								multi_change_niveau_sup();
						},
						'niveauInf': function(t) {
								multi_change_niveau_inf();
						},
						'moveMap': function(t) {
								modif_choix_selector( 0 );
						},
						'clickSelect': function(t) {
								modif_choix_selector( 1 );
						},
						'cursoSelect': function(t) {
								modif_choix_selector( 2 );
						},
						'addObstacle': function(t) {
								manager_obstacle( 'add' );
						},
						'deleteObstacle': function(t) {
								manager_obstacle( 'delete	' );
						},
						'addBot': function(t) {
								manager_bot( 'add' );
						},
						'deleteBot': function(t) {
								manager_bot( 'delete	' );
						}	
				}
		});
});

function init_command()
{
		$('#choixNiveau').click(function() {
				$('.numberNiveau').toggle();
		});
	
		$('#change').click(function(){
				$.facebox({
						ajax: url_script+'editeur/vignette/'+$('#tilesets').val()
				});
		});
	
		$('.elementDrop').live('click', function() {
				if( $('#multiselection').val() == 0 ) editElement( this );
		});
	
		$('.elements').live('click', function() {
				if( $('#multiselection').val() > 0 ) validate_multi_selection( this );
		});

		$('.mapTD').live('click', function() {
				if( $('#multiselection').val() == 1 ) multi_selection( this );
		});
			
		$('#supprimer').live('click', function() {
				deleteCase();
		});
	
		$('#enregistrer').live('click', function() {
				enregistrerCase();
		});
	
		$('.ContenerMenu').live('hover', function() {
				if( $('#ContenerAction').is(':visible')) $('#ContenerAction').fadeOut();
		});

		$('.no_element').live('click', function() {
				$('#ContenerAction').fadeOut();
		});
	
		$('.contenerBg').live('click', function() {
				$('.mapTD').css('background-image', $(this).css('background-image'));
				cache();
		});

		$('.multiDrag').live('click', function() {
				ElementMulti(this);
		});

		$('.closeMulti').live('click', function() {
				closeMulti(this);
		});

		$('#module').live('change', function() {
				action_form();
		});
		
		$('#tableMap').live('mousedown', function() {
				selection_mouse_start();
		}).live('mouseup', function() {
				selection_mouse_stop();
		});

		$('#map_position').change(function(){
				$(this).blur();
				niveau();
		});

		$('#multiselection').change(function() {
				choix_selection( this );
		});
	
		$('#button_select_0, #button_select_1, #button_select_2').click(function() {
				modif_choix_selector( $(this).val() );
		});

		$('#button_select_3, #button_select_4').click(function() {
				choix_option_selection( this );
		});
	
		$('#contener_selector_bg').show().jcarousel({
				vwrap: 'both', 
				scroll : 8
		});

		$('#button_select_5').click(function() {
				aff_grille( this );
		});

		$('#button_select_6').click(function() {
				aff_obstacle( this, 'obstacle' );
		});

		$('#button_select_7').click(function() {
				aff_obstacle( this, 'module' );
		});

		$('#button_select_9').click(function() {
				aff_obstacle( this, 'bot' );
		});

		$('#button_select_8').click(function() {
				help();
		});

		$('.numberNiveau').click(function() {
				$('#jqContextMenu').hide();
				multi_change_niveau( this.id.replace('niveau_','') );
		});
	
		$('#changeMap').change(function() {
				redirect( url_script+'editeur/show/'+$(this).val() );
		});
		
		$('.vign_mod').live('click', function() {
				$('#tilesets').val(this.id);
				menu();
		});
	
		$('.optionTilesets input, .optionTilesets select, .slider-handle, .contenerBg, .input-select-editor, #slider-legend').tipsy();
	
		$(document).keyup(function (e) {

				if(e.which == 17) 
						isCtrl = false;
				if(e.which == 16) 
						isShit = false;
			
		}).keydown(function (e) {

				if(e.which == 17) 
						isCtrl=true;
			
				if(e.which == 16) 
						isShit=true;
			
				if(e.which == 27 && isCtrl == false)
				{
						var selectionne = $('.selectionne');
	
						if( selectionne.length )
								selectionne.remove();
						else
								modif_choix_selector( 0 );
				}
				else if(e.which == 38 && isCtrl == true)
						niveau_plus();

				else if(e.which == 40 && isCtrl == true)
						niveau_moins();

				else if(e.which == 65 && isCtrl == true) 
						modif_choix_selector( 1 );
			
				else if(e.which == 68 && isCtrl == true)  
						modif_choix_selector( 0 );
			
				else if(e.which == 67 && isCtrl == true) 
						modif_choix_selector( 2 );
			
				else if(e.which == 83 && isCtrl == true) 
						choix_option_selection( '#button_select_3' );
			
				else if(e.which == 71 && isCtrl == true) 
						aff_grille( '#button_select_5' );
			
				else if(e.which == 79 && isCtrl == true) 
						aff_obstacle( '#button_select_6', 'obstacle' );
			
				else if(e.which == 77 && isCtrl == true) 
						aff_obstacle( '#button_select_7', 'module' );
			
				else if(e.which == 66 && isCtrl == true) 
						aff_obstacle( '#button_select_9', 'bot' );

		}).bind('mousemove',function(e){ 
				pageX = e.pageX;
				pageY = e.pageY; 
		});
		
		$('#tableMap').draggable({
				stop: function(event, ui) {
						cache();
				}
		});
}

function modif_choix_selector( type ) 
{
		$('#multiselection').val(type);
		choix_selection('#multiselection');
}

function choix_selection( obj )
{
		var valeur = $(obj).val();
	
		initialise_button( valeur ) ;
	
		if( valeur == 0 ) 
		{
				$('#tableMap').draggable('enable');
				$('.selectionne').remove();
				$('#no_select_all').hide();
				$('#noSelect').hide();
				$('#deleteSelect').hide();
				$('#moveMap').hide();
				$('#tableMap').css('cursor', 'default');
		}
		else if( valeur == 1 ) 
		{
				$('#tableMap').draggable('enable');
				$('#no_select_all').show();
				$('#noSelect').show();
				$('#deleteSelect').show();
				$('#moveMap').show();
				$('#tableMap').css('cursor', 'crosshair');
		}
		else if( valeur == 2 ) 
		{
				$('#tableMap').draggable('disable');
				$('#no_select_all').show();
				$('#noSelect').show();
				$('#deleteSelect').show();
				$('#moveMap').show();
				$('#tableMap').css('cursor', 'crosshair');
		}
}

function initialise_button( type ) 
{
		delete_aff_obstacle ();
		$('.button-image').removeClass('button-image-actif');
		$('#button_select_'+type).addClass('button-image-actif');
}

function choix_option_selection( obj )
{
		var valeur = $(obj).val(),
		selectionne = $('.selectionne');
	
		if( selectionne.length )
		{
				if( valeur == 1 && confirm(confirm_delete))
						delete_multi_selection();
	
				else if( valeur == 2 ) 
						selectionne.remove();
		}
}

function menu()
{
		$('#menu').load(url_script+'editeur/menu', {
				image : $('#tilesets').val()
		} );
}

function editElement( btn )
{
		$.facebox({
				ajax: url_script+'editeur/form?coordonne='+btn.id
		});
}

function cache( type, obj )
{
		var style = $('#tableMap').attr('style'),
		map_pos = $('#map_position').val(),
		id = $(obj).attr('id'),
		image = encode($('.mapTD:first').css('background-image')),
		valeur = {
				style : style, 
				position : map_pos, 
				image : image
		};

		if( type == 'ajout')
				valeur = {
						style : style, 
						position : map_pos, 
						image : image, 
						coordonne : id, 
						background : encode($(obj).css('background-image')), 
						positionBackground : encode($(obj).css('background-position'))
				};
				  
		else if( type == 'delete')
				valeur = {
						delete_element : true, 
						style : style, 
						image : image, 
						position : map_pos, 
						coordonne : id
				};
	
		$.post(url_script+'editeur/cache', valeur );
}

function enregistrerCase()
{
		delete_aff_obstacle ();
	
		if(typeof(editor)!='undefined' && $('#fonction').length )	
				$('#fonction').val(editor.getCode());	
		
		else if(typeof(editor)!='undefined' && $('#html').length )	
				$('#html').val(editor.getCode());	

		$.post(url_script+'editeur/cache_case', $('#myFormOption').serialize() );
}

function deleteCase()
{
		delete_aff_obstacle ();	
		$.post(url_script+'editeur/cache_case', {
				coordonne : $('#coordonne').val(), 
				delete_element : true
		} );
}

function multi_selection( obj )
{
		var selection = $('.selectionne', obj);
	
		if(selection.length && $('#multiselection').val() != 2)
				selection.remove();
		else if(!selection.length)
		{	
				var droppable = $('.droppable', obj);
				$(obj).prepend('<div id="select_'+droppable.attr('id')+'" class="selectionne"></div>');
		}
}

function validate_multi_selection( obj )
{
		$('.selectionne').each(function() 
		{ 
				var map_pos = $('#map_position').val(),
				id = $(this).siblings('.droppable').attr('id').split('-');
		
				id = id[0]+'-'+id[1]+'-'+map_pos;
	
				if( !$(this).siblings('.droppable').is('.niveau_'+map_pos))
				{	
						var my_html = '<div ondrop="dropElement(this, event)" ondragenter="return false" ondragover="return false" class="droppable niveau_'+map_pos+'" id="'+id+'"></div>';
						$(this).parents('.mapTD').append(my_html);
				}
	
				$('#'+id).css({
						'background-position': $(obj).css('background-position'), 
						'background-image' : 'url("'+dir_script+'../images/tilesets/'+$('#tilesets').val()+'")'
				} ).addClass('elementDrop');	
		
				cache('ajout', '#'+id );
		
				$(this).remove();
		})
} 

function delete_multi_selection()
{
		$('.selectionne').each(function() 
		{ 
				var id = $(this).siblings('.droppable').attr('id').split('-');
				id = '#'+id[0]+'-'+id[1]+'-'+$('#map_position').val();
	
				$(id).css({
						'background-position': '', 
						'background-image' : ''
				});	
		
				cache('delete', id );
		
				$(this).remove();
		})
} 

function selection_mouse_start()
{
		if($('#multiselection').val() != 2 || $('#jqContextMenu').is(':visible') )
				return;
		
		$('#msg').show().html(loading_traitement);
	
		if(pos_x_start === false)				
				pos_x_start = pageX;
		
		if(pos_y_start === false)				
				pos_y_start = pageY;
	
		clearInterval(pos_timer);
	
		if(!$('#blockSelector').length)
				$('#map').prepend('<div class="blockSelector" id="blockSelector" style="top:'+pageY+'px; left:'+pageX+'px">&nbsp;</div>');
	
		pos_timer = setInterval ("effectSelect()", 0);
}

function selection_mouse_stop()
{
		start_loading();
		$('body').css({
				'-webkit-user-select':'none', 
				'-moz-user-select':'none'
		});
	
		$('#blockSelector').remove();
	
		if($('#multiselection').val() != 2)
				return;
		
		if( pos_x_start && pos_y_start && !( pos_x_start == pageX && pos_y_start == pageY ))
		{
				var x_max,
				y_max,
				x_min,
				y_min,
				posMap = $('#tableMap').position();		
				
				if( pos_x_start > pageX )
				{
						x_max = pos_x_start,
						x_min = pageX;
				}
				else
				{
						x_max = pageX,
						x_min = pos_x_start;
				}
		
				if( pos_y_start > pageY )
				{
						y_max = pos_y_start,
						y_min = pageY;
				}
				else
				{
						y_max = pageY,
						y_min = pos_y_start;
				}
		
				$('.mapTR').each(function() {

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
										var child = $('.droppable:first', this);
										child.parent().prepend('<div id="select_'+child.attr('id')+'" class="selectionne"></div>');
								}
				
								if( top < y_max && top > y_min && left < x_max && left > x_min && bottom > y_max && bottom > y_min && right > x_max && right > x_min )
										return;
						}
				});
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
		var obj = $('#blockSelector'),
		width = parseInt(obj.css('width').replace('px', '')),
		height = parseInt(obj.css('height').replace('px', ''));
	
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

function slider_niveau_opacite() 
{
		$('.slider-handle').draggable({
				containment:'parent',
				axis:'x',
				grid: [ 10,0 ],
				cursor: 'pointer',
				drag:function(e,ui){
						
						if(!this.par)
						{
								this.par = $(this).parent();
								this.parWidth = this.par.width();
								this.width = $(this).width();
						}
			
						var ratio = 1 - (ui.position.left+this.width)/this.parWidth;
						$('#slider-legend').html(parseFloat(ratio).toFixed(1));
				},
				stop:function(){
						niveau();
				}
		});
}

function aff_grille( btn ) 
{
		var tableMap = $('#tableMap');
		var taillemap = tableMap.width();
	
		if( $(btn).is('.button-image-actif') )
		{
				tableMap.removeClass('no_grille').width( Math.round(taillemap + (taillemap / size_case) ) );
				$(btn).removeClass('button-image-actif');
				$('#masqueGrille').children('span').html(masq_grille);
		}
		else
		{
				tableMap.addClass('no_grille').width( Math.round(taillemap - (taillemap / size_case)) +2 );
				$(btn).addClass('button-image-actif');
				$('#masqueGrille').children('span').html(look_grille);
		}
	
		$('.mapTD').each(function() {
		
				var obj = $(this);
		
				if( obj.is('.no_grille'))
						obj.removeClass('no_grille');
				else
						obj.addClass('no_grille');
		
		});
}

function dropElement(target, e) 
{
		e.preventDefault();
	
		var map_pos = $('#map_position').val();
	
		if( $('#'+e.dataTransfer.getData('Text')).is('.bullMulti') )
				dropMulti( target, e, map_pos );
		else
		{
				var id = target.id.split('-');
				id = id[0]+'-'+id[1]+'-'+map_pos;
				dropSimple( id, e.dataTransfer.getData('Text'), map_pos );
		}
} 

function dropSimple( id, id_element, map_pos ) 
{
		var parent = id.split('-');
	
		if(!$('#TD_'+parent[0]+'-'+parent[1]).length)
				return;
		
		if( !$('#'+id).is('.niveau_'+map_pos) || !$('#'+id).length)
		{	
				var my_html = '<div ondrop="dropElement(this, event)" ondragenter="return false" ondragover="return false" class="droppable niveau_'+map_pos+'" id="'+id+'"></div>';
		
				$('#TD_'+parent[0]+'-'+parent[1]).append(my_html);		
		}
	
		$('#'+id).addClass('elementDrop').css({
				'background-position' : $('#'+id_element).css('background-position'), 
				'background-image' : 'url("'+dir_script+'../images/tilesets/'+$('#tilesets').val()+'")'
		});
	
		cache('ajout', '#'+id );
} 

function dropMulti( target, e, map_pos ) 
{
		var id = e.dataTransfer.getData('Text').split('-'),
		xMin = parseInt(id[1]),
		yMin = parseInt(id[2]),
		xMax = parseInt(id[3]),
		yMax = parseInt(id[4]),
		xCase = yCase = 0,
		idCase = target.id.split('-');
	
		for( var y = yMin; y < yMax; y++)
		{
				for( var x = xMin; x < xMax; x++)
				{
						dropSimple( ((parseInt(idCase[0])+xCase)+'-'+(parseInt(idCase[1])+yCase)+'-'+map_pos), x+'_'+y, map_pos ) ;
						xCase++;
				}
				xCase = 0;
				yCase++;
		}
} 

function dragElement(target, e) 
{
		$('img', target).hide();
		e.dataTransfer.setData('Text', target.id);
}

function dragElementMulti(target, e) 
{
		$('img', target).hide();
		e.dataTransfer.setData('Text', target.id);
}

function init_img(target) 
{
		$('img', target).show();
}

function ElementMulti(target) 
{
		var id = target.id.split('-'),
		xMin = parseInt(id[0]),
		yMin = parseInt(id[1]),
		xMax = parseInt(id[2]),
		yMax = parseInt(id[3]),
		position = $(target).position(),
		less = null;
		
		display = '<div draggable="true" ondragstart="dragElementMulti(this, event)" ondragend="init_img(this)" class="bullMulti" style="height:'+((yMax-yMin)*(size_case + 1))+'px; width:'+((xMax-xMin)*(size_case + 1))+'px; top:'+( parseInt(position.top)-2 )+'px; left:'+( parseInt(position.left)-2 )+'px;" id="bloc-'+target.id+'">';	

		for( var y = yMin; y < yMax; y++)
		{
				for( var x = xMin; x < xMax; x++)
				{
						display += '<div class="elementsMulti" style="background-position:-'+(size_case*x)+'px -'+(size_case*y)+'px; background-image:url(\''+dir_script+'../images/tilesets/'+$('#tilesets').val()+'\')">';
						if(!less)
						{
								less = true;
								display += '<img src="'+dir_script+'images/editeur/less.png" alt="-" class="closeMulti" />';
						}
						display += '</div>';
				}
		}

		display += '</div>';
		
		$('#contentMenu').prepend(display);
}

function closeMulti( obj ) 
{
		$(obj).parents('.bullMulti:first').remove();
}

function aff_obstacle ( btn, type ) 
{	
		if( $(btn).is('.button-image-actif') )
		{
				delete_aff_obstacle ( btn );
		}
		else
		{
				active_aff_obstacle( type );
				$(btn).addClass('button-image-actif');
		}
}

function delete_aff_obstacle ( obj ) 
{
		if(!obj)
		{
				$('#button_select_6, #button_select_7, #button_select_9').removeClass('button-image-actif');
				$('.aff_obstacle').fadeOut(function() {
						$(this).remove()
				});
		}
		else
		{
				if($(obj).attr('id') == 'button_select_6')
						$('.bg_obstacle').fadeOut(function() {
								$(this).remove()
						});
				else if($(obj).attr('id') == 'button_select_9')
						$('.bg_bot').fadeOut(function() {
								$(this).remove()
						});
				else
						$('.bg_module').fadeOut(function() {
								$(this).remove()
						});
		
				$(obj).removeClass('button-image-actif');
		}
}
function active_aff_obstacle ( type ) 
{
		$.post(url_script+'editeur/obstacle/'+type, function(data) {
		
				if(data.length)
				{
						var list = data.split('|');
			
						$.each( list, function(i, l)
						{
								if( ( type == 'module' && !$('#aff_obstacle_'+l+' .bg_module').length ) || ( type == 'obstacle' && !$('#aff_obstacle_'+l+' .bg_obstacle').length ) || ( type == 'bot' && !$('#aff_obstacle_'+l+' .bg_bot').length ) )
										$('#TD_'+l).append('<div class="aff_obstacle bg_'+type+'" id="aff_obstacle_'+l+'" style="display:none"></div>');
						});
						$('.aff_obstacle').fadeIn();
				}
		});
}

function help()
{
		$.facebox({
				ajax: url_script+'editeur/help'
		});
}

function action_form ()
{
		var form = $('#module').val();
	
		if(form)
				$('#formAction').load(url_script+'actions/form/'+form+'/'+$('#coordonne').val());
		else
				$('#formAction').html('');
}

function multi_change_niveau_sup()
{
		var niveau = $('#map_position').val();
		niveau++;
	
		if(niveau > 3)
				return;
	
		multi_change_niveau( niveau );
}

function multi_change_niveau_inf()
{
		var niveau = $('#map_position').val();
		niveau--;
	
		if(niveau < -3)
				return;
	
		multi_change_niveau( niveau );
}

function multi_change_niveau( niveau )
{
		if(!$('.selectionne').length)
				return;
		
		var opacite = parseFloat($('#slider-legend').html()),
		pos = $('#map_position').val(),
		url = url_script+'editeur/niveau?niveau_new='+niveau+'&niveau_actuel='+pos;
	
		$('.selectionne').each(function() {
		
				var id = $(this).siblings('.droppable').attr('id').split('-');
				id = id[0]+'-'+id[1];
		
				var selection = $('#'+id+'-'+pos),
				present = $('#'+id+'-'+niveau);
		
				if(selection.length)
				{
						url += '&id[]='+id;
						if(present.length)
								present.attr('id',id+'-'+pos).removeClass('niveau_'+niveau).addClass('niveau_'+pos+' niveau_max').animate({
										opacity : 1
								});
				
						selection.attr('id',id+'-'+niveau).removeClass('niveau_'+pos+' niveau_max').addClass('niveau_'+niveau).animate({
								opacity : opacite
						});
				}
		
		});
	
		$.get(url);	
	
		choix_option_selection( '#button_select_4' );
}

function niveau()
{
		var exp = new RegExp('[0-9]+?'),
		pos = $('#map_position').val();
	
		$('.elementDrop').each(function() {
		
				var res = exp.exec($(this).attr('class'));
		
				if( $(this).is('.niveau_-'+res))
						res = parseInt('-'+res);
	
				if( res == pos)
						$(this).animate({
								opacity: 1
						}).addClass('niveau_max');
				else
						$(this).animate({
								opacity: parseFloat($('#slider-legend').html())
						}).removeClass('niveau_max');
		});
}

function niveau_plus()
{	
		var nouveau = $('#map_position').val();
		nouveau++;
	
		if( nouveau <= 3)
				option_select( nouveau );
}

function niveau_moins()
{
		var nouveau = $('#map_position').val();
		nouveau--;
	
		if( nouveau >= -3)
				option_select( nouveau );
}

function option_select( nouveau )
{		
		$('#map_position').val(nouveau);
		niveau();
}

function manager_obstacle( type )
{
		if(!$('.selectionne').length)
				return;
					
		var url = url_script+'editeur/managerObstacle?type='+type;
	
		$('.selectionne').each(function() {
		
				var id = $(this).siblings('.droppable').attr('id').split('-');
				id = id[0]+'-'+id[1];
		
				$('#aff_obstacle_'+id).remove();
		
				url += '&id[]='+id;		
		});

		$.get(url, function() {
	
				if($('#button_select_6').is('.button-image-actif'))
						active_aff_obstacle ( 'obstacle' );
		
				choix_option_selection( '#button_select_4' );
		
		});	
}

function manager_bot( type )
{
		if(!$('.selectionne').length)
				return;
					
		var url = url_script+'editeur/managerBot?type='+type;
	
		$('.selectionne').each(function() {
		
				var id = $(this).siblings('.droppable').attr('id').split('-');
				id = id[0]+'-'+id[1];
		
				$('#aff_bot_'+id).remove();
		
				url += '&id[]='+id;		
		});

		$.get(url, function() {
			
				choix_option_selection( '#button_select_4' );
				
		});	
}