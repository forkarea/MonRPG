<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>

<h1><?php	echo	$data->nom	?	$data->nom	:	Kohana::lang(	'sort.title_view'	);	?></h1>
<?php	if(	$listSort	)	:	?>
		<form id="formBuy">
				<table width="100%" class="table_shop">
						<?php	foreach(	$listSort	as	$row	)	:	?>
								<?php	if(	$row->niveau	<=	$user->niveau	&&	!isset(	$sortListUser[$row->id]	)	)	:	?>
										<tr>
												<td width="30"><img src="<?php	echo	url::base();	?>images/sorts/<?php	echo	$row->image;	?>" width="24" height="24" /></td>
												<td><label for="sort_<?php	echo	$row->id;	?>"><span class="titreSpanForm"><?php	echo	$row->name;	?></span></label></td>
												<td align="right" width="160" class="<?php	echo	$row->attack_max	?	'vert'	:	'rouge';	?>"><?php	echo	Kohana::lang(	'user.scr_attack'	).' '.$row->attack_min.'/'.$row->attack_max;	?> pt(s)</td>
												<td align="right" width="70" class="<?php	echo	$row->mp	?	'vert'	:	'rouge';	?>"><?php	echo	$row->mp.' '.Kohana::lang(	'user.mp'	);	?></td>
												<td align="right" width="70" class="orange"><span class="prix"><?php	echo	$row->prix;	?></span> <?php	echo	Kohana::config(	'game.money'	);	?></td>
												<td align="right" width="40">
														<select class="input-select select_sort" name="sort[<?php	echo	$row->id;	?>]">
																<option value="0" class="rouge">--</option>
																<option value="1" class="vert">1</option>
														</select>
												</td>
										</tr>
								<?php	endif	?>
						<?php	endforeach	?>
						<tr>
								<td colspan="5" align="right"><strong class="rouge"><?php	echo	Kohana::lang(	'sort.total'	);	?></strong></td>
								<td align="right"><span id="prix_total">0</span> <?php	echo	Kohana::config(	'game.money'	);	?></td>
						</tr>
				</table>
		</form>
		<div class="formButton" id="show_buy" style="display:none">
				<input type="hidden" id="argent_user" value="<?php	echo	$user->argent;	?>"/>
				<input type="button" id="buy_sort" class="button button_vert" value="<?php	echo	Kohana::lang(	'sort.button_buy'	);	?>"/>
		</div>
<?php	endif	?>