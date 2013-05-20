<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Changement de carte sur la map.
 *
 * @package Action_move
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Move_Controller extends Action_Controller {

		/**
		 * Gestion du changement de carte.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				if( isset( $this->data->item ) && $this->data->item && (!$obj = Item_Model::instance()->select( $this->user->id, $this->data->item, 1 ) ) )
						echo Kohana::lang( 'move.oblige_object' );

				else
				{
						$this->user->x = $this->data->x;
						$this->user->y = $this->data->y;
						$this->user->region_id = $this->data->id_region;

						if( $this->data->prix && is_numeric( $this->data->prix ) && $this->user->argent >= $this->data->prix )
								$this->user->argent -= $this->data->prix;

						if( !$this->data->prix || $this->user->argent >= $this->data->prix )
						{
								History_Model::instance()->user_insert( $this->user->id, $this->data->id_module, $this->data->id_region, 'change_map' );
								$this->user->update();
								echo 'change-'.(isset( $this->data->music ) && $this->data->music ? $this->data->music : 'no' );
						}
						else
								echo Kohana::lang( 'move.no_money' );
				}
		}

}

?>