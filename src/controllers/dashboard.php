<?php
// src/controllers/dashboard.php

use RapiExpress\models\Usuario;
use RapiExpress\models\Cliente;
use RapiExpress\models\Tienda;
use RapiExpress\models\Courier;

function dashboard_index() {
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: /index.php?c=auth&a=login');
        exit();
    }

    try {
        // Obtener usuarios
        $usuarios = Usuario::obtenerTodos();
        $totalUsuarios = count($usuarios);

        // Obtener clientes
        $clienteModel = new Cliente();
        $clientes = $clienteModel->obtenerTodos();
        $totalClientes = count($clientes);

        // Obtener tiendas
        $tiendaModel = new Tienda();
        $tiendas = $tiendaModel->obtenerTodas();
        $totalTiendas = count($tiendas);

        // Obtener couriers
        $courierModel = new Courier();
        $couriers = $courierModel->obtenerTodos();
        $totalCouriers = count($couriers);

        // Incluir la vista
        include __DIR__ . '/../views/dashboard.php';

    } catch (\Throwable $e) {
        error_log("Error en Dashboard: " . $e->getMessage());
        header('Location: /index.php?c=auth&a=login');
        exit();
    }
}
