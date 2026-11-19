<?php

require 'Conexion.php';

class ModeloAsignatura extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function devolverAsignaturas() {
        $sql = "SELECT A.idAsignaturas, A.nombre AS asignatura, A.n_horas,
                       C.idCurso, C.idCurso AS curso,
                       P.idProfesor, P.nombre AS profesor
                FROM Asignaturas A
                LEFT JOIN PRO_ASIG_CUR PAC ON A.idAsignaturas = PAC.idAsignatura
                LEFT JOIN Cursos C ON PAC.idCurso = C.idCurso
                LEFT JOIN Profesores P ON PAC.idProfesor = P.idProfesor
                ORDER BY C.idCurso, A.idAsignaturas ";
        return $this->conexion->query($sql);
    }

    function cogerAsignaturasCurso() {
        $sql = "SELECT A.idAsignaturas AS siglas
                FROM PRO_ASIG_CUR PAC
                INNER JOIN Asignaturas A ON PAC.idAsignaturas = A.idAsignatura
                ORDER BY A.idAsignaturas ";
        return $this->conexion->query($sql);
    }

    public function devolverCursos() {
        return $this->conexion->query("SELECT idCurso, nombre FROM Cursos ORDER BY nombre");
    }

    public function devolverProfesores() {
        return $this->conexion->query("SELECT idProfesor, nombre FROM Profesores ORDER BY nombre");
    }

    public function anadirAsignatura($idAsignaturas, $nombre, $n_horas, $idCurso, $idProfesor) {
        $this->conexion->begin_transaction();

        try {
            $sql = "INSERT INTO Asignaturas (idAsignaturas, nombre, n_horas) VALUES (".$idAsignaturas.", '".$nombre."', ".$n_horas.")";
            
            if (!$this->conexion->query($sql)) {
                throw new Exception("Error al insertar asignatura: ".$this->conexion->error);
            }

            $sql = "INSERT INTO PRO_ASIG_CUR (idCurso, idProfesor, idAsignatura) VALUES (".$idCurso.", ".$idProfesor.", ".$idAsignaturas.")";
            
            if (!$this->conexion->query($sql)) {
                throw new Exception("Error al vincular asignatura: " . $this->conexion->error);
            }

            $this->conexion->commit();

        } catch (Exception $e) {
            $this->conexion->rollback();
        }
    }

    public function devolverModificar($idAsignaturas, $idCurso, $idProfesor) {
        $sql = "SELECT A.idAsignaturas, A.nombre, A.n_horas,
                       PAC.idCurso, PAC.idProfesor
                FROM Asignaturas A
                INNER JOIN PRO_ASIG_CUR PAC ON A.idAsignaturas = PAC.idAsignatura
                WHERE A.idAsignaturas = ".$idAsignaturas." AND PAC.idCurso = ".$idCurso." AND PAC.idProfesor = ".$idProfesor;
       
        return $this->conexion->query($sql);
    }

    public function modificarAsignatura($idOriginal, $idCursoOriginal, $idProfesorOriginal,$nombre, $n_horas, $idCursoNuevo, $idProfesorNuevo) {
        
            $sql = "UPDATE Asignaturas SET nombre = ".$nombre.", n_horas = ".$n_horas." WHERE idAsignaturas = ".$idOriginal;
            $this->conexion->query($sql);
            $sql = "DELETE FROM PRO_ASIG_CUR
                    WHERE idCurso = ".$idCursoOriginal." AND idProfesor = ".$idProfesorOriginal." AND idAsignatura = ".$idOriginal;
            $this->conexion->query($sql);
            $sql = "INSERT INTO PRO_ASIG_CUR (idCurso, idProfesor, idAsignatura) VALUES (".$idCursoNuevo.", ".$idProfesorNuevo.", ".$idOriginal.")";
            $this->conexion->query($sql);
    }

    public function eliminar($idAsignaturas) {
        
            $sql = "DELETE FROM PRO_ASIG_CUR WHERE idAsignatura = ".$idAsignaturas;
            $this->conexion->query($sql);

            $sql = "DELETE FROM Asignaturas WHERE idAsignaturas = ".$idAsignaturas;
            $this->conexion->query($sql);
    }
}
?>