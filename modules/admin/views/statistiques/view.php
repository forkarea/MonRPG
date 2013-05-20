<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.stat' ); ?></h3>
		</header>
		<table id="json_items" class="datatable" cellspacing="0">
				<tbody>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_user' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_user ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_role' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_role ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_bot' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_bot ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_item' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_item ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_region' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_region ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_sort' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_sort ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_article' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_article ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_cat_article' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_cat_article ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_quete' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_quete ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_module' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_php' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_php ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_article' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_article ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_fight' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_fight ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_html' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_html ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_move' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_move ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_object' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_object ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_quete' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_quete ); ?></strong></td>
						</tr>
						<tr class="even">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_shop' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_shop ); ?></strong></td>
						</tr>
						<tr class="odd">
								<td><?php echo Kohana::lang( 'statistique.nbr_module_sleep' ); ?></td>
								<td width="300"><strong><?php echo number_format( $global->nb_module_sleep ); ?></strong></td>
						</tr>
				</tbody>
		</table>
		<div class="clear"></div>
</article>