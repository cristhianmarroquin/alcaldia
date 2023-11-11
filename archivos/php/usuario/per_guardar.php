<?php
require_once "../main.php";
$detalle=conexion();
//almacenando datos
$psm_usuario=limpiar_cadena($_POST['per_usu']);
$psm_modulos=limpiar_cadena($_POST['per_mod']);
$psm_perfil=limpiar_cadena($_POST['per_perfil']);

//verificando campo obligatorios
if ($psm_usuario=="" || $psm_modulos=="" || $psm_perfil=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}
$per_usu = conexion();
$per_usu = $per_usu->query("SELECT * FROM persumo where psm_usu = '$psm_usuario' and psm_mod = $psm_modulos and psm_per = $psm_perfil");
if ($per_usu->rowCount()>0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el pefil ya se encuentra asignado, para este usuario
        </div>
        ';
    exit();
}

//guardando datos
$detalle=conexion();
$detalle=$detalle->prepare("INSERT INTO persumo(psm_usu,psm_mod,psm_per) VALUES(:psm_usuario,:psm_modulos,:psm_perfil)");
$marcadores=[
    ":psm_usuario"=>$psm_usuario,
    ":psm_modulos"=>$psm_modulos,
    ":psm_perfil"=>$psm_perfil
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
echo '<meta http-equiv=refresh content="1;index.php?vista=usuario/per_new">';