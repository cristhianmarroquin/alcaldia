<?php
    require_once "php/main.php";
    $id=(isset($_GET['dep_codigo_up'])) ? $_GET['dep_codigo_up'] : 0;
    $id=limpiar_cadena($_GET['dep_codigo_up']);
?>
<div class="container is-fluid mb-1">
        <h1 class="title">Dependencia</h1>
	    <h2 class="subtitle">Actualizar Dependencia</h2>
</div>

<div class="container pb-1 pt-1">
<?php
    include "inc/btn_back.php";
    $check_depen=conexion();
    $check_depen=$check_depen->query("SELECT * FROM dependencias WHERE dep_codigo='$id'");

    if ($check_depen->rowCount()>0) {
        $datos=$check_depen->fetch();
        ?>

            <div class="form-rest mb-1 mt-1"></div>

            <form action="php/dependencia/depen_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

                <input type="hidden" value="<?php echo $datos['dep_codigo']?>" name="dep_id" required readonly>
                
                <div class="columns">
                    <div class="column">
                        <div class="control">
                            <label>codigo</label>
                            <input class="input" type="text" name="dep_codigo" readonly value="<?php echo $datos['dep_codigo']?>" pattern="[0-9]{3,40}" maxlength="40" required >
                        </div>
                    </div>
                    <div class="column">
                        <div class="control">
                            <label>Nombre</label>
                            <input class="input" type="text" name="dep_nombre" value="<?php echo $datos['dep_nombre']?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
                        </div>
                    </div>

                    <div class="column">
                        <div class="control">
                            <p class="has-text-centered">
                                <label>Estado</label>
                                <br>
                                <input  type="checkbox" name="dep_estado" id="dep_estado" value="<?php echo $datos['dep_estado']?>" <?php if ($datos['dep_estado'] == "1") { ?>checked <?php } ?>>
                            </p>
                        </div>
                    </div>

                </div>
                <p class="has-text-centered">
                    <button type="submit" class="button is-success is-rounded">Actualizar</button>
                    <input  type="hidden" name="estado" id="estado" value="guardar">
                </p>
            </form>
        <?php 
    }else {
        include "inc/error_alert.php";
    }
    $check_depen=null;
?>
</div>