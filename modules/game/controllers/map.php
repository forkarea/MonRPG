<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Controller public de la map. Pour afficher la map.
 *
 * @package	 Map
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Map_Controller extends Authentic_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::login();
		}

		/**
		 * Génération de la map en mode jeu.
		 *
		 * @param bool Afficher directement ou return la vue
		 * @return string
		 */
		public function word( $render = TRUE )
		{
				if( !$id_region = $this->user->region_id )
						$this->user->update( array( 'region_id' => ($id_region = 1) ) );

				if( ($region = Region_Model::instance()->select( array( 'id' => $id_region ), 1 ) ) === FALSE )
						return FALSE;

				$cssPersoX = (Kohana::config( 'map.taille_map_visible_x' ) - Kohana::config( 'map.taille_case' )) / 2;
				$cssPersoY = (Kohana::config( 'map.taille_map_visible_y' ) - Kohana::config( 'map.taille_case' )) / 2;
				$cssMapX = $cssMapY = $nbr_bot = 0;
				$maxMapX = $region->x * Kohana::config( 'map.taille_case' ) - Kohana::config( 'map.taille_map_visible_x' );
				$maxMapY = $region->y * Kohana::config( 'map.taille_case' ) - Kohana::config( 'map.taille_map_visible_y' );
				$bots = $otherUsers = FALSE;

				if( !$element = Cache::instance()->get( 'element_region_'.$id_region ) )
				{
						if( ($rows = Map_Model::instance()->select( array( 'region_id' => $id_region ) ) ) !== FALSE )
								foreach( $rows as $row )
										$element[$row->x_map.'-'.$row->y_map][$row->z_map] = $row;

						Cache::instance()->set( 'element_region_'.$id_region, $element, 'map' );
				}

				if( !$element_obstacle = Cache::instance()->get( 'element_obstacle_region_'.$id_region ) )
				{
						if( ($rows = Map_Model::instance()->select_detail( array( 'region_id' => $id_region ), FALSE ) ) !== FALSE )
								foreach( $rows as $row )
								{
										$element_obstacle[$row->x_map.'-'.$row->y_map] = $row;

										if( $row->bot )
												$nbr_bot++;
								}

						Cache::instance()->set( 'element_obstacle_region_'.$id_region, $element_obstacle, 'map' );
				}

				if( ($rows = Bot_Model::instance()->select( array( 'region_id' => $id_region, 'module' => 0 ) ) ) !== FALSE )
						foreach( $rows as $row )
								$bots[$row->x.'-'.$row->y] = $row;

				if( ($rows = $this->user->select( array( 'region_id' => $id_region, 'last_action >' => ( time() - Kohana::config( 'map.last_time_other_user' ) ), 'id !=' => $this->user->id ) ) ) !== FALSE )
						foreach( $rows as $row )
								$otherUsers[$row->x.'-'.$row->y] = $row;

				$taille_cote_x = round( ( ( Kohana::config( 'map.taille_map_visible_x' ) / Kohana::config( 'map.taille_case' ) ) - 1 ) / 2 );
				$taille_cote_y = round( ( ( Kohana::config( 'map.taille_map_visible_y' ) / Kohana::config( 'map.taille_case' ) ) - 1 ) / 2 );

				if( $this->user->x > $taille_cote_x && $this->user->x < $region->x - $taille_cote_x )
						$cssMapX -= ( $this->user->x - $taille_cote_x ) * Kohana::config( 'map.taille_case' );

				if( $this->user->x < $taille_cote_x )
						$cssPersoX -= ( $taille_cote_x - $this->user->x ) * Kohana::config( 'map.taille_case' );
				elseif( $this->user->x >= $region->x - $taille_cote_x )
				{
						$cssPersoX += ( ( $taille_cote_x + 1) - ( $region->x - $this->user->x ) ) * Kohana::config( 'map.taille_case' );
						$cssMapX -= $maxMapX;
				}

				if( $this->user->y > $taille_cote_y && $this->user->y < $region->y - $taille_cote_y )
						$cssMapY -= ( $this->user->y - $taille_cote_y ) * Kohana::config( 'map.taille_case' );

				if( $this->user->y < $taille_cote_y )
						$cssPersoY -= ( $taille_cote_y - $this->user->y ) * Kohana::config( 'map.taille_case' );
				elseif( $this->user->y >= $region->y - $taille_cote_y )
				{
						$cssPersoY += ( ($taille_cote_y + 1) - ( $region->y - $this->user->y ) ) * Kohana::config( 'map.taille_case' );
						$cssMapY -= $maxMapY;
				}

				$view = new View( 'map/word' );
				$view->image = self::background( $region->background );
				$view->region = $region->name;
				$view->tailleMapX = $region->x;
				$view->tailleMapY = $region->y;
				$view->music = $region->music;
				$view->music_fight = $region->music_fight;
				$view->element = $element;
				$view->obstacle = $element_obstacle;
				$view->bots = $bots;
				$view->otherUsers = $otherUsers;
				$view->user = $this->user;
				$view->admin = in_array( 'admin', $this->role->name );
				$view->cssPersoX = $cssPersoX;
				$view->cssPersoY = $cssPersoY;
				$view->cssMapX = $cssMapX;
				$view->cssMapY = $cssMapY;
				$view->maxBot = $nbr_bot;

				return $view->render( $render );
		}

		/**
		 * Génération du background en cas de non existant.
		 *
		 * @param string	 Nom du fichier image qui se trouve dans : /images/background/
		 * @return string
		 */
		private static function background( $file )
		{
				if( !is_file( DOCROOT.'images/background/'.$file ) )
				{
						$image = new Image( DOCROOT.'images/tilesets/'.$file );
						$image->crop( Kohana::config( 'map.taille_case' ), Kohana::config( 'map.taille_case' ), 0, 0 )->save( DOCROOT.'images/background/'.$file );
				}

				return url::base().'images/background/'.$file;
		}

}

?>