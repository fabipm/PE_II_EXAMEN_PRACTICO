<?php
require_once 'config/db.php';

class MatrizFO {
    private $id_matriz_fo;
    private $valor;
    private $codigo;
    private $id_fortaleza;
    private $id_oportunidad;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdMatrizFo() {
        return $this->id_matriz_fo;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getIdFortaleza() {
        return $this->id_fortaleza;
    }

    public function getIdOportunidad() {
        return $this->id_oportunidad;
    }

    // Setters
    public function setIdMatrizFo($id) {
        $this->id_matriz_fo = intval($id);
        return $this;
    }

    public function setValor($valor) {
        $this->valor = intval($valor) >= 0 && intval($valor) <= 4 ? intval($valor) : 0;
        return $this;
    }

    public function setCodigo($codigo) {
        $this->codigo = $this->db->real_escape_string(trim($codigo));
        return $this;
    }

    public function setIdFortaleza($id_fortaleza) {
        $this->id_fortaleza = intval($id_fortaleza);
        return $this;
    }

    public function setIdOportunidad($id_oportunidad) {
        $this->id_oportunidad = intval($id_oportunidad);
        return $this;
    }

    // Métodos CRUD
    public function guardar() {
        if (empty($this->id_fortaleza) || empty($this->id_oportunidad)) {
            return false;
        }

        if (empty($this->codigo) && isset($_SESSION['plan_codigo'])) {
            $this->codigo = $_SESSION['plan_codigo'];
        }

        $sql = "INSERT INTO matriz_fo VALUES(
            NULL, 
            '{$this->getCodigo()}', 
            {$this->getValor()}, 
            {$this->getIdFortaleza()}, 
            {$this->getIdOportunidad()}
        )";
        
        $guardado = $this->db->query($sql);
        
        if ($guardado) {
            $this->id_matriz_fo = $this->db->insert_id;
            return true;
        }
        return false;
    }

    public function obtenerPorCodigo($codigo) {
        $sql = "SELECT * FROM matriz_fo 
                WHERE codigo = '{$this->db->real_escape_string($codigo)}'";
        return $this->db->query($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM matriz_fo 
                WHERE id_matriz_fo = {$this->getIdMatrizFo()}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE matriz_fo SET 
                valor = {$this->getValor()}
                WHERE id_matriz_fo = {$this->getIdMatrizFo()}";
        return $this->db->query($sql);
    }

    public function obtenerPorId($id_matriz_fo) {
        $sql = "SELECT * FROM matriz_fo 
                WHERE id_matriz_fo = $id_matriz_fo 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_object() : false;
    }

    public function existeRelacion($id_fortaleza, $id_oportunidad) {
        $sql = "SELECT id_matriz_fo FROM matriz_fo 
                WHERE id_fortaleza = $id_fortaleza 
                AND id_oportunidad = $id_oportunidad 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado && $resultado->num_rows > 0;
    }
}
?>