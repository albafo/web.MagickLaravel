<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;



use Magia\View\ViewComposers\ViewIncludes;

class DateTimeField extends InputField{


    const FORMAT_DATETIME = "d/m/Y H:i";

    public function generateField($column, $value=null)
    {
        if($value) {
            $value = date(self::FORMAT_DATETIME, strtotime($value));
        }
        $result =  parent::generateField($column, $value);
        ViewIncludes::getInstance()->addCss("plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css");
        ViewIncludes::getInstance()->addJsAfter("plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js");
        ViewIncludes::getInstance()->addJsAfter("plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js");

        ViewIncludes::getInstance()->addScript("

            <script>


                    $('#field_{$this->getName()}').datetimepicker({
                        format: 'dd/mm/yyyy hh:ii',
                        language: 'es'

                    });

            </script>

        ");

        return $result;

    }









}