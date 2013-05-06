<?php
	// ./module/Application/src/Application/View/Helper/AbsoluteUrl.php
	namespace Application\View\Helper;

	use Zend\View\Helper\HeadScript;

	final class MuneeHeadScript extends HeadScript
	{
		/**
		* Retrieve string representation
		*
		* @param  string|int $indent Amount of whitespaces or string to use for indention
		* @return string
		*/
		public function toString($indent = null)
		{
			if (!$this->getContainer()->count()) return '';
			
			$indent = (null !== $indent)
				   ? $this->getWhitespace($indent)
				   : $this->getIndent();

			if ($this->view) {
				$useCdata = $this->view->plugin('doctype')->isXhtml() ? true : false;
			} else {
				$useCdata = $this->useCdata ? true : false;
			}

			$escapeStart = ($useCdata) ? '//<![CDATA[' : '//<!--';
			$escapeEnd   = ($useCdata) ? '//]]>' : '//-->';

			$this->getContainer()->ksort();

			$srcs		= array();
			$commonItem = null;

			$muneeJs = $this->view->plugin('MuneeJs');

			foreach ($this as $item) {
				if (!$this->isValid($item)) {
					continue;
				}
				
				if (!$commonItem) {
					$commonItem = $item;
				}
				
				$srcs[] = $item->attributes['src'];
			}
			
			$commonItem->attributes['src'] = $muneeJs($srcs, true, false);
			
			return $this->itemToString($commonItem, $indent, $escapeStart, $escapeEnd);
		}
	}