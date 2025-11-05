<?php
// registro.php
$mensaje = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validamos que los campos necesarios estén
    if (isset($_POST['titulo']) && isset($_POST['autor']) && isset($_FILES['portada']) && $_FILES['portada']['error'] == 0) {
        
        require_once 'db_connect.php'; // Conectamos a la BD
        
        try {
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $fecha = $_POST['fecha_publicacion']; // Coincide con tu BD
            
            // Leemos los datos binarios de la imagen
            $portadaData = file_get_contents($_FILES['portada']['tmp_name']);
            
            // La consulta SQL coincide con tu BD: (titulo, autor, fecha_publicacion, portada)
            $sql = "INSERT INTO libros (titulo, autor, fecha_publicacion, portada) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(1, $titulo);
            $stmt->bindParam(2, $autor);
            $stmt->bindParam(3, $fecha);
            $stmt->bindParam(4, $portadaData, PDO::PARAM_LOB); // Tipo BLOB
            
            $stmt->execute();
            
            $mensaje = "¡Libro registrado con éxito!";
            
        } catch (PDOException $e) {
            $mensaje = "Error al registrar el libro: " . $e.getMessage();
        } catch (Exception $e) {
            $mensaje = "Error al procesar la imagen: " . $e.getMessage();
        }

    } else {
        $mensaje = "Error: Faltan datos o hubo un error al subir la imagen.";
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
    <title>Registro - Librería Cute</title>
</head>
<body>
<nav class="navbar navbar-expand-sm mi-navbar">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="#">💮Librería</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link active" aria-current="page" href="Inicio.html">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link" href="registro.php">Registrar Libro</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mi-nav-link" href="consulta.php">Consultar Libros</a>
      </li>
    </ul>
    <form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Search">
        <button class="btn btn-primary" type="button">Search</button>
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
                <label for="portada" class="form-label">Imagen de Portada</label>
                <input type="file" class="form-control" id="portada" name="portada" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Registrar Libro</button>
        </form>
    </div>

</body>
</html>
6. consulta.php
(Aquí está la lógica para MOSTRAR desde la BD. Nota cómo el while usa los nombres correctos).

PHP

<?php
// consulta.php
require_once 'db_connect.php';

try {
    $sql = "SELECT * FROM libros ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $num_libros = $stmt->rowCount();
} catch (PDOException $e) {
    echo "Error al consultar la base de datos: " . $e.getMessage();
    exit; 
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
    <title>Consulta - Librería Cute</title>
</head>
<body>

    <nav class="navbar navbar-expand-sm mi-navbar">
      <div class="container-fluid">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="index.html">📚 Librería</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mi-nav-link" href="index.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mi-nav-link" href="registro.php">Registrar Libro</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mi-nav-link active" aria-current="page" href="consulta.php">Consultar Libros</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center mb-4">Libros Registrados</h1>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <?php if ($num_libros > 0): ?>
                <?php while ($row = $stmt->fetch()):
                    
                    // Convertir el BLOB a Base64 para mostrar la imagen
                    $portadaSrc = 'data:image/jpeg;base64,' . base64_encode($row['portada']);
                    
                    // Usamos los nombres correctos de tu BD
                    $titulo = htmlspecialchars($row['titulo']);
                    $autor = htmlspecialchars($row['autor']);
                    $fecha = htmlspecialchars($row['fecha_publicacion']);
                ?>
                
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo $portadaSrc; ?>" class="card-img-top" alt="Portada de <?php echo $titulo; ?>" style="height: 350px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $titulo; ?></h5>
                            <p class="card-text"><strong>Autor:</strong> <?php echo $autor; ?></p>
                            <p class="card-text"><small class="text-muted">Publicado el: <?php echo $fecha; ?></small></p>
                        </div>
                    </div>
                </div>

                <?php endwhile; ?>

            <?php else: ?>
                <div class="col-12">
                    <p class="text-center mt-5">¡Aún no hay libros registrados en la base de datos!</p>
                </div>
            <?php endif; ?>
            
        </div>
    </div>

</body>
</html>