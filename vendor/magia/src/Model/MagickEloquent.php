<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 08/07/15
 * Time: 22:29
 */

namespace Magia\Model;


use Illuminate\Database\Eloquent\Model;

class MagickEloquent extends Model{

    protected $title = '';
    protected $fieldNames = array();
    protected $visiblesOnList = array();
    protected $urlName = '';

    /**
     * @return string
     */
    public function getUrlName()
    {
        return $this->urlName;
    }

    /**
     * @param string $urlName
     */
    public function setUrlName($urlName)
    {
        $this->urlName = $urlName;
    }





    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function __construct() {
        parent::__construct();
        if($this->title == '') {
            $this->title = $this->cleanedClassName();
        }
        foreach($this->getAttributes() as $index => $value)
        {
            $this->visiblesOnList[] = $index;
        }

    }

    public function setVisibleOnList($visibles = array())
    {
        $this->visiblesOnList = $visibles;
    }

    protected function cleanedClassName() {
        $className = get_class($this);
        $classNameParts = explode("\\", $className);
        $classNameCleaned = $classNameParts[count($classNameParts)-1];
        return $classNameCleaned;
    }

    public function getAttributes()
    {
        $allAttributes = parent::getAttributes();
        $hidden = $this->getHidden();
        foreach($allAttributes as $index => $value) {
            if(in_array($index, $hidden)) {
                unset($allAttributes[$index]);
            }
        }

        foreach($this->getRelations() as $relation=>$relationModel)
        {
            $index = $this->$relation()->getForeignKey();
            unset($allAttributes[$index]);
        }

        return $allAttributes;

    }

    public function getAllAttributes() {
        return parent::getAttributes();
    }

    public function getListAttributes()
    {
        $visibles = $this->visiblesOnList;
        $attributes = $this->getAttributes();
        foreach($attributes as $index=>&$attribute) {
            if(!in_array($index, $visibles))
                unset($attributes[$index]);
        }
        return $attributes;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getRelationType($relation)
    {
        return get_class($relation);
    }

    public function getText() {
        return $this;
    }

    public function setFieldName($column, $newName)
    {
        $this->fieldNames[$column] = $newName;
    }

    public function getFieldName($column) {
        $result = $column;
        if($name = $this->fieldNames[$column])
            $result = $name;
        return $result;
    }


    public function count() {
        return $this->all()->count();
    }

    public static function getModel($modelString)
    {
        $modelEloquent = new MagickEloquent();
        $model = $modelEloquent->cleanModel($modelString);

        $modelPath = '\\App\\'.$model;
        if(!class_exists($modelPath)) {
            throw new \Exception("Class $modelPath not found");
        }

        /* @var \Magia\Model\MagickEloquent $modelObject */
        $modelObject = new $modelPath();
        if(!is_a($modelObject, 'Magia\Model\MagickEloquent')) {
            throw new \Exception("Class $model is not a MagickEloquent Model");
        }
        $modelObject->setUrlName($modelString);
        return $modelObject;
    }

    protected function cleanModel($model)
    {
        $parts = explode("-", $model);
        $model = '';
        foreach($parts as $part)
            $model .= ucfirst($part);
        return $model;
    }



}