<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 12.02.2017
 * Time: 16:08
 */

function pr($p) {
    echo "<pre>";
    if (is_array($p) || is_object($p)) {
        print_r($p);
    } else if ( is_bool($p) || empty($p) || (is_string($p) && trim($p) == '') ) {
        var_export($p);
    } else {
        print_r($p);
    }
    echo "</pre>";
}

function uncache($url) {
    $url =  '/' . $url;
    $url = str_replace('//', '/', $url);
    $full_path = public_path() . $url;
    
    $pref = 'not_found';
    if(file_exists($full_path)){
        $pref = filemtime($full_path);
    }
    
    return $url . '?' . $pref;
}

/**
 * добавляет к текущему запросу дополнительные параметры
 * @param $arr
 * @return string
 */
function add_to_query($arr) {
    return http_build_query(array_merge(request()->query(), $arr));
}

/**
 * удаляет параметры у текущего запроса
 * @param $arr
 * @return string
 */
function del_from_query($arr) {
    
    $tmp = request()->query();
    foreach ($arr as $val) {
        if (isset($tmp[$val])) {
            unset($tmp[$val]);
        }
    }
    return http_build_query($tmp);
}

/**
 * Вернет слово в правильном склонении в зависимости от кол-ва
 * @param $number
 * @param $one
 * @param $two
 * @param $five
 * @return mixed
 */
function plurar($number, $one, $two , $five) {
    if (($number - $number % 10 ) % 100 != 10) {
        if ($number % 10 == 1 ) {
            $result = $one;
        } elseif ( ($number % 10 >= 2 ) && ($number % 10 <= 4) ) {
            $result = $two;
        } else {
            $result = $five;
        }
    } else {
        $result = $five;
    }
    return $result ;
}

/**
 * Добавит к названиям таблиц префиксы
 * @param $str
 * @return mixed
 */
function table_prefix($str) {

    preg_match_all('/([A-z0-9]+\.[A-z0-9]+)/ui', $str, $arr);
    $prefix = DB::getTablePrefix();

    if (isset($arr[0])) {
        foreach ($arr[0] as $item) {
            if (!is_numeric($item)) {
                $tmp = explode('.', trim($item));
                if (count($tmp) == 2) {
                    $new = '`'.$prefix.$tmp[0].'`.`'.$tmp[1].'`';
                    $str = str_replace($item, $new, $str);
                }
            }
        }
    }

    return $str;
}

/**
 * Возвращает SQL с подставленными значениями
 * @param $builder Illuminate\Database\Query\Builder
 * @return string
 */
function toSql($builder) {
    $sql = $builder->toSql();
    foreach($builder->getBindings() as $binding)
    {
        if ($binding instanceof \DateTime) {
            $binding = $binding->format('Y-m-d H:i:s');
        }

        $value = is_numeric($binding) ? $binding : "'".$binding."'";
        $sql = preg_replace('/\?/', $value, $sql, 1);
    }
    return $sql;
}

/**
 * Выведет информацию о времени существования сайта
 * @param $start_year
 * @return string
 */
function siteExist($start_year) {
    return (date('Y') <= $start_year) ? $start_year : $start_year.' — '.date('Y');
}

/**
 * Выведт значени поля у пользователя или пустоту
 * @param $fname
 * @return string
 */
function user_field($fname) {
    return \Auth::user() ? \Auth::user()->{$fname} : NULL;
}

/**
 * @return string
 * @param string $str - Исходная строка
 * @param int $length - Размер результирующей строки
 * @param string $char - Символ которым дополнять строку
 * @param string $pos - Позиция добавления r/l
 * @desc Дополняем строку до нужного размера
 */
function fit_line($str, $length, $char = ' ', $pos = 'r') {
    $str_length = mb_strlen($str, 'UTF-8');
    if ($str_length < $length) {
        $count = $length - $str_length;
        while ($count > 0) {
            $str = ($pos == 'r') ? $str.$char : $char.$str;
            $count--;
        }
    }
    return $str;
}

/**
 * Проверяет включены ли Кукисы у пользователя
 * @return bool
 */
function isCookieEnable() {
    if (isset($_SERVER['HTTP_COOKIE'])) {
        return true;
    }
    return false;
}

/**
 * Вспомогательная функция для русской раскладки
 * @param $str
 * @param null $encoding
 * @return string
 */
if(!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str, $encoding = NULL) {
        if($encoding === NULL)  {
            $encoding    = mb_internal_encoding();
        }

        return mb_substr(mb_strtoupper($str, $encoding), 0, 1, $encoding) . mb_substr($str, 1, mb_strlen($str)-1, $encoding);
    }
}

if (! function_exists('module_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path
     * @return string
     */
    function module_path($module_name, $path = '')
    {
        return app('path') . DIRECTORY_SEPARATOR . 'Modules' . DIRECTORY_SEPARATOR . ucfirst(camel_case($module_name)) . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

/**
 * Выкидывает стандартную ошибку
 * @param string $message
 * @param int $code
 * @param null $previous
 * @throws \App\Exceptions\ErrorMessage
 */
function error($message = '', $code = 0, $previous = null) {
    throw new \App\Exceptions\ErrorMessage($message, $code, $previous);
}

/**
 * Вернет настройку по алиасу
 * @param $alias
 * @return mixed
 */
function setting($alias) {
    return app('App\Modules\Settings\Models\Setting')->firstOrNew(['alias' => $alias])->text;
}

