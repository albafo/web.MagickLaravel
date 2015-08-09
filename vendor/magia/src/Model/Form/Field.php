<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 12/07/15
 * Time: 20:17
 */

namespace Magia\Model\Form;


class Field {
    public $labelName = '';
    public $labelFor = '';
    protected $obligatory = false;
    protected $name;


    public function __construct($obligatory=false)
    {
        $this->obligatory = $obligatory;
    }
    protected function setLabel($name)
    {
        $this->labelName = ucfirst(strtolower($name));
        $this->labelFor = "field_".$name;
    }
    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param mixed $value
     */
    public function generateField($column)
    {
        $this->name = $column->getName();
    }

    protected function generateFieldName($name)
    {
        return "name='field[$name]'";
    }

    public function isObligatory() {
        return $this->obligatory;
    }

    public function getName() {
        return $this->name;
    }

}