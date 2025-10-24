<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header("Location: ../pages/libros.html");
  exit();
}

require_once 'includes/functions.php';

$stats = getStatistics();

include('../php/conexion.php');

$sql = "SELECT COUNT(*) AS total FROM usuarios";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
$totalUsuarios = $fila['total'];


$sql = "SELECT COUNT(*) AS total_libros FROM libros";
$resultado = $conexion->query($sql);

$total_libros = 0;
if ($resultado && $fila = $resultado->fetch_assoc()) {
    $total_libros = $fila['total_libros'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - BIBLIOIECA</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="../imgs/ieca.jpg">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
    <div class="admin-container">
        <nav class="admin-sidebar">
            <div class="admin-logo">
                <img src="../imgs/ieca.jpg" alt="BIBLIOIECA Logo">
                <h1>BIBLIOIECA Administrador</h1>
            </div>
            <ul class="admin-menu">
                <li><a href="#" data-section="dashboard" class="active">Panel</a></li>
                <li><a href="libros.php" data-section="books">Gestión de Libros</a></li>
                <li><a href="usuarios.php" data-section="users">Gestión de Usuarios</a></li>
                <li><a href="prestamos.php" data-section="loans">Préstamos</a></li>
                <li><a href="../pages/index.php" data-section="loans">Inicio</a></li>
            </ul>
            <div class="admin-footer">
                <a href="../php/logout.php" data-section="loans" id="logout-admin logout" class="btn-logout"><i class="ri-logout-box-line">Cerrar Sesión</i></a>
            </div>
        </nav>

        <main class="admin-content">
            <section id="dashboard" class="admin-section active">
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Usuarios</h3>
                        <p id="total-users"><?php echo $totalUsuarios; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Libros Disponibles</h3>
                        <p id="total-books"><?php echo $total_libros; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Préstamos Activos</h3>
                        <p id="active-loans">Cargando...</p>
                    </div>

                </div>
                <div class="recent-activity">
                    <h3>Actividad Reciente</h3>
                    <div id="activity-list" class="activity-list">
                        <!-- Se llenará automaticamente -->
                    </div>
                </div>

            </section>
        </main>
           
<!-- <div class="dashboard-sections" style="width: 100%; display: flex; justify-content: center;">
    <div class="section-card" style="width: 100%; background-color: #fff; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; box-sizing: border-box;">
        <h2 style="text-align: center; color: #333; margin-bottom: 20px;">Historial de préstamos</h2>
        <div class="table-container" style="width: 100%; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-family: Arial, sans-serif;">
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

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> -->

    <script src="js/admin.js"></script>
</body>
</html>
