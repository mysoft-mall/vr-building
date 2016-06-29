<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/16 9:18
 */

namespace app\components;


use yii\base\UserException;

class Service
{
    private static $instances=[];
    
    private function __construct(){}
    private function __clone(){}

    /**
     * @return $this
     */
    public static function Instance()
    {
        $class = get_called_class();
        if(!array_key_exists($class, self::$instances)){
            self::$instances[$class] = new $class;
        }
        
        return self::$instances[$class];
    }

    /**
     * 抛出业务异常
     * @param $msg
     * @throws UserException
     */
    public static function throwError($msg)
    {
        throw new UserException($msg);
    }
        
}