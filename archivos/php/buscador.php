<?php
// ini_set('display_errors', 1);

// ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
$modulo_buscador=limpiar_cadena($_POST['modulo_buscador']);
$modulos=["usuario","dependencia","serial","subserial","documento"];
if (in_array($modulo_buscador,$modulos)) {
    $modulos_url=[
        "usuario"=>"usuario/user_search",
        "dependencia"=>"dependencia/dep_search",
        "serial"=>"serial/ser_search",
        "subserial"=>"subserial/sub_search",
        "documento"=>"documento/doc_search"
    ];
    $modulos_url=$modulos_url[$modulo_buscador];
    $modulo_buscador='busqueda_'.$modulo_buscador;

    //iniciar busqueda
    if (isset($_POST['txt_buscador'])) {
        $txt=limpiar_cadena($_POST['txt_buscador']);
        if ($txt=="") {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                introduce un termino de busqueda
            </div>
            ';
        }else {
            if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$txt)) {
                echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    el termino de busqueda no coincide con el formato solicitado
                </div>
                ';
            }else {
                $_SESSION[$modulo_buscador]=$txt;
                header("Location: index.php?vista=$modulos_url",true,303);
                exit;
            }
        }
    }
    
    //eliminar busqueda
    if (isset($_POST['eliminar_buscador'])) {
        unset($_SESSION[$modulo_buscador]);
        header("Location: index.php?vista=$modulos_url",true,303);
        exit;
    }
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No podemos procesar la peticion
        </div>
        ';
}