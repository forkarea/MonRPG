<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<div id="slider"> 
		<div id="mask"> 
        <ul id="image_container"> 
						<li><img src="<?php echo url::base(); ?>images/homepage/1.png" alt="monrpg"/></li> 
						<li><img src="<?php echo url::base(); ?>images/homepage/2.png" alt="monrpg" /></li> 
						<li><img src="<?php echo url::base(); ?>images/homepage/3.png" alt="monrpg" /></li> 
        </ul> 
		</div> 
</div> 
<div class="description"><?php echo Kohana::config( 'game.description' ); ?></div>
<div class="mod_home">
		<?php if( $top_user ) : ?>
				<h3><?php echo Kohana::lang( 'template.top_user' ); ?></h3>
				<?php foreach( $top_user as $row ) : ?>
						<div class="row_top_user">
								<div class="avatar_top_user" style="background-image:url('<?php echo url::base(); ?>images/character/<?php echo $row->avatar; ?>');"></div>
								<div class="username_top_user"><?php echo $row->username; ?></div>
								<div class="niveau_top_user"> <?php echo Kohana::lang( 'user.level' ).' : '.$row->niveau; ?></div>
								<div class="spacer"></div>
						</div>
				<?php endforeach ?>
		<?php endif ?>
</div>
<div id="auth-content" class="mod_home border_left_right">
		<?php if( $top_item ) : ?>
				<h3><?php echo Kohana::lang( 'template.top_item' ); ?></h3>
				<?php foreach( $top_item as $row ) : ?>
						<div class="row_top_user">
								<div class="img_top" style="background-image:url('<?php echo url::base(); ?>images/items/<?php echo $row->image; ?>');"></div>
								<div class="username_top_user"><?php echo $row->name; ?></div>
								<div class="niveau_top_user"> <?php echo $row->prix; ?> <?php echo Kohana::config( 'game.money' ); ?></div>
								<div class="spacer"></div>
						</div>
				<?php endforeach ?>
		<?php endif ?>
</div>
<div class="mod_home">
		<?php if( $top_sort ) : ?>
				<h3><?php echo Kohana::lang( 'template.top_sort' ); ?></h3>
				<?php foreach( $top_sort as $row ) : ?>
						<div class="row_top_user">
								<div class="img_top" style="background-image:url('<?php echo url::base(); ?>images/sorts/<?php echo $row->image; ?>');"></div>
								<div class="username_top_user"><?php echo $row->name; ?></div>
								<div class="niveau_top_user"> <?php echo $row->prix; ?> <?php echo Kohana::config( 'game.money' ); ?></div>
								<div class="spacer"></div>
						</div>
				<?php endforeach ?>
		<?php endif ?>
</div>
<div class="spacer"></div>
<script>
		var username_required = "<?php echo Kohana::lang( 'form.name_required' ); ?>",
		username_minlength = "<?php echo Kohana::lang( 'form.name_minlength' ); ?>",
		username_maxlength = "<?php echo Kohana::lang( 'form.name_maxlength' ); ?>",
		password_required = "<?php echo Kohana::lang( 'form.password_required' ); ?>",
		password_minlength = "<?php echo Kohana::lang( 'form.password_minlength' ); ?>",
		email_required = "<?php echo Kohana::lang( 'form.email_required' ); ?>",
		email_equalTo = "<?php echo Kohana::lang( 'form.email_equalTo' ); ?>";
</script> 
