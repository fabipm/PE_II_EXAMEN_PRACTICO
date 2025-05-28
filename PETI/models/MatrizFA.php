<?php
require_once 'config/db.php';

class MatrizFA {
    private $id_matriz_fa;
    private $valor;
    private $codigo;
    private $id_fortaleza;
    private $id_amenaza;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdMatrizFa() {
        return $this->id_matriz_fa;
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

    public function getIdAmenaza() {
        return $this->id_amenaza;
    }

    // Setters
    public function setIdMatrizFa($id) {
        $this->id_matriz_fa = intval($id);
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

    public function setIdAmenaza($id_amenaza) {
        $this->id_amenaza = intval($id_amenaza);
        return $this;
    }

    // Métodos CRUD
    public function guardar() {
        if (empty($this->id_fortaleza) || empty($this->id_amenaza)) {
            return false;
        }

        if (empty($this->codigo) && isset($_SESSION['plan_codigo'])) {
            $this->codigo = $_SESSION['plan_codigo'];
        }

        $sql = "INSERT INTO matriz_fa VALUES(
            NULL, 
            '{$this->getCodigo()}', 
            {$this->getValor()}, 
            {$this->getIdFortaleza()}, 
            {$this->getIdAmenaza()}
        )";
        
        $guardado = $this->db->query($sql);
        
        if ($guardado) {
            $this->id_matriz_fa = $this->db->insert_id;
            return true;
        }
        return false;
    }

    public function obtenerPorCodigo($codigo) {
        $sql = "SELECT * FROM matriz_fa 
                WHERE codigo = '{$this->db->real_escape_string($codigo)}'";
        return $this->db->query($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM matriz_fa 
                WHERE id_matriz_fa = {$this->getIdMatrizFa()}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE matriz_fa SET 
                valor = {$this->getValor()}
                WHERE id_matriz_fa = {$this->getIdMatrizFa()}";
        return $this->db->query($sql);
    }

    public function obtenerPorId($id_matriz_fa) {
        $sql = "SELECT * FROM matriz_fa 
                WHERE id_matriz_fa = $id_matriz_fa 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_object() : false;
    }

    public function existeRelacion($id_fortaleza, $id_amenaza) {
        $sql = "SELECT id_matriz_fa FROM matriz_fa 
                WHERE id_fortaleza = $id_fortaleza 
                AND id_amenaza = $id_amenaza 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado && $resultado->num_rows > 0;
    }
}
?>