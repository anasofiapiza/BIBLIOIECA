<div class="sidebar">
    <div class="sidebar-header">
        <h2>Biblioteca</h2>
        <p>Panel de Administración</p>
    </div>
    
    <nav class="sidebar-menu">
        <a href="index.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
            <span class="icon">■</span>
            <span>Dashboard</span>
        </a>
        
        <a href="libros.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) === 'libros.php' ? 'active' : ''; ?>">
            <span class="icon">■</span>
            <span>Libros</span>
        </a>
        
        <a href="usuarios.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) === 'usuarios.php' ? 'active' : ''; ?>">
            <span class="icon">■</span>
            <span>Usuarios</span>
        </a>
        
        <a href="prestamos.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) === 'prestamos.php' ? 'active' : ''; ?>">
            <span class="icon">■</span>
            <span>Préstamos</span>
        </a>
        
        <a href="reportes.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) === 'reportes.php' ? 'active' : ''; ?>">
            <span class="icon">■</span>
            <span>Reportes</span>
        </a>
    </nav>
</div>
