<?php
	/**
	 * Description of DefaultPagination
	*/
	
	namespace Admin\View\Helper;
	
	use 
		Zend\Paginator,
		Zend\View\Helper\PaginationControl;
	
	/**
	 */
	final class DefaultPagination extends PaginationControl
	{
		/**
		 * 
		 * @param Paginator $paginator
		 * @param Array $params
		 * @param String $scrollingStyle
		 * @param String $template
		 * @return String
		 */
		public function __invoke(
			Paginator\Paginator $paginator = null, 
			$scrollingStyle = null, 
			$partial = null, 
			$params = null
		)
		{
			$defaultParams = array(
				'routeParamName'         => 'page',
				'align'                  => 'right',
				'icons' => array(
					'icon-fast-backward',
					'icon-chevron-left',
					'icon-chevron-right',
					'icon-fast-forward',
				),
				'statistics' => array(
					'inline'            => false,
					'totalCount'        => true,
					'pageNumOfTotal'    => true,
					'totalPages'        => false,
					'pageSize'          => false,
					'pageNum'           => false,
				)
			);
			
			if (!is_array($params)) $params			= array();
			if (!$scrollingStyle) $scrollingStyle	= 'sliding';
			if (!$partial) $partial = 'dlutwbootstrap/paginator/standard';
			
			return parent::__invoke(
				$paginator, 
				$scrollingStyle, 
				$partial, 
				array_merge($defaultParams, $params)
			);
		}
	}