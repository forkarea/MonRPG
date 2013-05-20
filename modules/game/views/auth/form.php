<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<div class="contener-form">
		<form method="post" action="<?php echo url::site( 'login' ); ?>" id="formAuth">
						<label for="username"><?php echo Kohana::lang( 'logger.label_identify' ); ?></label>
						<input name="username" id="username" class="input-text" type="text" />
						<label for="password" ><?php echo Kohana::lang( 'logger.label_password' ); ?></label>
						<input name="password" id="password" class="input-text" type="password"/>
						<input type="submit" value="<?php echo Kohana::lang( 'logger.label_connexion' ); ?>" class="button"/>
		</form>
</div>
<div  class="lien-top"><a href="javascript:;" id="subscribe"><?php echo Kohana::lang( 'logger.subscribe' ); ?></a><br/><a href="javascript:;" id="mdp"><?php echo Kohana::lang( 'logger.send_password' ); ?></a></div>
