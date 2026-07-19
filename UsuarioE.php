<?php

class Usuario{

    private $conn;
    private $table_name = "administrador";

    private $Id;
    private $Usuario;
    private $Password;

    public function __construct($db){
        $this->conn = $db;
    }

    // GETTERS
    public function getId(){
        return $this->Id;
    }

    public function getUsuario(){
        return $this->Usuario;
    }

    // SETTERS
    public function setUsuario($Usuario){
        $this->Usuario = trim($Usuario);
    }

    public function setPassword($Password){
        $this->Password = trim($Password);
    }

    // LOGIN
    public function login(){

        try{

            $sql = "SELECT * FROM ".$this->table_name."
                    WHERE Usuario = :usuario
                    LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":usuario", $this->Usuario);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                $fila = $stmt->fetch(PDO::FETCH_ASSOC);

                // Si la contraseña está en texto plano
                if($this->Password == $fila["Password"]){

                    $this->Id = $fila["Id"];
                    $this->Usuario = $fila["Usuario"];

                    return true;
                }
            }

            return false;

        }catch(PDOException $e){

            die("Error: ".$e->getMessage());

        }

    }

}

?>