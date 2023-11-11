<div class="container is-fluid mb-1">
    <h1 class="title">Documento</h1>
    <h2 class="subtitle">Buscar Documento</h2>
</div>

<div class="container pb-1 pt-1">
    <?php
    require_once "./php/main.php";

    if (isset($_POST['modulo_buscador'])) {
        require_once "./php/buscador.php";
    }

        if (!isset($_SESSION['busqueda_documento']) && empty($_SESSION['busqueda_documento'])) {
            
    ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="documento">   
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
                <input type="hidden" name="modulo_buscador" value="documento"> 
                <input type="hidden" name="eliminar_buscador" value="documento">
                <p>Estas buscando <strong>“<?php echo $_SESSION['busqueda_documento'];?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php 
            //eliminar documento
            // if (isset($_GET['ser_codigo_del'])) {
            //     require_once "./php/documento/ser_eliminar.php";
            // }
             if (!isset($_GET['page'])) {
                $pagina=1;
            }else {
                $pagina=(int) $_GET['page'];
                if($pagina<=1){
                    $pagina=1;
                }
            }
            $pagina= limpiar_cadena($pagina);
            $url="index.php?vista=documento/doc_search&page=";
            $registros=15;
            $busqueda=$_SESSION['busqueda_documento'];
        
            require_once "./php/documento/doc_lista.php";
        } 
    ?>
</div>