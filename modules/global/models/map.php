<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

/**
 * Permet de connaitre toutes les informations sur la : map.
 *
 * @package Map
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
class Map_Model extends Model {

		/**
		 * Permet de créer une instance et donc de ne pas faire des doublons.
		 * 
		 * @var object protected
		 */
		protected static $instance;

		/**
		 * Permet de ne pas faire des multi appel d'object
		 *
		 * @return class return la classe construite
		 */
		public static function instance()
		{
				if( Map_Model::$instance === NULL )
						return new Map_Model;

				return Map_Model::$instance;
		}

		/**
		 * Faire une sélection sur la table element_map.
		 *
		 * @param array les valeur du where
		 * @param integer limit de la requête
		 * @param string colonne sur le trie
		 * @param string colonne sélectionné
		 * @return mixe retourne un object sinon false
		 */
		public function select( $array = false, $limit = false, $orderby = false, $select = false )
		{
				if( $orderby )
						$orderby = array( $orderby => 'ASC' );

				return parent::model_select( 'element_map', $array, $limit, $select, $orderby );
		}

		/**
		 * Faire une insertion d'une ligne SQL.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function insert( array $set )
		{
				return parent::model_insert( 'element_map', $set );
		}

		/**
		 * Faire une mise à jour d'une ligne.
		 *
		 * @param array valeur à mettre à jour
		 * @param mixe valeur string/array pour le where
		 * @return mixe retourne un object sinon false
		 */
		public function update( array $set, array $where )
		{
				return parent::model_update( 'element_map', $set, $where );
		}

		/**
		 * Supprimer une ligne.
		 *
		 * @param mixe string/array pour le where
		 * @return	 bool retour false ou true
		 */
		public function delete( $where )
		{
				return parent::model_delete( 'element_map', $where );
		}

		/**
		 * Faire une insertion d'un élément map.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function ajout( array $array )
		{
				if( !isset( $array['x_map'] ) || !isset( $array['y_map'] ) || !isset( $array['z_map'] ) || !isset( $array['region_id'] ) )
						return false;

				$where = array( 'x_map' => $array['x_map'],
						'y_map' => $array['y_map'],
						'z_map' => $array['z_map'],
						'region_id' => $array['region_id'] );

				if( self::select( $where, true ) )
						self::update( $array, $where );
				else
						self::insert( $array );
		}

		/**
		 * Faire une sélection sur la table element_drag.
		 *
		 * @param string par image background
		 * @return mixe retourne un object sinon false
		 */
		public function select_bloc_tileset( $carte )
		{
				$query = parent::model_select( 'element_drag', array( 'image' => $carte ), FALSE, FALSE, array( 'y_min' => 'ASC', 'x_min' => 'ASC' ) );

				$arrayReturn = FALSE;

				if( $query )
						foreach( $query as $row )
								$arrayReturn[$row->x_min.'-'.$row->y_min] = $row;

				return $arrayReturn;
		}

		/**
		 * Faire une insertion d'un bloc tileset.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function insert_bloc_tileset( array $set )
		{
				return parent::model_insert( 'element_drag', $set );
		}

		/**
		 * Faire une mise à jour d'un bloc tileset.
		 *
		 * @param array valeur à mettre à jour
		 * @param mixe valeur string/array pour le where
		 * @return mixe retourne un object sinon false
		 */
		public function update_bloc_tileset( array $set, array $where )
		{
				return parent::model_update( 'element_drag', $set, $where );
		}

		/**
		 * Supprimer un bloc tileset.
		 *
		 * @param mixe string/array pour le where
		 * @return	 bool retour false ou true
		 */
		public function delete_bloc_tileset( array $where )
		{
				return parent::model_delete( 'element_drag', $where );
		}

		/**
		 * Faire une sélection sur la table element_detail.
		 *
		 * @param array les valeur du where
		 * @param integer limit de la requête
		 * @return mixe retourne un object sinon false
		 */
		public function select_detail( $array = false, $limit = 1, $select = FALSE )
		{
				return parent::model_select( 'element_detail', $array, $limit, $select );
		}

		/**
		 * Faire une insertion d'un détail map.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function ajout_detail( array $array )
		{
				if( !isset( $array['x_map'] ) || !isset( $array['y_map'] ) || !isset( $array['region_id'] ) )
						return false;

				$where = array( 'x_map' => $array['x_map'],
						'y_map' => $array['y_map'],
						'region_id' => $array['region_id'] );

				if( self::select_detail( $where ) )
						self::update_detail( $array, $where );
				else
						self::insert_detail( $array );
		}

		/**
		 * Faire une insertion d'un détail map.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function insert_detail( array $set )
		{
				return parent::model_insert( 'element_detail', $set );
		}

		/**
		 * Faire une mise à jour d'un détail map.
		 *
		 * @param array valeur à mettre à jour
		 * @param mixe valeur string/array pour le where
		 * @return mixe retourne un object sinon false
		 */
		public function update_detail( array $set, array $where )
		{
				return parent::model_update( 'element_detail', $set, $where );
		}

		/**
		 * Supprimer un détail de map.
		 *
		 * @param mixe string/array pour le where
		 * @return	 bool retour false ou true
		 */
		public function delete_detail( $where )
		{
				return parent::model_delete( 'element_detail', $where );
		}

}

?>
