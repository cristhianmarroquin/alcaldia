<?php
require_once "../../../php/main.php";
$detalle=conexion();
//almacenando datos
$tip_codigo=limpiar_cadena($_POST['tip_codigo']);
$tip_nombre=limpiar_cadena($_POST['tip_nombre']);
$sel_subser=limpiar_cadena($_POST['sel_subser']);

//verificando campo obligatorios
if ($tip_codigo=="" || $tip_nombre=="" || $sel_subser=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

//verificando integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}",$tip_nombre)) {
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
$detalle=$detalle->query("SELECT tip_subser FROM tiposubser WHERE tip_codigo='$tip_codigo'");
if ($detalle->rowCount()>0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el subserial ingresado ya se encuentra registrado, por favor ingresar otro
        </div>
    ';
    exit();
}

//guardando datos
$detalle=conexion();
$detalle=$detalle->prepare("INSERT INTO tiposubser(tip_codigo,tip_nombre,tip_subser) VALUES(:tip_codigo,:tip_nombre,:sel_subser)");
$marcadores=[
    ":tip_codigo"=>$tip_codigo,
    ":tip_nombre"=>$tip_nombre,
    ":sel_subser"=>$sel_subser
];
$detalle->execute($marcadores);

if($detalle->rowCount()==1){
    echo '
        <div class="notification is-info is-light">
            <strong>¡Dependencia registrada!</strong><br>
            el subserial se registro con exito
        </div>
    ';
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el subserial, por favor intente nuevamente
        </div>
    ';
}
$detalle=null;