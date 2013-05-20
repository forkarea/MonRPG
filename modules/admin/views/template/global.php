<?php defined( 'SYSPATH' ) or die( 'No direct access allowed.' ); ?>
<!doctype html>
<html lang="en">
		<head>
				<meta charset="utf-8"/>
				<title>Dashboard I Admin Panel</title>
				<?php
				echo isset( $script ) ? $script : FALSE;
				echo isset( $css ) ? $css : FALSE;
				?>
		</head>
		<body>
				<header id="header">
						<hgroup>
								<h1 class="site_title"><a href="<?php echo url::base( TRUE ); ?>"><?php echo Kohana::config( 'game.name' ); ?></a></h1>
								<h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="/">Voir le jeu</a></div>
						</hgroup>
				</header>
				<section id="secondary_bar">
						<div class="user">
								<p><?php echo isset($username) ? $username : FALSE; ?></p>
								<a class="logout_user" id="hideShowMenu" href="javascript:;" title="Logout">Masquer Le menu</a>
						</div>
						<div class="breadcrumbs_container">
								<article class="breadcrumbs">
										<?php echo isset( $titre ) && $titre ? $titre : FALSE; ?>
								</article>
						</div>
				</section>
				<aside id="sidebar" class="column">
						<?php echo isset( $menu ) ? $menu : FALSE; ?>	
				</aside>
				<section id="main" class="column">
						<?php if( $msg ) : ?>
								<h4 class="alert_info" id="msg"><?php echo $msg; ?></h4>
						<?php endif ?>
						<?php echo isset( $contenu ) ? $contenu : FALSE; ?>
						<div class="clear"></div>
						<?php if( isset( $button ) && $button ) : ?>
								<div class="button_valid_bottom">
										<div class="button_valid_content"><?php echo $button; ?></div>
								</div>
						<?php endif ?>
				</section>
				<div class="clear"></div>
				<footer id="footer"></footer>
		</body>
</html>
