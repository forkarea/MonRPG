<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="content-user">
		<div id="user_hp" class="donnee"><?php echo graphisme::BarreGraphique( $user->hp, $user->hp_max, 160, Kohana::lang( 'user.hp' ) ); ?></div>
</div>
<div class="spacer"></div>
<div class="content-user">
		<div id="user_mp" class="donnee"><?php echo graphisme::BarreGraphique( $user->mp, $user->mp_max, 160, Kohana::lang( 'user.mp' ) ); ?></div>
</div>
<div class="spacer"></div>
<div class="option-user">
		<span class="titre"><?php echo Kohana::lang( 'user.money' ); ?> :</span> <span id="user_argent"><?php echo number_format( $user->argent ).' '.Kohana::config( 'game.money' ); ?></span>
</div>
<div class="option-user">
		<span class="titre"><?php echo Kohana::lang( 'user.level' ); ?> :</span> <span id="user_niveau"><?php echo $user->niveau; ?></span>
</div>