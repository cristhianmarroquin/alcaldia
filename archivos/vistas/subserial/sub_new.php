<?php
	 require "./php/main.php"; 
?>

<div class="container is-fluid mb-6">
	<h1 class="title">subseriales</h1>
	<h2 class="subtitle">Nuevo subserial</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/subserial/sub_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Codigo</label>
				  	<input class="input" type="text" name="sub_codigo" pattern="[0-9]{1,30}" maxlength="30" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="sub_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{1,50}" maxlength="50" required >
				</div>
		  	</div>
			  <div class="column">
			  <label>serial</label><br>
		    	<div class="select is-rounded">
				  	<select name="sel_ser" id="sel_ser" required  onchange="select('seriales');">
						<option value="" selected="" > Selecciona una serial </option>
						<?php
							$seriales = conexion();
							$seriales = $seriales->query("SELECT * FROM seriales");
							if ($seriales->rowCount()>0) {
								$seriales=$seriales->fetchAll();
								foreach ($seriales as $ser) {
									echo '<option value="'.$ser["ser_codigo"].'">'.$ser["ser_codigo"]." - ".$ser["ser_nombre"].'</option>';
								}	
							}
							$seriales = null;
						?>
					</select>
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
			<input  type="hidden" name="estado" id="estado" value="guardar">
		</p>
	</form>
</div>