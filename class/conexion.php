<?php 

class DATA {
    
	public static $conn;
    private static $config="";
    private static $configLDAP=[];

	private static function ConfiguracionIni(){
        require_once('Globals.php'); 
        // if (file_exists('../../ini/config.ini')) {
        //     self::$config = parse_ini_file('../../ini/config.ini',true);
        
        $dir=  __DIR__.DIRECTORY_SEPARATOR.".." .DIRECTORY_SEPARATOR.".." .DIRECTORY_SEPARATOR.'ini'.DIRECTORY_SEPARATOR."config.ini";
        if (file_exists($dir)) {
            self::$config = parse_ini_file($dir,true);
        }       
        else throw new Exception('Acceso denegado al Archivo de configuracion.',-1);  
    }  

    public static function getLDAP_Param() {
        try {
            self::ConfiguracionIni();            
            self::$configLDAP= array(
                    "LDAP_user"=>self::$config[Globals::app]['LDAP_user'],
                    "LDAP_passwd"=>self::$config[Globals::app]['LDAP_passwd'],
                    "LDAP_server"=>self::$config[Globals::app]['LDAP_server'],
                    "LDAP_port"=>self::$config[Globals::app]['LDAP_port'],
                    "LDAP_base_dn"=>self::$config[Globals::app]['LDAP_base_dn']
                );
            return self::$configLDAP;
        }
        catch(Exception $e){
            throw new Exception($e->getMessage(),$e->getCode());
        }
    }

    private static function Conectar(){
        try {          
            self::ConfiguracionIni();
            if(!isset(self::$conn)) {                                
                self::$conn = new PDO('mysql:host='. self::$config[Globals::app]['host'] .';dbname=' . self::$config[Globals::app]['dbname'].';charset=utf8', self::$config[Globals::app]['username'],   self::$config[Globals::app]['password']); 
                return self::$conn;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(),$e->getCode());
        }
        catch(Exception $e){
            throw new Exception($e->getMessage(),$e->getCode());
        }
    }  

    // Ejecuta consulta SQL, $op = true envía los datos en 'crudo', $op=false envía los datos en arreglo (fetch).
    public static function Ejecutar($sql, $param=NULL, $op=false) {
        try{
            //conecta a BD
            self::Conectar();
            $st=self::$conn->prepare($sql);
            self::$conn->beginTransaction(); 
            if($st->execute($param))
            {
                self::$conn->commit(); 
                if(!$op)
                    return  $st->fetchAll();
                else return $st;    
            } else {
                throw new Exception('Error al ejecutar.',00);
            }            
        } catch (Exception $e) {
            if(isset(self::$conn))
                self::$conn->rollback(); 
            if(isset($st))
                throw new Exception($st->errorInfo()[2],$st->errorInfo()[1]);
            else throw new Exception($e->getMessage(),$e->getCode());
        } finally{
            self::$conn = null;
        }
    }
    
	private static function Close(){
		mysqli_close(self::$conn);			
	}

    public static function getLastID(){
        return self::$conn->lastInsertId();
    }
}
?>
