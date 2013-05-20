<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="changeEditeur">
		<select id="changeMap" >
				<?php if( $listing ) : ?>
						<?php foreach( $listing as $val ) : ?>
								<option value="<?php echo $val->id; ?>" <?php echo ( $val->id == $idRegion ) ? 'selected="selected"' : ''; ?> style="padding-left:<?php echo $val->level * 12; ?>px;"><?php echo $val->name; ?></option>
						<?php endforeach ?>
				<?php endif ?>
		</select>
</div>

<div class="bg-editor" id="toolMap">
		<div class="contener-editor">
				<div class="slide-position">
						<div class="opacite-slider">
								<div class="slider-handle" title="<?php echo Kohana::lang( 'editeur.title_modif_opac' ); ?>"></div>
						</div>
						<div class="slider-legend"><span id="slider-legend" title="<?php echo Kohana::lang( 'editeur.title_opac_act' ); ?>">0.5</span></div>
				</div>
				<div class="optionTilesets">
						<input type="image" src="<?php echo url::base(); ?>images/editeur/move.png" value="0" title="<?php echo Kohana::lang( 'editeur.title_ctr_d' ); ?>" class="button-image" id="button_select_0" />
						<input type="image" src="<?php echo url::base(); ?>images/editeur/multi-select.png" value="1" title="<?php echo Kohana::lang( 'editeur.title_ctr_a' ); ?>" class="button-image" id="button_select_1" />
						<input type="image" src="<?php echo url::base(); ?>images/editeur/cursor.png" value="2" title="<?php echo Kohana::lang( 'editeur.title_ctr_c' ); ?>" class="button-image" id="button_select_2" />
						<select id="multiselection" style="display:none">
								<option value="0"></option>
								<option value="1"></option>
								<option value="2"></option>
						</select>
				</div>
				<div class="optionTilesets" style="display:none" id="no_select_all">
						<input type="image" src="<?php echo url::base(); ?>images/editeur/corbeille.png" value="1" title="<?php echo Kohana::lang( 'editeur.title_ctr_s' ); ?>" class="button-image" id="button_select_3" />
						<input type="image" src="<?php echo url::base(); ?>images/editeur/gomme.png" value="2" title="<?php echo Kohana::lang( 'editeur.title_esc' ); ?>" class="button-image" id="button_select_4" />
				</div>
				<div class="optionTilesets">
						<input type="image" src="<?php echo url::base(); ?>images/editeur/grille.png" value="1" title="<?php echo Kohana::lang( 'editeur.title_ctr_g' ); ?>" class="button-image" id="button_select_5" />
						<input type="image" src="<?php echo url::base(); ?>images/editeur/firewall.png" value="0" title="<?php echo Kohana::lang( 'editeur.title_ctr_o' ); ?>" class="button-image" id="button_select_6" />
						<input type="image" src="<?php echo url::base(); ?>images/editeur/bots.png" value="0" title="<?php echo Kohana::lang( 'editeur.title_ctr_b' ); ?>" class="button-image" id="button_select_9" />
						<input type="image" src="<?php echo url::base(); ?>images/editeur/connect.png" value="0" title="<?php echo Kohana::lang( 'editeur.title_ctr_m' ); ?>" class="button-image" id="button_select_7" />
						<input type="image" src="<?php echo url::base(); ?>images/editeur/help.png" value="0" title="<?php echo Kohana::lang( 'editeur.title_ctr_h' ); ?>" class="button-image" id="button_select_8" />
				</div>
				<div class="optionTilesets">
						<select id="map_position" class="input-select-editor" title="<?php echo Kohana::lang( 'editeur.title_niveau' ); ?>">
								<?php for( $n = -3; $n <= 3; $n++ ) : ?>
										<option <?php if( 0 == $n )
										echo 'selected="selected"'; ?> value="<?php echo $n; ?>"><?php echo Kohana::lang( 'editeur.minus_level' ); ?> : <?php echo $n; ?></option>
										<?php endfor ?>
						</select>
				</div>	
				<div class="optionTilesets">	
						<div class="contener-select-bg-editor">
								<ul id="contener_selector_bg" class="jcarousel-skin-tango invis" >
										<?php echo $optionTilesetsBg; ?>
								</ul>
						</div>
				</div>
				<div class="optionTilesets">
						<input type="button" id="change" class="input-select-editor" title="<?php echo Kohana::lang( 'editeur.title_modif_img' ); ?>" value="<?php echo Kohana::lang( 'editeur.change_tileset' ); ?>" />
						<input type="hidden" value="<?php echo $optionTilesets; ?>" id="tilesets"/>
				</div>
		</div>
		<div class="clear"></div>
</div>

<div class="clear"></div>
<table cellspacing="0" cellpadding="0" width="100%" class="bg-editor">
		<tr>
				<td id="td_map">
						<div class="map">
								<div id="map">
										<div class="loading"><?php echo Kohana::lang( 'form.loading' ); ?></div>
								</div>
						</div>
				</td>
				<td valign="top" id="ContenerMenu" class="ContenerMenu">
						<div class="menu" id="menu">
								<div class="loading" style="color:#000;"><?php echo Kohana::lang( 'form.loading' ); ?></div>
						</div>
				</td>
		</tr>
</table>


<div class="clear"></div>
<div class="contextMenu" id="myMenu1" style="display:none;">
		<ul>
				<li class="titleContextuel titleContextuelNiveau"> <strong><?php echo Kohana::lang( 'editeur.contextuel_my_select' ); ?></strong> </li>
				<li id="choixNiveau"><img src="<?php echo url::base(); ?>images/editeur/level.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.contextuel_choix_niveau' ); ?></span></li>
				<?php for( $n = -3; $n <= 3; $n++ ) : ?>
						<li class="numberNiveau" style="display:none;" id="niveau_<?php echo $n; ?>"><img src="<?php echo url::base(); ?>images/picto/blank.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.contextuel_niveau', $n ); ?></span></li>
				<?php endfor ?>
				<li id="niveauSup"><img src="<?php echo url::base(); ?>images/editeur/levelSup.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.contextuel_niveau_sup' ); ?></span></li>
				<li id="niveauInf"><img src="<?php echo url::base(); ?>images/editeur/levelInf.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.contextuel_niveau_inf' ); ?></span></li>
				<li id="noSelect" style="display:none;"><img src="<?php echo url::base(); ?>images/editeur/gomme.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'form.no_select' ); ?></span></li>
				<li id="deleteSelect" style="display:none;"><img src="<?php echo url::base(); ?>images/editeur/corbeille.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'form.delete' ); ?></span></li>
				<li id="addObstacle" style="display:none;"><img src="<?php echo url::base(); ?>images/editeur/add_bloc.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.addObstacle' ); ?></span></li>
				<li id="deleteObstacle" style="display:none;"><img src="<?php echo url::base(); ?>images/editeur/delete_bloc.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.deleteObstacle' ); ?></span></li>
				<li id="addBot" style="display:none;"><img src="<?php echo url::base(); ?>images/editeur/add_bot.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.addBot' ); ?></span></li>
				<li id="deleteBot" style="display:none;"><img src="<?php echo url::base(); ?>images/editeur/delete_bot.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.deleteBot' ); ?></span></li>
				<li class="titleContextuel"> <strong><?php echo Kohana::lang( 'editeur.contextuel_racc' ); ?></strong> </li>
				<li id="moveMap" style="display:none;"><img src="<?php echo url::base(); ?>images/editeur/move.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.contextuel_move_map' ); ?></span></li>
				<li id="clickSelect"><img src="<?php echo url::base(); ?>images/editeur/multi-select.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.contextuel_click_multi_select' ); ?></span></li>
				<li id="cursoSelect"><img src="<?php echo url::base(); ?>images/editeur/cursor.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.contextuel_multi_select' ); ?></span></li>
				<li id="masqueGrille"><img src="<?php echo url::base(); ?>images/editeur/grille.png" width="20" height="20" /> <span><?php echo Kohana::lang( 'editeur.contextuel_masq_grille' ); ?></span></li>
		</ul>
</div>
<script>
		var masq_grille = '<?php echo Kohana::lang( 'editeur.contextuel_masq_grille' ); ?>',
		look_grille = '<?php echo Kohana::lang( 'editeur.contextuel_look_grille' ); ?>';
</script> 
