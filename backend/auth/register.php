<?php
// register.php

header("Content-Type: text/plain; charset=utf-8");

// Permitir sólo método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método no permitido";
    exit;
}

// Conexión a BD
require_once __DIR__ . '/../config/db.php';

// Obtener datos POST
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'cliente';

// Validar datos mínimos
if (!$name || !$email || !$password) {
    http_response_code(400);
    echo "Completa todos los campos obligatorios.";
    exit;
}

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Email inválido.";
    exit;
}

try {
    // Verificar si email ya existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo "Este correo ya está registrado.";
        exit;
    }

    // Hashear contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $hash, $role]);

    echo "Registro exitoso. Ya puedes iniciar sesión.";

} catch (PDOException $e) {
    http_response_code(500);
    echo "Error en base de datos: " . $e->getMessage();
}
