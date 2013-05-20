<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Gestion des combat avec un emplacement précis
 *
 * @package Action_fight
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Fight_Controller extends Action_Controller {

		/**
		 * Affiche l'alerte de présentation d'un combat.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				if( History_Model::instance()->select( $this->user->id, $this->data->id_module, FALSE, 'victory_bot_module' ) )
						return FALSE;

				$view = new View( 'bot/action' );

				$bots = Bot_Model::instance();

				if( ($bot = $bots->select( array( 'x' => $this->user->x, 'y' => $this->user->y, 'region_id' => $this->user->region_id, 'module !=' => 0 ), 1 )) !== FALSE )
						$view->bot = $bot;

				else
				{
						$bot_hp = isset( $this->data->bot_hp ) ? $this->data->bot_hp : rand( 10, 100 );
						$bot_mp = isset( $this->data->bot_mp ) ? $this->data->bot_mp : rand( 10, 100 );
						$bot_attaque = isset( $this->data->bot_attaque ) ? $this->data->bot_attaque : rand( 10, 100 );
						$bot_defense = isset( $this->data->bot_defense ) ? $this->data->bot_defense : rand( 10, 100 );
						$niveau = isset( $this->data->niveau ) ? $this->data->niveau : rand( 10, 100 );
						$bot_argent_min = isset( $this->data->bot_argent_min ) ? $this->data->bot_argent_min : rand( 10, 100 );
						$bot_argent_max = isset( $this->data->bot_argent_max ) ? $this->data->bot_argent_max : rand( 100, 1000 );
						$sorts = isset( $this->data->sorts ) && $this->data->sorts ? implode( ',', $this->data->sorts ) : FALSE;
						$image = isset( $this->data->image ) && $this->data->image ? $this->data->image : FALSE;

						$new_bot = array( 'x' => $this->user->x,
								'y' => $this->user->y,
								'region_id' => $this->user->region_id,
								'user_id' => $this->user->id,
								'image' => $image,
								'hp_max' => $bot_hp,
								'hp' => $bot_hp,
								'mp_max' => $bot_mp,
								'mp' => $bot_mp,
								'attaque' => $bot_attaque,
								'defense' => $bot_defense,
								'argent' => rand( $bot_argent_min, $bot_argent_max ),
								'niveau' => $niveau,
								'module' => $this->data->id_module,
								'sorts' => $sorts );

						$new_bot['id'] = $bots->insert( $new_bot );
						$view->bot = (object) $new_bot;
				}

				$view->title = $this->data->title;
				$view->render( TRUE );
		}

}

?>