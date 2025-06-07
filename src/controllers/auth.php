<?php

// src/controllers/auth.php
use RapiExpress\Models\Usuario;
use RapiExpress\Config\Conexion;


function auth_login() {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log("Intentando autenticar usuario: " . $_POST['username']); 
        $usuario = Usuario::autenticar($_POST['username'], $_POST['password']);
        error_log("Resultado autenticación: " . print_r($usuario, true)); 
        
        if ($usuario) {
            session_start();
            $_SESSION['usuario'] = $usuario['username'];
            header('Location: index.php?c=dashboard&a=index');
            exit();
        } else {
            $error = "Credenciales inválidas.";
            error_log("Error de autenticación para usuario: " . $_POST['username']); 
        }
    }
    include __DIR__ . '/../views/auth/login.php';
}

function auth_register() {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'documento' => trim($_POST['documento']),
            'username' => trim($_POST['username']),
            'nombres' => trim($_POST['nombres']),
            'apellidos' => trim($_POST['apellidos']),
            'telefono' => trim($_POST['telefono']),
            'email' => trim($_POST['email']),
            'sucursal' => $_POST['sucursal'],
            'cargo' => $_POST['cargo'],
            'password' => $_POST['password']
        ];
        
        if (empty($data['documento']) || empty($data['email']) || empty($data['username'])) {
            $error = "Todos los campos son obligatorios";
        } else {
            $usuario = new Usuario($data);
            $resultado = $usuario->registrar();
            
            switch ($resultado) {
                case 'registro_exitoso':
                    session_start();
                    $_SESSION['registro_exitoso'] = true;
                    header('Location: index.php?c=auth&a=login&registro=exitoso');
                    exit();
                    
                case 'documento_existente':
                    $error = "La cédula/identificación ya está registrada";
                    break;
                    
                case 'email_existente':
                    $error = "El correo electrónico ya está registrado";
                    break;
                    
                case 'username_existente':
                    $error = "El nombre de usuario ya está en uso";
                    break;
                    
                case 'error_bd':
                    $error = "Error en la base de datos. Por favor intente más tarde";
                    break;
                    
                default:
                    $error = "Error al registrar. Por favor intente nuevamente";
            }
        }
    }
    
    include __DIR__ . '/../views/auth/register.php'; 
}

function auth_recoverPassword() {
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $newPassword = $_POST['password'] ?? '';

        if (!empty($username) && !empty($newPassword)) {
            $pdo = Conexion::getConexion();

            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE username = :username");
                $updateStmt->execute([
                    'password' => $hashedPassword,
                    'username' => $username
                ]);

                $success = "Contraseña actualizada correctamente. Puedes iniciar sesión con tu nueva contraseña.";
            } else {
                $error = "Usuario no encontrado.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }
    }
    include __DIR__ . '/../views/auth/recoverpassword.php';
}

function auth_logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php?c=auth&a=login');
    exit();
}
