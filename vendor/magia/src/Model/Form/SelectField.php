<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;



class SelectField extends Field
{

    protected $options = array();
    protected $value = array();
    protected $multiple = false;
    protected $name = null;

    protected static $addedScripts = false;



    public function generateCode($extraAttr = array())
    {
        $options = "";

        $userAttr = '';

        foreach($extraAttr as $index => $value) {
            $userAttr .= "$index='$value' ";
        }

        foreach($this->options as $index=>$option) {

            $selected = "";



            if(in_array($index, $this->value)) {
                $selected = "selected";
            }


            $options .= "<option value='$index' $selected >$option</option>";
        }
        $multiple = "";
        if($this->multiple)
            $multiple="multiple";
        $fieldName = $this->generateFieldName($this->name);
        return "<select $multiple $userAttr $fieldName>$options</select>";
    }

    protected function generateFieldName($name)
    {
        $result =  parent::generateFieldName($name);
        if($this->multiple) {
            $result = "name='field[$name][]'";
        }
        return $result;
    }


    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param mixed $value
     */
    public function generateField($column, $value=null)
    {

        $multiple = false;
        $options = $column->getValues();
        $options_temp = array();
        foreach($options as $index=>$option) {
            $option = str_replace("'", '', $option);
            $option = str_replace("\"", '', $option);
            $options_temp[$option] = $option;
        }
        $options = $options_temp;
        if(!$column->hasUniqueValue())
            $multiple = true;
        $value = explode(",", $value);
        $name = $column->getName();
        return $this->generateFilledField($options, $name, $multiple, $value);
    }

    public function generateFilledField($options, $name, $multiple = false, $value = array())
    {
        $this->options = $options;
        $this->multiple = $multiple;
        $this->value = $value;
        $this->name = $name;
        $this->setLabel($name);
        return $this;
    }







}