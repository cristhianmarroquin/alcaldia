<div class="container is-fluid mb-1">
    <h1 class="title">Dependecia</h1>
    <h2 class="subtitle">Buscar Dependencia</h2>
</div>

<div class="container pb-1 pt-1">
    <?php
    require_once "./php/main.php";

    if (isset($_POST['modulo_buscador'])) {
        require_once "./php/buscador.php";
    }

        if (!isset($_SESSION['busqueda_dependencia']) && empty($_SESSION['busqueda_dependencia'])) {
            
    ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="dependencia">   
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" >Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php }else {?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-2 mb-2" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="dependencia"> 
                <input type="hidden" name="eliminar_buscador" value="dependencia">
                <p>Estas buscando <strong>“<?php echo $_SESSION['busqueda_dependencia'];?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php 
            //eliminar dependencia
            if (isset($_GET['user_codigo_del'])) {
                require_once "./php/dependencia/depen_eliminar.php";
            }
             if (!isset($_GET['page'])) {
                $pagina=1;
            }else {
                $pagina=(int) $_GET['page'];
                if($pagina<=1){
                    $pagina=1;
                }
            }
            $pagina= limpiar_cadena($pagina);
            $url="index.php?vista=dependencia/dep_search&page=";
            $registros=15;
            $busqueda=$_SESSION['busqueda_dependencia'];
        
            require_once "./php/dependencia/depen_lista.php";
        } 
    ?>
</div>