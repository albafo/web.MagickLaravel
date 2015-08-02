<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 10/07/15
 * Time: 18:25
 */

namespace Magia\View\ViewComposers;

use Illuminate\Contracts\View\View;
use Magia\Model\Form\FieldGenerator;


class EditComposer {

    public function compose(View $view){

        $fieldGenerator = new FieldGenerator();
        $fields = $fieldGenerator->generateFields($view->item);
        $view->fields = $fields;

    }
}