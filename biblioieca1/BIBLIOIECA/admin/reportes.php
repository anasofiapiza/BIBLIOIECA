<?php
session_start();
require_once 'includes/functions.php';

$stats = getStatistics();
$category_stats = getCategoryStats();
$loans = getAllLoans();

$overdue_loans = array_filter($loans, function($loan) {
    return $loan['status'] === 'active' && strtotime($loan['return_date']) < time();
});
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes y Estadísticas - Biblioteca</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <header class="top-bar">
            <h1>Reportes y Estadísticas</h1>
        </header>

        <div class="content-area">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">LB</div>
                    <div class="stat-info">
                        <h3><?php echo $stats['total_books']; ?></h3>
                        <p>Total de Libros</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">OK</div>
                    <div class="stat-info">
                        <h3><?php echo $stats['available_books']; ?></h3>
                        <p>Libros Disponibles</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">PR</div>
                    <div class="stat-info">
                        <h3><?php echo $stats['active_loans']; ?></h3>
                        <p>Préstamos Activos</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">US</div>
                    <div class="stat-info">
                        <h3><?php echo $stats['total_users']; ?></h3>
                        <p>Usuarios Registrados</p>
                    </div>
                </div>
            </div>

            <div class="report-section">
                <h2>Libros por Categoría</h2>
                <div class="category-grid">
                    <?php foreach ($category_stats as $category => $count): ?>
                    <div class="category-card">
                        <h3><?php echo $count; ?></h3>
                        <p><?php echo htmlspecialchars($category); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (count($overdue_loans) > 0): ?>
            <div class="report-section">
                <h2>ALERTA: Préstamos Vencidos</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Libro</th>
                                <th>Usuario</th>
                                <th>Fecha Préstamo</th>
                                <th>Fecha Devolución</th>
                                <th>Días de Retraso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($overdue_loans as $loan):
                                $book = getBookById($loan['book_id']);
                                $user = getUserById($loan['user_id']);
                                $days_overdue = floor((time() - strtotime($loan['return_date'])) / (60 * 60 * 24));
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($book['title'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($loan['loan_date'])); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($loan['return_date'])); ?></td>
                                <td><span class="badge badge-inactive"><?php echo $days_overdue; ?> días</span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <div class="report-section">
                <h2>Resumen General</h2>
                <div class="summary-cards">
                    <div class="summary-item">
                        <h4>Tasa de Ocupación</h4>
                        <p class="summary-value">
                            <?php 
                            $occupied_rate = $stats['total_books'] > 0 
                                ? round((($stats['total_books'] - $stats['available_books']) / $stats['total_books']) * 100, 1)
                                : 0;
                            echo $occupied_rate . '%';
                            ?>
                        </p>
                    </div>
                    
                    <div class="summary-item">
                        <h4>Préstamos Totales</h4>
                        <p class="summary-value"><?php echo count($loans); ?></p>
                    </div>
                    
                    <div class="summary-item">
                        <h4>Préstamos Vencidos</h4>
                        <p class="summary-value"><?php echo count($overdue_loans); ?></p>
                    </div>
                    
                    <div class="summary-item">
                        <h4>Categorías Registradas</h4>
                        <p class="summary-value"><?php echo count($category_stats); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
