// Mostrar / Ocultar modal
function mostrarModal() {
    document.getElementById('modalAgregar').style.display = 'flex';
}
function ocultarModal() {
    document.getElementById('modalAgregar').style.display = 'none';
}

// Cerrar modal si se hace clic fuera
window.onclick = function (event) {
    const modal = document.getElementById('modalAgregar');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_titulo').value = this.dataset.titulo;
        document.getElementById('edit_autor').value = this.dataset.autor;
        document.getElementById('edit_categoria').value = this.dataset.categoria;
        document.getElementById('edit_isbn').value = this.dataset.isbn;
        document.getElementById('edit_estado').value = this.dataset.estado;

        document.getElementById('modalEditar').style.display = 'flex';
    });
});

function cerrarModalEditar() {
    document.getElementById('modalEditar').style.display = 'none';
}

document.getElementById('logout')?.addEventListener('click', function (e) {
    e.preventDefault();
    if (confirm('¿Deseas cerrar la sesión?')) {
        window.location.href = '../pages/index.php';
    }
});