<?php
/**
 * Вспомогательный класс для SEO оптимизации
 * 
 * Created by PhpStorm.
 * User: UNLIKE
 * Date: 03.02.2015
 * Time: 20:21
 */

namespace App\Shake\Libs;

use App\Models\ShakeModel;
use App\Modules\Pages\Models\Page;

class SEO {
	
	/**
	 * @var ShakeModel
	 */
	protected $obj;
	protected $kinds = ['title', 'keywords', 'description'];
	protected $changed = [];
	
	/**
	 * Вернет СЕО текст текущего объекта
	 * @param $kind
	 * @return string
	 */
	protected function getSeoText($kind) {
		$text = '';
		if ($this->checkKind($kind)) {
			if ($this->obj) {
				if ($seo = $this->obj->seoText) {
					$text = $seo->{$kind};
				}
				
				if (empty($text) && isset($this->changed[get_class($this->obj)][$kind])) {
					$foo = $this->changed[get_class($this->obj)][$kind];
					$text = $foo($this->obj, $text);
				}
			}
			if (empty($text)) {
				$text = $this->getDefSeoText($kind);
			}
		}
		return $text;
	}
	
	/**
	 * Вернет СЕО текст по умолчанию, на случай если никакой текст не найден
	 * @param $kind
	 * @return string
	 */
	public function getDefSeoText($kind) {
		$text = '';
		if ($this->checkKind($kind)) {
			if ($home = Page::where('is_home', '=', 1)->first()) {
				if ($seo = $home->seoText) {
					$text = $seo->{$kind};
				}
			}
		}
		return $text;
	}
	
	/**
	 * Проверяет тип СЕО текста
	 * @param $kind
	 * @return bool
	 */
	protected function checkKind($kind) {
		return in_array($kind, $this->kinds);
	}
	
	/**
	 * Возвращает Заголовок окна
	 * @return string
	 */
	public function title() {
		return $this->getSeoText('title');
	}
	
	/**
	 * Возвращает Ключевые слова
	 * @return string
	 */
	public function keywords() {
		return $this->getSeoText('keywords');
	}
	
	/**
	 * Возвращает Мета описание
	 * @return string
	 */
	public function description() {
		return $this->getSeoText('description');
	}
	
	/**
	 * Установить объект который будет участвовать в генерации СЕО текстов
	 * @param $obj
	 */
	public function set($obj) {
		if ($obj instanceof ShakeModel) {
			$this->obj = $obj;
		}
	}
	
	/**
	 * Добавляет поведение для разных классов
	 * @param $model
	 * @param $kind
	 * @param $foo
	 */
	public function change($model, $kind, $foo) {
		if ($this->checkKind($kind)) {
			if (class_exists($model)) {
				if (is_callable($foo)) {
					$this->changed[$model][$kind] = $foo;
				}
			}
		}
	}
	
}
