function mostrarCamposGenerales(){
	var camposGenerales = document.getElementsByClassName("modificaCamposGenerales");
	var etiquetasGenerales = document.getElementsByClassName("etiquetasGenerales");
	var botonModificar   = document.getElementById('botonModificarGenerales');
	var indice;
	for (indice = 0; indice < camposGenerales.length; indice++) {
	    camposGenerales[indice].style.display  ='block';
	}
	for (indice = 0; indice < etiquetasGenerales.length; indice++) {
	    etiquetasGenerales[indice].style.display  ='none';
	}					
	botonModificar.style.display   ='none';
}
function actualizarCamposGenerales(simulacro) { 
	var campoNombre = document.forms.formulario.titulo;
	var nombre = campoNombre.value;
	var campoDescripcion = document.forms.formulario.descripcion;
	var descripcion = campoDescripcion.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar los campos generales.");
			}
		}
	};
	xhttp.open("POST", "agregaCamposGenerales.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=actualizarCamposGenerales&simulacro="+simulacro+"&nombre="+nombre+"&descripcion="+descripcion);
}				
function mostrarCampoPDR(){
	var camposPDR = document.getElementsByClassName("modificaCampoPDR");
	var etiquetasPDR = document.getElementsByClassName("etiquetaPDR");
	var botonModificarPDR   = document.getElementById('botonModificarPDR');

	for (indice = 0; indice < camposPDR.length; indice++) {
	    camposPDR[indice].style.display  ='block';
	}
	for (indice = 0; indice < etiquetasPDR.length; indice++) {
	    etiquetasPDR[indice].style.display  ='none';
	}							
	botonModificarPDR.style.display ='none';
}
function actualizarCampoPDR(simulacro) { 
	var campoPDR = document.forms.formulario.pdr;
	var nombre = campoPDR.value;
	if (nombre.length == 0){
		nombre = 'null';
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar el campo del PDR.");
			}
		}
	};
	xhttp.open("POST", "agregaCampoPDR.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&pdr="+nombre);
}		
function mostrarCamposFechas(){
	var camposFechas = document.getElementsByClassName("modificaCamposFechas");
	var etiquetasFechas = document.getElementsByClassName("etiquetasFechas");
	var botonModificarFechas   = document.getElementById('botonModificarFechas');

	for (indice = 0; indice < camposFechas.length; indice++) {
	    camposFechas[indice].style.display  ='table-row';
	}
	for (indice = 0; indice < etiquetasFechas.length; indice++) {
	    etiquetasFechas[indice].style.display  ='none';
	}							
	botonModificarFechas.style.display ='none';
}
function actualizarCamposFechas(simulacro) { 
	var campoFechaProgramada = document.forms.formulario.fechaProgramada;
	var campoFechaInicio = document.forms.formulario.fechaInicio;
	var campoFechaFinalizacion = document.forms.formulario.fechaFinalizacion;
	var fechaProgramada = campoFechaProgramada.value;
	var fechaInicio = campoFechaInicio.value;
	var fechaFinalizacion = campoFechaFinalizacion.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar los campos de las fechas.");
			}
		}
	};
	xhttp.open("POST", "agregaCamposFechas.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&fechaProgramada="+fechaProgramada+"&fechaInicio="+fechaInicio+"&fechaFinalizacion="+fechaFinalizacion);
}
function mostrarCampoTipo(){
	var camposTipo = document.getElementsByClassName("modificaCampoTipo");
	var etiquetasTipo = document.getElementsByClassName("etiquetasTipo");
	var botonModificarTipo = document.getElementById('botonModificarTipo');

	for (indice = 0; indice < camposTipo.length; indice++) {
	    camposTipo[indice].style.display  ='table-row';
	}
	for (indice = 0; indice < etiquetasTipo.length; indice++) {
	    etiquetasTipo[indice].style.display  ='none';
	}							
	botonModificarTipo.style.display ='none';
}
function actualizarCampoTipo(simulacro) { 
	var campoTipo = document.forms.formulario.tipo;
	var tipo = campoTipo.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar el campo tipo.");
			}
		}
	};
	xhttp.open("POST", "agregaCampoTipo.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&tipo="+tipo);
}
function mostrarCampoAlcance(){
	var campoAlcance = document.getElementsByClassName("modificaCampoAlcance");
	var etiquetaAlcance = document.getElementsByClassName("etiquetaAlcance");
	var botonModificarAlcance = document.getElementById('botonModificarAlcance');
	var botonGuardar = document.getElementsByClassName("botonGuardar");

	for (indice = 0; indice < campoAlcance.length; indice++) {
	    campoAlcance[indice].style.display  ='table-row';
	}
	for (indice = 0; indice < etiquetaAlcance.length; indice++) {
	    etiquetaAlcance[indice].style.display  ='none';
	}				
	botonModificarAlcance.style.display ='none';
}
function actualizarCampoAlcance(simulacro) { 
	var campoAlcance = document.forms.formulario.alcance;
	var alcance = campoAlcance.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar el campo tipo.");
			}
		}
	};
	xhttp.open("POST", "agregaCampoAlcance.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&alcance="+alcance);
}
function mostrarCampoRecursos(){
	var campoRecursos = document.getElementsByClassName("modificaCampoRecursos");
	var etiquetaRecursos = document.getElementsByClassName("etiquetaRecursos");
	var botonModificarRecursos = document.getElementById('botonModificarRecursos');
	var botonGuardar = document.getElementsByClassName("botonGuardar");

	for (indice = 0; indice < campoRecursos.length; indice++) {
	    campoRecursos[indice].style.display  ='table-row';
	}
	for (indice = 0; indice < etiquetaRecursos.length; indice++) {
	    etiquetaRecursos[indice].style.display  ='none';
	}				
	botonModificarRecursos.style.display ='none';
}
function actualizarCampoRecursos(simulacro) { 
	var campoRecursos = document.forms.formulario.recursos;
	var recursos = campoRecursos.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar el campo recursos utilizados.");
			}
		}
	};
	xhttp.open("POST", "agregaCampoRecursos.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&recursos="+recursos);
}					
function mostrarCampoDesarrollo(){
	var campoDesarrollo = document.getElementsByClassName("modificaCampoDesarrollo");
	var etiquetaDesarrollo = document.getElementsByClassName("etiquetaDesarrollo");
	var botonModificarDesarrollo = document.getElementById('botonModificarDesarrollo');
	var botonGuardar = document.getElementsByClassName("botonGuardar");

	for (indice = 0; indice < campoDesarrollo.length; indice++) {
	    campoDesarrollo[indice].style.display  ='table-row';
	}
	for (indice = 0; indice < etiquetaDesarrollo.length; indice++) {
	    etiquetaDesarrollo[indice].style.display  ='none';
	}				
	botonModificarDesarrollo.style.display ='none';
}
function actualizarCampoDesarrollo(simulacro) { 
	var campoDesarrollo = document.forms.formulario.desarrollo;
	var desarrollo = campoDesarrollo.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar el campo desarrollo.");
			}
		}
	};
	xhttp.open("POST", "agregaCampoDesarrollo.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&desarrollo="+desarrollo);
}
function mostrarCampoResultado(){
	var campoResultado = document.getElementsByClassName("modificaCampoResultado");
	var etiquetaResultado = document.getElementsByClassName("etiquetaResultado");
	var botonModificarResultado = document.getElementById('botonModificarResultado');
	var botonGuardar = document.getElementsByClassName("botonGuardar");

	for (indice = 0; indice < campoResultado.length; indice++) {
	    campoResultado[indice].style.display  ='table-row';
	}
	for (indice = 0; indice < etiquetaResultado.length; indice++) {
	    etiquetaResultado[indice].style.display  ='none';
	}				
	botonModificarResultado.style.display ='none';
}
function actualizarCampoResultado(simulacro) { 
	var campoResultado = document.forms.formulario.resultado;
	var resultado = campoResultado.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar el campo desarrollo.");
			}
		}
	};
	xhttp.open("POST", "agregaCampoResultado.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&resultado="+resultado);
}
function mostrarCamposEvaluacion(){
	var camposEvaluacion = document.getElementsByClassName("modificaCamposEvaluacion");
	var etiquetasEvaluacion = document.getElementsByClassName("etiquetasEvaluacion");
	var botonModificarEvaluacion = document.getElementById('botonModificarEvaluacion');
	var botonGuardar = document.getElementsByClassName("botonGuardar");

	for (indice = 0; indice < camposEvaluacion.length; indice++) {
	    camposEvaluacion[indice].style.display  ='table-row';
	}
	for (indice = 0; indice < etiquetasEvaluacion.length; indice++) {
	    etiquetasEvaluacion[indice].style.display  ='none';
	}				
	botonModificarEvaluacion.style.display ='none';
}
function actualizarCamposEvaluacion(simulacro) { 
	var campoEvaluacion = document.forms.formulario.evaluacion;
	var evaluacion = campoEvaluacion.value;
	var campoDescripcionEvaluacion = document.forms.formulario.descripcionEvaluacion;
	var descripcionEvaluacion = campoDescripcionEvaluacion.value;  		
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error al actualizar el campo evaluacion.");
			}
		}
	};
	xhttp.open("POST", "agregaCampoEvaluacion.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&evaluacion="+evaluacion+"&descripcionEvaluacion="+descripcionEvaluacion);
}	
function actualizarFicha(simulacro){
	window.location = 'simulacroElementoActualizar.php?simulacro=' + simulacro;
}
function showBanana(valor){
	if(valor == 1){
		document.getElementById("banana1").style.display="inline-block";
		document.getElementById("banana0").style.display="none";
		document.getElementById("mapaIntranet").style.display="inline-block";
	} else if (valor == 0){
		document.getElementById("banana1").style.display="none";
		document.getElementById("banana0").style.display="inline-block";
		document.getElementById("mapaIntranet").style.display="none";
	}
}
function show(valor){
	if(valor == 1){
		document.getElementById("formularioAcuerdo").style.display="block";
		document.getElementById("mostrar").style.display="none";
		document.getElementById("ocultar").style.display="block";
		
	} else if (valor == 0){
		document.getElementById("formularioAcuerdo").style.display="none";
		document.getElementById("mostrar").style.display="block";
		document.getElementById("ocultar").style.display="none";
	}
}

function showSeguimiento(valor){
	if(valor == 1){
		document.getElementById("seguimiento1").style.display="none";
		document.getElementById("seguimiento0").style.display="block";
		document.getElementById("formSeguimiento").style.display="block";
					} 
	else if (valor == 0){
		document.getElementById("seguimiento1").style.display="block";
		document.getElementById("seguimiento0").style.display="none";
		document.getElementById("formSeguimiento").style.display="none";
					}
				}



function actualizarSeguimiento(simulacro) { 
	var codigo = document.forms.formulario.codigoTratamiento.value;
	var tipo = document.forms.formulario.atributotrat.value;  
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFicha(simulacro);
			}else{
				alert("Hubo un error en actualizar el seguimiento.");
			}
		}
	};
	xhttp.open("POST", "agregaCampoTipo.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&tipo="+tipo+"&codigo="+codigo);
 	//xhttp.send("simulacro="+simulacro+"&codigo="+codigotratamiento+"&tipo="+tipotratamiento);
}




function agregarseguimiento(simulacro) { 
	var codigo = document.forms.formulario.codigoTratamiento.value;
	var tipo = document.forms.formulario.atributotrat.value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				location.reload();
			}else{
				alert("Hubo un error al actualizar el campo tipo.");
			}
		}
	};

	if( tipo!= 0 && codigo !="" )
	{
	xhttp.open("POST", "agregaCampoSeguimiento.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("simulacro="+simulacro+"&tipo="+tipo+"&codigo="+codigo);
}
}