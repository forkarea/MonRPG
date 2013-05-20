<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="row_form">
		<label><span class="titreSpanForm"><?php echo Kohana::lang( 'action.pos_end' ); ?> X</span>
				<select name="x" class="input-select" >
						<?php for( $n = 0; $n <= 50; $n++ ) : ?>
								<option value="<?php echo $n; ?>" <?php echo isset( $data->x ) && $data->x == $n ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
						<?php endfor ?>
				</select>
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label><span class="titreSpanForm"><?php echo Kohana::lang( 'action.pos_end' ); ?> Y</span>
				<select name="y" class="input-select" >
						<?php for( $n = 0; $n <= 50; $n++ ) : ?>
								<option value="<?php echo $n; ?>" <?php echo isset( $data->y ) && $data->y == $n ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
						<?php endfor ?>
				</select>
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'action.choose_map' ); ?></span>
				<select name="id_region" class="input-select" >
						<?php if( $region ) : ?>
								<?php foreach( $region as $val ) : ?>
										<option value="<?php echo $val->id; ?>" <?php echo isset( $data->id_region ) && $val->id == $data->id_region ? 'selected="selected"' : ''; ?> style="padding-left:<?php echo $val->level * 12; ?>px;"><?php echo $val->name; ?></option>
								<?php endforeach ?>
						<?php endif ?>
				</select>
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'action.music_move' ); ?></span>
				<select name="music" class="input-select" >
						<option value="" ><?php echo Kohana::lang( 'region.no_music' ); ?></option>
						<option value="porte" <?php echo isset( $data->music ) && $data->music == 'porte' ? 'selected="selected"' : ''; ?>><?php echo Kohana::lang( 'action.music_porte' ); ?></option>
						<option value="teleporte" <?php echo isset( $data->music ) && $data->music == 'teleporte' ? 'selected="selected"' : ''; ?>><?php echo Kohana::lang( 'action.music_teleporte' ); ?></option>
				</select>
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label><span class="titreSpanForm"><?php echo Kohana::lang( 'action.price_move' ); ?></span>
				<input type="text" class="input-text" name="prix" value="<?php echo isset( $data->prix ) ? $data->prix : false; ?>" size="20" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'action.passage_object' ); ?></span>
				<select name="item" class="input-select input-select-multiple" >
						<option value="0">--</option>
						<?php if( $items ) : ?>
								<?php foreach( $items as $val ) : ?>
										<option value="<?php echo $val->id; ?>" <?php echo isset( $data->item ) && $val->id == $data->item ? 'selected="selected"' : ''; ?> ><?php echo $val->name; ?></option>
								<?php endforeach ?>
						<?php endif ?>
				</select>
		</label>
		<div class="clear"></div>
</div>
