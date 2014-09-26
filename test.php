<?php
class MyClass {
    const CONST_VALUE = 'A constant value<br>';
}

$classname = 'MyClass';
echo $classname::CONST_VALUE; // As of PHP 5.3.0

echo MyClass::CONST_VALUE;



class OtherClass extends MyClass
{
    public static $my_static = 'static var<br>';

    public static function doubleColon() {
        echo parent::CONST_VALUE;
        echo self::$my_static;
    }
}

$classname = 'OtherClass';
echo $classname::doubleColon(); // As of PHP 5.3.0

OtherClass::doubleColon();
?>