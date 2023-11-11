<?php
require_once "../main.php";
$detalle=conexion();
//almacenando datos
$nombre=limpiar_cadena($_POST['usuario_nombre']);
$apellido=limpiar_cadena($_POST['usuario_apellido']);
$usuario=limpiar_cadena($_POST['usuario_usuario']);
$email=limpiar_cadena($_POST['usuario_email']);
$clave_1=limpiar_cadena($_POST['usuario_clave_1']);
$clave_2=limpiar_cadena($_POST['usuario_clave_2']);

//verificando campo obligatorios
if ($nombre=="" || $apellido=="" || $usuario=="" || $clave_1=="" || $clave_2=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

//verificando integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el NOMBRE no coincide con el formato solicitado
        </div>
        ';
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el APELLIDO no coincide con el formato solicitado
        </div>
        ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el USUARIO no coincide con el formato solicitado
        </div>
        ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            las CLAVES no coincide con el formato solicitado
        </div>
        ';
    exit();
}

//verificando el email
if ($email!="") {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $detalle=$detalle->query("SELECT usu_clave FROM usuarios WHERE usu_clave='$email'");
        if ($detalle->rowCount()>0) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    el email ingresado ya se encuentra registrado, por favor ingresar otro
                </div>
            ';
            exit();
        }
    }else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                el EMAIL no es valido
            </div>
        ';
    exit();
    }
    $detalle=null;
}

//verificando usuario
$detalle=conexion();
$detalle=$detalle->query("SELECT usu_usuario FROM usuarios WHERE usu_usuario='$usuario'");
if ($detalle->rowCount()>0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el usuario ingresado ya se encuentra registrado, por favor ingresar otro
        </div>
    ';
    exit();
}

//verificando las claves
if ($clave_1!=$clave_2) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            las claves no coinciden
        </div>
    ';
    exit();
}else {
    $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
}

//guardando datos
$detalle=conexion();
$detalle=$detalle->prepare("INSERT INTO usuarios(usu_nombre,usu_apellido,usu_usuario,usu_correo,usu_clave) VALUES(:nombre,:apellido,:usuario,:email,:clave)");

$marcadores=[
    ":nombre"=>$nombre,
    ":apellido"=>$apellido,
    ":usuario"=>$usuario,
    ":email"=>$email,
    ":clave"=>$clave
];
$detalle->execute($marcadores);

if($detalle->rowCount()==1){
    echo '
        <div class="notification is-info is-light">
            <strong>¡usuario registrado!</strong><br>
            El usuario se registro con exito
        </div>
    ';
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el usuario, por favor intente nuevamente
        </div>
    ';
}
$detalle=null;