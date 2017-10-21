<?php
class Globals {
    const app = 'PORTAL';
    const version= '1.0';
    const cssversion= "1.0";
    public static $jsonrpcURL= "";
    public static $token="";
    public static $postmantoken="";
    private static $config="";
    //

    
    public static function ConfiguracionIni(){     
        if (file_exists('../../ini/config.ini')) {
            self::$config = parse_ini_file('../../ini/config.ini',true); 
        } 
        else if (file_exists('../ini/config.ini')) {
            self::$config = parse_ini_file('../ini/config.ini',true); 
        }   
        self::$jsonrpcURL= self::$config[self::app]['jsonrpcURL'];
        self::$token= self::$config[self::app]['token'];
        self::$postmantoken= self::$config[self::app]['postmantoken'];
    }  
}
?>