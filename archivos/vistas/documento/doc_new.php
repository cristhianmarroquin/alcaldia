
<?php
	//  require "./php/main.php"; 
?>
<script type="text/javascript" src="./php/documento/js/validacion.js?v=1.1"></script>
<div class="container is-fluid mb-6">
	<h1 class="title">Documento</h1>
	<h2 class="subtitle">Nuevo Documento</h2>
</div>
<div class="container pb-2 pt-2">

	<div class="form-rest mb-2 mt-2"></div>

	<form action="./php/documento/doc_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre documento</label>
				  	<input class="input" type="text" name="doc_nom" name="doc_nom" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9]{1,150}" maxlength="150" required >
				</div>
		  	</div>
			<input  type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['id'] ?>">
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
		  	<div class="column">
			  <label>Serie</label><br>
		    	<div class="select is-rounded">
				  	<select name="sel_ser" id="sel_ser" required onchange="select('serie');">
						<option value="" selected="" > Selecciona una Dependencia </option>
					</select>
				</div>
		  	</div>
		</div>
		
		<div class="columns">
			<div class="column">
				<label>SubSerie</label><br>
				<div class="select is-rounded">
					<select name="sel_subser" id="sel_subser" required onchange="select('tipo');">
						<option value="" selected="" > Selecciona una Subserie</option>
					</select>
				</div>
			</div>
			<div class="column">
				<div class="tags">
					<span class="tag is-medium is-primary" style="display:none" id="tipo0" name="tipo0"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo1" name="tipo1"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo2" name="tipo2"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo3" name="tipo3"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo4" name="tipo4"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo5" name="tipo5"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo6" name="tipo6"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo7" name="tipo7"></span>
				</div>
			</div>
			<div class="column">
			<div class="tags">
					<span class="tag is-medium is-primary" style="display:none" id="tipo8" name="tipo8"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo9" name="tipo9"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo10" name="tipo10"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo11" name="tipo11"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo12" name="tipo12"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo13" name="tipo13"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo14" name="tipo14"></span>
					<span class="tag is-medium is-primary" style="display:none" id="tipo15" name="tipo15"></span>
				</div>
			</div>
		</div>
		<br>
		<div class="columns">
			<div class="column">
				<div id="file-js-example" class="file has-name is-info is-boxed" onchange="img_carga();">
					<label class="file-label">
						<input class="file-input" type="file" id="document" name="document">
						<span class="file-cta">
						<!-- <span class="file-icon"> -->
							<!-- <img src="./img/carga-en-la-nube (1).png" width="112" height="28"> -->
							<img src="./img/carga-en-la-nube (2).png" width="80" height="20" id="img_carga"> </img>
						<!-- </span> -->
						</span>
						<span class="file-name">
							No se selecciono ningun archivo
						</span>
					</label>
				</div>
			</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
			<input  type="hidden" name="estado" id="estado" value="guardar">
		</p>
	</form>
</div>