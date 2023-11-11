<?php
$user_codigo_del=limpiar_cadena($_GET['ser_codigo_del']);

//verificando usuario
$check_usuario=conexion();
$check_usuario=$check_usuario->query("SELECT ser_codigo FROM seriales WHERE ser_codigo='$user_codigo_del' ");
if ($check_usuario->rowCount()==1) {

    //verificando usuario
    $check_documento=conexion();
    $check_documento=$check_documento->query("SELECT dep_id FROM documentos WHERE dep_id='$user_codigo_del' LIMIT 1");

    if ($check_documento->rowCount()<=0) {
        $eliminar_usuario=conexion();
        $eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM dependencia WHERE dep_codigo=:codigo");
        $eliminar_usuario->execute([":codigo"=>$user_codigo_del]);

        if ($eliminar_usuario->rowCount()==1) {
            echo '
            <div class="notification is-info is-light">
                <strong>¡usuario eliminado!</strong><br>
                los datos del usuario se eliminaron con exito
            </div>
            ';
        }else {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                no se puede eliminar el usuario, porfavor intente nuevamente
            </div>
            '; 
        }
        $eliminar_usuario=null;
    }else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            no podemos eliminar el usuario ya que tiene documentos realizados
        </div>
        ';
    }
    $check_documento=null;
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el usuario que intenta eliminar no existe
        </div>
        ';
}

$check_usuario=null;