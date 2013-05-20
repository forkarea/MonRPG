<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Pour que l'utilisateur récupère du HP et MP.
 *
 * @package Action_sleep
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Sleep_Controller extends Action_Controller {

		/**
		 * Affiche l'alerte de présentation pour dormir.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'sleep/plugin' );
				$v->data = $this->data;
				$v->valide = $this->user->hp == $this->user->hp_max && $this->user->mp == $this->user->mp_max ? FALSE : TRUE;
				$v->render( TRUE );
		}

		/**
		 * Traitement de l'action dormir.
		 * 
		 * @return  void
		 */
		public function show()
		{
				$this->auto_render = FALSE;
				
				if( $this->user->hp == $this->user->hp_max && $this->user->mp == $this->user->mp_max )
						$txt = Kohana::lang( 'sleep.no_sleep' );
				else
				{
						if( !$this->data->prix || ( is_numeric( $this->data->prix ) && $this->user->argent >= $this->data->prix ) )
						{
								$this->user->argent -= $this->data->prix;
								$this->user->hp = $this->user->hp_max;
								$this->user->mp = $this->user->mp_max;

								$this->user->update();

								History_Model::instance()->user_insert( $this->user->id, $this->data->id_module, FALSE, 'sleep' );

								$txt = Kohana::lang( 'sleep.yes_sleep' );
						}
						else
								$txt = Kohana::lang( 'sleep.no_money_sleep' );
				}

				echo $txt;
				
				echo '<script>refresh_user();</script>';
		}

}

?>