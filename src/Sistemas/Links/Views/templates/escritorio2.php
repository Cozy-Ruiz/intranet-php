
    <head>
    
    	<title>Documento sin t&iacute;tulo</title>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
       
        <link rel="stylesheet" type="text/css" href="../Views/css/escritorio.css" media="screen" />
        <script LANGUAGE="javascript">
			window.onload = function(){
				AdaptaPantalla();
				setInterval(muestraCierreSesion, 900000);
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
					document.getElementById('navegacion').style.width = 80 + "%";
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
                        	<option value="<?php echo $_SESSION["sesionLinksOficina"]; ?>" selected="selected"><?php echo $_SESSION["sesionLinksOficina"]; ?></option>
                            <?php
							for($a=0; $a<count($oficinasCambioSession); $a++){
								echo '<option type="submit" value="'.$oficinasCambioSession[$a]["XT_OFICINA"].'">'.$oficinasCambioSession[$a]["XT_OFICINA"].'</option>';
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
                	Versión 1.0<br><br>
                    
                    Usuario:<br> 
					
					<?php echo $_SESSION["sesionLinks"]->usuario; ?><br><br>
                    
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
						if(isset($iconosFuncionalidades)){
							echo $iconosFuncionalidades;
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
