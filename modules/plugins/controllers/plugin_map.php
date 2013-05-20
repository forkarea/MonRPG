<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Pour que l'utilisateur voit la carte dans son ensemble (totalité)
 *
 * @package Action_map
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Map_Controller extends Action_Controller {

		/**
		 * Affiche l'alerte de présentation pour dormir.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'map/plugin' );
				$v->data = $this->data;
				$v->render( TRUE );
		}

		/**
		 * Afficher la map en grand
		 * 
		 * @return  void
		 */
		public function show()
		{
				$this->auto_render = FALSE;
				
				$v = new View( 'map/plugin_show' );
				$v->data = $this->data;
				$v->render(TRUE);
		}

}

?>