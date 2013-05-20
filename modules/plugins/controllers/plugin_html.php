<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Afficher du HTML sur la map.
 *
 * @package Action_HTML
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Html_Controller extends Action_Controller {

		/**
		 * Affiche le code HTML dans l'alerte.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'html/plugin' );
				$v->html = isset( $this->data->html ) ? $this->data->html : FALSE;
				$v->render( TRUE );
		}

}

?>