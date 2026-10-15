<?php error_reporting(0); ?>
<?php
//Created by Cosijopi Richard Ruiz Avendaño
//Ing. Sistemas Computacionales

$nombrephp = 'BusquedaMultipleMV.php';
require_once("conexionDB.php");

$clientes = array();
$index = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Manifestaciones de valor</title>
	<style>
		#WindowLoad
			{
				position:fixed;
				top:0px;
				left:0px;
				z-index:3200;
				/*filter:alpha(opacity=10);   
			   -moz-opacity:10;   
				opacity:0.10;
				background:#999;*/
			}
    </style>
	<?php
		$estiloUsuario = $_GET['est'];
		$rr = $estiloUsuario;
		if($estiloUsuario == 1){
			echo "<link type='text/css' rel='stylesheet' href='css/styleHomePage.css'/>";
		}else if($estiloUsuario == 2){
			echo "<link type='text/css' rel='stylesheet' href='css/styleHomePage2.css'/>";
		}
	?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hojas de cálculo y Manifestaciones de Valor</title>
    <!--script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.7.1.min.js"></script-->
     <script language="javascript" type="text/javascript" src="JQuery/js/jquery-1.3.2.min.js"></script>
     <script type="text/javascrip" src="JQuery/js/jquery-1.2.6.min.js"></script>
    <script>

	function descargar_HC(referencia, tipo, cantidad, individual){    //Funcion para descargar archivos HC solo de una referencia
			/// Aqui podemos enviarle alguna variable a nuestro script PHP
			var referencia1 = referencia;
			var tipo1 = tipo;
			var cantidad1 = cantidad;
			var tipoDescarga =  individual;
			var representante = null
			var radio = document.form1.RS;//Obtenemos el valor seleccionado de l formulario de representantes (blanco, correspondiente u otro)
					for(i=0;i<radio.length;i++){
						if(radio[i].checked) {
							representante =  radio[i].value;
								if(representante == 'actual'){
									var radioR = document.form1.representanteOtro;
									if(radioR.checked){
										if(radioR.value != 'undefined'){
											representante = radioR.value;
										}
									}else if(radioR.length >1){
										for(b=0;b<radioR.length;b++){
												if(radioR[b].checked){representante = radioR[b].value;}//Valor del representante seleccionado
										}
									}
								}
							}
						}
			
			if(cantidad1 == 1 && tipo == 'HC'){ //Si las partes de la referencia son 1 solo descarga la HC
					var anexo = 'NO';
					$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1, individual : tipoDescarga, representante1 : representante, anexo1 : anexo, HC : 'HC'} , function(data){
						window.location = "file.php?file="+data;
					});
			}else if(cantidad >1 && tipo == 'HC'){//Si tiene mas de una parte genera el HC y su anexo
				tipoDescarga = 'ANEXO';
				var AHC= 'AHC';
				$.post("crearCarpeta_MV_HC.php",{referencia : referencia1,tipo : tipo1, tipoDescarga1 : tipoDescarga }, function(data){
					jsShowWindowLoad('Creando carpeta');
					$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1, individual : tipoDescarga, representante1 : representante , anexo1 : 'NO',HC  :'HC'} , function(data){
						jsShowWindowLoad('Creando hoja de cálculo');
						$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1, individual : tipoDescarga, anexo1 : 'SI', AHC1 : AHC} , function(data){
							jsShowWindowLoad('Creando anexo');
							$.post("generaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
								jsShowWindowLoad('Creando zip');
								$.post("descargaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
									jsRemoveWindowLoad();
									window.location = "descargaZip.php?referencia="+referencia1+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
								});
							});
						});							
					});
				});
			}         
		}

	function descargar_MV(referencia, tipo, cantidad, individual,metodoValoracion){//Funcion para descargar el MV de una referencia
		var referencia1 = referencia;
		var tipo1 = tipo;
		var cantidad1 = cantidad;
		var tipoDescarga = individual;
		var metodoValoracion1 = metodoValoracion;
		var representante = null;
		var radio = document.form1.RS;//Obtenemos el valor seleccionado de l formulario de representantes (blanco, correspondiente u otro)
				for(i=0;i<radio.length;i++){
					if(radio[i].checked) {
						representante =  radio[i].value;
							if(representante == 'actual'){
								var radioR = document.form1.representanteOtro;
								if(radioR.checked){
									if(radioR.value != 'undefined'){
										representante = radioR.value;
									}
								}else if(radioR.length >1){
									for(b=0;b<radioR.length;b++){
											if(radioR[b].checked){representante = radioR[b].value;}//Valor del representante seleccionado
									}
								}
							}
						}
					}
		if(metodoValoracion1 == 1 && tipo == 'MV'){//Si el metodo de valoracion es 1 se genera solo el MV
			var anexo = 'NO';
			$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1, individual : tipoDescarga, representante1 : representante, metodoValoracion1 : metodoValoracion, anexo1 : anexo, MV : 'MV'} , function(data){
				window.location = "file.php?file="+data;			    
			});
		}else if(metodoValoracion1 == 0 && tipo == 'MV'){ //Si el metodo de valoracion  0 se genera el MV y anexo
			tipoDescarga = 'ANEXO';
			var anexo = 'SI';
			var AMV= 'AMV';
			$.post("crearCarpeta_MV_HC.php",{referencia : referencia1,tipo : tipo1, tipoDescarga1 : tipoDescarga }, function(data){
				jsShowWindowLoad('Creando carpeta');
				$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1 , individual : tipoDescarga, representante1 : representante, anexo1 : 'NO', MV  : 'MV'} , function(data){
					jsShowWindowLoad('Creando manifestación de valor');
					$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1 , individual : tipoDescarga ,  metodoValoracion1 : metodoValoracion, anexo1 : 'SI', AMV1 : AMV} , function(data){
						jsShowWindowLoad('Creando anexo');
						$.post("generaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
							jsShowWindowLoad('Creando zip');
							$.post("descargaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
								jsRemoveWindowLoad();
								window.location = "descargaZip.php?referencia="+referencia1+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
							});
						});
					});
				});
			});
		}
	}

	function descargar_referencia_MV_HC(referencia, tipo, cantidad,individual, metodoValoracion){//Funcion para descargar el MV y HC de una referencia
		var referencia1 = referencia;
		var tipo1 = tipo;
		var cantidad1 = cantidad;
		var tipoDescarga = individual;
		var representante = null;
		var metodoValoracion1 = metodoValoracion;
		var radio = document.form1.RS;//Obtenemos el valor seleccionado de l formulario de representantes (blanco, correspondiente u otro)
				for(i=0;i<radio.length;i++){
					if(radio[i].checked) {
						representante =  radio[i].value;
							if(representante == 'actual'){
								var radioR = document.form1.representanteOtro;
								if(radioR.checked){
									if(radioR.value != 'undefined'){
										representante = radioR.value;
									}
								}else if(radioR.length >1){
									for(b=0;b<radioR.length;b++){
											if(radioR[b].checked){representante = radioR[b].value;}//Valor del representante seleccionado
									}
								}
							}
						}
					}
		if(cantidad1 == 1){//Si la cantidad de partidas es 1 del HC
			var anexo = 'NO';
			$.post("crearCarpeta_MV_HC.php",{referencia : referencia1,tipo : tipo1, tipoDescarga1 : tipoDescarga }, function(data){
				jsShowWindowLoad('Creando carpeta');
				$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1, individual : tipoDescarga , representante1 : representante, anexo1 : anexo, HC : 'HC'} , function(data){
					jsShowWindowLoad('Creando hoja de cálculo');
					if(metodoValoracion == 1){//Si el metodo de valoracion de los MV es 1
						$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1 , individual : tipoDescarga, representante1 : representante, anexo1 : anexo, MV : 'MV'} , function(data){
							jsShowWindowLoad('Creando manifestación de valor');
							$.post("generaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
								jsShowWindowLoad('Creando zip');
								$.post("descargaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){	
									jsRemoveWindowLoad();				
									window.location = "descargaZip.php?referencia="+referencia1+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
								});
							});	
						});	
					}else if(metodoValoracion == 0){//Si el metodo de valoracion de los MV es 0
						$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1 , individual : tipoDescarga, representante1 : representante, anexo1 : 'NO', MV : 'MV'} , function(data){
							jsShowWindowLoad('Creando manifestación de valor');
							$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1 , individual : tipoDescarga,  metodoValoracion1 : metodoValoracion, anexo1 : 'SI', AMV1 : 'AMV' } , function(data){
								jsShowWindowLoad('Creando anexo');
								$.post("generaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
									jsShowWindowLoad('Creando zip');
									$.post("descargaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
										jsRemoveWindowLoad();				
										window.location = "descargaZip.php?referencia="+referencia1+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
									});	
								});	
							});	
						});	
					}
				});
			});	
		}else if(cantidad1 > 1){//Si la cantidad de partidas es mayor de 1 del HC
				tipoAnexo = 'Anexo';
				$.post("crearCarpeta_MV_HC.php",{referencia : referencia1,tipo : tipo1, tipoDescarga1 : tipoDescarga }, function(data){
					jsShowWindowLoad('Creando carpeta');
					$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1, individual : tipoDescarga, representante1 : representante, anexo1 : 'NO' , HC: 'HC'} , function(data){
						jsShowWindowLoad('Creando hoja de cálculo');
						$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1, individual : tipoDescarga, anexo1 : 'SI', AHC1 : 'AHC'} , function(data){
							jsShowWindowLoad('Creando anexo');
							if(metodoValoracion == 1){//Si el metodo de valoracion de los MV es 1
								$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1 , individual : tipoDescarga, representante1 : representante, anexo1 : 'NO', MV : 'MV'} , function(data){
									jsShowWindowLoad('Creando manifestación de valor');
									$.post("generaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
										jsShowWindowLoad('Creando zip');
										$.post("descargaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
											jsRemoveWindowLoad();				
											window.location = "descargaZip.php?referencia="+referencia1+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
										});	
									});	
								});	
							}else if(metodoValoracion == 0){//Si el metodo de valoracion de los MV es 0
								tipoAnexo = 'Anexo';
								$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1 , individual : tipoDescarga, representante1 : representante, anexo1 : 'NO', MV : 'MV'} , function(data){
									jsShowWindowLoad('Creando manifestación de valor');
									$.post("control_Descargas.php", { referencia: referencia1, tipo : tipo1, cantidad : cantidad1 , individual : tipoDescarga ,  metodoValoracion1 : metodoValoracion,anexo1 : 'SI' , AMV1 : 'AMV' } , function(data){
										jsShowWindowLoad('Creando anexo');
										$.post("generaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
											jsShowWindowLoad('Creando zip');
											$.post("descargaZip.php", {referencia: referencia1, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
												jsRemoveWindowLoad();					
												window.location = "descargaZip.php?referencia="+referencia1+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
											});	
										});	
									});	
								});	
							}
						});	
					});							
				});
		} 
	}
			
	function descargarTodos_MV(referencias,tipo, tipoDescarga){
		var aleatorio = Math.floor((Math.random() * 10000) + 1000);//Generamos un numero aleatorio para la carpeta temporal que contendra los documentos
		var array = referencias.toString(); //convertimos el array de las referencias a un string
		var tipoDescarga1 = tipoDescarga;
		var individual = tipoDescarga;
		 var tipo1 = tipo;
		 var cantidad = 0;
		 var representante = null;
		var radio = document.form1.RS;
		for(i=0;i<radio.length;i++){
			if(radio[i].checked) {
				representante =  radio[i].value;
				if(representante == 'actual'){
					var radioR = document.form1.representanteOtro;
					if(radioR.checked){
						if(radioR.value != 'undefined'){
							representante = radioR.value;
						}
					}else if(radioR.length >1){
						for(b=0;b<radioR.length;b++){
							if(radioR[b].checked){representante = radioR[b].value;}//Valor del representante seleccionado
						}
					}
				}
			}
		}
		$.post("crearCarpeta_MV_HC.php",{referencia : aleatorio,tipo : tipo1, tipoDescarga1 : tipoDescarga }, function(data){
				tipoAnexo = 'Anexo';
				jsShowWindowLoad('Creando carpeta');
			$.post("control_Descargas.php", {referencia: array ,tipo : tipo1, cantidad : cantidad,individual : tipoDescarga, aleatorio1 : aleatorio, representante1 : representante, anexo1 : 'NO', MV1 : 'MV'}, function(data){
				jsShowWindowLoad('Creando manifestaciones de valor');
				$.post("control_Descargas.php", {referencia: array,tipo : tipo1, cantidad : cantidad,individual : tipoDescarga, aleatorio1 : aleatorio,  anexo1 : 'SI', AMV1 : 'AMV'}, function(data){	
					jsShowWindowLoad('Creando anexos');
					$.post("generaZip.php", {referencia: aleatorio, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
							jsShowWindowLoad('Creando zip');
							$.post("descargaZip.php", {referencia: aleatorio, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
								jsRemoveWindowLoad();
								window.location = "descargaZip.php?referencia="+aleatorio+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
							});
						});																
					});	
				});															
			});	
		}
					
	function descargarTodos_HC(referencias,tipo, tipoDescarga){
		var aleatorio = Math.floor((Math.random() * 10000) + 1000);
		var array = referencias.toString();						
		var tipoDescarga1 = tipoDescarga;
		var individual = tipoDescarga;
		 var tipo1 = tipo;
		 var cantidad = 0;
		  var representante = null;
		var radio = document.form1.RS;
		for(i=0;i<radio.length;i++){
			if(radio[i].checked) {
				representante =  radio[i].value;
				if(representante == 'actual'){
					var radioR = document.form1.representanteOtro;
					if(radioR.checked){
						if(radioR.value != 'undefined'){
							representante = radioR.value;
						}
					}else if(radioR.length >1){
						for(b=0;b<radioR.length;b++){
							if(radioR[b].checked){representante = radioR[b].value;}//Valor del representante seleccionado
						}
					}
				}
			}
		}
		$.post("crearCarpeta_MV_HC.php",{referencia : aleatorio,tipo : tipo1, tipoDescarga1 : tipoDescarga }, function(data){
				tipoAnexo = 'Anexo';
				jsShowWindowLoad('Creando carpeta');
			$.post("control_Descargas.php", {referencia: array ,tipo : tipo1, cantidad : cantidad,individual : tipoDescarga, aleatorio1 : aleatorio, representante1 : representante,anexo1 : 'NO', HC1 : 'HC'}, function(data){
				jsShowWindowLoad('Creando hojas de cálculo');
				$.post("control_Descargas.php", {referencia: array,tipo : tipo1, cantidad : cantidad,individual : tipoDescarga, aleatorio1 : aleatorio,  anexo1 : 'SI', AHC1 : 'AHC'}, function(data){	
					jsShowWindowLoad('Creando anexos');
					$.post("generaZip.php", {referencia: aleatorio, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
						jsShowWindowLoad('Creando zip');
						$.post("descargaZip.php", {referencia: aleatorio, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
							jsRemoveWindowLoad();
							window.location = "descargaZip.php?referencia="+aleatorio+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
						});
					});																		
				});	
			});															
		});	
	}
                
				
	function descargarTodos_FULL(referencias,tipo, tipoDescarga){
			var aleatorio = Math.floor((Math.random() * 10000) + 1000);	
			var array = referencias.toString();						
			var tipoDescarga1 = tipoDescarga;
			 var tipo1 = tipo;
			 var cantidad = 0;
			  var representante = null;
			var radio = document.form1.RS;
			for(i=0;i<radio.length;i++){
				if(radio[i].checked) {
					representante =  radio[i].value;
					if(representante == 'actual'){
						var radioR = document.form1.representanteOtro;
						if(radioR.checked){
							if(radioR.value != 'undefined'){
								representante = radioR.value;
							}
						}else if(radioR.length >1){
							for(b=0;b<radioR.length;b++){
								if(radioR[b].checked){representante = radioR[b].value;}//Valor del representante seleccionado
							}
						}
					}
				}
			}
			$.post("crearCarpeta_MV_HC.php",{referencia : aleatorio,tipo : tipo1, tipoDescarga1 : tipoDescarga }, function(data){
					tipoAnexo = 'Anexo';
					jsShowWindowLoad('Creando carpeta');
				$.post("control_Descargas.php", {referencia: array ,tipo : tipo1, cantidad : cantidad,individual : tipoDescarga, aleatorio1 : aleatorio, representante1 : representante,anexo1 : 'NO', MV1 : 'MV'}, function(data){
					jsShowWindowLoad('Creando manifestaciones de valor');
					$.post("control_Descargas.php", {referencia: array,tipo : tipo1, cantidad : cantidad,individual : tipoDescarga, aleatorio1 : aleatorio, anexo1 : 'SI', AMV1 : 'AMV'}, function(data){	
						jsShowWindowLoad('Creando anexos');
						$.post("control_Descargas.php", {referencia: array ,tipo : tipo1, cantidad : cantidad,individual : tipoDescarga, aleatorio1 : aleatorio, representante1 : representante, anexo1 : 'NO', HC1 : 'HC'}, function(data){
							jsShowWindowLoad('Creando hojas de cálculo');
							$.post("control_Descargas.php", {referencia: array,tipo : tipo1, cantidad : cantidad,individual : tipoDescarga, aleatorio1 : aleatorio, anexo1 : 'SI', AHC1 : 'AHC'}, function(data){	
								jsShowWindowLoad('Creando anexos');
								$.post("generaZip.php", {referencia: aleatorio, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
									jsShowWindowLoad('Creando zip');
									$.post("descargaZip.php", {referencia: aleatorio, tipo : tipo1, tipoDescarga1 : tipoDescarga}, function(data){
										jsRemoveWindowLoad();
										window.location = "descargaZip.php?referencia="+aleatorio+"&tipo="+tipo1+"&tipoDescarga="+tipoDescarga;
									});
								});		
							});
						});
					});	
				});															
			});	
		}					
					
	function mostrarValor(valor){//Fincion para mostrar los representantes del RFC que seleccionen
		var referencias = arrayReferencias.toString();
		$.post("muestraRepresentantes.php",{rfcCliente : valor, referencias1 : referencias}, function (data){
			$("#representantes").html(data);//id donde se mostrara elresultado
			$.post("verificaReferencias.php",{rfcCliente : valor, referencias1 : referencias},function (data){//Verifica que las referencias que se buuscan pertenezcan al RFC seleccionado
				$("#contenedorReferencias").html(data);//Actuualiza si es necesario la lista de referencias
			});
		});
	}
					
	function agregaNuevo(){//Agregar el nuevo nombre del representante
			var nombre = $('input:text[name=nombre]').val();
			var rfc = $('input:text[name=rfc]').val();
			var rfcCliente = document.getElementsByName("rfcs")[0].value;
			$.post("agregarNuevoRepresentante.php",{ nombre1 : nombre, rfc1 : rfc, rfcCliente1 : rfcCliente}, function (data){
				$("#representantes").html(data);//id donde mostrara el resultado
			});
	}
						
	function mostarSelects(){//Funcion que muestra el select de RFC, cuando se selecciona la opcion de "otro"
		if (document.form1.RS[2].checked == true) {
			//muestra (cambiando la propiedad display del estilo) el div con id 'desdeotro'
			$('.actual').show();
			//por el contrario, si no esta seleccionada
		} else if(document.form1.RS[0].checked == true || document.form1.RS[1].checked == true  ){//Se oculta el select cuando se elije otra opcion
			$('.actual').hide();
			$('.cp_oculta').hide();
		}
	}
				
	function MostrarOcultar(capa) {//Funcion para mostrar u ocultar el formulario para agregar un nunevo representante
		var vCambio=document.getElementById(capa);
			if(vCambio.style.display == 'block') {
				 vCambio.style.display = 'none';
			} else {
				 vCambio.style.display = 'block';
			}
	} 
	
</script>
<script>
		
	//Funciones que muestran el proceso de elaborar y descargar los archivos
	function jsRemoveWindowLoad() {
		// eliminamos el div que bloquea pantalla
		$("#WindowLoad").remove();
	
	}
			
	function jsShowWindowLoad(mensaje) {
		//eliminamos si existe un div ya bloqueando
		jsRemoveWindowLoad();
	   
		//si no enviamos mensaje se pondra este por defecto
		if (mensaje === undefined) mensaje = "Procesando la información<br>Espere por favor";
	   
		//centrar imagen gif
		height = 20;//El div del titulo, para que se vea mas arriba (H)
		var ancho = 0;
		var alto = 0;
		
		//obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
		if (window.innerWidth == undefined) ancho = window.screen.width;
		else ancho = window.innerWidth;
		if (window.innerHeight == undefined) alto = window.screen.height;
		else alto = window.innerHeight;
		
		//operación necesaria para centrar el div que muestra el mensaje
		var heightdivsito = alto/2 - parseInt(height)/2;//Se utiliza en el margen superior, para centrar
		
	   //imagen que aparece mientras nuestro div es mostrado y da apariencia de cargando
		imgCentro = "<div style='margin:0 auto 0 auto;text-align:center;width:20%;;background:rgb(225,226,228);'><div  style='color:#000;margin-top:" + heightdivsito + "px; font-size:20px;font-weight:bold'>" + mensaje + "</div><img  src='Imagenes/load.gif'></div>";
	
			//creamos el div que bloquea grande
			div = document.createElement("div");
			div.id = "WindowLoad"
			div.style.width = ancho + "px";
			div.style.height = alto + "px";
			$("body").append(div);
	
			//creamos un input text para que el foco se plasme en este y el usuario no pueda escribir en nada de atras
			input = document.createElement("input");
			input.id = "focusInput";
			input.type = "text"
	
			//asignamos el div que bloquea
			$("#WindowLoad").append(input);
			
			//asignamos el foco y ocultamos el input text 
			$("#focusInput").focus();
			$("#focusInput").hide();
			
			//centramos el div del texto
			$("#WindowLoad").html(imgCentro);
	}
			
</script>
    <style type="text/css">
		.overbox {
			display: none;
			position: absolute;
			background: white;
			width: 20%;
			height: 20%;
			top: 40%;
			left: 40%;
			border-radius: 30px;
			z-index:1002;
			overflow: auto;
		}
		.fadebox {
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.75;
			opacity:.75;
			filter: alpha(opacity=80);
		}
		img.imgD{
			width:15px;
			height:15px;
		}

	</style>
    
</head>

<body>
<?php
//Cuerpo dell formulario de inicio
echo "<div id='wrapperPopUp' style='margin:0 auto 0 auto;font-family:Lucida Sans'>";
	echo "<form name='form1' method='POST' action='BusquedaMultipleMV.php?est=$rr'>";
	
	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
				echo "<font>Manifestaciones de Valor y<br> Hojas de Cálculo</font>";
				echo"</td>";
			echo"</tr>";
		
			echo"<tr height='30'> </tr>";
			
			echo "<tr>";
				echo "<td  width='800' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
			
		echo "</table>"; 
	
	echo "<table width='800' style='margin:0 auto 0 auto;'>";
		echo "<tr>";
		echo "<td valign='top'>";	
		//FORMULARIO
			echo "<center>";
				echo "<select name='tipo'>";
				echo "<option value='Pedimento'>Pedimento</option>";
				echo "<option value='Referencia'>Referencia</option>";
				echo "</select>";
				echo "<br>";
				echo"<p style='color: #4682B4;'>Ejemplo de Pedimento:</p><p style='color: #4682B4;'> 15 47 3061 1234567</p>";
			  echo "<textarea cols=18 rows=15 name ='datos'></textarea>";	
			  echo "<br><br>";		
			  echo "<input type='submit' name='enviar' value='Enviar'>";
			echo "</center>";
		//FIN DEL FORMULARIO
		echo "</td>";
		echo "<td width='550' style='margin:0px auto;' valign='top'>";		
		
	if(isset($_POST['enviar'])){//Si se da click en el boton "enviar" ejecuta lo sig. dependiendo de la opcion (pedimento, referencia)
		echo "<table width='550' style='margin:0px auto;' valign='top'>";
		if($_POST['tipo'] == 'Pedimento'){//BUSQUEDA POR PEDIMENTO
			$datos = explode('||',eregi_replace("[\n|\r|\n\r]", '|', trim($_POST['datos'])));//Se obtiene el array de refrencias del textarea
				echo "<tr>";
				echo "<td></td>";
					echo "<td style='color: #4682B4;font-size:16px;'><strong>Opciones:</strong></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td></td>";
					echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'></tr>";
				echo "<tr>";
					echo "<td></td>";
					echo "<td colspan='3' font-size:14px;'>";
						echo "<strong>Representante legal:</strong>";
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'></tr>";
				echo "<tr  id='product1'>";
					echo "<td></td>";
					echo "<td align='center'>";
						echo "En blanco <input type='radio' name='RS'   value='blanco' onclick='javascript:mostarSelects();'>";
					echo "</td>";
					echo "<td align='center'>";
						echo "Correspondiente <input type='radio' name='RS'   value='correspondiente' checked='checked' onclick='javascript:mostarSelects();'>";
					echo "</td>";
					echo "<td align='center'>";
						echo "Otro <input type='radio' name='RS'  value='actual' onclick='javascript:mostarSelects();'>"; //NOMBRE DE OTRO REPRESENTANTE 
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td></td>";
					echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'></tr>";
				echo "</table>";
				echo "<table width='400' style='display:none;margin:0px auto;float:right;' valign='top'  class='actual'>";//Tabla del select de RFC´s
					echo "<tr >";
						echo "<td></td>";
						echo "<td align='left' colspan='2'>";
							echo "<p style='color:#4682B4;'>RFC:</p>";
							echo "<select name='rfcs' onchange='mostrarValor(this.value);'>";
								echo "<option value='selecciona......'>Selecciona......</option>";
								$RFC = $masterGE->Execute("SELECT DISTINCT xt_rfc FROM MASTER_RFC_CLIENTEID WHERE xt_rfc NOT IN ('', 'TODOS','.','65-0600569')  ORDER BY xt_rfc ASC");
								while($f = $RFC->fetchRow()){
									echo "<option value='".$f[0]."'>".$f[0]."</option>";
								}
							echo "</select>";
						echo "</td>";
						echo "<td align='right'>";
						?>
							<a href="javascript:MostrarOcultar('formNuevo'); "><img src="Imagenes/ICN_BotonMas.png" style="width:15%;margin-bottom:-23px;"></a><!--Imagen que muestra u oculta el formulario para el nuevo representante-->
						<?php
                        echo "</td>";
					echo "</tr>";
					echo "<tr height='5'></tr>";
					echo "<tr >";
						echo "<td></td>";
						echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					  echo "</td>";
					echo "</tr>";
				echo "</table>";
				echo "<table width='400' style='display:none;margin:0px auto;float:right;' valign='top' id='formNuevo' class='cp_oculta'>";//Formulario para agregar el nuevo representante
					echo "<tr>";
							echo "<td width='100'>";
								echo "<center><input type='text' name='nombre' placeholder='Nombre Completo'></center>";
							echo "</td>";
							 echo "<td width='100'>";
								echo "<center><input type='text' name='rfc' placeholder='RFC'></center>";
							echo "</td>";
							echo "<td width='200'>";
								echo "<center><a href='javascript:void(0);' onclick = 'agregaNuevo();'><img name='nombre' src='Imagenes/ICN_BotonAgregar.png' width='100'  height='23'  ></a></center>";
							echo "</td>";
						echo "</tr>";
				echo "</table>";
				echo "<table width='400' style='margin:0px auto;float:right;' valign='top' id='representantes' class='actual'>";//Despues de ejecutar la funcion agregarNuevo se actualizara la lista dentro de esta tabla
				echo "</table>";
				echo "<table width='550' style='margin:0px auto;' valign='top' id='contenedorReferencias'>";//Resultado de la busqueda
				echo "<tr height='20'></tr>";
				echo "<tr>";
					echo "<td align='center'>";
					echo "</td>";
					echo "<td align='center' style='color: #4682B4;'>";
						echo "<strong>MV</strong>";
					echo "</td>";
					echo "<td align='center' style='color: #4682B4;'>";
						echo "<strong>HC</strong>";
					echo "</td>";
					echo "<td align='center' style='color: #4682B4;'>";
						echo "<strong>MV y HC</strong>";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td></td>";
					echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'></tr>";

			for($a=0;$a<count($datos);$a++){
				$nuevoPedimento = explode(" ",trim($datos[$a]));// Separamos los valores del pedimento
				$pedimentoNuevo = $nuevoPedimento[2]."-".$nuevoPedimento[3];
				$year = $nuevoPedimento[0];
				$aduanaPedimento = $nuevoPedimento[1];
				//echo "<br>";
				if($aduanaPedimento == 47){
					$aduanaPedimento1 = 470;
				}else if($aduanaPedimento == 80){
					$aduanaPedimento1 = 800;
				}else if($aduanaPedimento == 16){
					$aduanaPedimento1 = 160;
				}else if($aduanaPedimento == 24){
					$aduanaPedimento1 = 240;
				}else if($aduanaPedimento == 65){
					$aduanaPedimento1 = 650;
				}else if($aduanaPedimento == 70){
					$aduanaPedimento1 = 70;
				}else if($aduanaPedimento == 71){
					$aduanaPedimento1 = 71;
				}else if($aduanaPedimento == 43){
					$aduanaPedimento1 = 430;
				}else if($aduanaPedimento == 47){
					$aduanaPedimento1 = 470;
				}else if($aduanaPedimento == 20){
					$aduanaPedimento1 = 200;
				}else if($aduanaPedimento == 53){
					$aduanaPedimento1 = 530;
				}else if($aduanaPedimento == 64){
					$aduanaPedimento1 = 647;
				}

				$index = 0;
				$query = "SELECT xt_referencia FROM MASTER_PEDIMENTOS WHERE kp_pedimento = '$pedimentoNuevo' AND xn_aduana = '$aduanaPedimento1' AND YEAR(xd_fechaPago) LIKE '%$year%'";
				//echo "<br>";
				$q = $masterGE->Execute($query);
				while($t = $q->fetchRow()){
					$referencia[$a] = $t[0];
					//Verificamos la existencia de las referencias
					$queryHC = $masterGE->getOne("SELECT count(xt_tipo) FROM MASTER_MANISFESTACION_DE_VALOR WHERE xt_referencia = '$t[0]' AND xt_tipo = 'HC'");
					$queryMV = $masterGE->getOne("SELECT count(xt_tipo) FROM MASTER_MANISFESTACION_DE_VALOR WHERE xt_referencia = '$t[0]' AND xt_tipo = 'MV'");

					if($queryMV == 0){$MV[$a] = 'Ref N/D';}else{$MV[$a] = 'S';}
					if($queryHC == 0){$HC[$a] = 'Ref N/D';}else{$HC[$a] = 'S';}
					
				}
		
			}

			for($b=0;$b<count($referencia);$b++){//Recorremos las referencias y sus vaalores
				echo "<tr>";
					echo "<td align='center'>";
						echo $referencia[$b];
					echo "</td>";
					echo "<td align='center'>";
					$y = $masterGE->Execute(
													"SELECT
														xn_fraccionArancelaria,
														xt_descripcionMercancia,
														xn_valorFacturaUSD,
														xn_cantidadMercanciaComercializacion,
														xn_claveUnidadMedidaTarifa,
														xt_clavePaisOrigen,
														xt_clavePaisDestino
													FROM
														MASTER_PARTIDAS
													WHERE
														xt_referencia = '$referencia[$b]'
													"
													);
						$total = $y->recordCount();//Obtenemos el numero departidas de la referencia
						
						if($MV[$b] == 'S'){//Si es MS significa que se encontro algun valor para MV
							$valor = 'MV';							
											//Obtenemos el metodo de valoracion
											$metodoValoracion = $masterGE->getOne("SELECT xt_valor FROM MASTER_MANISFESTACION_DE_VALOR WHERE xt_referencia = '$referencia[$b]' and xt_tipo = 'MV' AND xn_seccion = 12 AND xn_inciso = 1 AND xt_valor = 'VER ANEXO'");
											if(!empty($metodoValoracion)){$metodoValoracion = 0;}else{$metodoValoracion = 1;}
							?>
                            	<!--Generamos el link con la funcion  para descargar la MV-->
								<a href='javascript:void(0);' onclick='javascript:descargar_MV("<?php echo $referencia[$b]; ?>","MV",<?php echo $total; ?>,"INDIVIDUAL",<?php echo $metodoValoracion; ?>)'><img class='imgD' src='Imagenes/Boton_Verde.png'></a>
							<?php
						}else{//Si no es S solo muestra  Ref N/D
							echo $MV[$b];
						}
					echo "</td>";
					echo "<td align='center'>";
					
					if($HC[$b] == 'S'){//Si es S significa que se encontro algun valor para HC
						$valor = 'HC';
						?>
							<!--Generamos el link con la funcion  para descargar la HC-->
							<a href='javascript:void(0);' onclick='javascript:descargar_HC("<?php echo $referencia[$b]; ?>","HC",<?php echo $total; ?>,"INDIVIDUAL")'><img class='imgD' src='Imagenes/Boton_Verde.png'></a>
						<?php
					}else{
						//Si no es S solo muestra  Ref N/D
						echo $HC[$b];
					}
					echo "</td>";
					echo "<td align='center'>";
						?>
                        	<!--Generamos el link con la funcion  para descargar la MV y HC-->
							<a href='javascript:void(0);' onclick='javascript:descargar_referencia_MV_HC("<?php echo $referencia[$b]; ?>","MV_HC",<?php echo $total; ?>,"DOBLE","<?php echo $metodoValoracion; ?>")'><img class='imgD' src='Imagenes/Boton_Verde.png'></a>
						<?php
					echo "</td>";
				echo "</tr>";
			}
				echo "<tr height='10'></tr>";
				echo "<tr>";
					echo "<td></td>";
					echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10'>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
					echo "</td>";
					echo "<td align='center'>";
					?>
                    	<script>
                        	var arrayReferencias = <?php echo json_encode($referencia); ?>;//Pasamos el array de referencias en php a una variable en javascript
                        </script>
                        <!--Link para descargar todos los MV de las referencias buscadas-->
						<a href='javascript:void(0);' onclick='javascript:descargarTodos_MV(arrayReferencias,"MV","TODOS")'><img  src='Imagenes/ICN_Archivo.png'></a>
					<?php
                    echo "</td>";
					echo "<td align='center'>";
					?>
                    	<!--Link para descargar todos los HC de las referencias buscadas-->
						<a href='javascript:void(0);' onclick='javascript:descargarTodos_HC(arrayReferencias,"HC","TODOS")'><img  src='Imagenes/ICN_Archivo.png'></a>
					<?php
                    echo "</td>";
					echo "<td align='center'>";
					?>
                    	<!--Link para descargar todo de las referencias buscadas-->
						<a href='javascript:void(0);' onclick='javascript:descargarTodos_FULL(arrayReferencias,"MV_HC","FULL")'><img  src='Imagenes/ICN_Archivo.png'></a>
					<?php
                    echo "</td>";
				echo "</tr>";
				
		}else if($_POST['tipo'] == 'Referencia'){//BUSQUEDA POR REFERENCIAS
			$datos = explode('||',eregi_replace("[\n|\r|\n\r]", '|', trim($_POST['datos'])));
			echo "<tr>";
				echo "<td></td>";
				echo "<td style='color: #4682B4;font-size:16px;'><strong>Opciones:</strong></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			echo "<tr height='10'></tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='3' font-size:14px;'>";
					echo "<strong>Representante legal:</strong>";
				echo "</td>";
			echo "</tr>";
			echo "<tr height='10'></tr>";
			echo "<tr  id='product1'>";
				echo "<td></td>";
				echo "<td align='center'>";
					echo "En blanco <input type='radio' name='RS'   value='blanco' onclick='javascript:mostarSelects();'>";
				echo "</td>";
				echo "<td align='center'>";
					echo "Correspondiente <input type='radio' name='RS'   value='correspondiente' checked='checked' onclick='javascript:mostarSelects();'>";
				echo "</td>";
				echo "<td align='center'>";
					echo "Otro <input type='radio' name='RS'  value='actual' onclick='javascript:mostarSelects();'>"; //NOMBRE DEL REPRESENTANTE ACTUAL
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			echo "<tr height='10'></tr>";
		echo "</table>";
		echo "<table width='400' style='display:none;margin:0px auto;float:right;' valign='top'  class='actual'>";//Tabla del select de RFC´s
			echo "<tr >";
				echo "<td></td>";
				echo "<td align='left' colspan='2'>";
						echo "<p style='color:#4682B4;'>RFC:</p>";
						echo "<select name='rfcs' onchange='mostrarValor(this.value);'>";
							echo "<option value='selecciona......'>Selecciona......</option>";
							$RFC = $masterGE->Execute("SELECT DISTINCT xt_rfc FROM MASTER_RFC_CLIENTEID WHERE xt_rfc NOT IN ('', 'TODOS','.','65-0600569')  ORDER BY xt_rfc ASC");
							while($f = $RFC->fetchRow()){
								echo "<option value='".$f[0]."'>".$f[0]."</option>";
							}
						echo "</select>";
				echo "</td>";
				echo "<td align='right'>";
					?>
                       	<!--Link para mostrar u ocultar el formulario de un nuevo representante-->
						<a href="javascript:MostrarOcultar('formNuevo'); "><img src="Imagenes/ICN_BotonMas.png" style="width:15%;margin-bottom:-23px;"></a>
					<?php
                echo "</td>";
			echo "</tr>";
			echo "<tr height='5'></tr>";
			echo "<tr >";
				echo "<td></td>";
				echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<table width='400' style='display:none;margin:0px auto;float:right;' valign='top' id='formNuevo' class='cp_oculta'>";//Formulario para agregar el nuevo representante
			echo "<tr>";
				echo "<td width='100'>";
					echo "<center><input type='text' name='nombre' placeholder='Nombre Completo'></center>";
				echo "</td>";
				echo "<td width='100'>";
					echo "<center><input type='text' name='rfc' placeholder='RFC'></center>";
				echo "</td>";
				echo "<td width='200'>";
					echo "<center><a href='javascript:void(0);' onclick = 'agregaNuevo();'><img name='nombre' src='Imagenes/ICN_BotonAgregar.png' width='100'  height='23'  ></a></center>";//Link para agregar el nuevo representante
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<table width='400' style='margin:0px auto;float:right;' valign='top' id='representantes' class='actual'>";//Despues de agregar el nuevo representante aqui se actuaizara la lista
		echo "</table>";
		echo "<table width='550' style='margin:0px auto;' valign='top' id='contenedorReferencias'>";//Cuerpo de la busqueda de las referencias
			echo "<tr height='20'></tr>";
			echo "<tr>";
				echo "<td align='center'>";
				echo "</td>";
				echo "<td align='center' style='color: #4682B4;'>";
					echo "<strong>MV</strong>";
				echo "</td>";
				echo "<td align='center' style='color: #4682B4;'>";
					echo "<strong>HC</strong>";
				echo "</td>";
				echo "<td align='center' style='color: #4682B4;'>";
					echo "<strong>MV y HC</strong>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			echo "<tr height='10'></tr>";
			for($a=0;$a<count($datos);$a++){
				//Se busca que existe informacion de las referencias en la tabla de manifestaciones
				$queryMV = $masterGE->getOne("SELECT count(xt_tipo) FROM MASTER_MANISFESTACION_DE_VALOR WHERE xt_referencia = '$datos[$a]' AND xt_tipo = 'MV'");
				$queryHC = $masterGE->getOne("SELECT count(xt_tipo) FROM MASTER_MANISFESTACION_DE_VALOR WHERE xt_referencia = '$datos[$a]' AND xt_tipo = 'HC'");
				$referencia[$a] = $datos[$a];
				if($queryMV == 0){$MV[$a] = 'Ref N/D';}else{$MV[$a] = 'S';}
				if($queryHC == 0){$HC[$a] = 'Ref N/D';}else{$HC[$a] = 'S';}
			}
		    
			for($b=0;$b<count($referencia);$b++){
				echo "<tr>";
					echo "<td align='center'>";
						echo $referencia[$b];
					echo "</td>";
					echo "<td align='center'>";
					$y = $masterGE->Execute(
													"SELECT
														xn_fraccionArancelaria,
														xt_descripcionMercancia,
														xn_valorFacturaUSD,
														xn_cantidadMercanciaComercializacion,
														xn_claveUnidadMedidaTarifa,
														xt_clavePaisOrigen,
														xt_clavePaisDestino
													FROM
														MASTER_PARTIDAS
													WHERE
														xt_referencia = '$referencia[$b]'
													"
													);
						$total = $y->recordCount();
						
						if($MV[$b] == 'S'){//Si es S significa que se encontro algun valor para MV
							$valor = 'MV';	
							//Obtenemos el metodo de valoracion de la referencia					
							$metodoValoracion = $masterGE->getOne("SELECT xt_valor FROM MASTER_MANISFESTACION_DE_VALOR WHERE xt_referencia = '$referencia[$b]' and xt_tipo = 'MV' AND xn_seccion = 12 AND xn_inciso = 1 AND xt_valor = 'VER ANEXO'");
							if(!empty($metodoValoracion)){$metodoValoracion = 0;}else{$metodoValoracion = 1;}
							?>
                            	<!--Link para descargar el MV de la referencia seleccionada-->
								<a href='javascript:void(0);' onclick='javascript:descargar_MV("<?php echo $referencia[$b]; ?>","MV",<?php echo $total; ?>,"INDIVIDUAL",<?php echo $metodoValoracion; ?>)'><img class='imgD' src='Imagenes/Boton_Verde.png'></a>
							<?php
						}else{
							//Si no es S solo muestra  Ref N/D
							echo $MV[$b];
						}
						//echo $MV[$b];
					echo "</td>";
					echo "<td align='center'>";
						if($HC[$b] == 'S'){//Si es S significa que se encontro algun valor para HC
							$valor = 'HC';					
							?>
                            	<!-- Link para descargar los HC de las referencias-->
								<a href='javascript:void(0);' onclick='javascript:descargar_HC("<?php echo $referencia[$b]; ?>","HC",<?php echo $total; ?>,"INDIVIDUAL")'><img class='imgD' src='Imagenes/Boton_Verde.png'></a>
							<?php
						}else{
							echo $HC[$b];
						}
					echo "</td>";
					echo "<td align='center'>";
						?>
                        	<!-- Link para descargar el HC y MV de la referencia solicitada -->
							<a href='javascript:void(0);' onclick='javascript:descargar_referencia_MV_HC("<?php echo $referencia[$b]; ?>","MV_HC",<?php echo $total; ?>,"DOBLE","<?php echo $metodoValoracion; ?>")'><img class='imgD' src='Imagenes/Boton_Verde.png'></a>
						<?php
					echo "</td>";
				echo "</tr>";
			}

				echo "<tr height='10'></tr>";
				echo "<tr>";
					echo "<td></td>";
					echo  "<td colspan='3'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";

				echo "<tr height='10'>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
					echo "</td>";
					echo "<td align='center'>";
					?>
                    	<script>
                        	var arrayReferencias = <?php echo json_encode($referencia); ?>;//Convertir un array de php a una variable de javascript
                        </script>
                        <!-- Link para descargar todos los MV de las referencias-->
						<a href='javascript:void(0);' onclick='javascript:descargarTodos_MV(arrayReferencias,"MV","TODOS")'><img  src='Imagenes/ICN_Archivo.png'></a>
					<?php
                    echo "</td>";
					echo "<td align='center'>";
					?>
                    	<!-- Link para descargar todos los HC de las referencias-->
						<a href='javascript:void(0);' onclick='javascript:descargarTodos_HC(arrayReferencias,"HC","TODOS")'><img  src='Imagenes/ICN_Archivo.png'></a>
					<?php
                    echo "</td>";
					echo "<td align='center'>";
					?>
                    	<!-- Link para descargar todo de las referencias-->
						<a href='javascript:void(0);' onclick='javascript:descargarTodos_FULL(arrayReferencias,"MV_HC","FULL")'><img  src='Imagenes/ICN_Archivo.png'></a>
					<?php
                    echo "</td>";
				echo "</tr>";
		}
		echo "</table>";
	}
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr height='30'> </tr>";	
			echo "<tr>";
				echo "<td  width='800' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			echo"<tr height='15'> </tr>";
		echo "</table>"; 
	echo "</form>";
	echo "<div id='recargado'></div>";	
	echo "</div>";		
?>
</body>
</html>
