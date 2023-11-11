<?php
require_once "../../inc/session_start.php";
require_once "../main.php";

$id=limpiar_cadena($_POST['ser_id']);

// verificar el usuario
$check_ser=conexion();
$check_ser=$check_ser->query("SELECT * FROM seriales WHERE ser_codigo='$id'");

if ($check_ser->rowCount()<=0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el serial no existe en el sistema
        </div>
        ';
        exit();
}else {
    $datos=$check_ser->fetch();
}
$check_ser=null;
$ser_nombre=limpiar_cadena($_POST['ser_nombre']);
$ser_ano_dep=limpiar_cadena($_POST['ser_ano_dep']);
$ser_ano_arch=limpiar_cadena($_POST['ser_ano_arch']);
$sel_depen=limpiar_cadena($_POST['sel_depen']);

if (isset($_POST["ser_estado"])) {
    $ser_estado = 1;
} else {
$ser_estado = 0;
}
if ($ser_nombre=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

$actualizar_ser=conexion();
$actualizar_ser=$actualizar_ser->prepare("UPDATE seriales SET ser_nombre=:nombre,ser_estado=:estado,ser_ano_dep=:ano_dep,ser_ano_arch=:ano_arch,ser_depen=:sel_depen WHERE ser_codigo=:id");
   
$marcadores=[
   ":nombre"=>$ser_nombre,
   ":estado"=>$ser_estado,
   ":ano_dep"=>$ser_ano_dep,
   ":ano_arch"=>$ser_ano_arch,
   ":id"=>$id,
   ":sel_depen"=>$sel_depen
];
if ($actualizar_ser->execute($marcadores)) {
   echo '
       <div class="notification is-info is-light">
           <strong>¡SERIAL ACTUALIZADO!</strong><br>
                el serial se actualizo con exito
       </div>
       ';
}else {
   echo '
   <div class="notification is-danger is-light">
       <strong>¡Ocurrio un error inesperado!</strong><br>
       No se pudo actualizar el serial, por favor intente nuevamente
   </div>
   ';
}
$actualizar_usuario=null;



?>