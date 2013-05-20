<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Editeur_Controller extends Template_Controller {

		private $region;

		public function __construct()
		{
				parent::__construct();
				parent::access( 'carte' );
		}

		/**
		 * Méthode : pour empêcher un utilisateur d'accéder directement à ce controller
		 */
		public function index()
		{
				return self::redirection( Kohana::lang( 'logger.no_acces' ) );
		}

		/**
		 * Methode : page editeur en général
		 */
		public function show( $idRegion = false )
		{
				if( !$idRegion || !is_numeric( $idRegion ) )
						return parent::redirect_erreur( 'regions' );

				cookie::set( 'id_map_parent', $idRegion );

				if( !$region = Region_Model::instance()->select( array( 'id' => $idRegion ), 1 ) )
						return parent::redirect_erreur( 'regions' );

				$optionTilesetsBg = $optionTilesets = FALSE;

				foreach( self::list_tilesets() as $key => $row )
				{
						$optionTilesets[] = $row;

						if( preg_match( '/BG_/', $row ) )
								$optionTilesetsBg[] = '<li class="select-bg">
																<div title="'.$key.'" class="contenerBg" style="background-image:url(\''.self::background_menu( $row ).'\')"></div>
															</li>'."\n";
				}

				$this->script = array( 'jquery.jcarousel', 'jquery.facebox', 'jquery.ui', 'jquery.context', 'editeur' );

				$this->css = array( 'editeur', 'jcarousel', 'facebox', 'form' );

				$this->template->titre = array( Kohana::lang( 'menu.home' ) => url::base( TRUE ),
						'Liste des régions' => ( $region->id_parent ? 'regions/child/'.$region->id_parent : 'regions'),
						$region->name => 'regions/show/'.$region->id,
						Kohana::lang( 'editeur.title_edit' ) => NULL );

				$this->template->contenu = new View( 'editeur/show' );
				$this->template->contenu->optionTilesets = cookie::get( 'tileset', $optionTilesets[array_rand( $optionTilesets )] );
				$this->template->contenu->optionTilesetsBg = $optionTilesetsBg ? implode( '', $optionTilesetsBg ) : FALSE;
				$this->template->contenu->listing = Region_Model::instance()->listing_parent();
				$this->template->contenu->idRegion = $idRegion;
		}

		/**
		 * Methode : affiche la map
		 */
		public function word()
		{
				$this->auto_render = FALSE;

				$id = cookie::get( 'id_map_parent' );

				if( !request::is_ajax() || !$id )
						return false;

				$html = Cache::instance()->get( 'map_region_'.$id );

				echo $html ? $html : self::map( $id, Region_Model::instance()->select( array( 'id' => $id ), 1 )->background );
		}

		/**
		 * Methode : affiche le menu
		 */
		public function menu()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				$image = $this->input->post( 'image' );

				cookie::set( 'tileset', $image );

				$image = 'images/tilesets/'.$image;

				$html = Cache::instance()->get( 'menu_tileset_'.$image );

				echo $html ? $html : self::tileset( $image );
		}

		/**
		 * Methode : connaitre le background
		 */
		public function background()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				$html = Cache::instance()->get( 'menu_background' );

				echo $html ? $html : self::generate_apercu( 'background' );
		}

		/**
		 * Methode : affiche les tilesets
		 */
		public function tilesets()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				$html = Cache::instance()->get( 'menu_tilesets' );

				echo $html ? $html : self::generate_apercu( 'tilesets' );
		}

		/**
		 * Methode : affiche le formulaire en overlay
		 */
		public function form()
		{
				$this->auto_render = FALSE;

				$id = cookie::get( 'id_map_parent' );

				if( !request::is_ajax() )
						return false;

				if( ( $coordonne = $this->input->get( 'coordonne' ) ) && $id )
				{
						$coordonne = explode( '-', $coordonne );
						$select = array( 'region_id' => $id, 'x_map' => $coordonne[0], 'y_map' => $coordonne[1] );
				}
				elseif( ($id_detail = $this->input->get( 'id_detail' ) ) !== FALSE )
				{
						$select = array( 'id_detail' => $id_detail );
				}
				else
						return false;

				if( ($row = Map_Model::instance()->select_detail( $select ) ) !== FALSE )
						$id = $row->region_id;

				$view = new View( 'editeur/form' );
				$view->x_map = $coordonne ? $coordonne[0] : ($row ? $row->x_map : false);
				$view->y_map = $coordonne ? $coordonne[1] : ($row ? $row->y_map : false);
				$view->vignettes = Map_Model::instance()->select( array( 'region_id' => $id, 'x_map' => $view->x_map, 'y_map' => $view->y_map ), false, 'z_map' );
				$view->row = $row;
				$view->actions = file::listing_dir( MODPATH.'/plugins/views' );
				$view->images = file::listing_dir( DOCROOT.'../images/modules' );
				$view->render( true );
		}

		/**
		 * Methode : affiche l'aide en overlay
		 */
		public function help()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				$view = new View( 'editeur/help' );
				$view->render( true );
		}

		/**
		 * Methode : gestion du niveau de plusieur case
		 */
		public function niveau()
		{
				$this->auto_render = FALSE;

				$id = cookie::get( 'id_map_parent' );

				if( !request::is_ajax() || !$id )
						return false;

				$new_niveau = $this->input->get( 'niveau_new' );
				$actuel_niveau = $this->input->get( 'niveau_actuel' );
				$list_position = $this->input->get( 'id' );

				if( $list_position && $new_niveau !== false && $actuel_niveau !== false )
				{
						$map = Map_Model::instance();
						$sql = "( z_map = ".$new_niveau." OR z_map = ".$actuel_niveau." ) AND region_id = ".$id." AND ( ";

						foreach( $list_position as $row )
						{
								$data = explode( '-', $row );
								$x = $data[0];
								$y = $data[1];
								$sql .= " ( x_map = ".$x." AND y_map = ".$y." ) OR";
						}

						$sql = substr( $sql, 0, -3 )." )";

						$list = $map->select( $sql, false, false, 'z_map, id_map' );

						if( $list->count() )
								foreach( $list as $row )
										if( $row->z_map == $actuel_niveau )
												$map->update( array( 'z_map' => $new_niveau ), array( 'id_map' => $row->id_map ) );
										else
												$map->update( array( 'z_map' => $actuel_niveau ), array( 'id_map' => $row->id_map ) );
				}
		}

		/**
		 * Methode : gestion du niveau de plusieur case
		 */
		public function managerObstacle()
		{
				$this->auto_render = FALSE;

				$id = cookie::get( 'id_map_parent' );

				if( !request::is_ajax() || !$id )
						return false;

				$type = $this->input->get( 'type' );
				$list_position = $this->input->get( 'id' );

				if( $list_position && $type !== false )
				{
						$map = Map_Model::instance();

						foreach( $list_position as $row )
						{
								$data = explode( '-', $row );
								$x = $data[0];
								$y = $data[1];

								$map->delete_detail( array( 'x_map' => $x, 'y_map' => $y, 'region_id' => $id ) );

								if( $type == 'add' )
										$map->insert_detail( array( 'x_map' => $x, 'y_map' => $y, 'region_id' => $id, 'passage_map' => 0 ) );
						}
				}
		}

		/**
		 * Methode : gestion du niveau de plusieur case
		 */
		public function managerBot()
		{
				$this->auto_render = FALSE;

				$id = cookie::get( 'id_map_parent' );

				if( !request::is_ajax() || !$id )
						return false;

				$type = $this->input->get( 'type' );
				$list_position = $this->input->get( 'id' );

				if( $list_position && $type !== false )
				{
						$map = Map_Model::instance();

						foreach( $list_position as $row )
						{
								$data = explode( '-', $row );
								$x = $data[0];
								$y = $data[1];

								$map->delete_detail( array( 'x_map' => $x, 'y_map' => $y, 'region_id' => $id ) );

								if( $type == 'add' )
										$map->insert_detail( array( 'x_map' => $x, 'y_map' => $y, 'region_id' => $id, 'bot' => 1, 'passage_map' => 1 ) );
						}
				}
		}

		/**
		 * Methode : pour connaitre les obstacles
		 */
		public function obstacle( $type = false )
		{
				$this->auto_render = FALSE;

				$id = cookie::get( 'id_map_parent' );

				if( !request::is_ajax() || !$id )
						return false;

				$select = array( 'region_id' => $id );

				if( $type == 'module' )
						$select['module_map !='] = '';
				elseif( $type == 'bot' )
						$select['bot'] = 1;
				else
						$select['passage_map'] = 0;


				if( ($obstacles = Map_Model::instance()->select_detail( $select, false ) ) !== FALSE )
				{
						foreach( $obstacles as $obstacle )
								$display[] = $obstacle->x_map.'-'.$obstacle->y_map;

						echo implode( '|', $display );
				}
		}

		/**
		 * Methode : gestion du cache pour soulager la BD
		 */
		public function cache()
		{
				$this->auto_render = FALSE;

				$id = cookie::get( 'id_map_parent' );

				if( !request::is_ajax() || !$id )
						return false;

				$array = self::cache_array();

				if( isset( $array['x_map'] ) && isset( $array['y_map'] ) && $array['region_id'] !== false )
				{
						if( !$this->input->post( 'delete_element' ) )
						{
								if( !$this->input->post( 'modifier' ) )
								{
										$array['background_map'] = end( explode( '/', str_replace( array( '")', ')' ), '', urldecode( $this->input->post( 'background' ) ) ) ) );
										$array['position_background_map'] = urldecode( $this->input->post( 'positionBackground' ) );
								}

								Map_Model::instance()->ajout( $array );
						}
						else
								Map_Model::instance()->delete( $array );

						Cache::instance()->delete_tag( 'database_map' );
				}

				if( ( $style = $this->input->post( 'style' ) ) && ( $image = $this->input->post( 'image' ) ) )
				{
						$image = end( explode( '/', str_replace( array( '")', ')' ), '', urldecode( $image ) ) ) );

						Region_Model::instance()->update( array( 'background' => urldecode( $image ) ), $id );

						self::map( $id, $image, $style );
				}
		}

		/**
		 * Methode : cache de chaque case
		 */
		public function cache_case()
		{
				$this->auto_render = false;

				if( !request::is_ajax() )
						return false;

				$array = self::cache_array( TRUE );

				if( isset( $array['x_map'] ) && isset( $array['y_map'] ) && $array['region_id'] !== false )
				{
						if( !$this->input->post( 'delete_element' ) )
								Map_Model::instance()->ajout_detail( $array );
						else
						{
								unset( $array['passage_map'], $array['action_map'], $array['module_map'], $array['nom_map'], $array['image'], $array['fonction'] , $array['bot'] );

								Map_Model::instance()->delete_detail( $array );
						}
				}
		}

		/**
		 * Methode privé : permet de récuperer les element envoyer par un FORM
		 */
		private function cache_array( $tileset = false )
		{
				if( $tileset )
				{
						$array = array( 'nom_map' => urldecode( $this->input->post( 'nom' ) ),
								'passage_map' => $this->input->post( 'passage' ),
								'module_map' => $this->input->post( 'module' ),
								'image' => $this->input->post( 'image' ),
								'fonction' => $this->input->post( 'fonction' ),
								'bot' => $this->input->post( 'bot' ),
								'action_map' => NULL );

						if( $array['module_map'] )
								$array['action_map'] = serialize( (object) $this->input->post() );

						if( isset( $array['fonction'] ) && ( trim( $array['fonction'] ) == '' || $array['fonction'] == '<?php ?>' ) )
								$array['fonction'] = '';
				}
				else
						$array['z_map'] = $this->input->post( 'position', 0 );

				$array['region_id'] = $this->input->post( 'region_id', cookie::get( 'id_map_parent' ) );

				$coordonne = explode( '-', $this->input->post( 'coordonne' ) );

				if( isset( $coordonne[0] ) )
						$array['x_map'] = $coordonne[0];

				if( isset( $coordonne[1] ) )
						$array['y_map'] = $coordonne[1];

				return $array;
		}

		/**
		 * Methode privé : element map
		 */
		private function map( $region_id, $image, $style = false )
		{
				$id = cookie::get( 'id_map_parent' );

				if( !$region = Region_Model::instance()->select( array( 'id' => $id ), 1 ) )
						return false;

				$element = false;

				if( ($rows = Map_Model::instance()->select( array( 'region_id' => $region_id ) ) ) !== FALSE )
						foreach( $rows as $row )
								$element[$row->x_map.'-'.$row->y_map][$row->z_map] = $row;

				$view = new View( 'editeur/map' );
				$view->image = 'images/background/'.$image;
				$view->tailleMapX = $region->x;
				$view->tailleMapY = $region->y;
				$view->element = $element;
				$view->style_table = $style;
				$html = $view->render();

				Cache::instance()->set( 'map_region_'.$region_id, $html, 'map' );

				return $html;
		}

		/**
		 * Methode privé : tileset
		 */
		private function tileset( $image )
		{
				$imageBloc = end( explode( '/', $image ) );
				$img = Image::factory( DOCROOT.'../'.$image );

				$view = new View( 'editeur/menu' );
				$view->image = $image;
				$view->height = $img->__get( 'height' ) / 32;
				$view->width = $img->__get( 'width' ) / 32;
				$view->bloc_tileset = Map_Model::instance()->select_bloc_tileset( $imageBloc );
				$html = $view->render();

				Cache::instance()->set( 'menu_tileset_'.$image, $html, 'tilesets' );

				return $html;
		}

		/**
		 * Methode privé : connaitre la liste des tilesets
		 */
		private function list_tilesets()
		{
				$dir = DOCROOT.'../images/tilesets';

				if( is_dir( $dir ) && $dh = opendir( $dir ) )
				{
						while( ($file = readdir( $dh )) !== false )
						{
								if( $file != '.' && $file != '..' && $file != '.svn' && $file != '.DS_Store' )
								{
										$fileName = explode( '.', end( explode( '-', $file ) ) );
										$optionTilesets[$fileName[0]] = $file;
								}
						}
						closedir( $dh );
				}

				ksort( $optionTilesets );

				return $optionTilesets;
		}

		/**
		 * Methode privé : gestion du background (génération en cas de non existant)
		 */
		private function background_menu( $file )
		{
				if( !is_file( DOCROOT.'../images/background/'.$file ) && preg_match( '/BG_/', $file ) )
				{
						if( !is_writable( DOCROOT.'../images/background/' ) )
								url::redirect( 'regions?msg='.urlencode( Kohana::lang( 'editeur.chmod', 'images/background' ) ) );

						$image = new Image( DOCROOT.'../images/tilesets/'.$file );
						$image->crop( 32, 32, 0, 32 )->save( DOCROOT.'../images/background/'.$file );
				}

				return url::base().'../images/background/'.$file;
		}

		/**
		 * Methode : Afficher les vignettes dans un overlay pour le choix du tileset avec lequel on travail
		 */
		public function vignette( $img = false )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				cookie::set( 'tileset', $img );
				$listImg = false;

				foreach( file::listing_dir( DOCROOT.'../images/tilesets' ) as $row )
				{
						list($width, $height, $type, $attr) = getimagesize( DOCROOT.'../images/tilesets/'.$row );
						$listImg[$height][] = $row;
				}

				ksort( $listImg );

				$v = new View( 'editeur/vignette' );
				$v->images = $listImg;
				$v->selected = $img;
				$v->render( true );
		}

}

?>