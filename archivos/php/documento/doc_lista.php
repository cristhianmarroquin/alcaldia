<?php
$inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla = "";
if(isset ($busqueda) && $busqueda!=""){
    $consulta_datos="SELECT d.*,de.dep_nombre,se.ser_nombre,su.sub_nombre  FROM documentos d
                        left join dependencias de on (d.doc_dependecia=de.dep_codigo)
                        left join seriales se on (d.doc_serial=se.ser_codigo)
                        left join subseries su on (d.doc_subser=su.sub_codigo)
                        WHERE doc_nombre LIKE '%$busqueda%' ORDER BY doc_nombre ASC LIMIT $inicio,$registros";
    $consulta_total="SELECT COUNT(doc_codigo) FROM documentos";
}else {
    $consulta_datos="SELECT d.*,de.dep_nombre,se.ser_nombre,su.sub_nombre  FROM documentos d
                                left join dependencias de on (d.doc_dependecia=de.dep_codigo)
                                left join seriales se on (d.doc_serial=se.ser_codigo)
                                left join subseries su on (d.doc_subser=su.sub_codigo)
                                ORDER BY doc_nombre ASC LIMIT $inicio,$registros";
    $consulta_total="SELECT COUNT(doc_codigo) FROM documentos WHERE doc_nombre LIKE '%$busqueda%' ";
}

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
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Dependencia</th>
                        <th>Serial</th>
                        <th>Subserial</th>
                        <th colspan="1">Opciones</th>
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
                <td>'.$rows['doc_nombre'].'</td>
                <td>'.$rows['doc_fechac'].'</td>
                <td>'.$rows['doc_dependecia'].'-'.$rows['dep_nombre'].'</td>
                <td>'.$rows['doc_serial'].'-'.$rows['ser_nombre'].'</td>
                <td>'.$rows['doc_subser'].'-'.$rows['sub_nombre'].'</td>
            ';
        $tabla.='
            <td>
                <a href="index.php?vista=documento/doc_update&doc_codigo_up='.$rows['doc_codigo'].'" class="button is-primary is-rounded is-small">Adjuntar/Detalle</a>
            </td>
            ';

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