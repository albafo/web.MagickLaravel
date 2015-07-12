<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;



class NumberField extends InputField{

    const TYPE = "number";

    protected static function getHtmlAttributes($column, $value = null)
    {
        $result = parent::getHtmlAttributes($column, $value);
        if($column->getUnsigned())
        {
            $result .= "min='0' ";
        }
        return $result;
    }


}