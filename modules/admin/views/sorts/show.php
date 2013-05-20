<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<style type="text/css">
		.vignetteAnimate {
				background-image:url('<?php echo url::base(); ?>../images/sorts_animate/<?php echo $row->effect; ?>.png');
		}
</style>
<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?php echo Kohana::lang( 'sort.edit_param' ); ?></h3>
		</header>
		<div class="module_content">
				<p class="form-line">
						<label for="name" class="form-label"><?php echo Kohana::lang( 'sort.name' ); ?> :</label>
						<input name="name" id="name" value="<?php echo $row->name; ?>" class="inputbox input-text" type="text" maxlength="50" />
				</p>
				<p class="form-line">
						<label for="comment" class="form-label"><?php echo Kohana::lang( 'sort.desc' ); ?> : <span class="p-lower"><?php echo Kohana::lang( 'form.minus' ); ?></span></label>
						<textarea name="comment" id="comment" class="inputbox input-textarea" style="height:100px;"><?php echo $row->comment; ?></textarea>
				</p>
				<p class="form-line">
						<label class="form-label"><?php echo Kohana::lang( 'sort.img' ); ?> :</label>
						<input type="button" id="list_vignette" class="button" value="<?php echo Kohana::lang( 'form.selected_list' ); ?>" />
						<input type="hidden" value="<?php echo $row->image; ?>" id="image" name="image"/>
				</p>
				<p class="form-line">
						<label for="prix" class="form-label"><?php echo Kohana::lang( 'sort.price' ); ?> :</label>
						<input name="prix" id="prix" value="<?php echo $row->prix; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="niveau" class="form-label"><?php echo Kohana::lang( 'sort.level' ); ?> :</label>
						<select name="niveau" id="niveau" class="inputbox" >
								<?php for( $n = 0; $n <= 100; $n++ ) : ?>
										<option value="<?php echo $n; ?>" <?php echo ( $n == $row->niveau ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
								<?php endfor ?>
						</select>
				</p>
				<p class="form-line">
						<label for="attack_min" class="form-label"><?php echo Kohana::lang( 'sort.attack_min' ); ?> :</label>
						<input name="attack_min" id="attack_min" value="<?php echo $row->attack_min; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="attack_max" class="form-label"><?php echo Kohana::lang( 'sort.attack_max' ); ?> :</label>
						<input name="attack_max" id="attack_max" value="<?php echo $row->attack_max; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="effect" class="form-label"><?php echo Kohana::lang( 'sort.effect' ); ?> :</label>
						<select name="effect" id="effect" class="inputbox" >
								<?php if( $imagesEffect ) : ?>
										<?php foreach( $imagesEffect as $val ) : ?>
												<option value="<?php echo $val; ?>" <?php echo ( $val == $row->effect.'.png' ) ? 'selected="selected"' : ''; ?>><?php $name_effect = explode( '_', $val );
								echo $name_effect[0]; ?></option>
										<?php endforeach ?>
								<?php endif ?>
						</select>
				</p>
				<p class="form-line">
						<label for="mp" class="form-label"><?php echo Kohana::lang( 'user.mp' ); ?> :</label>
						<input name="mp" id="mp" value="<?php echo $row->mp; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
		</div>
</article>
<article class="module width_quarter">
		<header><h3><?php echo $row->name; ?></h3></header>
		<div class="module_content">
				<div class="label">
						<label><?php echo Kohana::lang( 'sort.id' ); ?> :</label>
						<?php echo $row->id; ?></div>
				<div class="label">
						<label><?php echo Kohana::lang( 'sort.vignette_anime' ); ?> :</label>
						<div id="vignetteAnimate" class="vignetteAnimate"></div>
						<div class="center"><a href="javascript:;" id="LookAnimate"><?php echo Kohana::lang( 'sort.look_effect' ); ?></a></div>
				</div>
				<div class="label">
						<label><?php echo Kohana::lang( 'sort.vignette_button' ); ?> :</label>
						<div class="center" style="margin:10px 0;"> <img src="<?php echo url::base(); ?>../images/sorts/<?php echo $row->image; ?>" width="40" height="40" id="boutonSort" class="imageSort" /></div>
				</div>
		</div>
</article>
<div class="spacer"></div>
<script>
		var name_required = "<?php echo Kohana::lang( 'form.name_required' ); ?>",
		name_minlength = "<?php echo Kohana::lang( 'form.name_minlength' ); ?>",
		name_maxlength = "<?php echo Kohana::lang( 'form.name_maxlength' ); ?>",
		comment_required = "<?php echo Kohana::lang( 'form.comment_required' ); ?>",
		comment_minlength = "<?php echo Kohana::lang( 'form.comment_minlength' ); ?>",
		comment_maxlength = "<?php echo Kohana::lang( 'form.comment_maxlength' ); ?>",
		prix_required = "<?php echo Kohana::lang( 'form.prix_required' ); ?>",
		prix_min = "<?php echo Kohana::lang( 'form.prix_min' ); ?>",
		prix_max = "<?php echo Kohana::lang( 'form.prix_max' ); ?>",
		prix_number = "<?php echo Kohana::lang( 'form.prix_number' ); ?>",
		mp_required = "<?php echo Kohana::lang( 'form.mp_required', Kohana::lang( 'user.mp' ) ); ?>",
		mp_max = "<?php echo Kohana::lang( 'form.mp_max', Kohana::lang( 'user.mp' ) ); ?>",
		mp_number = "<?php echo Kohana::lang( 'form.mp_number', Kohana::lang( 'user.mp' ) ); ?>";
</script>
