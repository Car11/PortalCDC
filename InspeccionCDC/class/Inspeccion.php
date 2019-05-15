<?php
date_default_timezone_set('America/Costa_Rica');
if(isset($_POST["action"])){
    $opt= $_POST["action"];
    unset($_POST['action']);
    // Classes
    require_once("Conexion.php");
    require_once("Usuario.php");
    // Session
    // if (!isset($_SESSION))
    //     session_start();
    // Instance
    $inspeccion= new Inspeccion();
    switch($opt){
        case "ReadAll":
            echo json_encode($inspeccion->ReadAll());
            break;
        case "ReadEntregaTurno":
            echo json_encode($inspeccion->ReadEntregaTurno());
            break;
        case "Create":
            $inspeccion->Create();
            break;
        case "ReadAllbyRange":
            echo json_encode($inspeccion->ReadAllbyRange());
            break;
        }
}

class Inspeccion{
    public $tblInspeccion=null;
    public $fechaInicial='';
    public $fechaFinal='';

    function __construct(){
        // identificador único
        if(isset($_POST["id"]))
            $this->id= $_POST["id"];
        
         if(isset($_POST["obj"])){
             $obj= json_decode($_POST["obj"],true);
             $this->tblInspeccion= $obj["arrayInspeccion"] ?? null;
             $this->fechaInicial= $obj["fechaInicial"] ?? '';
             $this->fechaFinal= $obj["fechaFinal"] ?? '';
         }
     }

    function ReadAll(){
        try {
            $sql="SELECT * FROM entregaTurno";
            $duplicate= DATA::Ejecutar($sql);
            if (!$duplicate) {
                $sql='SELECT id, idSector, (SELECT nombre FROM sector WHERE id=idSector) AS sector, nombre AS componente, 1 AS estado FROM componente';                
                $data= DATA::Ejecutar($sql);
            }
            else{
                $sql='SELECT c.id, et.fecha, (SELECT nombre FROM usuario WHERE id=et.idUsuarioRealiza) as userReport, 
                c.idSector, (SELECT nombre FROM sector WHERE id=c.idSector) AS sector, 
                c.nombre AS componente, et.detalle, et.estado FROM entregaTurno et 
                INNER JOIN componente c ON et.idComponente = c.id;';
                $data= DATA::Ejecutar($sql);
            }
            return $data;
        }     
        catch(Exception $e) { error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar la lista'))
            );
        }
    }

    function ReadEntregaTurno(){
        try {
            $sql='SELECT c.id, et.fecha, (SELECT nombre FROM usuario WHERE id=et.idUsuarioRealiza) as userReport, 
            c.idSector, (SELECT nombre FROM sector WHERE id=c.idSector) AS sector, 
            c.nombre AS componente, et.detalle, et.estado FROM entregaTurno et 
            INNER JOIN componente c ON et.idComponente = c.id WHERE et.estado = 0;';
            $data= DATA::Ejecutar($sql);
            return $data;
        }     
        catch(Exception $e) { error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar la lista'))
            );
        }
    }

    function ReadAllbyRange(){
        try {
            $sql='SELECT i.id,i.idComponente, c.nombre AS componente,
            i.idUsuarioRealiza,(SELECT nombre FROM usuario WHERE id=i.idUsuarioRealiza) as userReport,
            i.idUsuarioRecibe,(SELECT nombre FROM usuario WHERE id=i.idUsuarioRecibe) as userRecibe,
            i.fecha,i.estado,i.detalle, c.idSector, (SELECT nombre FROM sector WHERE id= c.idSector) AS sector 
            FROM inspeccion i INNER JOIN componente c ON c.id=i.idComponente 
            WHERE i.fecha Between :fechaInicial and :fechaFinal;';
            
            $param= array(':fechaInicial'=>$this->fechaInicial, ':fechaFinal'=>$this->fechaFinal);

            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) { error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar la lista'))
            );
        }
    }

    function Create(){
        try {
            foreach ($this->tblInspeccion as $componente) {
                
                $sql="INSERT INTO `monitoreoDC`.`inspeccion`
                (`id`,`idComponente`,`idUsuarioRealiza`,`idUsuarioRecibe`,`fecha`,`estado`,`detalle`)VALUES
                (uuid(),:idComponente,:idUsuarioRealiza,:idUsuarioRecibe,:fecha,:estado,:detalle);";
                //
                $param= array(':idComponente'=>$componente['idComponente'],
                ':idUsuarioRealiza'=>"51ef93cf-75a9-11e9-8165-005056b94b23",
                ':idUsuarioRecibe'=>"6662a008-75a9-11e9-8165-005056b94b23",
                ':fecha'=>date("Y-m-d H:i:s"),
                ':estado'=>$componente['estado'],
                ':detalle'=>$componente['detalle']);
    
                $data = DATA::Ejecutar($sql,$param, false);      

                $sql="SELECT id FROM `monitoreoDC`.`entregaTurno` WHERE idComponente="."'".$componente["idComponente"]."';";
                $duplicate = DATA::Ejecutar($sql);
                
                if ($duplicate) {
                    $sql="UPDATE `monitoreoDC`.`entregaTurno`
                    SET
                    `idUsuarioRealiza` = :idUsuarioRealiza,
                    `idUsuarioRecibe` = :idUsuarioRecibe,
                    `fecha` = :fecha,
                    `estado` = :estado,
                    `detalle` = :detalle
                    WHERE `idComponente` = :idComponente;";

                    $param= array(':idComponente'=>$componente['idComponente'],
                    ':idUsuarioRealiza'=>"51ef93cf-75a9-11e9-8165-005056b94b23",
                    ':idUsuarioRecibe'=>"6662a008-75a9-11e9-8165-005056b94b23",
                    ':fecha'=>date("Y-m-d H:i:s"),
                    ':estado'=>$componente['estado'],
                    ':detalle'=>$componente['detalle']);
        
                    $data = DATA::Ejecutar($sql,$param, false);  
                }
                else{
                    $sql="INSERT INTO `monitoreoDC`.`entregaTurno`
                    (`id`,`idComponente`,`idUsuarioRealiza`,`idUsuarioRecibe`,`fecha`,`estado`,`detalle`)VALUES
                    (uuid(),:idComponente,:idUsuarioRealiza,:idUsuarioRecibe,:fecha,:estado,:detalle);";
                    //
                    $param= array(':idComponente'=>$componente['idComponente'],
                    ':idUsuarioRealiza'=>"51ef93cf-75a9-11e9-8165-005056b94b23",
                    ':idUsuarioRecibe'=>"6662a008-75a9-11e9-8165-005056b94b23",
                    ':fecha'=>date("Y-m-d H:i:s"),
                    ':estado'=>$componente['estado'],
                    ':detalle'=>$componente['detalle']);
        
                    $data = DATA::Ejecutar($sql,$param, false); 
                }
            }
            if($data)
            {
                //get id.
                //save array obj
                return true;
            }
            else throw new Exception('Error al guardar.', 02);
        }     
        catch(Exception $e) { error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => $e->getMessage()))
            );
        }
    }
}

?>