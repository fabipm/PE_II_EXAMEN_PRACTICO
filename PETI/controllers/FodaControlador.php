<?php
require_once 'models/Amenaza.php';
require_once 'models/Debilidad.php';
require_once 'models/Fortaleza.php';
require_once 'models/Oportunidad.php';

class FodaControlador {

    public function index() {
        if (!isset($_SESSION['identity'])) {
            $_SESSION['error_foda'] = 'Debes iniciar sesión para acceder a esta sección';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        if (!isset($_SESSION['plan_codigo'])) {
            $_SESSION['error_foda'] = 'Debes seleccionar un plan estratégico primero';
            header("Location:" . base_url . "planEstrategico/seleccionar");
            exit();
        }

        try {
            $id_usuario = $_SESSION['identity']->id;
            $codigo_plan = $_SESSION['plan_codigo'];

            // Fortalezas
            $fortalezaModel = new Fortaleza();
            $fortalezas = [];
            $result = $fortalezaModel->obtenerPorCodigo($codigo_plan);
            while ($row = $result->fetch_object()) {
                if ($row->id_usuario == $id_usuario) {
                    $fortalezas[] = $row;
                }
            }

            // Debilidades
            $debilidadModel = new Debilidad();
            $debilidades = [];
            $result = $debilidadModel->obtenerPorCodigo($codigo_plan);
            while ($row = $result->fetch_object()) {
                if ($row->id_usuario == $id_usuario) {
                    $debilidades[] = $row;
                }
            }

            // Oportunidades
            $oportunidadModel = new Oportunidad();
            $oportunidades = [];
            $result = $oportunidadModel->obtenerPorCodigo($codigo_plan);
            while ($row = $result->fetch_object()) {
                if ($row->id_usuario == $id_usuario) {
                    $oportunidades[] = $row;
                }
            }

            // Amenazas
            $amenazaModel = new Amenaza();
            $amenazas = [];
            $result = $amenazaModel->obtenerPorCodigo($codigo_plan);
            while ($row = $result->fetch_object()) {
                if ($row->id_usuario == $id_usuario) {
                    $amenazas[] = $row;
                }
            }

            require_once 'views/foda/index.php';

        } catch (Exception $e) {
            $_SESSION['error_foda'] = 'Error al cargar los datos FODA: ' . $e->getMessage();
            header("Location:" . base_url . "foda/index");
            exit();
        }
    }
}
