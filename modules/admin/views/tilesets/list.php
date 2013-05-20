<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.item_game' ); ?></h3>
		</header>
		<table id="json_items" class="datatable" cellspacing="0">
				<thead>
						<tr>
								<th width="200"><?php echo Kohana::lang( 'tileset.name_file' ); ?></th>
								<th width="50"><?php echo Kohana::lang( 'tileset.horizon' ); ?></th>
								<th width="50"><?php echo Kohana::lang( 'tileset.vertical' ); ?></th>
								<th width="50"><?php echo Kohana::lang( 'tileset.type' ); ?></th>
						</tr>
				</thead>
				<tbody>
						<?php foreach( $images as $row ) : ?>
								<?php
								$size = getimagesize( $chemin.$row );
								$n++;
								?>
								<tr class="<?php echo $n % 2 == 0 ? 'odd' : 'even'; ?>">
										<td><?php echo html::anchor( '/tilesets/show/'.urlencode( $row ), $row ); ?></td>
										<td align="center" class="<?php echo $size[0] == 256 ? 'vert' : 'rouge'; ?>"><?php echo $size[0]; ?>px</td>
										<td align="center" class="<?php echo $size[0] <= 1200 ? 'vert' : 'rouge'; ?>"><?php echo $size[1]; ?>px</td>
										<td align="center"><?php echo image_type_to_mime_type( $size[2] ); ?></td>
								</tr>
						<?php endforeach ?>
				</tbody>
		</table>
		<div class="clear"></div>
</article>
<div class="spacer"></div>