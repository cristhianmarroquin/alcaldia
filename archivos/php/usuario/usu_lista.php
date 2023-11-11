<?php
$inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla = "";
if(isset ($busqueda) && $busqueda!=""){
    $consulta_datos="SELECT * FROM usuarios WHERE ((usu_codigo!='".$_SESSION['id']."') AND (usu_nombre LIKE '%$busqueda%' OR usu_apellido LIKE '%$busqueda%' OR usu_usuario LIKE '%$busqueda%' OR usu_correo LIKE '%$busqueda%')) ORDER BY usu_nombre ASC LIMIT $inicio,$registros";
    $consulta_total="SELECT COUNT(usu_codigo) FROM usuarios WHERE usu_codigo!='".$_SESSION['id']."'";
}else {
    $consulta_datos="SELECT * FROM usuarios WHERE usu_codigo!='".$_SESSION['id']."' ORDER BY usu_nombre ASC LIMIT $inicio,$registros";
    $consulta_total="SELECT COUNT(usu_codigo) FROM usuarios WHERE ((usu_codigo!='".$_SESSION['id']."') AND (usu_nombre LIKE '%$busqueda%' OR usu_apellido LIKE '%$busqueda%' OR usu_usuario LIKE '%$busqueda%' OR usu_correo LIKE '%$busqueda%'))";
}

$conexion=conexion();

$datos=$conexion->query($consulta_datos);
$datos=$datos->fetchAll();

$total=$conexion->query($consulta_total);
$total=(int) $total->fetchColumn();

$Npaginas=ceil($total/$registros);
$actualizar = 0;
$per_usu = conexion();
$per_usu = $per_usu->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 3 and psm_per = 2");
if ($per_usu->rowCount()>0) {
    $actualizar = 1;
  $per_usu = null;
}
$tabla.='
    <div class="table-container pb-8 pt-8">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Email</th>';
                        if ($actualizar == 1) {
                            $tabla.='<th colspan="1">Opciones</th>';
                        }
                        $tabla.='</tr>
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
            <td>'.$rows['usu_apellido'].'</td>
            <td>'.$rows['usu_usuario'].'</td>
            <td>'.$rows['usu_correo'].'</td>';
            if ($actualizar ==1) {
                $tabla.='<td>
                <a href="index.php?vista=usuario/user_update&user_codigo_up='.$rows['usu_codigo'].'" class="button is-success is-rounded is-small">Actualizar</a>
            </td>';
            }
            $tabla.='</tr>
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
    $tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
}
$conexion=null;
echo $tabla;

if ($total>=1 && $pagina<=$Npaginas) {
    echo paginador_tablas($pagina,$Npaginas,$url,7);
}