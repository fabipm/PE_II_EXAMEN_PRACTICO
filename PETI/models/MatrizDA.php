<?php
require_once 'config/db.php';

class MatrizDA {
    private $id_matriz_da;
    private $valor;
    private $codigo;
    private $id_debilidad;
    private $id_amenaza;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdMatrizDa() {
        return $this->id_matriz_da;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getIdDebilidad() {
        return $this->id_debilidad;
    }

    public function getIdAmenaza() {
        return $this->id_amenaza;
    }

    // Setters
    public function setIdMatrizDa($id) {
        $this->id_matriz_da = intval($id);
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

    public function setIdDebilidad($id_debilidad) {
        $this->id_debilidad = intval($id_debilidad);
        return $this;
    }

    public function setIdAmenaza($id_amenaza) {
        $this->id_amenaza = intval($id_amenaza);
        return $this;
    }

    // Métodos CRUD
    public function guardar() {
        if (empty($this->id_debilidad) || empty($this->id_amenaza)) {
            return false;
        }

        if (empty($this->codigo) && isset($_SESSION['plan_codigo'])) {
            $this->codigo = $_SESSION['plan_codigo'];
        }

        $sql = "INSERT INTO matriz_da VALUES(
            NULL, 
            {$this->getValor()}, 
            '{$this->getCodigo()}', 
            {$this->getIdDebilidad()}, 
            {$this->getIdAmenaza()}
        )";
        
        $guardado = $this->db->query($sql);
        
        if ($guardado) {
            $this->id_matriz_da = $this->db->insert_id;
            return true;
        }
        return false;
    }

    public function obtenerPorCodigo($codigo) {
        $sql = "SELECT * FROM matriz_da 
                WHERE codigo = '{$this->db->real_escape_string($codigo)}'";
        return $this->db->query($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM matriz_da 
                WHERE id_matriz_da = {$this->getIdMatrizDa()}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE matriz_da SET 
                valor = {$this->getValor()}
                WHERE id_matriz_da = {$this->getIdMatrizDa()}";
        return $this->db->query($sql);
    }

    public function obtenerPorId($id_matriz_da) {
        $sql = "SELECT * FROM matriz_da 
                WHERE id_matriz_da = $id_matriz_da 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_object() : false;
    }

    public function existeRelacion($id_debilidad, $id_amenaza) {
        $sql = "SELECT id_matriz_da FROM matriz_da 
                WHERE id_debilidad = $id_debilidad 
                AND id_amenaza = $id_amenaza 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado && $resultado->num_rows > 0;
    }
}
?>