<div class="container is-fluid mb-6">
    <h1 class="title">Documentos</h1>
    <h2 class="subtitle">Documentos Lista</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
    require_once "./php/main.php";

    //eliminar usuario
    // if (isset($_GET['user_codigo_del'])) {
    //     require_once "./php/serial/ser_eliminar.php";
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
    $url="index.php?vista=documento/doc_list&page=";
    $registros=15;
    $busqueda="";

    require_once "./php/documento/doc_lista.php";
    ?>

</div>