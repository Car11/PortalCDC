<?php
class Globals {
    const app = 'PORTAL';
    const version= '1.0';
    const cssversion= "1.0";
    public static $jsonrpcURL= "http://10.129.20.177/kanboard/jsonrpc.php";
    public static $token="anNvbnJwYzo2ZmZhNWVmMzczM2U5YzBiOGJhMDA2ZmI5ODkzMzFhOTRiOWU4NzRkYTk5OWYwZjhkNzJmMTljMzNkZjg";
    public static $postmantoken="1ec2b092-199a-ee41-b698-37096a6c36f7";
    private static $config="";
    //

    
    public static function ConfiguracionIni(){     
        if (file_exists('../../ini/config.ini')) {
            self::$config = parse_ini_file('../../ini/config.ini',true); 
        } 
        else if (file_exists('../ini/config.ini')) {
            self::$config = parse_ini_file('../ini/config.ini',true); 
        }
        else if (file_exists('../../../ini/config.ini')) {
            self::$config = parse_ini_file('../../../ini/config.ini',true); 
        }   
        self::$jsonrpcURL= self::$config[self::app]['jsonrpcURL'];
        self::$token= self::$config[self::app]['token'];
        self::$postmantoken= self::$config[self::app]['postmantoken'];
    }  
}
?>