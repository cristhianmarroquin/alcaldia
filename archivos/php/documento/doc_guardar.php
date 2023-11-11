<?php
require_once "../main.php";
//almacenando datos
$doc_nom=limpiar_cadena($_POST['doc_nom']);
$doc_depen=limpiar_cadena($_POST['sel_depen']);
$doc_ser=limpiar_cadena($_POST['sel_ser']);
$doc_subser=limpiar_cadena($_POST['sel_subser']);
$document=$_FILES['document']['tmp_name'];
$nom_arch=$_FILES['document']['name'];
$doc_size=$_FILES['document']['size'];
$num_paginas = getNumPagesInPDF($document);
$usuario = limpiar_cadena($_POST['usuario']);
$fecha = date("Ymd");

//verificando campo obligatorios
if ($doc_nom=="" || $doc_depen=="" || $doc_ser=="" || $doc_subser=="" || $document=="" ) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}
// die(' termino');
//verificando integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9]{1,200}",$doc_nom)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el NOMBRE no coincide con el formato solicitado
        </div>
        ';
    exit();
}
//guardando datos
$detalle=conexion();
$detalle=$detalle->prepare("INSERT INTO documentos(doc_nombre,doc_size,doc_dependecia,doc_usu,doc_serial,doc_subser,doc_pagina,doc_fechac)
                                 VALUES(:doc_nombre,:doc_size,:doc_dependencia,:doc_usu,:doc_serial,:doc_subser,:doc_pagina,:doc_fechac)");
$marcadores=[
    ":doc_nombre"=>$doc_nom."_".date("YmdHis"),
    ":doc_size"=>$doc_size,
    ":doc_dependencia"=>$doc_depen,
    ":doc_usu"=>$usuario,
    ":doc_serial"=>$doc_ser,
    ":doc_subser"=>$doc_subser,
    ":doc_pagina"=>$num_paginas,
    ":doc_fechac"=>$fecha
];
$detalle->execute($marcadores);
$num_max=conexion();
$num_max = $num_max->query("SELECT MAX(doc_codigo) AS id FROM documentos");
$num_max=$num_max->fetch();
$max_num = trim($num_max[0]);
$num_max=null;
if($detalle->rowCount()==1){
    $det=conexion();
    $det=$det->prepare("INSERT INTO detdocum(det_nombre,det_docum,det_fecha)
                                    VALUES(:det_nombre,:det_docum,:det_fecha)");
    $marcadores=[
        ":det_nombre"=>$nom_arch,
        ":det_docum"=>$max_num,
        ":det_fecha"=>$fecha,
        ":det_usu"=>$usuario
    ];
    $det->execute($marcadores);
    if($det->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡Documento Creado!</strong><br>
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
    $det=null;
}else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
                No se Guardo el documento, por favor intente nuevamente
        </div>
    ';
}
$detalle=null;


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