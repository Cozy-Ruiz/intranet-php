function eliminaReferencia(referencia){

	var confirmacion = confirm("Confirma eliminar referencia?.");
	if (confirmacion != false) {

		//alert("Eliminando Referencia");
		
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			
			if (xhttp.readyState == 4 && xhttp.status == 200) {

				if(xhttp.responseText == ""){
					ocultaProcesando();
					generaTablero();
				}else{
					ocultaProcesando();
					alert(xhttp.responseText);
					//actualizaReferencia(referencia);
				}
			}
		};
		
		xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("evento=eliminaReferencia&referencia=" + referencia);
		
	}

	
}

function enviaCancelar(referencia){

	var prevalidador = document.getElementById("prevalidador").value;
	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";
	var prevalidadorCodigoNombre = document.getElementById("prevalidador").options[document.getElementById("prevalidador").selectedIndex].innerText;
	var prevalidadorNombre = (prevalidadorCodigoNombre.split("-"))[1];

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){
				ocultaProcesando();
				//actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				//actualizaReferencia(referencia);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaCancelar&referencia=" + referencia+ "&prevalidador=" + prevalidador + "&prevalidadorNombre=" + prevalidadorNombre);
}


function paraGenerarCancelacion(referencia){
	//muestraProcesando();
	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cambiando...";
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=paraGenerarCancelacion&referencia=" + referencia);
}

function paraReprocesarPago(referencia){
	//muestraProcesando();
	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cambiando...";
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == ""){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=paraReprocesarPago&referencia=" + referencia);
}

function paraGenerarE(referencia){
	//muestraProcesando();
	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cambiando...";
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=paraGenerarE&referencia=" + referencia);
}
 

function saltaCargaEvidenciaSOIA(referencia){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == true){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				//alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=saltaCargaEvidenciaSOIA&referencia=" + referencia);
	
}

function registraDatosPagoSinA(referencia){

	//alert("Registrando datos");
	
	var operacionBancaria = document.getElementById("operacionBancaria").value;
	var transaccionSAT = document.getElementById("transaccionSAT").value;
	var fechaPago = document.getElementById("fechaPago").value;
	var horaPago = document.getElementById("horaPago").value;
	var turno = document.getElementById("turno").value;

	//alert(operacionBancaria + " - " + transaccionSAT + " - " + fechaPago + " - " + horaPago + " - " + turno );
	muestraProcesando();

	if(operacionBancaria != "" && transaccionSAT != "" && fechaPago != "" && horaPago != "" && turno != ""){

		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {

				if(xhttp.responseText == ""){
					ocultaProcesando();
					actualizaReferencia(referencia);
				}else{
					ocultaProcesando();
					alert(xhttp.responseText);
					actualizaReferencia(referencia);
				}
			}
		};
		
		xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("evento=registraDatosPagoSinA&referencia=" + referencia + "&operacionBancaria=" + operacionBancaria + "&transaccionSAT=" + transaccionSAT + "&fechaPago=" + fechaPago + "&horaPago=" + horaPago + "&turno=" + turno);
		
	}else{
		alert("Campos vacios por favor llenar todos los campos");
		ocultaProcesando();
	}
	
}


function saltaCompletarDatosPagoSinA(referencia){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=saltaCompletarDatosPagoSinA&referencia=" + referencia);
	
}

function muestraCargaReciboPago(referencia){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			var manto = document.getElementById('manto');
			var popUp = document.getElementById('popUp');

			popUp.style.width = "50%";
			popUp.style.height = "50%";
			popUp.style.top = "25%";
			popUp.style.left = "25%";

			popUp.innerHTML = xhttp.responseText;

			manto.style.display="block";
			popUp.style.display="block";
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=muestraCargaReciboPago&referencia=" + referencia);
}

function saltoGeneracionDocumentos(referencia){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == true){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=saltoGeneracionDocumentos&referencia=" + referencia);
	
}

function cargaReciboPago(ev, inputFile, referencia) {
	
	ev.stopPropagation();
	ev.preventDefault();
	
	var fileAlta = document.querySelector('input[name="'+inputFile+'"]');
	fileAlta.files = ev.dataTransfer.files;


	var manto = document.getElementById('manto');
	var popUp = document.getElementById('popUp');
	manto.style.display="none";
	popUp.style.display="none";

	muestraProcesando();
	
	
	var datos = new FormData();

	//Archivos
	var archivos = document.getElementById(inputFile);

	if(fileAlta.files.length > 1){
		for (var i = 0; i < fileAlta.files.length; i++) {
			datos.append('files', archivos.files[i]);
		}
	}else{
		datos.append('file', archivos.files[0]);
	}
	

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == true){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};
	
	xhttp.open('POST', "../Controllers/validacionPeceController.php?evento=cargaReciboPago" +	"&referencia="+ referencia , true);
	xhttp.send(datos);
	
}

function registraDatosPago(referencia){

	var operacionBancaria = document.getElementById("operacionBancaria").value;
	var transaccionSAT = document.getElementById("transaccionSAT").value;
	var fechaPago = document.getElementById("fechaPago").value;
	var horaPago = document.getElementById("horaPago").value;
	var turno = document.getElementById("turno").value;

	//alert(operacionBancaria + " - " + transaccionSAT + " - " + fechaPago + " - " + horaPago + " - " + turno );
	muestraProcesando();

	if(operacionBancaria != "" && transaccionSAT != "" && fechaPago != "" && horaPago != "" && turno != ""){

		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {

				if(xhttp.responseText == ""){
					ocultaProcesando();
					actualizaReferencia(referencia);
				}else{
					ocultaProcesando();
					alert(xhttp.responseText);
					actualizaReferencia(referencia);
				}
			}
		};
		
		xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("evento=registraDatosPago&referencia=" + referencia + "&operacionBancaria=" + operacionBancaria + "&transaccionSAT=" + transaccionSAT + "&fechaPago=" + fechaPago + "&horaPago=" + horaPago + "&turno=" + turno);
	
	}else{
		alert("Campos vacios por favor llenar todos los campos");
	}

	
}

function cargaArchivoEvidenciaSOIA(ev, inputFile, referencia) {
	
	ev.stopPropagation();
	ev.preventDefault();
	
	var fileAlta = document.querySelector('input[name="'+inputFile+'"]');
	fileAlta.files = ev.dataTransfer.files;


	var manto = document.getElementById('manto');
	var popUp = document.getElementById('popUp');
	manto.style.display="none";
	popUp.style.display="none";

	muestraProcesando();
	
	
	var datos = new FormData();

	//Archivos
	var archivos = document.getElementById(inputFile);

	if(fileAlta.files.length > 1){
		for (var i = 0; i < fileAlta.files.length; i++) {
			datos.append('files', archivos.files[i]);
		}
	}else{
		datos.append('file', archivos.files[0]);
	}
	

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == true){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};

	xhttp.open('POST', "../Controllers/validacionPeceController.php?evento=cargaArchivoEvidenciaSOIA" +	"&referencia="+ referencia , true);
	xhttp.send(datos);
	
}

function cargaArchivoA(ev, inputFile, referencia) {
	
	ev.stopPropagation();
	ev.preventDefault();
	
	var fileAlta = document.querySelector('input[name="'+inputFile+'"]');
	fileAlta.files = ev.dataTransfer.files;


	var manto = document.getElementById('manto');
	var popUp = document.getElementById('popUp');
	manto.style.display="none";
	popUp.style.display="none";

	muestraProcesando();
	
	
	var datos = new FormData();

	//Archivos
	var archivos = document.getElementById(inputFile);

	if(fileAlta.files.length > 1){
		for (var i = 0; i < fileAlta.files.length; i++) {
			datos.append('files', archivos.files[i]);
		}
	}else{
		datos.append('file', archivos.files[0]);
	}
	

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};

	xhttp.open('POST', "../Controllers/validacionPeceController.php?evento=cargaArchivoA" +	"&referencia="+ referencia , true);
	xhttp.send(datos);
	
}

function muestraCargaArchivoA(referencia){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			var manto = document.getElementById('manto');
			var popUp = document.getElementById('popUp');

			popUp.style.width = "50%";
			popUp.style.height = "50%";
			popUp.style.top = "25%";
			popUp.style.left = "25%";

			popUp.innerHTML = xhttp.responseText;

			manto.style.display="block";
			popUp.style.display="block";
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=muestraCargaArchivoA&referencia=" + referencia);
}

function cargaArchivoE(ev, inputFile, referencia) {
	
	ev.stopPropagation();
	ev.preventDefault();
	
	var fileAlta = document.querySelector('input[name="'+inputFile+'"]');
	fileAlta.files = ev.dataTransfer.files;


	var manto = document.getElementById('manto');
	var popUp = document.getElementById('popUp');
	manto.style.display="none";
	popUp.style.display="none";

	muestraProcesando();
	
	
	var datos = new FormData();

	//Archivos
	var archivos = document.getElementById(inputFile);

	if(fileAlta.files.length > 1){
		for (var i = 0; i < fileAlta.files.length; i++) {
			datos.append('files', archivos.files[i]);
		}
	}else{
		datos.append('file', archivos.files[0]);
	}
	

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};

	xhttp.open('POST', "../Controllers/validacionPeceController.php?evento=cargaArchivoE" +	"&referencia="+ referencia , true);
	xhttp.send(datos);
	
}

function muestraCargaArchivoE(referencia){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			var manto = document.getElementById('manto');
			var popUp = document.getElementById('popUp');

			popUp.style.width = "50%";
			popUp.style.height = "50%";
			popUp.style.top = "25%";
			popUp.style.left = "25%";

			popUp.innerHTML = xhttp.responseText;

			manto.style.display="block";
			popUp.style.display="block";
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=muestraCargaArchivoE&referencia=" + referencia);
}

function cargaArchivoERR(ev, inputFile, referencia) {
	
	
	ev.stopPropagation();
	ev.preventDefault();
	
	var fileAlta = document.querySelector('input[name="'+inputFile+'"]');
	fileAlta.files = ev.dataTransfer.files;


	var manto = document.getElementById('manto');
	var popUp = document.getElementById('popUp');
	manto.style.display="none";
	popUp.style.display="none";

	muestraProcesando();
	
	
	var datos = new FormData();

	//Archivos
	var archivos = document.getElementById(inputFile);

	if(fileAlta.files.length > 1){
		for (var i = 0; i < fileAlta.files.length; i++) {
			datos.append('files', archivos.files[i]);
		}
	}else{
		datos.append('file', archivos.files[0]);
	}
	

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};

	xhttp.open('POST', "../Controllers/validacionPeceController.php?evento=cargaArchivoERR" +	"&referencia="+ referencia , true);
	xhttp.send(datos);
	
}

function muestraCargaArchivoERR(referencia){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			var manto = document.getElementById('manto');
			var popUp = document.getElementById('popUp');

			popUp.style.width = "50%";
			popUp.style.height = "50%";
			popUp.style.top = "25%";
			popUp.style.left = "25%";

			popUp.innerHTML = xhttp.responseText;

			manto.style.display="block";
			popUp.style.display="block";
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=muestraCargaArchivoERR&referencia=" + referencia);
}

function cargaArchivoM(ev, inputFile, referencia) {
	
	
	ev.stopPropagation();
	ev.preventDefault();
	
	var fileAlta = document.querySelector('input[name="'+inputFile+'"]');
	fileAlta.files = ev.dataTransfer.files;


	var manto = document.getElementById('manto');
	var popUp = document.getElementById('popUp');
	manto.style.display="none";
	popUp.style.display="none";

	muestraProcesando();
	
	
	var datos = new FormData();

	//Archivos
	var archivos = document.getElementById(inputFile);

	if(fileAlta.files.length > 1){
		for (var i = 0; i < fileAlta.files.length; i++) {
			datos.append('files', archivos.files[i]);
		}
	}else{
		datos.append('file', archivos.files[0]);
	}
	

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
	    
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){
				ocultaProcesando();
				actualizaReferencia(referencia);
			}else{
				ocultaProcesando();
				alert(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};

	xhttp.open('POST', "../Controllers/validacionPeceController.php?evento=cargaArchivoM" +	"&referencia="+ referencia , true);
	xhttp.send(datos);
	
}

function muestraCargaArchivoM(referencia){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			var manto = document.getElementById('manto');
			var popUp = document.getElementById('popUp');

			popUp.style.width = "50%";
			popUp.style.height = "50%";
			popUp.style.top = "25%";
			popUp.style.left = "25%";

			popUp.innerHTML = xhttp.responseText;

			manto.style.display="block";
			popUp.style.display="block";
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=muestraCargaArchivoM&referencia=" + referencia);
}

function dragover_handler(event) {
	
	event.preventDefault();
	
}



function registraAutorizacionContabilidadPago(referencia, session){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){

				enviaGenerarE(referencia, session);

			}else{
				
				alert(xhttp.responseText);
				actualizaReferencia(referencia);

			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=registraAutorizacionContabilidadPago&referencia=" + referencia);

}

function registraCambioPeca(referencia){

	var personalAutoriza = document.getElementById('selectCambioPeca').value;

	alert("Registrando cambio Peca autorizado por " + personalAutoriza );


	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){

				var manto = document.getElementById('manto');
				var popUp = document.getElementById('popUp');

				manto.style.display="none";
				popUp.style.display="none";

			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=registraCambioPeca&referencia=" + referencia + "&personalAutoriza=" + personalAutoriza);

	
}


function cancelarCambioPeca(referencia){

	alert("Cancelando cambio PECA");
	
	var selectBanco = document.getElementById("banco").innerHTML;
	var select = document.getElementById("banco");
	select.innerHTML = selectBanco;

	var manto = document.getElementById('manto');
	var popUp = document.getElementById('popUp');

	manto.style.display="none";
	popUp.style.display="none";
	
}


function confirmaCambioPeca(referencia) {
	//alert("Confirmando cambio PECA");
	
	/*
	var confirmacion = confirm("Cuenta con autorización de tesoreria para cambio de Peca/Banco? , de lo contrario se establecera el default.");
	if (confirmacion == false) {
		var selectBanco = document.getElementById("banco").innerHTML;
		var select = document.getElementById("banco");
		select.innerHTML = selectBanco;

	}
	*/

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			//alert(xhttp.responseText);

			
			var manto = document.getElementById('manto');
			var popUp = document.getElementById('popUp');

			popUp.style.width = "50%";
			popUp.style.height = "50%";
			popUp.style.top = "25%";
			popUp.style.left = "25%";

			popUp.innerHTML = xhttp.responseText;

			manto.style.display="block";
			popUp.style.display="block";
			
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=muestraCambioPeca&referencia=" + referencia);
	
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

//Funcion para Mostrar Archivos
function muestraArchivos(datosReferencia, session) {

	muestraProcesando();

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			ocultaProcesando();
			//alert(xhttp.responseText);

			var manto = document.getElementById('manto');
			var popUp = document.getElementById('popUp');

			popUp.style.width = "90%";
			popUp.style.height = "90%";
			popUp.style.top = "5%";
			popUp.style.left = "5%";

			popUp.innerHTML = xhttp.responseText;

			manto.style.display="block";
			popUp.style.display="block";
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=muestraArchivos&datosReferencia=" + datosReferencia + "&session=" + session);
}

//Funcion para liberar
function enviaLiberar(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "liberando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == ""){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaLiberar&referencia=" + referencia);
}

//Funcion para reintentar pago
function reintentoPagar(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cambiando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=reintentoPagar&referencia=" + referencia);
}

//Funcion para reintentar validacion
function reintentoValidar(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cambiando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=reintentoValidar&referencia=" + referencia);
}

//Funcion para reintentar prevalidacion
function reintentoPrevalidar(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cambiando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=reintentoPrevalidar&referencia=" + referencia);
}

//Funcion para enviar a generar Aviso Consolidado
function cerrarConsolidado(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cerrando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=cerrarConsolidado&referencia=" + referencia);
	
}


//Funcion para enviar a generar Aviso Consolidado
function enviaGenerarAvisoConsolidado(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaGenerarAvisoConsolidado&referencia=" + referencia);
	
}

//Funcion para enviar a generar Simplificado
function enviaGenerarSimplificadoDesistimiento(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaGenerarSimplificadoDesistimiento&referencia=" + referencia);
	
}

//Funcion para enviar a generar Simplificado
function enviaGenerarSimplificado(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaGenerarSimplificado&referencia=" + referencia);
	
}

//Funcion para enviar a pagar
function enviaPagar(referencia, session) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "pagando...";
	var validador = document.getElementById("validador").value;
	var validadorCodigoNombre = document.getElementById("validador").options[document.getElementById("validador").selectedIndex].innerText;
	var validadorNombre = (validadorCodigoNombre.split("-"))[1];

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaPagar&referencia=" + referencia + "&session=" + session + "&validador=" + validador  + "&validadorNombre=" + validadorNombre);
	
}

//Funcion para enviar a regenerar E
function reGenerarE(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cambiando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=reGenerarE&referencia=" + referencia);
	
}

/*
function registraAutorizacionContabilidadPago(referencia, session){

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {

			if(xhttp.responseText == ""){

				enviaGenerarE(referencia, session);

			}else{
				
				alert(xhttp.responseText);
				actualizaReferencia(referencia);

			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=registraAutorizacionContabilidadPago&referencia=" + referencia);

}
*/

//Funcion para enviar a generar E
function enviaGenerarE_RECTI(referencia, session) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";

	var banco = (document.getElementById("banco").value).split("-");
	
	var claveBanco = banco[0];
	var claveCuenta = banco[1];
	var tipoCuenta = banco[2];

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);

			}else if(xhttp.responseText == "Sin aprobación de Contabilidad para generar pago"){

				var confirmacion = confirm("Sin aprobación de Contabilidad para generar pago.\n\nPara autorizar oprima 'Aceptar' de lo contrario 'Cancelar'.\n\nQuedara registro en el sistema!!.");
				if (confirmacion == false) {

					actualizaReferencia(referencia);

				}else{

					registraAutorizacionContabilidadPago(referencia, session);
				}
				

			}else{

				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaGenerarE_RECTI&referencia=" + referencia + "&session=" + session + "&claveBanco=" + claveBanco + "&claveCuenta=" + claveCuenta + "&tipoCuenta=" + tipoCuenta);
	
}


//Funcion para enviar a generar E
function enviaGenerarE(referencia, session) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";

	var banco = (document.getElementById("banco").value).split("-");

	var claveBanco = banco[0];
	var claveCuenta = banco[1];
	var tipoCuenta = banco[2];

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);

			}else if(xhttp.responseText == "Sin aprobación de Contabilidad para generar pago"){

				var confirmacion = confirm("Sin aprobación de Contabilidad para generar pago.\n\nPara autorizar oprima 'Aceptar' de lo contrario 'Cancelar'.\n\nQuedara registro en el sistema!!.");
				if (confirmacion == false) {

					actualizaReferencia(referencia);

				}else{

					registraAutorizacionContabilidadPago(referencia, session);
				}
				

			}else{

				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
				actualizaReferencia(referencia);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaGenerarE&referencia=" + referencia + "&session=" + session + "&claveBanco=" + claveBanco + "&claveCuenta=" + claveCuenta + "&tipoCuenta=" + tipoCuenta);
	
}

//Funcion para enviar a desistir
function enviaDesistir(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "desistiendo...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaDesistir&referencia=" + referencia);
}

//Funcion para enviar a validar
function enviaValidar(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "validando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaValidar&referencia=" + referencia);
}

//Funcion para enviar a prevalidar
function enviaPrevalidar(referencia) {

	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "prevalidando...";

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaPrevalidar&referencia=" + referencia);
}

//Funcion para cargar Referencias
function paraGenerarM(referencia) {

	//muestraProcesando();
	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "cambiando...";
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=paraGenerarM&referencia=" + referencia);
	
}


//Funcion para enviar a generar M
function enviaGenerarM_Desistimiento(referencia) {

	//alert("Generando m Desistimiento");

	
	var curp = document.getElementById("curp").value;
	var prevalidador = document.getElementById("prevalidador").value;
	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";
	var prevalidadorCodigoNombre = document.getElementById("prevalidador").options[document.getElementById("prevalidador").selectedIndex].innerText;
	var prevalidadorNombre = (prevalidadorCodigoNombre.split("-"))[1];
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			//alert(xhttp.responseText);
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaGenerarM_Desistimiento&referencia=" + referencia + "&curp=" + curp + "&prevalidador=" + prevalidador + "&prevalidadorNombre=" + prevalidadorNombre);
	
}


//Funcion para enviar a generar M
function enviaGenerarM_RECTI(referencia) {

	var curp = document.getElementById("curp").value;
	var prevalidador = document.getElementById("prevalidador").value;
	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";
	var prevalidadorCodigoNombre = document.getElementById("prevalidador").options[document.getElementById("prevalidador").selectedIndex].innerText;
	var prevalidadorNombre = (prevalidadorCodigoNombre.split("-"))[1];
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaGenerarM_RECTI&referencia=" + referencia + "&curp=" + curp + "&prevalidador=" + prevalidador + "&prevalidadorNombre=" + prevalidadorNombre);
	
}

//Funcion para enviar a generar M
function enviaGenerarM(referencia) {

	var curp = document.getElementById("curp").value;
	var prevalidador = document.getElementById("prevalidador").value;
	var estatusReferencia = document.getElementById("estatus-" + referencia).innerHTML = "generando...";
	var prevalidadorCodigoNombre = document.getElementById("prevalidador").options[document.getElementById("prevalidador").selectedIndex].innerText;
	var prevalidadorNombre = (prevalidadorCodigoNombre.split("-"))[1];
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
				registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
				console.log(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=enviaGenerarM&referencia=" + referencia + "&curp=" + curp + "&prevalidador=" + prevalidador + "&prevalidadorNombre=" + prevalidadorNombre);
	
}


//Funcion para cargar Referencias
function cargaReferencias(session) {

	var referencias = (document.getElementById("referencias").value).split(/\n/);
	
	if (document.getElementById('estatusDesistimiento').checked){

		alert('checkbox desistimiento esta seleccionado');

		muestraProcesando();
	
		var xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				if(xhttp.responseText == true){
					//actualizaDatos(session);
					generaTablero();
					document.getElementById("referencias").value = "";
					ocultaProcesando();
				}else{
					//actualizaDatos(session);
					generaTablero();
					document.getElementById("referencias").value = "";
					ocultaProcesando();
					alert(xhttp.responseText);
					registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
					console.log(xhttp.responseText);
				}
			}
		};
		
		xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("evento=cargaReferenciasDesistimiento&referencias=" + JSON.stringify(referencias) + "&session=" + session );

	}else{

		muestraProcesando();
	
		var xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				if(xhttp.responseText == true){
					//actualizaDatos(session);
					generaTablero();
					document.getElementById("referencias").value = "";
					ocultaProcesando();
				}else{
					//actualizaDatos(session);
					generaTablero();
					document.getElementById("referencias").value = "";
					ocultaProcesando();
					alert(xhttp.responseText);
					registraExcepcion("VALIDACION_PAGO",xhttp.responseText);
					console.log(xhttp.responseText);
				}
			}
		};
		
		xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("evento=cargaReferencias&referencias=" + JSON.stringify(referencias) + "&session=" + session );

	}
	
}


//Funcion para generar el Detalle
function muestraDetalle(detalle, referencia) {
	document.getElementById("historial").innerHTML = atob(detalle);
	//cambiaIframeUrl("../Controllers/validacionPeceController.php?evento=agregaDropZone&referencia=" + referencia, "archivoValidador");
}


function cambiaIframeUrl(url, elemento) {
	var iframe = document.getElementById(elemento);
	iframe.src = url;
}


//Funcion para actualizar la tabla 
function actualizaTablero() {

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			//alert(xhttp.responseText);
			
			var datos = JSON.parse(xhttp.responseText);

			try{

				for(var a=0; a<datos.length; a++){

					var referencia = datos[a][0];
					var referenciaEstatusNuevo = datos[a][2];

					try{

						var referenciaEstatusViejo = document.getElementById("accion-" + datos[a][0]).getAttribute("name");
						var referenciaProcesando = document.getElementById("estatus-" + datos[a][0]).innerHTML;

						if(referenciaProcesando != "generando..." || referenciaProcesando != "cambiando..." || referenciaProcesando != "prevalidando..." || referenciaProcesando != "validando..." || referenciaProcesando != "pagando..." || referenciaProcesando != "liberando..."){
							if(referenciaEstatusNuevo != referenciaEstatusViejo){
								actualizaReferencia(referencia);
							}
						}

					}catch(err1){
						
						var tablero = document.getElementById("TblTablero");
						var noRegistrosTabla = tablero.rows.length;
						var row = tablero.insertRow(noRegistrosTabla);
						row.setAttribute("id", "registro-" + referencia);
						row.setAttribute("style", "background-color:rgb(249,249,249); height:35px");
						var cell1 = row.insertCell(0);
						cell1.setAttribute("id", "index-" + referencia);
						cell1.setAttribute("name", noRegistrosTabla);
						actualizaReferencia(referencia);
					}
				}

				var tablero = document.getElementById("TblTablero");
				var noRegistrosTabla = tablero.rows.length;
				if((noRegistrosTabla - 1) > datos.length){
					generaTablero();
				}

			}catch(err){
				//alert(err)
			}
			
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=actualizaTablero");
}

//Funcion para Actualizar Referencia
function actualizaReferencia(referencia) {

	var referenciaIndex = document.getElementById("index-" + referencia).getAttribute("name");
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("registro-" + referencia).innerHTML = xhttp.responseText;

			var referenciaEstatusNuevo = document.getElementById("accion-" + referencia).getAttribute("name");
			var referenciaDetalle = document.getElementById("referenciaDetalle").innerHTML;
			var estatusDetalle = document.getElementById("estatusDetalle").innerHTML;

			if(referencia == referenciaDetalle){
				if(referenciaEstatusNuevo != estatusDetalle){
					document.getElementById("detalle-" + referencia).click();
				}
			}
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=actualizaReferencia&referencia=" + referencia + "&index=" + referenciaIndex);
}


//Funcion para generar la tabla 
function generaTablero() {
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("tablero").innerHTML = xhttp.responseText;
		}
	};
	
	xhttp.open("POST", "../Controllers/validacionPeceController.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=generaTablero");
}