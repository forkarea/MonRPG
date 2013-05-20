<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

/**
 * Permet de connaitre toutes les informations sur un : objet (équipement aussi).
 *
 * @package Item
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
class Item_Model extends Model {

		/**
		 * Permet de créer une instance et donc de ne pas faire des doublons.
		 * 
		 * @var object protected
		 */
		protected static $instance;

		/**
		 * Permet de ne pas faire des multi appel d'object.
		 *
		 * @return class return la classe construite
		 */
		public static function instance()
		{
				if( Item_Model::$instance === NULL )
						return new Item_Model;

				return Item_Model::$instance;
		}

		/**
		 * Faire une sélection sur la table item en joiture avec users_items.
		 *
		 * @param integer ID utilisateur
		 * @param integer ID de l'objet
		 * @param integer limite des lignes
		 * @return mixe retourne un object sinon false
		 */
		public function select( $user_id = false, $item_id = false, $limit = false )
		{
				if( $user_id )
				{
						$this->db->select( '*, count(*) as nbr' )
										->join( 'users_items', 'users_items.item_id', 'items.id' )
										->where( 'users_items.user_id', $user_id )
										->groupby( array( 'users_items.item_id', 'users_items.user_id' ) );
				}

				if( $item_id )
						$this->db->where( 'items.id', $item_id );

				if( $limit )
						$this->db->limit( $limit );

				$query = $this->db->from( 'items' )->get();

				return $query->count() ? (!$limit || $limit > 1 ? $query : $query->current() ) : FALSE;
		}

		/**
		 * Faire une insertion d'une ligne SQL.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function insert( array $set )
		{
				return parent::model_insert( 'items', $set );
		}

		/**
		 * Faire une mise à jour d'une ligne.
		 *
		 * @param array valeur à mettre à jour
		 * @param integer ID de la ligne
		 * @return mixe retourne un object sinon false
		 */
		public function update( array $set, $item_id )
		{
				return parent::model_update( 'items', $set, array( 'id' => $item_id ) );
		}

		/**
		 * Supprimer une ligne.
		 *
		 * @param integer ID de la ligne
		 * @return	 bool retour false ou true
		 */
		public function delete( $item_id )
		{
				return parent::model_delete( 'items', array( 'id' => $item_id ) );
		}

		/**
		 * Faire une sélection sur les objets d'un utilisateur en mode IN array.
		 *
		 * @param array ID des objets
		 * @return mixe retourne un object sinon false
		 */
		public function in( array $in )
		{
				$query = $this->db->from( 'items' )->in( 'id', $in )->get();

				return $query->count() ? $query : FALSE;
		}

		/**
		 * Faire une sélection sur les objets d'un utilisateur.
		 *
		 * @param integer ID de l'utilisateur
		 * @param integer ID de l'objet
		 * @return mixe retourne un object sinon false
		 */
		public function user_quick( $user_id, $item_id = false )
		{
				if( $item_id )
						$this->db->where( array( 'users_items.user_id' => $user_id, 'users_items.item_id' => $item_id ) );
				else
						$this->db->where( array( 'users_items.user_id' => $user_id, 'users_items.item_position >' => 0 ) );

				$query = $this->db->select( '*, count(*) as nbr' )
								->from( 'items' )
								->join( 'users_items', 'users_items.item_id', 'items.id' )
								->groupby( array( 'users_items.item_id', 'users_items.user_id' ) )
								->get();

				return $query->count() ? $item_id ? $query->current() : $query  : FALSE;
		}

		/**
		 * Faire une insertion d'un objet pour un utilisateur.
		 *
		 * @param integer ID de l'utilisateur
		 * @param integer ID de l'objet
		 * @param integer ID de la position
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function user_insert( $user_id, $item_id, $item_position = 0 )
		{
				return parent::model_insert( 'users_items', array( 'user_id' => $user_id, 'item_id' => $item_id, 'item_position' => $item_position ) );
		}

		/**
		 * Supprimer tous les objets d'un utilisateur.
		 *
		 * @param integer ID de l'utilisateur
		 * @param integer ID de l'objet
		 * @param bool si on delete tous les objets de l'utilisateur
		 * @return	 bool retour false ou true
		 */
		public function user_delete( $user_id, $item_id, $all = false )
		{
				return $this->db->query( 'DELETE FROM users_items WHERE user_id = '.$user_id.' AND item_id = '.$item_id.(!$all ? ' LIMIT 1' : '') );
		}

		/**
		 * Supprimer tous les objets d'un utilisateur.
		 *
		 * @param integer ID de la ligne
		 * @return	 bool retour false ou true
		 */
		public function user_delete_all( $user_id )
		{
				return parent::model_delete( 'users_items', array( 'user_id' => $user_id ) );
		}

		/**
		 * Faire une mise à jour d'un objet utilisateur.
		 *
		 * @param array valeur à mettre à jour
		 * @param integer ID de l'utilisateur
		 * @param integer ID de l'objet
		 * @return mixe retourne un object sinon false
		 */
		public function user_update( array $set, $user_id, $item_id )
		{
				return parent::model_update( 'users_items', $set, array( 'user_id' => $user_id, 'item_id' => $item_id ) );
		}

		/**
		 * Faire une sélection sur l'équipement d'un utilisateur.
		 *
		 * @param integer ID de l'utilisateur
		 * @param integer ID de l'objet (équipement)
		 * @return mixe retourne un object sinon false
		 */
		public function stuff_user( $user_id, $item_id = false )
		{
				if( $item_id )
						$this->db->where( 'items.id', $item_id );

				$query = $this->db->from( 'users_stuffs' )
								->join( 'items', 'items.id', 'users_stuffs.item_id' )
								->where( 'users_stuffs.user_id', $user_id )
								->get();

				return $query->count() ? $item_id ? $query->current() : $query  : FALSE;
		}

		/**
		 * Faire une insertion d'un équipement pour un utilisateur.
		 *
		 * @param integer ID de l'utilisateur
		 * @param integer ID de l'objet
		 * @param integer ID de la position
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function stuff_insert( $user_id, $item_id, $item_position = 0 )
		{
				return parent::model_insert( 'users_stuffs', array( 'user_id' => $user_id, 'item_id' => $item_id, 'item_position' => $item_position ) );
		}

		/**
		 * Supprimer tous les équipements d'un utilisateur.
		 *
		 * @param integer ID de l'utilisateur
		 * @param integer ID de l'objet
		 * @param integer ID de la position
		 * @param bool si on delete tous les objets de l'utilisateur
		 * @return	 bool retour false ou true
		 */
		public function stuff_delete( $user_id, $item_id = false, $position = false, $all = false )
		{
				$sql = 'user_id = '.$user_id;

				if( $item_id )
						$sql .= ' AND item_id = '.$item_id;

				if( $position )
						$sql .= ' AND item_position = '.$position;

				if( !$all )
						$sql .= ' LIMIT 1';

				return $this->db->query( 'DELETE FROM users_stuffs WHERE '.$sql );
		}

		/**
		 * Faire une mise à jour d'un équipement utilisateur.
		 *
		 * @param array valeur à mettre à jour
		 * @param integer ID de l'utilisateur
		 * @param integer ID de l'équipement
		 * @return mixe retourne un object sinon false
		 */
		public function stuff_update( array $set, $user_id, $item_id )
		{
				return parent::model_update( 'users_stuffs', $set, array( 'user_id' => $user_id, 'item_id' => $item_id ) );
		}

		/**
		 * Faire un tableau pour facilité l'affichage.
		 *
		 * @param object liste à trier
		 * @return array retourne un tableau multi-dimension
		 */
		public function tableau_type_tiem( $list = FALSE )
		{
				if( !$list )
						$list = self::select();

				$array = FALSE;

				foreach( $list as $row )
				{
						if( $row->hp && $row->position == 0 )
						{
								$array['hp']['title'] = 'Objet pour la santé';
								$array['hp']['data'][] = $row;
						}
						elseif( $row->mp && $row->position == 0 )
						{
								$array['mp']['title'] = 'Objet pour la magie';
								$array['mp']['data'][] = $row;
						}
						elseif( !$row->hp && !$row->mp && $row->position != 0 )
						{
								$array[$row->position]['title'] = 'Equipement pour 	'.Kohana::lang( 'item.position_'.$row->position );
								$array[$row->position]['data'][] = $row;
						}
				}

				return $array;
		}

		/**
		 * Faire une insertion pour un couplage item.
		 *
		 */
		public function link_insert( $items_id_one, $nbr_one, $items_id_two, $nbr_two, $items_id_result, $job_id, $niveau, $xp )
		{
				return parent::model_insert( 'items_link', array( 'items_id_one' => $items_id_one,
										'nbr_one' => $nbr_one,
										'items_id_two' => $items_id_two,
										'nbr_two' => $nbr_two,
										'items_id_result' => $items_id_result,
										'job_id' => $job_id,
										'niveau' => $niveau,
										'xp' => $xp ) );
		}

		/**
		 * Faire une sélection sur les couplage
		 *
		 */
		public function link_select_simple( $where = FALSE, $limit = FALSE )
		{
				$this->db->select( '*, items_link.id as items_link_id, items_link.niveau as items_link_niveau, items_link.xp as items_link_xp' )
								->from( 'items_link' )
								->join( 'items', 'items.id', 'items_link.items_id_result' );

				if( $where )
						$this->db->where( $where );

				if( $limit )
						$this->db->limit( $limit );

				$query = $this->db->get();

				return $query->count() ? (!$limit || $limit > 1 ? $query : $query->current() ) : FALSE;
		}

		/**
		 * Faire une sélection sur les couplage
		 *
		 */
		public function link_select( $job_id, $niveau )
		{
				return $this->link_select_simple( array( 'items_link.job_id' => $job_id, 'items_link.niveau <=' => $niveau ) );
		}

		/**
		 * Supprimer un couplage
		 *
		 * @param integer ID de la ligne
		 * @return	 bool retour false ou true
		 */
		public function link_delete( $id )
		{
				return parent::model_delete( 'items_link', array( 'id' => $id ) );
		}

}

?>
