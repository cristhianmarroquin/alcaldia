<?php
	 require "archivos/../php/main.php"; 
?>

<div class="container is-fluid mb-6">
	<h1 class="title">tipo</h1>
	<h2 class="subtitle">Nuevo tipo</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/subserial/tipo/tip_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Codigo</label>
				  	<input class="input" type="text" name="tip_codigo" pattern="[0-9]{1,30}" maxlength="30" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="tip_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{1,50}" maxlength="50" required >
				</div>
			</div>
			  <div class="column">
			  <label>sub serial</label><br>
		    	<div class="select is-rounded">
				  	<select name="sel_subser" id="sel_subser" required  onchange="select('subseries');">
						<option value="" selected="" > Selecciona un subserial </option>
						<?php
							$subseriales = conexion();
							$subseriales = $subseriales->query("SELECT * FROM subseries");
							if ($subseriales->rowCount()>0) {
								$subseriales=$subseriales->fetchAll();
								foreach ($subseriales as $sub) {
									echo '<option value="'.$sub["sub_codigo"].'">'.$sub["sub_codigo"]." - ".$sub["sub_nombre"].'</option>';
								}	
							}
							$subseriales = null;
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