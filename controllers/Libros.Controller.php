<?php

//TODO: controlador de libros

require_once('../models/Libros.Modelo.php');
//error_reporting(0);
$libros = new Libros;

switch ($_GET["op"]) {
    //TODO: operaciones de libros

    case 'todos': //TODO: Procedimiento para cargar todos los datos de los libros
        $datos = array();
        $datos = $libros->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno': //TODO: procedimiento para obtener un registro de la base de datos
        $libro_id = $_POST["libro_id"];
        $datos = array();
        $datos = $libros->uno($libro_id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar': //TODO: Procedimiento para insertar un libro en la base de datos
        $titulo = $_POST["titulo"];
        $autor = $_POST["autor"];
        $genero = $_POST["genero"];
        $anio_publicacion = $_POST["anio_publicacion"];

        $datos = array();
        $datos = $libros->insertar($titulo, $autor, $genero, $anio_publicacion);
        echo json_encode($datos);
        break;

    case 'actualizar': //TODO: Procedimiento para actualizar un libro en la base de datos
        $libro_id = $_POST["libro_id"];
        $titulo = $_POST["titulo"];
        $autor = $_POST["autor"];
        $genero = $_POST["genero"];
        $anio_publicacion = $_POST["anio_publicacion"];
        $datos = array();
        $datos = $libros->actualizar($libro_id, $titulo, $autor, $genero, $anio_publicacion);
        echo json_encode($datos);
        break;

    case 'eliminar': //TODO: Procedimiento para eliminar un libro en la base de datos
        $libro_id = $_POST["libro_id"];
        $datos = array();
        $datos = $libros->eliminar($libro_id);
        echo json_encode($datos);
        break;
}