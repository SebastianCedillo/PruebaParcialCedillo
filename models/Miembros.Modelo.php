<?php
//TODO: Clase de Miembros
require_once(__DIR__ . '/../config/Conexion.php');

class Miembros
{
    private $conexion;

    public function __construct()
    {
        $conectar = new ClaseConectar();
        $this->conexion = $conectar->ProcedimientoParaConectar();
    }

    public function todos()
    {
        $query = "SELECT * FROM `miembros`";
        $resultado = mysqli_query($this->conexion, $query);
        return $resultado;
    }

    public function uno($miembro_id)
    {
        $query = "SELECT * FROM `miembros` WHERE `miembro_id` = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $miembro_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return $resultado;
    }

    public function insertar($nombre, $apellido, $email, $fecha_suscripcion)
    {
        $query = "INSERT INTO `miembros` (`nombre`, `apellido`, `email`, `fecha_suscripcion`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $apellido, $email, $fecha_suscripcion);
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conexion);
        } else {
            return false;
        }
    }

    public function actualizar($miembro_id, $nombre, $apellido, $email, $fecha_suscripcion)
    {
        $query = "UPDATE `miembros` SET `nombre` = ?, `apellido` = ?, `email` = ?, `fecha_suscripcion` = ? WHERE `miembro_id` = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $apellido, $email, $fecha_suscripcion, $miembro_id);
        return mysqli_stmt_execute($stmt);
    }

    public function eliminar($miembro_id)
    {
        $query = "DELETE FROM `miembros` WHERE `miembro_id` = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $miembro_id);
        return mysqli_stmt_execute($stmt);
    }
}
?>