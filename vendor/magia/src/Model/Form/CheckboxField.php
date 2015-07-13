<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;



class CheckboxField extends InputField
{

    protected $type = "checkbox";

    protected static function getHtmlAttributes($column, $value = null)
    {
        $result = parent::getHtmlAttributes($column, $value);

        if($value) {
            $result .= "checked ";
        }
        return $result;
    }


}