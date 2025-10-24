document.getElementById('logout')?.addEventListener('click', function (e) {
  e.preventDefault();
  if (confirm('¿Deseas cerrar la sesión?')) {
    window.location.href = '../pages/index.php';
  }
});