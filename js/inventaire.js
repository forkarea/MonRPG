var oldDropID = false;

function dragInventaire(target, e) 
{
		oldDropID = $(target).parent('div').attr('id');
				
		e.dataTransfer.setData('Text', target.id);
		$('.tipsy').remove();
}

function dropInventaire(target, e) 
{
		e.preventDefault();
		var element = e.dataTransfer.getData('Text');
	
		if(typeof(element) == 'undefined')
				return;
	
		var idDrag = $('#'+element).attr('id').replace('elementInventaire_',''),
		my_oldDropID = oldDropID.replace('inventaire_',''),
		idDrop = target.id.replace('inventaire_','');
		
		if( idDrop === my_oldDropID)
				return;
			
		var newContent = $('#'+element),
		url = url_script+'item/move/'+idDrag+'/'+idDrop;

		if( $(target).html().replace(/^\s+/g,'') == '')
				newContent.remove();
		else if( idDrop != 0)
		{
				url += '/'+$(target).children('div').attr('id').replace('elementInventaire_','')+'/'+my_oldDropID;
				if( my_oldDropID == 0 )
						newContent.parent('div').append($(target).html());
				else
						newContent.parent('div').html($(target).html());
		}

		$('#'+element).remove();
		
		if( idDrop != 0)
				$(target).html(newContent);
		else
				$(target).append(newContent);
		
		$.get(url);
	
		oldDropID = false;
	
		$('.imgItem').tipsy();
}

function useItem( id, no_request )
{		
		var nbr = parseInt($('#elementInventaire_'+id).children('.nombre').html());
	
		nbr--;

		if(nbr<0 || isNaN(nbr) )
		{
				$('.tipsy').remove();
				$('#elementInventaire_'+id).remove();
				return;
		}
	
		if(nbr == 0)
		{
				$('.tipsy').remove();
				$('#elementInventaire_'+id).remove();
		}
		else
				$('#elementInventaire_'+id).children('.nombre').html(nbr);
		
		if( no_request != null)
				return;
				
		$.getJSON(url_script+'item/using/'+id, function(data) {
				if(data.hp)
				{
						set_barre( '#infoUserHP', data.hp );
						set_barre( '#user_hp', data.hp );
				}
	
				if(data.mp)
				{
						set_barre( '#infoUserMP', data.mp );
						set_barre( '#user_mp', data.mp );
				}
		});			
}