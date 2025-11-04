<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crafty+Girls&family=Delius&family=Poiret+One&family=Winky+Rough&display=swap" rel="stylesheet">
    <title>Registro - Librería Cute</title>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-light navbar-light">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="index.html">Librería</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link active" aria-current="page" href="index.html">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link" href="registro.php">Registrar Libro</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link" href="consulta.html">Consultar Libros</a>
      </li>
    </ul>
    <form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Search">
        <button class="btn btn-primary" type="button">Search</button>
    </form>
  </div>
</nav>

    <div class="container my-5 bienvenida">
        <h1 class="text-center mb-4">Registro de Libro Nuevo</h1>
        
        <form class="p-4 border rounded shadow-sm">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej. Cien años de soledad">
            </div>
            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" placeholder="Ej. Gabriel García Márquez">
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de Publicación</label>
                <input type="date" class="form-control" id="fecha" name="fecha">
            </div>
            <div class="mb-3">
                <label for="portada" class="form-label">Imagen de Portada</label>
                <input type="file" class="form-control" id="portada" name="portada" accept="image/*">
                <small class="form-text text-muted">Selecciona un archivo de imagen para la portada.</small>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Registrar Libro</button>
        </form>
    </div>

</body>
</html>