

<?php

class Visitante{
    public $cedula;//id
    public $nombre;
    public $empresa;
    public $permisoanual;
    public $visitante;
    public $visitanteexcluido;

    function __construct(){
        require_once("conexion.php");
    }
    
    //
    // Funciones de Mantenimiento.
    //
    function Agregar(){
        try {
            $sql='INSERT INTO visitante (nombre, cedula, empresa) VALUES (:nombre, :cedula, :empresa)';
            $param= array(':nombre'=>$this->nombre,':cedula'=>$this->cedula,':empresa'=>$this->empresa);
            $data = DATA::Ejecutar($sql,$param,true);
            if($data)
                return true;
            else return false;
        }     
        catch(Exception $e) {
            header('Location: ../Error.php?w=conectar&id='.$e->getMessage());
            exit;
        }
    }

    function Modificar(){
        try {
            $sql="UPDATE visitante 
                SET nombre= :nombre, cedula= :cedula, empresa= :empresa
                WHERE cedula=:cedula";
            $param= array(':nombre'=>$this->nombre,':cedula'=>$this->cedula,':empresa'=>$this->empresa);
            $data = DATA::Ejecutar($sql,$param,true);
            if($data)
                return true;
            else return false;
        }     
        catch(Exception $e) {
            header('Location: ../Error.php?w=conectar&id='.$e->getMessage());
            exit;
        }
    }
    
      // carga 1 registro específico.
    function Cargar($ID){
        try {
            $sql="SELECT CEDULA, NOMBRE, EMPRESA, PERMISOANUAL 
                FROM visitante 
                where cedula=:cedula";
            $param= array(':cedula'=>$ID);
            $data= DATA::Ejecutar($sql,$param);
            //
            $this->cedula= $data[0]['CEDULA'];
            $this->nombre= $data[0]['NOMBRE'];
            $this->empresa= $data[0]['EMPRESA'];
            $this->permisoanual= $data[0]['PERMISOANUAL'];
            //            
            return $data;
        }
        catch(Exception $e) {
            //header('Location: ../Error.php?w=conectar&id='.$e->getMessage());
            echo "Error al leer la información";
            exit;
        }
    }
    
    function CargarTodos(){
        try {
            $sql='SELECT cedula, nombre, empresa, permisoanual FROM visitante ORDER BY cedula';
            $data= DATA::Ejecutar($sql);
            return $data;
        }
        catch(Exception $e) {            
            header('Location: ../Error.php?w=conectar&id='.$e->getMessage());
            exit;
        }
    }
    
}
?>
