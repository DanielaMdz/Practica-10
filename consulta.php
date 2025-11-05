<?php
    $servername = "db";     // El nombre del servicio en Docker
    $username = "root";
    $password = "root_password";
    $dbname = "libros";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if(mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($conn, "SELECT * FROM libro;");
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