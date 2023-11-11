<?php
require_once "../../../inc/session_start.php";
require_once "../../../php/main.php";

$id=limpiar_cadena($_POST['tip_id']); 

// verificar el usuario
$check_tip=conexion();
$check_tip=$check_tip->query("SELECT * FROM tiposubser WHERE tip_codigo='$id'");

if ($check_tip->rowCount()<=0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el subserial no existe en el sistema
        </div>
        ';
        exit();
}else {
    $datos=$check_tip->fetch();
}
$check_tip=null;
$tip_nombre=limpiar_cadena($_POST['tip_nombre']);
$sel_sub=limpiar_cadena($_POST['sel_sub']);

if (isset($_POST["tip_estado"])) {
    $tip_estado = 1;
} else {
$tip_estado = 0;
}
if ($tip_nombre=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

$actualizar_tip=conexion();
$actualizar_tip=$actualizar_tip->prepare("UPDATE tiposubser SET tip_nombre=:nombre,tip_estado=:estado,tip_subser=:sel_sub WHERE tip_codigo=:id");
   
$marcadores=[
   ":nombre"=>$tip_nombre,
   ":estado"=>$tip_estado,
   ":id"=>$id,
   ":sel_sub"=>$sel_sub
];
$actualizar_tip->execute($marcadores);
if ($actualizar_tip->execute($marcadores)) {
   echo '
       <div class="notification is-info is-light">
           <strong>¡SUBSERIAL ACTUALIZADO!</strong><br>
                el subserial se actualizo con exito
       </div>
       ';
}else {
   echo '
   <div class="notification is-danger is-light">
       <strong>¡Ocurrio un error inesperado!</strong><br>
       No se pudo actualizar el subserial, por favor intente nuevamente
   </div>
   ';
}
$actualizar_usuario=null;



?>