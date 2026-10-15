<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio García
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'ProcesoPDF.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
require('../Librerias/fpdf/fpdf.php');

$idProceso 			= $_GET['idProceso'];

$codigo 			= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $idProceso ");

$nombreArchivoPDF	= "Proceso_".$codigo.".pdf";

$titulo 			= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $idProceso ");

class PDF extends FPDF{
	//Cabecera de Pagina
	function Header($codigo){
		//Tipo de Letra
		$this->SetFont('Arial','B',30);
		//Movernos a la derecha
		$this->Cell(450);
				//Titulo
		$this->Cell(1, 10, "Grupo Escalante Agencias Aduanales S.C.", 0, 0, 'C');
		$this->Line(10, 25, 890, 25);
		//salto de linea 
		$this->Ln(40);
	}
	// Pie de página
	function Footer(){
		// Posición: a 1,5 cm del final
		$this->SetY(-20);
		// Arial italic 8
		$this->SetFont('Arial', '' , 18);
		// Número de página
		$this->Line(10, 575, 890, 575);
		$this->Cell(1 , 10, utf8_decode("Página ".$this->PageNo()."/{nb}"), 0, 0, 'C');
	}
}	

//variables


//Creacion del Objeto
$pdf = new PDF('L','mm',array(900,600));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->ln(30);


$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(150, 20, '', 0, 0, 'C', false);
$pdf->Cell(150, 20, '', 0, 0, 'C', false);
$pdf->Cell(150, 20, '(2)Procesos de Apoyo', 1, 0, 'C', false);
$pdf->Cell(150, 20, '', 0, 0, 'C', false);
$pdf->Cell(150, 20, '', 0, 0, 'C', false);

$pdf->ln(20);


$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(150, 20, '(1) Procesos Antecesores', 1, 0, 'C', false);
$pdf->Cell(150, 20, '(4) Entradas', 1, 0, 'C', false);

$x = $pdf->GetX(); 
$y = $pdf->GetY(); 

$pdf->SetFont('Arial', 'B', 22);
$pdf->MultiCell(150, 10, 'Proceso: '.$titulo, 1, 'C', false);
$pdf->SetXY($x+150, $y); 

$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(150, 20, '(5) Salidas', 1, 0, 'C', false);
$pdf->Cell(150, 20, '(3) Procesos Sucesores', 1, 0, 'C', false);

$pdf->ln(20);


$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(150, 20, '', 0, 0, 'C', false);
$pdf->Cell(150, 20, '(6) Equipos/Insumos', 1, 0, 'C', false);
$pdf->Cell(150, 20, '(10) Riesgos', 1, 0, 'C', false);
$pdf->Cell(150, 20, '(11) Indicadores', 1, 0, 'C', false);
$pdf->Cell(150, 20, '', 0, 0, 'C', false);

$pdf->ln(20);


$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(150, 20, '', 0, 0, 'C', false);
$pdf->Cell(150, 20, '(7) Compliance', 1, 0, 'C', false);
$pdf->Cell(150, 20, '(8) Documentos', 1, 0, 'C', false);
$pdf->Cell(150, 20, '(9) Stakeholders (puestos y roles)', 1, 0, 'C', false);
$pdf->Cell(150, 20, '', 0, 0, 'C', false);

$pdf->ln(20);


/*
class PDF_MC_Table extends FPDF { 
	var $widths; 
	var $aligns;
	
	
	function SetWidths($w) { 
		//Set the array of column widths 
		$this->widths = $w; 
	} 
	
	function SetAligns($a) { 
		//Set the array of column alignments 
		$this->aligns = $a; 
	} 
	
	function fill($f){
		//juego de arreglos de relleno
		$this->fill = $f;
	}
	
	function Row($data) { 
		//Calculate the height of the row 
		$nb = 0; 
		for($i = 0; $i < count($data); $i++){
			
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		}
		
		$h = 5*$nb; 
		//Issue a page break first if needed 
		$this->CheckPageBreak($h); 
		//Draw the cells of the row 
		for($i = 0; $i < count($data); $i++){ 
			$w = $this->widths[$i]; 
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
			//Save the current position 
			$x = $this->GetX(); 
			$y = $this->GetY(); 
			//Draw the border 
			//$this->Rect($x, $y, $w, $h, $style); 
			//Print the text 
			$this->MultiCell($w, 18, $data[$i], 'C', $a, $fill); 
			//Put the position to the right of the cell 
			$this->SetXY($x+$w, $y); 
		} 
		//Go to the next line 
		$this->Ln($h); 
	} 
	
	function CheckPageBreak($h) { 
		//If the height h would cause an overflow, add a new page immediately 
		if($this->GetY()+$h>$this->PageBreakTrigger){
			
			$this->AddPage($this->CurOrientation);
			
		}
	} 
	
	function NbLines($w, $txt) { 
		//Computes the number of lines a MultiCell of width w will take 
		$cw =& $this->CurrentFont['cw'];
		
		if($w == 0){
			$w = $this->w-$this->rMargin-$this->x;
		}
		
		$wmax 	= ($w-2*$this->cMargin)*1000/$this->FontSize;
		
		$s 		= str_replace("\r", '', $txt); 
		
		$nb 	= strlen($s); 
		
		if($nb>0 and $s[$nb-1]=="\n"){
		
			$nb--;
		
		}
		
		$sep	= -1; 
		$i		= 0; 
		$j		= 0; 
		$l		= 0; 
		$nl		= 1;
		
		while($i < $nb){
			
			$c = $s[$i]; 
			
			if($c == "\n"){ 
				$i++;
				 
				$sep =- 1; 
				
				$j = $i;
				
				$l = 0; 
				
				$nl++; 
				
				continue; 
			}
			
			if($c == ' '){
				
				$sep = $i;
				
			}
			
			$l += $cw[$c];
			
			if($l > $wmax){
				
				if($sep == -1){
					
					if($i == $j){
						
						$i++;
						
					}
				} else{
					
					$i = $sep+1; 
				
				}
				
				$sep = -1; 
				
				$j = $i; 
				
				$l = 0; 
				
				$nl++; 
			
			} else{
				
				$i++;
			
			}
		}
		
		return $nl; 
	} 
} 

*/

$pdf->Output($nombreArchivoPDF,D);

?>