<?php

require_once "BaseE.php";

class Alumno{

    private $conexion;

    private $idAlumno;
    private $nombre;
    private $numeroControl;
    private $semestre;
    private $carrera;

    public function __construct(){

        $base = new Base();
        $this->conexion = $base->getConnection();

    }

    public function setIdAlumno($idAlumno){
        $this->idAlumno = $idAlumno;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setNumeroControl($numeroControl){
        $this->numeroControl = $numeroControl;
    }

    public function setSemestre($semestre){
        $this->semestre = $semestre;
    }

    public function setCarrera($carrera){
        $this->carrera = $carrera;
    }

    public function registrar(){

    try{

        // Verificar que no exista el número de control
        if($this->existeNumeroControl($this->numeroControl)){
            return "duplicado";
        }

        $sql = "INSERT INTO Alumno
                (NombreA, NumeroControl, Semestre, Carrera)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        if($stmt->execute([
            $this->nombre,
            $this->numeroControl,
            $this->semestre,
            $this->carrera
        ])){
            return true;
        }

        return false;

    }catch(PDOException $e){

        die("Error SQL: ".$e->getMessage());

    }

}

public function existeNumeroControlEditar($numeroControl,$id){

    $sql="SELECT COUNT(*) AS total
          FROM Alumno
          WHERE NumeroControl=?
          AND IdAlumno<>?";

    $stmt=$this->conexion->prepare($sql);

    $stmt->execute([$numeroControl,$id]);

    $resultado=$stmt->fetch(PDO::FETCH_ASSOC);

    return ($resultado["total"]>0);

}
    public function listar(){

        $sql = "SELECT * FROM Alumno
                ORDER BY IdAlumno DESC";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function obtener($id){

        $sql = "SELECT *
                FROM Alumno
                WHERE IdAlumno = ?";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

   public function actualizar($id){

    try{

        if($this->existeNumeroControlEditar($this->numeroControl,$id)){
            return "duplicado";
        }

        $sql="UPDATE Alumno
              SET NombreA=?,
                  NumeroControl=?,
                  Semestre=?,
                  Carrera=?
              WHERE IdAlumno=?";

        $stmt=$this->conexion->prepare($sql);

        return $stmt->execute([
            $this->nombre,
            $this->numeroControl,
            $this->semestre,
            $this->carrera,
            $id
        ]);

    }catch(PDOException $e){

        die("Error SQL: ".$e->getMessage());

    }

}

    public function eliminar($id){

        try{

            $sql = "DELETE FROM Alumno
                    WHERE IdAlumno = ?";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([$id]);

        }catch(PDOException $e){

            die("Error SQL: ".$e->getMessage());

        }

    }

    public function existeNumeroControl($numeroControl){

        $sql = "SELECT COUNT(*) AS total
                FROM Alumno
                WHERE NumeroControl = ?";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([$numeroControl]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($resultado["total"] > 0);

    }

}

?>