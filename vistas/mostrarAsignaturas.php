<?php


function crearTabla($resultado){
    while ($fila = $resultado->fetch_array()) {
        echo '<tr>';
        echo '<td>'.$fila['idAsignaturas'].'</td>';
        echo '<td>'.$fila['asignatura'].'</td>';
        echo '<td>'.$fila['n_horas'].'</td>';
        echo '<td>'.$fila['curso'].'</td>';
        echo '<td>'.$fila['profesor'].'</td>';
        echo '<td><a href="control.php?idAsignaturas='.$fila['idAsignaturas'].'&idCurso='.$fila['idCurso'].'&idProfesor='.$fila['idProfesor'].'&accion=m">M</a></td>';
        echo '<td><a href="borrarAsignatura.php?idAsignaturas='.$fila['idAsignaturas'].'">E</a></td>';
        echo '</tr>';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= vistas.'css/estilos.css' ?>">
    <title>Asignaturas</title>
</head>
<body>
    <nav>
        <a id="home" href="index.php?"><img src="<?php echo vistas; ?>imagenes/casa-blanca.png" alt=""></a>
        <a href="">Asignaturas</a>
        <a href="">Cursos</a>
        <a href="">Profesores</a>
        <a id="uso" href="">Horarios</a>
    </nav>
    <main>
        <h1>Listado de asignaturas</h1>
        <a href="formulario.php">Añadir asignatura (+)</a>
        <table border="1">
            <tr>
                <th>Código</th>
                <th>Asignatura</th>
                <th>Horas</th>
                <th>Curso</th>
                <th>Profesor</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
            <?php crearTabla($datos); ?>
        </table>
    </main>
    
</body>
</html>