<script>
	var posicion = 0;
	var imagenes=<?php echo json_encode($ruta);?>;
	var posicionMax = imagenes.length - 1;

	function ver(){
		rutaActual = "../../archivos/ImagenesEvidencia/"+imagenes[0];
		fotoActual.setAttribute('src', rutaActual);
			document.btnSiguiente.style.display = "block";
			document.fotoActual.style.display = "block";
			document.btnVer.style.display = "none";
	}

	function anterior(){
		posicion = posicion-1;
		rutaActual = "../../archivos/ImagenesEvidencia/"+imagenes[posicion];
		fotoActual.setAttribute('src', rutaActual);

			if (posicion > 0 && posicion <= posicionMax) {
			document.btnAnterior.style.display = "block";
			document.btnSiguiente.style.display = "block";
			}else{
			document.btnAnterior.style.display = "none";
			document.btnSiguiente.style.display = "block";
			}
	}

	function siguiente(){
		document.fotoActual.style.display = "block";
		posicion = posicion+1;
		rutaActual = "../../archivos/ImagenesEvidencia/"+imagenes[posicion];
		fotoActual.setAttribute('src', rutaActual);
			if (posicion > 0 && posicion <= posicionMax) {
			document.btnAnterior.style.display = "block";
			document.btnSiguiente.style.display = "block";
			}else{
			document.btnAnterior.style.display = "block";
			document.btnSiguiente.style.display = "none";
			}
	}
</script>