<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Commerçant acheter/vendre sur la map.
 *
 * @package Action_shop
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Shop_Controller extends Action_Controller {

		/**
		 * Affiche l'alerte de présentation d'un vendeur.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'shop/plugin' );
				$v->data = $this->data;
				$v->admin = in_array( 'admin', $this->role->name );
				$v->render( TRUE );
		}

		/**
		 * Affiche la liste des objets qu'on peut acheter.
		 * 
		 * @return  void
		 */
		public function show()
		{
				$this->auto_render = FALSE;

				if( !isset( $this->data->items ) || !$this->data->items )
						return false;

				$item = Item_Model::instance();

				$listItem = $item->in( $this->data->items );

				$itemProtect = FALSE;

				if( ($items = $item->select( $this->user->id ) ) !== FALSE )
						foreach( $items as $row )
								if( $row->protect )
										$itemProtect[$row->id] = TRUE;

				echo html::stylesheet( 'index.php/css_'.base64_encode( 'shop' ) );

				$v = new View( 'shop/plugin_show' );
				$v->listItem = $listItem;
				$v->itemProtect = $itemProtect;
				$v->data = $this->data;
				$v->user = $this->user;
				$v->admin = in_array( 'admin', $this->role->name );
				$v->render( TRUE );
		}

		/**
		 * Traitement insertion des achats.
		 * 
		 * @return  void
		 */
		public function insert()
		{
				$this->auto_render = FALSE;

				$txt = Kohana::lang( 'shop.no_buy' );

				if( ($list = $this->input->get( 'item' ) ) !== FALSE )
				{
						$listItem = Item_Model::instance()->in( $this->data->items );

						$somme = 0;
						$insert_list = FALSE;

						foreach( $listItem as $row )
								if( isset( $list[$row->id] ) && $list[$row->id] > 0 )
								{
										$insert_list[$row->id] = $list[$row->id];
										$somme += $list[$row->id] * $row->prix;
								}

						if( $somme <= $this->user->argent )
						{
								foreach( $insert_list as $key => $row )
										for( $n = 0; $n < $row; $n++ )
										{
												if( ($position = Item_Model::instance()->select( $this->user->id, $key, 1 ) ) )
														$position = $position->item_position;
												else
														$position = 0;

												Item_Model::instance()->user_insert( $this->user->id, $key, $position );
										}

								$this->user->argent -= $somme;
								$this->user->update();

								History_Model::instance()->user_insert( $this->user->id, $this->data->id_module, $somme, 'shop' );

								$txt = Kohana::lang( 'shop.total_buy', number_format( $somme ), Kohana::config( 'game.money' ) );
						}
				}

				echo $txt;

				echo '<script>refresh_user(true);</script>';
		}

		/**
		 * Affiche la liste des objets qu'on peut vendre.
		 * 
		 * @return  void
		 */
		public function sale()
		{
				$this->auto_render = $arrayStuff = FALSE;

				if( !isset( $this->data->items ) || !$this->data->items )
						return false;

				if( !($items = Item_Model::instance()->select( $this->user->id ) ) !== FALSE )
						return false;

				if( ($stuffs = Item_Model::instance()->stuff_user( $this->user->id ) ) !== FALSE )
						foreach( $stuffs as $stuff )
								$arrayStuff[$stuff->item_id] = $stuff;

				echo html::stylesheet( 'index.php/css_'.base64_encode( 'shop' ) );

				$v = new View( 'shop/plugin_sale' );
				$v->listItem = $items;
				$v->data = $this->data;
				$v->user = $this->user;
				$v->stuff = $arrayStuff;
				$v->admin = in_array( 'admin', $this->role->name );
				$v->render( TRUE );
		}

		/**
		 * Traitement update des ventes.
		 * 
		 * @return  void
		 */
		public function update()
		{
				$this->auto_render = FALSE;

				$txt = Kohana::lang( 'shop.no_sale' );

				if( ($list = $this->input->get( 'item' ) ) !== FALSE )
				{
						$listItem = Item_Model::instance()->select( $this->user->id );

						$somme = 0;
						$insert_list = FALSE;

						foreach( $listItem as $row )
								if( isset( $list[$row->id] ) && $list[$row->id] > 0 )
								{
										$insert_list[$row->id] = $list[$row->id];
										$somme += $list[$row->id] * ( isset($this->data->price) && $this->data->price ? round( $row->prix - ( $row->prix * ( $this->data->price / 100 ) ) ) : $row->prix );
								}

						if( $somme > 0 )
						{
								foreach( $insert_list as $key => $row )
										for( $n = 0; $n < $row; $n++ )
												Item_Model::instance()->user_delete( $this->user->id, $key );

								$this->user->argent += $somme;
								$this->user->update();

								History_Model::instance()->user_insert( $this->user->id, $this->data->id_module, $somme, 'sale' );

								$txt = Kohana::lang( 'shop.total_sale', number_format( $somme ), Kohana::config( 'game.money' ) );
						}
				}

				echo $txt;

				echo '<script>refresh_user(true);</script>';
		}

}

?>