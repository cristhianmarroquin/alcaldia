<?php
require_once "../main.php";
//almacenando datos
$id=limpiar_cadena($_POST['doc_id']);
$document=$_FILES['document']['tmp_name'];
$nom_arch=$_FILES['document']['name'];
$doc_size=$_FILES['document']['size'];
$doc_type=$_FILES['document']['type'];
$num_paginas = getNumPagesInPDF($document);
$usuario = limpiar_cadena($_POST['usuario']);
$fecha = date("Ymd");

if ($document=="" ) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se selecciono un archivo
        </div>
        ';
        echo '<meta http-equiv=refresh content="2">';
    exit();
}

//guardando datos
$detalle=conexion();
$detalle=$detalle->prepare("INSERT INTO detdocum(det_nombre,det_docum,det_fecha,det_usu,det_size,det_numpag,det_tipfor)
                                 VALUES(:det_nombre,:det_docum,:det_fecha,:det_usu,:det_size,:det_numpag,:det_tipfor)");
$marcadores=[
    ":det_nombre"=>$nom_arch,
    ":det_docum"=>$id,
    ":det_fecha"=>$fecha,
    ":det_usu"=>$usuario,
    ":det_size"=>$doc_size,
    ":det_numpag"=>$num_paginas,
    ":det_tipfor"=>$doc_type
];
$detalle->execute($marcadores);
if($detalle->rowCount()==1){
    echo '
        <div class="notification is-info is-light">
            <strong>¡Documento Almacenado!</strong><br>
            El documento se Guardo Correctamente
        </div>
    ';
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
                No se Guardo el documento, por favor intente nuevamente
        </div>
    ';
}
$detalle=null;
echo '<meta http-equiv=refresh content="2">';

function getNumPagesInPDF($filePath) {
    if (!file_exists($filePath))
        return 0;
    if (!$fp = @fopen($filePath, "r"))
        return 0;
    $i = 0;
    $type = "/Contents";
    while (!feof($fp)) {
        $line = fgets($fp, 255);
        $x = explode($type, $line);
        if (count($x) > 1) {
            $i++;
        }
    }
    fclose($fp);
    return (int) $i;
} 