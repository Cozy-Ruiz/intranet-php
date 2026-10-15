'use strict';

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById("snap");
const envio = document.getElementById("envio");
const errorMsgElement = document.querySelector('span#errorMsg');
var $canvas2 = document.getElementById("canvas")
const constraints = {
  
  video: {
    width: 320, height: 240
  }
};

// Access webcam
async function init() {
  try {
    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    handleSuccess(stream);
  } catch (e) {
     //window.close();
  }
}

// Success
function handleSuccess(stream) {
  window.stream = stream;
  video.srcObject = stream;
}


function mostarOcultar() {
  
  if (canvas.style.display === "none") {
    canvas.style.display = "block";
  } else {
    canvas.style.display = "none";
  }
  
  if (video.style.display === "none") {
    video.style.display = "block";
  } else {
    video.style.display = "none";
  }

  if (envio.style.display === "none") {
    envio.style.display = "block";
  } else {
    envio.style.display = "none";
  }
  

  
}

// Load init
init();

// Draw image
var context = canvas.getContext('2d');
snap.addEventListener("click", function() {
context.drawImage(video, 0, 0, 320, 240);
var foto = canvas.toDataURL(); //Esta es la foto, en base 64

var xhr = new XMLHttpRequest();
        xhr.open("POST", "./guardar_foto.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(encodeURIComponent(foto)); //Codificar y enviar

        xhr.onreadystatechange = function() {
            if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                console.log("La foto fue enviada correctamente");
                console.log(xhr); 
            var   foto= document.getElementById('foto');
               foto.value=xhr.responseText;
                mostarOcultar()
            }
        }



});