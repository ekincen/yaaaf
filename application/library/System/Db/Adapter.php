<?php
/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 */

class System_Db_Adapter
{

    public static $_db;
    public static $_config;

    const DB_ADAPTER_CLASS_PREFIX = 'System_Db_Adapter_';

    private function __construct()
    {
    }

    private function __clone()
    {

    }

    public static function getAdapter($adapter)
    {
        return isset(self::$_db[$adapter]) ? self::$_db[$adapter] : false;
    }

    public static function setConfig($config = array())
    {
        self::$_config = $config;
    }

    public static function connect($adapter)
    {
        $adapterClass = self :: DB_ADAPTER_CLASS_PREFIX . ucfirst($adapter);
        if (class_exists($adapterClass))
        {
            $adapterClass = new $adapterClass();
            self::$_db[$adapter] = $adapterClass;

            if(!self::$_config){
                self::$_config =new Yaf_Config_Ini(CONF_PATH.'database.ini');
            }
            $adapter=strtolower($adapter);
            return call_user_func_array(array($adapterClass, 'connect'), current((array) self::$_config->$adapter));
        }
        else
        {
            throw new Exception("No adapter class with '$adapter'");
        }
    }

}