$(function(){
	
		//USER
		$('#modif_avatar').live('click', function() {
				$.facebox({
						ajax: url_script+'user/listing_avatar'
				});
		});
		
		$('.avatar_modif').live('click', function() {
				
				// mise a jour de la variable global
				user_avatar = $(this).css('background-image').replace('url(', '').replace(')', '');

				$('#myUser').css('background-image', $(this).css('background-image'));
				$.get(url_script+'user/update_avatar/'+this.id);
		});
		
		$('#modif_pwd').live('click', function(){
				
				var new_pwd = $('#new_pwd').val();
				
				$('#repeat_new_pwd, #new_pwd').removeClass('border-rouge');
				
				if( new_pwd == '')
				{
						$('#new_pwd').addClass('border-rouge');
						return;
				}
				
				if( new_pwd != $('#repeat_new_pwd').val() )
				{
						$('#repeat_new_pwd, #new_pwd').addClass('border-rouge');
						return
				}
		
				$.post(url_script+'user/update_pwd', {
						'new_pwd' : new_pwd
				}, function( data ) {
						$('body').append(data);
						msg();
						$('#repeat_new_pwd, #new_pwd').val('');
				});
		});
		
		//SORT
		$('.select_sort').live('change', function() {
				calcul_sort();
		});
		
		$('#buy_sort').live('click', function() {
				
				audio('decapsul.ogg', true);
				
				var url = 'actions/sort/insert?ajax=1';
				
				$('select').each(function(){
						url += '&'+$(this).attr('name')+'='+$(this).val();
				});
		
				loadAction( url );
		});
		
		//SHOP
		$('.select_item').live('change', function() {
				calcul_shop();
		});
	
		$('#buy_item').live('click', function() {
				
				audio('decapsul.ogg', true);
				
				var url = 'actions/shop/insert?ajax=1';

				$('select').each(function(){
						url += '&'+$(this).attr('name')+'='+$(this).val();
				});
				
				loadAction( url );
				
		});
	
		$('#sale_item').live('click', function() {
				
				audio('decapsul.ogg', true);
				
				var url = 'actions/shop/update?ajax=1';

				$('select').each(function(){
						url += '&'+$(this).attr('name')+'='+$(this).val();
				});
				
				loadAction( url );
				
		});
		
		//MAP
		$('#accepter').live('click', function() {
				loadAction('actions/quete/add/'+$('#id_quete').val() );
		});

		$('#annul').live('click', function() {
				loadAction('actions/quete/annul/'+$('#id_quete').val() );
		});
		
		//ITEM
		$('.ramasser').live('click', function() {
				$(this).val('En cours');
				ramasser( this );
		});	
		
		//INVENTAIRE
		$('.element-item, .content-item').live('click', function(){
				$.facebox({
						ajax: url_script+'item/show/'+this.id.replace('elementInventaire_','')
				});
		});
				
		$('.utiliser').live('click', function(){
				
				audio('champagne.ogg', true);
				
				var id = this.id.replace('utiliser_','');
				useItem(id);
		});

		$('.equiper').live('click', function(){
				
				audio('gifle.ogg', true);
				
				var id = this.id.replace('equiper_','');
				$.get( url_script+'item/equiper/'+id, function(data) { 
						$('.position_equipe_'+data+' img').css('background-color', '#EFF4EB');
						$('#elementInventaire_'+id+' img').css('background-color', '#A52A25');
				});
		});
		
		$('.retirer').live('click', function(){
				
				audio('sabre.ogg', true);
				
				var id = this.id.replace('retirer_','');
				$.get( url_script+'item/equiper_delete/'+id, function () {
						$('#elementInventaire_'+id+' img').css('background-color', '#EFF4EB');
				});
		});
		
		$('.supprimer').live('click', function(){
				
				audio('sabre.ogg', true);
				
				var id = this.id.replace('supprimer_','');
				$.get( url_script+'item/delete/'+id, function () {
						useItem(id, true);
				});
		});
		
		$('.imgItem, .button_menu_right').tipsy();
		
		
		//FIGHT
		$('.buttonActiobSort').tipsy().live('click', function() {
				initFight(this);
		});
	
		//MAP
		$('#activite').live('click', function() {
				loadAction('user/show' );
		});
		
		$('.menu_top').live('click', function() {
				loadAction('user/show/'+this.id.replace('_menu',''), function() {
						$('.imgItem').tipsy({
								gravity : 'n',
								delayIn : 0
						});
				} );
		});
		
		$('#tchat-menu').delegate('#msgTchat', 'keypress', function(e){
				if(e.keyCode == 13) 
						send_tchat();
		});
				
		$('#msgTchat').focus(function() {
				$('#tchat').show();
				focusChat = true;
		}).blur(function() {
				$('#tchat').hide();
				$(this).val('');
				focusChat = false;
		});
				
		$('#commandAction').delegate('.closeAction', 'click', function(){
				closeAction( );
		});
		
		$('#control_sound').live('click', function() {
				control_audio(  );
		});
		
		//METIER
		$('#job_menu').live('click', function() {
				loadAction('job' );
		});
		
		$('#select_job').live('click', function() {
				
				var my_job = $('#my_job').val();
				
				if( my_job )
						loadAction('job/select/'+my_job );
		});
		
		$('.insert_couple').live('click', function() {
				
				audio('magic.ogg', true);
				
				loadAction('job/couple/'+this.id.replace('couple_', ''), function() {
						refresh_user( true);
				});
		});
			
});
