<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Elements_Controller extends Template_Controller {

		private $elements = FALSE;

		public function __construct()
		{
				parent::__construct();
				parent::access( 'element' );

				$this->elements = Map_Model::instance();
		}

		/**
		 * Methode : page de listing générale
		 */
		public function index()
		{
				$this->script = array( 'jquery.dataTables', 'listing' );

				$this->template->titre = Kohana::lang( 'element.all_module' );

				$this->template->contenu = new View( 'elements/list' );
		}

		/**
		 * Methode : page de détail d'un article
		 */
		public function show( $idElement = FALSE )
		{
				if( !$idElement || !is_numeric( $idElement ) )
						return parent::redirect_erreur( 'elements' );

				if( !$element = $this->elements->select_detail( array( 'id_detail' => $idElement ) ) )
						return parent::redirect_erreur( 'elements' );

				$this->script = array( 'jquery.validate', 'jquery.facebox', 'elements' );

				$this->css = array( 'form', 'element', 'facebox' );

				$this->template->titre = array( Kohana::lang( 'element.all_module' ) => 'elements', $element->nom_map => NULL );

				$this->template->button = TRUE;

				$this->template->navigation = $this->elements->navigation( $idElement, 'id_detail', 'element_detail' );
				$this->template->navigationURL = 'elements/show';

				$this->template->contenu = new View( 'formulaire/form' );
				$this->template->contenu->action = 'elements/save';
				$this->template->contenu->id = $idElement;
				$this->template->contenu->formulaire = new View( 'elements/show' );
				$this->template->contenu->formulaire->row = $element;
				$this->template->contenu->formulaire->data = $element;
		}

		/**
		 * Méthode : page qui gère la sauvegarde ou le delete avec un renvois soit au détail ou listing
		 */
		public function save( $type = FALSE, $idElement = FALSE )
		{
				if( ($save = $this->input->post() ) !== FALSE )
				{
						if( isset( $save['fonction'] ) && ( trim( $save['fonction'] ) == '' || $save['fonction'] == '<?php ?>' ) )
								$save['fonction'] = '';

						if( $type == 'sauve' || $type == 'valid' )
								$this->elements->update_detail( $save, array( 'id_detail' => $idElement ) );
						elseif( $type == 'trash' )
								$this->elements->delete_detail( array( 'id_detail' => $idElement ) );
				}

				$url = 'elements/show/'.$idElement;

				if( $type == 'annul' || $type == 'valid' || $type == 'trash' )
						$url = 'elements';

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

				$arrayCol = array( 'id_detail', 'nom_map', 'module_map', 'region_id', 'x_map', 'y_map' );

				$searchAjax = Search_Model::instance();

				$arrayResultat = $searchAjax->indexRecherche( $arrayCol, 'element_detail', $this->input, array( 'module_map !=' => '' ) );

				$display = false;

				$list_carte = Region_Model::instance()->listing_parent();

				foreach( $arrayResultat as $row )
				{
						$url = 'elements/show/'.$row->id_detail;

						$v[] = '<center>'.$row->id_detail.'</center>';
						$v[] = html::anchor( $url, $row->nom_map ? $row->nom_map : '<strong class="rouge">'.Kohana::lang( 'form.inconnu' ).'</strong>'  );
						$v[] = '<center>'.$row->module_map.'</center>';
						$v[] = '<center>'.$list_carte[$row->region_id]->name.'</center>';
						$v[] = '<center>'.$row->x_map.'</center>';
						$v[] = '<center>'.$row->y_map.'</center>';
						$v[] = '<center>'.html::anchor( $url, html::image( 'images/template/drawings.png', array( 'title' => Kohana::lang( 'form.edit' ), 'class' => 'icon_list' ) ) ).'</center>';

						$display .= '['.parent::json( $v ).'],';

						unset( $v );
				}

				echo $searchAjax->displayRecherche( $display, $this->input->get( 'sEcho' ) );
		}

		/**
		 * Methode :
		 */
		public function vignette( $img = false )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'formulaire/vignette' );
				$v->images = file::listing_dir( DOCROOT.'../images/modules' );
				$v->selected = $img;
				$v->module = 'modules';
				$v->width = 96;
				$v->height = 96;
				$v->render( true );
		}

}

?>