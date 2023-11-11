<?php
$inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla = "";
if(isset ($busqueda) && $busqueda!=""){
    $consulta_datos="SELECT * FROM tiposubser WHERE tip_nombre LIKE '%$busqueda%' ORDER BY tip_nombre ASC LIMIT $inicio,$registros";
    $consulta_total="SELECT COUNT(tip_codigo) FROM tiposubser";
}else {
    $consulta_datos="SELECT * FROM tiposubser ORDER BY tip_nombre ASC LIMIT $inicio,$registros";
    $consulta_total="SELECT COUNT(tip_codigo) FROM tiposubser WHERE tip_nombre LIKE '%$busqueda%' ";
}

$conexion=conexion();
$datos=$conexion->query($consulta_datos);
$datos=$datos->fetchAll();

$total=$conexion->query($consulta_total);
$total=(int) $total->fetchColumn();

$Npaginas=ceil($total/$registros);

$actualizar = 0;
$per_usu = conexion();
    $per_usu = $per_usu->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 4 and psm_per = 2");
    if ($per_usu->rowCount()>0) {
        $actualizar = 1;
      $per_usu = null;
    }
$tabla.='
    <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Nombre</th>';
                        if ($actualizar==1) {
                            $tabla.='<th>Opciones</th>';
                        }
                        $tabla.='<th>Estado</th>
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
                <td>'.$rows['tip_codigo'].'</td>
                <td>'.$rows['tip_nombre'].'</td>
            ';
            if ($actualizar==1) {
                $tabla.='<td>
                        <a href="index.php?vista=subserial/tipo/tip_update&tip_codigo_up='.$rows['tip_codigo'].'" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        ';
            }
        
            if ($rows['tip_estado'] == "0" ) {
                $tabla.=' <td style="red;color:#ff0000;" >O</td>';
            }else {
                $tabla.=' <td style="red;color:#0dff00;" >O</td>';
            }

        $tabla.='</tr>';
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
    $tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
}
$conexion=null;
echo $tabla;

if ($total>=1 && $pagina<=$Npaginas) {
    echo paginador_tablas($pagina,$Npaginas,$url,7);
}