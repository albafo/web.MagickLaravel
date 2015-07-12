<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;


use Magia\Model\ViewComposers\ViewIncludes;

class WysiwygField extends Field{



    protected $value = '';

    protected static $addedScripts = false;

    public function __construct()
    {
        if(!self::$addedScripts) {
            ViewIncludes::getInstance()->addCss("plugins/summernote-master/summernote.css");
            ViewIncludes::getInstance()->addJsAfter("plugins/summernote-master/summernote.min.js");
            ViewIncludes::getInstance()->addScript("
                <script>

                    $('.summernote').summernote({
                      height: 350
                    });

                </script>
            ");
        }

        self::$addedScripts = true;

    }

    public function generateCode($extraAttr = array())
    {

        return "<div class='summernote'>{$this->value}</div>";
    }


    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param mixed $value
     */
    public static function generateField($column, $value=null)
    {
        $field = new WysiwygField();
        if($value)
            $field->value = $value;
        $field->setLabel($column->getName());
        return $field;
    }





}