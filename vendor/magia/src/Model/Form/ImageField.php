<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;





class ImageField extends InputField
{
    protected $value = "";

    protected $type = "file";

    public function generateCode($extraAttr = array())
    {
        $result = parent::generateCode($extraAttr);

        $result .= "
        <br>
        <img src='".asset($this->value)."' style='max-width: 100%; max-height: 350px;'>
        <br>
        <button type='button' class='btn btn-danger'>Eliminar imagen</button>
        ";

        return $result;
    }

    public function generateField($column, $value = null)
    {
        $result = parent::generateField($column, $value);
        $result->value = $value;
        return $result;
    }


    protected static function getHtmlAttributes($column, $value = null)
    {
        $result = "";

        if($name = $column->getName())
            $result.="id='field_$name' name='field[$name]' ";


        return $result;
    }


}