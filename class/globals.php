<?php
class Globals {
    const app = 'PORTAL';
    const version= '1.0';
    const cssversion= "1.0";
    const configFile= "../../../ini/config.ini";
    // KB
    public static $jsonrpcURL= "";
    public static $token= "";
    public static $postmantoken= "";
    private static $config="";
    // WAS LDAP
    public static $adServer="";
    public static $ldapport="";
    public static $userconn="";
    public static $pwconn="";
    
    public static function ConfiguracionIni(){     
        try{
            if (file_exists(self::configFile)) {
                self::$config = parse_ini_file(self::configFile,true); 
            }
            else throw new Exception('[ERROR] Acceso denegado al Archivo de configuración.',ERROR_CONFI_FILE_NOT_FOUND);
            //
            self::$jsonrpcURL= self::$config[self::app]['jsonrpcURL'];
            self::$token= self::$config[self::app]['token'];
            self::$postmantoken= self::$config[self::app]['postmantoken'];
        }
        catch(Exception $e) {
            error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar el archivo de configuración'))
            );
        }
    }  

    public static function ConfiguracionLdap(){
        try{
            if (file_exists(self::configFile)) {
                self::$config = parse_ini_file(self::configFile,true); 
            }
            else throw new Exception('[ERROR] Acceso denegado al Archivo de configuración.',ERROR_CONFI_FILE_NOT_FOUND);
            //
            self::$adServer= self::$config['WAS']['adserver'];
            self::$ldapport= self::$config['WAS']['port'];
            self::$userconn= self::$config['WAS']['userconn'];
            self::$pwconn= self::$config['WAS']['pwconn'];
        }
        catch(Exception $e) {
            error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar el archivo de configuración'))
            );
        }

    }  
}
?>