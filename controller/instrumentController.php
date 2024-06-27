<?php
$instrument_name = $_POST['instrument_name'];

if (empty($instrument_name)) {
    echo "No se ha ingresado el nombre del instrumento, intente nuevamente";
    return;
}

if (preg_match('/\s/', $instrument_name)) {
    echo "El nombre no puede contener espacios en blanco.";
    return;
}

include('../Model/ModelCRUDSimuladorMusico.php');

$objSim = new ModelCRUDSimuladorMusico();

if ($objSim->instrumentExists($instrument_name)) {
    echo "El instrumento ya existe";
} else {
    if ($objSim->insertInstrument($instrument_name)) {
        echo "Registro exitoso. El nombre del instrumento ingresado es: $instrument_name";
    } else {
        echo "Error en el registro";
    }
}
