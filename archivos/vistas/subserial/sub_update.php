<?php
    require_once "php/main.php";
    $id=(isset($_GET['sub_codigo_up'])) ? $_GET['sub_codigo_up'] : 0;
    $id=limpiar_cadena($_GET['sub_codigo_up']);
?>
<div class="container is-fluid mb-1">
        <h1 class="title">subseriales</h1>
	    <h2 class="subtitle">Actualizar subserial</h2>
</div>

<div class="container pb-1 pt-1">
<?php
    include "inc/btn_back.php";
    $check_sub=conexion();
    $check_sub=$check_sub->query("SELECT su.*,s.ser_nombre  FROM subseries su
                                    left join seriales s on (s.ser_codigo = su.sub_serial)
                                    WHERE sub_codigo='$id'");

    if ($check_sub->rowCount()>0) {
        $datos=$check_sub->fetch();
        ?>

            <div class="form-rest mb-1 mt-1"></div>

            <form action="php/subserial/sub_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

                <input type="hidden" value="<?php echo $datos['sub_codigo']?>" name="sub_id" required readonly>
                
                <div class="columns">
                    <div class="column">
                        <div class="control">
                            <label>codigo</label>
                            <input class="input" type="text" name="sub_codigo" readonly value="<?php echo $datos['sub_codigo']?>" pattern="[0-9]{3,40}" maxlength="40" required >
                        </div>
                    </div>
                    <div class="column">
                        <div class="control">
                            <label>Nombre</label>
                            <input class="input" type="text" name="sub_nombre" value="<?php echo $datos['sub_nombre']?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
                        </div>
                    </div>

                    <div class="column">
                        <div class="control">
                            <p class="has-text-centered">
                                <label>Estado</label>
                                <br>
                                <input  type="checkbox" name="sub_estado" id="sub_estado" value="<?php echo $datos['sub_estado']?>" <?php if ($datos['sub_estado'] == "1") { ?>checked <?php } ?>>
                            </p>
                        </div>
                    </div>
            
                    <div class="column">
			  <label>serial</label><br>
		    	<div class="select is-rounded">
				  	<select name="sel_ser" id="sel_ser" required  onchange="select('seriales');">
						<option value="<?php echo $datos['sub_serial']?>" selected="" > <?php echo $datos['sub_serial']." - ".$datos['sub_nombre']?> </option>
						<?php
							$seriales = conexion();
							$seriales = $seriales->query("SELECT * FROM seriales");
							if ($seriales->rowCount()>0) {
								$seriales=$seriales->fetchAll();
								foreach ($seriales as $ser) {
									echo '<option value="'.$ser["ser_codigo"].'">'.$dep["ser_codigo"]." - ".$dep["ser_nombre"].'</option>';
								}	
							}
							$seriales = null;
						?>
					</select>
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