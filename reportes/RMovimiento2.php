<?php
// Extend the TCPDF class to create custom MultiRow
/*
 * Autor RAC
 * Fecha: 16/03/2017
 * 
 * */
class RMovimiento2 extends  ReportePDF {
	var $dataMaster;
	var $datos_detalle;
	var $ancho_hoja;
	var $gerencia;
	var $numeracion;
	var $ancho_sin_totales;
	var $tipoMov;	
	
	function getDataSource(){
		return  $this->datos_detalle;		
	}
	
	
	function datosHeader  ( $maestro, $detalle ) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		$this->datos_detalle = $detalle;
		$this->dataMaster = $maestro;	
		$this->tipoMov = $this->dataMaster[0]['cod_movimiento']; 
		
		if($this->tipoMov=='asig'||$tipo=='devol'){
			$this->SetMargins(7, 55, 5);
        } 
        else if ($this->tipoMov=='deprec'){
        	$this->SetMargins(7, 53, 5);
         }
		else{
			$this->SetMargins(7, 52, 5);
		}	
		
		
		
	}
	
	function Header() {
		
		
		
		$height = 6;
        $midHeight = 9;
        $longHeight = 18;

        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetXY($x, $y);
       
		//$this->Image(dirname(__FILE__).'/../../lib/'.$_SESSION['_DIR_LOGO'], 10,5,35,20);
		$this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 10,5,35,20);

        $this->SetFontSize(12);
        $this->SetFont('', 'B');
        $this->Cell(44, $midHeight, '', 'LRT', 0, 'C', false, '', 0, false, 'T', 'C');
       
        $this->Cell(168, $midHeight, 'FORMULARIO DE '.strtoupper($this->dataMaster[0]['movimiento']).' DE ACTIVOS FIJOS', 'LRT', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->tipoMov = $this->dataMaster[0]['cod_movimiento']; 

        $x = $this->GetX();
        $y = $this->GetY();
        $this->Ln();
        $this->SetFontSize(10);
        $this->SetFont('', 'B');
        $this->Cell(44, $midHeight, '', 'LRB', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(168, $midHeight, strtoupper($this->dataMaster[0]['depto']), 'LRB', 0, 'C', false, '', 0, false, 'T', 'C');

        $this->SetFontSize(7);

        $width1 = 15;
        $width2 = 25;
        $this->SetXY($x, $y);

        $this->SetFont('', '');
        $this->Cell(44, $longHeight, '', 1, 0, 'C', false, '', 0, false, 'T', 'C');

        $this->SetXY($x, $y);
        $this->setCellPaddings(2);
        $this->Cell($width1-4, $height, 'FORM:', "B", 0, '', false, '', 0, false, 'T', 'C');
        $this->SetFont('', 'B');
        $this->Cell($width2+8, $height,$this->dataMaster[0]['formulario'], "B", 0, 'L', false, '', 0, false, 'T', 'C');
        $this->setCellPaddings(2);
        $this->Ln();
        $this->SetX($x);
        $this->SetFont('', '');
        $this->Cell($width1-4, $height, 'FECHA:', "B", 0, '', false, '', 0, false, 'T', 'C');
        $this->SetFont('', 'B');
        $this->Cell($width2+8, $height,$this->dataMaster[0]['fecha_mov'], "B", 0, 'L', false, '', 0, false, 'T', 'C');
        $this->setCellPaddings(2);
        $this->Ln();
        $this->SetX($x);
        $this->SetFont('', '');
        $this->Cell($width1-4, $height, 'PAGINA:', "B", 0, '', false, '', 0, false, 'T', 'C');
        $this->SetFont('', 'B');
        $this->Cell($w = $width2, $h = $height, $txt = $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), $border = "B", $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $this->setCellPaddings(2);
		
		
		
		//$this->Ln();
		$this->fieldsHeader($this->tipoMov);
		$this->generarCabecera($this->tipoMov);
		
	}

    public function fieldsHeader($tipo){
       
            $this->SetFontSize(10);
            if($tipo=='asig'||$tipo=='devol'){
                $this->Ln();
                $this->SetFont('', 'B');
                $this->Cell(35, $height,'Responsable:', "", 0, 'L', false, '', 0, false, 'T', 'C');
                $this->SetFont('', '');
                $this->Cell($w = 100,$h = $hGlobal, $txt = $this->dataMaster[0]['responsable'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $this->SetFont('', 'B');
                $this->Cell(25, $height,'Custodio:', "", 0, 'L', false, '', 0, false, 'T', 'C');
                $this->SetFont('', '');
                $this->Cell($w = 100,$h = $hGlobal, $txt = $this->dataMaster[0]['custodio'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $this->Ln();
                $this->SetFont('', 'B');
                $this->Cell(35, $height,'Oficina:', "", 0, 'L', false, '', 0, false, 'T', 'C');
                $this->SetFont('', '');
                $this->Cell($w = 100,$h = $hGlobal, $txt = $this->dataMaster[0]['oficina'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $this->SetFont('', 'B');
                $this->Cell(25, $height,'Direccion:', "", 0, 'L', false, '', 0, false, 'T', 'C');
                $this->SetFont('', '');
                $this->Cell($w = 100,$h = $hGlobal, $txt = $this->dataMaster[0]['direccion'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            } else if ($tipo=='deprec'){
                $this->Ln();
                $this->SetFont('', 'B');
                $this->Cell(35, $height,'Depreciacion hasta:', "", 0, 'L', false, '', 0, false, 'T', 'C');
                $this->SetFont('', '');
                $this->Cell($w = 100,$h = $hGlobal, $txt = $this->dataMaster[0]['fecha_hasta'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            }

            //Estado
            $this->Ln();
            $this->SetFont('', 'B');
            $this->Cell($width2+18, $height,'Estado:', "", 0, 'L', false, '', 0, false, 'T', 'C');
            //$this->Ln();
            $this->SetFont('', '');
            $this->MultiCell($w = 0, $h = $hLong, $txt = $this->dataMaster[0]['estado'], $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = $hMedium, $valign = 'M', $fitcell = false);

            //Glosa
            //$this->Ln();
            $this->SetFont('', 'B');
            $this->Cell($width2+8, $height,'Glosa:', "", 0, 'L', false, '', 0, false, 'T', 'C');
            $this->Ln();
            $this->SetFont('', '');
            $this->MultiCell($w = 0, $h = $hLong, $txt = $this->dataMaster[0]['glosa'], $border = 0, $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = $hMedium, $valign = 'M', $fitcell = false);
            $this->firstPage++;
           $this->Ln();   
       
    }




	function Firmas() {
		 $this->SetFontSize(8);
        
        $_firma100='';
        $_firma110=$this->dataMaster[0]['responsable_depto'];
        $_firma111='RESPONSABLE ACTIVOS FIJOS';
        
        $_firma200='';
        $_firma210='';
        $_firma211='';

        $_firma300='';
        $_firma310='';
        $_firma311='';

        $_firma400='';
        $_firma410='';
        $_firma411='';

        if($this->tipoMov=='asig'){
            $_firma100=$this->dataMaster[0]['responsable_depto'];
            $_firma110='RESPONSABLE ACTIVOS FIJOS';
            $_firma111='ENTREGUÉ CONFORME';
            
            $_firma200=strtoupper($this->dataMaster[0]['responsable']);
            $_firma210=strtoupper($this->dataMaster[0]['nombre_cargo']);
            $_firma211='RECIBÍ CONFORME';

            if($this->dataMaster[0]['custodio']!=''){
                $_firma300=strtoupper($this->dataMaster[0]['custodio']);
                $_firma310='CI. '.strtoupper($this->dataMaster[0]['ci_custodio']);
                $_firma311='CUSTODIO';    
            }

        }
		
		
		 if($this->tipoMov=='transf'){
            $_firma100=$this->dataMaster[0]['responsable_depto'];
            $_firma110='RESPONSABLE ACTIVOS FIJOS';
            $_firma111='SUPERVISOR';
            
            $_firma200=strtoupper($this->dataMaster[0]['responsable']);
            $_firma210=strtoupper($this->dataMaster[0]['nombre_cargo']);
            $_firma211='ENTREGUE CONFORME';
            
            $_firma300=strtoupper($this->dataMaster[0]['responsable_dest']);
            $_firma310=strtoupper($this->dataMaster[0]['nombre_cargo_dest']);
            $_firma311='RECIBÍ CONFORME';  
        }


        $this->Cell(63, $midHeight, '', 'LRT', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LRT', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LRT', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LRT', 1, 'C', false, '', 0, false, 'T', 'C');
         
        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 1, 'C', false, '', 0, false, 'T', 'C');
        
        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 1, 'C', false, '', 0, false, 'T', 'C');

        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, '', 'LR', 1, 'C', false, '', 0, false, 'T', 'C');

        $this->Cell(63, $midHeight, $_firma100, 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma200, 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma300, 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma400, 'LR', 1, 'C', false, '', 0, false, 'T', 'C');

        $this->Cell(63, $midHeight, $_firma110, 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma210, 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma310, 'LR', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma410, 'LR', 1, 'C', false, '', 0, false, 'T', 'C');
        
        $this->Cell(63, $midHeight, $_firma111, 'LRBT', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma211, 'LRBT', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma311, 'LRBT', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(63, $midHeight, $_firma411, 'LRBT', 1, 'C', false, '', 0, false, 'T', 'C');
		
		
	}
   
   function generarReporte() {
   	      $this->setFontSubsetting(false);
		  $this->AddPage();
		  $tipo = $this->tipoMov;
		  
		  $this->SetFontSize(7);
      
		  		
		 foreach ($this->getDataSource() as $datarow) {
            if($tipo=='baja'){
               
			  $this->tablealigns=array('L','L','L','L','L','L','L');
		      $this->tablenumbers=array(0,0,0,0,0,0,0);
		      $this->tableborders=array('RLTB','RLTB','RLTB','RLTB','RLTB','RLTB','RLTB');
	          $this->tabletextcolor=array();
			  $RowArray = array(
	            			's0'  => $i+1,
	            			's1' => $datarow['codigo'],   
	                        's2' => $datarow['descripcion'],        
	                        's3' => $datarow['marca'],
	                        's4' => $datarow['nro_serie'],            
	                        's5' => $datarow['estado_fun'],
	                        's6' => $datarow['motivo']);
				
				
            } else if($tipo=='reval'){
               
				
				$this->tablealigns=array('L','L','L','L','L','L','R','R','L');
		        $this->tablenumbers=array(0,0,0,0,0,0,1,1);
		        $this->tableborders=array('RLTB','RLTB','RLTB','RLTB','RLTB','RLTB','RLTB');
	            $this->tabletextcolor=array();
				
				$RowArray = array(
	            			's0'  => $i+1,
	            			's1' => $datarow['codigo'],   
	                        's2' => $datarow['descripcion'],       
	                        's4' => $datarow['marca'],
	                        's5' => $datarow['nro_serie'],
	                        's6' => $datarow['estado_fun'] ,  
	                        's7' => $datarow['vida_util'] , 
	                        's8' => $datarow['importe'] 
	                        );
				

            } else if($tipo=='deprec'){
               
				
				$this->tablealigns=array('L','L','L','L','L','L','L');
		        $this->tablenumbers=array(0,0,0,0,0,0,0);
		        $this->tableborders=array('RLTB','RLTB','RLTB','RLTB','RLTB','RLTB','RLTB');
	            $this->tabletextcolor=array();
				
				$RowArray = array(
	            			's0'  => $i+1,
	            			's1' => $datarow['codigo'],   
	                        's2' => $datarow['descripcion'],       
	                        's4' => $datarow['marca'],
	                        's5' => $datarow['nro_serie'],
	                        's6' => $datarow['estado_fun'] ,  
	                        's7' => $datarow['monto_compra'] , 
	                        's8' => $datarow['importe']  
	                        );
				

            } else if($tipo=='asig'||$tipo=='devol'){
                	
               				
				$this->tablealigns=array('L','L','L','L','L','L','L');
		        $this->tablenumbers=array(0,0,0,0,0,0,0);
		        $this->tableborders=array('RLTB','RLTB','RLTB','RLTB','RLTB','RLTB','RLTB');
	            $this->tabletextcolor=array();
				
				$RowArray = array(
	            			's0'  => $i+1,
	            			's1' => $datarow['codigo'],   
	                        's2' => $datarow['descripcion'],       
	                        's4' => $datarow['marca'],
	                        's5' => $datarow['nro_serie'],
	                        's6' => $datarow['estado_fun'] ,           
	                        's7' => ''
	                        );
				
				
            } else {
                //Alta      
				
			  $this->tablealigns=array('L','L','L','L','L','L','L');
		      $this->tablenumbers=array(0,0,0,0,0,0,0);
		      $this->tableborders=array('RLTB','RLTB','RLTB','RLTB','RLTB','RLTB','RLTB');
	          $this->tabletextcolor=array();
			  $RowArray = array(
	            			's0'  => $i+1,
	            			's1' => $datarow['codigo'],   
	                        's2' => $datarow['descripcion'],   
	                        's3' => $datarow['tipo_activo'],       
	                        's4' => $datarow['marca'],
	                        's5' => $datarow['nro_serie'],
	                        's6' => $datarow['fecha_compra'] ,           
	                        's7' => $datarow['estado_fun']
	                        );
				
				
            }
            $i++;
			
			$this-> MultiRow($RowArray,false,1);
			$this->revisarfinPagina();
			
        }
		
		$this->Ln(3);	
		
		$this->Firmas();
		
   } 
   
   function generarCabecera($tipo){
    	
		//armca caecera de la tabla
		$this->SetFontSize(9);
        $this->SetFont('', 'B');				
		///////////////////////////////////////
		if($tipo=='baja'){
            
	          $this->tablewidthsHD=array(10,35,100,70,50,20,20);			  
	          $this->tablealignsHD=array('C','C','C','C','C','C','C');
		      $this->tablenumbersHD=array(0,0,0,0,0,0,0);
		      $this->tablebordersHD=array('TB','TB','TB','TB','TB','TB','TB');
	          $this->tabletextcolorHD=array();
			  $RowArray = array(
	            			's0'  => 'Nro',
	            			's1' => 'Código',   
	                        's2' => 'Descripcion',        
	                        's3' => 'Marca',
	                        's4' => 'Nro. Serie',            
	                        's5' => 'Estado Fun.',
	                        's6' => 'Motivo');
			

        } else if($tipo=='reval'){
        	
			  $this->tablewidthsHD=array(8,35,90,35,25,20,20,20);
	          $this->tablealignsHD=array('C','C','C','C','C','C','C');
		      $this->tablenumbersHD=array(0,0,0,0,0,0,0,0);
		      $this->tablebordersHD=array('TB','TB','TB','TB','TB','TB','TB','TB');
	          $this->tabletextcolorHD=array();
			  $RowArray = array(
	            			's0'  => 'Nro',
	            			's1' => 'Código',   
	                        's2' => 'Descripcion',        
	                        's3' => 'Marca',
	                        's4' => 'Nro. Serie',            
	                        's5' => 'Estado Fun.',
	                        's6' => 'Inc.Vida Util',
	                        's7' => 'Inc.Valor')  ;

        } else if($tipo=='deprec'){
        	
			  $this->tablewidthsHD=array(8,35,90,35,25,20,20,20);
	          $this->tablealignsHD=array('C','C','C','C','C','C','C');
		      $this->tablenumbersHD=array(0,0,0,0,0,0,0,0);
		      $this->tablebordersHD=array('TB','TB','TB','TB','TB','TB','TB','TB');
	          $this->tabletextcolorHD=array();
			  $RowArray = array(
	            			's0'  => 'Nro',
	            			's1' => 'Código',   
	                        's2' => 'Descripcion',        
	                        's3' => 'Marca',
	                        's4' => 'Nro. Serie',            
	                        's5' => 'Estado Fun.',
	                        's6' => 'Imp. Compral',
	                        's7' => 'Imp. Vigente');
				
        } else if($tipo=='asig'||$tipo=='devol'){
            	
              $this->tablewidthsHD=array(8,35,75,32,26,20,60);
			   //$this->tablewidths=array(8,31,84.5,34,32.5,26.5,18,20.5);
	          $this->tablealignsHD=array('C','C','C','C','C','C','C','C');
		      $this->tablenumbersHD=array(0,0,0,0,0,0,0,0);
		      $this->tablebordersHD=array('TB','TB','TB','TB','TB','TB','TB','TB');
	          $this->tabletextcolorHD=array();
			  $RowArray = array(
	            			's0'  => 'Nro',
	            			's1' => 'Código',   
	                        's2' => 'Descripcion',        
	                        's3' => 'Marca',
	                        's4' => 'Nro. Serie',            
	                        's5' => 'Estado Fun.',           
	                        's8' => 'Observaciones');
			
			
            
        } else {
            //Alta, transf
            
            $this->tablewidthsHD=array(8,31,84.5,34,32.5,26.5,18,20.5);
            $this->tablealignsHD=array('C','C','C','C','C','C','C','C');
	        $this->tablenumbersHD=array(0,0,0,0,0,0,0,0);
	        $this->tablebordersHD=array('TB','TB','TB','TB','TB','TB','TB','TB');
            $this->tabletextcolorHD=array();
		    
		    $RowArray = array(
            			's0'  => 'Nro',
            			's1' => 'Código',   
                        's2' => 'Descripcion',        
                        's3' => 'Tipo de Activo',
                        's4' => 'Marca',            
                        's5' => 'Nro. Serie',
                        's6' => 'Fecha Compra',
                        's7' => 'Estado Fun.');

            $this->Ln();    
        }
		
		/////////////////////////////////	                         
        $this-> MultiRowHeader($RowArray,false,1);
		$this->tablewidths = $this->tablewidthsHD;
		
		
    }

   function revisarfinPagina(){
		$dimensions = $this->getPageDimensions();
		$hasBorder = false; //flag for fringe case
		
		$startY = $this->GetY();
		$this->getNumLines($row['cell1data'], 80);
		
		if (($startY + 4 * 3) + $dimensions['bm'] > ($dimensions['hk'])) {
		    if($this->total!= 0){
				$this->AddPage();
			}
		} 
	}
   
  
   
   
 
}
?>