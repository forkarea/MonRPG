<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Controller public des users.
 *
 * @package Action
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class User_Controller extends Template_Controller {

		/**
		 * Page de détail d'un personnage
		 * 
		 * @return  void
		 */
		public function show( $type )
		{
				parent::login();

				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$attaque = $defense = 0;

				$listingItem = $listingCle = $listingStuff = $arrayStuff = FALSE;

				if( ($stuffs = Item_Model::instance()->stuff_user( $this->user->id ) ) !== FALSE )
						foreach( $stuffs as $stuff )
						{
								$arrayStuff[$stuff->item_id] = $stuff;
								if( $stuff->attaque )
										$attaque += $stuff->attaque;
								if( $stuff->defense )
										$defense += $stuff->defense;
						}

				if( ($items = Item_Model::instance()->select( $this->user->id ) ) !== FALSE )
						foreach( $items as $item )
								if( !$item->item_position && !$item->cle && !$item->protect )
										$listingItem[$item->item_id] = $item;
								elseif( $item->protect && !$item->cle )
										$listingStuff[$item->item_id] = $item;
								elseif( $item->cle )
										$listingCle[$item->item_id] = $item;

				echo html::stylesheet( 'index.php/css_'.base64_encode( implode( '--', array( 'facebox', 'user' ) ) ) );

				$v = new View( 'user/'.$type );
				$v->stats = Statistiques_Model::instance()->user_show( $this->user->id );
				$v->user = $this->user;
				$v->modif = TRUE;
				$v->items = $listingItem;
				$v->cles = $listingCle;
				$v->stuffs = $listingStuff;
				$v->arrayStuff = $arrayStuff;
				$v->attaque = number_format( $attaque );
				$v->defense = number_format( $defense );

				$v->render( TRUE );
		}

		/**
		 * Permet de connaitre les informations sur le module ou se trouve l'user.
		 *
		 * @return void
		 */
		public function move()
		{
				parent::login();

				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$this->user->x = $this->input->post( 'x', $this->user->x );
				$this->user->y = $this->input->post( 'y', $this->user->y );

				$this->user->update();

				Bot_Model::instance()->update( array( 'user_id' => NULL ), array( 'user_id' => $this->user->id ) );
		}

		/**
		 * Page qui affiche les avatars pour modifier
		 * 
		 * @return  void
		 */
		public function listing_avatar()
		{
				parent::login();

				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'user/avatar' );
				$v->avatar = file::listing_dir( DOCROOT.'images/character' );
				$v->render( TRUE );
		}

		/**
		 * SAuvegarder le nouvel avatar d'un user
		 * 
		 * @return  void
		 */
		public function update_avatar( $avatar )
		{
				if( !request::is_ajax() )
						return FALSE;

				parent::login();

				$this->auto_render = FALSE;

				$this->user->avatar = $avatar;
				$this->user->update();
		}

		/**
		 * Sauvegarder le nouvel mot de passe d'un user
		 * 
		 * @return  void
		 */
		public function update_pwd()
		{
				if( !request::is_ajax() )
						return FALSE;

				parent::login();

				$this->auto_render = FALSE;

				$new_pwd = $this->input->post( 'new_pwd' );

				if( strlen( $new_pwd ) <= 4 )
						$msg = Kohana::lang( 'user.error_pwd' );
				else
				{
						$this->user->update( array( 'password' => Auth::instance()->hash_password( $new_pwd ) ) );
						$msg = Kohana::lang( 'user.valid_change_pwd' );
				}

				echo '<div class="msg">'.$msg.'</div>';
		}

		public function information()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() || !$this->user )
						return FALSE;

				echo '{
							"hp": '.json_encode( graphisme::BarreGraphique( $this->user->hp, $this->user->hp_max, 160, Kohana::lang( 'user.hp' ) ) ).',
							"mp": '.json_encode( graphisme::BarreGraphique( $this->user->mp, $this->user->mp_max, 160, Kohana::lang( 'user.mp' ) ) ).',
							"xp": '.json_encode( graphisme::BarreGraphique( $this->user->xp, $this->user->niveau_suivant(), 992, Kohana::lang( 'user.xp' ) ) ).',
							"niveau": "'.$this->user->niveau.'",
							"argent": "'.number_format( $this->user->argent ).' '.Kohana::config( 'game.money' ).'"
						}';
		}

		public function inventaire()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() || !$this->user )
						return FALSE;

				$arrayItem = FALSE;
				if( ($items = Item_Model::instance()->user_quick( $this->user->id ) ) !== FALSE )
						foreach( $items as $item )
								$arrayItem[$item->item_position] = $item;

				$v = new View( 'user/inventaire' );
				$v->items = $arrayItem;
				$v->user = $this->user;
				$v->render( TRUE );
		}

}

?>