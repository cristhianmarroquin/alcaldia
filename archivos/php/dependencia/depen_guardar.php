<?php
require_once "../main.php";
$detalle=conexion();
//almacenando datos
$dep_codigo=limpiar_cadena($_POST['depen_codigo']);
$dep_nombre=limpiar_cadena($_POST['depen_nombre']);

//verificando campo obligatorios
if ($dep_codigo=="" || $dep_nombre=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

//verificando integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}",$dep_nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el NOMBRE no coincide con el formato solicitado
        </div>
        ';
    exit();
}

//verificando usuario
$detalle=conexion();
$detalle=$detalle->query("SELECT dep_codigo FROM dependencias WHERE dep_codigo='$dep_codigo'");
if ($detalle->rowCount()>0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            la dependencia ingresada ya se encuentra registrada, por favor ingresar otra
        </div>
    ';
    exit();
}

//guardando datos
$detalle=conexion();
$detalle=$detalle->prepare("INSERT INTO dependencias(dep_codigo,dep_nombre) VALUES(:dep_codigo,:dep_nombre)");
$marcadores=[
    ":dep_codigo"=>$dep_codigo,
    ":dep_nombre"=>$dep_nombre
];
$detalle->execute($marcadores);

if($detalle->rowCount()==1){
    echo '
        <div class="notification is-info is-light">
            <strong>¡Dependencia registrada!</strong><br>
            la dependencia se registro con exito
        </div>
    ';
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar la dependencia, por favor intente nuevamente
        </div>
    ';
}
$detalle=null;