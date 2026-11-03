<?php
/*
$tipoDespliegue = "Lista";

$index = 0;

$renglon = 1;

//Omitir secciones 6 y 9 hasta nuevo aviso 
$secciones = 4;
$arrayInicial[$secciones] = array();
$arrayFinal[$secciones] = array();

$lista = array("Lista 1", "Lista 2", "Lista 3", "Lista 4", "Lista 5", "Lista 6", "Lista 7", "Lista 8", "Lista 9", "Lista 10", "Lista 11", "Lista 12", "Lista13", "Lista 14", "Lista 15", "Lista 16", "Lista 17", "Lista 18", "Lista 19", "Lista 20", "Lista 21", "Lista 22", "Lista 23", "Lista24", "Lista 25", "Lista 26", "Lista 27", "Lista 28", "Lista 29", "Lista 30");

$conjunto = array();
$numeroConjunto = 0;
$elementosXdiv = round(count($lista) / ($secciones + 1));

$index = 0;
for($a=0; $a<count($lista); $a++){
	if($index == 0){
		$conjunto[$numeroConjunto] = $lista[$a]."<br>";
	}else if($index < $elementosXdiv){
		$conjunto[$numeroConjunto] .= $lista[$a]."<br>";
	}else{
		$numeroConjunto++;
		$conjunto[$numeroConjunto] = $lista[$a]."<br>";
		$index = 0;
	}
	$index++;
}

for($a=0; $a<count($arrayInicial); $a++){
	$arrayInicial[$a] = $conjunto[$a];//"<div id='elementoLista' class='elementoLista'>$conjunto[$a]</div>";
	$arrayFinal[$a] = "<div id='elementoLista$a' class='elementoLista'>Cozy</div>";
}
*/

/*
$arrayFinal = array();
$a = 0;
$arrayFinal[$a] = "<div  style='width:300px; height:300px;'>Cozy</div>";
*/

?>

    <head>
    
    	<title>Links</title>
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
       
        <link rel="stylesheet" type="text/css" href="../Views/css/escritorio.css" media="screen" />
        <script language='javascript' src="../Views/js/Excepciones.js"></script>
        <script LANGUAGE="javascript">
			window.onload = function(){
				AdaptaPantalla();
				setInterval(muestraCierreSesion, 1800000);
			}
			
			window.onresize = function(){
				AdaptaPantalla();
			}
			
			function AdaptaPantalla(){
				var anchoPantalla=window.innerWidth;
				
				var anchoContainer = document.getElementById('container').clientWidth;
				var anchoMenuLateralIzquierdo = document.getElementById('menuLateralIzquierdo').clientWidth;
				var anchoLogo = document.getElementById('logo').clientWidth;
				
				document.getElementById('barra').style.width = (anchoContainer - (anchoLogo))-1;
				if(anchoMenuLateralIzquierdo == anchoContainer){
					document.getElementById('escritorio').style.width = anchoContainer;
					document.getElementById('navegacion').style.width = anchoMenuLateralIzquierdo - document.getElementById('sesion').clientWidth - 1;
					document.getElementById('navegacionElementos').style.width = document.getElementsByClassName("elemento").length * document.getElementById('elemento').clientWidth;
				}else{
					document.getElementById('escritorio').style.width = (anchoContainer - anchoMenuLateralIzquierdo)-1;
					document.getElementById('navegacion').style.width = 100 + "%";
					document.getElementById('navegacionElementos').style.width = 100 + "%";
				}
				
				//AdaptaLista();
			}
			
			var ID = null;
			function ocultaCierreSesion(intervalID) {
				var manto = document.getElementById('manto');
				var contador = document.getElementById('contadorCierreSesion');
				manto.style.display="none";
				contador.style.display="none";
				clearInterval(ID);
			}
			
			function muestraCierreSesion() {
				var manto = document.getElementById('manto');
				var contador = document.getElementById('contadorCierreSesion');
				var cuentaRegresiva = 20
				manto.style.display="block";
				contador.style.display="block";
				
				contador.getElementsByTagName('td')[0].innerHTML = 'La Sesion se cerrara en : <br><br>'+
						'<progress id="progressBar" value='+cuentaRegresiva+' max='+cuentaRegresiva+'></progress> <br>'+
						'<span>'+cuentaRegresiva+'</span> <br><br>'+
						'<button onClick="ocultaCierreSesion()"><b>Continuar</b></button>';
						
				ID = setInterval(actualizaContador,1000)
			}
			
			function actualizaContador() {
				var contador = document.getElementById('contadorCierreSesion');
				var cuentaMaxima = document.getElementById("progressBar").getAttribute("max");
				var cuentaRegresiva = document.getElementById("progressBar").getAttribute("value");
				if(cuentaRegresiva >= 1){
					cuentaRegresiva = cuentaRegresiva - 1;
					contador.getElementsByTagName('td')[0].innerHTML = 'La Sesion se cerrara en : <br><br>'+
							'<progress id="progressBar" value='+cuentaRegresiva+' max='+cuentaMaxima+'></progress> <br>'+
							'<span>'+cuentaRegresiva+'</span> <br><br>'+
							'<button onClick="ocultaCierreSesion()"><b>Continuar</b></button>';
				}else if(cuentaRegresiva == 0){
					clearInterval(ID);
					location.href='homePageController.php?evento=CierraSession';
				}
			}
			
			function muestraCambiadorOficina() {
				var manto = document.getElementById('manto');
				var cambiador = document.getElementById('cambiadorOficina');
				manto.style.display="block";
				cambiador.style.display="block";
			}

			
			function ocultaCambiadorOficina() {
				var manto = document.getElementById('manto');
				var cambiador = document.getElementById('cambiadorOficina');
				var popUp = document.getElementById('popUp');
				manto.style.display="none";
				cambiador.style.display="none";
				popUp.style.display="none";
			}
			
			function muestraProcesando() {
				var manto = document.getElementById('manto');
				var procesador = document.getElementById('procesando');
				manto.style.display="block";
				procesador.style.display="block";
			}
			
			function ocultaProcesando() {
				var manto = document.getElementById('manto');
				var procesador = document.getElementById('procesando');
				manto.style.display="none";
				procesador.style.display="none";
			}
		</script>
	</head>

    <body>
    	
        <div id="cambiadorOficina" class="overbox" align="center">
			<table height='100%' width='100%'>
				<tr>
					<td align="center">
                    	<form action="homePageController.php" method="POST">
                    	<b>Selecciona oficina</b>
                        <br><br>
                    	<select name="cambiaOficina">
                        	<option value="<?php echo $_SESSION["sesionLinks"]->oficina; ?>" selected="selected"><?php echo $_SESSION["sesionLinks"]->oficina; ?></option>
                            <?php
							for($a=0; $a<count($_SESSION["sesionLinks"]->oficinasDisponibles); $a++){
								if($_SESSION["sesionLinks"]->oficinasDisponibles[$a]["XT_OFICINA"] != $_SESSION["sesionLinks"]->oficina){
									echo '<option type="submit" value="'.$_SESSION["sesionLinks"]->oficinasDisponibles[$a]["XT_OFICINA"].'">'.$_SESSION["sesionLinks"]->oficinasDisponibles[$a]["XT_OFICINA"].'</option>';
								}
							}
							?>
                        </select>
                        <br><br>
                         <input type="submit" value="Enviar">
                        </form>
					</td>
				</tr>
			</table>
		</div>
        <div id="procesando" class="overbox" align="center">
        	<table height='100%' width='100%'>
				<tr>
					<td align="center">
                    	<img src='../Views/img/cargando.gif'/>
					</td>
				</tr>
				<tr id="mensajeLoad">
				</tr>
			</table>
		</div>
		<div id="procesandoDetallado" class="overbox" align="center">
        	<table height='100%' width='100%' align="center">
				<tr>
					<td align="center">
                    	<img src='../Views/img/cargando.gif'/>
					</td>
				</tr>
				<tr id="trDetalle"></tr>
			</table>
		</div>
    	<div id="contadorCierreSesion" class="overbox" align="center" >
			<table height='100%' width='100%'>
				<tr>
					<td align="center">
					</td>
				</tr>
			</table>
		</div>
		<div id="popUp" class="overbox" align="center" ></div>
		<div id="manto" class="fadebox" onClick="ocultaCambiadorOficina()">&nbsp;</div>
        
    	<div id="container">
         
        	<div id='barraSuperior'>
                <div id='logo'>
                    <img  src="../Views/img/LogoGEA.png">
                </div>
                <div id="barra">
                    <div id='modulo'>
                        <div align="center"><?php echo $tituloEscritorio ?></div>
                    </div>
                    <div id='breadCrumb'>
                        <div align="center"><?php if(isset($session)){echo $session->showBreadCrumbs();} ?></div>
                    </div>
                </div>
            </div>
         
			<div id="menuLateralIzquierdo" align="center">
            	<div id="sesion" >
                	<table  border="0" width="80%" >
                        <tr valign="middle">
                            <td align="center">
                                <IMG href="javascript:void(0)" onClick="muestraCambiadorOficina()" SRC="../Views/img/ICN_BotonOficina.png">
                            </td>
                            <td align="center">
                                <a href="../Controllers/homePageController.php?evento=CierraSession"><IMG SRC="../Views/img/ICN_BotonCierreSesion.png"></a>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div id="informacionUsuario" align="left">
                	Versión 2.0<br><br>
                    
                    Usuario:<br> 
					<div id="nickName"><?php echo $_SESSION["sesionLinks"]->usuario; ?></div>
					<br><br>
                    

                    <b><?php echo $_SESSION["sesionLinks"]->oficina; ?></b>
                    
                    <br><br>
                    
                	<table border="0" width="100%">
                        <tr>
                        	<td id="whiteLine"></td>
                        </tr>
                    </table>
                </div>
                
                <div id="navegacion">
                	<div id="navegacionElementos">
                    	<?php
						if(isset($barraFuncionalidades)){
							echo $barraFuncionalidades;
						}
						?>
                    </div>
                </div>
                
            </div><!-- fin del div del menu izquierdo -->
            
           	<div id="escritorio">
            	<?php
					for($a=0; $a<count($arrayFinal); $a++){
						echo $arrayFinal[$a];
					}
				?>
        	</div><!-- fin de escritorio -->
         
    	</div><!-- fin del container-->
	</body>
    
</html>
