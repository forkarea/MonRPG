<?php defined( 'SYSPATH' ) or die( 'Access non autoris&eacute;.' ); ?>

<?php
if( in_array( 'item', $acces )
				|| in_array( 'carte', $acces )
				|| in_array( 'sort', $acces )
				|| in_array( 'article', $acces )
				|| in_array( 'quete', $acces )
				|| in_array( 'element', $acces )
				|| in_array( 'user', $acces )
				|| in_array( 'admin', $acces ) ) :
		?>
		<h3><?php echo Kohana::lang( 'menu.gest_ele' ); ?></h3>
		<ul class="toggle">
				<?php if( in_array( 'user', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_view_users"><?php echo html::anchor( 'users', Kohana::lang( 'menu.users' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'carte', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_world"><?php echo html::anchor( 'regions', Kohana::lang( 'menu.map' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'article', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_edit_article"><?php echo html::anchor( 'articles', Kohana::lang( 'menu.article' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'element', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_mod "><?php echo html::anchor( 'elements', Kohana::lang( 'menu.element' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'quete', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_quete"><?php echo html::anchor( 'quetes', Kohana::lang( 'menu.quete' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'item', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_object"><?php echo html::anchor( 'items', Kohana::lang( 'menu.item_game' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'sort', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_sort"><?php echo html::anchor( 'sorts', Kohana::lang( 'menu.sort_fight' ) ); ?></li>
				<?php endif ?>
		</ul>
		<div class="clear"></div>
		<hr/>
		<h3 id="add_menu"><?php echo Kohana::lang( 'menu.add' ); ?></h3>
		<ul class="toggle invis">
				<?php if( in_array( 'user', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_add_user"><?php echo html::anchor( 'users/insert', Kohana::lang( 'menu.add_users' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'carte', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_world_add"><?php echo html::anchor( 'regions/insert', Kohana::lang( 'menu.add_map' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'article', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_edit_article_add"><?php echo html::anchor( 'articles/insert', Kohana::lang( 'menu.add_article' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'quete', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_quete_add"><?php echo html::anchor( 'quetes/insert', Kohana::lang( 'menu.add_quete' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'item', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_object_add"><?php echo html::anchor( 'items/insert', Kohana::lang( 'menu.add_item_game' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'sort', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_sort_add"><?php echo html::anchor( 'sorts/insert', Kohana::lang( 'menu.add_sort_fight' ) ); ?></li>
				<?php endif ?>
		</ul>
		<div class="clear"></div>
		<hr/>
<?php endif ?>	
<?php
if( in_array( 'ftp', $acces )
				|| in_array( 'tileset', $acces )
				|| in_array( 'carte', $acces )
				|| in_array( 'admin', $acces ) ) :
		?>
		<h3 id="tool_menu"><?php echo Kohana::lang( 'menu.tool' ); ?></h3>
		<ul class="toggle invis">
				<?php if( in_array( 'ftp', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_folder"><?php echo html::anchor( 'ftp', Kohana::lang( 'menu.ftp' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'import', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_tileset"><?php echo html::anchor( 'import', Kohana::lang( 'menu.import' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'export', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_tileset"><?php echo html::anchor( 'export', Kohana::lang( 'menu.export' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'tileset', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_tileset"><?php echo html::anchor( 'tilesets', Kohana::lang( 'menu.tileset' ) ); ?></li>
						<li class="icn_character"><?php echo html::anchor( 'character', Kohana::lang( 'menu.character' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'carte', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_gen_map"><?php echo html::anchor( 'cache/map', Kohana::lang( 'menu.cache_map' ) ); ?></li>
				<?php endif ?>
		</ul>
		<div class="clear"></div>
		<hr/>
<?php endif ?>
<h3><?php echo Kohana::lang( 'menu.admin' ); ?></h3>
<ul class="toggle">
		<?php
		if( in_array( 'statistique', $acces )
						|| in_array( 'cache', $acces )
						|| in_array( 'config', $acces )
						|| in_array( 'admin', $acces ) ) :
				?>
				<?php if( in_array( 'admin', $acces ) ) : ?>
						<li class="icn_install"><?php echo html::anchor( 'install', Kohana::lang( 'menu.install' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'statistique', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_statistics"><?php echo html::anchor( 'statistiques', Kohana::lang( 'menu.stat' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'config', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_settings"><?php echo html::anchor( 'config', Kohana::lang( 'menu.config' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'cache', $acces ) || in_array( 'admin', $acces ) ) : ?>
						<li class="icn_refresh"><?php echo html::anchor( 'cache/deleteAll', Kohana::lang( 'menu.cache' ) ); ?></li>
				<?php endif ?>
				<?php if( in_array( 'admin', $acces ) ) : ?>
						<li class="icn_database"><?php echo html::anchor( 'purge', Kohana::lang( 'menu.purge' ) ); ?></li>
				<?php endif ?>
		<?php endif ?>
		<li class="icn_help"><a href="http://docs.openrpg.fr/creer-son-jeu"><?php echo Kohana::lang( 'menu.doc' ); ?></a></li>
		<li class="icn_twitter"><a href="http://twitter.com/#!/wubart"><?php echo Kohana::lang( 'menu.twitter' ); ?></a></li>
		<li class="icn_jump_back"><a href="<?php echo url::base( TRUE ); ?>logout"><?php echo Kohana::lang( 'menu.quit_admin' ); ?></a></li>
</ul>
<div class="clear"></div>
<hr />
<footer>
		<p><strong>Copyright &copy; 2011 Pasquelin Alban</strong></p>
		<p>Créé par <a href="http://www.openrpg.fr">Open RPG</a></p>
</footer>