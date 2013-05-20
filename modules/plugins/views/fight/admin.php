<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'bot.bot_x', Kohana::lang( 'user.hp' ) ); ?></span>
				<input name="bot_hp" value="<?php echo isset( $data->bot_hp ) ? $data->bot_hp : false; ?>" class="input-text" type="text" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'bot.bot_x', Kohana::lang( 'user.mp' ) ); ?></span>
				<input name="bot_mp" value="<?php echo isset( $data->bot_mp ) ? $data->bot_mp : false; ?>" class="input-text" type="text" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'bot.bot_x', Kohana::lang( 'user.attack' ) ); ?></span>
				<input name="bot_attaque" value="<?php echo isset( $data->bot_attaque ) ? $data->bot_attaque : false; ?>" class="input-text" type="text" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'bot.bot_x', Kohana::lang( 'user.defense' ) ); ?></span>
				<input name="bot_defense" value="<?php echo isset( $data->bot_defense ) ? $data->bot_defense : false; ?>" class="input-text" type="text" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'bot.niveau' ) ?></span>
				<select name="niveau" class="input-select" >
						<?php for( $n = 0; $n <= 100; $n++ ) : ?>
								<option value="<?php echo $n; ?>" <?php echo ( isset( $data->niveau ) && $n == $data->niveau ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
						<?php endfor ?>
				</select>
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'region.bot_argent_min' ); ?></span>
				<input name="bot_argent_min" value="<?php echo isset( $data->bot_argent_min ) ? $data->bot_argent_min : false; ?>" class="input-text" type="text" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'region.bot_argent_max' ); ?></span>
				<input name="bot_argent_max" value="<?php echo isset( $data->bot_argent_max ) ? $data->bot_argent_max : false; ?>" class="input-text" type="text" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'bot.image' ); ?></span>
				<select name="image" class="input-select" >
						<?php if( $image ) : ?>
								<?php foreach( $image as $val ) : ?>
										<option value="<?php echo $val; ?>" <?php echo ( isset( $data->image ) && $val == $data->image ) ? 'selected="selected"' : ''; ?>><?php echo $val; ?></option>
								<?php endforeach ?>
						<?php endif ?>
				</select>
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'bot.listing_sort' ); ?></span>
				<select name="sorts[]" size="5" multiple="multiple" class="input-select input-select-multiple" >
						<?php if( $sorts ) : ?>
								<?php foreach( $sorts as $val ) : ?>
										<option value="<?php echo $val->id; ?>" <?php echo isset( $data->sorts ) && is_array( $data->sorts ) && in_array( $val->id, $data->sorts ) ? 'selected="selected"' : ''; ?> ><?php echo $val->name; ?></option>
								<?php endforeach ?>
						<?php endif ?>
				</select>
		</label>
		<div class="clear"></div>
</div>

<h2><?php echo Kohana::lang( 'plg_fight.item_victory' ); ?></h2>

<ul id="accordion"> 
		<?php foreach( $items as $item ) : ?>
				<li> 
						<a href="javascript:;" class="heading"><?php echo $item['title']; ?></a> 
						<ul id="recent" class="invis"> 
								<li>
										<?php foreach( $item['data'] as $row ) : ?>
												<div class="row_form">
														<label>
																<span class="titreSpanForm"><img src="<?php echo url::base(); ?>../images/items/<?php echo $row->image; ?>" width="24" height="24" id="imageItem" align="middle"/> <a href="/items/show/<?php echo $row->id; ?>" class="titreSpanForm"><?php echo $row->name; ?></a></span>
																<select class="input-select" name="item_victory[<?php echo $row->id; ?>]" >
																		<?php if( $row->protect || $row->cle ) : ?>
																				<option value="0" class="rouge"><?php echo Kohana::lang( 'form.no' ); ?></option>
																				<option value="1" class="vert" <?php echo isset( $data->item_victory ) && is_array( $data->item_victory ) && $data->item_victory [$row->id] == 1 ? 'selected="selected"' : ''; ?>><?php echo Kohana::lang( 'form.yes' ); ?></option>
																		<?php else : ?>
																				<?php for( $n = 0; $n <= 100; $n++ ) : ?>
																						<option value="<?php echo $n; ?>" <?php echo isset( $data->item_victory ) && is_array( $data->item_victory ) && $data->item_victory [$row->id] == $n ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
																				<?php endfor ?>
																		<?php endif ?>
																</select>

														</label>
														<div class="clear"></div>
												</div>
										<?php endforeach ?></li> 
						</ul>
				</li> 
		<?php endforeach ?>
</ul> 



<script>
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
		});
</script>
