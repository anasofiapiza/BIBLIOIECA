# Panel de Administración de Biblioteca

## Descripción General
Sistema de gestión de biblioteca desarrollado en PHP vanilla y CSS, con diseño moderno en tonos azules. El sistema permite gestionar libros, usuarios, préstamos y generar reportes estadísticos.

## Características Implementadas
- ✅ Gestión completa de libros (CRUD: agregar, editar, eliminar, buscar)
- ✅ Gestión de usuarios/miembros con información completa
- ✅ Sistema de préstamos y devoluciones
- ✅ Dashboard con estadísticas en tiempo real
- ✅ Reportes y análisis de datos
- ✅ Diseño responsive con paleta de colores azules moderna

## Tecnologías Utilizadas
- **Backend**: PHP 8.4 (vanilla, sin frameworks)
- **Frontend**: HTML5 + CSS3 puro
- **Almacenamiento**: Archivos JSON
- **Servidor**: PHP Built-in Server (puerto 5000)

## Estructura del Proyecto
```
/
├── index.php           # Dashboard principal
├── libros.php          # Gestión de libros
├── usuarios.php        # Gestión de usuarios
├── prestamos.php       # Gestión de préstamos
├── reportes.php        # Reportes y estadísticas
├── includes/
│   ├── functions.php   # Funciones helper y CRUD
│   └── sidebar.php     # Menú de navegación
├── css/
│   └── styles.css      # Estilos modernos en tonos azules
└── data/
    ├── books.json      # Base de datos de libros
    ├── users.json      # Base de datos de usuarios
    └── loans.json      # Base de datos de préstamos
```

## Paleta de Colores
- **Azul Primario**: #1e3a8a
- **Azul Secundario**: #3b82f6
- **Azul Claro**: #60a5fa
- **Azul Muy Claro**: #dbeafe
- **Azul Oscuro**: #1e293b

## Funcionalidades Principales

### Gestión de Libros
- Agregar nuevos libros con título, autor, ISBN, categoría
- Editar información de libros existentes
- Eliminar libros del catálogo
- Búsqueda por título, autor o ISBN
- Control de disponibilidad

### Gestión de Usuarios
- Registro de nuevos miembros
- Editar información de usuarios
- Eliminar usuarios
- Búsqueda por nombre o email

### Sistema de Préstamos
- Registro de nuevos préstamos
- Devolución de libros
- Filtrado por estado (activos/devueltos)
- Control automático de disponibilidad

### Dashboard y Reportes
- Estadísticas generales (total libros, disponibles, préstamos activos, usuarios)
- Préstamos recientes
- Distribución por categorías
- Alertas de préstamos vencidos
- Tasa de ocupación de la biblioteca

## Ejecución del Proyecto
El servidor PHP está configurado para ejecutarse automáticamente en el puerto 5000.

## Estado Actual
✅ Sistema completamente funcional con datos de ejemplo
✅ Diseño responsive y moderno
✅ Todas las operaciones CRUD implementadas
✅ Almacenamiento persistente en JSON
