<?php

namespace App\Shake\Libs;

use Form;
use Illuminate\Support\Facades\Input;
use View;
use Resizer;

class ShakeTable {

	/**
	 * @var $model \App\Models\ShakeModel
	 */
	private $model; 					//Модель с которой предстоит работать
	private $data; 						//Полученные данные, к ним применяются фильтры и постраничная навигация
	private $columns = [];			    //колонки
	private $module = '';				//название модуля

    private $filter_fields = []; 	    //поля участвующие в фильтре

    private $def_sort = [];             //сортировка по умолчанию  array('param', 'trend')

    private $max_img_dimension = 40;   //максимальная размерность картинки, после чего она заресайзена
    
	private $page_counts_arr = [12, 25, 50, 100];
    

	/**
	 * конструктор
	 * @param $data
	 */
	public function __construct($model = null) {
		if ($model) {
			$this->setModel($model);
		}
	}

	/**
	 * Устанавливает модель для таблицы
	 * @param $model
	 */
	public function setModel($model) {
		$this->model = $model;
		$this->data = $model;
		
		$this->filter_fields = $model->getFilterFields();
	}
	
	/**
	 * Устанавливаем модуль для роутов
	 * @param $name
	 */
	public function setModule($name) {
		$this->module = $name;
		
		return $this;
	}

	/**
	 * Устанавливает сортировку по умолчанию
	 * @param $param
	 * @param string $trend
	 */
	public function set_def_sort($param, $trend = 'asc') {
		$this->def_sort = [$param, $trend];
	}

	/**
	 * Добавляем колонку
	 * @param $name
	 * @param string $title
     * @param $type - text|img тип поля
     * @param int $width
	 * @param object|bool $callback - функция для обработки значения
	 * @param bool $sort - если false то отключает сортировку у столбца
	 */
	public function add($name, $title = '', $type = 'text', $width = 0, $callback = false, $sort = true) {
		
		if (empty($title)) {
			$title = $name;
		}
		
		$this->columns[$name] = [
		    'type' => $type,
			'title' => $title,
			'width' => $width,
			'callback' => $callback,
			'sort' => $sort,
		];
		
		return $this;
	}
	
	//алиас для добавления картинок
	public function addImg($name, $title = '', $width = 0, $callback = false, $sort = true) {
	    $this->add($name, $title, 'img', $width, $callback, $sort);
	    return $this;
    }

	/**
	 * генерируем заголовки таблицы
	 * @return string
	 */
	public function head() {
		
		$ret = '';
		$ret .= '<th width="40"></th>';
		if ($this->model->hasActive()) {
			$ret .= '<th width="40" style="color: #BABABA;"><span class="glyphicon glyphicon-eye-open"></span></th>';
		}
		$ret .= '<th width="70">#</th>';
		
		foreach ($this->columns as $name => $col) {
			$width = '';
			if ($col['width'] != 0) {
				$width = 'width="'.$col['width'].'"';
			}

			$ses = 'shake.sort.'.$this->module;
			
			$param = 'asc';
			$glyph = 'glyphicon glyphicon-align-left';
			
			if (session($ses.'.sort_param') == $name) {
				if (session($ses.'.sort_trend') == 'asc') {
					$param = 'desc';
					$glyph = 'glyphicon glyphicon-sort-by-attributes';
				} else {
					$glyph = 'glyphicon glyphicon-sort-by-attributes-alt';
				}
				
			}
			
			$query = add_to_query([
				'sort_param' => $name, 
				'sort_trend' => $param,
			]);
			
			$sort = link_to_route('admin.'.$this->module.'.def', '', $query, ['class' => $glyph]);
			
			if (!$col['sort']) {
				$sort = '';
			}
			
			$ret .= '<th '.$width.'>'.$col['title'].' '.$sort.'</th>';
		}

		$ret .= '<th width="100">Действия</th>';
		
		$ret = '<thead><tr>'.$ret.'</tr></thead>';
		
		return $ret;
	}

	/**
	 * генерируем основную часть
	 * @return string
	 */
	public function body() {
		
		if ($this->data->count() == 0) {
			return '<tr><td colspan="999"><h3>Ни одной записи не найдено</h3></td></tr>';
		}
		
		$ret = '';
		
		foreach ($this->data as $item) {
			$ret .= $this->row($item);
		}
		
		$ret = '<tbody>'.$ret.'</tbody>';
		
		return $ret;
	}

	/**
	 * генерируем строку
	 * @param $item
	 * @return string
	 */
	public function row($item) {
		$ret = '';
		$ret .= '<td>'.Form::checkbox('', 1, NULL, ['class' => 'table__checkbox']).'</td>';

		if ($this->model->hasActive()) {
			if ($item->active == 1) {
				$ret .= '<td><span class="glyphicon glyphicon-eye-open table__row_eye" data-route="/admin/'.$this->module.'/active"></span></td>';
			} else {
				$ret .= '<td><span class="glyphicon glyphicon-eye-close table__row_eye" data-route="/admin/'.$this->module.'/active"></span></td>';
			}
		}
		
		$ret .= '<td>'.$item->id.'</td>';
		
		foreach ($this->columns as $name => $col) {
            $val = $item->{$name};
		    
		    if ($col['type'] == 'img') {
                if (!empty($val)) {
                    $val = '<a href="'.$val.'" data-fancybox taget="_blank"><img src="'.Resizer::image($val)->make(200, $this->max_img_dimension, 1).'"></a>';
                }
            }
			
			if (!empty($col['callback'])) {
				$val = $col['callback']($val, $item);
			}
			$ret .= '<td>'.$val.'</td>';
		}
		
		$ret .= '<td>'
			.link_to_route('admin.'.$this->module.'.edit', '', ['id' => $item->id], ['class' => 'glyphicon glyphicon-pencil'])
			.'&nbsp;&nbsp;&nbsp;'
			.link_to_route('admin.'.$this->module.'.delete', '', ['id' => $item->id], ['class' => 'glyphicon glyphicon-trash table__row_delete'])
			.'</td>';

		$ret = '<tr class="table__row" data-id="'.$item->id.'" data-edit="'.route('admin.'.$this->module.'.edit', ['id' => $item->id]).'">'.$ret.'</tr>';
		
		return $ret;
	}

	/**
	 * генерируем постраничку
	 * @return mixed
	 */
	public function pager() {
		return $this->data->appends(Input::query())->links();
	}

	public function multiple() {
		$ret = '';
		
		if ($this->data->count() > 0) {

			$ret .= '<div class="btn-group btn-group-sm">';
			if ($this->model->hasActive()) {
				$ret .= '<button type="button" class="btn btn-default table__multi_active" data-route="/admin/'.$this->module.'/active"><span class="glyphicon glyphicon-retweet"></span></button>';
			}
			$ret .= '<button type="button" class="btn btn-default table__multi_delete" data-route="/admin/'.$this->module.'/delete"><span class="glyphicon glyphicon-trash"></span></button>';
			$ret .= '</div>';

			$ret = '<thead><tr><td>'.Form::checkbox('', 1, null, ['style' => 'margin-top: 9px;', 'class' => 'table__check_all']).'</td><td colspan="999">'.$ret.'</td></tr></thead>';
		}

		
		return $ret;
	}

	/**
	 * генерируем фильтр
	 * @return $this|\Illuminate\View\View
	 */
	public function filter() {
		return view('dashboard::widgets.filter.default')->with(['fields' => $this->filter_fields]);
	}
	
	/**
	 * генерируем селект для выбора элементов на странице
	 * @return string
	 */
	public function page_count() {
		
		$ret = '';
		
		foreach ($this->page_counts_arr as $count) {
			
			$link = add_to_query(['per_page' => $count]);
			
			if (Input::query('per_page') == $count) {
				$ret .= '<option value="?'.$link.'" selected="selected">'.$count.'</option>';
			} else {
				$ret .= '<option value="?
				'.$link.'">'.$count.'</option>';
			}
			
		}
		
		$ret = '<div class="pagination__count"><select>'.$ret.'</select></div>';
		
		return $ret;
	}

	/**
	 * Вернет количество элеметов на странице
	 * @return string
	 */
	public function per_page() {
		$default = $this->page_counts_arr[0];
		return Input::query('per_page') ? Input::query('per_page') : $default;
	}

	/**
	 * Применяем постраничку к данным
	 */
	public function apply_pager() {
		$this->data = $this->data->paginate($this->per_page());
	}

	/**
	 * Применяем фильтр для выборки
	 * Проверяем массив filter 
	 * А так же смотрим сохраненные значения в сессии
	 */
	public function apply_filter() {
		$ses = 'shake.filter.'.$this->module;
		
		if (Input::has('filter')) {
			foreach (Input::get('filter') as $key => $val) {
				if (array_key_exists('filter['.$key.']', $this->filter_fields)) {
					$val = trim($val);
					$ses_name = $ses.'.'.$key;

					if (!empty($val)) {
						//если поле булево, слегка меняем значение 
						if ($this->filter_fields['filter['.$key.']']['type'] == 'bool') {
							if ($val == 2) {
								$val = 0;
							}
						}
						
						session([$ses_name => $val]);
					} else {
					    session()->forget($ses_name);
					}
				}
			}
			
			if (Input::has('filter.reset')) {
			    session()->forget($ses);
			}
		} 
		
		if (session($ses)) {
			foreach (session($ses) as $key => $val) {
				$this->filter_fields['filter['.$key.']']['value'] = $val;
				
				$cur_field = $this->filter_fields['filter['.$key.']'];
				
				$strict = false;
				if (in_array($cur_field['type'], ['select', 'bool'])) {
					$strict = true;
				} else if (isset($cur_field['strict']) && $cur_field['strict']) {
					$strict = true;
				}
				
				if ($strict) {
					$this->data = $this->data->where($key, '=', $val);
				} else {
					$this->data = $this->data->where($key, 'LIKE', '%'.$val.'%');
				}
				
			}
		}
	}
	
	public function apply_sort() {
		$ses = 'shake.sort.'.$this->module;
		
		if (Input::has('sort_param')) {
			session([$ses.'.sort_param' => Input::get('sort_param')]);
			session([$ses.'.sort_trend' => Input::get('sort_trend')]);
		} else if (!empty($this->def_sort)) {
			session([$ses.'.sort_param' => $this->def_sort[0]]);
			session([$ses.'.sort_trend' => $this->def_sort[1]]);
		}
		
		if (session($ses.'.sort_param')) {
			$param = session($ses.'.sort_param');
			$trend = session($ses.'.sort_trend');
			$this->data = $this->data->orderBy($param, $trend);
		}
		
		$this->data = $this->data->orderBy('id', 'desc');
	}
	
	/**
	 * собираем всю таблицу вместе
	 * @return string
	 */
	public function html() {
		
		if (empty($this->module)) {
			return '<h3>Не задано имя модуля для таблицы</h3>';
		}
		
		if (empty($this->model)) {
			return '<h3>Не задана модель!</h3>';
		}

        
		$this->apply_filter();
		$all_count = $this->data->count();
		$this->apply_sort();
		$this->apply_pager();
        
		
		$ret = $this->filter().$this->head().$this->body();
		
		$ret = '<table class="table table-hover">'
			.$ret
			.$this->multiple()
			.'</table>';
		
		$ret .= '<div class="table__all_count">Общее кол-во: '.$all_count.'</div>';
		
		$ret .= '<div class="table__bottom">';
		$ret .= $this->pager();
		$ret .= $this->page_count();
		$ret .= '</div>';
		
		return $ret;
	}
	
}
