<?php
	/**
	 * @namespace
	 */
	 namespace Application\Utility;
	 
	 use 
		Doctrine\ORM\Query,
		Doctrine\ORM\Mapping\ClassMetadata;
	 
	/**
	 * Time utils
	 */
	final class Cache
	{
		const DEFAULT_LIFE_TIME = 2592000; //default life time is 30 days
		
		/**
		 * @param ClassMetadata $meta
		 * @param String $methodName
		 * @param array $args
		 * @return String
		 */
		public static function setCacheForQuery(
			Query $query, Array $struc, $lifeTime = self::DEFAULT_LIFE_TIME
		)
		{
			if (
				!(isset($struc['meta']) 
				|| $struc['meta'] instanceof ClassMetadata)
			)
				throw new \RuntimeException('Wrong meta instance given');
			
			if (empty($struc['method']))
				throw new \RuntimeException('No method name given');
			
			$cacheName = strtolower($struc['meta']->getTableName());
			
			if (!empty($struc['args'])) {
				$cacheName .= '_' . md5(serialize($struc['args']));
			}
			
			$cacheName .= '_' . strtolower($struc['method']);
			
			return $query->useResultCache(true, $lifeTime, $cacheName);
		}
	}