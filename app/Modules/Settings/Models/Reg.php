<?php

namespace App\Modules\Settings\Models;

use App\Models\ShakeModel;

class Reg extends ShakeModel {
	
	protected $fillable = ['key', 'value'];
	
	protected $fields = [
		'key' => [
			'type' => 'text',
			'title' => 'Ключ',
		],
		'value' => [
			'type' => 'text',
			'title' => 'Значение',
		],
	];

	public function validate($data, $behavior = 'default') {
		
		$rules = [
			'key' => 'required|min:2|unique:regs,key',
			'value' => '',
		];
		
		if (!empty($this->id)) {
			$rules['key'] = $rules['key'].','.$this->id;
		}
		
		return validator($data, $rules);
	}
	
	
	/**
	 * Устанавливает значение по ключу, возвращает переданное значение
	 * @param $alias
	 * @param $value
	 * @return mixed
	 */
	public static function set($key, $value) {
		$obj = self::where('key', '=', $key)->first();
		if (!$obj) {
			$obj = new self();
		}
		
        $data = compact('key', 'value');
		$validation = $obj->validate($data);
		
		if ($validation->passes()) {
			$obj->fill($data);
			$obj->save();
		}
		
		return $value;
	}
	
	/**
	 * Вернет значение по ключю
	 * @param array $key
	 * @param null $defValue
	 * @return mixed|null
	 */
	public static function get($key, $defValue = NULL) {
		$obj = self::where('key', '=', $key)->first();
		if ($obj) {
			return $obj->value;
		}
		
		return $defValue;
	}
	
	/**
	 * Удалит значение с заданным ключом
	 * @param $key
	 */
	public static function del($key) {
		self::where('key', '=', $key)->delete();
	}
	
}
