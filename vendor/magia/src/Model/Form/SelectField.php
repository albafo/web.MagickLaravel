<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;


use Magia\Model\ViewComposers\ViewIncludes;

class SelectField extends Field
{

    protected $options = array();
    protected $value = null;
    protected $multiple = false;

    protected static $addedScripts = false;

    public function __construct()
    {


    }

    public function generateCode($extraAttr = array())
    {
        $options = "";

        $userAttr = '';

        foreach($extraAttr as $index => $value) {
            $userAttr .= "$index='$value' ";
        }

        foreach($this->options as $option) {
            $option = str_replace("'", '', $option);
            $option = str_replace("\"", '', $option);
            $selected = "";

            if($this->multiple) {
                $values = explode(",", $this->value);
                if(in_array($option, $values)) {
                    $selected = "selected";
                }
            }
            if($this->value == $option) {
                $selected = "selected";
            }
            $options .= "<option value='$option' $selected >$option</option>";
        }
        $multiple = "";
        if($this->multiple)
            $multiple="multiple";



        return "<select $multiple $userAttr>$options</select>";
    }


    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param mixed $value
     */
    public static function generateField($column, $value=null)
    {
        $field = new SelectField();
        $field->options = $column->getValues();
        if(!$column->hasUniqueValue())
            $field->multiple = true;
        if($value)
            $field->value = $value;
        $field->setLabel($column->getName());
        return $field;
    }





}