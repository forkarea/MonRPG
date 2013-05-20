<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Controller public des combats, On affiche la page de combat,
 * on gère le calcul d'un combat.
 *
 * @package Fight
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Fight_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::login();
		}

		/**
		 * Page général pour un combat avec un bot.
		 *
		 * @param integer ID du bot
		 * @return  void
		 */
		public function bot( $id = FALSE )
		{
				$this->auto_render = FALSE;

				if( !$bot = Bot_Model::instance()->select( array( 'region_id' => $this->user->region_id, 'id' => $id ), 1 ) )
						return FALSE;

				if( $bot->user_id != 0 && $bot->user_id != $this->user->id )
				{
						echo Kohana::lang( 'fight.now_fight' );
						return;
				}
				elseif( $bot->user_id == 0 && $bot->user_id != $this->user->id )
						Bot_Model::instance()->update( array( 'user_id' => $this->user->id ), $id );

				if( !$bot->hp || !$this->user->hp )
						self::end( $id, $bot );

				$arrayItem = FALSE;

				if( ($items = Item_Model::instance()->user_quick( $this->user->id ) ) !== FALSE )
						foreach( $items as $item )
								$arrayItem[$item->item_position] = $item;

				$region = Region_Model::instance()->select( array( 'id' => $this->user->region_id ), 1 );

				$liste_item_bot[] = '{id : \'0\', mp : \'0\', effect : \''.Kohana::config( 'fight.sort_defalut_bot' ).'\'}';

				if( $bot->sorts )
						if( ( $item_bot = Sort_Model::instance()->in( explode( ',', $bot->sorts ) ) ) != FALSE )
								foreach( $item_bot as $row )
										$liste_item_bot[] = '{id : \''.$row->id.'\', mp : \''.$row->mp.'\', effect : \''.$row->effect.'\'}';

				$sorts = Sort_Model::instance()->user( $this->user->id );

				echo html::stylesheet( 'index.php/css_'.base64_encode( 'fight' ) );

				$v = new View( 'fight/index' );
				$v->terrain = url::base().'images/terrain/'.$region->fight_terrain.'.jpg';
				$v->bot = $bot;
				$v->user = $this->user;
				$v->sorts = $sorts;
				$v->sorts_bot = implode( ',', $liste_item_bot );
				$v->render( TRUE );

				echo html::script( 'index.php/js_'.base64_encode( 'fight' ) );
		}

		/**
		 * Calcul d'un combat entre user/bot.
		 *
		 * @param integer ID du bot
		 * @param bool Savoir si le calcul est dut au user ou au bot
		 * @return  void
		 */
		public function calcul( $id = FALSE, $botAttack = FALSE )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$bots = Bot_Model::instance();

				if( !$bot = $bots->select( array( 'region_id' => $this->user->region_id, 'user_id' => $this->user->id, 'id' => $id ), 1 ) )
						return FALSE;

				$sort = $user = FALSE;

				$score_attaque = $attaque_user = $defense_user = 0;

				$result['hpUser'] = $this->user->hp;
				$result['mpUser'] = $this->user->mp;
				$result['hpBot'] = $bot->hp;
				$result['mpBot'] = $bot->mp;

				if( ($id_sort = $this->input->get( 'id_sort' )) !== FALSE )
				{
						if( ( $sort = Sort_Model::instance()->select( array( 'id' => $id_sort ), 1 ) ) !== FALSE )
						{
								if( !$botAttack && $this->user->mp >= $sort->mp )
										$result['mpUser'] = $this->user->mp -= $sort->mp;
								elseif( $bot->mp >= $sort->mp )
										$result['mpBot'] = $bot->mp -= $sort->mp;

								if( $sort->attack_min && $sort->attack_max )
										$score_attaque = rand( $sort->attack_min, $sort->attack_max );
						}
				}

				if( ($stuffs = Item_Model::instance()->stuff_user( $this->user->id ) ) !== FALSE )
						foreach( $stuffs as $stuff )
						{
								if( $stuff->attaque )
										$attaque_user += $stuff->attaque;
								if( $stuff->defense )
										$defense_user += $stuff->defense;
						}

				if( $botAttack )
				{
						$score_attaque += ( $bot->attaque - $defense_user );

						if( $score_attaque <= 0 )
								$score_attaque = Kohana::config( 'fight.score_min_attack' );

						$result['hpUser'] = $this->user->hp -= $score_attaque;
				}
				else
				{
						$score_attaque += ( $attaque_user - $bot->defense );

						if( $score_attaque <= 0 )
								$score_attaque = Kohana::config( 'fight.score_min_attack' );

						$result['hpBot'] = $bot->hp -= $score_attaque;
				}

				if( rand( 0, 100 ) <= Kohana::config( 'fight.pourcentage_dodge' ) )
						$score_attaque = Kohana::lang( 'fight.dodge' );
				else
				{
						$score_attaque = number_format( $score_attaque );

						$rand = rand( 0, 10 );

						if( $rand == 1 )
								$score_attaque .= '<br />'.Kohana::lang( 'fight.excelent' );
						elseif( $rand == 2 )
								$score_attaque .= '<br />'.Kohana::lang( 'fight.aie' );
				}

				$result['score'] = $score_attaque;

				$result['killBot'] = $result['killUser'] = 0;

				if( $this->user->hp <= 0 )
				{
						$result['killUser'] = 1;
						$result['hpUser'] = $this->user->hp = $result['mpUser'] = $this->user->mp = 0;
				}
				elseif( $this->user->hp > $this->user->hp_max )
						$result['hpUser'] = $this->user->hp = $this->user->hp_max;

				if( $bot->hp <= 0 )
				{
						$result['killUser'] = 1;
						$result['hpBot'] = $bot->hp = $result['mpBot'] = $bot->mp = 0;
				}
				elseif( $bot->hp > $bot->hp_max )
						$result['hpBot'] = $bot->hp = $bot->hp_max;

				$this->user->update();
				$bots->update( array( 'mp' => $bot->mp, 'hp' => $bot->hp ), $bot->id );

				echo json_encode( $result );
		}

		/**
		 * Victoire du combat user/bot
		 *
		 * @return  void
		 */
		public function end( $id = FALSE, $bot = FALSE )
		{
				$this->auto_render = FALSE;

				$bots = Bot_Model::instance();

				if( !$bot )
						if( !$bot = $bots->select( array( 'region_id' => $this->user->region_id, 'user_id' => $this->user->id, 'id' => $id ), 1 ) )
								return;

				$bots->delete( $bot->id );

				if( !$this->user->hp )
						self::gameOver( $bot );
				else if( !$bot->hp )
						self::victory( $bot );
		}

		private function gameOver( $bot )
		{
				$this->user->hp = $this->user->hp_max;
				$this->user->mp = $this->user->mp_max;
				$this->user->xp = 0;
				$this->user->x = Kohana::config( 'game.initialPosition.x' );
				$this->user->y = Kohana::config( 'game.initialPosition.y' );
				$this->user->region_id = Kohana::config( 'game.initialPosition.region' );

				if( Kohana::config( 'fight.game_over_argent' ) && $this->user->argent > Kohana::config( 'fight.game_over_argent' ) )
						$this->user->argent /= Kohana::config( 'fight.game_over_argent' );

				$this->user->update();

				History_Model::instance()->user_insert( $this->user->id, $bot->module, $bot->id, 'gameover_bot'.( $bot->module ? '_module' : FALSE) );
				
				$v = new View( 'fight/gameover' );
				$v->render( TRUE );
		}

		private function victory( $bot )
		{
				$nbr_all = 0;

				if( $bot->module )
						if( ($row = Map_Model::instance()->select_detail( array( 'region_id' => $this->user->region_id,
								'x_map' => $this->user->x,
								'y_map' => $this->user->y,
								'id_detail' => $bot->module,
								'module_map' => 'fight' ) ) ) )
								if( $row->action_map && ($data = @unserialize( $row->action_map ) ) )
										if( isset( $data->item_victory ) && $data->item_victory )
												foreach( $data->item_victory as $key => $nbr )
														for( $n = 0; $n < $nbr; $nbr_all += $n++ )
																Item_Model::instance()->user_insert( $this->user->id, $key );

				$this->user->argent += $bot->argent;
				$this->user->xp += $bot->xp;
				$this->user->update();

				History_Model::instance()->user_insert( $this->user->id, $bot->module, $bot->id, 'victory_bot'.( $bot->module ? '_module' : FALSE) );

				$v = new View( 'fight/victory' );
				$v->money = $bot->argent.' '.Kohana::config( 'game.money' );
				$v->xp = $bot->xp.' '.Kohana::lang( 'user.xp' );
				$v->object = $nbr_all ? Kohana::lang( 'fight.object_add' ) : FALSE;
				$v->bot_id = $bot->id;
				$v->render( TRUE );
		}

}

?>