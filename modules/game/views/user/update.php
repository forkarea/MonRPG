<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<?php if( isset( $modif ) && $modif ) : ?>
		<div class="panel">
				<div id="content_pwd">
						<div class="row_stat_user">
								<div class="title_stat_user"><?php echo Kohana::lang('user.modif_avatar'); ?> : </div>
								<div class="info_stat_user"><input type="button" value="Modifier mon avatar" id="modif_avatar" class="button" /></div>
								<div class="spacer"></div>
						</div>
						<div class="title_stat_user"><label for="new_pwd"><?php echo Kohana::lang('user.new_password'); ?> :</label></div>
						<div class="info_stat_user"><input type="password" class="input-text" name="new_pwd" id="new_pwd" /></div>
						<div class="spacer"></div>
						<div class="title_stat_user"><label for="repeat_new_pwd"><?php echo Kohana::lang('user.verif_password'); ?> :</label></div>
						<div class="info_stat_user"><input type="password" class="input-text" name="repeat_new_pwd" id="repeat_new_pwd" /></div>
						<div class="spacer"></div>
						<div class="modif_password"><input type="button" value="<?php echo Kohana::lang('user.modif_password'); ?>" id="modif_pwd" class="button" /></div>
				</div>
				<div class="spacer"></div>
		</div>
<?php endif ?>