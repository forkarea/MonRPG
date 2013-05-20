<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

/**
 * Controller public du template. cette class est l'extends de tous
 * les controllers qui souhaitent afficher le template du jeu.
 *
 * @package Template
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
abstract class Template_Controller extends Authentic_Controller {

		/**
		 * Permet de faire passer l'object template qui sera la vue finale.
		 * 
		 * @var object protected
		 */
		protected $template = FALSE;

		/**
		 * Permet d'afficher ou non le template.
		 * 
		 * @var bool protected
		 */
		protected $auto_render = TRUE;

		/**
		 * Afficher ou non le menu de l'utilisateur.
		 * 
		 * @var bool protected
		 */
		protected $menu = TRUE;

		/**
		 * Afficher les informations de l'utilisateur.
		 * 
		 * @var bool protected
		 */
		protected $information_menu = TRUE;

		/**
		 * Afficher l'inventaire de l'utilisateur.
		 * 
		 * @var bool protected
		 */
		protected $inventaire_menu = TRUE;

		/**
		 * Afficher l'équipement de l'utilisateur.
		 * 
		 * @var bool protected
		 */
		protected $stuff_menu = TRUE;

		/**
		 * listing des fichiers JS à charger dans le template propre au systeme.
		 * 
		 * @var array protected
		 */
		protected $script = FALSE;

		/**
		 * listing des fichiers JS à charger dans le template propre à l'utilisateur.
		 * 
		 * @var array protected
		 */
		protected $my_script = FALSE;

		/**
		 * listing des fichiers CSS à charger dans le template mais qui ne seront pas compressés.
		 * 
		 * @var array protected
		 */
		protected $script_no_compress = FALSE;

		/**
		 * listing des fichiers CSS à charger dans le template.
		 * 
		 * @var array protected
		 */
		protected $css = FALSE;

		public function __construct()
		{
				parent::__construct();

				$this->template = new View( 'template/global' );

				$this->template->msg = $this->input->get( 'msg' );

				Event::add( 'system.post_controller', array( $this, '_render' ) );
		}

		/**
		 * Traitement du template après le chargement de toutes les méthodes (page).
		 * 
		 * @return  void
		 */
		public function _render()
		{
				if( $this->auto_render === FALSE )
						return FALSE;

				self::meta_link();

				$this->template->login = $this->user ? TRUE : FALSE;

				$this->template->admin = isset( $this->role->name ) && (in_array( 'admin', $this->role->name ) || in_array( 'modo', $this->role->name )) ? TRUE : FALSE;

				if( $this->user && $this->menu )
						self::info_user();

				$this->template->render( TRUE );
		}

		/**
		 * Gestion des informations utilisateur sur le template.
		 * 
		 * @return  void
		 */
		private function info_user()
		{
				if( $this->information_menu )
				{
						$this->template->menu = new View( 'user/information' );
						$this->template->menu->user = $this->user;
				}

				if( $this->inventaire_menu )
				{
						$arrayItem = FALSE;
						if( ($items = Item_Model::instance()->user_quick( $this->user->id ) ) !== FALSE )
								foreach( $items as $item )
										$arrayItem[$item->item_position] = $item;

						$this->template->bottom = new View( 'user/inventaire' );
						$this->template->bottom->items = $arrayItem;
						$this->template->bottom->user = $this->user;
				}
		}

		/**
		 * Methode : compresse les donnée en JSON
		 */
		protected function json( array $txtArray )
		{
				foreach( $txtArray as $txt )
						$display[] = json_encode( $txt );

				return implode( ',', $display );
		}

		/**
		 * Gestion des JS/CSS du jeu.
		 * 
		 * @return  void
		 */
		private function meta_link()
		{
				$script = array( 'jquery', 'jquery.tipsy', 'loading', 'inventaire', Router_Core::$controller );

				$css = array( 'core', Router_Core::$controller );

				if( $this->script && is_array( $this->script ) )
						$script = array_merge( $script, $this->script );

				if( $this->css && is_array( $this->css ) )
						$css = array_merge( $css, $this->css );

				$script = array_unique( $script );
				$css = array_unique( $css );

				$this->template->script = html::script( 'index.php/js_phpjs' );

				if( $this->script_no_compress )
						$this->template->script .= html::script( $this->script_no_compress );

				$this->template->script .= html::script( array( 'index.php/js_'.base64_encode( implode( '--', $script ) ) ) );

				if( $this->my_script )
						$this->template->script .= html::script( $this->my_script, TRUE );

				$this->template->css = html::stylesheet( 'index.php/css_'.base64_encode( implode( '--', $css ) ) );
		}

}

?>
