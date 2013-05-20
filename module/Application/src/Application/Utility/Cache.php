<?php
	/**
	 * @namespace
	 */
	 namespace Application\Utility;
	 
	 use 
		Doctrine\ORM\Query,
		Doctrine\Common\Cache\Cache as CacheDriver,
		Doctrine\ORM\Mapping\ClassMetadata;
	 
	/**
	 * Time utils
	 */
	final class Cache
	{
		
		const PARAM_SEPARATOR	= '%#=#%';
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
			$query->getResultCacheDriver();
			
			return $query->useResultCache(
				true, $lifeTime, self::makeCacheKey($struc)
			);
		}
		
		public static function makeCacheKey(Array $struc, $isSilent = false)
		{
			$hasMeta = true;
			
			if (
				(
					!(isset($struc['meta']) 
					|| $struc['meta'] instanceof ClassMetadata)
				)
			) {
				if (!$isSilent)
					throw new \RuntimeException('Wrong meta instance given');
				else
					$hasMeta = false;
			}
			
			$cacheName = '';
			
			if ($hasMeta)
				$cacheName = strtolower($struc['meta']->getTableName());
			
			if (!empty($struc['args'])) {
				if (is_array($struc['args'])) {
					
					$piece = '';
					
					array_walk(
						$struc['args'], 
						function ($item, $key) use (&$piece) {
							$piece .= 
								'_' . md5($key . self::PARAM_SEPARATOR . $item);
						}
					);
					
					if ($piece)  {
						$cacheName .= $piece;
					}
					
				} else {
					$cacheName .= '_' . md5(serialize($struc['args']));
				}
			}
			
			if (!empty($struc['method'])) {
				$cacheName .= '_' . strtolower($struc['method']);
			}
			
			return $cacheName;
		}
		
		public static function deleteById(CacheDriver $cache, $id)
		{
			if (is_array($id)) $id = self::makeCacheKey($id);
			
			return $cache->delete($id);
		}
		
		public static function dropSingle(CacheDriver $cache, Array $struc)
		{
			foreach ($struc['argsForRemove'] as $key => $value) {
				self::deleteById(
					$cache, array('meta' => $struc['meta'], 'args' => $value['args'])
				);
			}
		}
	}