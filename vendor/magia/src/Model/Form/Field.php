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

    protected function setLabel($name)
    {
        $this->labelName = ucfirst(strtolower($name));
        $this->labelFor = "field_".$name;
    }

}