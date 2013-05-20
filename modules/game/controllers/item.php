<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Controller public des items. Il permet de gerer les items
 * d'un utilisateur (add/delete/use).
 *
 * @package Item
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Item_Controller extends Template_Controller {

		/**
		 * Permet de faire passer l'object item sur toutes les méthodes.
		 * 
		 * @var object private
		 */
		private $item;

		public function __construct()
		{
				parent::__construct();
				parent::login();
				$this->item = Item_Model::instance();
		}

		/**
		 * Mise a jour d'un objet apres un drag n drop.
		 * 
		 * @param integer ID élément en drag
		 * @param integer	 D position ou on drop
		 * @param integer ID élément qui se trouve sur la position drop
		 * @param integer	 ID position initial de l'élémént qu'on drag
		 * @return  void
		 */
		public function move( $id_drag, $id_drop, $id_drag_old = FALSE, $id_drop_old = FALSE )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$this->item->user_update( array( 'item_position' => $id_drop ), $this->user->id, $id_drag );

				if( $id_drag_old !== FALSE && $id_drop_old !== FALSE )
						$this->item->user_update( array( 'item_position' => $id_drop_old ), $this->user->id, $id_drag_old );
		}

		/**
		 * Utiliser un objet.
		 * 
		 * @param integer	 ID de l'item
		 * @param bool Ajax ou non
		 * @return  void
		 */
		public function using( $item_id, $ajax = TRUE )
		{
				$this->auto_render = $txt = FALSE;

				if( $ajax && !request::is_ajax() )
						return FALSE;

				if( ($item = $this->item->select( $this->user->id, $item_id, 1 ) ) !== FALSE )
				{
						$result = FALSE;

						if( $item->hp )
						{
								$this->user->hp += $item->hp;

								if( $this->user->hp > $this->user->hp_max )
										$this->user->hp = $this->user->hp_max;

								$result['hp'] = $this->user->hp;

								$this->item->user_delete( $this->user->id, $item_id );
						}

						if( $item->mp )
						{
								$this->user->mp += $item->mp;

								if( $this->user->mp > $this->user->mp_max )
										$this->user->mp = $this->user->mp_max;

								$result['mp'] = $this->user->mp;

								$this->item->user_delete( $this->user->id, $item_id );
						}

						if( $result )
						{
								$this->user->update();

								History_Model::instance()->user_insert( $this->user->id, FALSE, $item_id, 'using_item' );

								if( $ajax )
										echo json_encode( $result );
								else
										$txt = Kohana::lang( 'item.util_item' );
						}
						else
								$txt = Kohana::lang( 'item.error_util_item' );

						if( !$ajax )
								return url::redirect( 'user/show?msg='.urlencode( $txt ) );
				}
		}

		/**
		 * Utiliser un objet sans ajax.
		 * 
		 * @return  void
		 */
		public function usingListing( $item_id )
		{
				self::using( $item_id, FALSE );
		}

		/**
		 * Supprimer un objet.
		 * 
		 * @param integer ID item
		 * @return  void
		 */
		public function delete( $item_id )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() || !$item_id )
						return FALSE;

				$this->item->user_delete( $this->user->id, $item_id );
		}

		/**
		 * Connaitre le détail d'un objet.
		 * 
		 * @param integer ID item
		 * @return  void
		 */
		public function show( $item_id )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() || !$item_id )
						return FALSE;

				if( ($item = $this->item->select( $this->user->id, $item_id, 1 )) !== FALSE )
				{
						$view = new View( 'item/show' );
						$view->item = $item;
						$view->user = $this->user;
						$view->using = $this->item->stuff_user( $this->user->id, $item_id );
						$view->render( TRUE );
				}
		}

		/**
		 * Placer un équipement sur le personnage.
		 * 
		 * @param integer ID item
		 * @return  void
		 */
		public function equiper( $item_id )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() || !$item_id )
						return FALSE;

				if( ($item = $this->item->select( $this->user->id, $item_id, 1 )) !== FALSE )
				{
						$this->item->stuff_delete( $this->user->id, FALSE, $item->position );
						$this->item->stuff_insert( $this->user->id, $item->id, $item->position );

						echo $item->position;
				}
		}

		/**
		 * Retirer un equipement du personnage.
		 * 
		 * @param integer ID item
		 * @return  void
		 */
		public function equiper_delete( $item_id )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() || !$item_id )
						return FALSE;

				if( ($item = $this->item->select( $this->user->id, $item_id, 1 ) ) !== FALSE )
						$this->item->stuff_delete( $this->user->id, FALSE, $item->position );
		}

}

?>