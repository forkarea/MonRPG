function ramasser( obj )
{
		var id = $(obj).siblings('input[name=id_object]').val();

		$.post(url_script+'actions/object/insert/', {
				object : id
		}, function ( data ) { 
				if(data)
				{
						var clone = $('#objet_'+id).clone().prependTo('#myUser');
						
						clone.css({
								'position' : 'absolute',
								'margin-left': (Math.round(size_case - clone.width()) / 2 )+'px', 
								'z-index' : '1'
						}).animate({
								opacity: 0, 
								top: '-=50'
						}, 6000, function() {
								$(this).remove();
						} );	
								
						$(obj).replaceWith(data); 
						
						if($('#elementInventaire_'+id).length)
						{
								var child = $('#elementInventaire_'+id).children('.nombre');
								child.html(parseInt(child.html()) + 1);
						}
				}
		});
}