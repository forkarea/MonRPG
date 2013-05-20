<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Cache_Controller extends Authentic_Controller {

		/**
		 * Méthode : pour empêcher un utilisateur d'accéder directement à ce controller
		 */
		public function index()
		{
				return self::redirection( Kohana::lang( 'logger.no_acces' ) );
		}

		/**
		 * Methode : purger tout les caches
		 */
		public function deleteAll()
		{
				Cache::instance()->delete_all();
				return url::redirect( '?msg='.urlencode( Kohana::lang( 'cache.all_cache' ) ) );
		}

		public function map( $id_region = FALSE )
		{
				if( !is_writable( DOCROOT.'../images/map' ) )
						return url::redirect( '?msg='.urlencode( Kohana::lang( 'cache.chmod_dir' ) ) );

				set_time_limit( 0 );

				if( $id_region )
						$id_region = array( 'id' => $id_region );

				if( ($regions = Region_Model::instance()->select( $id_region ) ) !== FALSE )
				{
						foreach( $regions as $region )
						{
								if( ($rows = Map_Model::instance()->select( array( 'region_id' => $region->id ) ) ) !== FALSE )
										foreach( $rows as $row )
												$element[$row->z_map][$row->x_map.'-'.$row->y_map] = $row;

								$image = imagecreatetruecolor( Kohana::config( 'map.taille_case' ) * $region->x, Kohana::config( 'map.taille_case' ) * $region->y );

								imagealphablending( $image, false );
								$col = imagecolorallocatealpha( $image, 255, 255, 255, 127 );
								imagefilledrectangle( $image, 0, 0, Kohana::config( 'map.taille_case' ) * $region->x, Kohana::config( 'map.taille_case' ) * $region->y, $col );
								imagealphablending( $image, true );
								imagealphablending( $image, false );
								imagesavealpha( $image, true );

								imagepng( $image, DOCROOT.'../images/map/'.$region->id.'_trans.png' );

								$imageInf = imagecreatefrompng( DOCROOT.'../images/map/'.$region->id.'_trans.png' );
								imagesavealpha( $imageInf, true );

								$imageSup = imagecreatefrompng( DOCROOT.'../images/map/'.$region->id.'_trans.png' );
								imagesavealpha( $imageSup, true );

								$imageGlobal = imagecreatefrompng( DOCROOT.'../images/map/'.$region->id.'_trans.png' );
								imagesavealpha( $imageSup, true );

								for( $z = -4; $z < 3; $z++ )
								{
										for( $y = 0; $y < $region->y; $y++ )
										{
												for( $x = 0; $x < $region->x; $x++ )
												{
														if( $z == -4 )
														{
																if( is_file( DOCROOT.'../images/tilesets/'.$region->background ) )
																{
																		if( !is_file( DOCROOT.'../images/background/'.$region->background ) )
																		{
																				$imageBG = new Image( DOCROOT.'../images/tilesets/'.$region->background );
																				$imageBG->crop( Kohana::config( 'map.taille_case' ), Kohana::config( 'map.taille_case' ), 0, 0 )->save( DOCROOT.'../images/background/'.$region->background );
																		}

																		$source = imagecreatefrompng( DOCROOT.'../images/background/'.$region->background );
																		imagecopy( $imageInf, $source, ($x * Kohana::config( 'map.taille_case' ) ), ($y * Kohana::config( 'map.taille_case' ) ), 0, 0, Kohana::config( 'map.taille_case' ), Kohana::config( 'map.taille_case' ) );
																		imagecopy( $imageGlobal, $source, ($x * Kohana::config( 'map.taille_case' ) ), ($y * Kohana::config( 'map.taille_case' ) ), 0, 0, Kohana::config( 'map.taille_case' ), Kohana::config( 'map.taille_case' ) );
																}
														}
														else if( isset( $element[$z][$x.'-'.$y] ) )
														{
																$pos = explode( ' ', str_replace( array( 'px', '%', '-' ), '', $element[$z][$x.'-'.$y]->position_background_map ) );
																$source = imagecreatefrompng( DOCROOT.'../images/tilesets/'.urldecode( $element[$z][$x.'-'.$y]->background_map ) );
																imagecopy( $z > 0 ? $imageSup : $imageInf, $source, ($x * Kohana::config( 'map.taille_case' ) ), ($y * Kohana::config( 'map.taille_case' ) ), $pos[0], $pos[1], Kohana::config( 'map.taille_case' ), Kohana::config( 'map.taille_case' ) );
																imagecopy( $imageGlobal, $source, ($x * Kohana::config( 'map.taille_case' ) ), ($y * Kohana::config( 'map.taille_case' ) ), $pos[0], $pos[1], Kohana::config( 'map.taille_case' ), Kohana::config( 'map.taille_case' ) );
														}
												}
										}
								}

								imagepng( $imageInf, DOCROOT.'../images/map/'.$region->id.'_inf.png' );
								imagepng( $imageSup, DOCROOT.'../images/map/'.$region->id.'_sup.png' );
								imagepng( $imageGlobal, DOCROOT.'../images/map/'.$region->id.'_global.png' );

								$image = new Image( DOCROOT.'../images/map/'.$region->id.'_global.png' );
								$image->resize( 608, 608, Image::WIDTH )->save( DOCROOT.'../images/map/'.$region->id.'_global_600.png' );

								$image = new Image( DOCROOT.'../images/map/'.$region->id.'_global.png' );
								$image->resize( 90, 90, Image::WIDTH )->save( DOCROOT.'../images/map/'.$region->id.'_global_90.png' );

								unset( $imageInf, $imageSup, $imageGlobal, $image, $source, $element );
						}
				}

				return url::redirect( $this->input->get( 'url_return' ).'?msg='.urlencode( Kohana::lang( 'cache.all_cache_map' ) ) );
		}

}

?>
