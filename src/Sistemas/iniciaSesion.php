<?php
session_start();

/*
 *@author Cosijopi Richard Ruiz Avendaño
 *@version 1.0
 *@copyright Copyright (c) 2015, Grupo Escalante Agencias Aduanales S.C.

 */

require_once "conexionMasterDB.php";

if (isset($_SESSION["autentificado"]) && $_SESSION["autentificado"] == "SI") {
    $sesionUsuario = $_SESSION["sesionUsuario"];
    $sesionFechaEntrada = date('Y-m-d');
    $sesionHoraEntrada = date('H:i:s');

    //echo "INSERT into PERFILES.SESIONES_USUARIOS (xt_usuario, xd_fechaEntrada, xt_horaEntrada) values ('$sesionUsuario','$sesionFechaEntrada','$sesionHoraEntrada') ";

    $MASTER_GE->Execute("INSERT into PERFILES.SESIONES_USUARIOS (xt_usuario, xd_fechaEntrada, xt_horaEntrada) values ('$sesionUsuario','$sesionFechaEntrada','$sesionHoraEntrada') ") or die("Error al registrar el inicio de session <br>");

    $s = $MASTER_GE->Execute("select xn_sesionId from PERFILES.SESIONES_USUARIOS where xt_usuario = '$sesionUsuario' and xd_fechaEntrada = '$sesionFechaEntrada' and xt_horaEntrada = '$sesionHoraEntrada' ") or die("Error al seleccionar la session <br>");
    $r = $s->fetchRow();
    //echo "$sesionUsuario";
    $_SESSION["sesionId"] = $r[0];
    //echo $_SESSION["sesionId"];

    $ultimoCambioPass = date('Y-m-d', strtotime($MASTER_GE->getOne("SELECT xd_fechaCambioPassword FROM PERFILES.USUARIOS WHERE xt_usuario = '$sesionUsuario' ")));
    $fechaActual = date('Y-m-d');

    $dias = abs((strtotime($ultimoCambioPass) - strtotime($sesionFechaEntrada)) / 86400);
    //echo "-$dias";
    if ($dias >= 180) {
        header("Location: Configuraciones/modificaPassword.php");
    } else {
        //echo $_SESSION["sesionCategoria"];
        if ($_SESSION["sesionCategoria"] == 'Administrador') {
            header("Location: seleccionaSistema.php");
        } else if ($_SESSION["sesionCategoria"] == 'Inhouse' || $_SESSION["sesionCategoria"] == 'inhouse') {
            header("Location: seleccionaSistema.php");
        } else if ($_SESSION["sesionCategoria"] == 'Cliente') {
            header("Location: seleccionaSistema.php");
        }else if ($_SESSION["sesionCategoria"] == 'Empleado') {
            header("Location: seleccionaSistema.php");
        }
    }

} else if ($_POST['usuario'] == '' || $_POST['password'] == '') {
    //echo "entra 3" . $_POST['usuario'] . "-" . $_POST['password'];

    header("Location: index.php");

} else if (($_POST['usuario'] != '' && $_POST['password']) != '') {
    

    //echo "entra 2" . $_POST['usuario'] . "-" . $_POST['password'];

    $patrones = array(' OR ', ' AND ', ' or ', ' and ', '<', '>', '(', ')', "'", '"'); // array(' OR ', ' AND ', '=', ' or ', ' and ', ' < ', ' > ', '<', '>', '*', '(', ')', ' ( ', ' ) ', ' , ', ',', '%', "'", '"');

    $usuario = str_replace($patrones, "", htmlspecialchars(trim($_POST['usuario']), ENT_QUOTES, 'UTF-8'));
    $password = str_replace($patrones, "", htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8'));

    $status = false;
    //echo "SELECT u.xt_usuario, u.xt_categoria, u.xn_estilo, u.xt_estatus, u.xt_correo, u.xt_puesto, (SELECT cp.xt_categoria FROM perfiles.catalogo_puestos cp WHERE cp.xt_puesto = u.xt_puesto LIMIT 1) as xt_puestoCategoria, ( SELECT e.kp_personalId FROM intranetgea.sgi_empleados e WHERE e.kf_usuario = u.xt_usuario) AS xt_personalId  from PERFILES.USUARIOS u where u.xt_usuario='$usuario' and u.xt_password='$password' AND u.xt_estatus ='Activo' ";
    $query = "SELECT u.xt_usuario, u.xt_categoria, u.xn_estilo, u.xt_estatus, u.xt_correo, u.xt_puesto, (SELECT cp.xt_categoria FROM perfiles.catalogo_puestos cp WHERE cp.xt_puesto = u.xt_puesto LIMIT 1) as xt_puestoCategoria, ( SELECT e.kp_personalId FROM intranetgea.sgi_empleados e WHERE e.kf_usuario = u.xt_usuario) AS xt_personalId  from PERFILES.USUARIOS u where u.xt_usuario='$usuario' and u.xt_password='$password' AND u.xt_estatus ='Activo' ";
    $s = $MASTER_GE->Execute($query);
    $texto = "";

    while ($r = $s->fetchRow()) {
        //var_dump($r);

        //session_start();
        $sesionId = $_SESSION["sesionId"];
        $sesionUsuario = $_SESSION["sesionUsuario"];
        $sesionEstilo = $r[2];
        $sesionFechaSalida = date('Y-m-d');
        $sesionHoraSalida = date('H:i:s');
        $sesionCorreo = $r[4];
        $sessionPuesto = $r[5];
        $sessionPuestoCategoria = $r[6];
        $sessionPersonalId = $r[7];

        //echo "UPDATE PERFILES.SESIONES_USUARIOS set xd_fechaSalida = '" . $sesionFechaSalida . "', xt_horaSalida = '" . $sesionHoraSalida . "' where xn_sesionId = '" . $sesionId . "' and xt_usuarioId = '" . $sesionUsuario . "' ";
        $MASTER_GE->execute("UPDATE PERFILES.SESIONES_USUARIOS set xd_fechaSalida = '" . $sesionFechaSalida . "', xt_horaSalida = '" . $sesionHoraSalida . "' where xn_sesionId = '" . $sesionId . "' and xt_usuario = '" . $sesionUsuario . "' ");

        //session_destroy();

        $status = true;
        //echo "a" . $sesionUsuario = $r[0];
        //echo "b" . $sesionCategoria = $r[1];
        $sesionEstilo = $r[2];

    }

    if ($status == true) {

        //session_start();

        $_SESSION["autentificado"] = "SI";
        $_SESSION["sesionUsuario"] = $sesionUsuario;
        $_SESSION["sesionCategoria"] = $sesionCategoria;
        $_SESSION["sesionHoraAcceso"] = date('H:i:s');
        $_SESSION["sesionEstilo"] = $sesionEstilo;
        $_SESSION["sesionCorreo"] = $sesionCorreo;
        $_SESSION["sesionPuesto"] = $sessionPuesto;
        $_SESSION["sesionPuestoCategoria"] = $sessionPuestoCategoria;
        $_SESSION["sessionPersonalId"] = $sessionPersonalId;

        $sesionFechaEntrada = date('Y-m-d');
        $sesionHoraEntrada = date('H:i:s');

        $MASTER_GE->Execute("INSERT into PERFILES.SESIONES_USUARIOS (xt_usuario, xd_fechaEntrada, xt_horaEntrada) values ('$sesionUsuario','$sesionFechaEntrada','$sesionHoraEntrada')");

        $s = $MASTER_GE->Execute("SELECT xn_sesionId from PERFILES.SESIONES_USUARIOS where xt_usuario = '$sesionUsuario' and xd_fechaEntrada = '$sesionFechaEntrada' and xt_horaEntrada = '$sesionHoraEntrada' ");
        $r = $s->fetchRow();

        $_SESSION["sesionId"] = $r[0];

        $ultimoCambioPass = date('Y-m-d', strtotime($MASTER_GE->getOne("SELECT xd_fechaCambioPassword FROM PERFILES.USUARIOS WHERE xt_usuario = '$sesionUsuario' ")));
        $fechaActual = date('Y-m-d');
        $dias = abs((strtotime($ultimoCambioPass) - strtotime($sesionFechaEntrada)) / 86400);

        if ($dias >= 180) {
            header("Location: Configuraciones/modificaPassword.php");
        } else {
            
            if ($_SESSION["sesionCategoria"] == 'Administrador') {
                header("Location: seleccionaSistema.php");
            } else if ($_SESSION["sesionCategoria"] == 'Inhouse') {
                header("Location: seleccionaSistema.php");
            } else if ($_SESSION["sesionCategoria"] == 'Cliente') {
                header("Location: seleccionaSistema.php");
            }else if ($_SESSION["sesionCategoria"] == 'Empleado') {
                header("Location: seleccionaSistema.php");
            }else if ($_SESSION["sesionCategoria"] == 'Proveedor') {
                header("Location: seleccionaSistema.php");
            }
            
        }

    } else {

        //session_start();
        //session_destroy();
        unset($sesionUsuario);
        header("Location: index.php");
        //echo "Usuario Invalido";
    }

}
