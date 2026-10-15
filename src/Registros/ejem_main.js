// js/main.js
 
			function tomaFoto() {
				

				var cxt = canvas.getContext("2d");

				canvas = document.getElementById("canvas");

				video = document.getElementById("video");

 

				if(!navigator.getUserMedia)

					navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

				if(!window.URL)

					window.URL = window.webkitURL;

 

				if (navigator.getUserMedia) {

					navigator.getUserMedia({

						"video" : true,

						"audio": false

					}, function(stream) {

						video.src = window.URL.createObjectURL(stream);

						video.play();

					},function(err){

						console.log("Ocurrió el siguiente error: " + err);

					});

				}

				else{

					alert("getUserMedia no disponible");

					return;

				}

 


				// Evento click para enviar la foto al servidor.

        $('#photo').click
        (
            function()
            {
                cxt.drawImage(video, 0, 0, 200, 200);
				
				var canvas = document.getElementById("canvas");
				
				var data = canvas.toDataURL("image/jpeg");
				
				var info = data.split(",", 2);
				
					$.ajax({
					  type: "POST",
					  url: "sube_foto_previo_tmp.php",
					  data: { 
							type : info[0],

							data : info[1]
						 
					  }
					}).done(function(o) {
					  console.log('saved'); 
					});
				
				
            }
        );
    }
