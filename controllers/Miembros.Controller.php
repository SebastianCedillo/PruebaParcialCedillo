<?php
//TODO: controlador de miembros

require_once(__DIR__ . '/../models/Miembros.Modelo.php');
$miembros = new Miembros();

if (isset($_GET["op"])) {
    switch ($_GET["op"]) {
        case 'todos':
            $datos = $miembros->todos();
            $miembros_array = array();
            while ($row = mysqli_fetch_assoc($datos)) {
                $miembros_array[] = $row;
            }
            echo json_encode($miembros_array);
            break;

        case 'uno':
            if (isset($_POST["miembro_id"])) {
                $miembro_id = $_POST["miembro_id"];
                $datos = $miembros->uno($miembro_id);
                $miembro = mysqli_fetch_assoc($datos);
                echo json_encode($miembro);
            } else {
                echo json_encode(array("error" => "miembro_id no proporcionado"));
            }
            break;

        case 'insertar':
            if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["email"]) && isset($_POST["fecha_suscripcion"])) {
                $resultado = $miembros->insertar($_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["fecha_suscripcion"]);
                echo json_encode(array("id_insertado" => $resultado));
            } else {
                echo json_encode(array("error" => "Faltan datos para la inserción"));
            }
            break;

        case 'actualizar':
            if (isset($_POST["miembro_id"]) && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["email"]) && isset($_POST["fecha_suscripcion"])) {
                $resultado = $miembros->actualizar($_POST["miembro_id"], $_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["fecha_suscripcion"]);
                echo json_encode(array("actualizado" => $resultado));
            } else {
                echo json_encode(array("error" => "Faltan datos para la actualización"));
            }
            break;

        case 'eliminar':
            if (isset($_POST["miembro_id"])) {
                $resultado = $miembros->eliminar($_POST["miembro_id"]);
                echo json_encode(array("eliminado" => $resultado));
            } else {
                echo json_encode(array("error" => "miembro_id no proporcionado para eliminación"));
            }
            break;

        default:
            echo json_encode(array("error" => "Operación no válida"));
    }
} else {
    echo json_encode(array("error" => "No se especificó ninguna operación"));
}
?>