<?php
	/**
	 * @namespace
	 */
	 namespace Application\Utility;
	 
	/**
	 * Time utils
	 */
	final class Time
	{
		const DEFAULT_TIMEZONE = 'UTC';
		
		const SECS_IN_DAY	= 86400;
		const SECS_IN_HOUR	= 3600;
		const SECS_IN_MIN	= 60;
		
		/**
		 * @return DateTime 
		 */
		static public function makeCurrentDate()
		{
			return new DateTime();
		}
		
		static public function removeTooOldPrograms(Array $programs)
		{
			$from = Application_Model_Utils_Time::convert2UTC(
				new DateTime(date("Y-m-d H:i:s", time() - (60 * 30)))
			)->getTimestamp();
			
			$sliceBorder = 0;
			
			foreach ($programs as $program) {
				$programDate = new DateTime(
					$program['program_program_date'] . ' ' 
					. $program['program_start_time'],
					new DateTimeZone(Application_Model_Utils_Time::DEFAULT_TIMEZONE)
				);
				
				if ($programDate->getTimestamp() >= $from) {
					break;
				}
				
				$sliceBorder++;
			}
			
			return array_slice($programs, $sliceBorder);
		}
		
		static public function getProgramTimes(Array $program)
		{
			$startDate = new DateTime(
				$program['program_date'] . ' ' . $program['start_time'],
				new DateTimeZone(Application_Model_Utils_Time::DEFAULT_TIMEZONE)
			);
			
			$endDate = new DateTime(
				$program['program_date'] . ' ' . $program['end_time'],
				new DateTimeZone(Application_Model_Utils_Time::DEFAULT_TIMEZONE)
			);
			
			if ($startDate->getTimestamp() > $endDate->getTimestamp())
				$endDate->modify ('+1 day');
			
			return array(
				'start' => $startDate,
				'end' => $endDate
			);
		}
		
		/**
		 * convert to date string with given format
		 * 
		 * @param Mixed $dt
		 * @param String $format
		 * @return String
		 */
		static public function convertFormat($dt, $format)
		{
			return self::_convert2DT($dt)->format($format);
		}
		
		/**
		 * converts to default date string
		 * 
		 * @param Mixed $dt
		 * @param Boolean $withTime
		 * 
		 * @return String
		 */
		static public function defaultFormat(/*Mixed*/ $dt, $withTime = true)
		{
			$str = '';
			
			if ($withTime) $str = ' H:i:s';
			
			return self::convertFormat($dt, 'd/m/Y' . $str);
		}
		
		/**
		 * converts to db date string
		 *  
		 * @param Mixed $dt
		 * @return String
		 */
		static public function dbDate(/*Mixed*/ $dt)
		{
			return self::convertFormat($dt, 'Y-m-d');
		}
		
		/**
		 * converts to db datetime string
		 *  
		 * @param Mixed $dt
		 * @return String
		 */
		static public function dbDateTime(/*Mixed*/ $dt)
		{
			return self::dbDate($dt) . ' ' . self::convertFormat($dt, 'H:i:s');
		}
		
		/**
		 * convert timizone for given date to UTC
		 * 
		 * @param Mixed $sourceDate
		 * @param DateTimeZone $sourceTimezone 
		 * @return DateTime
		 */
		static public function convert2UTC(
			$sourceDate, DateTimeZone $sourceTimezone = null
		)
		{
			return
				self::_convert2DT($sourceDate, $sourceTimezone)->
				setTimezone(new DateTimeZone(self::DEFAULT_TIMEZONE));
		}
		
		/**
		 * returns timezone offset
		 * 
		 * @param Integer $offset
		 * @param Bollean $isDst (whether to check Summer time)
		 * @return Integer 
		 */
		static public function tzOffsetToName($offset, $isDst = null)
		{
			if ($isDst === null)
			{
				$isDst = date('I');
			}

			$offset *= 3600;
			$zone    = timezone_name_from_abbr('', $offset, $isDst);

			if ($zone === false)
			{
				foreach (timezone_abbreviations_list() as $abbr)
				{
					foreach ($abbr as $city)
					{
						if ((bool)$city['dst'] === (bool)$isDst &&
							strlen($city['timezone_id']) > 0    &&
							$city['offset'] == $offset)
						{
							$zone = $city['timezone_id'];
							break;
						}
					}

					if ($zone !== false)
					{
						break;
					}
				}
			}
			
			return $zone;
		}
		
		static public function makeDateLine($daysCount)
		{
			$dateLine = array();
			
			$now = self::makeCurrentDate();
			
			$translate = Zend_Registry::get('Zend_Translate');
			
			for ($i = 0; $i < $daysCount; $i++) {
				
				$name = 
					' ' . $translate->_($now->format('D')) 
					. ' ' . $now->format('d') . '/' . $now->format('m');
				
				switch ($i) {
					case 0:
						$name = $translate->_('Idag') . $name;
						break;
				}
				
				$dateLine[$name] = clone $now;
				
				$now->modify('+1 day');
			}
			
			return $dateLine;
		}
		
		/**
		 * fix the data format if it isn't supported 
		 * strtotime() func
		 * @param String $strDate
		 * @return String 
		 */
		static private function _correctStrDate($strDate)
		{
			if (!is_string($strDate)) return $strDate;
			
			return strtr($strDate, '/', '-');
		}
		
		/**
		 * converts datetime. if string given converts it to dt with 
		 * given timezone
		 * 
		 * @param Mixed $dt
		 * @return DateTime 
		 */
		static private function _convert2DT(
			/*Mixed*/ $dt, DateTimeZone $timezone = null
		)
		{
			if (!($dt instanceof DateTime)) {
				
				$dt = new DateTime(self::_correctStrDate($dt));
			}
			
			if ($timezone) $dt->setTimezone($timezone);
			
			return $dt;
		}
	}