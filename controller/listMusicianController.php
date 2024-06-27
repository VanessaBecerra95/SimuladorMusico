<?php
require_once('../Model/ModelCRUDSimuladorMusico.php');

$instrumento_id = isset($_GET['instrumento']) ? $_GET['instrumento'] : '';

if ($instrumento_id === '') {
    header("Location: ../view/listMusician.php?error=1");
    exit();
}

$objSim = new ModelCRUDSimuladorMusico();
$musicos = $objSim->getMusiciansByInstrument($instrumento_id);

if (empty($musicos)) {
    echo "<p>No se encontraron músicos para el instrumento seleccionado.</p>";
} else {
    echo "<h4>Músicos encontrados:</h4>";
    echo "<ul class='list-group'>";
    foreach ($musicos as $musico) {
        echo "<li class='list-group-item'>{$musico['VCH_NOMBRE_MUSICO']} - {$musico['VCH_NOMBRE_INSTRUMENTO']} ({$musico['INT_ANOS_EXPERIENCIA']} años de experiencia)</li>";
    }
    echo "</ul>";
}
