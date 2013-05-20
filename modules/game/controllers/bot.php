<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Controller public des bots. On génère lesbots d'un joueur.
 *
 * @package Bot
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Bot_Controller extends Authentic_Controller {

		/**
		 * Permet de faire passer l'object bot sur toutes les méthodes.
		 * 
		 * @var object private
		 */
		private $bot;

		public function __construct()
		{
				parent::__construct();
				parent::login();
				$this->bot = Bot_Model::instance();
		}

		/**
		 * Génération des bots d'un utilisateur sur la map.
		 * Les parametres se place selon l'éditeur de map
		 * 
		 * @return  void
		 */
		public function list_map()
		{
				if( !request::is_ajax() )
						return FALSE;

				if( !$my_bot = $this->bot->select( array( 'region_id' => $this->user->region_id ) ) )
				{
						if( !$region = Region_Model::instance()->select( array( 'id' => $this->user->region_id ), 1 ) )
								return FALSE;

						$image = file::listing_dir( DOCROOT.'images/character' );
						$list_obst = FALSE;

						if( ($rows = Map_Model::instance()->select_detail( array( 'region_id' => $this->user->region_id ), FALSE ) ) !== FALSE )
								foreach( $rows as $row )
										$list_obst[$row->x_map.'-'.$row->y_map] = TRUE;

						$rows_sorts = Sort_Model::instance()->select( array( 'niveau <=' => $region->bot_niveau ) );


						if( ( $rows = Map_Model::instance()->select_detail( array( 'region_id' => $this->user->region_id,
								'bot' => 1,
								'x_map !=' => $this->user->x,
								'y_map !=' => $this->user->y ), FALSE, 'x_map, y_map' ) ) !== FALSE )
						{
								foreach( $rows as $row )
								{
										if( rand( 0, 100 ) > Kohana::config( 'bot.pourcent_no_generate_bot' ) )
										{
												$hp = rand( $region->bot_hp_min, $region->bot_hp_max );
												$mp = rand( $region->bot_mp_min, $region->bot_mp_max );

												if( !$hp || !$mp )
														break;

												$list_sorts = FALSE;

												if( $rows_sorts )
														foreach( $rows_sorts as $row_sorts )
																if( rand( 0, 1 ) && $row_sorts->mp <= $mp )
																		$list_sorts[] = $row_sorts->id;

												$new_bot = array( 'x' => $row->x_map,
														'y' => $row->y_map,
														'region_id' => $this->user->region_id,
														'image' => $image[array_rand( $image )],
														'hp_max' => $hp,
														'hp' => $hp,
														'mp_max' => $mp,
														'mp' => $mp,
														'attaque' => rand( $region->bot_attaque_min, $region->bot_attaque_max ),
														'defense' => rand( $region->bot_defense_min, $region->bot_defense_max ),
														'argent' => rand( $region->bot_argent_min, $region->bot_argent_max ),
														'xp' => rand( $region->bot_xp_min, $region->bot_xp_max ),
														'niveau' => $region->bot_niveau,
														'sorts' => $list_sorts ? implode( ',', $list_sorts ) : FALSE );

												$new_bot['id'] = $this->bot->insert( $new_bot );

												$my_bot[] = (object) $new_bot;
										}
								}
						}
						else
								return FALSE;
				}
				else
						return FALSE;

				if( $my_bot )
				{
						foreach( $my_bot as $rows )
								$list[] = array( 'x' => $rows->x, 'y' => $rows->y, 'id' => $rows->id, 'image' => $rows->image );

						echo json_encode( $list );
				}
		}

		/**
		 * Mise a jour des coordonnées d'un bot apres déplacement.
		 *
		 * @param mixe ID/X/Y du bot
		 * @return  void
		 */
		public function move_map()
		{
				if( !request::is_ajax() )
						return FALSE;

				$id = str_replace( 'bot-', '', $this->input->post( 'id' ) );
				$x = $this->input->post( 'x' );
				$y = $this->input->post( 'y' );

				if( $id && $x && $y )
						$this->bot->update( array( 'x' => $x, 'y' => $y ), $id );
		}

		/**
		 * Affiche le panel de control quand on se trouve sur un bot.
		 *
		 * @param integer ID du bot
		 * @return  void
		 */
		public function action( $id = FALSE )
		{
				if( !request::is_ajax() || !$id )
						return FALSE;

				if( ($bot = $this->bot->select( array( 'id' => str_replace( 'bot-', '', $id ) ), 1 )) !== FALSE )
				{
						$this->user->update( array( 'x' => $bot->x, 'y' => $bot->y ) );

						$view = new View( 'bot/action' );
						$view->bot = $bot;
						$view->render( TRUE );
				}
		}

}

?>