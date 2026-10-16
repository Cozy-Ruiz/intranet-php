<?php
require_once("../../ConexionIntranet2.php");

$fechaProgramada   = $_POST['fechaProgramada'];
$fechaInicio       = $_POST['fechaInicio'];
$fechaFinalizacion = $_POST['fechaFinalizacion'];
$simulacro         = $_POST['simulacro'];

if((!empty($fechaProgramada))&&(!empty($fechaInicio))&&(!empty($fechaFinalizacion))){
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaProgramada = '$fechaProgramada' WHERE xt_codigoSimulacro = '$simulacro'")){
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaInicio = '$fechaInicio' WHERE xt_codigoSimulacro = '$simulacro'")){
			if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaFinalizacion = '$fechaFinalizacion' WHERE xt_codigoSimulacro = '$simulacro'")){
				echo true;
			}else {
				echo "Hubo un error al actualizar los datos";
			}
		} else {
			echo "Hubo un error al actualizar los datos";
		}
	}else{
		echo "Hubo un error al actualizar los datos";
	}
}
if((empty($fechaProgramada))&&(!empty($fechaInicio))&&(!empty($fechaFinalizacion))){
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaInicio = '$fechaInicio' WHERE xt_codigoSimulacro = '$simulacro'")){
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaFinalizacion = '$fechaFinalizacion' WHERE xt_codigoSimulacro = '$simulacro'")){
			if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaProgramada = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
				echo true;
			} else {
				echo "Hubo un error al actualizar los datos";
			}
		} else {
			echo "Hubo un error al actualizar los datos";
		}
	} else {
		echo "Hubo un error al actualizar los datos";
	}
}
if((!empty($fechaProgramada))&&(empty($fechaInicio))&&(!empty($fechaFinalizacion))){
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaProgramada = '$fechaProgramada' WHERE xt_codigoSimulacro = '$simulacro'")){
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaFinalizacion = '$fechaFinalizacion' WHERE xt_codigoSimulacro = '$simulacro'")){
			if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaInicio = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
				echo true;
			} else {
				echo "Hubo un error al actualizar los datos";
			}
		}else {
			echo "Hubo un error al actualizar los datos";
		}
	}else{
		echo "Hubo un error al actualizar los datos";
	}
}
if((!empty($fechaProgramada))&&(!empty($fechaInicio))&&(empty($fechaFinalizacion))){
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaProgramada = '$fechaProgramada' WHERE xt_codigoSimulacro = '$simulacro'")){
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaInicio = '$fechaInicio' WHERE xt_codigoSimulacro = '$simulacro'")){
			if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaFinalizacion = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
				echo true;
			} else {
				echo "Hubo un error al actualizar los datos";
			}
		} else {
			echo "Hubo un error al actualizar los datos";
		}
	}else{
		echo "Hubo un error al actualizar los datos";
	}
}
if((!empty($fechaProgramada))&&(empty($fechaInicio))&&(empty($fechaFinalizacion))){
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaProgramada = '$fechaProgramada' WHERE xt_codigoSimulacro = '$simulacro'")){
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaInicio = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
			if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaFinalizacion = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
				echo true;
			} else {
				echo "Hubo un error al actualizar los datos";
			}
		} else {
			echo "Hubo un error al actualizar los datos";
		}
	}else{
		echo "Hubo un error al actualizar los datos";
	}
}
if((empty($fechaProgramada))&&(!empty($fechaInicio))&&(empty($fechaFinalizacion))){
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaInicio = '$fechaInicio' WHERE xt_codigoSimulacro = '$simulacro'")){
		if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaProgramada = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
			if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaFinalizacion = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
				echo true;
			} else {
				echo "Hubo un error al actualizar los datos";
			}
		} else {
			echo "Hubo un error al actualizar los datos";
		}
	}else{
		echo "Hubo un error al actualizar los datos";
	}
}
if((empty($fechaProgramada))&&(empty($fechaInicio))&&(!empty($fechaFinalizacion))){
	if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaFinalizacion = '$fechaFinalizacion' WHERE xt_codigoSimulacro = '$simulacro'")){
			if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaInicio = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
				if($INTRANETV2->Execute("UPDATE SGI_Simulacros SET xd_fechaProgramada = NULL WHERE xt_codigoSimulacro = '$simulacro'")){
					echo true;
				} else {
					echo "Hubo un error al actualizar los datos";
				}
			} else {
				echo "Hubo un error al actualizar los datos";
			}
	}else{
		echo "Hubo un error al actualizar los datos";
	}
}
?>