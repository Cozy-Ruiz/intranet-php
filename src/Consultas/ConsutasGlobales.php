<?php
/*
CONSULTAS A LA BASE DE DATOS SGI_Catalogo_Sucuarsales
*/

require_once("conexionIntranet.php");
 

function nombreCiudades(){  
    $conexion = new ConexionIntranet();
    
    $c = $conexion->Query("SELECT DISTINCT
                          CASE U.xt_codigoCiudad WHEN 'DF' THEN 'CMX' WHEN 'LRD' THEN 'LAR' ELSE U.xt_codigoCiudad END as Ciudad,
                          CASE O.xt_descripcion WHEN 'Mexico DF' THEN 'Ciudad de México' ELSE O.xt_descripcion END as codigo
                        FROM
                          IntranetGEA.IntranetGEA_Usuarios_Oficina U,
                          IntranetGEA.IntranetGEA_CATALOGO_OFICINA O
                        WHERE
                          O.xt_oficina = U.xt_codigoCiudad");
      
    while($city = $c->fetchRow()){
            $codigo = $city[0];
            $nombreC = $city[1];
            if(!empty($codigo)){
                        echo "<option value=".$codigo." > ".$nombreC."</option>";
            }
        }
  $conexion->Close(); 
  
  }


   function opcionesCiudadesAlta($onchange=""){  
    $conexion = new ConexionIntranet();
  $conexion = new ConexionIntranet();
    if($onchange!=""){
      echo '<select name="ciudad" onchange="'.$onchange.'";" > ';
       echo "<option value='' >  </option>"; 
    }
    else{
        echo '<select name="ciudad"> '; }
    $c = $conexion->Query("SELECT DISTINCT
                          CASE U.xt_codigoCiudad WHEN 'DF' THEN 'CMX' WHEN 'LRD' THEN 'LAR' ELSE U.xt_codigoCiudad END as Ciudad,
                          CASE O.xt_descripcion WHEN 'Mexico DF' THEN 'Ciudad de México' ELSE O.xt_descripcion END as codigo
                        FROM
                          IntranetGEA.IntranetGEA_Usuarios_Oficina U,
                          IntranetGEA.IntranetGEA_CATALOGO_OFICINA O
                        WHERE
                          O.xt_oficina = U.xt_codigoCiudad");
        
    while($city = $c->fetchRow()){
            $codigo = $city[0];
            $nombreC = $city[1];
            if(!empty($codigo) AND  $nombreC!= "General" ){
                        echo "<option value=".$codigo." > ".$nombreC."</option>";
            }
        }
  $conexion->Close(); 
  echo "</select>";
  }


  function opcionesCiudades($onchange=""){  
    $conexion = new ConexionIntranet();
    if($onchange!=""){
      echo '<select name="ciudad" onchange="'.$onchange.'";" ><option value="Todas">Todas</option>'; 
    }
    else{
        echo '<select name="ciudad"><option value="Todas">Todas</option>'; }
              
    $c = $conexion->Query("SELECT DISTINCT
                          CASE U.xt_codigoCiudad WHEN 'DF' THEN 'CMX' WHEN 'LRD' THEN 'LAR' ELSE U.xt_codigoCiudad END as Ciudad,
                          CASE O.xt_descripcion WHEN 'Mexico DF' THEN 'Ciudad de México' ELSE O.xt_descripcion END as codigo
                        FROM
                          IntranetGEA.IntranetGEA_Usuarios_Oficina U,
                          IntranetGEA.IntranetGEA_CATALOGO_OFICINA O
                        WHERE
                          O.xt_oficina = U.xt_codigoCiudad");
      
    while($city = $c->fetchRow()){
            $codigo = $city[0];
            $nombreC = $city[1];
            if(!empty($codigo)){
                        echo "<option value=".$codigo." > ".$nombreC."</option>";
            }
        }
  $conexion->Close(); 
  echo "</select>";
  }

  function opcionesanio()
  {

    $anio = date("Y");
    $base= 2014;
    echo '<select name="anio">';  echo "<option value='' > Todos</option>";
    for ($i=$anio; $i >= $base  ; $i--) { 
     echo "<option value=".$i." > ".$i."</option>";
    }
echo "</select>";


  }

  function anioscheck()
  {
     $anio = date("Y");
    $base= 2014;
    
    for ($i=$anio; $i >= $base  ; $i--) { 
     echo "<input type='checkbox' name='anio[]' value='$i'> $i<br>";
    }
 
  }

function opcionesCiudadescheck()
  {  
    $conexion = new ConexionIntranet();
    
    $c = $conexion->Query("SELECT DISTINCT
                          CASE U.xt_codigoCiudad WHEN 'DF' THEN 'CMX' WHEN 'LRD' THEN 'LAR' ELSE U.xt_codigoCiudad END as Ciudad,
                          CASE O.xt_descripcion WHEN 'Mexico DF' THEN 'Ciudad de México' ELSE O.xt_descripcion END as codigo
                        FROM
                          IntranetGEA.IntranetGEA_Usuarios_Oficina U,
                          IntranetGEA.IntranetGEA_CATALOGO_OFICINA O
                        WHERE
                          O.xt_oficina = U.xt_codigoCiudad");
      
    while($city = $c->fetchRow()){
            $codigo = $city[0];
            $nombreC = $city[1];
            if(!empty($codigo)){

              echo"<input type='checkbox' name='ciudad[]' value='".$codigo."'>$nombreC<br>";
                         
            }
        }
         
  $conexion->Close(); 
  
  }

  function opcionesestatuscheck($tipo)
  {  
    $conexion = new ConexionIntranet();
    
    $c = $conexion->Query("SELECT distinct xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_tipo = '$tipo'");
       
    while($A = $c->fetchRow()){
            $xt_nombre = $A[0];
            
            if(!empty($xt_nombre)){

            echo"<input type='checkbox' name='estatus[]' value='".$xt_nombre."'>$xt_nombre<br>";
                         
            }
        }
         
  $conexion->Close(); 
  
  }


   function opcionesPDR()
  {  
    echo "<select name='pdr' size='1' >";
      echo "<option value=''>Elige pdr</option>"; 

    $conexion = new ConexionIntranet();
    
    $a = $conexion->Query("SELECT DISTINCT IU.xt_nombre, SQ.xt_pdr FROM SGI_Quejas_Solicitudesv2 SQ, IntranetGEA.IntranetGEA_USUARIOS IU WHERE SQ.xt_pdr = IU.kp_usuario order by IU.xt_nombre");
      
    while($n= $a->fetchRow()){
        echo"<option value='".$n[1]."'>".$n[0]."</option>"; 
   }      echo "</select>";
  $conexion->Close(); 
  
  }

  function opcionesSolicitante()
  {  
    echo "<select name='solicitante'>";
      echo "<option value=''>Elige un Solicitante</option>";
      
    $conexion = new ConexionIntranet();
    
    $c = $conexion->Query("SELECT DISTINCT  IU.xt_nombre, SQ.kf_usuarioId FROM  SGI_Quejas_Solicitudesv2 SQ, IntranetGEA.IntranetGEA_USUARIOS IU WHERE  SQ.kf_usuarioId = IU.kp_usuario ORDER BY IU.xt_nombre");
      
    while($rw = $c->fetchRow()){
      echo "<option value='".$rw[1]."'>".$rw[0]."</option>";  
    }
    echo "</select>";
  $conexion->Close(); 
  
  }

?>