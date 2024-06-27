<?php
require_once('../Model/ModelCRUDSimuladorMusico.php');
$objSim = new ModelCRUDSimuladorMusico();
$musicos = $objSim->getAllMusicians();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Músico</title>
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
                            <a class="nav-link text-white" href="./insertInstrumet.php">Insertar Instrumento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./mainView.php">Editar Músico</a>
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
        <h2 class="mb-4">Eliminar Músico</h2>
        <form action="../controller/deleteMusicianController.php" method="POST">
            <div class="mb-3">
                <label for="rut" class="form-label">Selecciona un músico:</label>
                <select class="form-select" id="rut" name="rut">
                    <option value="">Seleccionar músico</option>
                    <?php foreach ($musicos as $musico) : ?>
                        <option value="<?= htmlspecialchars($musico['RUT_MUSICO'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($musico['VCH_NOMBRE_MUSICO'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</body>

</html>