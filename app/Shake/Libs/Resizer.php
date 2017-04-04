<?php

/**
 * Class Resizer
 * Ресайзит картинки и кеширует полученные результаты
 * 
 * Пример
 * Resizer::image('/upload/image.jpg')->make(100, 100);
 * Resizer::image('/upload/image.jpg')->deleteCache();
 * 
 */

namespace App\Shake\Libs;

use Image;

class Resizer {
	
	private static $max_resolution = 2000; //максимальное разрешение (иначе нехватка памяти)
	
	private $img = '';
	
	public function __construct() {
	    
	}
	
    /**
     * Устанавливаем изображение
     * @param $img
     * @return $this
     */
	public function image($img) {
        if (is_file($this->public_path().$img)) {
            $this->img = $img;
        } else {
            $this->$img = '';
        }
        return $this;
	}

	/**
	 * Возвращает полный путь до картинки
	 * @return string
	 */
	public function full_path() {
		if (!empty($this->img)) {
			return $this->public_path().$this->img;
		}
		
		return '';
	}

	/**
	 * Возвращает путь до корневой директории
	 * @return string
	 */
	protected function public_path() {
		return public_path();
	}

	/**
	 * Возвращает путь до директории с кешем
	 * @return string
	 */
	private function cache_path() {
		return '/cache/img';
	}

	/**
	 * Возвращает префикс генерируемый из пути файла
	 * @return mixed|string
	 */
	private function resize_prefix() {
		$pref = dirname($this->img);
		$bad_symbols = array("/", " ");
		$pref = str_replace ($bad_symbols, "_", $pref);
		$pref = substr($pref, 1);
		$pref = empty($pref) ? '' : $pref.'_';

		return $pref;
	}

	/**
	 * Удаляет кеш текущей картинки
	 */
	public function deleteCache() {
		if (!empty($this->img)) {
			
			$filename = $this->resize_prefix().basename($this->img);
			$from_path = $this->public_path().$this->cache_path();
			
			$full = $from_path.'/*/'.$filename;
			$arr = glob($full);
			$arr = ($arr === false) ? array() : $arr;
			
			$full = $from_path.'/'.$filename;
			$arr2 = glob($full);
			$arr2 = ($arr2 === false) ? array() : $arr2;
			
			$arr = array_merge($arr, $arr2);
			
			foreach ($arr as $file) {
				@unlink($file);
			}
		}
		return $this;
	}

	/**
	 * Ресайзить картинку и кеширует ее
	 * @param int $width - ширина
	 * @param int $height - высота
	 * @param int $scale_type - режим работы; 0 - изображение заполняет всю область, 1 - изображение вписывается в заданную область
	 * @param int $bg - цвет фона
	 * @return string
	 */
	public function make($width = 0, $height = 0, $scale_type = 0, $bg = 0) {

		if (empty($this->img)) {
			return '';
		}
		
		//на случай, если передана не картинка
		if (!@exif_imagetype($this->full_path())) {
			return $this->img;
		}

		$width = intval($width);
		$height = intval($height);
		$scale_type = ($scale_type != 0) ? 1 : 0; //может быть только 0 или 1

		$pref = $this->resize_prefix();

		//именно такой порядок нужен для быстрого удаления кеша конкретной картинки
		$dir = $this->cache_path().'/'.$width.'x'.$height.'_'.$scale_type.'_'.str_replace('#', '', $bg);
		$resize_file_name = $dir.'/'.$pref.substr(strrchr($this->img, "/"), 1);

		if (!file_exists($this->public_path() . $resize_file_name)) {
			
			//сечем картинки с высоким разрешением
			$info = getimagesize($this->full_path());
			if ( ($info[0] > self::$max_resolution) || ($info[1] > self::$max_resolution) ) {
				return 'resize_error?big_resolution';
			}
			
			$img = Image::make($this->full_path());
			
			if (!is_dir($this->public_path() . $dir)) @mkdir($this->public_path() . $dir, 0777, true);

			if (!empty($bg)) {
				$img->fill($bg);
			}

			if ($height > 0 && $width > 0) {
				
				if (($img->width() <= $width) && ($img->height() <= $height)) {
					return $this->img;
				}
				
				if ($scale_type == 1) {
					
					$kw = $img->width() / $width;
//					$kh = $img->height() / $height;
					
					if ( ($img->height() / $kw) <= $height ) {
						$img->widen($width);
					} else {
						$img->heighten($height);
					}
					
				} else {
					$img->fit($width, $height);
				}
				

			} else if ($height > 0) {

				if ($img->width() <= $width) {
					return $this->img;
				}

				$img->heighten($height);

			} else if ($width > 0) {

				if ($img->height() <= $height) {
					return $this->img;
				}

				$img->widen($width);

			}

			$img->save(public_path() . $resize_file_name);
		}

		return $resize_file_name;
	}
	
	
}
