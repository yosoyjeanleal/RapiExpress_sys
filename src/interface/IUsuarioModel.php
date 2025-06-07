<?php
namespace RapiExpress\Interface;

interface IUsuarioModel
{
    public function registrar();
    public function actualizar(array $data);
    public function eliminar($id);
    public static function obtenerTodos();
    public static function obtenerPorId($id);
    public static function autenticar($username, $password);
}
