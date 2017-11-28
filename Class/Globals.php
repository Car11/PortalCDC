<?php
class Globals {
    const app = 'PORTAL';
    const version= '1.0';
    const cssversion= "1.0";
    public static $jsonrpcURL= "http://10.129.20.177/kanboard/jsonrpc.php";
    public static $token="anNvbnJwYzphZWUzYzQ0YmZhZTJiZTg2MDRjYjU2MGQ5MDdiM2E3M2ViZjE4OTY4OWM0YTQ1ZDY0YTdmNmExYWY1Yzc";
    public static $postmantoken="6f7211a7-99df-f951-788c-3274e311bb7b";
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