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

        $this->addImageScripts($column->getName());


        return $result;
    }

    protected function addImageScripts($name)
    {
        ViewIncludes::getInstance()->addScript("
        <script>
            var resetSrc = false;

            function saveFirstImage(image) {
                if(!resetSrc) {
                    resetSrc = image.attr('src');
                }
            }

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

            function resetAction(resetButton, image, input, hidden) {
                resetButton.click(function() {
                    image.attr('src', resetSrc);
                    input = typeof input !== 'undefined' ? input : false;
                    hidden = typeof hidden !== 'undefined' ? hidden : false;
                    if(input)
                        input.val('');
                    if(hidden)
                        hidden.val(0);
                });
            }
            $('button.remove-image').click(function(event) {
                var hiddenDelete = $(this).parent().find('input[type=hidden]');
                var image = $(this).parent().find('img');
                var resetButton = $(this).parent().find('button.reset-image');

                hiddenDelete.val(1);
                saveFirstImage(image);
                image.attr('src', '".asset(self::SRC_EMPTY_IMAGE)."');
                resetAction(resetButton, image, false, hiddenDelete);
                msgImageChanged();

            });

            $('#field_$name').change(function(event){

                var input = $(this);
                var image = $(this).parent().find('img');
                var resetButton = $(this).parent().find('button.reset-image');

                saveFirstImage(image);

                resetAction(resetButton, image, input);
                msgImageChanged();


                var files = event.target.files;

                for (var i = 0, f; f = files[i]; i++) {

                    // Only process image files.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                  // Closure to capture the file information.
                    reader.onload = (function(theFile) {
                        return function(e) {
                        // Render thumbnail.

                            image.attr('src', e.target.result);
                        };
                    })(f);

                    // Read in the image file as a data URL.
                    reader.readAsDataURL(f);
                }
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