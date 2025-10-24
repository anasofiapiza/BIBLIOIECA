const input = document.getElementById("buscador");
const table = document.getElementById("tablaLibros").getElementsByTagName("tbody")[0];

input.addEventListener("keyup", function () {
    const filtro = input.value.toLowerCase();
    const filas = table.getElementsByTagName("tr");

    for (let i = 0; i < filas.length; i++) {
        const textoFila = filas[i].textContent.toLowerCase();
        filas[i].style.display = textoFila.includes(filtro) ? "" : "none";
    }
});


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

function eliminarLibro(id) {
    if (confirm("¿Seguro que deseas eliminar este libro?")) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar_libro.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200 && xhr.responseText.trim() === "ok") {
                // Eliminar la fila visualmente sin recargar
                const fila = event.target.closest("tr");
                fila.style.transition = "0.3s";
                fila.style.opacity = "0";
                setTimeout(() => fila.remove(), 300);
            } else {
                alert("Error al eliminar el libro.");
            }
        };
        xhr.send("id=" + id);
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