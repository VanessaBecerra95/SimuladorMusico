<?php
require_once('../Model/ModelCRUDSimuladorMusico.php');

$rut = $_POST['rut'];
$newName = $_POST['name'];
$instrument_id = $_POST['instrument_id'];
$newYearsExperience = $_POST['years_experience'];

$objSim = new ModelCRUDSimuladorMusico();
$success = $objSim->updateMusician($rut, $newName, $instrument_id, $newYearsExperience);

if ($success) {
    echo "El músico ha sido actualizado satisfactoriamente.";
} else {
    echo "Error al actualizar el músico.";
}
?>
