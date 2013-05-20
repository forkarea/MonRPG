<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<?php echo $chmod; ?>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.export' ); ?></h3>
		</header>
		<table id="json_items" class="datatable" cellspacing="0">
				<tbody>
						<?php $n = 0; ?>
						<?php if( $listing ) : ?>
								<?php foreach( $listing as $row ) : ?>
										<?php $n++; ?>
										<tr class="<?php echo $n % 2 == 0 ? 'odd' : 'even'; ?>">
												<td width="200"><?php echo html::anchor( 'export/send/'.$row->id, html::image( '../images/map/'.$row->id.'_global.png', array( 'height' => 40 ) ) ); ?></td>
												<td><?php echo html::anchor( 'export/send/'.$row->id, $row->name ); ?></td>
												<td class="center" width="150"><?php
						echo html::anchor( 'export/send/'.$row->id, html::image( 'images/template/icn_folder.png', array( 'title' => Kohana::lang( 'form.export' ), 'class' => 'icon_list' ) ) )
						.' '.html::anchor( 'editeur/show/'.$row->id, html::image( 'images/template/drawings.png', array( 'title' => Kohana::lang( 'form.edit' ), 'class' => 'icon_list' ) ) )
						.' '.html::anchor( 'regions/show/'.$row->id, html::image( 'images/template/icn_settings.png', array( 'title' => Kohana::lang( 'form.params' ), 'class' => 'icon_list' ) ) );
										?></td>
										</tr>
								<?php endforeach ?>
						<?php endif ?>
				</tbody>
		</table>
		<div class="clear"></div>
</article>
<div class="spacer"></div>
