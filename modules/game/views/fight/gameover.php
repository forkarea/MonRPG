<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<h1><?php echo Kohana::lang('fight.gameover'); ?></h1>
<p><?php echo Kohana::lang('fight.gameover_desc'); ?></p>
<script>
		refresh();
		audio('douleur.ogg', true);
</script>