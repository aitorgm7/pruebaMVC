<?php
require_once __DIR__ . '/../modelos/ModeloAsignatura.php';

class ControladorAsignatura {
    private $modelo;
    public $vista;

    public function __construct() {
        $this->modelo = new ModeloAsignatura();
    }

    public function anadirAsignatura($post) {
        return $this->modelo->anadirAsignatura($post['idAsignaturas'],$post['nombre'],$post['n_horas'],$post['idCurso'],$post['idProfesor']);
    }

    public function modificar($post) {
        return $this->modelo->modificarAsignatura($post['idOriginal'],$post['idCursoOriginal'],$post['idProfesorOriginal'],$post['nombre'],$post['n_horas'],$post['idCurso'],$post['idProfesor']);
    }

    public function darDatosModificar() {
        $resultado = $this->modelo->devolverModificar(
            $_GET['idAsignaturas'],
            $_GET['idCurso'],
            (int)$_GET['idProfesor']
        );

        if ($fila = $resultado->fetch_assoc()) {
            echo '<input type="hidden" name="idOriginal" value="'.$fila['idAsignaturas'].'">';
            echo '<input type="hidden" name="idCursoOriginal" value="'.$fila['idCurso'].'">';
            echo '<input type="hidden" name="idProfesorOriginal" value="'.$fila['idProfesor'].'">';

            echo '<label>Código de la asignatura</label>';
            echo '<input type="text" value="'.$fila['idAsignaturas'].'" disabled><br>';

            echo '<label>Nombre de la asignatura</label>';
            echo '<input type="text" name="nombre" value="'.$fila['nombre'].'" required><br>';

            echo '<label>Número de horas</label>';
            echo '<input type="number" name="n_horas" min="1" value="'.$fila['n_horas'].'" required><br>';

            echo '<label>Curso</label><select name="idCurso" required>';
            $cursos = $this->modelo->devolverCursos();
            while ($curso = $cursos->fetch_assoc()) {
                $selected = ($curso['idCurso'] === $fila['idCurso']) ? ' selected' : '';
                echo '<option value="'.$curso['idCurso'].'"'.$selected.'>'.$curso['nombre'].'</option>';
            }
            echo '</select><br>';

            echo '<label>Profesor</label><select name="idProfesor" required>';
            $profesores = $this->modelo->devolverProfesores();
            while ($profesor = $profesores->fetch_assoc()) {
                $selected = ((int)$profesor['idProfesor'] === (int)$fila['idProfesor']) ? ' selected' : '';
                echo '<option value="'.(int)$profesor['idProfesor'].'"'.$selected.'>'.$profesor['nombre'].'</option>';
            }
            echo '</select><br>';
            echo '<input type="submit" value="Guardar cambios">';
        } else {
            echo 'No se ha encontrado la asignatura o su relación con el curso y profesor.';
        }
    }

    public function mostrarTabla() {
        $this->vista="mostrarAsignaturas.php";
        return $this->modelo->devolverAsignaturas();
    }

    public function mostrarCursos() {
        return $this->modelo->devolverCursos();
    }

    public function mostrarProfesores() {
        return $this->modelo->devolverProfesores();
    }

    public function eliminar() {
        return $this->modelo->eliminar($_GET['idAsignaturas']);
    }
}
?>