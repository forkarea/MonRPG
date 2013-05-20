<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<h3><?php echo Kohana::lang('fight.victory');?></h3>
<p><?php echo Kohana::lang('fight.victory_desc');?> :</p>
<ul>
		<li><?php echo $money; ?></li>
		<li><?php echo $xp; ?></li>
		<li><?php echo $money; ?></li>
</ul>
<script>
		refresh();
		send_bot_socket( 'kill-bot', 0, 0, 0, 0, <?php echo $bot_id; ?>);
		audio('grelot.ogg', true);
</script>