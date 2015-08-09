<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 10/07/15
 * Time: 23:43
 */

namespace Magia\Model\Form;


class InputField extends Field{

    protected $type = 'text';
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
    public function generateField($column, $value=null)
    {
        parent::generateField($column);
        $this->setLabel($column->getName());
        $this->htmlAttributes = $this->getHtmlAttributes($column, $value);

        return $this;

    }

    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param mixed $value
     * @return string
     */
    protected function getHtmlAttributes($column, $value = null)
    {
        $result = "";
        if(isset($value))
            $result.="value='$value' ";

        if($name = $column->getName()) {
            $fieldName = $this->generateFieldName($name);
            $result .= "id='field_$name'  $fieldName";
        }


        return $result;
    }

}