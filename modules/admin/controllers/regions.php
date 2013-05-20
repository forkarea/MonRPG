<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Regions_Controller extends Template_Controller {

		private $region;

		public function __construct()
		{
				parent::__construct();
				parent::access( 'region' );

				$this->region = Region_Model::instance();
		}

		/**
		 * Methode : page de listing générale
		 */
		public function index( $idRegion = 0 )
		{
				cookie::set( 'id_map_parent', $idRegion );

				$this->script = array( 'jquery.dataTables', 'listing', 'region' );

				if( $idRegion )
						$this->template->titre = self::parents( $idRegion );

				$this->template->titre[Kohana::lang( 'region.liste_regions' )] = NULL;

				$this->template->contenu = new View( 'regions/list' );
				$this->template->contenu->listing = $this->region->listing_parent();
				$this->template->contenu->idRegion = $idRegion;
		}

		/**
		 * Methode : page de détail d'une carte
		 */
		public function show( $idRegion = false )
		{
				if( !$idRegion || !is_numeric( $idRegion ) )
						return parent::redirect_erreur( 'regions' );

				cookie::set( 'id_map_parent', $idRegion );

				if( !$region = $this->region->select( array( 'id' => $idRegion ), 1 ) )
						return parent::redirect_erreur( 'regions' );

				if( !file_exists( DOCROOT.'../images/map/'.$idRegion.'_global.png' ) )
						$this->template->msg = Kohana::lang( 'region.chmod_map' );

				$this->script = array( 'jquery.validate', 'jquery.facebox', 'region' );

				$this->css = array( 'form', 'region', 'facebox' );

				$this->template->titre = array( Kohana::lang( 'region.liste_regions' ) => (!$region->id_parent ? 'regions' : '/regions/child/'.$region->id_parent ),
						Kohana::lang( 'region.show_name', ucfirst( mb_strtolower( $region->name ) ) ) => NULL );

				$this->template->button = TRUE;

				$this->template->navigation = parent::navigation( $idRegion, 'id', 'regions' );

				$this->template->contenu = new View( 'formulaire/form' );
				$this->template->contenu->action = 'regions/save';
				$this->template->contenu->id = $idRegion;
				$this->template->contenu->formulaire = new View( 'regions/show' );
				$this->template->contenu->formulaire->row = $region;
				$this->template->contenu->formulaire->listing = $this->region->listing_parent();
				$this->template->contenu->formulaire->music = file::listing_dir( DOCROOT.'../audio/' );
		}

		/**
		 * Methode : page qui va ajouter une ligne dans la BD et renvois vers la page détail
		 */
		public function insert()
		{
				$idRegion = $this->region->insert( array( 'name' => Kohana::lang( 'region.map' ).' '.time(), 'id_parent' => cookie::get( 'id_map_parent', 0 ) ) );

				return url::redirect( 'regions/show/'.$idRegion.'?msg='.urlencode( Kohana::lang( 'form.crea_valide' ) ) );
		}

		/**
		 * Méthode : page qui gère la sauvegarde ou le delete avec un renvois soit au détail ou listing
		 */
		public function save( $type = FALSE, $idRegion = FALSE )
		{
				if( ($save = $this->input->post() ) !== FALSE )
				{
						unset( $save['json_actions_length'] );

						$map = Map_Model::instance();

						if( $type == 'sauve' || $type == 'valid' )
						{
								$where_delete = '( x_map >= '.$save['x'].' OR y_map >= '.$save['y'].' ) AND region_id = '.$idRegion;

								$map->delete( $where_delete );
								$map->delete_detail( $where_delete );

								$this->region->update( $save, $idRegion );
						}
						elseif( $type == 'trash' )
						{
								if( ($region = $this->region->select( array( 'id_parent' => $idRegion ), 1 ) ) !== FALSE )
										url::redirect( 'regions/show/'.$idRegion.'?msg='.urlencode( Kohana::lang( 'region.yes_parent' ) ) );

								$this->region->delete( $idRegion );
						}
				}

				$url = 'regions/show/'.$idRegion;

				if( $type == 'annul' || $type == 'valid' || $type == 'trash' )
				{
						$url = 'regions';

						if( isset( $save['id_parent'] ) && $save['id_parent'] )
								$url = 'regions/child/'.$save['id_parent'];
				}

				return parent::redirect( $url, $type );
		}

		/**
		 * Methode : gestion du listing en ajax
		 */
		public function resultatAjax()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$arrayCol = array( 'id', 'name', 'x', 'y', 'id_parent' );

				$searchAjax = Search_Model::instance();

				$arrayResultat = $searchAjax->indexRecherche( $arrayCol, 'regions', $this->input, array( 'id_parent' => cookie::get( 'id_map_parent', 0 ) ) );

				$display = false;

				foreach( $arrayResultat as $row )
				{
						$url = 'regions/show/'.$row->id;

						$v[] = html::anchor( $url, html::image( '../images/map/'.$row->id.'_global.png', array( 'height' => 40 ) ) );
						$v[] = '<center>'.$row->id.'</center>';
						$v[] = html::anchor( $url, $row->name );
						$v[] = '<center>'.$row->x.'</center>';
						$v[] = '<center>'.$row->y.'</center>';
						$v[] = '<center>'.html::anchor( 'regions/child/'.$row->id, html::image( 'images/template/category.png' ), array( 'title' => Kohana::lang( 'region.look_all_map' ), 'class' => 'icon_list' ) )
										.' '.html::anchor( 'editeur/show/'.$row->id, html::image( 'images/template/drawings.png', array( 'title' => Kohana::lang( 'form.edit' ), 'class' => 'icon_list' ) ) )
										.' '.html::anchor( $url, html::image( 'images/template/icn_settings.png', array( 'title' => Kohana::lang( 'form.params' ), 'class' => 'icon_list' ) ) ).'</center>';

						$display .= '['.parent::json( $v ).'],';

						unset( $v );
				}

				echo $searchAjax->displayRecherche( $display, $this->input->get( 'sEcho' ) );
		}

		/**
		 * Methode :liste des parent d'une region
		 */
		private function parents( $idRegion, $array = false )
		{
				if( ($region = $this->region->select( array( 'id' => $idRegion ), 1 ) ) !== FALSE )
				{
						if( $region->id_parent )
						{
								$array[$region->name] = 'regions/child/'.$region->id;
								return self::parents( $region->id_parent, $array );
						}
						else
								$array[$region->name] = 'regions';
				}

				if( $array )
						return array_reverse( $array );

				return array( Kohana::lang( 'region.no_parent_map' ) => 'regions' );
		}

		/**
		 * Methode :
		 */
		public function vignette_bg( $img = false )
		{
				self::vignette_global( $img = false, 'background', 36, 36 );
		}

		/**
		 * Methode :
		 */
		public function vignette_fight( $img = false )
		{
				self::vignette_global( $img = false, 'terrain', 105, 53 );
		}

		/**
		 * Methode :
		 */
		private function vignette_global( $img, $dossier, $x, $y )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'formulaire/vignette' );
				$v->images = file::listing_dir( DOCROOT.'../images/'.$dossier );
				$v->selected = $img;
				$v->class = $dossier;
				$v->module = $dossier;
				$v->width = $x;
				$v->height = $y;
				$v->render( true );
		}

}
?>