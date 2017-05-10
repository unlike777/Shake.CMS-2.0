<?php
/**
 * Вспомогательный класс для определения активных пунктов меню
 * 
 * Created by PhpStorm.
 * User: UNLIKE
 * Date: 03.02.2015
 * Time: 20:21
 */ 

namespace App\Shake\Libs;

use Eloquent;

class Menu {
	
	protected $active = [];

    protected function getClass($obj) {
		if ($obj instanceof Eloquent) {
			$class = get_class($obj);
			$class = strtolower($class);
			return $class;
		}
		
		return '';
	}

    public function add($obj) {
		if ($obj instanceof Eloquent) {
			if (!empty($obj->id)) {
				$class = $this->getClass($obj);
                $this->active[$class][] = $obj->id;
			}
		}
	}

    public function isActive($obj) {
		if ($obj instanceof Eloquent) {
			if (!empty($obj->id)) {
				$class = $this->getClass($obj);
				if (isset($this->active[$class])) {
					if (in_array($obj->id, $this->active[$class])) {
						return true;
					}
				}
			}
		}
		
		return false;
	}
}
