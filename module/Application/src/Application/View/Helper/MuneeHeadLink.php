<?php
	// ./module/Application/src/Application/View/Helper/AbsoluteUrl.php
	namespace Application\View\Helper;

	use Zend\View\Helper\HeadLink;

	final class MuneeHeadLink extends HeadLink
	{
		/**
		* Retrieve string representation
		*
		* @param  string|int $indent Amount of whitespaces or string to use for indention
		* @return string
		*/
		public function toString($indent = null)
		{
			$indent = (null !== $indent)
					? $this->getWhitespace($indent)
					: $this->getIndent();

			$items = array();
			$this->getContainer()->ksort();
			
			$srcs		= array();
			$commonItem = null;
			
			$muneeCss = $this->view->plugin('MuneeCss');
			
			foreach ($this as $item) {
				if (isset($item->type) && $item->type == 'text/css') {
					if (!$commonItem) {
						$commonItem = $item;
					}
					
					$srcs[] = $item->href;
					
				} else {
					$items[] = $this->itemToString($item);
				}
			}
			
			if ($srcs) {
				$commonItem->href = $muneeCss($srcs, true, false);
				$items[] = $this->itemToString($commonItem);
			}
			
			return $indent . implode($this->escape($this->getSeparator()) . $indent, $items);
		}
	}