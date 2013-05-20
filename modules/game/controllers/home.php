<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Controller public de la page par défaut (homepage).
 *
 * @package	 Home
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Home_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
		}

		/**
		 * Page par défaut du jeu (homepage).
		 *
		 * @param bool Afficher directement ou return la vue
		 * @return  void
		 */
		public function index()
		{
				if( !$this->user )
				{
						Router_Core::$controller = 'logger';
						return Logger_Controller::index();
				}

				$list_js[] = 'jquery.facebox';
				$list_js[] = 'jquery.easing';
				$list_js[] = 'jquery.coda';

				foreach( file::listing_dir( DOCROOT.'js' ) as $row )
						if( is_file( DOCROOT.'js/'.$row ) && $row != 'logger.js' )
								$list_js[] = str_replace( '.js', '', $row );
						
				$this->script = $list_js;
				$this->script_no_compress = array( Kohana::config( 'url.websocket_user' ).':'.Kohana::config( 'url.websocket_port' ).'/socket.io/socket.io.js' );

				$this->css = array( 'map', 'facebox' );

				$this->template->content = new View( 'home/index' );
				$this->template->content->map = Map_Controller::word( FALSE );
		}

}

?>