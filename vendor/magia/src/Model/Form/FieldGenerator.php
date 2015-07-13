<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 10/07/15
 * Time: 18:35
 */

namespace Magia\Model\Form;


class FieldGenerator {


    /**
     * @param \Magia\Model\MagickEloquent $item
     */


    public function generateFields($item)
    {
        $fields = array();
        $table = $item->getTable();
        foreach($item->getAttributes() as $index => $value)
        {
            $fields[] = $this->generateField($table, $index, $value);
        }

        return $fields;


    }


    /**
     * @param String $table
     * @param mixed $index
     * @return \Doctrine\DBAL\Schema\Column
     */
    public function getColumn($table, $index) {


        $column = \DB::connection()->getDoctrineColumn($table, $index);

        return $column;
    }

    public function generateField($table, $index, $value) {

        $column = $this->getColumn($table, $index);
        $fieldComposer = $this->selectFieldComposer($column);


        return $fieldComposer::generateField($column, $value);
    }


    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     */
    public function selectFieldComposer($column)
    {
        $type = $column->getType()->getName();

        $field = null;
        $addScripts = false;

        switch($type) {
            case 'integer':
            case 'string':
            case 'boolean':
            case 'date':
            case 'datetime':
            case 'float':
            case 'smallint':
            case 'bigint':
            case 'decimal':
            case 'time':
                $field = 'Input';
                break;
            case 'text':
                $field = 'Wysiwyg';
                break;
            case 'simple_array':
                $field = 'Select';
                break;
            default :
                $field = 'Input';

        }




        $fieldComposer = $field."Field";
        return "\\Magia\\Model\\Form\\".$fieldComposer;
    }

}