<?php
                        if($estiloUsuario == 1){
                            echo "<link type='text/css' rel='stylesheet' href='../../../../../css/styleHomePage.css'/>";
                        }else if($estiloUsuario == 2){
                            echo "<link type='text/css' rel='stylesheet' href='../../../../../css/styleHomePage2.css'/>";
                        }
            ?>

            <link rel="shortcut icon" type="image/x-icon" href="../../../Imagenes/ICN_PestanaWebGE.png">
             <?php                   
            $breadcrumb="<a href='../../../../../Home.php' id='breadcrumbs'> Home / </a><a href='../../../../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> <a href='../../../../Modulos.php' id='breadcrumbs'> Modulos / </a> <a href='../../principalSimulacros.php' id='breadcrumbs'> Principal simulacros</a>"; 
?>
             
        <table border='0'  align='left' name='Datos_usuario' width="100%">
            <tr style="height: 30px"></tr>
        <tr> 
            <td width="10%"></td><td width="20%"  align='left' id='breadcrumbs'>Usuario: <?php echo $usuarioId ?></td>
            <td></td>
        </tr>
        <tr> 
            <td width="10%"></td><td width="20%"  align='left' id='breadcrumbs'>Fecha: <?php echo date('d-m-y'); ?></td>
            <td></td>
        </tr>
        <tr><td width="10%"></td><td width="75%" align='left' id='breadcrumbs'>Ciudad: <?php echo $c->imprimirCiudad($usuarioId); ?></td>      
            <td width="80%" align="left" ><a href="logout.php" target="cerrarSesion" id="breadcrumbs">Cerrar sesion</a></td>
        </tr>
        </table>

        <table border='0' align='center' name='Encabezado' width="100%">
        <tr height='50px'><td></td></tr>
        <tr>
        <td align='center' id='titulo1'><?php echo $nombreModulo ?></td>
        </tr>
        <tr>
            <td align='center' valign='top' height='20px'>
                <table border='0' align='center'>
                    <tr height='20px'>
                        <td valign='middle'>
                            <img src='../../../../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>
                            <img src='../../../../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>
                        </td>                
                        <td valign='middle'>
                            <font style='display:inline-block;'> <?php echo $breadcrumb ?></font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
        <table border='0' align='center' id='mapaIntranet' style='display:none;'>
        </table>
</head>