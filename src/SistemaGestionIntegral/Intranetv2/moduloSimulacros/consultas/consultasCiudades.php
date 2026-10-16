<?php
/*
CONSULTAS A LA BASE DE DATOS SGI_Catalogo_Sucuarsales
*/

class Ciudades{

	function imprimir(){
		$conexion = new ConexionIntranet();
		$d = $conexion->Query("SELECT xt_descripcionSimulacro FROM SGI_Simulacros WHERE xt_ciudad = 'CMX'");

		while($f = $d->fetchRow()){
		            $nombreS = $f[0];
		            if(!empty($nombreS)){
		                echo $nombreS."<br>";
		            }
		        }
		$conexion->Close();
		}

	function imprimirCiudad($usuario){
//bug por dejar acento
		if($usuario=="José_Sigala"){
				$usuario=="Jose_Sigala";
				
			}
		$conexion = new ConexionIntranet();
		$c = $conexion->Query("SELECT DISTINCT LTRIM(RTRIM(xt_ciudad)) FROM IntranetGEA.IntranetGEA_USUARIOS WHERE kp_usuario = '".$usuario."'");
		
		while($city = $c->fetchRow()){
            $nombreC = $city[0];
            if(!empty($nombreC)){
                if ($nombreC == 'DF' || $nombreC == 'CDMX'){
			        $ciudad = 'CMX';
			    }else{
			    	$ciudad = $nombreC;
			    }
            }
        }
    return $ciudad;
	$conexion->Close();
	}

		function nombreCiudad($codigo){
		$conexion = new ConexionIntranet();
		$c = $conexion->Query("SELECT DISTINCT xt_nombre FROM SGI_Catalogo_Sucursales WHERE xt_sucursal = '".$codigo."'");
		
		while($city = $c->fetchRow()){
            $nombreC = $city[0];
            if(!empty($nombreC)){
                if ($nombreC == 'DF'){
			        $ciudad = 'CMX';
			    }else{
			    	$ciudad = $nombreC;
			    }
            }
        }
    return $ciudad;
	$conexion->Close();
	}

	function opcionesCiudadesFiltro($usuario){
		$conexion = new ConexionIntranet();
	    $con_usuario = new Usuarios();
	    $con_ciudades = new Ciudades();
	    $usuariosAdmin = $con_usuario->getUsuariosAdmin();
		$c = $conexion->Query("SELECT DISTINCT cs.xt_sucursal, cs.xt_nombre FROM SGI_Catalogo_Sucursales cs 
								INNER JOIN SGI_Simulacros s ON cs.xt_sucursal = s.xt_ciudad ORDER BY cs.xt_nombre ASC");
		$repetir=1;
		while($city = $c->fetchRow()){
            $codigo = $city[0];
            $nombreC = $city[1];
            if(!empty($codigo)){
            	if (in_array($usuario, $usuariosAdmin)) {
                        echo "<option value=".$codigo." > ".$nombreC."</option>";
                    }else{
                    	if ($repetir==1) {
                    	$codigoCiudad = $this->imprimirCiudad($usuario);
                    	$nombreCiudad = $this->nombreCiudad($codigoCiudad);
                        echo "<option value=".$codigoCiudad." > ".$nombreCiudad."</option>";
                        $repetir=0;
                    }
                    }
                
            }
        }
	$conexion->Close();
	}

	function opcionesCiudades(){
		$conexion = new ConexionIntranet();
		$c = $conexion->Query("SELECT DISTINCT
													CASE U.xt_codigoCiudad WHEN 'DF' THEN 'CMX' WHEN 'LRD' THEN 'LAR' ELSE U.xt_codigoCiudad END as Ciudad,
													CASE O.xt_descripcion WHEN 'Mexico DF' THEN 'Ciudad de Mexico' ELSE O.xt_descripcion END as codigo
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
	}

    $c = new Ciudades();
?>