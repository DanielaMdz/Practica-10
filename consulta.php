<?php
    $servername = "db";   
    $username = "root";
    $password = "root_password";
    $dbname = "libros";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);


    if(mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
$sql_query = ""; 
    $search_term = "";

    if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
        
        $search_term = $_GET['search_query'];
        $like_term = "%" . $search_term . "%";

        $sql_query = "SELECT * FROM libro WHERE titulo LIKE ? OR autor LIKE ?";
        
        $stmt = mysqli_prepare($conn, $sql_query);
        mysqli_stmt_bind_param($stmt, "ss", $like_term, $like_term);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);

    } else {
        $sql_query = "SELECT * FROM libro ORDER BY id DESC;";
        $result = mysqli_query($conn, $sql_query);
    }

    $num_libros = 0;
    if ($result) {
        $num_libros = mysqli_num_rows($result);
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
    <title>Consulta</title>
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
        <h1 class="text-center mb-4">Libros Registrados</h1>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <?php if ($num_libros > 0): ?>
                
                <?php while ($row = mysqli_fetch_assoc($result)):
                    
                    $PortadaSrc = 'data:image/jpeg;base64,' . base64_encode($row['Portada']);
                    
                    $titulo = htmlspecialchars($row['titulo']);
                    $autor = htmlspecialchars($row['autor']);
                    $fecha = htmlspecialchars($row['fecha_publicacion']);
                ?>
                
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo $PortadaSrc; ?>" class="card-img-top" alt="Portada de <?php echo $titulo; ?>" style="height: 350px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $titulo; ?></h5>
                            <p class="card-text"><strong>Autor:</strong> <?php echo $autor; ?></p>
                            <p class="card-text"><small class="date">Publicado el: <?php echo $fecha; ?></small></p>
                        </div>
                    </div>
                </div>

                <?php endwhile; ?>

<?php else: ?>
    <div class="col-md-6 text-center mt-5 mx-auto"> 
        <p>¡Aún no hay libros registrados en la base de datos!</p>
    </div>
<?php endif; ?>
            
        </div>
    </div>

</body>
</html>