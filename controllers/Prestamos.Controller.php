<?php
//TODO: controlador de prestamos

require_once(__DIR__ . '/../models/Prestamos.Modelo.php');
$prestamos = new Prestamos();

if (isset($_GET["op"])) {
    switch ($_GET["op"]) {
        case 'todos':
            $datos = $prestamos->todos();
            $prestamos_array = array();
            while ($row = mysqli_fetch_assoc($datos)) {
                $prestamos_array[] = $row;
            }
            echo json_encode($prestamos_array);
            break;

        case 'uno':
            if (isset($_POST["prestamo_id"])) {
                $prestamo_id = $_POST["prestamo_id"];
                $datos = $prestamos->uno($prestamo_id);
                $prestamo = mysqli_fetch_assoc($datos);
                echo json_encode($prestamo);
            } else {
                echo json_encode(array("error" => "prestamo_id no proporcionado"));
            }
            break;

        case 'insertar':
            if (isset($_POST["libro_id"]) && isset($_POST["miembro_id"]) && isset($_POST["fecha_prestamo"]) && isset($_POST["fecha_devolucion"])) {
                $resultado = $prestamos->insertar($_POST["libro_id"], $_POST["miembro_id"], $_POST["fecha_prestamo"], $_POST["fecha_devolucion"]);
                echo json_encode(array("id_insertado" => $resultado));
            } else {
                echo json_encode(array("error" => "Faltan datos para la inserción"));
            }
            break;

        case 'actualizar':
            if (isset($_POST["prestamo_id"]) && isset($_POST["libro_id"]) && isset($_POST["miembro_id"]) && isset($_POST["fecha_prestamo"]) && isset($_POST["fecha_devolucion"])) {
                $resultado = $prestamos->actualizar($_POST["prestamo_id"], $_POST["libro_id"], $_POST["miembro_id"], $_POST["fecha_prestamo"], $_POST["fecha_devolucion"]);
                echo json_encode(array("actualizado" => $resultado));
            } else {
                echo json_encode(array("error" => "Faltan datos para la actualización"));
            }
            break;

        case 'eliminar':
            if (isset($_POST["prestamo_id"])) {
                $resultado = $prestamos->eliminar($_POST["prestamo_id"]);
                echo json_encode(array("eliminado" => $resultado));
            } else {
                echo json_encode(array("error" => "prestamo_id no proporcionado para eliminación"));
            }
            break;

        default:
            echo json_encode(array("error" => "Operación no válida"));
    }
} else {
    echo json_encode(array("error" => "No se especificó ninguna operación"));
}
?>