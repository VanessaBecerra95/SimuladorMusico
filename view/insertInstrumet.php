<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Instrumentos</title>
    <link rel="stylesheet" href="">
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
                            <a class="nav-link text-white" href="./insertMusician.php">Insertar Músico</a>
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
    <section class="container py-5 mx-auto text-center">
    <h3 class="text-black">Registro de instrumentos</h3>
    <div class="card py-5 px-5 mx-auto" style="max-width: 600px;">
        <form action="../controller/instrumentController.php" method="post">
            <div class="form-group">
                <label for="instrument_name" class="form-label">Nombre del instrumento</label>
                <input type="text" class="form-control" id="instrument_name" name="instrument_name">
            </div>
            <button type="submit" class="btn btn-outline-dark mt-4">Agregar Instrumento</button>
        </form>
    </div>
</section>
</body>

</html>