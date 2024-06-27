<?php
require_once('../Model/ModelCRUDSimuladorMusico.php');
$objSim = new ModelCRUDSimuladorMusico();
$instrumentos = $objSim->getAllInstruments();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Músicos por Instrumentos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm bg-black py-3 px-5">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="../index.php">Simulador de Músicos</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./insertInstrumet.php">Insertar Instrumentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./mainView.php">Editar Músico</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./insertMusician.php">Insertar Músico</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-5">
        <h2 class="mb-4">Listado de Músicos por Instrumentos</h2>
        <?php if (isset($_GET['error']) && $_GET['error'] == 1) : ?>
            <div class="alert alert-danger" role="alert">
                No se ha seleccionado un instrumento.
            </div>
        <?php endif; ?>
        <form action="../controller/listMusicianController.php" method="GET" class="mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="instrumento" class="col-form-label">Selecciona un instrumento:</label>
                </div>
                <div class="col-auto">
                    <select class="form-select" id="instrumento" name="instrumento">
                        <option value="">Todos los instrumentos</option>
                        <?php
                        foreach ($instrumentos as $instrumento) {
                            $id = htmlspecialchars($instrumento['ID_INSTRUMENTO'], ENT_QUOTES, 'UTF-8');
                            $nombre = htmlspecialchars($instrumento['VCH_NOMBRE_INSTRUMENTO'], ENT_QUOTES, 'UTF-8');
                            echo "<option value='$id'>$nombre</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <div id="listado-musicos">
            <?php
            if (isset($_GET['instrumento']) && $_GET['instrumento'] !== '') {
                include('../controller/listMusicianController.php');
            }
            ?>
        </div>
    </div>
</body>

</html>