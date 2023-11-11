<?php
require_once "../../inc/session_start.php";
require_once "../main.php";

$id=limpiar_cadena($_POST['usu_usuario']);

// verificar el usuario
$datos=array();
$check_usuario=conexion();
$check_usuario=$check_usuario->query("SELECT * FROM usuarios WHERE usu_usuario='$id'");
$datos=$check_usuario->fetch();
if ($check_usuario->rowCount()<=0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el usuario no existe en el sistema
        </div>
        ';
        exit();
}else {
    
}
$check_usuario=null;

$admin_usuario=limpiar_cadena($_POST['administrador_usuario']);
$admin_clave=limpiar_cadena($_POST['administrador_clave']);

//verificando campo obligatorios
if ($admin_usuario=="" || $admin_clave=="" ) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios, que corresponden a su USUARIO y CLAVE.
        </div>
        ';
    exit();
}

//verificando integridad de los datos
if (verificar_datos("[a-zA-Z0-9]{4,20}",$admin_usuario)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            su USUSARIO no coincide con el formato solicitado
        </div>
        ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            su CLAVE no coincide con el formato solicitado
        </div>
        ';
    exit();
}

//verificando el admin
$check_admin=conexion();
$check_admin=$check_admin->query("SELECT usu_usuario,usu_clave FROM usuarios WHERE usu_usuario='$admin_usuario' AND usu_codigo='".$_SESSION['id']."'");

if ($check_admin->rowCount()==1) {
    $check_admin=$check_admin->fetch();

    if ($check_admin['usu_usuario']!=$admin_usuario || !password_verify($admin_clave,$check_admin['usu_clave'])) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            USUARIO o CLAVE de administrdor incorrectos
        </div>
        ';
    exit(); 
    }
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            USUARIO o CLAVE de administrdor incorrectos
        </div>
        ';
    exit();
}
$check_admin=null;

//almacenando datos
$nombre=limpiar_cadena($_POST['usuario_nombre']);
$apellido=limpiar_cadena($_POST['usuario_apellido']);
$usuario=limpiar_cadena($_POST['usu_usuario']);
$email=limpiar_cadena($_POST['usuario_email']);
$dependencia=limpiar_cadena($_POST['usu_depen']);
$lider=limpiar_cadena($_POST['usu_lider']);
$clave_1=limpiar_cadena($_POST['usuario_clave_1']);
$clave_2=limpiar_cadena($_POST['usuario_clave_2']);

//verificando campo obligatorios
if ($nombre=="" || $apellido=="" || $usuario=="" || $dependencia=="") {
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

//verificando el email
if ($email!="") {
    if ($email!=$datos['usu_correo']) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $detalle=conexion();
            $detalle=$detalle->query("SELECT usu_correo FROM usuarios WHERE usu_correo='$email'");
            if ($detalle->rowCount()>0) {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        el email ingresado ya se encuentra registrado, por favor ingresar otro
                    </div>
                ';
                exit();
            }
        }
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

    //verificando usuario
// if($usuario!=$datos['usu_usuario']){
//     $detalle=conexion();
//     $detalle=$detalle->query("SELECT usu_usuario FROM usuarios WHERE usu_usuario='$usuario'");
//     if ($detalle->rowCount()>0) {
//         echo '
//             <div class="notification is-danger is-light">
//                 <strong>¡Ocurrio un error inesperado!</strong><br>
//                 el usuario ingresado ya se encuentra registrado, por favor ingresar otro
//             </div>
//         ';
//         exit();
//     }
//     $detalle=null;
// }

//verificando las claves
if ($clave_1!="" || $clave_2!="") {
    if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                las CLAVES no coincide con el formato solicitado
            </div>
            ';
        exit();
    }else {
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
    }
}else {
    $clave=$datos['usu_clave'];
}
if (isset($_POST["usu_lider"])) {
    $lider = 1;
} else {
$lider = 0;
}
 //actualizar datos
 $actualizar_usuario=conexion();
 $actualizar_usuario=$actualizar_usuario->prepare("UPDATE usuarios SET usu_nombre=:nombre,usu_apellido=:apellido,usu_correo=:email,usu_depen=:dependencia,usu_lider=:lider,usu_clave=:clave WHERE usu_usuario=:id");
    
 $marcadores=[
    ":nombre"=>$nombre,
    ":apellido"=>$apellido,
    ":email"=>$email,
    ":dependencia"=>$dependencia,
    ":lider"=>$lider,
    ":clave"=>$clave,
    ":id"=>$id
];
// print_r($marcadores);

if ($actualizar_usuario->execute($marcadores)) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡USUARIO ACTUALIZADO!</strong><br>
            el usuario se actualizo con exito
        </div>
        ';
}else {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se pudo actualizar el usuario, por favor intente nuevamente
    </div>
    ';
}
$actualizar_usuario=null;