<?php
//Define los roles y accesos
//cada rol contiene las vistas prohibidas
$roles = [
  1 => [], // admin
  2 => [], // encargado
  3 => [], // empleado
  4 => ['servicio_new', 'servicio_list', 'servicio_search', 'servicio_update', 'horario_new', 'horario_list', 'horario_update', 'reserva_new', 'reserva_list', 'reserva_search', 'reserva_update', 'cliente_new', 'cliente_list', 'cliente_search', 'cliente_update', 'mimadito_list', 'raza_new', 'raza_list', 'raza_search', 'raza_update', 'tipo_new', 'tipo_list', 'tipo_search', 'tipo_update', 'user', 'user_new', 'user_list', 'user_search', 'user_update']
];

//Verificar el acceso
function check_rol($vista, $rol) {
  global $roles;
  //si el rol y la vista exis
  if (array_key_exists($rol, $roles) && in_array($vista, $roles[$rol])) {

      //si la vista está incluida en la lista de prohibidos    
      // El usuario no tiene permiso para acceder a la vista
      echo '
      <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Atención!</h4>
        <p>No tiene permisos para acceder a esta página.</p>
        <hr>
    </div>
      ';
      include("./inc/btn_back.php");
      exit();
  } else {
    // El usuario tiene permiso para acceder a la vista
    return true;
  }
}
