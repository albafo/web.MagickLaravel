<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;



class NumberField extends InputField
{

    protected $type = "number";

    protected static function getHtmlAttributes($column, $value = null)
    {
        $result = parent::getHtmlAttributes($column, $value);
        if($column->getUnsigned())
        {
            $result .= "min='0' ";
        }
        if($column->getType()->getName() == "float" || $column->getType()->getName() == "decimal") {


            $zeroDecimal = "";
            if($precision = $column->getScale()){

                for($i=1; $i<$precision; $i++) {
                    $zeroDecimal .= "0";
                }
            }

            $result .= "step='0.".$zeroDecimal."1' ";
        }


        return $result;
    }


}