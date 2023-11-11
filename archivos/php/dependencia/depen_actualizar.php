<?php
require_once "../../inc/session_start.php";
require_once "../main.php";

$id=limpiar_cadena($_POST['dep_id']);
// verificar el usuario
$check_depen=conexion();
$check_depen=$check_depen->query("SELECT * FROM dependencias WHERE dep_codigo='$id'");

if ($check_depen->rowCount()<=0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            la dependencia no existe en el sistema
        </div>
        ';
        exit();
}else {
    $datos=$check_depen->fetch();
}
$check_depen=null;
$dep_nombre=limpiar_cadena($_POST['dep_nombre']);
if (isset($_POST["dep_estado"])) {
    $dep_estado = 1;
} else {
$dep_estado = 0;
}
if ($dep_nombre=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

$actualizar_dep=conexion();
$actualizar_dep=$actualizar_dep->prepare("UPDATE dependencias SET dep_nombre=:nombre,dep_estado=:estado WHERE dep_codigo=:id");
   
$marcadores=[
   ":nombre"=>$dep_nombre,
   ":estado"=>$dep_estado,
   ":id"=>$id
];
if ($actualizar_dep->execute($marcadores)) {
   echo '
       <div class="notification is-info is-light">
           <strong>¡DEPENDENCIA ACTUALIZADO!</strong><br>
                la dependencia se actualizo con exito
       </div>
       ';
}else {
   echo '
   <div class="notification is-danger is-light">
       <strong>¡Ocurrio un error inesperado!</strong><br>
       No se pudo actualizar la dependencia, por favor intente nuevamente
   </div>
   ';
}
$actualizar_usuario=null;



?>