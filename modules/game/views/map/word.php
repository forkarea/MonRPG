<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<?php $style = 'background-image:url(\''.url::base().'images/character/'.$user->avatar.'\'); left:'.$cssPersoX.'px; top:'.$cssPersoY.'px;'; ?>

<div id="myUser" class="myUser" style="<?php echo $style; ?>"></div>
<div class="map_coordonne">
		<?php if( $admin ) : ?>
				<a href="<?php echo url::base(); ?>admin/index.php/editeur/show/<?php echo $user->region_id; ?>"  title="<?php echo Kohana::lang( 'form.edit' ); ?>" target="blank"><img src="<?php echo url::base(); ?>images/orther/edit.png"  alt="<?php echo Kohana::lang( 'form.edit' ); ?>"/></a>&nbsp;
		<?php endif; ?>
				<span><?php echo $region; ?></span> <span id="coordonne_x_y"><?php echo $user->x; ?> - <?php echo $user->y; ?></span>
				&nbsp;<img src="<?php echo url::base(); ?>images/orther/sound.png"  alt="Audio" id="control_sound" class="invis"/>
		</div>
<div id="tableMap" class="tableMap" style="left:<?php echo $cssMapX; ?>px; top:<?php echo $cssMapY; ?>px; width:<?php echo Kohana::config( 'map.taille_case' ) * $tailleMapX; ?>px; height:<?php echo Kohana::config( 'map.taille_case' ) * $tailleMapY; ?>px;">
		<div class="niveau_-1"  style="position:absolute; width:<?php echo Kohana::config( 'map.taille_case' ) * $tailleMapX; ?>px; height:<?php echo Kohana::config( 'map.taille_case' ) * $tailleMapY; ?>px; background-image:url('<?php echo url::base(); ?>images/map/<?php echo $user->region_id; ?>_inf.png');"></div>
		<div class="niveau_1"  style="position:absolute; width:<?php echo Kohana::config( 'map.taille_case' ) * $tailleMapX; ?>px; height:<?php echo Kohana::config( 'map.taille_case' ) * $tailleMapY; ?>px; background-image:url('<?php echo url::base(); ?>images/map/<?php echo $user->region_id; ?>_sup.png');"></div>
		<?php
		$js = FALSE;

		for( $y = 0; $y < $tailleMapY; $y++ )
		{
				$js .= 'obstacle['.$y.'] = new Array();';

				for( $x = 0; $x < $tailleMapX; $x++ )
				{
						$positionDiv = 'top:'.(Kohana::config( 'map.taille_case' ) * $y).'px; left:'.(Kohana::config( 'map.taille_case' ) * $x).'px;';

						$js .= 'obstacle['.$y.']['.$x.'] = '.(isset( $obstacle[$x.'-'.$y] ) && $obstacle[$x.'-'.$y]->passage_map != 1 ? 1 : 0).';';

						if( isset( $obstacle[$x.'-'.$y] ) && $obstacle[$x.'-'.$y]->module_map )
								echo '<div id="action-'.$x.'-'.$y.'" class="elements niveau_2" data-rel="'.$obstacle[$x.'-'.$y]->module_map.'" title="'.$obstacle[$x.'-'.$y]->nom_map.'" style=" '.$positionDiv.'"></div>'."\n";

						if( isset( $bots[$x.'-'.$y] ) && ( $bot = $bots[$x.'-'.$y]) )
								echo '<div id="bot-'.$bot->id.'" class="bots dispo" style="background-image:url(\''.url::base().'images/character/'.$bot->image.'\'); '.$positionDiv.'"></div>'."\n";

						if( isset( $otherUsers[$x.'-'.$y] ) && ( $otherUser = $otherUsers[$x.'-'.$y]) )
								echo '<div id="otherUser-'.$otherUser->id.'" class="otherUsers" style="background-image:url(\''.url::base().'images/character/'.$otherUser->avatar.'\');  '.$positionDiv.'"><div class="usernameUsers">'.$otherUser->username.'</div></div>'."\n";
				}
		}
		?>
</div>
<audio id="audio" preload autobuffer loop/>
<audio id="audio_other" preload autobuffer />
<script>
		var maxBot = <?php echo $maxBot; ?>,
		music = '<?php echo $music; ?>',
		music_fight = '<?php echo $music_fight; ?>',
		id_user = <?php echo $user->id; ?>,
		id_region = <?php echo $user->region_id; ?>,
		user_username = '<?php echo $user->username; ?>';
		user_avatar = '<?php echo url::base(); ?>images/character/<?php echo $user->avatar; ?>';
		obstacle = new Array();
		
<?php echo $js; ?>		
		
</script>
