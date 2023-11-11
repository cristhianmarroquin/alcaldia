<?php
    require_once "./php/main.php";
    $id=(isset($_GET['tip_codigo_up'])) ? $_GET['tip_codigo_up'] : 0;
    $id=limpiar_cadena($_GET['tip_codigo_up']);
?>
<div class="container is-fluid mb-1">
        <h1 class="title">tipo</h1>
	    <h2 class="subtitle">Actualizar tipo</h2>
</div>

<div class="container pb-1 pt-1">
<?php
    include "inc/btn_back.php";
    $check_tip=conexion();
    $check_tip=$check_tip->query("SELECT t.*,su.sub_nombre  FROM tiposubser t
                                    left join subseries su on (su.sub_codigo = t.tip_subser)
                                    WHERE tip_codigo='$id'");
    if ($check_tip->rowCount()>0) {
        $datos=$check_tip->fetch();
        ?>

            <div class="form-rest mb-1 mt-1"></div>

            <form action="php/subserial/tipo/tip_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

                <input type="hidden" value="<?php echo $datos['tip_codigo']?>" name="tip_id" required readonly>
                
                <div class="columns">
                    <div class="column">
                        <div class="control">
                            <label>codigo</label>
                            <input class="input" type="text" name="tip_codigo" readonly value="<?php echo $datos['tip_codigo']?>" pattern="[0-9]{3,40}" maxlength="40" required >
                        </div>
                    </div>
                    <div class="column">
                        <div class="control">
                            <label>Nombre</label>
                            <input class="input" type="text" name="tip_nombre" value="<?php echo $datos['tip_nombre']?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
                        </div>
                    </div>

                    <div class="column">
                        <div class="control">
                            <p class="has-text-centered">
                                <label>Estado</label>
                                <br>
                                <input  type="checkbox" name="tip_estado" id="tip_estado" value="<?php echo $datos['tip_estado']?>" <?php if ($datos['tip_estado'] == "1") { ?>checked <?php } ?>>
                            </p>
                        </div>
                    </div>
            
                    <div class="column">
			  <label>subserial</label><br>
		    	<div class="select is-rounded">
				  	<select name="sel_sub" id="sel_sub" required  onchange="select('tiposubser');">
						<option value="<?php echo $datos['tip_subser']?>" selected="" > <?php echo $datos['tip_subser']." - ".$datos['sub_nombre']?> </option>
						<?php
							$tipseriales = conexion();
							$tipseriales = $tipseriales->query("SELECT * FROM tiposubser");
							if ($tipseriales->rowCount()>0) {
								$tipseriales=$tipseriales->fetchAll();
								foreach ($tipseriales as $tip) {
									echo '<option value="'.$tip["tip_codigo"].'">'.$tip["tip_codigo"]." - ".$tip["tip_nombre"].'</option>';
								}	
							}
							$tipseriales = null;
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
    $check_tip=null;
?>
</div>