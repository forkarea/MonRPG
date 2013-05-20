<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<?php echo $chmod; ?>

<form id="form1" name="form1" method="post" action="<?php echo url::base( TRUE ).'import/send'; ?>" enctype="multipart/form-data">
		<article class="module width_full relative">
				<header>
						<h3 class="tabs_involved"><?php echo Kohana::lang( 'import.title' ); ?></h3>
				</header>
				<div class="module_content">
						<p><?php echo Kohana::lang( 'import.desc' ); ?></p>
						<h4><?php echo Kohana::lang( 'import.select_zip' ); ?></h4>
						<p><?php echo Kohana::lang( 'import.verif_zip' ); ?></p>
						<input name="tiled" type="file" size="50"/>
						<h4><?php echo Kohana::lang( 'import.donwload_desc' ); ?></h4>
						<a href="<?php echo url::base().'../images/tiled/exemple.zip'; ?>" ><?php echo Kohana::lang( 'import.donwload_title' ); ?></a>
						<div class="center"><img src="<?php echo url::base().'../images/tiled/arbo.png'; ?>" /></div>
						<h4><?php echo Kohana::lang( 'import.donwload_link' ); ?></h4>
						<ul>
								<li><a href='http://sourceforge.net/projects/tiled/files/tiled-qt/0.7.1/tiled-0.7.1-win32-setup.exe'>Tiled Qt 0.7.1 for Windows</a></li>
								<li><a href='http://sourceforge.net/projects/tiled/files/tiled-qt/0.7.1/tiled-qt-0.7.1.dmg'>Tiled Qt 0.7.1 for Mac OS X</a></li>
								<li><a href='http://sourceforge.net/projects/tiled/files/tiled-qt/0.7.1/tiled-qt-0.7.1.tar.gz'>Tiled Qt 0.7.1 source</a></li>
								<li><a href='https://launchpad.net/~duck-wallace/+archive/tiled'>Ubuntu Lucid/Maverick PPA</a></li>
						</ul>
						<h4><?php echo Kohana::lang( 'import.config' ); ?></h4>
						<p><?php echo Kohana::lang( 'import.think' ); ?></p>
						<div class="center"><img src="<?php echo url::base().'../images/tiled/import.png'; ?>" /></div>
				</div>
				<footer>
						<div class="submit_link">
								<input type="reset" value="<?php echo Kohana::lang( 'form.reset' ); ?>">
								<input type="submit" value="<?php echo Kohana::lang( 'import.submit' ); ?>" class="button button-normal alt_btn" style="margin-right:5px" />
						</div>
				</footer>
				<div class="clear"></div>
		</article>
</form>