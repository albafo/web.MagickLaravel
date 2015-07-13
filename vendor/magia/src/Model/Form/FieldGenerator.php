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

        foreach($item->getRelations() as $relation=>$relationModel)
        {

            $fields[] = $this->generateFieldFromRelation($relation, $relationModel);
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

        $fieldComposer = new $fieldComposer();
        return $fieldComposer->generateField($column, $value);
    }

    public function generateFieldFromRelation($relation, $relationModel)
    {
        
    }


    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     */
    public function selectFieldComposer($column)
    {
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
            case 'text':
                $field = 'Wysiwyg';
                break;
            case 'simple_array':
                $field = 'Select';
                break;
            default :
                $field = 'Input';

        }

        if($this->isLikeImage($column))
            $field = 'Image';



        $fieldComposer = $field."Field";
        return "\\Magia\\Model\\Form\\".$fieldComposer;
    }

    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * return boolean
     */
    public function isLikeImage($column)
    {
        $type = $column->getType()->getName();
        $name = $column->getName();
        $result = false;
        if(($name == "image" || $name == "picture") && ($type == "string" || $type == "text"))
        {
            $result = true;
        }
        return $result;
    }
}