<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Tilesets_Controller extends Template_Controller {

		private $dir = false;

		public function __construct()
		{
				parent::__construct();
				parent::access( 'tileset' );
				$this->dir = DOCROOT.'../images/tilesets/';
		}

		/**
		 * Methode : page de listing générale
		 */
		public function index()
		{
				$this->template->titre = Kohana::lang( 'tileset.all_tileset' );

				$this->template->contenu = new View( 'tilesets/list' );
				$this->template->contenu->images = file::listing_dir( $this->dir );
				$this->template->contenu->chemin = $this->dir;
				$this->template->contenu->n = 0;
		}

		/**
		 * Methode : page de détail d'un tileset
		 */
		public function show( $image = false )
		{
				$image = urldecode( $image );

				if( !$image || !file_exists( $this->dir.$image ) )
						parent::redirect_erreur( 'tilesets' );

				$img = Image::factory( $this->dir.$image );

				$optionTilesets = file::listing_dir( $this->dir );

				$this->script = array( 'jquery.jeditable', 'jquery.facebox', 'tilesets' );

				$this->css = array( 'tileset', 'facebox' );

				$this->template->titre = array( Kohana::lang( 'tileset.all_tileset' ) => 'tilesets', $image => NULL );

				$this->template->contenu = new View( 'tilesets/show' );
				$this->template->contenu->image = $image;
				$this->template->contenu->tileset = Map_Model::instance()->select_bloc_tileset( $image );
				$this->template->contenu->height = $img->__get( 'height' ) / 32;
				$this->template->contenu->width = $img->__get( 'width' ) / 32;
				$this->template->contenu->optionTilesets = cookie::get( 'tileset', $optionTilesets[array_rand( $optionTilesets )] );
		}

		/**
		 * Methode : sauver block tileset ajax
		 */
		public function insert()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				if( ($array = $this->input->post() ) !== FALSE )
						echo Map_Model::instance()->insert_bloc_tileset( $array );
		}

		/**
		 * Methode : sauver block tileset ajax
		 */
		public function delete()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				if( ($array = $this->input->post() ) !== FALSE )
						Map_Model::instance()->delete_bloc_tileset( $array );
		}

		/**
		 * Methode : sauver block tileset ajax
		 */
		public function update()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				if( ($save['title'] = trim( $this->input->post( 'value' ) ) ) !== FALSE )
				{
						Map_Model::instance()->update_bloc_tileset( $save, array( 'id_drag' => $this->input->post( 'id' ) ) );

						echo $save['title'];
				}
		}

}