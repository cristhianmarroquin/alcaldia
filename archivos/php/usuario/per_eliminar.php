<?php
$psm_codigo_del=limpiar_cadena($_GET['psm_codigo_del']);

//verificando usuario
$check_usuario=conexion();
$check_usuario=$check_usuario->query("SELECT psm_codigo FROM persumo WHERE psm_codigo='$psm_codigo_del' ");
if ($check_usuario->rowCount()==1) {

        $eliminar_usuario=conexion();
        $eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM persumo WHERE psm_codigo=:codigo");
        $eliminar_usuario->execute([":codigo"=>$psm_codigo_del]);

        if ($eliminar_usuario->rowCount()==1) {
            echo '
            <div class="notification is-info is-light">
                <strong>¡usuario eliminado!</strong><br>
                los datos del perfil se eliminaron con exito
            </div>
            ';
        }else {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                no se puede eliminar el perfil, porfavor intente nuevamente
            </div>
            '; 
        }
        $eliminar_usuario=null;
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el perfil que intenta eliminar no existe
        </div>
        ';
}

$check_usuario=null;
echo '<meta http-equiv=refresh content="1;index.php?vista=usuario/per_new">';