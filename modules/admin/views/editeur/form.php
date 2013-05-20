<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<form id="myFormOption" onsubmit="return false;">
		<div class="titreForm">
				<?php if( $vignettes ) : ?>
						<div class="vignette">
								<?php foreach( $vignettes as $vignette ) : ?>
										<style type="text/css">
												#vignette_detail_<?php echo $vignette->id_map; ?> {
														background-image:url("<?php echo url::base(); ?>../images/tilesets/<?php echo $vignette->background_map; ?>"); background-position:<?php echo $vignette->position_background_map; ?>; 
												}
										</style>
										<div class="vignette_detail" id="vignette_detail_<?php echo $vignette->id_map; ?>"></div>
								<?php endforeach ?>
						</div>
				<?php endif ?>
				<div class="titreCentent"><?php echo Kohana::lang( 'editeur.form_title' ); ?></div>
				<div class="spacer"></div>
		</div>
		<div class="contentForm">
				<div class="row_form">
						<label><span class="titreSpanForm"><?php echo Kohana::lang( 'editeur.form_name' ); ?></span>
								<input type="text" class="input-text" id="nom" name="nom" value="<?php echo isset( $row->nom_map ) ? $row->nom_map : false; ?>" size="40" maxlength="100" />
						</label>
						<div class="spacer"></div>
				</div>
				<div class="row_form">
						<label><span class="titreSpanForm"><?php echo Kohana::lang( 'editeur.form_label_passage' ); ?></span>
								<select class="input-select" id="passage" name="passage">
										<option <?php if( isset( $row->passage_map ) && $row->passage_map == 1 )
						echo 'selected="selected"'; ?> class="vert" value="1"><?php echo Kohana::lang( 'editeur.form_yes_passage' ); ?></option>
										<option <?php if( isset( $row->passage_map ) && $row->passage_map == 0 )
						echo 'selected="selected"'; ?> class="rouge" value="0"><?php echo Kohana::lang( 'editeur.form_no_passage' ); ?></option>
								</select>
						</label>
						<div class="spacer"></div>
				</div>
				<div class="row_form">
						<label><span class="titreSpanForm"><?php echo Kohana::lang( 'editeur.form_label_bot' ); ?></span>
								<select class="input-select" id="bot" name="bot">
										<option class="rouge" value="0"><?php echo Kohana::lang( 'editeur.form_no_bot' ); ?></option>
										<option <?php if( isset( $row->bot ) && $row->bot == 1 )
						echo 'selected="selected"'; ?> class="vert" value="1"><?php echo Kohana::lang( 'editeur.form_yes_bot' ); ?></option>
								</select>
						</label>
						<div class="spacer"></div>
				</div>
				<div class="row_form">
						<label><span class="titreSpanForm"><?php echo Kohana::lang( 'editeur.form_label_image' ); ?></span>
								<select name="image" id="image" class="input-select" >
										<option value="0" >--</option>
										<?php if( $images ) : ?>
												<?php foreach( $images as $val ) : ?>
														<option value="<?php echo $val; ?>" <?php echo isset( $row->image ) && $val == $row->image ? 'selected="selected"' : ''; ?>><?php echo $val; ?></option>
		<?php endforeach ?>
<?php endif ?>
								</select>
						</label>
						<div class="spacer"></div>
				</div>
				<div class="row_form">
						<label><span class="titreSpanForm"><?php echo Kohana::lang( 'editeur.form_label_action' ); ?></span>
								<select class="input-select" id="module" name="module">
										<option value=""><?php echo Kohana::lang( 'editeur.form_no_action' ); ?></option>
										<?php if( $actions ) : ?>
												<?php foreach( $actions as $val ) : ?>
														<?php $val = str_replace( '.php', '', $val ); ?>
														<option value="<?php echo $val; ?>" <?php echo ( isset( $row->module_map ) && $val == $row->module_map ) ? 'selected="selected"' : ''; ?>><?php echo Kohana::lang( 'plg_'.$val.'.title' ); ?></option>
		<?php endforeach ?>
<?php endif ?>
								</select>
						</label>
						<div class="spacer"></div>
				</div>
				<div id="formAction"></div>
		</div>
		<div class="footerForm">
<?php if( $row ) : ?>
						<input type="button" id="supprimer" class="button button_rouge close" value="<?php echo Kohana::lang( 'form.delete' ); ?>"/>
<?php endif ?>
				<input type="button" id="enregistrer" class="button button_vert close" value="<?php echo!$row ? Kohana::lang( 'form.crea' ) : Kohana::lang( 'form.modif' ); ?>"/>
				<input type="button" class="button close" value="<?php echo Kohana::lang( 'form.annul' ); ?>"/>
		</div>
		<input type="hidden" id="coordonne" name="coordonne" value="<?php echo $x_map.'-'.$y_map; ?>"/>
		<?php if( isset( $row->id_detail ) ) : ?>
				<input type="hidden" id="id_detail" name="id_detail" value="<?php echo $row->id_detail; ?>"/>
		<?php endif ?>
<?php if( isset( $row->region_id ) ) : ?>
				<input type="hidden" id="region_id" name="region_id" value="<?php echo $row->region_id; ?>"/>
<?php endif ?>
</form>
<script>
		$(function(){ action_form (); });
</script>