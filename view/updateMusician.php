<?php
require_once('../Model/ModelCRUDSimuladorMusico.php');
$objSim = new ModelCRUDSimuladorMusico();

$musicos = $objSim->getAllMusicians();
$instrumentos = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rut'])) {
    $selectedRut = $_POST['rut'];
    $instrumentos = $objSim->getInstrumentsByMusician($selectedRut);
} else {
    $selectedRut = '';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Músico</title>
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
        <h2 class="mb-4">Actualizar Músico</h2>
        <form action="updateMusician.php" method="POST">
            <div class="mb-3">
                <label for="rut" class="form-label">Selecciona un músico:</label>
                <select class="form-select" id="rut" name="rut" onchange="this.form.submit()">
                    <option value="">Seleccionar músico</option>
                    <?php foreach ($musicos as $musico) : ?>
                        <option value="<?= htmlspecialchars($musico['RUT_MUSICO'], ENT_QUOTES, 'UTF-8') ?>" <?= $selectedRut == $musico['RUT_MUSICO'] ? 'selected' : '' ?>><?= htmlspecialchars($musico['VCH_NOMBRE_MUSICO'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if (!empty($selectedRut) && !empty($instrumentos)) : ?>
            <form action="../controller/updateMusicianController.php" method="POST">
                <input type="hidden" name="rut" value="<?= htmlspecialchars($selectedRut, ENT_QUOTES, 'UTF-8') ?>">
                <div class="mb-3">
                    <label for="instrument_id" class="form-label">Selecciona un instrumento:</label>
                    <select class="form-select" id="instrument_id" name="instrument_id">
                        <?php foreach ($instrumentos as $instrumento) : ?>
                            <option value="<?= htmlspecialchars($instrumento['ID_INSTRUMENTO'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($instrumento['VCH_NOMBRE_INSTRUMENTO'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nuevo nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="years_experience" class="form-label">Nuevos años de experiencia:</label>
                    <input type="number" class="form-control" id="years_experience" name="years_experience" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        <?php elseif (!empty($selectedRut)) : ?>
            <p>No hay instrumentos asociados a este músico.</p>
        <?php endif; ?>
    </div>
</body>

</html>