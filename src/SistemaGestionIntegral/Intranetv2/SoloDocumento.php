<?php

$nombrephp = 'FichaItem.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

//$codDocumento = $_GET['id'];
 error_reporting(E_PARSE);

?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="latin">
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
			<style type="text/css">
				
				#roles, #tiempos{
					color: #007CBD;
				}
				table.auto{
					table-layout: auto;
				}

				.linkButton {

					float:right;
					font-family: Lucida Sans, Arial;
					font-size: 13px;
				    background: none;
				    border: none;
				    color: #007CBD;
				    text-decoration: none;
				    cursor: pointer; 
				}
			</style>            
        
             <?php

             set_time_limit(300); // Esta es la línea añadida para lograr tu objetivo.
			
 

             //NormaISO31000Copy.pdf 11 mb

             //SocioComercialCertificadoJAEB.pdf 9 mb

             // CRP-CC-GRL-X-0128 Manual de identidad gráfica ISO.pdf MB

             //CRPCCGRLX0123ISO31000GestiondeRiesgosPrincipiosyDirectrices.pdf 5mb

             //CRPOPGRLX0221AlcatelLucentBrokerRules2019.pdf 3mb
             $doc= "procedimiento7.pdf";
              
           //  $ruta ="0023.pdf"; 
           //  $ruta="../Correctiva0.pdf";
           // $ruta ="../../Correctiva0.pdf";
          // $ruta ="../../FILES/GEOPETOLI001InstructivoSAAI.pdf"; -1mb
              $ruta ="../../FILES/NYECCGRLX0135CertificadoNMXR026SCFI2016.pdf";//+1mb 

              set_time_limit(8000); // Esta es la líne	a añadida para lograr tu objetivo.
			$src = urldecode($ruta);
    //$src <-- string 'Z:/327000360.pdf'

    		ini_set('memory_limit', '2048');
    		$dataBase64 = base64_encode(file_get_contents($src));   


              $src = urldecode($_REQUEST['archivo']);
            
            echo " <embed src='data:application/pdf;base64,$dataBase64' width='100%' type='application/pdf'>";

             ?>


			 
	</body>
</html>

