<?php
    require('../php/mysqli_conexion.php');
    require('../php/utils_query.php');
	require('../php/querys_ver_detalle.php');
	require('../php/querys_inventario.php');

    session_start();
	 // Verificamos que el usuario esté iniciado sesión
    if(!isset($_SESSION['usuario'])) {
        // Si el usuario no está iniciado sesión, lo redirigimos a la página de inicio de sesión
        header("Location: ../views/login.php");
    } else {
		$usuario = $_SESSION['usuario'];
    	echo "<script> console.log(" . json_encode($usuario) . "); </script>";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ver Detalles | ISTG</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/sweetalert2.css">
	<link rel="stylesheet" href="../css/material.min.css">
	<link rel="stylesheet" href="../css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="../css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/style.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../js/jquery-1.11.2.min.js"><\/script>')</script>
	<script src="../js/material.min.js" ></script>
	<script src="../js/sweetalert2.min.js" ></script>
	<script src="../js/jquery.mCustomScrollbar.concat.min.js" ></script>
	<script src="../js/main.js" ></script>
	<script src="../js/mostrarInputNuevoCodigo.js" ></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>
<body>

<!-- navBar -->
<div class="full-width navBar">
		<div class="full-width navBar-options">
			<div class="mdl-tooltip" for="btn-menu">Menu</div>
			<nav class="navBar-options-list">
				<ul class="list-unstyle">
					
					<li class="text-condensedLight noLink" ><small>ISTG</small></li>
					<li class="noLink">
						<figure>
							<img src="../assets/img/avatar-male.png" alt="Avatar" class="img-responsive">
						</figure>
					</li>

					<li class="noLink">
					<form action="../php/logout.php" method="post">
						<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Cerrar sesión</button>
					</form>
					</li>

				</ul>
			</nav>
		</div>
	</div>

	

	<!-- navLateral -->
	<section class="full-width navLateral">
		<div class="full-width navLateral-bg btn-menu"></div>
		<div class="full-width navLateral-body">
			<div class="full-width navLateral-body-logo text-center tittles">
				<i class="zmdi zmdi-close btn-menu"></i> Inventario 
			</div>
			<figure class="full-width" style="height: 77px;">
				<!-- <div class="navLateral-body-cl">
					<img src="assets/img/avatar-male.png" alt="Avatar" class="img-responsive">
				</div> -->
				<figcaption class="navLateral-body-cr hide-on-tablet">
					<span style="margin-left: 60px;">
						<b>Instituto Superior Tecnológico Guayaquil</b><br>
						<?php
							$nombrecompleto = $_SESSION['usuario']['nombre']." ".$_SESSION['usuario']['apellido'];
							$rol = $_SESSION['rol'];
							echo "<small>".$nombrecompleto."</small><br>";
							echo '<small>'. $rol . '</small>';

						?>
					</span>
				</figcaption>
			</figure>
			<div class="full-width tittles navLateral-body-tittle-menu">
				<i class="zmdi zmdi-desktop-mac"></i><span class="hide-on-tablet">&nbsp; VER DETALLES</span>
			</div>
			<nav class="full-width">
				<ul class="full-width list-unstyle menu-principal">

					<!-- INICIO -->
					<li class="full-width">
						<a href="../home.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-home"></i>
							</div>
							<div class="navLateral-body-cr hide-on-tablet">
								INICIO
							</div>
						</a>
					</li>

					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="bien.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-plus"></i>
							</div>
							<div class="navLateral-body-cr hide-on-tablet">
								AGREGAR BIEN
							</div>
						</a>
					</li>
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="inventario.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-folder"></i>
							</div>
							
							<div class="navLateral-body-cr hide-on-tablet">
								INVENTARIO
							</div>
						</a>
					</li>
					<?php
						$rol = $_SESSION['rol'];
						if($rol == 'Administrador'){
							$html = '<li class="full-width divider-menu-h"></li>
         								<li class="full-width">
											<a href="usuarios.php" class="full-width">
												<div class="navLateral-body-cl">
												<i class="zmdi zmdi-account"></i>
												</div>
												<div class="navLateral-body-cr hide-on-tablet">
												USUARIOS
												</div>
											</a>
									</li>';
							echo $html;
						}	
					?>
				</ul>
			</nav>
		</div>
	</section>

	<section class="full-width pageContent">
	<div style="text-align: center; margin-top: 20px" >
		<h5 class="mdl-color-text--primary">Ver Detalles</h5>
  </div>
	

	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id_prod = $_POST['id_prod'];
			$prod = obtener_producto_por_id($conexion, $id_prod);	
		 }		
	?>
	<!-- <script>console.log('holaaa')</script> -->

	<!-- Form -->
      <form class="mdl-grid" action="editar_bien.php" method="post" style="max-width: 800px; margin: 0 auto;">


	  	<div class="mdl-cell mdl-cell--2-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
				<?php
					$html = ' <input class="mdl-textfield__input" type="text" id="id_prod" name="id_prod" required value="'.$id_prod = $_POST['id_prod'].'" readonly>';
		 			echo $html;
				?>
              <label class="mdl-textfield__label" for="id_prod">ID</label>
              <span class="mdl-textfield__error">Este campo es requerido</span>
            </div>
          </div>


          <div class="mdl-cell mdl-cell--10-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
				<?php
					$html = ' <input class="mdl-textfield__input" type="text" id="nombre" name="nombre" required value="'.$prod['nombre'].'" readonly>';
		 			echo $html;
				?>
              <label class="mdl-textfield__label" for="nombre">Nombre General</label>
              <span class="mdl-textfield__error">Este campo es requerido</span>
            </div>
          </div>

          <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled" >
			    <?php
					$html = '<input class="mdl-textfield__input" type="text" id="descripcion" name="descripcion" required value="'.$prod['descripcion'].'" readonly>';
		 			echo $html;
				?>
              <label class="mdl-textfield__label" for="descripcion">Descripción</label>
              <span class="mdl-textfield__error">Este campo es requerido</span>
            </div>
          </div>

        
          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
				<?php
					$html = '<input class="mdl-textfield__input" type="number" id="numero_de_acta" name="numero_de_acta" value="'.$prod['#_acta'].'" readonly>';
		 			echo $html;
				?>
              <label class="mdl-textfield__label" for="numero_de_acta"># Acta</label>
            </div>
          </div>

          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<?php
					$html = '<input class="mdl-textfield__input" type="number" id="anio" name="anio" value="'.$prod['año'].'" readonly>';
		 			echo $html;
				?>
              <label class="mdl-textfield__label" for="anio">Año</label>
            </div>
          </div>

          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
				<?php
					$campus = obtener_campus_por_id($conexion, $id_prod);
					$html = '<input class="mdl-textfield__input" type="text" id="campus" name="campus" value="'.$campus.'" readonly>';
		 			echo $html;
				?>
              
              <label class="mdl-textfield__label" for="campus">Campus</label>
            </div>
          </div>

        <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
			<?php
					$area_de_ubicacion = obtener_ubicacion_por_id($conexion, $id_prod);
					$html = '<input class="mdl-textfield__input" type="text" id="area_de_ubicacion" name="area_de_ubicacion" value="'.$area_de_ubicacion.'" readonly>';
		 			echo $html;
				?>
              <label class="mdl-textfield__label" for="area_de_ubicacion">Área de ubicación</label>
            </div>
        </div>


        <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<?php
					$array_codigo_de_producto = obtener_array_codigo_de_producto($conexion, $id_prod);
					$campus = obtener_campus_por_id($conexion, $id_prod);
					$codigoISTG = $array_codigo_de_producto[0]['codigo'];
					$codigoAdicional = isset($array_codigo_de_producto[1]['codigo'])? $array_codigo_de_producto[1]['codigo']: '';
					$html = '<input class="mdl-textfield__input" type="text" id="codigoISTG" name="codigoISTG" required value="'.$codigoISTG.'" readonly>';
		 			echo $html;
				?>
              
              <label class="mdl-textfield__label" for="codigo">Código ISTG</label>
              <span class="mdl-textfield__error">Este campo es requerido</span>
            </div>
          
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label  div-codigoSENESCYT/SECAP/COLEGIO" id=divCodigo>
		  <?php
					$html = '<input class="mdl-textfield__input" type="text" id="codigoAdicional" name="codigoAdicional" value="'.$codigoAdicional.'" readonly>';
		 			echo $html;
				?>
              
              <label class="mdl-textfield__label" for="codigoAdicional">Código SENESCYT/SECAP/COLEGIO </label>
          </div>
        </div>

          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
				<?php
					$origen = obtener_origen($conexion, $id_prod);
					$html = '<input class="mdl-textfield__input" type="text" id="origen_del_bien" name="origen_del_bien" value="'.$origen.'" readonly>';
		 			echo $html;
				
				?>
              <label class="mdl-textfield__label" for="origen_del_bien">Origen del bien</label>
            </div>
          </div>


          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
			<?php
					$custodio = obtener_custodio($conexion, $id_prod);
					$html = '<input class="mdl-textfield__input" type="text" id="custodio" name="custodio" value="'.$custodio.'" readonly>';
		 			echo $html;
			?>
              <label class="mdl-textfield__label" for="custodio">Custodio</label>
            </div>
          </div>


          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
			<?php
					$proceso_de_adquisicion = obtener_proceso_adquisicion($conexion, $id_prod);
					$html = '<input class="mdl-textfield__input" type="text" id="proceso_de_adquisicion" name="proceso_de_adquisicion" value="'.$proceso_de_adquisicion.'" readonly>';
		 			echo $html;
			?>
              <label class="mdl-textfield__label" for="proceso_de_adquisicion">Proceso de adquisición</label>
            </div>
          </div>

          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
			<?php
					$estado_de_uso = obtener_estado_uso($conexion, $id_prod);
					$html = '<input class="mdl-textfield__input" type="text" id="estado_de_uso" name="estado_de_uso" value="'.$estado_de_uso.'" readonly>';
		 			echo $html;
				?>
              
              <label class="mdl-textfield__label" for="estado_de_uso">Estado de uso</label>
            </div>
          </div>

          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
			<?php
					$estado_fisico = obtener_estado_fisico($conexion, $id_prod);
					$html = '<input class="mdl-textfield__input" type="text" id="estado_fisico" name="estado_fisico" value="'.$estado_fisico.'" readonly>';
		 			echo $html;
				?>
              <label class="mdl-textfield__label" for="estado_fisico">Estado físico</label>
            </div>
          </div>


          <div class="mdl-cell mdl-cell--6-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded is-disabled">
				<?php
					$acta_de_donacion = $prod['acta_de_donacion'];
					switch ($acta_de_donacion) {
						case '1':
							$acta_de_donacion = 'SI';
							break;
						case '0':
							$acta_de_donacion = 'NO';
							break;
						case NULL:
							$acta_de_donacion = '';
							break;
						default:
							$acta_de_donacion = '';
							break;
					}
					$html = '<input class="mdl-textfield__input" type="text" id="acta_de_donacion" name="acta_de_donacion" value="'.$acta_de_donacion.'" readonly>';
		 			echo $html;
				?>
              <!-- <input class="mdl-textfield__input" type="text" id="acta_de_donacion" name="acta_de_donacion" value="SI" readonly> -->
              <label class="mdl-textfield__label" for="acta_de_donacion">Acta de donación</label>
            </div>
          </div>

          <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<?php
					$html = ' <textarea class="mdl-textfield__input" type="text" rows= "3" id="observaciones" name="observaciones" readonly>'.$prod['observaciones'].'</textarea>';
		 			echo $html;
				?>
              <!-- <textarea class="mdl-textfield__input" type="text" rows= "3" id="observaciones" name="observaciones" readonly>Texto predeterminado</textarea> -->
              <label class="mdl-textfield__label" for="observaciones">Observaciones</label>
            </div>
          </div>
        
        <div class="mdl-cell mdl-cell--12-col">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary" type="submit">
              Habilitar Edición 
            </button>
        </div>
    </form>
	</section>
</body>
</html>