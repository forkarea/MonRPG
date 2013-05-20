<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Import_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'import' );
		}

		/**
		 * Methode : page générale de l import
		 */
		public function index()
		{
				$this->template->titre = Kohana::lang( 'import.title' );

				$this->template->contenu = new View( 'import/index' );

				$this->template->contenu->chmod = !is_writable( MODPATH.'../tmp/' ) ? '<h4 class="alert_error">chmod 777 '.MODPATH.'../tmp/'.'</h4>' : FALSE;
		}

		/**
		 * Methode : on importe le fichier
		 */
		public function send()
		{
				$this->auto_render = FALSE;

				if( !isset( $_FILES['tiled'] ) && $_FILES['tiled'] )
						return url::redirect( 'import?msg='.urlencode( Kohana::lang( 'import.no_file' ) ) );

				$fichier = basename( $_FILES['tiled']['name'] );

				if( strrchr( $_FILES['tiled']['name'], '.' ) != '.zip' )
						return url::redirect( 'import?msg='.urlencode( Kohana::lang( 'import.no_extension_zip' ) ) );

				$fichier = strtr( $fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy' );
				$fichier = preg_replace( '/([^.a-z0-9]+)/i', '-', $fichier );

				if( !@move_uploaded_file( $_FILES['tiled']['tmp_name'], MODPATH.'../tmp/'.$fichier ) )
						return url::redirect( 'import?msg='.urlencode( Kohana::lang( 'import.no_save_zip' ) ) );

				require_once MODPATH.'global/libraries/Pclzip.php';
				$archive = new PclZip( MODPATH.'../tmp/'.$fichier );

				if( ($list = $archive->extract( PCLZIP_OPT_PATH, MODPATH.'../tmp/' ) ) === FALSE )
						return url::redirect( 'import?msg='.urlencode( Kohana::lang( 'import.error_compress' ) ) );

				$region = FALSE;

				foreach( $list as $row )
				{
						if( !$row['folder'] )
						{
								if( strrchr( $row['stored_filename'], '.' ) == '.tmx' )
										$region = self::tmx( $row['stored_filename'], $row['filename'] );
								else
										copy( $row['filename'], DOCROOT.'../images/tilesets/'.end( explode( '/', $row['stored_filename'] ) ) );

								unlink( $row['filename'] );
						}
				}

				return url::redirect( 'cache/map/'.$region.'?url_return=regions/show/'.$region );
		}

		private function tmx( $name, $tmp_name )
		{
				$extensions = array( '.tmx' );
				$extension = strrchr( $name, '.' );

				if( !in_array( $extension, $extensions ) )
						return url::redirect( 'import?msg='.urlencode( Kohana::lang( 'import.no_extension' ) ) );

				$xml = simplexml_load_file( $tmp_name );

				$img_tile = FALSE;

				$n = 1;

				foreach( $xml->tileset as $tileset )
				{
						$attribut = $tileset->attributes();
						$attribut_img = $tileset->image->attributes();

						$x_img = $attribut_img->width / $attribut->tilewidth;
						$y_img = $attribut_img->height / $attribut->tileheight;

						for( $y = 0; $y < $y_img; $y++ )
						{
								for( $x = 0; $x < $x_img; $x++ )
								{
										$img_tile[$n] = array( 'position' => ($x > 0 ? '-' : '').($x * $attribut->tilewidth ).'px '.($y > 0 ? '-' : '').($y * $attribut->tileheight).'px', 'img' => end( explode( '/', (string) $attribut_img->source ) ) );
										$n++;
								}
						}
				}

				$arrayResult = FALSE;

				foreach( $xml->layer as $layer )
				{
						$attribut = $layer->attributes();

						if( $attribut->name != 'fond' )
						{
								if( (string) $layer->data->attributes() != 'csv' )
										return url::redirect( 'import?msg='.urlencode( Kohana::lang( 'import.no_csv' ) ) );

								$data = explode( ',', $layer->data );

								$x = $y = 0;

								foreach( $data as $row )
								{
										if( $row > 0 && isset( $img_tile[(int) $row] ) )
												$arrayResult[str_replace( 'niveau ', '', $attribut->name )][$x][$y] = $img_tile[(int) $row];

										$x++;

										if( $x >= $attribut->width )
										{
												$x = 0;
												$y++;
										}
								}
						}
				}

				foreach( $xml->properties->property as $row )
						if( $row->attributes()->name == 'name' )
						{
								$name = (string) $row->attributes()->value;
								break;
						}

				$query = Database::instance()->select( 'id' )->from( 'regions' )->where( 'name', $name )->limit( 1 )->get();

				$region = FALSE;

				if( $query->count() )
				{
						$region = $query->current()->id;
						Database::instance()->delete( 'element_map', array( 'region_id' => $region ) );
						Database::instance()->update( 'regions', array( 'x' => $attribut->width, 'y' => $attribut->height ), array( 'name' => $name ) );
				}
				elseif( ($query = Database::instance()->insert( 'regions', array( 'name' => $name, 'x' => $attribut->width, 'y' => $attribut->height ) ) ) !== FALSE )
						$region = $query->insert_id();
				else
						return url::redirect( 'import?msg='.urlencode( Kohana::lang( 'import.error_crea_map' ) ) );

				if( !$arrayResult )
						return url::redirect( 'import?msg='.urlencode( Kohana::lang( 'import.error_vide_map' ) ) );

				foreach( $arrayResult as $z => $key )
						foreach( $key as $x => $key2 )
								foreach( $key2 as $y => $key3 )
										Database::instance()->insert( 'element_map', array( 'region_id' => $region,
												'x_map' => $x,
												'y_map' => $y,
												'z_map' => $z,
												'background_map' => $key3['img'],
												'position_background_map' => $key3['position'] ) );

				return $region;
		}

}

?>
