//Funcion para enviar a registrar excepcion
function registraExcepcion(modulo, descripcion) {

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizaReferencia(referencia);
			}else{
				alert(xhttp.responseText);
			}
		}
	};
	
	xhttp.open("POST", "../Models/Excepciones.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("evento=registraExcepcion&modulo=" + modulo + "&descripcion=" + descripcion);
	
}