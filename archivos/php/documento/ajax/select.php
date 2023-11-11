<?php
include "../../main.php";
// extract($_REQUEST);
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$parametro        = isset($_GET['parametro'])       ? $_GET['parametro']:'';
$tipo        = isset($_GET['tipo'])       ? $_GET['tipo']:'';
// print_r($_GET);
// die();
$arr = array();
if ($tipo == "dependencia") {
    $sql = "SELECT ser_codigo as id, ser_nombre as name FROM seriales WHERE ser_depen='$parametro'";
    $arr[] = array("id" => "", "name" => "Selecciona un Serial");
}else if ($tipo == "serie") {
    $sql = "SELECT sub_codigo as id, sub_nombre as name FROM subseries WHERE sub_serial='$parametro'";
    $arr[] = array("id" => "", "name" => "Selecciona un SubSerial");
}else if ($tipo == "tipo") {
    $sql = "SELECT tip_codigo as id, tip_nombre as name FROM tiposubser WHERE tip_subser='$parametro'";
}

if($parametro != ""){
    $result=conexion();
    $result = $result->query($sql);
    foreach($result as $row){
        $userid = $row['id'];
        $name = $row['name'];
        
        $arr[] = array("id" => $userid, "name" => $name);
    }
    $result=null;
}
// encoding array to json format
echo json_encode($arr);
?>