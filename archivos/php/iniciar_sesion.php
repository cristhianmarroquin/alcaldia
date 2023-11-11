<?php
//almacenando datos
$usuario=limpiar_cadena($_POST['login_usuario']);
$clave=limpiar_cadena($_POST['login_clave']);

//verificando campo obligatorios
if ($usuario=="" || $clave=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

//verificando integridad de los datos
if (verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el USUARIO no coincide con el formato solicitado
        </div>
        ';
    exit();
}
if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            la CLAVE no coincide con el formato solicitado
        </div>
        ';
    exit();
}

$detalle=conexion();
$detalle=$detalle->query("SELECT * FROM usuarios WHERE 	usu_usuario='$usuario'");

if ($detalle->rowCount()==1) {
    $detalle=$detalle->fetch();

    if ($detalle['usu_usuario']==$usuario && password_verify($clave,$detalle['usu_clave'])) {
        
        $_SESSION['id']=$detalle['usu_codigo'];
        $_SESSION['nombre']=$detalle['usu_nombre'];
        $_SESSION['apellido']=$detalle['usu_apellido'];
        $_SESSION['usuario']=$detalle['usu_usuario'];
        $_SESSION['dependencia']=$detalle['usu_depen'];
        $_SESSION['lider']=$detalle['usu_lider'];

        if (headers_sent()) {
            echo "<script>window.location.href='index.php?vista=home';
            </script>";
        }else {
            header("Location: index.php?vista=home");
        }

    }else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            usuario o clave incorrectos1
        </div>
        '; 
    }
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            usuario o clave incorrectos2
        </div>
        ';
}
$detalle=null;