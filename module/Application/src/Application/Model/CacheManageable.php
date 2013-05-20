<?php
	namespace Application\Model;

	/**
	 *
	 * @author sirvantos
	 */
	interface CacheManageable 
	{
		public function dropSingle($entity);
		public function dropLists();
		public function fullDrop();
	}
