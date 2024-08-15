<?php
//TODO: Clase de Prestamos
require_once(__DIR__ . '/../config/Conexion.php');

class Prestamos
{
    private $conexion;

    public function __construct()
    {
        $conectar = new ClaseConectar();
        $this->conexion = $conectar->ProcedimientoParaConectar();
    }

    public function todos()
    {
        $query = "SELECT p.*, l.titulo as libro_titulo, m.nombre as miembro_nombre, m.apellido as miembro_apellido 
                  FROM `prestamos` p
                  JOIN `libros` l ON p.libro_id = l.libro_id
                  JOIN `miembros` m ON p.miembro_id = m.miembro_id";
        $resultado = mysqli_query($this->conexion, $query);
        return $resultado;
    }

    public function uno($prestamo_id)
    {
        $query = "SELECT p.*, l.titulo as libro_titulo, m.nombre as miembro_nombre, m.apellido as miembro_apellido 
                  FROM `prestamos` p
                  JOIN `libros` l ON p.libro_id = l.libro_id
                  JOIN `miembros` m ON p.miembro_id = m.miembro_id
                  WHERE p.`prestamo_id` = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $prestamo_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return $resultado;
    }

    public function insertar($libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion)
    {
        $query = "INSERT INTO `prestamos` (`libro_id`, `miembro_id`, `fecha_prestamo`, `fecha_devolucion`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "iiss", $libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion);
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conexion);
        } else {
            return false;
        }
    }

    public function actualizar($prestamo_id, $libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion)
    {
        $query = "UPDATE `prestamos` SET `libro_id` = ?, `miembro_id` = ?, `fecha_prestamo` = ?, `fecha_devolucion` = ? WHERE `prestamo_id` = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "iissi", $libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion, $prestamo_id);
        return mysqli_stmt_execute($stmt);
    }

    public function eliminar($prestamo_id)
    {
        $query = "DELETE FROM `prestamos` WHERE `prestamo_id` = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $prestamo_id);
        return mysqli_stmt_execute($stmt);
    }
}
?>