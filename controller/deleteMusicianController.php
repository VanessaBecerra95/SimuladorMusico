<?php
include('../Model/ModelCRUDSimuladorMusico.php');

$rut = $_POST['rut'];
$objSim = new ModelCRUDSimuladorMusico();
$message = $objSim->deleteMusicianIfNoInstruments($rut);

echo $message;
?>
