<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;



class TextField extends InputField{

    const TYPE = "text";

    protected static function getHtmlAttributes($column, $value = null)
    {
        $result = parent::getHtmlAttributes($column, $value);

        if($length = $column->getLength()) {
            $result .= "maxlength='$length' ";
        }
        return $result;
    }


}