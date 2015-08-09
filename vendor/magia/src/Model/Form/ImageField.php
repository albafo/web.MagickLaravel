<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 11/07/15
 * Time: 19:53
 */

namespace Magia\Model\Form;





use Magia\View\ViewComposers\ViewIncludes;

class ImageField extends InputField
{
    protected $value = "";
    protected $name = "";
    protected $type = "file";
    const SRC_EMPTY_IMAGE = "packages/magia/images/no_image_available.png";


    public function generateCode($extraAttr = array())
    {
        $result = parent::generateCode($extraAttr);
        $srcImg = self::SRC_EMPTY_IMAGE;
        if($this->value) {
           $srcImg = $this->value;
        }
        $result .= "
        <br>
        <img src='".asset($srcImg)."' style='max-width: 100%; max-height: 350px;'>
        <br>
        <input type='hidden' name='deleted_image[{$this->name}]' value='0'>
        <button type='button' class='btn btn-danger remove-image'>Eliminar imagen</button> <button type='button' class='btn btn-info reset-image'>Resetear imagen</button>
        ";

        return $result;
    }

    public function generateField($column, $value = null)
    {
        $result = parent::generateField($column, $value);
        $result->value = $value;
        $this->name = $column->getName();

        ViewIncludes::getInstance()->addJsAfter('plugins/magia/imageform.js');


        $this->addImageScripts($column->getName());


        return $result;
    }

    protected function addImageScripts($name)
    {
        ViewIncludes::getInstance()->addScript("
        <script>

            function msgImageChanged() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut',
                    timeOut: 5000
                };
                toastr.info('Los cambios de imágenes no se registrarán hasta que se guarde la ficha.', '¡CUIDADO!');
            }



            var image_$name = $('#field_$name').imageform({
                noImageSrc : '".asset(self::SRC_EMPTY_IMAGE)."',
                imgDOM: $('#field_$name').parent().find('img'),
                hiddenDeleteDOM: $('#field_$name').parent().find('input[type=hidden]'),
                onImgUpdate: msgImageChanged
            });




            $('#field_$name').parent().find('button.remove-image').click(function(event) {

               image_$name.imageform('remove');

            });

             $('#field_$name').parent().find('button.reset-image').click(function(event) {

               image_$name.imageform('reset');

            });

            $('#field_$name').change(function(event){

                image_$name.imageform('eventToImage', event);

            });



        </script>
        ");
    }


    protected  function getHtmlAttributes($column, $value = null)
    {
        $result = "";

        if($name = $column->getName())
            $result.="id='field_$name' name='field[$name]' ";


        return $result;
    }


}