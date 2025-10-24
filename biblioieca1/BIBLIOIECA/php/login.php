<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "biblioieca_bd";

$conn = new mysqli($servidor, $usuario, $clave, $bd);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $clave = trim($_POST['clave']);

  $sql_admin = "SELECT * FROM admin WHERE email = '$email'";
  $res_admin = $conn->query($sql_admin);

  if ($res_admin->num_rows > 0) {
    $fila = $res_admin->fetch_assoc();

    if ($clave === $fila['clave'] || password_verify($clave, $fila['clave'])) {
      $_SESSION['usuario'] = $email;
      $_SESSION['rol'] = 'admin';
      header("Location: ../admin/index.php");
      exit();
    } else {
      $mensaje = "❌ Contraseña incorrecta para administrador.";
    }

  } else {
    $sql_user = "SELECT * FROM usuarios WHERE email = '$email'";
    $res_user = $conn->query($sql_user);

    if ($res_user->num_rows > 0) {
      $fila = $res_user->fetch_assoc();

      if ($clave === $fila['clave'] || password_verify($clave, $fila['clave'])) {
        $_SESSION['usuario'] = $email;
        $_SESSION['rol'] = $fila['rol'];

        if ($fila['rol'] === 'administrador') {
          header("Location: ../admin/index.php");
        } else {
          header("Location: ../pages/libros.html");
        }
        exit();
      } else {
        $mensaje = "❌ Contraseña incorrecta.";
      }
    } else {
      $mensaje = "❌ Usuario no encontrado.";
    }
  }
}

if (isset($_POST['registro'])) {
  $nombre = trim($_POST['nombre']);
  $email = trim($_POST['email']);
  $clave = trim($_POST['clave']);
  $rol = strtolower($_POST['rol'] ?? '');
  $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

  $check = "SELECT * FROM usuarios WHERE email = '$email'";
  $res = $conn->query($check);

  if ($res->num_rows > 0) {
    $mensaje = "⚠️ El correo ya está registrado.";
  } else {
    $sql = "INSERT INTO usuarios (nombre, email, clave, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $clave_hash, $rol);

    if ($stmt->execute()) {
      $mensaje = "✅ Registro exitoso. Ahora puedes iniciar sesión.";
    } else {
      $mensaje = "❌ Error al registrar: " . $stmt->error;
    }

    $stmt->close();
  }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login y Registro</title>
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="shortcut icon" href="../imgs/ieca.jpg">
</head>
<body>
  <a href="../pages/index.php" class="volver-btn volver-btn-izquierda">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg>  
    Volver
  </a>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">

        <form action="login.php" method="POST" class="sign-in-form">
          <h2 class="title">Iniciar Sesión</h2>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="clave" placeholder="Contraseña" required />
          </div>
          <input type="submit" name="login" value="Inicia Sesión" class="btn solid" />
          <p class="social-text">O inicia sesión con Google</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
          </div>
        </form>

        <form action="login.php" method="POST" class="sign-up-form">
          <h2 class="title">Registrarse</h2>
          
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="nombre" placeholder="Nombre" required />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="clave" placeholder="Contraseña" required />
          </div>

            <label for="rol">Tipo de usuario:</label>
            <select name="rol" id="rol" required>
              <option value="estudiante">Estudiante</option>
              <option value="administrador">Administrador</option>
            </select>



          <input type="submit" name="registro" class="btn" value="Registrarse" />
          <p class="social-text">O regístrate con Google</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
          </div>
        </form>

      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>¿Eres nuevo aquí?</h3>
          <p>¡Regístrate en segundos! Comienza a disfrutar de todos los beneficios de ser miembro.</p>
          <button class="btn transparent" id="sign-up-btn">Registrarse</button>
        </div>
        <img src="../imgs/log.png" class="image" alt="Login" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>¿Ya eres uno de nosotros?</h3>
          <p>¡Bienvenido de vuelta! Inicia sesión para continuar donde lo dejaste.</p>
          <button class="btn transparent" id="sign-in-btn">Iniciar sesión</button>
        </div>
        <img src="../imgs/register.svg" class="image" alt="Registro" />
      </div>
    </div>
  </div>

  <?php if (isset($mensaje)) { ?>
    <script>
      alert("<?php echo $mensaje; ?>");
    </script>
  <?php } ?>

  <script src="../js/login.js"></script>
</body>
</html>