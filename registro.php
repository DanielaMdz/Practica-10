<?php

$mensaje = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['titulo']) && isset($_POST['autor']) && isset($_FILES['Portada']) && $_FILES['Portada']['error'] == 0) {
        
    $servername = "db";    
    $username = "root";
    $password = "root_password";
    $dbname = "libros";
        
    $conn = mysqli_connect($servername, $username, $password, $dbname);

        if(mysqli_connect_errno()) {
            $mensaje = "Error de conexión: " . mysqli_connect_error();
        } else {
            
            try {
                $titulo = $_POST['titulo'];
                $autor = $_POST['autor'];
                $fecha = $_POST['fecha_publicacion'];
                
                $PortadaData = file_get_contents($_FILES['Portada']['tmp_name']);
                $sql = "INSERT INTO libro (titulo, autor, fecha_publicacion, Portada) VALUES (?, ?, ?, ?)";
                
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssb", $titulo, $autor, $fecha, $null);
                
                mysqli_stmt_send_long_data($stmt, 3, $PortadaData); 

                if (mysqli_stmt_execute($stmt)) {
                    $mensaje = "¡Libro registrado con éxito!";
                } else {
                    $mensaje = "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt);
                }
                
                mysqli_stmt_close($stmt);
                
            } catch (Exception $e) {
                $mensaje = "Error al procesar la imagen: " . $e->getMessage();
            }
            
            mysqli_close($conn);
        }

    } else {
        $mensaje = "Error: Faltan datos o hubo un error al subir la imagen (¿archivo muy grande?).";
        if (isset($_FILES['Portada']) && $_FILES['Portada']['error'] != 0) {
            $mensaje .= " Código de error de subida: " . $_FILES['Portada']['error'];
        }
    }
}
?>
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
    
    <title>Registro</title>
</head>
<body>
<nav class="navbar navbar-expand-sm mi-navbar">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="#">💮Librería</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link" href="Inicio.html">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link active" aria-current="page" href="registro.php">Registrar Libro</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link" href="consulta.php">Consultar Libros</a>
      </li>
    </ul>
    <form class="d-flex" action="consulta.php" method="GET">
            <input class="form-control me-2" type="text" placeholder="Buscar por título o autor" name="search_query">
            <button class="btn btn-primary" type="submit">Buscar</button>
    </form>
  </div>
</nav>

    <div class="container my-5">
        <h1 class="text-center mb-4">Registro de Libro Nuevo</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        
        <form action="registro.php" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm" style="background-color: white;">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" required>
            </div>
            <div class="mb-3">
                <label for="fecha_publicacion" class="form-label">Fecha de Publicación</label>
                <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion" required>
            </div>
            <div class="mb-3">
                <label for="Portada" class="form-label">Imagen de Portada</label>
                <input type="file" class="form-control" id="Portada" name="Portada" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Registrar Libro</button>
        </form>
    </div>

</body>
</html>