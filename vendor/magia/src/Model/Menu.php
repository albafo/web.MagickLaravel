<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 19/06/15
 * Time: 17:08
 */

namespace Magia\Model;



class Menu {


    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }


    public function getMenu() {

        $items = array();
        $application->getAllModels();

    }

}