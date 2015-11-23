<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/23
 * Time: 18:30
 */

namespace Util;


abstract class ControllerUnitTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $className
     * @param array $injectFiles
     */
    public function createController($className, array $injectFiles = [])
    {
        $instance = new $className();
        foreach ($injectFiles as $property => $object) {
            $refProperty = new \ReflectionProperty($className, $property);
            $refProperty->setAccessible(true);
            $refProperty->setValue($instance, $object);
        }
        return $instance;
    }
}