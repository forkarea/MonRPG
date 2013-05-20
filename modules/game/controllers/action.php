<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Controller public des actions. Souvent extends de toutes les autres actions
 * Cela permet de vérifier que le joueur est au bon endroit.
 * On récupère aussi tout le DATA concernant l'action.
 *
 * @package Action
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Action_Controller extends Template_Controller {

		/**
		 * Permet de faire passer les données du module.
		 * 
		 * @var object protected
		 */
		protected $data = FALSE;

		/**
		 * Fixe le module qui est traité.
		 * 
		 * @var string protected
		 */
		protected $module = FALSE;

		public function __construct()
		{
				parent::__construct();
				parent::login();

				$url = explode( '/', url::current() );

				$this->module = $url[1];

				if( !self::header() )
						die( Kohana::lang( 'action.impossible_action' ) );
		}

		/**
		 * Permet de connaitre les informations sur le module ou se trouve l'user.
		 *
		 * @param string Forcer un module précis
		 * @return object
		 */
		protected function header( $module = FALSE )
		{
				if( $module )
						$this->module = $module;

				$x = $this->input->post( 'x', $this->user->x );
				$y = $this->input->post( 'y', $this->user->y );

				if( $this->user->x != $x || $this->user->y != $y )
				{
						$this->user->x = $x;
						$this->user->y = $y;
						$this->user->update();
				}

				if( !$row = Map_Model::instance()->select_detail( array( 'region_id' => $this->user->region_id,
						'x_map' => $this->user->x,
						'y_map' => $this->user->y,
						'module_map' => $this->module ) ) )
						return FALSE;

				if( !$row->action_map || (!$this->data = @unserialize( $row->action_map ) ) )
						return FALSE;

				if( $row->fonction )
						eval( '?>'.$row->fonction.'<?php' );

				$this->data->id_module = $row->id_detail;
				$this->data->region_id = $row->region_id;
				$this->data->x_map = $row->x_map;
				$this->data->y_map = $row->y_map;
				$this->data->image = $row->image;
				$this->data->title = $row->nom_map;

				return $this;
		}

}

?>