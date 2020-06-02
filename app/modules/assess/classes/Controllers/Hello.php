<?php


namespace Project\Evaluation\Controllers;
use \Phalcon\Mvc\Controller;

class Hello extends Controller{

    static function sayHello() {
        return "Hello";
    }

    static function getMenuItem() {
        $mi = \Project\Evaluation\Models\MenuItem::find();

        $mi->delete();

        return $mi;
    }
    
}
