<?php
require_once('../Model/ModelCRUDSimuladorMusico.php');

if (!isset($_POST['rut']) || !isset($_POST['instrumento'])) {
    header("Location: ../view/deleteInstrument.php?mensaje=Seleccione un músico e instrumento para eliminar.");
    exit();
}

$rut = $_POST['rut'];
$instrumento_id = $_POST['instrumento'];

$objSim = new ModelCRUDSimuladorMusico();

$musicianExists = $objSim->getMusicianByRut($rut);
$hasInstrument = $objSim->musicianHasInstrument($rut, $instrumento_id);

if (!$musicianExists) {
    $mensaje = "El usuario no está registrado.";
} elseif (!$hasInstrument) {
    $mensaje = "No se puede eliminar el instrumento porque el músico no tiene ese instrumento asignado.";
} else {
    $deleted = $objSim->deleteInstrumentFromMusician($rut, $instrumento_id);
    if ($deleted) {
        $mensaje = "Instrumento eliminado correctamente del músico.";
    } else {
        $mensaje = "Error al eliminar el instrumento del músico.";
    }
}

header("Location: ../view/deleteInstrument.php?mensaje=" . urlencode($mensaje));
exit();
