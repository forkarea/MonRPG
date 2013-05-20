<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="titreForm"><?php echo Kohana::lang( 'editeur.help_title' ); ?></div>
<div class="contentForm">
		<h3><?php echo Kohana::lang( 'editeur.racc_clavier' ); ?></h3>
		<ul class="ulHelp">
				<li><img src="<?php echo url::base(); ?>images/editeur/move.png" height="16" align="absmiddle" /><span class="quick_help">CTRL + D</span> : <?php echo Kohana::lang( 'editeur.ctrl_d' ); ?></li>
				<li><img src="<?php echo url::base(); ?>images/editeur/multi-select.png" height="16" align="absmiddle" /><span class="quick_help">CTRL + A</span> : <?php echo Kohana::lang( 'editeur.ctrl_a' ); ?></li>
				<li><img src="<?php echo url::base(); ?>images/editeur/cursor.png" height="16" align="absmiddle" /><span class="quick_help">CTRL + C</span> : <?php echo Kohana::lang( 'editeur.ctrl_c' ); ?></li>
				<li><img src="<?php echo url::base(); ?>images/editeur/corbeille.png" height="16" align="absmiddle" /><span class="quick_help">CTRL + S</span> : <?php echo Kohana::lang( 'editeur.ctrl_s' ); ?></li>
				<li><img src="<?php echo url::base(); ?>images/editeur/grille.png" height="16" align="absmiddle" /><span class="quick_help">CTRL + G</span> : <?php echo Kohana::lang( 'editeur.ctrl_g' ); ?></li>
				<li><img src="<?php echo url::base(); ?>images/editeur/firewall.png" height="16" align="absmiddle" /><span class="quick_help">CTRL + O</span> : <?php echo Kohana::lang( 'editeur.ctrl_o' ); ?></li>
				<li><img src="<?php echo url::base(); ?>images/editeur/connect.png" height="16" align="absmiddle" /><span class="quick_help">CTRL + M</span> : <?php echo Kohana::lang( 'editeur.ctrl_m' ); ?></li>
				<li><img src="<?php echo url::base(); ?>images/editeur/level.png" height="16" align="absmiddle" /><span class="quick_help">CTRL + &uarr; &darr;</span> : <?php echo Kohana::lang( 'editeur.help_niveau' ); ?></li>
				<li><img src="<?php echo url::base(); ?>images/editeur/gomme.png" height="16" align="absmiddle" /><span class="quick_help">ESC</span> : <?php echo Kohana::lang( 'editeur.esc' ); ?></li>
		</ul>
</div>
<div class="footerForm">
		<input type="button" class="button close" value="<?php echo Kohana::lang( 'form.close' ); ?>"/>
</div>
