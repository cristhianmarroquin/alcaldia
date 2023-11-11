<?php
require_once "../main.php";
$detalle=conexion();
//almacenando datos
$ser_codigo=limpiar_cadena($_POST['ser_codigo']);
$ser_nombre=limpiar_cadena($_POST['ser_nombre']);
$ser_ano_dep=limpiar_cadena($_POST['ser_ano_dep']);
$ser_ano_arch=limpiar_cadena($_POST['ser_ano_arch']);
$sel_depen=limpiar_cadena($_POST['sel_depen']);

//verificando campo obligatorios
if ($ser_codigo=="" || $ser_nombre=="" || $ser_ano_dep=="" || $ser_ano_arch=="" || $sel_depen=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

//verificando integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}",$ser_nombre)) {
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
$detalle=$detalle->query("SELECT ser_codigo FROM seriales WHERE ser_codigo='$ser_codigo'");
if ($detalle->rowCount()>0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el serial ingresado ya se encuentra registrado, por favor ingresar otro
        </div>
    ';
    exit();
}

//guardando datos
$detalle=conexion();
$detalle=$detalle->prepare("INSERT INTO seriales(ser_codigo,ser_nombre,ser_ano_dep,ser_ano_arch,ser_depen) VALUES(:ser_codigo,:ser_nombre,:ser_ano_dep,:ser_ano_arch,:sel_depen)");
$marcadores=[
    ":ser_codigo"=>$ser_codigo,
    ":ser_nombre"=>$ser_nombre,
    ":ser_ano_dep"=>$ser_ano_dep,
    ":ser_ano_arch"=>$ser_ano_arch,
    ":sel_depen"=>$sel_depen
];
$detalle->execute($marcadores);

if($detalle->rowCount()==1){
    echo '
        <div class="notification is-info is-light">
            <strong>¡Dependencia registrada!</strong><br>
            el serial se registro con exito
        </div>
    ';
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el serial, por favor intente nuevamente
        </div>
    ';
}
$detalle=null;