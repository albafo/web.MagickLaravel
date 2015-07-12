<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 12/07/15
 * Time: 19:31
 */

namespace Magia\Model\ViewComposers;


class ViewIncludes {

    protected static $instance = null;
    protected $css = array();
    protected $jsBefore = array();
    protected $jsAfter = array();
    protected $scripts = array();


    /**
     * @return ViewIncludes
     */
    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new ViewIncludes();
        }

        return self::$instance;
    }

    public function addCss($path)
    {
        $this->css[] = $path;
    }

    public function addJsBefore($path)
    {
        $this->jsBefore[] = $path;
    }

    public function addJsAfter($path)
    {
        $this->jsAfter[] = $path;
    }

    /**
     * @return array
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @return array
     */
    public function getJsBefore()
    {
        return $this->jsBefore;
    }

    /**
     * @return array
     */
    public function getJsAfter()
    {
        return $this->jsAfter;
    }

    /**
     * @return array
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    public function addScript($script)
    {
        $this->scripts[] = $script;
    }






}