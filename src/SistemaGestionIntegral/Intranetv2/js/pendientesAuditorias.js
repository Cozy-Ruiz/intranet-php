/*
Programador: Guillermo Quezada Gómez
Fecha: Junio del 2019
Contacto: gquezada@escalante.com.mx
*/

//resalto registro seleccionado
function resaltaRegistro(id) {
	var elms = document.querySelectorAll("[id='"+id+"']");
    var filas = document.querySelectorAll("[class='trIlumina']");
    //recorro para  resaltar las celdas que pertenescan al Id de la relacion
    for(var i = 0; i < filas.length; i++) {
    	if(filas[i].style.backgroundColor == 'rgb(98, 178, 237)'){
      		filas[i].style.backgroundColor = '';
      	}
    }
    for(var i = 0; i < elms.length; i++){
        elms[i].style.backgroundColor="rgb(98, 178, 237)";
    }
}
//recarga la pagina que abrio el popup
function reCargarPadre(){
    opener.location.reload();
    window.close();
}
//muestra la banana de navegacion
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
//esta funcion me sirve para mostrar y ocultar dos id al mismo tiempo
function muestra_ocultaDiv(divMostrar, divOcultar){
	if (divMostrar!='') {
	var mostrar = document.getElementById(divMostrar);
		if(mostrar.style.display == 'block'){
			mostrar.style.display = 'none';
		}else{
			mostrar.style.display = 'block';
		}
	}

	if (divOcultar!='') {
	var ocultar = document.getElementById(divOcultar);
		if(ocultar.style.display == 'block'){
			ocultar.style.display = 'none';
		}else{
			ocultar.style.display = 'block';
		}
	}
}
//muestro filtro
function muestraFiltro(){
    //obtengo todos los atributos del filtro
    var form1 = document.getElementById("filtroTablero");
    //valido que este oculto o no
    if(form1.style.display ==  'none'){
        form1.style.display = 'block';          
    }else{
        form1.style.display =  'none';
    }
}

//Funcion para subir archivo evaluacion
function agregaNotaAuditoria(auditoria,id){
    //obtengo el contenido de la nota
    var nota = document.getElementById(id).value;
    if (nota != '') {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == true) {
                    //si se inserta o actualiza correctamente la nota recargo solo el div de contenido para no recargar toda la pagina
                    document.getElementById('showNota_'+auditoria).innerHTML = nota;
                    //muestro y oculto lo necesario
                    muestra_ocultaDiv('showNota_'+auditoria,'modNota_'+auditoria);
                    muestra_ocultaDiv('engrane_'+auditoria,'check_'+auditoria);
                }else{
                    alert(xhttp.responseText);
                }
            }
        };
        //envio la informacion a guardar
        xhttp.open("POST", "modificaInformacion.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("evento=agregaNotaAuditoria&auditoria="+auditoria+"&nota="+nota);
    }else{
        alert("Escribe algo para guardar!");
    }
}