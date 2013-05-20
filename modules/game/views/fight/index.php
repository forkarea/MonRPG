<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div id="contenerActionGlobal" class="background-fight" style="background-image:url(<?php echo $terrain; ?>)">
		<div class="vignetteBot vignette" style="background-image:url('<?php echo url::base(); ?>images/faceset/<?php echo $bot->image; ?>');"></div>
		<div class="vignetteUser vignette" style="background-image:url('<?php echo url::base(); ?>images/faceset/<?php echo $user->avatar; ?>');"></div>
		<div class="persoBot perso" style="background-image:url('<?php echo url::base(); ?>images/character/<?php echo $bot->image; ?>');"></div>
		<div class="persoUser perso" style="background-image:url('<?php echo url::base(); ?>images/character/<?php echo $user->avatar; ?>');"></div>
		<div class="infoBot info">
				<table>
						<tr>
								<td><div id="infoBotHP"><?php echo graphisme::BarreGraphique( $bot->hp, $bot->hp_max, Kohana::config( 'fight.taille_barre_info_for_fight' ) ); ?></div></td>
								<td><?php echo Kohana::lang( 'user.hp' ); ?></td>
						</tr>
						<tr>
								<td><div id="infoBotMP"><?php echo graphisme::BarreGraphique( $bot->mp, $bot->mp_max, Kohana::config( 'fight.taille_barre_info_for_fight' ) ); ?></div></td>
								<td><?php echo Kohana::lang( 'user.mp' ); ?></td>
						</tr>
				</table>
		</div>
		<div class="infoUser info">
				<table>
						<tr>
								<td><?php echo Kohana::lang( 'user.hp' ); ?></td>
								<td><div id="infoUserHP"><?php echo graphisme::BarreGraphique( $user->hp, $user->hp_max, Kohana::config( 'fight.taille_barre_info_for_fight' ) ); ?></div></td>
						</tr>
						<tr>
								<td><?php echo Kohana::lang( 'user.mp' ); ?></td>
								<td><div id="infoUserMP"><?php echo graphisme::BarreGraphique( $user->mp, $user->mp_max, Kohana::config( 'fight.taille_barre_info_for_fight' ) ); ?></div></td>
						</tr>
				</table>
		</div>
		<div class="infoBar"></div>
		<div class="infoVS"><img src="<?php echo url::base(); ?>images/sorts/vs.png" width="60" height="60" /></div>
		<div class="effectBot effect" id="effectBot"></div>
		<div class="effectUser effect" id="effectUser"></div>
		<div class="contentSort">
				<div class="buttonActiobSort" id="0-17_5-0" title="Pouvoir de l'aube" style="background-image:url('<?php echo url::base(); ?>images/sorts/pouvoirAube.png');"></div>
				<?php if( $sorts ) : ?>
						<?php foreach( $sorts as $sort ) : ?>
								<div class="buttonActiobSort" id="<?php echo $sort->id.'-'.$sort->effect.'-'.$sort->mp; ?>" title="<?php echo $sort->name; ?><br/><?php echo $sort->mp.' '.Kohana::lang( 'user.mp' ); ?>" style="background-image:url('<?php echo url::base(); ?>images/sorts/<?php echo $sort->image; ?>');">
										<?php if( $sort->mp > $user->mp )
												echo '<img src="'.url::base().'images/sorts/no.png" width="30" height="30" />'; ?>
								</div>
						<?php endforeach ?>
				<?php endif ?>
		</div>
</div>
<div class="menu">
		<div ><?php echo isset( $menu ) ? $menu : false; ?></div>
		<div class="spacer"></div>
</div>
<div class="spacer"></div>
<div id="idBot" class="invis"><?php echo $bot->id; ?></div>
<script>
		var sort_bot = new Array(<?php echo $sorts_bot; ?>),
		id_bot = <?php echo $bot->id; ?>;
	
		autoBotAttack();
	
		if( music_fight != '')
				audio(music_fight);
</script>
