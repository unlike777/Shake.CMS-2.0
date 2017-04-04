<?php

/**
 * Date.php Copyright 2014
 * https://github.com/unlike777/Laravel-localized-format-date
 *
 * Класс для локализованного форматирования даты
 */

namespace App\Shake\Libs;

use Lang;

class Date {
	
	protected $time;
//	protected static $lang;
	
	public function __construct() {
	    
	}
	
//	public static function setLocale($lang) {
//		self::$lang = $lang;
//	}

    /**
     * работаем с текущей датой
     * @return $this
     */
	public function now() {
		$this->setTime();
        return $this;
	}

    /**
     * парсим время
     * @param bool $time
     * @return $this
     */
	public function parse($time = false) {
	    $this->setTime($time);
		return $this;
	}

	/**
	 * Устанавливаем время в формате timestamp
	 * @param bool $time
	 */
	private function setTime($time = false)
	{
		if ($time === false) {
			$time = time();
		}

		if (!is_numeric($time) && is_string($time)) {
			$time = strtotime($time);
		}

		if ($time instanceof \Carbon\Carbon) {
			$time = $time->timestamp;
		}

		$this->time = $time;
	}

	/**
	 * Заменяет аббревиатуры на нужные значения
	 * 
	 * @param $format - формат даты "j mmm Y H:i"
	 * @param $num - порядковый номер в массиве
	 * @param $arr - массив соответсвия, какой элемент массива соответсвует той или иной аббревиатуре
	 */
	private static function replace(&$format, $num, $arr) {
		
		foreach ($arr as $key => $val) {
			$word = Lang::get('date.'.$val)[$num];
			$format = str_replace($key, $word, $format);
			$format = str_replace(mb_strtoupper($key, 'UTF-8'), mb_ucfirst($word, 'UTF-8'), $format);
		}
		
	}
	
	/**
	 * Форматирует дату в заданном формате
	 * поддерживаемые аббревиатуры:
	 * dd, ddd - день недели
	 * mm, mmm, mmmm - месяц
	 * для получения первой буквы заглавной, используем DD, MMM 
	 * 
	 * @param string $format
	 * @return bool|string
	 */
	public function format($format = 'Y-m-d H:i:s') {

		$num_day = date('N', $this->time);
		self::replace($format, $num_day, array(
			'ddd' => 'fweekday',
			'dd' => 'sweekday',
		));
		
		$num_month = date('n', $this->time);
		self::replace($format, $num_month, array(
			'mmmm' => 'fmonth',
			'mmm' => 'month',
			'mm' => 'smonth',
		));
		
		return date($format, $this->time);
	}
	
}
