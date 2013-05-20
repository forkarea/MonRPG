<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Export_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'export' );
		}

		/**
		 * Methode : page générale de l export
		 */
		public function index()
		{
				$this->template->titre = Kohana::lang( 'export.title' );

				$this->template->contenu = new View( 'export/index' );

				$this->template->contenu->listing = Region_Model::instance()->listing_parent();

				$this->template->contenu->chmod = !is_writable( MODPATH.'../tmp/' ) ? '<h4 class="alert_error">chmod 777 '.MODPATH.'../tmp/'.'</h4>' : FALSE;
		}

		/**
		 * Methode : on export le fichier
		 */
		public function send( $idRegion = FALSE )
		{
				$this->auto_render = FALSE;

				if( !$region = Region_Model::instance()->select( array( 'id' => $idRegion ), 1 ) )
						return url::redirect( 'export?msg='.urlencode( Kohana::lang( 'export.error_id_region' ) ) );

				$n = 1;
				$tilesets = $images = $listFile = FALSE;

				$v = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
				$v .= '<map version="1.0" orientation="orthogonal" width="'.$region->x.'" height="'.$region->y.'" tilewidth="'.Kohana::config( 'map.taille_case' ).'" tileheight="'.Kohana::config( 'map.taille_case' ).'">'."\n";
				$v .= '<properties><property name="name" value="'.$region->name.'"/></properties>'."\n";

				$listFile[$region->background] = $region->background;

				list($width, $height, $type, $attr) = getimagesize( DOCROOT.'../images/tilesets/'.$region->background );

				$x_img = $width / Kohana::config( 'map.taille_case' );
				$y_img = $height / Kohana::config( 'map.taille_case' );

				$v .= '<tileset firstgid="'.$n.'" name="'.$region->background.'" tilewidth="'.Kohana::config( 'map.taille_case' ).'" tileheight="'.Kohana::config( 'map.taille_case' ).'"><image source="'.$region->background.'" width="'.$width.'" height="'.$height.'"/></tileset>';

				for( $y = 0; $y < $y_img; $y++ )
						for( $x = 0; $x < $x_img; $x++ )
						{
								$images[$region->background][($x > 0 ? '-' : '').($x * Kohana::config( 'map.taille_case' ) ).'px '.($y > 0 ? '-' : '').($y * Kohana::config( 'map.taille_case' )).'px'] = $n;
								$n++;
						}

				$query_tile = Database::instance()->select( 'background_map' )->from( 'element_map' )->where( 'region_id', $region->id )->groupby( 'background_map' )->get();
				if( $query_tile->count() )
				{
						foreach( $query_tile as $row )
						{
								if( !isset( $listFile[$row->background_map] ) )
								{
										$listFile[$row->background_map] = $row->background_map;

										list($width, $height, $type, $attr) = getimagesize( DOCROOT.'../images/tilesets/'.$row->background_map );

										$x_img = $width / Kohana::config( 'map.taille_case' );
										$y_img = $height / Kohana::config( 'map.taille_case' );

										$v .= '<tileset firstgid="'.$n.'" name="'.$row->background_map.'" tilewidth="'.Kohana::config( 'map.taille_case' ).'" tileheight="'.Kohana::config( 'map.taille_case' ).'"><image source="'.$row->background_map.'" width="'.$width.'" height="'.$height.'"/></tileset>';

										for( $y = 0; $y < $y_img; $y++ )
												for( $x = 0; $x < $x_img; $x++ )
												{
														$images[$row->background_map][($x > 0 ? '-' : '').($x * Kohana::config( 'map.taille_case' ) ).'px '.($y > 0 ? '-' : '').($y * Kohana::config( 'map.taille_case' )).'px'] = $n;
														$n++;
												}
								}
						}
				}

				$v .= '<layer name="fond" width="'.$region->x.'" height="'.$region->y.'">'."\n";
				$v .= '<data encoding="csv">'."\n";

				$x = $y = 0;
				$list = FALSE;

				for( $y = 0; $y < $region->y; $y++ )
						for( $x = 0; $x < $region->x; $x++ )
								$list[] = 2;

				$v .= implode( ',', $list );

				$v .= '</data>'."\n";
				$v .= '</layer>'."\n";

				foreach( array( -3, -2, -1, 0, 1, 2, 3 ) as $row )
				{
						$my_element = FALSE;

						$query_ele = Database::instance()->select()->from( 'element_map' )->where( array( 'region_id' => $region->id, 'z_map' => $row ) )->get();
						if( $query_ele->count() )
								foreach( $query_ele as $ele )
										if( isset( $images[$ele->background_map][str_replace( '-0px', '0px', $ele->position_background_map )] ) )
												$my_element[$ele->x_map][$ele->y_map] = $images[$ele->background_map][str_replace( '-0px', '0px', $ele->position_background_map )];

						$v .= '<layer name="niveau '.$row.'" width="'.$region->x.'" height="'.$region->y.'">'."\n";
						$v .= '<data encoding="csv">'."\n";

						$x = $y = 0;
						$list = FALSE;

						for( $y = 0; $y < $region->y; $y++ )
								for( $x = 0; $x < $region->x; $x++ )
										$list[] = isset( $my_element[$x][$y] ) ? $my_element[$x][$y] : 0;

						$v .= implode( ',', $list );

						$v .= '</data>'."\n";
						$v .= '</layer>'."\n";
				}

				$v .= '</map>'."\n";

				if( !file_exists( DOCROOT.'../tmp/tiled/'.$region->id ) )
						mkdir( DOCROOT.'../tmp/tiled/'.$region->id, 0777, TRUE );

				if( ($fp = fopen( DOCROOT.'../tmp/tiled/'.$region->id.'/'.$region->name.'.tmx', "w" ) ) )
				{
						fputs( $fp, $v, strlen( $v ) );
						fclose( $fp );
				}

				foreach( $listFile as $row )
						copy( DOCROOT.'../images/tilesets/'.$row, DOCROOT.'../tmp/tiled/'.$region->id.'/'.$row );

				require_once MODPATH.'global/libraries/Pclzip.php';
				$archive = new PclZip( DOCROOT.'../tmp/tiled/'.$region->name.'.zip' );
				$v_list = $archive->create( DOCROOT.'../tmp/tiled/'.$region->id, PCLZIP_OPT_REMOVE_ALL_PATH );

				file::rm_all_dir( DOCROOT.'../tmp/tiled/'.$region->id );

				if( $v_list == 0 )
						return url::redirect( 'export?msg='.urlencode( $archive->errorInfo( true ) ) );

				return url::redirect( url::base().'../tmp/tiled/'.$region->name.'.zip' );
		}

}

?>
