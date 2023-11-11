<?php
$inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla = "";
$consulta_datos="SELECT psm.*,p.per_nombre,s.usu_nombre,m.mod_nombre  FROM persumo psm
                    left join perfil p on (psm.psm_per=p.per_codigo)
                    left join usuarios s on (psm.psm_usu=s.usu_codigo)
                    left join modulos m on (psm.psm_mod=m.mod_codigo)";
$consulta_total="SELECT count(*) FROM persumo";

$conexion=conexion();

$datos=$conexion->query($consulta_datos);
$datos=$datos->fetchAll();

$total=$conexion->query($consulta_total);
$total=(int) $total->fetchColumn();

$Npaginas=ceil($total/$registros);

$tabla.='
    <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Modulos</th>
                        <th>Perfil</th>
                        <th>Quitar</th>
                    </tr>
                </thead>
                <tbody>
';
if ($total>=1 && $pagina<=$Npaginas) {
    $contador=$inicio+1;
    $pag_inicio=$inicio+1;
    foreach($datos as $rows){
        $tabla.='
        <tr class="has-text-centered" >
            <td>'.$contador.'</td>
            <td>'.$rows['usu_nombre'].'</td>
            <td>'.$rows['mod_nombre'].'</td>
            <td>'.$rows['per_nombre'].'</td>
            <td>
                <a href="'.$url.$pagina.'&psm_codigo_del='.$rows['psm_codigo'].'" class="button is-danger is-rounded is-small">Eliminar</a>
            </td>
        </tr>
        ';
        $contador++;
    }
    $pag_final=$contador-1;
}else {
   if ($total>=1) {
    $tabla.='
    <tr class="has-text-centered" >
         <td colspan="7">
            <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                Haga clic acá para recargar el listado
            </a>
         </td>
    </tr>
    ';
   } else {
    $tabla.='
    <tr class="has-text-centered" >
        <td colspan="7">
            No hay registros en el sistema
        </td>
    </tr>    
    ';
   }
}
$tabla.='</tbody></table></div>';

if ($total>=1 && $pagina<=$Npaginas) {
    $tabla.='<p class="has-text-right">Mostrando perfiles<strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
}
$conexion=null;
echo $tabla;

if ($total>=1 && $pagina<=$Npaginas) {
    echo paginador_tablas($pagina,$Npaginas,$url,7);
}