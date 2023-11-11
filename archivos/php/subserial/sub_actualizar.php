<?php
require_once "../../inc/session_start.php";
require_once "../main.php";

$id=limpiar_cadena($_POST['sub_id']); 

// verificar el usuario
$check_sub=conexion();
$check_sub=$check_sub->query("SELECT * FROM subseries WHERE sub_codigo='$id'");

if ($check_sub->rowCount()<=0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el subserial no existe en el sistema
        </div>
        ';
        exit();
}else {
    $datos=$check_sub->fetch();
}
$check_sub=null;
$sub_nombre=limpiar_cadena($_POST['sub_nombre']);
$sel_ser=limpiar_cadena($_POST['sel_ser']);

if (isset($_POST["sub_estado"])) {
    $sub_estado = 1;
} else {
$sub_estado = 0;
}
if ($sub_nombre=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

$actualizar_sub=conexion();
$actualizar_sub=$actualizar_sub->prepare("UPDATE subseries SET sub_nombre=:nombre,sub_estado=:estado,sub_serial=:sel_ser WHERE sub_codigo=:id");
   
$marcadores=[
   ":nombre"=>$sub_nombre,
   ":estado"=>$sub_estado,
   ":id"=>$id,
   ":sel_ser"=>$sel_ser
];
if ($actualizar_sub->execute($marcadores)) {
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