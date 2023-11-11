<?php
$inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla = "";
if(isset ($busqueda) && $busqueda!=""){
    $consulta_datos="SELECT * FROM seriales WHERE ser_nombre LIKE '%$busqueda%' ORDER BY ser_nombre ASC LIMIT $inicio,$registros";
    $consulta_total="SELECT COUNT(ser_codigo) FROM seriales";
}else {
    $consulta_datos="SELECT * FROM seriales ORDER BY ser_nombre ASC LIMIT $inicio,$registros";
    $consulta_total="SELECT COUNT(ser_codigo) FROM seriales WHERE ser_nombre LIKE '%$busqueda%' ";
}

$conexion=conexion();
$datos=$conexion->query($consulta_datos);
$datos=$datos->fetchAll();

$total=$conexion->query($consulta_total);
$total=(int) $total->fetchColumn();

$Npaginas=ceil($total/$registros);

$actualizar = 0;
$per_usu = conexion();
    $per_usu = $per_usu->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 2 and psm_per = 2");
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
                        <th>Nombre</th>
                        <th>Año dep</th>
                        <th>Año arch</th>';
                        if ($actualizar==1) {
                            $tabla.='<th colspan="1">Opciones</th>';
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
                <td>'.$rows['ser_codigo'].'</td>
                <td>'.$rows['ser_nombre'].'</td>
                <td>'.$rows['ser_ano_dep'].'</td>
                <td>'.$rows['ser_ano_arch'].'</td>
            ';
            if ($actualizar==1) {
                $tabla.='<td>
                        <a href="index.php?vista=serial/ser_update&ser_codigo_up='.$rows['ser_codigo'].'" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        ';
            }
        
            if ($rows['ser_estado'] == "0" ) {
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