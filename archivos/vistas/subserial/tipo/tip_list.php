<div class="container is-fluid mb-6">
    <h1 class="title">tipo</h1>
    <h2 class="subtitle">tipo Lista</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
    require_once "./php/main.php";

    if (!isset($_GET['page'])) {
        $pagina=1;
    }else {
        $pagina=(int) $_GET['page'];
        if($pagina<=1){
            $pagina=1;
        }
    }
    $pagina= limpiar_cadena($pagina);
    $url="index.php?vista=subserial/tipo/tip_list&page=";
    $registros=15;
    $busqueda="";

    require_once "./php/subserial/tipo/tip_lista.php";
    ?>

</div>