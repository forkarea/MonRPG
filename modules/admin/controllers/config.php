<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

class Config_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'config' );
		}

		/**
		 * Méthode : 
		 */
		public function index()
		{
				$list_config = file::listing_dir( DOCROOT.'../modules/global/config' );

				$this->script = array( 'config' );

				$this->css = array( 'config' );

				$this->template->titre = Kohana::lang( 'config.configuration' );

				$this->template->contenu = new View( 'config/show' );

				$this->template->contenu->config = $list_config;

				$this->template->contenu->list = array( 'logs' => DOCROOT.'../logs',
						'cache' => DOCROOT.'../cache',
						'css' => DOCROOT.'../css',
						'js' => DOCROOT.'../js',
						'configuration_global' => MODPATH.'global/config',
						'controllers_plugin' => MODPATH.'plugins/controllers',
						'models_plugin' => MODPATH.'plugins/models',
						'views_plugin' => MODPATH.'plugins/views',
						'i18n_plugin' => MODPATH.'plugins/i18n',
						'images' => DOCROOT.'../images',
						'articles' => DOCROOT.'../images/articles',
						'tilesets' => DOCROOT.'../images/tilesets',
						'background' => DOCROOT.'../images/background',
						'character' => DOCROOT.'../images/character',
						'faceset' => DOCROOT.'../images/faceset',
						'items' => DOCROOT.'../images/items',
						'modules' => DOCROOT.'../images/modules',
						'sorts' => DOCROOT.'../images/sorts',
						'sorts_animate' => DOCROOT.'../images/sorts_animate',
						'terrain' => DOCROOT.'../images/terrain',
						'map' => DOCROOT.'../images/map' );

				$this->template->contenu->versionPHP = phpversion();
		}

		public function update( $file )
		{
				$this->script = array( 'config' );

				$this->css = array( 'config' );

				$this->template->titre = array( Kohana::lang( 'config.update' ) => 'config', $file => NULL );

				$this->template->contenu = new View( 'config/update' );

				$this->template->contenu->file = file_get_contents( DOCROOT.'../modules/global/config/'.$file.EXT );

				$this->template->contenu->file_name = $file;
		}

		public function save( $file )
		{
				$this->auto_render = FALSE;

				if( $this->input->post() !== FALSE )
				{
						if( ($fp = fopen( DOCROOT.'../modules/global/config/'.$file.EXT, "w" ) ) )
						{
								fputs( $fp, $_POST['fichier'], strlen( $_POST['fichier'] ) );
								fclose( $fp );

								return url::redirect( 'config?msg='.urlencode( Kohana::lang( 'config.update_valide' ) ) );
						}
						
						return url::redirect( 'config?msg='.urlencode( Kohana::lang( 'config.update_no_valide' ) ) );
				}
		}

}
?>