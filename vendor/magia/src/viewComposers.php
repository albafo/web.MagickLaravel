<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 19/06/15
 * Time: 00:18
 */

use \Magia\View\ViewComposers\ViewIncludes;

View::composer('magia::layout', function($view)
{

    $view->css = array(
        "plugins/bootstrap/css/bootstrap.min.css",
        "css/custom.css",
        "css/modern.min.css",
        "css/themes/green.css",
        "plugins/toastr/toastr.min.css",
        "plugins/metrojs/MetroJs.min.css",
        "plugins/weather-icons-master/css/weather-icons.min.css",
        "plugins/slidepushmenus/css/component.css",
        "plugins/3d-bold-navigation/css/style.css",
        "plugins/switchery/switchery.min.css",
        "plugins/waves/waves.min.css",
        "plugins/offcanvasmenueffects/css/menu_cornerbox.css",
        "plugins/line-icons/simple-line-icons.css",
        "plugins/fontawesome/css/font-awesome.css",

        "plugins/uniform/css/uniform.default.min.css",
        "plugins/pace-master/themes/blue/pace-theme-flash.css",
    );

    $view->css = array_merge($view->css, ViewIncludes::getInstance()->getCss());

    foreach($view->css as &$item) {
        $item = asset("packages/magia/" . $item);
    }

    $view->jsBefore = array(
        "plugins/3d-bold-navigation/js/modernizr.js",
        "plugins/offcanvasmenueffects/js/snap.svg-min.js"
    );

    $view->jsBefore = array_merge($view->jsBefore, ViewIncludes::getInstance()->getJsBefore());

    $view->jsAfter = array(
        "plugins/jquery/jquery-2.1.3.min.js",
        "plugins/jquery-ui/jquery-ui.min.js",
        "plugins/pace-master/pace.min.js",
        "plugins/jquery-blockui/jquery.blockui.js",
        "plugins/bootstrap/js/bootstrap.min.js",
        "plugins/jquery-slimscroll/jquery.slimscroll.min.js",
        "plugins/switchery/switchery.min.js",
        "plugins/uniform/jquery.uniform.min.js",
        "plugins/offcanvasmenueffects/js/classie.js",
        "plugins/offcanvasmenueffects/js/main.js",
        "plugins/waves/waves.min.js",
        "plugins/3d-bold-navigation/js/main.js",
        "plugins/waypoints/jquery.waypoints.min.js",
        "plugins/jquery-counterup/jquery.counterup.min.js",
        "plugins/toastr/toastr.min.js",
        "plugins/flot/jquery.flot.min.js",
        "plugins/flot/jquery.flot.time.min.js",
        "plugins/flot/jquery.flot.symbol.min.js",
        "plugins/flot/jquery.flot.resize.min.js",
        "plugins/flot/jquery.flot.tooltip.min.js",
        "plugins/curvedlines/curvedLines.js",
        "plugins/metrojs/MetroJs.min.js",
        "js/modern.js",
        "js/pages/dashboard.js"
    );

    $view->jsAfter = array_merge($view->jsAfter, ViewIncludes::getInstance()->getJsAfter());



    foreach($view->jsBefore as &$item) {
        $item = asset("packages/magia/" . $item);
    }

    foreach($view->jsAfter as &$item) {
        $item = asset("packages/magia/" . $item);
    }

    $view->scripts = array();

    foreach(ViewIncludes::getInstance()->getScripts() as $script)
    {
        $view->scripts[] = "$script";
    }


});

View::composer('magia::edit', 'Magia\\View\\ViewComposers\\EditComposer');
