<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Character_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'admin' );
		}

		/**
		 * Methode : page du generateur de character
		 */
		public function index()
		{
				$this->script = array( 'character' );

				$this->css = array( 'character' );

				$this->template->titre = Kohana::lang( 'tileset.all_tileset' );

				$this->template->contenu = new View( 'character/index' );

				$this->template->contenu->hair = self::listing( 'hair' );

				$this->template->contenu->hairop = self::listing( 'hairop' );

				$this->template->contenu->option = self::listing( 'option' );

				$this->template->contenu->mante = self::listing( 'mante' );

				$this->template->contenu->body = self::listing( 'body' );

				$this->template->contenu->acce1 = self::listing( 'acce1' );

				$this->template->contenu->acce2 = self::listing( 'acce2' );

				$this->template->contenu->chmod_map = is_writable( DOCROOT.'../images/character/' );
		}

		private function listing( $dir = false, $type = false )
		{
				if( ( $listing = file::listing_dir( DOCROOT.'images/character/'.$dir.'/front' ) ) !== FALSE )
				{
						foreach( file::listing_dir( DOCROOT.'images/character/'.$dir.'/front' ) as $key => $row )
								$data[] = array( 'front' => $row,
										'back' => file_exists( DOCROOT.'images/character/'.$dir.'/back/'.$row ) ? $row : 'none.png',
										'top' => file_exists( DOCROOT.'images/character/'.$dir.'/top/'.$row ) ? $row : 'none.png' );

						return $data;
				}

				return FALSE;
		}

		public function generate()
		{
				$this->auto_render = FALSE;

				$imageList = $this->input->get( 'img' );

				$image = imagecreatetruecolor( 96, 128 );

				imagealphablending( $image, false );

				$col = imagecolorallocatealpha( $image, 0, 0, 255, 127 );

				imagefilledrectangle( $image, 0, 0, 96, 128, $col );

				imagealphablending( $image, true );
				imagealphablending( $image, false );
				imagesavealpha( $image, true );

				if( $imageList )
						foreach( $imageList as $row )
								imagecopy( $image, imagecreatefrompng( $row ), 0, 0, 0, 0, 96, 128 );

				imagepng( $image, DOCROOT.'../images/character/'.time().'.png' );

				imagedestroy( $image );

				return url::redirect( 'character/?msg='.urlencode( Kohana::lang( 'character.crea_img' ) ) );
		}

}