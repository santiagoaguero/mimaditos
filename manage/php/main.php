<?php
//conexion a la bd

date_default_timezone_set("America/Asuncion");

function con (){
    $pdo = new PDO("mysql: host=localhost;dbname=reservet", "root", "");//dbtype: host,dbname,user,pas
    return $pdo;
}


//verificar datos
function verificar_datos($filtro, $cadena){
    if(preg_match("/^".$filtro."$/", $cadena)){
        return false;
    } else {
        return true;
    }
}


//limpiar cadenas de texto y evitar inyecciones no deseadas-xss
function limpiar_cadena($cadena){

    //busca y elimina posibles scripts de inyecciones
	$cadena=str_ireplace("<script>", "", $cadena);
	$cadena=str_ireplace("</script>", "", $cadena);
	$cadena=str_ireplace("<script src", "", $cadena);
	$cadena=str_ireplace("<script type=", "", $cadena);
	$cadena=str_ireplace("SELECT * FROM", "", $cadena);
	$cadena=str_ireplace("DELETE FROM", "", $cadena);
	$cadena=str_ireplace("INSERT INTO", "", $cadena);
	$cadena=str_ireplace("DROP TABLE", "", $cadena);
	$cadena=str_ireplace("DROP DATABASE", "", $cadena);
	$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
	$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
	$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
	$cadena=str_ireplace("<?php", "", $cadena);
	$cadena=str_ireplace("?>", "", $cadena);
	$cadena=str_ireplace("--", "", $cadena);
	$cadena=str_ireplace("^", "", $cadena);
	$cadena=str_ireplace("<", "", $cadena);
	$cadena=str_ireplace("[", "", $cadena);
	$cadena=str_ireplace("]", "", $cadena);
	$cadena=str_ireplace("==", "", $cadena);
	$cadena=str_ireplace(";", "", $cadena);
	$cadena=str_ireplace("::", "", $cadena);

    $cadena = trim($cadena);//elimina espacios en blanco al inicio y/o fin
    $cadena = stripslashes($cadena);//elimina barras

	return $cadena;
	}


//renombrar fotos
function renombrar_fotos($nombre){
    $nombre = str_ireplace(" ", "_", $nombre);
    $nombre = str_ireplace("/", "_", $nombre);
    $nombre = str_ireplace("#", "_", $nombre);
    $nombre = str_ireplace("-", "_", $nombre);
    $nombre = str_ireplace("$", "_", $nombre);
    $nombre = str_ireplace(".", "_", $nombre);
    $nombre = str_ireplace(",", "_", $nombre);
    $nombre = $nombre."_".rand(0,1000);

    return $nombre;
}


//paginacion
function paginador($pagina, $Npaginas, $url, $botones){
	$tabla='
			<nav aria-label="Page navigation example">
			';
	if($pagina<=1){//primera pagina
		$tabla.='	
				<ul class="pagination justify-content-center">
					<li class=" disabled">
						<a class="page-link ">Anterior</a>
					</li>
				';
	}else{
		$tabla.='
				<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" href="'.$url.($pagina-1).'">Anterior</a>
				</li>

				<li class="page-item">
					<a class="page-link" href="'.$url.'1">1</a>
				</li>
				<li class="page-item">
					<span class="page-ellipsis">...</span>
				</li>
				';
	}

	$ci=0;//contador de paginas
	for($i=$pagina; $i<=$Npaginas; $i++){
		if($ci>=$botones){
			break;
		}
		if($pagina==$i){
			$tabla.='
					<li class="page-item">
						<a class="page-link active" href="'.$url.$i.'">'.$i.'</a>
					</li>';
		}else{
			$tabla.='
					<li class="page-item">
						<a class="page-link" href="'.$url.$i.'">'.$i.'</a>
					</li>';
		}
		$ci++;
	}

	if($pagina==$Npaginas){//ultima pagina
		$tabla.='
				<li class="page-item">
					<a class="page-link disabled ">Siguiente</a>
				</li>
		';
	}else{
		$tabla.='
				<li class="page-item">
					<span class="page-ellipsis">...</span>
				</li>
				<li class="page-item">
					<a class="page-link" href="'.$url.$Npaginas.'">'.$Npaginas.'</a>
				</li>
				<li class="page-item">
					<a class="page-link" href="'.$url.($pagina+1).'" >Siguiente</a>
				</link>
			';
	}

	$tabla.='
			</ul>
		</nav>';
	return $tabla;
}