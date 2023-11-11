<?php
require_once "../main.php";
$detalle=conexion();
//almacenando datos
$sub_codigo=limpiar_cadena($_POST['sub_codigo']);
$sub_nombre=limpiar_cadena($_POST['sub_nombre']);
$sel_ser=limpiar_cadena($_POST['sel_ser']);

//verificando campo obligatorios
if ($sub_codigo=="" || $sub_nombre=="" || $sel_ser=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

//verificando integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}",$sub_nombre)) {
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
$detalle=$detalle->query("SELECT sub_codigo FROM subseries WHERE sub_codigo='$sub_codigo'");
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
$detalle=$detalle->prepare("INSERT INTO subseries(sub_codigo,sub_nombre,sub_serial) VALUES(:sub_codigo,:sub_nombre,:sel_ser)");
$marcadores=[
    ":sub_codigo"=>$sub_codigo,
    ":sub_nombre"=>$sub_nombre,
    ":sel_ser"=>$sel_ser
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