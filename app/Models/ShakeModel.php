<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:08
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShakeModel extends \Eloquent  
{
    protected $fields = [];
    protected $guarded = []; //all access
    
    /**
     * Вернет все поля формирующие форму редактирования
     * @return array
     */
    public function getFormFields()
    {
        return $this->fields;
    }
    
    /**
     * @param $data
     * @param string $behavior
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data, $behavior = 'default')
    {
        return validator($data);
    }
        
}
