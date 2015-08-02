<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 10/07/15
 * Time: 18:35
 */

namespace Magia\Model\Form;



use Illuminate\Database\Eloquent\Relations\Relation;
use Magia\Model\Relations\MagiaRelation;

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

            $relationObject = $item->$relation();
            $fields[] = $this->generateFieldFromRelation($relation, $relationObject, $relationModel);
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

        $obligation = $this->getObligationFromColumn($column);

        $fieldComposer = new $fieldComposer($obligation);
        return $fieldComposer->generateField($column, $value);
    }

    public function generateFieldFromRelation($relation, $relationObject, $relationModel)
    {
        $fieldComposer = $this->selectFieldComposerFromRelation($relationObject);
        $obligation = $this->getObligationFromRelation($relationObject);
        $fieldComposer = new $fieldComposer($obligation);
        return $fieldComposer->generateFieldFromRelation($relation, $relationObject, $relationModel);
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

    public function selectFieldComposerFromRelation($relation)
    {
        $field = null;

        if($relation instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo)
        {
            $field = "Select2";
        }
        if($relation instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany)
        {
            $field = "Select2";
        }
        if($field)
            $field .= "Field";
        return "\\Magia\\Model\\Form\\".$field;
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
    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * return boolean
     */
    public function getObligationFromColumn($column)
    {
        return $column->getNotnull();
    }

    /* @param \Illuminate\Database\Eloquent\Relations\Relation $relation
     * return boolean
     */
    public function getObligationFromRelation($relation)
    {
        $result = false;
        $className = class_basename($relation);

        if ($className == MagiaRelation::BELONGS_TO) {

            $column = $this->getColumn($relation->getParent()->getTable(), $relation->getForeignKey());

            $result = $this->getObligationFromColumn($column);

        }

        return $result;
    }

}