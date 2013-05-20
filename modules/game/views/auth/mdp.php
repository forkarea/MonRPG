<?php defined( 'SYSPATH' ) or die( 'No direct access allowed.' ); ?>

<div class="titreForm">
		<div class="titreCentent"><?php echo Kohana::lang( 'logger.send_password' ); ?></div>
		<div class="spacer"></div>
</div>

<form id="formMDP"  method="post" action="send">
		<div class="contentForm">
				<p><?php echo Kohana::lang( 'logger.desc_password' ); ?></p>
				<table class="contener-content">
						<tr>
								<td><label for="emailMDP"><?php echo Kohana::lang( 'logger.mail_user' ); ?></label></td>
								<td class="right"><input name="emailMDP" type="text" class="input-text" id="emailMDP" value="" size="30"/></td>
						</tr>
						<tr>
								<td><?php echo $captcha; ?></td>
								<td class="right"><b class="rouge"><?php echo Kohana::lang( 'logger.label_captcha' ); ?></b>
										<input name="captcha_response" id="captcha_response" value="" type="text" maxlength="4" class="input-text"/></td>
						</tr>
				</table>

		</div>
		<div class="footerForm" id="footerForm">
				<input type="button" class="button close" value="<?php echo Kohana::lang( 'form.close' ); ?>"/>
				<input name="submitMDP" id="submitMDP" value="<?php echo Kohana::lang( 'logger.button_send_mail' ); ?>" type="submit" class="button"/>
		</div>
</form>
<script>
		$(function(){
				$('#formMDP').validate({
						rules: {
								emailMDP: {
										required: true,
										email: true
								}
						},
						messages: {
								emailMDP: email_required
						}
				});		
		});
</script>