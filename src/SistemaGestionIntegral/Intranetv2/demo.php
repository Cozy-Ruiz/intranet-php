<?php
$archivo = base64_encode(file_get_contents("file.pdf")); 
?>
<style>
	#the-canvas {
	  border: 1px solid black;
	  direction: ltr;
	}
</style>
<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>

<?php
echo '
<body onload="llamada(\''.$archivo.'\');">

	<div>
	  <button id="previo">Anterior</button>
	  <button id="siguiente">Siguiente</button>
	  &nbsp; &nbsp;
	  <span>Pagina: <span id="page_num"></span> / <span id="total_paginas"></span></span>
	</div>
	
	<canvas id="the-canvas"></canvas>
</body>
';
?>
<script>
	
	function llamada(contenido_file){
		
		var b64 = contenido_file;
		
		var pdfData = atob(b64);
		var pdfjsLib = window['pdfjs-dist/build/pdf'];

		// The workerSrc property shall be specified.
		pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

		var pdfFile = null,
			pageNum = 1,
			pageRendering = false,
			pageNumPending = null,
			scale = 0.8,
			canvas = document.getElementById('the-canvas'),
			ctx = canvas.getContext('2d');
				
	
		function renderPagina(num) {
		  pageRendering = true;
		  // Using promise to fetch the page
		  pdfFile.getPage(num).then(function(page) {
			var viewport = page.getViewport({scale: scale});
			canvas.height = viewport.height;
			canvas.width = viewport.width;

			// Render PDF page into canvas context
			var renderContext = {
			  canvasContext: ctx,
			  viewport: viewport
			};
			var renderTask = page.render(renderContext);

			// Wait for rendering to finish
			renderTask.promise.then(function() {
			  pageRendering = false;
			  if (pageNumPending !== null) {
				// New page rendering is pending
				renderPagina(pageNumPending);
				pageNumPending = null;
			  }
			});
		  });

		  // Update page counters
		  document.getElementById('page_num').textContent = num;
		}

		function procesaPaginas(num) {
		  if (pageRendering) {
			pageNumPending = num;
		  } else {
			renderPagina(num);
		  }
		}

		/**
		 * Mostrar pagina anterior
		 */
		function paginaPrevio() {
		  if (pageNum <= 1) {
			return;
		  }
		  pageNum--;
		  procesaPaginas(pageNum);
		}
		document.getElementById('previo').addEventListener('click', paginaPrevio);

		/**
		 * Mostrar pagina siguiente.
		 */
		function paginaSiguiente() {
		  if (pageNum >= pdfFile.numPages) {
			return;
		  }
		  pageNum++;
		  procesaPaginas(pageNum);
		}
		document.getElementById('siguiente').addEventListener('click', paginaSiguiente);
				 
		pdfjsLib.getDocument({data: pdfData}).promise.then(function(documento) {
		  pdfFile = documento;
		  document.getElementById('total_paginas').textContent = pdfFile.numPages;

		  // Initial/first page rendering
		  renderPagina(pageNum);
		});
	
	}
	

</script>