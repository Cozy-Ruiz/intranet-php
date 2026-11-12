<?php

$moduloScript = "Login";
$oficinaScript = "";
$listaSistemas = null;

require_once("conexionMasterDB.php");
require_once("compruebaUsuario.php");

$indexSistemas= 0;
 
$s = $MASTER_GE->Execute("SELECT xt_sistema from PERFILES.SISTEMAS where xt_usuario = '$sesionUsuario' AND xt_estatus = 'ACTIVO' ") or die ("Error al seleccionar sistemas <br>");
while($r = $s->fetchRow()){
	$listaSistemas [$indexSistemas] = $r[0];
	$indexSistemas ++;
}

 
	 
//$clienteId= $_REQUEST['clienteId'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Grupo Escalante</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" type="text/javascript" src="https://escalante.com.mx/js/node_modules/jquery/dist/jquery.js"></script> 
	<script type="text/javascript" src="js/interface.js"></script>
	<style>
body{
	overflow-x:hidden;
	background-color: #000000;
}

	 @import url(https://fonts.googleapis.com/css?family=Raleway:400,200,300,800);
figure.snipEibar {
  font-family: 'Raleway', Arial, sans-serif;
  color: #fff;
  position: relative;
  float: left;
  overflow: hidden;   
  min-width: 112px;
  max-width: 112px;
  max-height: 112px;
  width: 100%; 
  text-align: center;
}
figure.snipEibar * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
figure.snipEibar img {
  opacity: 1;
  width: 100%;
  -webkit-transition: opacity 0.35s;
  transition: opacity 0.35s;
}
figure.snipEibar figcaption {
  position: absolute;
  bottom: 0;
  left: 0;
  padding: 1em 1em;
  width: 100%;
  height: 100%;
}
 
figure.snipEibar p {
  margin: 0 0 5px;
  opacity: 0;
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s,-webkit-transform 0.35s,-moz-transform 0.35s,-o-transform 0.35s,transform 0.35s;
}
figure.snipEibar p {
  word-spacing: -0.15em;
  font-weight: 300;
  text-transform: uppercase;
  -webkit-transform: translate3d(0%, 50%, 0);
  transform: translate3d(0%, 50%, 0);
  -webkit-transition-delay: 0.3s;
  transition-delay: 0.3s;
}
 
figure.snipEibar:hover img {
  opacity: 0.35;
}
figure.snipEibar:hover figcaption p {
  opacity: 1;
  -webkit-transform: translate3d(0%, 0%, 0);
  transform: translate3d(0%, 0%, 0);
  -webkit-transition-delay: 0.3s;
  transition-delay: 0.3s;
}

figure.snipEibar:hover figcaption::before {
  background: rgba(255, 255, 255, 0);
  top: 30px;
  bottom: 30px;
  opacity: 1;
  -webkit-transition-delay: 0s;
  transition-delay: 0s;
}
figure.snipEibar figcaption::before {
  position: absolute;
  right: 30px;
  left: 30px;
  border-top: 1px solid rgba(255, 255, 255, 0.8);
  border-bottom: 1px solid rgba(255, 255, 255, 0.8);
  content: '';
  opacity: 0;
  background-color: #ffffff;
  -webkit-transition: all 0.4s;
  transition: all 0.4s;
  -webkit-transition-delay: 0.6s;
  transition-delay: 0.6s;
}



		#color_usuario{
			color:	#039;
			text-align: center;
		}

		#div_centrado{
			margin : 0 auto 0 auto;
		}
		.text-hidde{
			display:none;
		}

		.img{
			display: block;
			max-width: 100%;
			height: auto;
		}
		
		@media (min-width: 1200px){
			.col-lg-1 {
				width: 9.333333%!important;
			}
		}


		@import url(https://fonts.googleapis.com/css?family=Raleway:400,200,300,800);


	</style>
</head>
<body>
<br><br>
<div class="container-fluid" >
	<div class="row">
		<div class="col-md-4"><h4 id="color_usuario"> Usuario: <?php echo $sesionUsuario; ?></h4></div>
		<div class="col-md-4">
			<center><img  class="img-responsive" src='images/Grupo_Escalante_logo.png' width='460' height='260'></center>
			<!--center><img  class="img" src='images/Grupo_Escalante_logo.png'></center-->
		</div>
		<div class="col-md-4"></div>
	</div>
	<br><br><br><br><br><br><br>
	<div class="row ">
		<div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-2 col-xs-offset-2">
			<div class="row">
		<?php if($listaSistemas != ''){ 

			$contadorV=0;
				if(in_array("LINKS", $listaSistemas))
				$contadorV++;
				if(in_array("RADAR", $listaSistemas))
					 $contadorV++;	 
					if(in_array("INTRANET", $listaSistemas))
					 $contadorV++;	 
					if(in_array("EXTRACTOR", $listaSistemas))
					 $contadorV++;	 
					if(in_array("MAILS", $listaSistemas))
					 $contadorV++;	 
					if(in_array("FTPS", $listaSistemas))
					 $contadorV++;	 
					if(in_array("ESTADISTICAS", $listaSistemas))
					 $contadorV++;	if(in_array("REPORTES", $listaSistemas))
					 $contadorV++;	if(in_array("BACKLOG", $listaSistemas))
					 $contadorV++;	


					 if( $contadorV <8 and $contadorV >2)	{	 	?>
				 
				<div class = 'col-lg-1  '  ></div>
		<?php	}



					 if( $contadorV ==2)	{		?>
				<div class = 'col-lg-4 col-md-4 col-sm-3 col-xs-12' ></div>
		<?php	}








			?>



			<?php  if(in_array("LINKS", $listaSistemas)){ ?>

				
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='Links/Controllers/loginController.php'>
						<figure class="snipEibar"> <img src="images/ICN_LinkS.png" alt="Links"/>
							<figcaption>
    							<br> <p>LINKS</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
					 

					 

				<?php if(in_array("LINKS PRUEBAS", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='Links/Controllers/loginController.php?evento=cambiaEntorno&usuario=<?php echo $sesionUsuario; ?>'>
						<figure class="snipEibar"> <img src="images/ICN_LinkS.png" alt="Links"/>
							<figcaption>
    							<br> <p>LINKS PRUEBAS</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
 
			 <?php } ?>
			<?php } ?>
			
			<?php if(in_array("RADAR", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='radar/iniciaSesion.php'>
						<figure class="snipEibar"> <img src="images/ICN_Radar.png" alt="Radar"/>
							<figcaption>
    							<br><p>RADAR</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>

			<?php if ($indexSistemas>2) { ?>
				<div class = 'visible-xs col-xs-12'><br></div>
			<?php } ?>

			<?php if(in_array("INTRANET", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='INTRANET_GEA/iniciaSesion.php'>
						<figure class="snipEibar"> <img src="images/ICN_Intranet.png" alt="Intranet"/>
							<figcaption>
    							<br><p>INTRANET</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php }  ?>

			<?php if ($indexSistemas>3) { ?>
				<div class = ' visible-sm col-sm-12'><br></div>
			<?php } ?>

			<?php if(in_array("EXTRACTOR", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='ExtractorImagenes/iniciaSesion.php'>
						<figure class="snipEibar"> <img src="images/ICN_Extractor.png" alt="Extractor de Imagenes"/>
							<figcaption>
    							<br><p>EXTRACTOR</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>
			<?php if ($indexSistemas>4) { ?>
				<div class = 'visible-xs col-xs-12'><br></div>
			<?php } ?>


			<?php if(in_array("MAILS", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='Mails/iniciaSesion.php'>
						<figure class="snipEibar"> <img src="images/ICN_Mails.png" alt="Mails"/>
							<figcaption>
    							<br><p>MAILS</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>
			
			<?php if(in_array("FTPS", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='FTP/iniciaSesion.php'>
						<figure class="snipEibar"> <img src="images/ICN_ftp.png" alt="Ftp"/>
							<figcaption>
    							<br><p>FTPS</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php }	?>

			<?php if ($indexSistemas>6) { ?>
				<div class = 'visible-sm col-sm-12'><br></div>
				<div class = 'visible-xs col-xs-12'><br></div>
				<div class = 'visible-md col-md-12'><br></div> 
			<?php } ?>
				
			<?php if(in_array("ESTADISTICAS", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='GRAPHICS/iniciaSesion.php'>
						<figure class="snipEibar"> <img src="images/ICN_Estadisticas.png" alt="Estadisticas"/>
							<figcaption>
    							<br><p>ESTADISTICAS</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>
			
			<?php if(in_array("ESTADISTICAS", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='Estadisticas/Controllers/loginController.php'>
						<figure class="snipEibar"> <img src="images/ICN_Estadisticas.png" alt="Estadisticas"/>
							<figcaption>
    							<br><p>ESTADISTICAS 2</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>
			
			<?php if(in_array("REPORTES", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='reporteador/tablero_reportes.php?est=1&usuario=<?php echo $sesionUsuario; ?>'>
						<figure class="snipEibar"> <img src="images/ICN_Reportes.png" alt="Reportes"/>
							<figcaption>
    							<br><p>REPORTES</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>
			<?php if ($indexSistemas>8) { ?>
				<div class = 'visible-xs col-xs-12'><br></div>
			<?php } ?>

			
			<?php if(in_array("REPORTES_2", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='radar/Reportes/administrarUsuarioCliente.php?selectUsuario=<?php echo $sesionUsuario; ?>'>
						<figure class="snipEibar"> <img src="images/ICN_reportes_2.png" alt="Reportes 2"/>
							<figcaption>
    							<br><p>REPORTES 2</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>
			<?php if ($indexSistemas>8) { ?>
				<div class = 'visible-xs col-xs-12'><br></div>
			<?php } ?>



			<?php if(in_array("BACKLOG", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
					<a href='BackLog/iniciaSesion.php'>
						<figure class="snipEibar"> <img src="images/ICN_Backlog.png" alt="Reportes"/>
							<figcaption>
    							<br><p>BACKLOG</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>
			<?php if ($indexSistemas>9) { ?>
				<div class = ' visible-sm col-sm-12'><br></div>
			<?php } ?>

			<?php if(in_array("AUDITORIA DATOS", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
						<a href='AuditoriaDatos/BitacoraArchivos/'>
						<figure class="snipEibar"> 
								<img src="images/ICN_AuditoriaDatos.png" alt="Auditoria de Datos"/>
							<figcaption>
    							<br><p>AUDITORIA DE DATOS</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>

			<?php if(in_array("AUDITORIA DATOS 2", $listaSistemas)){ ?>
				<div class = 'col-lg-1 col-md-2 col-sm-4 col-xs-6' >
						<a href='AuditoriaDatos3/index.php?selectUsuario=<?php echo $sesionUsuario; ?>'>
						<figure class="snipEibar"> 
								<img src="images/ICN_AuditoriaDatos.png" alt="Auditoria de Datos 2"/>
							<figcaption>
    							<br><p>AUDITORIA DE DATOS 2</p>
    						</figcaption>			
						</figure>
					</a>
					<br>
				</div>
			<?php } ?>			
		<?php } ?>
	</div>
	<br><br>
	<div class="row">
		<div class="col-sm-4 col-xs-1"></div>
		<div class="col-sm-4 col-xs-9 col-md-3">
			<div class="row">
				<div class="col-xs-6">
					<a href='cerrarSesion.php'>
						<img height='24' width='90' border='none'; src='images/ICN_cerrar.png'>
					</a>
				</div>
				<div class="col-xs-6">
					<a href='Configuraciones/configuraciones.php'>
						<img height='24' width='95' border='none'; src='images/ICN_configuracion.png'>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
