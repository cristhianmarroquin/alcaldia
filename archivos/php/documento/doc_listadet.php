<?php
$inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla = "";

$consulta_datos="SELECT d.*, s.usu_nombre FROM  detdocum d 
                    left join usuarios s on (s.usu_codigo=d.det_usu)
                    where  det_docum = ".$_SESSION["DOC_ACTU"]."";
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
                        <th>Nombre</th>
                        <th>fecha</th>
                        <th>usuario</th>
                        <th>Numero Paginas</th>
                        <th>Tamaño</th>
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
            <td>'.$rows['det_nombre'].'</td>
            <td>'.$rows['det_fecha'].'</td>
            <td>'.$rows['det_usu'].'-'.$rows['usu_nombre'].'</td>
            <td>'.$rows['det_numpag'].'</td>
            <td>'.show_filesize($rows['det_size']).'</td>
            <td>
                <a class="button is-primary is-rounded is-small">Descargar</a>
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

function show_filesize($filename, $decimalplaces = 0) {
 
    $size = $filename;
    $sizes = array('B', 'kB', 'MB', 'GB', 'TB');
   
    for ($i=0; $size > 1024 && $i < count($sizes) - 1; $i++) {
       $size /= 1024;
    }
    return round($size, $decimalplaces).' '.$sizes[$i];
   
  }