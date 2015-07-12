<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 10/07/15
 * Time: 23:43
 */

namespace Magia\Model\Form;


class InputField extends Field{

    protected $type = '';
    protected $htmlAttributes = '';
    public $labelName = '';
    public $labelFor = '';



    public function generateCode($extraAttr = array())
    {
        $userAttr = '';

        foreach($extraAttr as $index => $value) {
            $userAttr .= "$index='$value' ";
        }

        return "<input type='{$this->type}' $this->htmlAttributes $userAttr>";
    }

    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param mixed $value
     */
    public static function generateField($column, $value=null)
    {

        $fieldObject = null;
        $type = $column->getType()->getName();
        $field = null;
        switch($type)
        {
            case 'integer':
            case 'float':
            case 'smallint':
            case 'bigint':
            case 'decimal':
                $field = "Number";
                break;
            case 'string':
                $field = "Text";
                break;
            case 'boolean':
                $field = "Checkbox";
                break;
            case 'date':
                $field = "Date";
                break;
            case 'datetime':
                $field = "DateTime";
                break;
            case 'time':
                $field = "Time";
                break;
            default:
                $field = null;
        }

        if($field) {
            $fieldComposer = "\\Magia\\Model\\Form\\" . $field . "Field";

            $fieldObject = new InputField();
            $fieldObject->setLabel($column->getName());
            $fieldObject->type = $fieldComposer::TYPE;
            $fieldObject->htmlAttributes = $fieldComposer::getHtmlAttributes($column, $value);
        }

        return $fieldObject;

    }

    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param mixed $value
     * @return string
     */
    protected static function getHtmlAttributes($column, $value = null)
    {
        $result = "";
        if(isset($value))
            $result.="value='$value' ";

        if($name = $column->getName())
            $result.="id='field_$name' name='field[$name]' ";


        return $result;
    }

}