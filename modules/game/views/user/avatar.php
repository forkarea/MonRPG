<?php defined( 'SYSPATH' ) or die( 'No direct access allowed.' ); ?>

<div class="titreForm">
		<div class="titreCentent"><?php echo Kohana::lang('user.modif_avatar'); ?></div>
		<div class="spacer"></div>
</div>
<form id="formInscript" method="post" action="user/avatar" >
		<div class="contentForm">
				<?php foreach( $avatar as $row ) : ?>
						<div class="avatar_modif close" id="<?php echo $row; ?>" style="background-image:url('<?php echo url::base(); ?>images/character/<?php echo $row; ?>');"></div>
				<?php endforeach ?>
				<div class="spacer"></div>
		</div>
		<div class="footerForm" id="footerForm">
				<input type="button" class="button close" value="<?php echo Kohana::lang( 'form.close' ); ?>"/>
		</div>
</form>
