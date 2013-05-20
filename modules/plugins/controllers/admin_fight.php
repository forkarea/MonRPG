<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Changement des combats sur la map.
 *
 * @package Action_fight
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Admin_Fight_Controller extends Controller {

		/**
		 * Méthode : 
		 */
		public function index( &$view )
		{
				$view->image = file::listing_dir( DOCROOT.'../images/character' );
				$view->sorts = Sort_Model::instance()->select();
				$view->items = Item_Model::instance()->tableau_type_tiem();
		}

}

?>