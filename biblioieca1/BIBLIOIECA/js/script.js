document.addEventListener("DOMContentLoaded", function () {
  const userMenu = document.querySelector(".user-menu");
  const userIcon = document.getElementById("userIcon");

  userIcon.addEventListener("click", () => {
    userMenu.classList.toggle("active");
  });

  document.addEventListener("click", (e) => {
    if (!userMenu.contains(e.target)) {
      userMenu.classList.remove("active");
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const userInfo = document.getElementById('user-info');
  const loginBtn = document.querySelector('.btn-login');

  function checkSession() {
    fetch('../php/check_session.php')
      .then(response => response.json())
      .then(data => {
        if (data.loggedIn) {
          userInfo.innerHTML = `
                        <span>Bienvenido, ${data.name}</span>
                        <a href="perfil.html">Mi Perfil</a>
                        <button id="logout-btn">Cerrar Sesión</button>
                    `;
          if (loginBtn) loginBtn.style.display = 'none';

          document.getElementById('logout-btn').addEventListener('click', logout);
        } else {
          userInfo.innerHTML = '';
          if (loginBtn) loginBtn.style.display = 'inline-block';
        }
      });
  }

  function logout() {
    fetch('../php/logout.php')
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          checkSession();
          window.location.href = '../html/index.html';
        }
      });
  }

  checkSession();

  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const name = document.getElementById('contact-name').value;
      const email = document.getElementById('contact-email').value;
      const message = document.getElementById('contact-message').value;

      alert(`Enviando mensaje: \nNombre: ${name}\nEmail: ${email}\nMensaje: ${message}`);
      alert('Mensaje enviado.');
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const bookItems = document.querySelectorAll(".book-item");
  bookItems.forEach(item => {
    const img = item.querySelector("img");
    img.addEventListener("click", (event) => {
      event.stopPropagation();

      document.querySelectorAll(".book-options").forEach(options => {
        options.classList.add("hidden");
      });

      const options = item.querySelector(".book-options");
      options.classList.toggle("hidden");
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const userIcon = document.getElementById("userIcon");
  const userMenu = document.querySelector(".user-menu");
  const loginBtn = document.getElementById("loginBtn");
  const logoutBtn = document.getElementById("logoutBtn");

  let loggedIn = false; // Simulación inicial (luego lo reemplazamos con PHP)

  // Abrir/cerrar menú al hacer clic en el ícono
  userIcon.addEventListener("click", () => {
    userMenu.classList.toggle("active");
  });

  // Iniciar sesión → redirige a login.html
  loginBtn.addEventListener("click", () => {
    window.location.href = "login.html";
  });

  // Cerrar sesión → llama logout.php
  logoutBtn.addEventListener("click", (e) => {
    e.preventDefault();
    fetch("../php/logout.php")
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          loggedIn = false;
          userIcon.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
          `;
          loginBtn.style.display = "block";
          logoutBtn.style.display = "none";
        }
      });
  });

  // 🔹 Aquí puedes verificar sesión con tu PHP
  fetch("../php/check_session.php")
    .then(res => res.json())
    .then(data => {
      if (data.loggedIn) {
        loggedIn = true;
        userIcon.textContent = data.name.charAt(0).toUpperCase(); // Inicial
        loginBtn.style.display = "none";
        logoutBtn.style.display = "block";
      }
    });
});

document.addEventListener("DOMContentLoaded", function () {
  const userMenu = document.querySelector(".user-menu");
  const userIcon = document.getElementById("userIcon");

  // Mostrar/ocultar menú al dar clic en el ícono
  userIcon.addEventListener("click", () => {
    userMenu.classList.toggle("active");
  });

  document.addEventListener("click", (e) => {
    if (!userMenu.contains(e.target)) {
      userMenu.classList.remove("active");
    }
  });
});
