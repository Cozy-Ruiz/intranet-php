<?php error_reporting(0); ?>
<?php 
require_once("../ConexionDBT.php");

//VARIABLES GENERALES
$codigoAnt     = $_POST["codigoOld"];
$codigoOld     = explode("_",$_POST["codigoOld"]);

//MODIFICAR FUNCIONALIDAD
$funcionalidad = $_POST["funcionalidad"];
$actividades   = $_POST["actividades"];

//MODIFICARACTIVIDAD
$rol    = $_POST["rol"];
$tiempo = $_POST["tiempo"];

if($actividades != "nada" && $funcionalidad == "nada" && !isset($_POST["rol"]) && !isset($_POST["tiempo"])){
  
  $codigoNuevo = $codigoOld[0]."_".$codigoOld[1]."_".$actividades."_".$codigoOld[3];
  $codigoAct   = $codigoOld[0]."_".$codigoOld[1]."_".$actividades;

  $previo = $INTRANET->getOne("SELECT 
                                kp_codigo 
                              FROM 
                                SGI_Proceso_Roles_Actividades_Funcionalidades
                              WHERE kp_codigo = '$codigoNuevo'");
  if($previo != ''){

    $string =  "UPDATE SGI_Proceso_Roles_Actividades_Funcionalidades
                  SET 
                    kp_codigo = '$codigoNuevo',
                    kf_codigoProcesoRolActividad = '$codigoAct'
                  WHERE 
                    kp_codigo = '$codigoAnt'";  
    $INTRANET->Execute($string);
    echo $codigoNuevo;
  }else{

    echo "El codigo ya existe.";
  }
  
}else if($funcionalidad != "nada" && $actividades == "nada" && !isset($_POST["rol"]) && !isset($_POST["tiempo"])){

  $codigoNuevo = $codigoOld[0]."_".$codigoOld[1]."_".$codigoOld[2]."_".$funcionalidad;

  $previo = $INTRANET->getOne("SELECT 
                                kp_codigo 
                              FROM 
                                SGI_Proceso_Roles_Actividades_Funcionalidades
                              WHERE kp_codigo = '$codigoNuevo'");
  if($previo != ''){

    $string = "UPDATE SGI_Proceso_Roles_Actividades_Funcionalidades
                    SET
                      kp_codigo = '$codigoNuevo',
                      kf_codigoFuncionalidad = '$funcionalidad'
                    WHERE 
                      kp_codigo = '$codigoAnt'";
    $INTRANET->Execute($string);

    echo $codigoNuevo;
  }else{

    echo "El codigo ya existe.";
  }
}else if($funcionalidad != "nada" && $actividades != "nada" && !isset($_POST["rol"]) && !isset($_POST["tiempo"])){

  $codigoNuevo = $codigoOld[0]."_".$codigoOld[1]."_".$actividades."_".$funcionalidad;
  $codigoAct   = $codigoOld[0]."_".$codigoOld[1]."_".$actividades;

  $previo = $INTRANET->getOne("SELECT 
                                kp_codigo 
                              FROM 
                                SGI_Proceso_Roles_Actividades_Funcionalidades
                              WHERE kp_codigo = '$codigoNuevo'");
  if($previo != ''){

    $string = "UPDATE SGI_Proceso_Roles_Actividades_Funcionalidades
                    SET
                      kp_codigo = '$codigoNuevo',
                      kf_codigoFuncionalidad = '$funcionalidad'
                      kf_codigoProcesoRolActividad = '$codigoAct'
                    WHERE 
                      kp_codigo = '$codigoAnt'";
    $INTRANET->Execute($string);

    echo $codigoNuevo;

  }else{

    echo "El codigo ya existe.";
  }
}
if($rol != "nada" && $tiempo == "nada"){

  $codigoNuevo2 = $codigoOld[0]."_".$rol."_".$codigoOld[2];
  $codigoRol    = $codigoOld[0]."_".$rol;

  //procesos_roles_actividades
  //echo "SELECT kp_codigo FROM SGI_Procesos_Roles_Actividades WHERE kp_codigo = '$codigoNuevo2'";
  //echo "<br>";

  $va = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Procesos_Roles_Actividades WHERE kp_codigo = '$codigoNuevo2'");
  if($va == ''){
    $string = "UPDATE SGI_Procesos_Roles_Actividades
                        SET
                          kf_codigoProcesoRol = '$codigoRol',
                          kp_codigo = '$codigoNuevo2'
                        WHERE
                          kp_codigo = '$codigoAnt'
                        ";

    $INTRANET->Execute($string);
    //echo "<br>";
    //

  }else{

    echo "El codigo ya existe.";
  }
  //procesos_roles_actividades_funcionalidades
  $va2 = $INTRANET->getOne("SELECT kf_codigoProcesoRolActividad FROM SGI_Procesos_Roles_Actividades_Funcionalidades WHERE kf_codigoProcesoRolActividad = '$codigoNuevo2'");

  if($va2 == ''){
    
    $s = $INTRANET->Execute("SELECT kp_codigo, kf_codigoProcesoRolActividad FROM SGI_Procesos_Roles_Actividades_Funcionalidades WHERE kf_codigoProcesoRolActividad = '$codigoAnt'");
    while($r = $s->fetchRow()){
      $cod = explode("_",$r[0]);
      $valorKp = $cod[0]."_".$rol."_".$cod[2]."_".$cod[3];
      $valorKf = $cod[0]."_".$rol."_".$cod[2];
    
      $string = "UPDATE SGI_Proceso_Roles_Actividades_Funcionalidades
                          SET
                            kf_codigoProcesoRolActividad = '$valorKf',
                            kp_codigo = '$valorKp'
                           WHERE 
                            kf_codigoProcesoRolActividad = '$r[1]'
                          AND
                            kp_codigo = '$r[0]'";

      $INTRANET->Execute($string);
      //echo "<br>";
    }

    echo $codigoNuevo2;

  }else{

    echo "El codigo ya existe.";
  }
}else if($rol == "nada" && $tiempo != "nada"){

  $string = "UPDATE SGI_Procesos_Roles_Actividades
                      SET
                        xt_tiempo = '$tiempo'
                        WHERE
                        kp_codigo = '$codigoAnt'
                        ";

  $INTRANET->Execute($string);

  echo $codigoAnt;

}else if($rol != "nada" && $tiempo != "nada"){

   $codigoNuevo2 = $codigoOld[0]."_".$rol."_".$codigoOld[2];
  $codigoRol    = $codigoOld[0]."_".$rol;

  //procesos_roles_actividades
  //echo "SELECT kp_codigo FROM SGI_Procesos_Roles_Actividades WHERE kp_codigo = '$codigoNuevo2'";
  //echo "<br>";
  $va = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Procesos_Roles_Actividades WHERE kp_codigo = '$codigoNuevo2'");
  if($va == ''){
    $string = "UPDATE SGI_Procesos_Roles_Actividades
                        SET
                          kf_codigoProcesoRol = '$codigoRol',
                          kp_codigo = '$codigoNuevo2',
                          xt_tiempo = '$tiempo'
                        WHERE
                          kp_codigo = '$codigoAct'
                        ";
    //echo "<br>";
    $INTRANET->Execute($string);

  }else{

    echo "El codigo ya existe.";
  }
  //procesos_roles_actividades_funcionalidades
  //echo "SELECT kf_codigoProcesoRolActividad FROM SGI_Procesos_Roles_Actividades_Funcionalidades WHERE kf_codigoProcesoRolActividad = '$codigoNuevo2'";
  //echo "<br>";
  $va2 = $INTRANET->getOne("SELECT kf_codigoProcesoRolActividad FROM SGI_Procesos_Roles_Actividades_Funcionalidades WHERE kf_codigoProcesoRolActividad = '$codigoNuevo2'");

  if($va2 == ''){
    
    $s = $INTRANET->Execute("SELECT kp_codigo, kf_codigoProcesoRolActividad FROM SGI_Procesos_Roles_Actividades_Funcionalidades WHERE kf_codigoProcesoRolActividad = '$codigoAnt'");
    while($r = $s->fetchRow()){
      $cod = explode("_",$r[0]);
      $valorKp = $cod[0]."_".$rol."_".$cod[2]."_".$cod[3];
      $valorKf = $cod[0]."_".$rol."_".$cod[2];
    
      $string = "UPDATE SGI_Proceso_Roles_Actividades_Funcionalidades
                          SET
                            kf_codigoProcesoRolActividad = '$valorKf',
                            kp_codigo = '$valorKp'
                           WHERE 
                            kf_codigoProcesoRolActividad = '$r[1]'
                          AND
                            kp_codigo = '$r[0]'";
      //echo "<br>";
      $INTRANET->Execute($string);
    }

    echo $codigoNuevo2;

  }else{

    echo "El codigo ya existe.";
  }
}