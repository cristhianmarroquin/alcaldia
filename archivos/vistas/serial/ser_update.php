<?php
    require_once "php/main.php";
    $id=(isset($_GET['ser_codigo_up'])) ? $_GET['ser_codigo_up'] : 0;
    $id=limpiar_cadena($_GET['ser_codigo_up']);
?>
<div class="container is-fluid mb-1">
        <h1 class="title">seriales</h1>
	    <h2 class="subtitle">Actualizar serial</h2>
</div>

<div class="container pb-1 pt-1">
<?php
    include "inc/btn_back.php";
    $check_depen=conexion();
    $check_depen=$check_depen->query("SELECT s.*,d.dep_nombre FROM seriales s 
                                        left join  dependencias d on (d.dep_codigo = s.ser_depen)  
                                            WHERE ser_codigo='$id'");

    if ($check_depen->rowCount()>0) {
        $datos=$check_depen->fetch();
        ?>

            <div class="form-rest mb-4 mt-4"></div>

            <form action="php/serial/ser_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

                <input type="hidden" value="<?php echo $datos['ser_codigo']?>" name="ser_id" required readonly>
                
                <div class="columns">
                    <div class="column">
                        <div class="control">
                            <label>codigo</label>
                            <input class="input" type="text" name="ser_codigo" readonly value="<?php echo $datos['ser_codigo']?>" pattern="[0-9]{3,40}" maxlength="40" required >
                        </div>
                    </div>

                    <div class="column">
                        <div class="control">
                            <label>Nombre</label>
                            <input class="input" type="text" name="ser_nombre" value="<?php echo $datos['ser_nombre']?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
                        </div>
                    </div>

                    <div class="column">
                        <div class="control">
                            <p class="has-text-centered">
                                <label>Estado</label>
                                <br>
                                <input  type="checkbox" name="ser_estado" id="ser_estado" value="<?php echo $datos['ser_estado']?>" <?php if ($datos['ser_estado'] == "1") { ?>checked <?php } ?>>
                            </p>
                        </div>
                    </div>

                </div>
                <div class="columns">
                    <div class="column">
                            <div class="control">
                                <label>Año dep</label>
                                <input class="input" type="text" name="ser_ano_dep" value="<?php echo $datos['ser_ano_dep']?>" pattern="[0-9]{1,40}" maxlength="3" required >
                            </div>
                    </div>
                    <div class="column">
                            <div class="control">
                                <label>Año arch</label>
                                <input class="input" type="text" name="ser_ano_arch" value="<?php echo $datos['ser_ano_arch']?>" pattern="[0-9]{1,40}" maxlength="3" required >
                            </div>
                    </div>
                    <div class="column">
                            <div class="control">
                            </div>
                    </div>
                </div>
            <div class="column">
			  <label>Dependencia</label><br>
		    	<div class="select is-rounded">
				  	<select name="sel_depen" id="sel_depen" required  onchange="select('dependencia');">
						<option value="<?php echo $datos['ser_depen']?>" selected="" > <?php echo $datos['ser_depen']." - ".$datos['dep_nombre']?> </option>
						<?php
							$depencias = conexion();
							$depencias = $depencias->query("SELECT * FROM dependencias");
							if ($depencias->rowCount()>0) {
								$depencias=$depencias->fetchAll();
								foreach ($depencias as $dep) {
									echo '<option value="'.$dep["dep_codigo"].'">'.$dep["dep_codigo"]." - ".$dep["dep_nombre"].'</option>';
								}	
							}
							$depencias = null;
						?>
					</select>
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