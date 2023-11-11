<?php
	 require "./php/main.php"; 
?>
<div class="container is-fluid mb-6">
	<h1 class="title">seriales</h1>
	<h2 class="subtitle">Nueva serial</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/serial/ser_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Codigo</label>
				  	<input class="input" type="text" name="ser_codigo" pattern="[0-9]{1,30}" maxlength="30" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="ser_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{1,50}" maxlength="50" required >
				</div>
		  	</div>
			  <div class="column">
		    	<div class="control">
					<label>Año dep</label>
				  	<input class="input" type="text" name="ser_ano_dep" pattern="[0-9]{1,50}" maxlength="3" required >
				</div>
		  	</div>
			  <div class="column">
		    	<div class="control">
					<label>Año arch</label>
				  	<input class="input" type="text" name="ser_ano_arch" pattern="[0-9]{1,50}" maxlength="3" required >
				</div>
		  	</div>
		</div>
		<div class="column">
			  <label>Dependencia</label><br>
		    	<div class="select is-rounded">
				  	<select name="sel_depen" id="sel_depen" required  onchange="select('dependencia');">
						<option value="" selected="" > Selecciona una dependencia </option>
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
			<button type="submit" class="button is-info is-rounded">Guardar</button>
			<input  type="hidden" name="estado" id="estado" value="guardar">
		</p>
	</form>
</div>