
<?php
	 $id=(isset($_GET['doc_codigo_up'])) ? $_GET['doc_codigo_up'] : 0;
	 $id=limpiar_cadena($_GET['doc_codigo_up']);
?>
<script type="text/javascript" src="./php/documento/js/validacion.js?v=1.1"></script>
<div class="container is-fluid mb-1">
	<h1 class="title">Documento</h1>
	<h2 class="subtitle">Adjuntar Documento</h2>
</div>
<div class="container pb-2 pt-2">
	<?php
		include "inc/btn_back.php";
		$check_depen=conexion();
		$check_depen=$check_depen->query("SELECT d.*, de.dep_nombre,se.ser_nombre,su.sub_nombre FROM documentos d 
											left join dependencias de on (d.doc_dependecia=de.dep_codigo)
											left join seriales se on (d.doc_serial=se.ser_codigo)
											left join subseries su on (d.doc_subser=su.sub_codigo)
											WHERE doc_codigo='$id'");

		if ($check_depen->rowCount()>0) {
			$datos=$check_depen->fetch();
	?>
		<div class="form-rest mb-2 mt-2"></div>

		<form action="./php/documento/doc_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >
			<input type="hidden" value="<?php echo $datos['doc_codigo']?>" name="doc_id" required readonly>
			<div class="columns">
				<div class="column">
					<div class="control">
						<label>Nombre documento</label>
						<input class="input" type="text" value="<?php echo $datos['doc_nombre']?>" name="doc_nom" name="doc_nom" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{1,150}" maxlength="150" disabled >
					</div>
				</div>
				<input  type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['id'] ?>">
				<div class="column">
				<label>Dependencia</label><br>
					<div class="select is-rounded">
						<select name="sel_depen" id="sel_depen" disabled >
							<option value="<?php echo $datos['doc_dependecia']?>" selected="" > <?php echo $datos['doc_dependecia']."-".$datos['dep_nombre']?> </option>
						</select>
					</div>
				</div>
				<div class="column">
				<label>Serie</label><br>
					<div class="select is-rounded">
						<select name="sel_ser" id="sel_ser" disabled>
							<option value="<?php echo $datos['doc_serial']?>" selected="" > <?php echo $datos['doc_serial']." - ".$datos['ser_nombre']?> </option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="columns">
				<div class="column">
					<label>SubSerie</label><br>
					<div class="select is-rounded">
						<select name="sel_subser" id="sel_subser" disabled>
							<option value="<?php echo $datos['doc_subser']?>" selected="" ><?php echo $datos['doc_subser']." - ".$datos['sub_nombre']?></option>
						</select>
					</div>
				</div>
				<?php
					$depencias = conexion();
					$depencias = $depencias->query("SELECT tip_nombre FROM tiposubser where tip_subser = '".$datos['doc_subser']."'");
					if ($depencias->rowCount()>0) {
						$depencias=$depencias->fetchAll();
						echo'<div class="column">
							<div class="tags">';
						for ($i=0; $i < sizeof($depencias); $i++) {
							if ($i < 8) {
								echo '<span class="tag is-medium is-primary" id="tipo'.$i.'" name="tipo'.$i.'">'.$depencias[$i]["tip_nombre"].'</span>';
							}else {
								if ($i == 9) {
									echo '</div>
									</div>
									<div class="column">
									<div class="tags">';
								}
								echo '<span class="tag is-medium is-primary" id="tipo'.$i.'" name="tipo'.$i.'">'.$depencias[$i]["tip_nombre"].'</span>';
							}
						}
						echo '</div>
							</div>';

					}
					$depencias = null;
				?>
			</div>
			<div class="columns">
				<div class="column">
					<div id="file-js-example" class="file has-name is-info is-boxed" onchange="img_carga();">
						<label class="file-label">
							<input class="file-input" type="file" id="document" name="document">
							<span class="file-cta">
								<img src="./img/carga-en-la-nube (2).png" width="80" height="20" id="img_carga"> </img>
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
	<?php 
		}else {
			include "inc/error_alert.php";
		}
		$check_depen=null;
	?>
</div>
<div class="form-rest mb-1 mt-1"></div>
	<?php
    if (!isset($_GET['page'])) {
        $pagina=1;
    }else {
        $pagina=(int) $_GET['page'];
        if($pagina<=1){
            $pagina=1;
        }
    }
    $pagina= limpiar_cadena($pagina);
    $url="index.php?vista=documento/doc_new&page=";
    $registros=15;
    $busqueda="";
	$_SESSION["DOC_ACTU"]=$id;
    require_once "./php/documento/doc_listadet.php";
    ?>