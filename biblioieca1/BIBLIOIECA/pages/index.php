<?php
session_start();
$usuario_logueado = isset($_SESSION['usuario']);
$rol = strtolower($_SESSION['rol'] ?? '');
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BIBLIOIECA - Biblioteca Digital</title>
        <link rel="stylesheet" href="../css/index.css">
        <link rel="shortcut icon" href="../imgs/ieca.jpg">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    </head>

    <body>
        <header>
            <nav>
                <div class="logo">
                    <img src="../imgs/ieca.jpg" alt="Logo Biblioteca">
                    <h1>BIBLIOIECA</h1>
                </div>
                <ul>
                    <li><a href="index.php" class="active">Inicio</a></li>
                    <li><a href="libros.html">Libros</a></li>
                    <li class="dropdown">
                        <a href="sobre-nosotros.html">Sobre Nosotros</a>
                    </li>
                    <li class="user-menu">
                        <div class="user-icon" id="userIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor"
                                class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                            </svg>
                        </div>
                        <ul class="dropdown" id="dropdownMenu">
                            <?php if ($usuario_logueado): ?>
                                <?php if ($rol === 'administrador'): ?>
                                <li><a href="../admin/index.php" id="adminPanelBtn">Ir al Panel</a></li>
                                <?php else: ?>
                                <li><a href="libros.html" id="goBooksBtn">Ir a Libros</a></li>
                                <?php endif; ?>
                                <li><a href="../php/logout.php" id="logoutBtn">Cerrar sesión</a></li>
                            <?php else: ?>
                                <li><a href="../php/login.php" id="loginBtn">Iniciar sesión</a></li>
                            <?php endif; ?>
                        </ul>

                    </li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="hero">
                <h2>BIBLIOIECA</h2>
                <p>Tu viaje literario comienza aquí.</p>
                
                <?php if ($usuario_logueado): ?>
                <?php if ($rol === 'administrador'): ?>
                <a href="../admin/index.php" class="btn-primary">Ir al Panel</a>
                <?php else: ?>
                <a href="libros.html" class="btn-primary">Ir a Libros</a>
                <?php endif; ?>
                <?php else: ?>
                <a href="../php/login.php" class="btn-primary">Iniciar sesión</a>
                <?php endif; ?>


            </section>

            <section id="sobre-nosotros" class="about-section">
                <h2>¡Bienvenido a BIBLIOIECA!</h2>
                <p>¡Hola a todos! Bienvenidos a su biblioteca escolar digital. Aquí encontrarás un montón de libros e
                    historias para inspirarte, aprender y divertirte. </p><br>
                <p>¡Esperamos que disfrutes explorando todo lo que tenemos para ofrecerte, porque tu viaje literario
                    comienza justo aquí!</p>
            </section>

            <section id="libros" class="books-section">
                <h2>Libros destacados</h2>
                <div class="books-container">
                    <div class="book-item">
                        <img src="https://www.bogotaauctions.com/img/thumbs/500/001/711/001-711-238.jpg?a=1714431792"
                            alt="Libro 1">
                        <h3>Debora arango</h3>
                        <p>Debora arango perez</p>
                        <p>1996</p>

                        <div class="book-options hidden">
                            <button class="btn-prestar">Prestar</button>
                            <button class="btn-libros">Libros</button>
                        </div>
                    </div>

                    <div class="book-item">
                        <img src="https://www.libreriacasatomada.com/imagenes/9789589/978958980278.GIF" alt="Libro 2">
                        <h3>Medellín de calles y gentes </h3>
                        <p>Juan Fernando Ospina.</p>
                        <p>2010</p>

                        <div class="book-options hidden">
                            <button class="btn-prestar">Prestar</button>
                            <button class="btn-libros">Libros</button>
                        </div>
                    </div>

                    <div class="book-item">
                        <img src="https://images.cdn2.buscalibre.com/fit-in/360x360/e6/b4/e6b4c842c7f7974dfd9431740d66734e.jpg"
                            alt="Libro 3">
                        <h3>Toda mafalda</h3>
                        <p>Joaquín Salvador Lavado Tejón</p>
                        <p>1964</p>

                        <div class="book-options hidden">
                            <button class="btn-prestar">Prestar</button>
                            <button class="btn-libros">Libros</button>
                        </div>
                    </div>
                </div>

                <div class="contact-wrapper">
                    <section id="contacto-info" class="contact-info-section">
                        <div class="container">
                            <div class="contact-columns">
                                <div class="contact-details">
                                    <h3>Contáctanos</h3>
                                    <p>Barrio Santander, Medellín, Antioquia, Colombia</p>

                                    <h3>Dirección</h3>
                                    <p>Calle 111 No. 79 - 77</p>
                                    <p>Lun - Vie 8 a.m. - 4 p.m.
                                        <br>
                                        Sáb, Dom Cerrado
                                    </p>

                                    <h3>Teléfono</h3>
                                    <p>(604) 358 95 88 <br>
                                        Celular: +57 300 418 0469</p>
                                    <div class="social-icons">
                                        <a href="https://www.facebook.com/profile.php?id=100076308393310" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a>
                                        <a href="https://www.youtube.com/@ciudadelalasamericas8902" target="_blank"><i
                                                class="fab fa-youtube"></i></a>
                                        <a href="https://instagram.com/ciudadelalasamericas?igshid=OGQ5ZDc2ODk2ZA=="
                                            target="_blank"><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>

                                <div class="contact-right">
                                    <br>
                                    <p>Una gran visión sin grandes personas es irrelevante.<br>Trabajemos juntos.</p>
                                    <div class="contact-form-container">
                                        <form id="contact-form">
                                            <input type="text" id="name" name="name" placeholder="Nombre" required>
                                            <textarea id="message" name="message" placeholder="Mensaje" required></textarea>
                                            <button type="submit">Enviar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
            </section>
        </main>
        <script src="../js/script.js"></script>
    </body>
</html>