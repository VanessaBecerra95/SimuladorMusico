<?php

include('../Model/ModelCRUDSimuladorMusico.php');


$instrumentModel = new ModelCRUDSimuladorMusico();
$instruments = $instrumentModel->getAllInstruments();
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Músico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                            <a class="nav-link text-white" href="./insertInstrumet.php">Insertar Instrumentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./mainView.php">Editar Músico</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./listMusician.php">Listar Músicos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="container-fluid px-1 py-5 mx-auto">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                <h3 class="text-black">Registro de Músico</h3>
                <div class="card py-5 px-5 mx-auto">
                    <form action="../controller/musicianController.php" method="post">
                        <div class="row justify-content-between mb-3">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="rut" class="form-label">Rut del músico sin código verificador</label>
                                <input type="number" class="form-control" id="rut" name="rut">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="name" class="form-label">Nombre del músico</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                        <div class="row justify-content-between mb-3">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="years_experience" class="form-label">Años de experiencia</label>
                                <input type="number" class="form-control" id="years_experience" name="years_experience">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="instrument" class="form-label">Instrumento</label>
                                <select class="form-control" id="instrument" name="instrument">
                                    <?php foreach ($instruments as $instrument) : ?>
                                        <option value="<?php echo $instrument['ID_INSTRUMENTO']; ?>"><?php echo $instrument['VCH_NOMBRE_INSTRUMENTO']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center pt-4">
                            <div class="form-group col-sm-6">
                                <button type="submit" class="btn btn-outline-dark">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>