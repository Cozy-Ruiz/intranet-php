<?php
$nombreModulo="Autorización de Documentos";
$nombrephp = "principalDocumentos.php";
//incluyo los archivos necesarios
require_once("../../../Librerias/adodb/adodb.inc.php");
require_once("header.php"); 
require_once("../../../ConexionIntranet2.php");
//require_once("Librerias/adodb/adodb.inc.php");
//require_once("consultas/consultaSimulacros.php");
//require_once("consultas/consultasUsuarios.php");
//obtengo arreglo de las personas que tienen permisos para hacer modificaciones al simulacro
//$usuariosAdmin = $con_usuario->getUsuariosAdmin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Autorizacion de Documentos</title>
        </head>
    <body>
     <table  border='0' align='center' width='100%' id='ocultar' style='display:block;'>
             <tr style="height: 30px"></tr>

            
            <tr id='titulo2'>
                <td align='center' style='width:350px'></td>

                <td style='width:600px'> Código Documento </td>
                <td style='width:600px'> Nombre Documento </td>
                <td style='width:600px'> Autorización Calidad</td>
                <td style='width:600px'> Autorización Juridico</td>
                <td style='width:600px'> Comentarios </td>
            </tr> 
            <tr style="height: 30px"></tr>          
            
        </table>
<?php


$indice = 0;





                 $codigoCompleto= array();
                 $codigo= array();
                 $nombreDoc= array();
                 $version= array();
                 $usuario= array();
                 $juridico =array();


                $l= $INTRANETV2->Execute("SELECT
    SMD.xt_codigoCompleto,
    SMD.xt_codigoDocumento codigo,
    SMD.xt_nombre,
    IFNULL(
        (
            SELECT
                MAX(CD.xn_version)
            FROM
                SGI_Control_De_Cambios_Documentos CD
            WHERE
                CD.xt_codigoDocumento = SMD.xt_codigoDocumento
        ),
        0
    ) version,
    IFNULL(
        (
            SELECT
                CD.xt_inicialesUsuario usuario
            FROM
                SGI_Control_De_Cambios_Documentos CD
            WHERE
                CD.xt_codigoDocumento = SMD.xt_codigoDocumento
            ORDER BY
                usuario DESC
            LIMIT 1
        ),
        'NA'
    ) usuario,
    IFNULL(
        (
            SELECT
                AD.xn_autorizacionJuridico
            FROM
                SGI_Autorizacion_Documentos AD
            WHERE
                SMD.xt_codigoCompleto = AD.xt_codigoDocumento
        ),
        'NA'
    ) juridico
FROM
    INTRANET2.SGI_Manuales_Documentos SMD
WHERE
    xt_tipoDocumento NOT IN ('K', 'f')
ORDER BY
    codigo ASC");

$indice1 = 0;




            while($i= $l->fetchRow()){
                 $codigoCompleto[$indice] =  $i[0];
                 $codigo[$indice]         =  $i[1];
                 $nombreDoc[$indice]      =  $i[2];
                 $version[$indice]        =  $i[3];
                 $usuario[$indice]        =  $i[4];    
                 $juridico[$indice]       =  $i[5];             
              

             $indice ++; 
            }unset($rl); unset($i);

            
        /* echo "<form action='recoleccionVariable.php?arregloCodigo=".serialize($codigoCompleto)."' method='POST'>";*/
           


            for($a=0; $a<count($codigo); $a++){   


                                         
                    echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                          echo"<td width='10px'></td>"; 
                            ///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
                           echo "<td width='120px' align='left'>";

                           
                           echo"<a href='../fichaDocumentov3.php?id=".$codigo[$a]."' id='fileItem' style='text-decoration:none;'>". $codigoCompleto[$a]."</a>";
                           echo "</td>";                       
                           echo"<td width='400px'> <imput type='date' name='nombre'> ". $nombreDoc[$a]."</td>";                          
                           echo"<td width='110px'></td>"; 

                           if ($usuario[$a]=='sdelap') {
                                  echo "<td> <IMG SRC='img/ICN_SemaforoVerdeOscuro.png' width=17 height=17></td> </td>";    
           
                             }   


                             if ($usuario[$a]!='sdelap') {
                                  echo "<td> <a href='prueba.php? target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes'); return false;\"><img src='img/ICN_SemaforoRojoOscuro.png' width=17 height=17></a> </td>"; 
           
                             }   
           
                                
                             if ($juridico[$a]== 0 && $usuario[$a]=='sdelap') {
                                   echo "<td> <a href='AceptarJuridico.php?CodigoDoc=".$codigo[$a]."&NombreDoc=".$nombreDoc[$a]." target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes'); return false;\"><img src='img/ICN_SemaforoRojoOscuro.png' width=17 height=17></a> </td>";     
           
                             }   
                             if ($juridico[$a]==0 && $usuario[$a]!='sdelap') {
                                  echo "<td> <IMG SRC='img/ICN_SemaforoAmarillo.png' width=17 height=17></td> </td>";    
           
                             } 
                             if ($juridico[$a]== 1) {
                                  echo "<td> <IMG SRC='img/ICN_SemaforoVerdeOscuro.png' width=17 height=17></td> </td>";    
           
                             } 



                        



                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    
                }

?>
           

        
      
        
    </body>
</html>