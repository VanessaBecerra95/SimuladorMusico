<?php
include('../Model/ModelCRUDSimuladorMusico.php');

$rut = $_POST['rut'];
$name = $_POST['name'];
$years_experience = $_POST['years_experience'];
$instrument_id = isset($_POST['instrument']) ? $_POST['instrument'] : '';

if (empty($rut) || empty($name) || empty($years_experience) || empty($instrument_id)) {
    if (empty($instrument_id)) {
        echo "Es necesario seleccionar un instrumento de la base de datos.";
    } else {
        echo "Todos los campos son obligatorios.";
    }
    return;
}

if (!is_numeric($rut) || !is_numeric($years_experience)) {
    echo "El rut y los años de experiencia deben ser numéricos.";
    return;
}

if ($years_experience < 0) {
    echo "Los años de experiencia no pueden ser negativos.";
    return;
}

if (preg_match('/\s/', $name)) {
    echo "El nombre no puede contener espacios en blanco.";
    return;
}

$objSim = new ModelCRUDSimuladorMusico();


$instrument = $objSim->getInstrumentById($instrument_id);
if (!$instrument) {
    echo "El instrumento seleccionado no existe. Por favor, registre el instrumento primero.";
    echo "<a href='../view/insertInstrumet.php'>Registrar Instrumento</a>";
    return;
}

$existingMusician = $objSim->getMusicianByRut($rut);

if ($existingMusician) {
    $existingName = trim($existingMusician['VCH_NOMBRE_MUSICO']);
    $providedName = trim($name);

    if (strcasecmp($existingName, $providedName) !== 0) {
        echo "El nombre no coincide con el rut.";
        echo "Nombre en la base de datos: " . htmlspecialchars($existingName);
        echo "Nombre proporcionado: " . htmlspecialchars($providedName);
        return;
    }

    $musicianInstrument = $objSim->getMusicianInstrument($rut, $instrument_id);
    if ($musicianInstrument) {
        echo "El músico ya tiene ese instrumento asociado.";
        return;
    }
}

$respuesta = $objSim->insertMusicianWithInstrument($rut, $name, $years_experience, $instrument_id);
if ($respuesta) {
    echo "Registro exitoso";
} else {
    echo "Error en el registro";
}
