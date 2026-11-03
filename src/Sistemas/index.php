<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Grupo Escalante</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://escalante.com.mx/js/node_modules/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="js/interface.js"></script>
<style>
#login_logo{
	height:300px;
	width:809px;
	/*
	margin:10px 0px 0px 460px;
	float:left;
	*/
	position:relative;
} 

#login_box {
	height:372px;
	width:500px;
	/*
	margin:0px 0px 0px 460px;
	float:left;
	position:relative;
	*/
	background:url(images/login.png) no-repeat;
}

#login_fields {
	height:170px;
	width:390px;
	float:right;
	margin:102px 53px 0 0;
	position:relative;
}

.login_fields, #datos {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#666666;
}
.URL{
    color:#00F;
    text-align:center;
    font-family:"Arial";
    font-size: 12px;
	text-decoration:none;
}


/*#campoDatos{
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	border:none;
}*/

</style>
</head>

<body>
<?php
echo "<form id='login' action='iniciaSesion.php' method='POST'>";
echo "<div id='wrapper' align='center' style='width:100%'>";
echo "<div id='login_logo'><img src='images/Grupo_Escalante_logo.png' width='460' height='260'></div>";
  echo "<div id='login_box'>";
	echo "<div id='login_fields'>";
	  echo"<table width='310' border='0' align='right' cellpadding='0' cellspacing='0' class='login_fields'>";
	  
	  
		echo "<table name= 'valida' id= 'datos' border=0>";
			  echo "<tr>";
			echo "<td width='320' height='40' align='center' valign='middle'>";
			 	echo "<input type='text'name='usuario' size='21' maxlength='50' id='campoDatosUsuario' placeholder='Username' style='height: 35px; width: 320px;'/>";
			echo "</td>";
		  echo "</tr>";
		  echo "<tr>";
			echo "<td height='25'>&nbsp;</td>";
		  echo "</tr>";	
		  echo "<tr>";
			echo "<td height='40' align='center' valign='middle'>";
				echo "<input type='password' autocomplete='off' name='password' size='21' maxlength='50' id='campoDatos' placeholder='Password' style='height: 35px;width: 320px;' />";
			echo "</td>";
		  echo "<tr>";
		  
		  echo "<tr>";
		 	 echo "<td height='20'>&nbsp;</td>";
		  echo "</tr>";	
		  
		  echo "<tr>";
				echo "<td align='center'>";
					echo "<a href='EnvioAcceso.php' class='URL' 
							target='popup' onclick=\"window.open(this.href,this.target,'width=450,height=280,scrollbars=yes')\">";
						echo "¿Olvidaste tu contraseña?";
					echo "</a>";
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td align='center'>";
					echo "¿Olvidaste tu usuario?, contacta al departamento de calidad.";
				echo "</td>";
			echo "</tr>";
		
		  echo "</tr>";
			echo "<td  height='40' align='right' valign='bottom'>";
			echo "<a href='javascript:document.forms.login.submit()'><img src='images/btn_login_key_2.png' width='30' height='30' border='none'></a>";
			echo "</td>";
		  echo "</tr>";
		echo "</table>";
		
  
	echo "</div>";
  echo "</div>";
echo "</div>";//<!--end wrapper-->
echo "</form>";
?>

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#dock2').Fisheye(
				{
					maxWidth: 120,
					items: 'a',
					itemsText: 'span',
					container: '.dock-container2',
					itemWidth: 120,
					proximity: 60,
					alignment : 'left',
                    valign: 'bottom',
                    halign : 'center'
				}
			)
		}
	);

</script>
 
</body>
</html>
