<script>
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
            document.getElementById("mostrar").style.display="block";
            document.getElementById("ocultar").style.display="none";
        } else if (valor == 0){
            document.getElementById("mostrar").style.display="none";
            document.getElementById("ocultar").style.display="block";
        }
    }
</script>