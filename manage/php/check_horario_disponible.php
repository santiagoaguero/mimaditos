<?php
    require_once("main.php");

    $data = json_decode(file_get_contents('php://input'), true);

    // Obtén la fecha seleccionada del objeto JSON enviado desde JavaScript
    $fechaSeleccionada = $data['fechaSeleccionada'];
    
    $horario = con();
    $horario = $horario->query("SELECT * FROM horario WHERE horario_id NOT IN (SELECT horario_id FROM reserva WHERE reserva_fecha = '$fechaSeleccionada') ORDER BY horario_posicion ASC");
    if ($horario->rowCount() > 0) {
        $horarios_disponibles = array();
    
        foreach ($horario as $row) {
            $horarios_disponibles[] = array(
                'horario_id' => $row['horario_id'],
                'horario_inicio' => $row['horario_inicio'],
                'horario_fin' => $row['horario_fin']
            );
        }
    
        // Genera una respuesta JSON válida
        echo json_encode($horarios_disponibles);
    } else {
        // Si no hay horarios disponibles, puedes devolver un mensaje o un objeto JSON vacío
        echo json_encode(array());
    }