<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Músicos e Instrumentos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm bg-black y-3 px-5">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="../index.php">Simulador de Músicos</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./insertMusician.php">Insertar Músico</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./insertInstrument.php">Insertar Instrumento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./listMusician.php">Lista de Músicos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-5">
        <h3 class="mb-4 text-center">Gestión de Músicos e Instrumentos</h3>
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="updateMusician.php" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-pencil-square me-2"></i> Editar Músico o Años de Experiencia
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="deleteMusician.php" class="btn btn-danger btn-lg w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-trash me-2"></i> Eliminar Músico
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="deleteInstrument.php" class="btn btn-warning btn-lg w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-music-note-beamed me-2"></i> Eliminar Instrumento de Músico
                </a>
            </div>
        </div>
    </div>
</body>

</html>