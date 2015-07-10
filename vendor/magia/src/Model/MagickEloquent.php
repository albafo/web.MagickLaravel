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
        if($this->title == '') {
            $this->title = $this->cleanedClassName();
        }

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

        return $allAttributes;

    }

    public function getAllAttributes() {
        return parent::getAttributes();
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }





}