<?php
// --- Conexión a la base de datos ---
$servername = "localhost";
$username = "root"; // cambia si usas otro usuario
$password = ""; // agrega tu contraseña si aplica
$dbname = "biblioieca_bd"; // asegúrate de usar el nombre real de tu BD

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// --- Actualizar estado si se envió el formulario ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['estado'], $_POST['id'])) {
    $estado = $conn->real_escape_string($_POST['estado']);
    $id = intval($_POST['id']);
    $sql_update = "UPDATE libros SET Estado = '$estado' WHERE ID_libros = $id";
    if (!$conn->query($sql_update)) {
        echo "Error al actualizar: " . $conn->error;
    }
}

// --- Consultar libros ---
$sql = "SELECT ID_libros, Titulo, Autor, Categoria, ISBN, Estado FROM libros";
$result = $conn->query($sql);

// --- INSERTAR NUEVO LIBRO ---
$mensaje = "";
if (isset($_POST['agregar_libro'])) {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $estado = $conn->real_escape_string($_POST['estado']);

    $sql = "INSERT INTO libros (Titulo, Autor, ISBN, Categoria, Estado)
            VALUES ('$titulo', '$autor', '$isbn', '$categoria', '$estado')";
    if ($conn->query($sql)) {
        $mensaje = "✅ Libro agregado exitosamente.";
    } else {
        $mensaje = "❌ Error al agregar el libro: " . $conn->error;
    }
}

// --- OBTENER LIBROS ---
$libros = $conn->query("SELECT * FROM libros");

// --- ELIMINAR LIBRO ---
if (isset($_POST['eliminar'])) {
    $id = $_POST['ID_libros'];

    if (!empty($id) && is_numeric($id)) {
        $sql = "DELETE FROM libros WHERE ID_libros = $id";
        if ($conn->query($sql)) {
            echo "<script>alert('✅ Libro eliminado correctamente'); window.location.href='libros.php';</script>";
        } else {
            echo "<script>alert('❌ Error al eliminar el libro: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('ID no válido');</script>";
    }
}

if (isset($_POST['actualizar'])) {
    $id = $_POST['ID_libros'];
    $titulo = $_POST['Titulo'];
    $autor = $_POST['Autor'];
    $categoria = $_POST['Categoria'];
    $isbn = $_POST['ISBN'];
    $estado = $_POST['Estado'];

    $sql = "UPDATE libros 
            SET Titulo='$titulo', Autor='$autor', Categoria='$categoria', ISBN='$isbn', Estado='$estado'
            WHERE ID_libros=$id";

    if ($conn->query($sql)) {
        echo "<script>alert('✅ Libro actualizado correctamente'); window.location.href='libros.php';</script>";
    } else {
        echo "<script>alert('❌ Error al actualizar: " . $conexion->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de libros - BIBLIOIECA</title>
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
                <li><a href="libros.php" data-section="books" class="active">Gestión de Libros</a></li>
                <li><a href="usuarios.php" data-section="users">Gestión de Usuarios</a></li>
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

                    <form method="GET" class="search-form"
                        style="display: flex; align-items: center; gap: 8px;">
                        <input type="text" name="search" id="buscador" placeholder="Buscar libros..."
                            style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 250px; font-size: 14px;">
                        <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 10px 16px; border-radius: 5px; cursor: pointer;">
                            Buscar
                        </button>
                    </form>

                    <button style="background-color: #28a745; color: white; border: none; padding: 10px 16px; border-radius: 5px; cursor: pointer;" onclick="mostrarModal()">
                        + Agregar libro
                    </button>
                </div>
            </div>
            <div class="table-container" style="width: 90%; margin: 20px auto; overflow-x: auto; box-sizing: border-box;">
                <table id="tablaLibros" style="width: 90%; border-collapse: collapse; font-family: Arial, sans-serif; text-align: left; margin: 20px auto;">
                    <thead>
                        <tr style="background-color: #007bff; color: white;">
                            <th style="padding: 12px; border: 1px solid #ddd;">Título</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">Autor</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">ISBN</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">Categoría</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">Estado</th>
                            <th style="padding: 12px; border: 1px solid #ddd;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($row['Titulo']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($row['Autor']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($row['ISBN']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($row['Categoria']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">
                                        <form method="POST" style="margin: 0;">
                                            <input type="hidden" name="id" value="<?= $row['ID_libros'] ?>">
                                            <select name="estado" onchange="this.form.submit()"
                                                    style="padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
                                                <option value="Disponible" <?= $row['Estado'] == 'Disponible' ? 'selected' : '' ?>>Disponible</option>
                                                <option value="Prestado" <?= $row['Estado'] == 'Prestado' ? 'selected' : '' ?>>Prestado</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                        <button class="edit-btn" style="background-color: #ffc107; color: white; border: none; padding: 6px 20px; border-radius: 6px; cursor: pointer; font-size: 16px; display: inline-flex; align-items: center; justify-content: center; gap: 5px; transition: background-color 0.3s ease, transform 0.2s ease; margin-right: 5px; margin-bottom: 5px;" onmouseover="this.style.backgroundColor='#e0a800'; this.style.transform='scale(1.05)';"  onmouseout="this.style.backgroundColor='#ffc107'; this.style.transform='scale(1)';"                       
                                            data-id="<?php echo $row['ID_libros']; ?>"
                                            data-titulo="<?php echo $row['Titulo']; ?>"
                                            data-autor="<?php echo $row['Autor']; ?>"
                                            data-categoria="<?php echo $row['Categoria']; ?>"
                                            data-isbn="<?php echo $row['ISBN']; ?>"
                                            data-estado="<?php echo $row['Estado']; ?>">Editar
                                        </button>

                                        <form method="POST" action="">
                                            <input type="hidden" name="ID_libros" value="<?php echo $row['ID_libros']; ?>">
                                            <button type="submit" name="eliminar"
                                                style="background-color: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 16px; display: inline-flex; align-items: center; justify-content: center; gap: 5px; transition: background-color 0.3s ease, transform 0.2s ease;" onmouseover="this.style.backgroundColor='#b02a37'; this.style.transform='scale(1.05)';"  onmouseout="this.style.backgroundColor='#dc3545'; this.style.transform='scale(1)';">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align:center; padding: 12px;">No hay libros registrados</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
    

    <!-- --- MODAL --- -->
    <div class="modal" id="modalAgregar">
        <div class="modal-content">
            <h2>Agregar Nuevo Libro</h2>
            <form method="POST">
                <input type="text" name="titulo" placeholder="Título del libro" required>
                <input type="text" name="autor" placeholder="Autor" required>
                <input type="text" name="isbn" placeholder="ISBN" required>
                <input type="text" name="categoria" placeholder="Categoría" required>
                <select name="estado" required>
                    <option value="">Seleccionar estado...</option>
                    <option value="Disponible">Disponible</option>
                    <option value="Prestado">Prestado</option>
                </select>

                <button type="submit" name="agregar_libro" class="btn-guardar">Guardar</button>
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
    
    <script src="js/libros.js"></script>
</body>
</html>

<?php $conn->close(); ?>