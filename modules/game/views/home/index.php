<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="map-contener" id="mapContener">
		<div class="map" id="map"><?php echo isset( $map ) ? $map : false; ?></div>
		<div class="action-contener invis" id="commandAction">
				<div class="blockAction">
						<img class="closeAction" src="<?php echo url::base(); ?>images/orther/close.png" alt="close" />
						<div class="clear"></div>
						<div id="commandActionContent"></div>
				</div>
		</div>
		<div id="tchat_global">
				<div class="tchat-menu" id="tchat-menu">
						<label for="msgTchat"><?php echo Kohana::lang('form.dicute'); ?></label><br/>
						<div id="tchat" class="tchat-content invis">
								<div id="slide-chat"></div>
						</div>
						<input id="msgTchat" type="text" class="inputbox" maxlength="100" />
						<div class="clear"></div>
				</div>
		</div>
</div>
