<?php
	/*
	 * To change this template, choose Tools | Templates
	 * and open the template in the editor.
	 */
	 
	 namespace Application\Utility;

	/**
	 * Description of Common
	 *
	 * @author sirvantos
	 */
	final class String 
	{
		public static function camelStyle2Underscore(/*string*/ $className)
		{
			return strtolower(
				preg_replace('/([a-z])([A-Z])/', '$1_$2', $className)
			);
		}
	}