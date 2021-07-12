<?php

/**
 * progressValue($val, $max)
 *
 * Using progressValue(), get percentage of value compare to maximum value
 *
 * @access	public
 * @param	int		$val 	current value
 * @param	int		$max 	maximum value
 * @return	string 	return percentage of value, max is 100.
 */

if (!function_exists('progressValue')) {
	function progressValue($val, $max)
	{
		if($max <= 0 || $max == NULL) return $val;
		return ($val / $max) * 100;
	}
}

/**
 * generateId($prefix)
 *
 * Generate new ID
 *
 * @access	public
 * @param	string	$prefix 	the prefix of id
 * @return	string 	return new id.
 */

if (!function_exists('generateId')) {
	function generateId($prefix)
	{
		return $prefix . strtotime(date("d-m-Y H:i:s"));
	}
}

/**
 * safeUnlink($path)
 *
 * Using unlink(), and check file existance before execute
 *
 * @access	public
 * @param	string	$path 	the file path
 * @return	bool 	return TRUE if success, false otherwise.
 */
 
if (! function_exists('safeUnlink'))
{
	function safeUnlink($path)
	{
		if ($path!=NULL) {
            if (file_exists($path)) {
            	if (!is_dir($path)) {
            		unlink($path);
            		return TRUE;
            	}
            }
        }
        return FALSE;
	}
}

/**
 * inputSelect($value, $selectvalue)
 *
 * Used to select one of the select box option
 *
 * @access	public
 * @param	string	$value 	the value send by server
 * @param	string	$selectvalue 	the select option value
 * @param	string	$returnstring 	(Optional) the return value for selected option
 * @return	string 	return string selected="true" for equal value ($value==$selectvalue).
 */
 
if (! function_exists('inputSelect'))
{
	function inputSelect($value, $selectvalue, $returnstring = 'selected="true"')
	{
		if ($value==NULL || $selectvalue == NULL) {
			return NULL;
		};
		if($value == $selectvalue){
			return $returnstring;
		};
	}
}

/**
 * columnLetter($index)
 *
 * Convert int to char,
 * used for working with excel column.
 * eg : 1 = A, 2 = B
 *
 * @access	public
 * @param	string	index 	input value, integer only. (0 = NULL)
 * @param	bool	(Optional) resultToUpperCase 	convert to upercase
 * @return	char 	return single char. ( A ~ Z )
 */
 
if (! function_exists('columnLetter'))
{
	function columnLetter($index, $resultToUpperCase = FALSE)
	{
		$c = intval($index);
	    if ($c <= 0) return NULL;

	    $letter = '';
	             
	    while($c != 0){
	       $p = ($c - 1) % 26;
	       $c = intval(($c - $p) / 26);
	       $letter = chr(65 + $p) . $letter;
	    }
	    if ($resultToUpperCase) $letter = strtoupper($letter);
	    
	    return $letter;
	}
}

/**
 * timeLog($inputDate, $format = "%d days, %m months, %y years, %H Hour %i minutes %s seconds")
 *
 * Get time log, used for LastSeen in chat app
 *
 * @access	public
 * @param	string	inputDate 	input date comparison
 * @param	string	format 	(Optional) string output format
 * @return	type	
 */
 
if (! function_exists('timeLog'))
{
	function timeLog($inputDate, $format = "%d days, %m months, %Y years, %H Hour %i minutes %s seconds")
	{
		if(trim($inputDate)==NULL) return NULL;
		$date = NULL;

		if (strpos($inputDate, "-") !== FALSE || strpos($inputDate, "/") !== FALSE) {
			$temp = formatDate($inputDate, TRUE);
			$date = getYear($temp)."-".getMonth($temp)."-".getDay($temp)." ".getTime($temp);
		}else{
			// timestapms
			$date = date("Y-m-d H:i:s", $inputDate);
		};

        $datetime1 = new DateTime($date); // input Date
        $datetime2 = new DateTime(date("Y-m-d H:i:s")); // Now
        $interval = $datetime1->diff($datetime2);
        return $interval->format($format);
	}
}

/**
 * formatDate($date, useTime)
 *
 * Format date from any format into dd-mm-YY
 * useful for quick formating layout.
 *
 * @access	public
 * @param	string	date 	input date from any format (not timestamps)
 * @param	bool	useTime 	(Optional) using time if available in the input value
 * @return	string	return as dd-mm-YY string
 */
 
if (! function_exists('formatDate'))
{
	function formatDate($date, $useTime = FALSE){
		if(trim($date)==NULL){return NULL;};
		$date=trim($date);
		$c = array();
		$d=NULL;
		$m=NULL;
		$Y=NULL;
		$time = NULL;
		if (strpos($date, " ")!==FALSE){
			$time = " ".explode(" ", $date)[1];
			$date = explode(" ", $date)[0];
			if(trim($date)==NULL){return NULL;};
		}else{
			$time = date(" H:i:s");
		}
		if(strpos($date, "-")!==FALSE){
			$c = explode("-", $date);
		}else if(strpos($date, "/")!==FALSE){
			$c = explode("/", $date);
		}else{
			return NULL;
		};
		if(strlen($c[0]) >= 4){
			$d = $c[2];
			$m = $c[1];
			$Y = $c[0];
		}else if($c[1] >= 13){
			$d = $c[1];
			$m = $c[0];
			$Y = $c[2];
		}else{
			return $date;
		}
		if ($useTime) {
			return $d."-".$m."-".$Y.$time;
		}else{
			return $d."-".$m."-".$Y;
		}
		
	}
}

/**
 * getTime($date)
 *
 * Get the time from string date
 *
 * @access	public
 * @param	string	date 	input date value (only accept format d-m-Y H:i:s)
 * @return	string 	return as time
 */
 
if (! function_exists('getTime'))
{
	function getTime($date){
		if($date==NULL){return NULL;};
		if (strpos($date, ' ')!==FALSE) {
			return explode(' ', $date)[1];
		}else{
			return date("H:i:s");
		}
	}
}

/**
 * getDay($date)
 *
 * Get the day from string date
 *
 * @access	public
 * @param	string	date 	input date value (only accept format d-m-Y)
 * @return	int 	return as day
 */
 
if (! function_exists('getDay'))
{
	function getDay($date){
		if($date==NULL){return NULL;};
		$sp = strpos($date, '-')!==FALSE?'-':'/';
		$res = explode($sp, $date)[0];
		return $res;
	}
}

/**
 * getMonth($date)
 *
 * Get the month from string date
 *
 * @access	public
 * @param	string	date 	input date value (only accept format d-m-Y)
 * @return	int 	return as month (1 - 12)
 */
 
if (! function_exists('getMonth'))
{
	function getMonth($date){
		if($date==NULL){return NULL;};
		$sp = strpos($date, '-')!==FALSE?'-':'/';
		$res = explode($sp, $date)[1];
		return $res;
	}
}

/**
 * getYear($date)
 *
 * Get the year from string date
 *
 * @access	public
 * @param	string	date 	input date value (only accept format d-m-Y)
 * @return	int 	return as year
 */
 
if (! function_exists('getYear'))
{
	function getYear($date){
		if($date==NULL){return NULL;};
		$sp = strpos($date, '-')!==FALSE?'-':'/';
		if (strpos($date, ' ')!==FALSE) $date = explode(' ', $date)[0];
		$res = explode($sp, $date)[2];
		
		return $res;
	}
}

/**
 * monthToString($month, $arrayLangMonths)
 *
 * Convert month into string
 *
 * @access	public
 * @param	int		month 	(Ooptional) input month, int only, default is today if no value given
 * @param	array	arrayLangMonths 	(Optional) list string month for the result, or use listStringMonth() for default
 * @return	string	spellout the given month
 */
 
if (! function_exists('monthToString'))
{
	function monthToString($month = NULL, $arrayLangMonths = NULL)
	{
		if ($month==NULL) $month = date("m");
		if($month==NULL) {
			$month = date("m", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
		}else{
			if (strlen($month)>=3) {
				$month = date("m", mktime(0, 0, 0, getMonth($month), getDay($month), getYear($month)));
			}
		}
		if ($arrayLangMonths==NULL) $arrayLangMonths = ['', 'January', "February", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
		if ($month<=count($arrayLangMonths)){
			$month = $month*1;
			return $arrayLangMonths[$month];
		}else{
			return NULL;
		}
	}
}

/**
 * listStringMonth()
 *
 * Get list of month. eg : January, February, etc
 * Zero index is NULL.
 * used for monthToString(12, listStringMonth())
 *
 * @access	public
 * @return	array	return [January, February, etc]
 */
 
if (! function_exists('listStringMonth'))
{
	function listStringMonth()
	{
		return ['', 'January', "February", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
	}
}

/**
 * dayToString($inputDate, $arrayLangDays)
 *
 * Convert day into string
 *
 * @access	public
 * @param	string	inputDate 	(Optional) accept int or string, default is today if no value given
 * @param	array	arrayLangDays 	(Optional) list string day for the result, or use listStringDay() for default
 * @return	string	spellout the given day
 */
 
if (! function_exists('dayToString'))
{
	function dayToString($inputDate = NULL, $arrayLangDays = NULL)
	{
		$temp = NULL;
		if($inputDate==NULL) {
			$temp = date("w", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
		}else{
			if (strlen($inputDate)>=3) {
				$temp = date("w", mktime(0, 0, 0, getMonth($inputDate), getDay($inputDate), getDay($inputDate)));
			}else{
				$temp = date("w", mktime(0, 0, 0, date("m"), $inputDate, date("Y")));
			}
		}
		if ($arrayLangDays==NULL) $arrayLangDays = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
		if ($temp<=count($arrayLangDays)){
			$temp = $temp*1;
			return $arrayLangDays[$temp];
		}else{
			return NULL;
		}
	}
}

/**
 * listStringDay()
 *
 * Get list of month. eg : Sunday, Monday, etc
 * used for dayToString(12, listStringDay())
 *
 * @access	public
 * @return	array	return [Sunday, Monday, etc]
 */
 
if (! function_exists('listStringDay'))
{
	function listStringDay()
	{
		return ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
	}
}

/**
 * setTimezone($zone = 'Asia/Jakarta')
 *
 * set Timezone
 *
 * @access	public
 * @param	string	zone Timezone
 */
 
if (! function_exists('setTimezone'))
{
	function setTimezone($zone = 'Asia/Jakarta')
	{
		date_default_timezone_set($zone);
	}
}

/**
 * formatNumber($number)
 *
 * Format given number into currency. eg : 1.000.000
 *
 * @access	public
 * @param	string	number 	input number, standar format only
 * @return	string	return as string formated currency
 */
 
if (! function_exists('formatNumber'))
{
	function formatNumber($number)
	{
		$result = $number;
		if(strpos($number, ",")!==FALSE){
			$listNumber = explode(",", $number);

			$result = number_format($listNumber[0]);
			$result = str_replace(",", ".", $result);
			foreach ($listNumber as $value) {
				$result .= ",". $value;
			}
		}else{
			$result = number_format($number);
			$result = str_replace(",", ".", $result);
		};

		return $result;
	}
}

/**
 * strSentence($str)
 *
 * Convert string into upper case for each word.
 *
 * @access	public
 * @param	string	str 	input string
 * @return	string 	return as string	
 */
 
if (! function_exists('strSentence'))
{
	function strSentence($str)
	{
		if (trim($str)==NULL) return NULL;
		$res = strtoupper(substr($str, 0, 1)).substr($str, 1);
		if (strpos($str, "\r\n")!==FALSE) {
			$c = explode("\r\n", $res);
			$res = NULL;
			foreach ($c as $key => $line) {
				$res .= strSentence($line);
			}
		}
		if (strpos($str, " ")!==FALSE) {
			$c = explode(" ", $res);
			$res = NULL;
			foreach ($c as $key => $line) {
				$res .= strSentence($line);
			}
		}
		return $res;
	}
}

/**
 * dateAdd($date, $increament, $returnFormat)
 *
 * Increase date value
 *
 * @access	public
 * @param	string	date 	input date. (allowed format : 'd-m-Y' or 'd-m-Y H:i:s')
 * @param	int 	increament 	(Optional) increament value.
 * @param	string 	returnFormat 	(Optional) return format, default is 'd-m-Y H:i:s'.
 * @return	type	
 */
 
if (! function_exists('dateAdd'))
{
	function dateAdd($date, $increament = 1, $returnFormat = "d-m-Y H:i:s")
	{
		$d = strtotime("+".$increament." day", strtotime(getYear($date)."-".getMonth($date)."-".getDay($date)." ".getTime($date)));
		return date($returnFormat, $d);
	}
}

/**
 * dateSub($date, $decreament, $returnFormat)
 *
 * Increase date value
 *
 * @access	public
 * @param	string	date 	input date. (allowed format : 'd-m-Y' or 'd-m-Y H:i:s')
 * @param	int 	decreament 	(Optional) decreament value.
 * @param	string 	returnFormat 	(Optional) return format, default is 'd-m-Y H:i:s'.
 * @return	type	
 */
 
if (! function_exists('dateSub'))
{
	function dateSub($date, $decreament = 1, $returnFormat = "d-m-Y H:i:s")
	{
		$d = strtotime("-".$decreament." day", strtotime(getYear($date)."-".getMonth($date)."-".getDay($date)." ".getTime($date)));
		return date($returnFormat, $d);
	}
}

/**
 * isOdd($number)
 *
 * Is given number is Odd ?
 *
 * @access	public
 * @param	int 	number 	input number
 * @return	bool	return TRUE if given number is Odd, FALSE otherwise.
 */
 
if (! function_exists('isOdd'))
{
	function isOdd($number)
	{
		if($number % 2 == 0){ 
	        return false;
	    } 
	    else{ 
	        return true;
	    }
	}
}

/**
 * isEven($number)
 *
 * Is given number is Even ?
 *
 * @access	public
 * @param	int 	number 	input number
 * @return	bool	return TRUE if given number is Even, FALSE otherwise.
 */
 
if (! function_exists('isEven'))
{
	function isEven($number)
	{
		if($number % 2 == 0){ 
	        return true;
	    } 
	    else{ 
	        return false;
	    }
	}
}