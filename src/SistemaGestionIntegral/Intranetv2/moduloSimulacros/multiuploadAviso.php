<?php
$simulacro = $_POST['simulacro'];
class Multiupload
{
    /**
    *sube archivos al servidor a través de un formulario
    *@access public
    *@param array $files estructura de array con todos los archivos a subir
    */
    public function upFiles($files = array(), $simulacro)
    {
    $dbHost = 'localhost:3306';
    $dbUsername = 'INTRANET';
    $dbPassword = 'intranet';
    $dbName = 'INTRANET';
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 

        /*$conexion = new ConexionIntranet();*/

        //inicializamos un contador para recorrer los archivos
        $i = 0;

        //si no existe la carpeta files la creamos
        if(!is_dir("archivosAviso/")) 
            mkdir("archivosAviso/", 0777);
         
        if ($_FILES['userfile']['name'][0]) {
            $tipo[0]="1";
        }
        if($_FILES['userfile']['name'][1]){
            $tipo[1]="2";
        }
        if ($_FILES['userfile']['name'][2]) {
            $tipo[2]="3";
        }
        if ($_FILES['userfile']['name'][3]) {
            $tipo[3]="4";
        }

        //recorremos los input files del formulario
        foreach($files as $file) 
        {
            //si se está subiendo algún archivo en ese indice
            if($_FILES['userfile']['tmp_name'][$i])
            {
                //separamos los trozos del archivo, nombre extension
                $trozos[$i] = explode(".", $_FILES["userfile"]["name"][$i]);

                //obtenemos la extension
                $extension[$i] = end($trozos[$i]);

                //si la extensión es una de las permitidas
                if($this->checkExtension($extension[$i]) === TRUE)
                {

                    //comprobamos si el archivo existe o no, si existe renombramos 
                    //para evitar que sean eliminados   
                    $_FILES['userfile']['name'][$i] = $this->checkExists($trozos[$i]); 
                                        //comprobamos si el archivo ha subido
                    if(move_uploaded_file($_FILES['userfile']['tmp_name'][$i], "archivosAviso/".$_FILES['userfile']['name'][$i]))
                    {   
                    
                    $conn->query("INSERT INTO SGI_Simulacros_Avisos(xt_codigoSimulacro, xt_nombreAviso, xt_tipoAviso) VALUES ('".$simulacro."', '".$_FILES['userfile']['name'][$i]."', '".$tipo[$i]."')");
                        //aqui podemos procesar info de la bd referente a este archivo
                        echo'<script type="text/javascript">
                        alert("Se guardo correctamente!");
                            self.close();
                            window.opener.document.location.href = "../simulacro/verSimulacro.php#divDesarrollo";
                            window.opener.location.reload();
                        </script>';
                    }else{
                        echo'<script type="text/javascript">
                        alert("Ocurrió un error al intentar cargar el aviso, intente de nuevo mas tarde!");
                            self.close();
                            window.opener.document.location.href = "../simulacro/verSimulacro.php#divDesarrollo";
                            window.opener.location.reload();
                        </script>'; 
                    }

                    //si la extension no es una de las permitidas
                }else{
                    
                    echo'<script type="text/javascript">
                        alert("Solo se permiten documentos en formato PDF.");
                        self.close();
                        window.opener.document.location.href = "../simulacro/verSimulacro.php#divDesarrollo";
                        window.opener.location.reload();
                        </script>';
                }

            //si ese input file no ha sido cargado con un archivo
            }
            echo "<br />";
            //en cada pasada por el loop incrementamos i para acceder al siguiente archivo
            $i++;     
        }   
    }

    /**
    *funcion privada que devuelve true o false dependiendo de la extension
    *@access private
    *@param string 
    *@return boolean - si esta o no permitido el tipo de archivo
    */
    private function checkExtension($extension)
    {
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones = array("pdf");
        if(in_array(strtolower($extension), $extensiones))
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
    *funcion que comprueba si el archivo existe, si es asi, iteramos en un loop 
    *y conseguimos un nuevo nombre para el, finalmente lo retornamos
    *@access private
    *@param array 
    *@return array - archivo con el nuevo nombre
    */
    private function checkExists($file)
    {
        //asignamos de nuevo el nombre al archivo
        $archivo = $file[0] . '.' . end($file);
        $i = 0;
        //mientras el archivo exista entramos
        while(file_exists("archivosAviso/".$archivo))
        {
            $i++;
            $archivo = $file[0]."(".$i.")".".".end($file);       
        }
        //devolvemos el nuevo nombre de la imagen, si es que ha 
        //entrado alguna vez en el loop, en otro caso devolvemos el que
        //ya tenia
        return $archivo;
    }
}