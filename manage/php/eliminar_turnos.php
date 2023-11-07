<?php
require_once('main.php');

$conn = con();
$inicio = $_POST['inicio'];//formato para guardar en la bd tipo date
$fin = $_POST['fin'];//formato para guardar en la bd tipo date
$no_error = true;//respuesta form-rest

// Verificar si ya existen registros para el rango de fechas
$existeRegistro = $conn->prepare("SELECT COUNT(*) as count FROM turno WHERE (turno_fecha BETWEEN :inicio AND :fin) AND turno_estado > 0");
$existeRegistro->bindParam(':inicio', $inicio);
$existeRegistro->bindParam(':fin', $fin);
$existeRegistro->execute();
$result = $existeRegistro->fetch(PDO::FETCH_ASSOC);

if ($result['count'] > 0) {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pueden eliminar los turnos mientras existan reservas registradas en este rango de fechas
    </div>';
    exit();
    } else {

    // Definir el rango de fechas
    $fechaInicio = new DateTime($inicio); // formatear fecha para iterar
    $fechaFin = new DateTime($fin); // formatear fecha para iterar

    try{
        // Bucle para cada día en el rango de fechas
        while ($fechaInicio <= $fechaFin) {
            $diaSemana = $fechaInicio->format('l'); // Obtener el día de la semana
            if ($diaSemana !== 'Sunday') { // Omitir domingo

                    
                    // Insertar los datos en la base de datos (ajusta la sentencia según tu estructura de tabla)
                    $sql = $conn->prepare("DELETE FROM turno WHERE turno_fecha = :fecha");

                    $marcadores=[
                        ":fecha" => $fechaInicio->format('Y-m-d'),//guardar en la bd formato date
                    ];

                    $sql->execute($marcadores);
                    
                }

            $fechaInicio->modify('+1 day'); // Avanzar al siguiente día
        }

        $conn=null;
    } catch(PDOException $e) {
        $no_error = false;
        //echo "Error: " . $e->getMessage(); // Manejo de errores con excepciones PDO
    }
}

if($no_error){// turno nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Turnos eliminados!</strong><br>
        Los Turnos se eliminaron exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo eliminar los turnos, inténtelo nuevamente.
    </div>';
}