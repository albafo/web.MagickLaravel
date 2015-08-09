<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;


use Magia\View\ViewComposers\ViewIncludes;

class WysiwygField extends Field
{

    protected $value = '';
    protected $name = '';


    public function __construct($obligation)
    {
        parent::__construct($obligation);
        ViewIncludes::getInstance()->addCss("plugins/summernote-master/summernote.css");
        ViewIncludes::getInstance()->addJsAfter("plugins/summernote-master/summernote.min.js");
        ViewIncludes::getInstance()->addScript("
            <script>
                var editor = $('.summernote');
                editor.summernote({
                  height: 350
                });

            </script>
        ");



    }

    public function generateCode($extraAttr = array())
    {


        return "<textarea class='summernote' name='field[{$this->name}]'>{$this->value}</textarea>";
    }


    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param mixed $value
     */
    public  function generateField($column, $value=null)
    {

        if($value)
            $this->value = $value;
        $this->setLabel($column->getName());
        $this->name = $column->getName();
        return $this;
    }





}