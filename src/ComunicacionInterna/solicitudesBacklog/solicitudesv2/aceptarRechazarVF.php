<?php error_reporting(0); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
require_once("../../ConexionDBT.php");
$solicitudID = $_POST['codigo'];

 $status = $_POST['status'];
 
 $usuario = $_POST['usuario'];
 
 $comentario = $_POST['comentario'];
 
?>

<script type="text/javascript" src="../../JS/jquery-1.9.1.js"></script>

<!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
 <script language="javascript" type="text/javascript">
 
 function ilumina(celda, color){
	 
 celda1 = document.getElementById(celda);
 //var celda1 = document.getElementById(celda).innerHTML;

  	var codigo ="<?php echo $solicitudID;?>";
	var usuario = "<?php echo $usuario;?>";
 // alert (color+celda);

    if(color == 'white' && celda == 'tdProcede'){
	//alert (celda1);
    	//celda1.style.bgcolor  = 'red';
		celda1.style.backgroundColor  = '#42CB27';
        document.getElementById('tdNoProcede').style.backgroundColor  = 'red';
		

        $('#validacionNegocio').load("aceptarRechazarVN.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario}, function(data){

       })
       
	}

    if(color == 'white' && celda == 'tdNoProcede'){
            celda1.style.backgroundColor  = '#42CB27';
           document.getElementById('tdProcede').style.backgroundColor  = 'red';

           $('#validacionNegocio').load("aceptarRechazarVN.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario}, function(data){

       		})
       }


    }
  </SCRIPT>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<?php

//hago consulta para saber que validacion tiene asignada
              
$statusValidacionT = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'FINAL'");

if (empty($statusValidacionT)){

	$INTRANET->Execute("INSERT INTO SGI_Backlog_Validaciones (xt_quejaSolicitud, xt_status, xt_tipoValidacion, xt_usuario, xt_comentario) VALUES ('$solicitudID', '$status', 'FINAL', '$usuario', '$comentario')");
	
}else{
	
	$INTRANET->Execute("UPDATE SGI_Backlog_Validaciones SET xt_status = '$status', xt_usuario = '$usuario' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'FINAL'");
	
}



	
	?>
<script>
	window.location.reload();
</script>
<?php
	


?>

</body>
</html>
