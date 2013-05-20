<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Maitre des sorts pour permettre de vendre des sorts à un joueur
 *
 * @package Action_shop
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Sort_Controller extends Action_Controller {

		/**
		 * Affiche l'alerte de présentation d'un maitre des sorts.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'sort/plugin' );
				$v->data = $this->data;
				$v->render( TRUE );
		}

		/**
		 * Affiche la liste des sorts qu'on peut acheter.
		 * 
		 * @return  void
		 */
		public function show()
		{
				$this->auto_render = FALSE;

				if( !isset( $this->data->sorts ) || !$this->data->sorts )
						return FALSE;
				
				$sort = Sort_Model::instance();

				$listSort = $sort->in( $this->data->sorts );

				$sortListUser = FALSE;

				if( ($sorts = $sort->user( $this->user->id ) ) !== FALSE )
						foreach( $sorts as $row )
								$sortListUser[$row->id] = TRUE;

				echo html::stylesheet( 'index.php/css_'.base64_encode( 'sort' ) );

				$v = new View( 'sort/plugin_show' );
				$v->listSort = $listSort;
				$v->sortListUser = $sortListUser;
				$v->data = $this->data;
				$v->user = $this->user;
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

				$txt = Kohana::lang( 'sort.no_buy' );

				if( ($list = $this->input->get( 'sort' ) ) !== FALSE )
				{
						$listSort = Sort_Model::instance()->in( $this->data->sorts );

						$somme = 0;
						$insert_list = FALSE;

						foreach( $listSort as $row )
								if( isset( $list[$row->id] ) && $list[$row->id] == 1 )
										$somme += $insert_list[$row->id] = $row->prix;

						if( $somme <= $this->user->argent )
						{
								foreach( $insert_list as $key => $row )
										Sort_Model::instance()->insert_user( $this->user->id, $key );

								$this->user->argent -= $somme;
								$this->user->update();

								History_Model::instance()->user_insert( $this->user->id, $this->data->id_module, $somme, 'sort' );

								$txt = Kohana::lang( 'sort.total_buy', number_format( $somme ), Kohana::config( 'game.money' ) );
						}
				}

				echo $txt;
		}

}

?>