<?php
session_start();
require_once 'includes/functions.php';

include('../php/conexion.php'); // conecta a la base de datos

$sql = "SELECT COUNT(*) AS total FROM usuarios";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
$totalUsuarios = $fila['total'];

$action = $_GET['action'] ?? 'list';
$message = '';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de usuarios - BIBLIOIECA</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="../imgs/ieca.jpg">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
    <div class="admin-container">
        <nav class="admin-sidebar">
            <div class="admin-logo">
                <img src="../imgs/ieca.jpg" alt="BIBLIOIECA Logo">
                <h1>BIBLIOIECA - Administrador</h1>
            </div>
            <ul class="admin-menu">
                <li><a href="index.php" data-section="dashboard">Panel</a></li>
                <li><a href="libros.php" data-section="books">Gestión de Libros</a></li>
                <li><a href="usuarios.php" data-section="users">Gestión de Usuarios</a></li>
                <li><a href="prestamos.php" data-section="loans" class="active">Préstamos</a></li>
                <li><a href="../pages/index.php" data-section="loans">Inicio</a></li>
            </ul>
            <div class="admin-footer">
                <a href="../php/logout.php" data-section="loans" id="logout-admin logout" class="btn-logout"><i class="ri-logout-box-line">Cerrar Sesión</i></a>
            </div>
        </nav>

        <main>
            <div class="action-bar" style="display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; margin-top:40px;">
                <div class="filter-buttons" style="display: flex; gap: 8px;">
                    <a href="#" style="background-color: #007bff; color: white; padding: 8px 14px; border-radius: 5px; text-decoration: none;">Todos</a>
                    <a href="#" style="background-color: #28a745; color: white; padding: 8px 14px; border-radius: 5px; text-decoration: none;">Disponibles</a>
                    <a href="#" style="background-color: #ffc107; color: white; padding: 8px 14px; border-radius: 5px; text-decoration: none;">Prestados</a>
                </div>
                <button style="background-color: #28a745; color: white; border: none; padding: 8px 14px; border-radius: 5px; cursor: pointer;">
                    + Nuevo Préstamo
                </button>
            </div>

            <div class="table-container" 
                style="width: 90%; margin: 0 auto; overflow-x: auto; box-sizing: border-box;">
                <table style="width: 90%; border-collapse: collapse; text-align: left; background-color: white;">
                    <thead>
                        <tr style="background-color: #007bff; color: white;">
                            <th style="padding: 12px; border: 1px solid #ddd;">Libro</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">Usuario</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">Fecha Préstamo</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">Fecha Devolución</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">Cien años de soledad</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">María López</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">01/10/2025</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">15/10/2025</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <select style="padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                                    <option>Disponible</option>
                                    <option selected>Prestado</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="js/prestamos.js"></script>
</body>
</html>
