<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\IUsuarioModel;


abstract class Persona {
    protected $nombre;
    protected $apellido;

    abstract public function getNombreCompleto();
}

class Usuario extends Persona implements IUsuarioModel {
    private $id;
    private $documento;
    private $username;
    private $nombres;
    private $apellidos;
    private $telefono;
    private $email;
    private $sucursal;
    private $cargo;
    private $password;
    private $fecha_registro;

    public function __construct($data = []) {
        $this->id        = $data['id'] ?? '';
        $this->documento = $data['documento'] ?? '';
        $this->username  = $data['username'] ?? '';
        $this->nombres   = $data['nombres'] ?? '';
        $this->apellidos = $data['apellidos'] ?? '';
        $this->telefono  = $data['telefono'] ?? '';
        $this->email     = $data['email'] ?? '';
        $this->sucursal  = $data['sucursal'] ?? '';
        $this->cargo     = $data['cargo'] ?? '';
        $this->password  = $data['password'] ?? '';
    }

    public function registrar() {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE documento = ? OR email = ? OR username = ?");
        $stmt->execute([$this->documento, $this->email, $this->username]);
        $existe = $stmt->fetch();

        if ($existe) {
            if ($existe['documento'] === $this->documento) return 'documento_existente';
            if ($existe['email'] === $this->email) return 'email_existente';
            if ($existe['username'] === $this->username) return 'username_existente';
            return 'error_bd';
        }

        $stmt = $pdo->prepare("INSERT INTO usuarios (documento, username, nombres, apellidos, email, telefono, sucursal, cargo, password)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $resultado = $stmt->execute([
            $this->documento,
            $this->username,
            $this->nombres,
            $this->apellidos,
            $this->email,
            $this->telefono,
            $this->sucursal,
            $this->cargo,
            $this->password
        ]);

        return $resultado ? 'registro_exitoso' : 'error_bd';
    }

    public function actualizar(array $data) {
        $pdo = Conexion::getConexion();

        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET 
                documento = ?, username = ?, nombres = ?, apellidos = ?, 
                telefono = ?, email = ?, sucursal = ?, cargo = ? 
                WHERE id = ?");

            return $stmt->execute([
                $data['documento'],
                $data['username'],
                $data['nombres'],
                $data['apellidos'],
                $data['telefono'],
                $data['email'],
                $data['sucursal'],
                $data['cargo'],
                $data['id']
            ]);
        } catch (PDOException $e) {
            error_log("Error en actualizar: " . $e->getMessage());
            return false;
        }
    }

   // En la clase Usuario
public function eliminar($id, $currentUsername = null) {
    $pdo = Conexion::getConexion();
    
    // Si se proporciona el nombre de usuario actual, verificar
    if ($currentUsername !== null) {
        $stmt = $pdo->prepare("SELECT username FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && $user['username'] === $currentUsername) {
            return false; // No permitir eliminarse a sí mismo
        }
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("Error al eliminar usuario: " . $e->getMessage());
        return false;
    }
}

    public static function obtenerTodos() {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->prepare("SELECT id, documento, username, nombres, apellidos, telefono, email, sucursal, cargo, fecha_registro 
                               FROM usuarios ORDER BY fecha_registro DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorId($id) {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function autenticar($username, $password) {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario && password_verify($password, $usuario['password']) ? $usuario : false;
    }

    public function getNombreCompleto() {
        return $this->nombres . ' ' . $this->apellidos;
    }

    // Getters
    public function getDocumento()      { return $this->documento; }
    public function getTelefono()       { return $this->telefono; }
    public function getSucursal()       { return $this->sucursal; }
    public function getCargo()          { return $this->cargo; }
    public function getFechaRegistro()  { return $this->fecha_registro; }
}
