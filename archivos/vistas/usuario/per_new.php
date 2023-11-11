<div class="container is-fluid mb-2">
	<h1 class="title">Perfil</h1>
	<h2 class="subtitle">Nuevo Perfil</h2>
</div>
<div class="container pb-2 pt-2">

	<div class="form-rest mb-2 mt-2"></div>

	<form action="./php/usuario/per_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
		<div class="columns">
			<div class="column">
			  <label>Usuario</label><br>
		    	<div class="select is-rounded">
				  	<select name="per_usu" id="per_usu" required >
						<option value="" selected="" >usuario</option>
						<?php
							$depencias = conexion();
							$depencias = $depencias->query("SELECT * FROM usuarios where usu_depen = '".$_SESSION['dependencia']."'");
							if ($depencias->rowCount()>0) {
								$depencias=$depencias->fetchAll();
								foreach ($depencias as $dep) {
									echo '<option value="'.$dep["usu_codigo"].'">'.$dep["usu_codigo"]." - ".$dep["usu_nombre"].'</option>';
								}	
							}
							$depencias = null;
						?>
					</select>
				</div>
		  	</div>
		  	<div class="column">
			  <label>Modulos</label><br>
		    	<div class="select is-rounded">
				  	<select name="per_mod" id="per_mod" required >
						<option value="" selected="" >Modulos</option>
						<?php
							$depencias = conexion();
							$depencias = $depencias->query("SELECT * FROM modulos");
							if ($depencias->rowCount()>0) {
								$depencias=$depencias->fetchAll();
								foreach ($depencias as $dep) {
									echo '<option value="'.$dep["mod_codigo"].'">'.$dep["mod_codigo"]." - ".$dep["mod_nombre"].'</option>';
								}	
							}
							$depencias = null;
						?>
					</select>
				</div>
		  	</div>
			<div class="column">
			  <label>Perfil</label><br>
		    	<div class="select is-rounded">
				  	<select name="per_perfil" id="per_perfil" required >
						<option value="" selected="" >Perfil</option>
						<?php
							$depencias = conexion();
							$depencias = $depencias->query("SELECT * FROM perfil");
							if ($depencias->rowCount()>0) {
								$depencias=$depencias->fetchAll();
								foreach ($depencias as $dep) {
									echo '<option value="'.$dep["per_codigo"].'">'.$dep["per_codigo"]." - ".$dep["per_nombre"].'</option>';
								}	
							}
							$depencias = null;
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
<div class="form-rest mb-6 mt-6"></div>
	<?php

    //eliminar usuario
    if (isset($_GET['psm_codigo_del'])) {
        require_once "./php/usuario/per_eliminar.php";
    }
    if (!isset($_GET['page'])) {
        $pagina=1;
    }else {
        $pagina=(int) $_GET['page'];
        if($pagina<=1){
            $pagina=1;
        }
    }
    $pagina= limpiar_cadena($pagina);
    $url="index.php?vista=usuario/per_new&page=";
    $registros=15;
    $busqueda="";

    require_once "./php/usuario/per_lista.php";
    ?>