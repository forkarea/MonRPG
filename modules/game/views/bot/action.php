<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="avatarAction" id="avatarAction" style="background-image:url('<?php echo url::base(); ?>images/faceset/<?php echo $bot->image; ?>'); background-position:0px 0px;"></div>
<div class="contenerActionStat">
		<h1><?php echo isset( $title ) && $title ? $title : Kohana::lang( 'bot.title_bot' ); ?></h1>
		<table border="0" width="420px" cellpadding="3" cellspacing="2">
				<tr>
						<td><strong><?php echo Kohana::lang( 'user.hp' ); ?> : </strong></td>
						<td><?php echo graphisme::BarreGraphique( $bot->hp, $bot->hp_max, Kohana::config( 'bot.taille_barre_info_for_bot' ) ); ?></td>
						<td><strong><?php echo Kohana::lang( 'user.level' ); ?> : </strong></td>
						<td><?php echo $bot->niveau; ?></td>
				</tr>
				<tr>
						<td><strong><?php echo Kohana::lang( 'user.mp' ); ?> : </strong></td>
						<td><?php echo graphisme::BarreGraphique( $bot->mp, $bot->mp_max, Kohana::config( 'bot.taille_barre_info_for_bot' ) ); ?></td>
						<td><strong><?php echo Kohana::lang( 'user.money' ); ?> : </strong></td>
						<td><?php echo number_format( $bot->argent ).' '.Kohana::config( 'game.money' ); ?></td>
				</tr>
		</table>
</div>
<div class="bontonActionRight">
		<input type="button" id="lancerBot" value="<?php echo Kohana::lang( 'bot.start_attack' ); ?>" class="button button_vert"/>
</div>
<div class="spacer"></div>
<div id="idBot" class="invis"><?php echo $bot->id; ?></div>
<script>
		$('#lancerBot').hover(
				function () { $('#avatarAction').css('background-position', '-96px 0px');  }, 
				function () { $('#avatarAction').css('background-position','0px 0px'); }
		).click(
				function(){ $('#commandActionContent').load( url_script+'fight/bot/<?php echo $bot->id; ?>' );  }
		);
</script> 
