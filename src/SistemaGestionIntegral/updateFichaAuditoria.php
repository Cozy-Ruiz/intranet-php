<?php error_reporting(0); ?>
<?PHP

/*
 *@author Samantha del Carmen Abam Donoso
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp="updateFichaAuditoria.php";
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$auditoriaId= $_GET['id'];


$informe = $_POST['informe'];
$programa = $_POST['programa'];
$titulo = $_POST['titulo'];


echo"$informe <br> $programa <br> $titulo<br> ID $auditoriaId"

    $INTRANET->Execute("UPDATE SGI_Auditorias SET xt_titulo= '$titulo' WHERE kp_auditoriaID= $auditoriaId ");
        
if($informe != ""){

    $INTRANET->Execute("UPDATE SGI_Auditorias SET xt_descripcion= '$informe' WHERE kp_auditoriaID= $auditoriaId ");

	header("Location: FichaAuditoria.php?id=$auditoriaId");

}

if($programa != ""){

    $INTRANET->Execute("UPDATE SGI_Auditorias SET xt_descripcion= '$programa' WHERE kp_auditoriaID= $auditoriaId ");

	header("Location: FichaAuditoria.php?id=$auditoriaId");

}

header("Location: FichaAuditoria.php?id=$auditoriaId");

?>