<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'includes/functions.php';

include('../php/conexion.php');

$sql = "SELECT COUNT(*) AS total FROM usuarios";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
$totalUsuarios = $fila['total'];

$action = $_GET['action'] ?? 'list';
$message = '';



$conexion = new mysqli("localhost", "root", "", "biblioieca_bd");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

if (isset($_POST['eliminar_usuario'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM usuarios WHERE ID_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario eliminado correctamente'); window.location='usuarios.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario');</script>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BIBLIOIECA - Gestión de usuarios</title>
        <link rel="stylesheet" href="../css/admin.css">
        <link rel="shortcut icon" href="../imgs/ieca.jpg">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
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
                    <li><a href="usuarios.php" data-section="users" class="active">Gestión de Usuarios</a></li>
                    <li><a href="prestamos.php" data-section="loans">Préstamos</a></li>
                    <li><a href="../pages/index.php" data-section="loans">Inicio</a></li>
                </ul>
                <div class="admin-footer">
                    <a href="../php/logout.php" data-section="loans" id="logout-admin logout" class="btn-logout"><i class="ri-logout-box-line">Cerrar Sesión</i></a>
                </div>
            </nav>

            <main>
                <div class="content-area">
                    <div class="action-bar"
                        style="display: flex; justify-content: center; align-items: center; gap: 15px; flex-wrap: wrap; margin: 20px 0;">
    
                        <form method="GET" class="search-form" style="display: flex; align-items: center; gap: 8px;">
                            <input type="text" name="search" placeholder="Buscar usuarios..."
                                style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 250px; font-size: 14px;">
                            <button type="submit"
                                style="background-color: #007bff; color: white; border: none; padding: 10px 16px; border-radius: 5px; cursor: pointer;">
                                Buscar
                            </button>
                        </form>

                        <button style="background-color: #28a745; color: white; border: none; padding: 10px 16px; border-radius: 5px; cursor: pointer;" onclick="mostrarModal()">
                            + Agregar Usuario
                        </button>
                    </div>
                </div>
    
                <div style="width:90%; margin: 10px auto; display:flex; justify-content: space-between; align-items:center;">
                    <div style="color:#555;">Total de usuarios registrados: <?php echo htmlspecialchars($totalUsuarios, ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
    
                <div class="table-container" style="width: 90%; margin: 20px auto; overflow-x: auto; box-sizing: border-box;">
                    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; text-align: left;">
                        <thead>
                            <tr style="background-color: #007bff; color: white;">
                                <th style="padding: 12px; border: 1px solid #ddd;">Nombre</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Email</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Fecha Registro</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $busqueda = "";
                                if (isset($_GET['search']) && !empty($_GET['search'])) {
                                    $busqueda = trim($_GET['search']);
                                    $sqlUsuarios = "SELECT * FROM usuarios WHERE nombre LIKE ? OR email LIKE ? ORDER BY ID_usuario DESC";
                                    $stmt = $conexion->prepare($sqlUsuarios);
                                    $param = "%$busqueda%";
                                    $stmt->bind_param("ss", $param, $param);
                                    $stmt->execute();
                                    $resultadoUsuarios = $stmt->get_result();
                                } else {
                                    $sqlUsuarios = "SELECT * FROM usuarios ORDER BY ID_usuario DESC";
                                    $resultadoUsuarios = $conexion->query($sqlUsuarios);
                                }
    
    
                                if ($resultadoUsuarios->num_rows > 0) {
                                    while ($usuario = $resultadoUsuarios->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$usuario['nombre']}</td>";
                                        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($usuario['email']) . "</td>";
                                        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($usuario['fecha_registro']) . "</td>";
                                        echo "<td style='padding: 10px; border: 1px solid #ddd; text-align: center;'>
                                                <form method='POST' onsubmit='return confirm(\"¿Seguro que deseas eliminar este usuario?\");' style='display:inline;'>
                                                    <input type='hidden' name='id' value='" . $usuario['ID_usuario'] . "'>
                                                    <button type='submit' name='eliminar_usuario' style='background-color: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;'>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' style='text-align:center; padding:10px;'>No hay usuarios registrados.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>

        <!-- --- MODAL --- -->
    <div class="modal" id="modalAgregar">
        <div class="modal-content">
            <h2>Agregar Nuevo Usuario</h2>
            <form method="POST">
                <input type="text" name="nombre" placeholder="Nombre del usuario" required>
                <input type="text" name="email" placeholder="Email" required>
                <input type="text" name="clave" placeholder="Contraseña" required>
                <select name="rol" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Estudiante">Estudiante</option>
                </select>

                <button type="submit" name="usuario" class="btn-guardar">Agregar</button>
                <button type="button" class="btn-cancelar" onclick="ocultarModal()">Cancelar</button>
            </form>

            <?php if (!empty($mensaje)): ?>
                <div class="mensaje"><?php echo $mensaje; ?></div>
            <?php endif; ?>
        </div>
    </div>


    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <h2>Editar Libro</h2>
            <form method="POST" action="">
                <input type="hidden" name="ID_libros" id="edit_id">
                
                <label>Título</label>
                <input type="text" name="Titulo" id="edit_titulo" required>
                
                <label>Autor</label>
                <input type="text" name="Autor" id="edit_autor" required>
                
                <label>Categoría</label>
                <input type="text" name="Categoria" id="edit_categoria" required>
                
                <label>ISBN</label>
                <input type="text" name="ISBN" id="edit_isbn" required>
                
                <label>Estado</label>
                <select name="Estado" id="edit_estado">
                    <option value="Disponible">Disponible</option>
                    <option value="Prestado">Prestado</option>
                </select>
                
                <button type="submit" name="actualizar" class="btn-guardar">Guardar Cambios</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModalEditar()">Cancelar</button>
            </form>
        </div>
    </div>

        <script src="js/usuarios.js"></script>
    </body>
</html>