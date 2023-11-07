<?php
    require_once("main.php");

    $data = json_decode(file_get_contents('php://input'), true);

    // capturar la fecha seleccionada del objeto JSON enviado desde JavaScript
    //cambiar formato fecha
    $fechaSeleccionada = strtotime($data['fechaSeleccionada']);
    //formatea la fecha en el formato DD-MM-YYYY
    $fecha = date("Y-m-d", $fechaSeleccionada);
    
    $horario = con();
    $horario = $horario->query("SELECT * FROM horario WHERE horario_id NOT IN (SELECT horario_id FROM reserva WHERE reserva_fecha = '$fecha' AND reserva_estado = 1) ORDER BY horario_posicion ASC");
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