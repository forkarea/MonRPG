<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>
<?php	if(	$data->image	)	:	?>
		<div class="avatarAction" id="avatarAction" style="background-image:url('<?php	echo	url::base();	?>images/modules/<?php	echo	$data->image;	?>');"></div>
<?php	endif	?>
<div class="contenerActionStat">
		<h1><?php	echo	$data->nom;	?></h1>
		<p><?php	echo	Kohana::lang(	'sort.desc_maitre_sort'	);	?></p>
</div>
<div class="bontonActionRight">
		<input type="button" class="button button_vert" id="show_sort" value="<?php	echo	Kohana::lang(	'sort.button_maitre'	);	?>"/>
</div>
<div class="spacer"></div>
<script>
		$(function(){ $('#show_sort').click(function() {  $('#commandActionContent').load( url_script+'actions/sort/show' ); }); });
</script> 

