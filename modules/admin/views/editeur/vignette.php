<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>

<div class="titreForm">
		<div style="float:right; margin-top:3px;"><a href="<?php echo url::base(TRUE); ?>ftp?dir=/images/tilesets">Gerer</a></div>
		<div class="titreCentent"><?php	echo	Kohana::lang(	'form.title_selected'	);	?></div>
</div>
<div class="contentForm">
		<?php	if(	$images	)	:	?>
				<?php	foreach(	$images	as	$row	)	:	?>
						<?php	foreach(	$row	as	$val	)	:	?>
								<img src="<?php	echo	url::base();	?>../images/tilesets/<?php	echo	$val;	?>" id="<?php	echo	$val;	?>" width="96" height="" alt="" class="vign_mod close <?php	echo	$val	==	$selected	?	'selected'	:	false;	?>" />
						<?php	endforeach	?>
						<hr/>
						<div class="spacer"></div>
				<?php	endforeach	?>
		<?php	endif	?>
		<div class="spacer"></div>
</div>
<div class="footerForm">
		<input type="button" class="button close" value="<?php	echo	Kohana::lang(	'form.annul'	);	?>"/>
</div>
