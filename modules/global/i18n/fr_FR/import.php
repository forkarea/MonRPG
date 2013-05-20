<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

$lang = array
		(
		'title' => 'Importation de fichier tiled TMX',
		'desc' => 'Cet outil va vous permettre d\'importer vos fichiers <b>Tiles</b> directement sur votre jeu. veuillez bien vérifier que vos fichier comportent bien 7 calques. 1 nommé <b>"fond"</b> qui ne sera pas utilisé lors de l\'importation, il sert juste a vous donner un sol. Les 6 autres calques doivent être nommés de <b>"niveau -3"</b> à <b>"niveau 3"</b> en sachant que <b>"niveau 0"</b> est le niveau du joueur.',
		'submit' => 'Importer mon TMX',
		'no_file' => 'Veuillez indiquer un fichier TMX',
		'no_extension' => 'Veuillez utiliser un fichier .TMX',
		'no_csv' => 'Veuillez enregistrer votre fichier en CSV (Modifier les préférences Tiled)',
		'error_crea_map' => 'Erreur lors de la création de la région',
		'error_vide_map' => 'Votre fichier ne comporte pas d\'éléments',
		'select_zip' => 'Sélectionnez votre fichier .zip',
		'verif_zip' => 'Veuillez vérifier que votre fichier .zip qui contient bien un fichier .tmx et toutes les images utilisées à la racine du dossier.',
		'donwload_desc' => 'Télécharger un exemple de fichier à importer pour Mon RPG',
		'donwload_title' => 'Télécharger l\'exemple',
		'donwload_link' => 'Télécharger <a href="http://www.mapeditor.org" >Tiled Map Editor</a> pour générer des régions ',
		'config' => 'Comment configurer l\'application Tiled Map Editor',
		'think' => 'Pensez à modifier les préférences par défaut au format d\'enregistrement <strong>CSV</strong>',
		'' => '',
);
?>