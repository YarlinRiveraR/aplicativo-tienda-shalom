<?php
class MetodosPagoModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getMetodosPago($estado)
    {
        $sql = "SELECT * FROM metodo_pago WHERE estado = $estado";
        return $this->selectAll($sql);
    }

    public function registrar($nombre, $imagen, $numero_cuenta)
    {
        $sql = "INSERT INTO metodo_pago (nombre, imagen, numero_cuenta) VALUES (?,?,?)";
        $array = array($nombre, $imagen, $numero_cuenta);
        return $this->insertar($sql, $array);
    }

    public function eliminar($idMetPago)
    {
        $sql = "UPDATE metodo_pago SET estado = ? WHERE id = ?";
        $array = array(0, $idMetPago);
        return $this->save($sql, $array);
    }

    public function getMetodoPago($idMetPago)
    {
        $sql = "SELECT * FROM metodo_pago WHERE id = $idMetPago";
        return $this->select($sql);
    }

    public function modificar($nombre, $destino, $numero_cuenta, $id)
    {
        $sql = "UPDATE metodo_pago SET nombre=?, imagen=?, numero_cuenta=? WHERE id = ?";
        $array = array($nombre, $destino, $numero_cuenta, $id);
        return $this->save($sql, $array);
    }
}
 
?>