<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils
{ 

	public function traduceMeses($fecha) 
	{
		$meses = array("Enero", "Febrero", "Marzo","Abri","Mayo","Junio","Julio","Agosto","Septiembre","Octubre",
					   "Noviembre","Diciembre");
		$months = array("January","February","March","April","May","June","July","August","September","October",
		                "November","December");
		
		$fechaTraducida = str_replace($months,$meses,$fecha);
		$fechaTraducida = str_replace("-"," de ", $fechaTraducida);		
	
		return $fechaTraducida;
	}
	 public function sennisEmptySL($param) 
	{
		if ( empty($param) || $param == "" )
                    { return 0;      }
                else
                    { return $param; }                    
	}
        
        public function senniEmptyInteger($param) 
	{
		if ( empty($param) || $param == "" || $param =='undefined' )
                    { return 0;      }
                else
                    { return $param; }                    
	}  
          
	public function senniDateFormat($paramDate) 
	{
		if ( empty($paramDate) )
                    { return NULL; }
                else
                    {   $paramDateStr = DateTime::createFromFormat('j#n#Y', $paramDate);
                        return $paramDateStr ->format('Y/m/d');                         
                    }                    
	}

	public function dateExpFactura($paramDate) 
	{
	
		if ( empty($paramDate) )
			{ return NULL; }                    
		else
			{                         
				return str_replace("/", "-", $paramDate);
			}  		
	} 
	

	public function arrayDateFormat($paramDate) 
	{
		if ( empty($paramDate) )
			{ return array();  }
		else
			{   $paramDateStr = DateTime::createFromFormat('j#n#Y', $paramDate);				
				return array("year"=>$paramDateStr ->format('Y'),"month"=>$paramDateStr ->format('m'),"day"=>$paramDateStr ->format('j'));
			}                    
	}



	public function generaNombrePDF($fileName) 
	{
		$newCaracter = array("n", "N", "a","e","i","o","u","A","E","I","O","U");
		$oldCaracter = array("ñ","Ñ","á","é","í","ó","ú","Á","É","Í","Ó","Ú");
		
		$sinAcentos = str_replace($oldCaracter,$newCaracter,$fileName);
		$sinAcentos = str_replace(" ","_", $sinAcentos);
                $sinAcentos = str_replace(")","_", $sinAcentos);
                $sinAcentos = str_replace("(","_", $sinAcentos);
                $sinAcentos = str_replace("&","_", $sinAcentos);
                $sinAcentos = str_replace("%","_", $sinAcentos);
                $sinAcentos = str_replace("|","_", $sinAcentos);
                $sinAcentos = str_replace("°","_", $sinAcentos);
                $sinAcentos = str_replace("!","_", $sinAcentos);
                $sinAcentos = str_replace("@","_", $sinAcentos);
                $sinAcentos = str_replace("#","_", $sinAcentos);
                $sinAcentos = str_replace("$","_", $sinAcentos);
                $sinAcentos = str_replace("/","_", $sinAcentos);
                $sinAcentos = str_replace("\\","_", $sinAcentos);
                $sinAcentos = str_replace("^","_", $sinAcentos);
                $sinAcentos = str_replace("*","_", $sinAcentos);                
                $sinAcentos = str_replace("?","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("]","_", $sinAcentos);
                $sinAcentos = str_replace("{","_", $sinAcentos);
                $sinAcentos = str_replace("}","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("'","", $sinAcentos);
                $sinAcentos = str_replace("\"","", $sinAcentos);                
                $sinAcentos = str_replace(",","", $sinAcentos);                
                $sinAcentos = str_replace(":","", $sinAcentos);                
                $sinAcentos = str_replace(";","", $sinAcentos);                
		
		if (strlen($sinAcentos) > 10 )
			$sinAcentos = substr($sinAcentos, 0, 10);
			
		return $sinAcentos;
	}
        
        public function generaNombrePlantilla($fileName) 
	{
		$newCaracter = array("n", "N", "a","e","i","o","u","A","E","I","O","U");
		$oldCaracter = array("ñ","Ñ","á","é","í","ó","ú","Á","É","Í","Ó","Ú");
		
		$sinAcentos = str_replace($oldCaracter,$newCaracter,$fileName);
		$sinAcentos = str_replace(" ","_", $sinAcentos);
                $sinAcentos = str_replace(")","_", $sinAcentos);
                $sinAcentos = str_replace("(","_", $sinAcentos);
                $sinAcentos = str_replace("&","_", $sinAcentos);
                $sinAcentos = str_replace("%","_", $sinAcentos);
                $sinAcentos = str_replace("|","_", $sinAcentos);
                $sinAcentos = str_replace("°","_", $sinAcentos);
                $sinAcentos = str_replace("!","_", $sinAcentos);
                $sinAcentos = str_replace("@","_", $sinAcentos);
                $sinAcentos = str_replace("#","_", $sinAcentos);
                $sinAcentos = str_replace("$","_", $sinAcentos);
                $sinAcentos = str_replace("/","_", $sinAcentos);
                $sinAcentos = str_replace("\\","_", $sinAcentos);
                $sinAcentos = str_replace("^","_", $sinAcentos);
                $sinAcentos = str_replace("*","_", $sinAcentos);                
                $sinAcentos = str_replace("?","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("]","_", $sinAcentos);
                $sinAcentos = str_replace("{","_", $sinAcentos);
                $sinAcentos = str_replace("}","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("'","", $sinAcentos);
                $sinAcentos = str_replace("\"","", $sinAcentos);                				
			
		return $sinAcentos;
	}
	
        public function generaNombreImagen($fileName) 
	{
		$newCaracter = array("n", "N", "a","e","i","o","u","A","E","I","O","U");
		$oldCaracter = array("ñ","Ñ","á","é","í","ó","ú","Á","É","Í","Ó","Ú");
		
		$sinAcentos = str_replace($oldCaracter,$newCaracter,$fileName);
		$sinAcentos = str_replace(" ","_", $sinAcentos);
                $sinAcentos = str_replace(")","_", $sinAcentos);
                $sinAcentos = str_replace("(","_", $sinAcentos);
                $sinAcentos = str_replace("&","_", $sinAcentos);
                $sinAcentos = str_replace("%","_", $sinAcentos);
                $sinAcentos = str_replace("|","_", $sinAcentos);
                $sinAcentos = str_replace("°","_", $sinAcentos);
                $sinAcentos = str_replace("!","_", $sinAcentos);
                $sinAcentos = str_replace("@","_", $sinAcentos);
                $sinAcentos = str_replace("#","_", $sinAcentos);
                $sinAcentos = str_replace("$","_", $sinAcentos);
                $sinAcentos = str_replace("/","_", $sinAcentos);
                $sinAcentos = str_replace("\\","_", $sinAcentos);
                $sinAcentos = str_replace("^","_", $sinAcentos);
                $sinAcentos = str_replace("*","_", $sinAcentos);                
                $sinAcentos = str_replace("?","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("]","_", $sinAcentos);
                $sinAcentos = str_replace("{","_", $sinAcentos);
                $sinAcentos = str_replace("}","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("'","", $sinAcentos);
                $sinAcentos = str_replace("\"","", $sinAcentos);                

		return $sinAcentos;
	}
        
	public function pdf_create($html, $filename='', $stream=TRUE) 
	{						
		$dompdf = new DOMPDF();
                
   		$dompdf->load_html($html);
                
                $dompdf->render();
		
		if ($stream) 
                { return $dompdf->stream($filename.".pdf"); } 
		else 
                { return $dompdf->output(); }         
	}

 	 			
	public function creaPrefacturaWord($encabezado,$productos,$cliente,$datosSL,$cuentasSL)
	{
		
		$dir 		 = "adjuntos/prefactura/";
		$dirTemplate = "adjuntos/prefactura/template/";
		
		$now 	   = new DateTime();
		$fechaPF   = $now->format('d-F-Y');
		
		$rs    	   = $this->revisaValorVacio($cliente[0]['razon_social']);
		$rfc	   = $this->revisaValorVacio($cliente[0]['rfc']);
		$calle 	   = $this->revisaValorVacio($cliente[0]['calle']);
		$num   	   = $this->revisaValorVacio($cliente[0]['numero']);
		$cp    	   = $this->revisaValorVacio($cliente[0]['cp']);
		$col   	   = $this->revisaValorVacio($cliente[0]['colonia']);
		$del   	   = $this->revisaValorVacio($cliente[0]['delegacion']);
		$edo   	   = $this->revisaValorVacio($cliente[0]['estado']);
		$pais  	   = $this->revisaValorVacio($cliente[0]['pais']);
		$vv    	   = $this->revisaValorVacio($encabezado[0]['vessel_voyage']);
		$etd       = $this->revisaValorVacio($encabezado[0]['etd']);
		$pol       = $this->revisaValorVacio($encabezado[0]['pol']);
		$pod       = $this->revisaValorVacio($encabezado[0]['pod']);
		$mbl       = $this->revisaValorVacio($encabezado[0]['mbl']);
		$hbl       = $this->revisaValorVacio($encabezado[0]['hbl']);
		$id_pedido = $this->revisaValorVacio($encabezado[0]['id_pedido']);
		
		// New Word Document
		$PHPWord = new PHPWord();
	
		$section = $PHPWord->createSection();
	
		//HEADer
		$header = $section->createHeader();
		
		$PHPWord->addParagraphStyle('pCenter', array('align'=>'center'));
		$PHPWord->addParagraphStyle('pRight', array('align'=>'right'));
		$PHPWord->addParagraphStyle('pLeft', array('align'=>'left'));
		$tableH = $header->addTable();
		$tableH->addRow();
		$tableH->addCell(4500)->addImage(
										'images/logo.png',
										array(
											'width' => 80,
											'height' => 80,
											'marginTop' => -1,
											'marginLeft' => -1,
											'align'=>'left'
										)
									);
		$tableH->addCell(4500)->addImage(
										'images/lg.png',
										array(
											'width' => 208,
											'height' => 84,
											'marginTop' => -1,
											'marginLeft' => -1,
											'align'=>'right'
										)
									);
		$tableH->addRow();					
		$tableH->addCell(90000)->addText(utf8_decode('Servicios Integrales Especializados en Logística')
										 ,array('name' => 'Times New Roman','size' => 10, 'bold' => true,
										'italic'=>true,'gridSpan'=>2),
										'pCenter'
										);
	// Add footer
		$footer = $section->createFooter();
		$footer->addPreserveText(utf8_decode('Página {PAGE} de {NUMPAGES}.')
								, 'pCenter');
		$footer->addTextBreak(1);
		$footer->addText(utf8_decode('Respeto - Honestidad - Compromiso - Profesionalismo - Innovación - Actitud de Servicio'),$fontStyleT,'pCenter');
	
		$fontStyleT = array('name'=>'Calibri','size'=>18,'bold'=>true,'italic'=>true,
							'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE);
		$fontStyleCal = array('name'=>'Calibri','size'=>11);	
		$fontStyleCalNeg = array('name'=>'Calibri','size'=>11,'bold'=>true);	
		$styleCell = array('valign'=>'center');																														
	//		$linestyle = array('weight' => 1,'width' => 100,'height' => 0,'color' => 635552);
	//		$section->addLine($lineStyle);
		$section->addTextBreak(2);
		$section->addText( 'PRE-FACTURA',$fontStyleT,'pCenter');
		$section->addTextBreak(2);
	//		$section->addLine($lineStyle);
		$section->addText(utf8_decode('México DF a ').$this->traduceMeses($fechaPF),$fontStyleCal,'pRight');
		$section->addTextBreak(1);
		$section->addText(utf8_decode('DATOS DE FACTURACIÓN DEL CLIENTE'),$fontStyleCal,'pCenter');
		$section->addTextBreak(1);
		
		$tableRFC = $section->addTable();
		$tableRFC->addRow();
		$tableRFC->addCell(4000,$styleCell)->addText($rs, $fontStyleCal,'pLeft');
		$tableRFC->addRow();
		$tableRFC->addCell(2000,$styleCell)->addText('RFC '.$rfc, $fontStyleCal,'pLeft');
		$tableRFC->addRow();
		$tableRFC->addCell(6000,$styleCell)->addText(utf8_decode($calle).' #'.$num.', col. '.utf8_decode($col).', CP '.$cp, $fontStyleDer,'pLeft');
		$tableRFC->addRow();
		$tableRFC->addCell(6000,$styleCell)->addText(utf8_decode('Delegación '.$del), $fontStyleCal,'pLeft');
		$tableRFC->addRow();
		$tableRFC->addCell(6000,$styleCell)->addText(utf8_decode($pais.' '.$edo), $fontStyleCal,'pLeft');
		
		$section->addTextBreak(1);
		$tablePD = $section->addTable();
		$tablePD->addRow();
		$tablePD->addCell(2000,$styleCell)->addText('Vol/Vyg: ', $fontStyleCalNeg,'pRight');
		$tablePD->addCell(2000,$styleCell)->addText(utf8_decode($vv), $fontStyleCal,'pLeft');
		$tablePD->addCell(2000,$styleCell)->addText('ETD: ', $fontStyleCalNeg,'pRight');
		$tablePD->addCell(2000,$styleCell)->addText($etd, $fontStyleCal,'pLeft');
		$tablePD->addRow();
		$tablePD->addCell(2000,$styleCell)->addText('P.O.L: ', $fontStyleCalNeg,'pRight');
		$tablePD->addCell(2000,$styleCell)->addText(utf8_decode($pol), $fontStyleCal,'pLeft');
		$tablePD->addCell(2000,$styleCell)->addText('P.O.D: ', $fontStyleCalNeg,'pRight');
		$tablePD->addCell(2000,$styleCell)->addText(utf8_decode($pod), $fontStyleCal,'pLeft');
		$tablePD->addRow();
		$tablePD->addCell(2000,$styleCell)->addText('CNTR NO: ', $fontStyleCalNeg,'pRight');
		$tablePD->addCell(2000,$styleCell)->addText(utf8_decode($hbl), $fontStyleCal,'pLeft');
		$tablePD->addCell(2000,$styleCell)->addText('MBL: ', $fontStyleCalNeg,'pRight');
		$tablePD->addCell(2000,$styleCell)->addText(utf8_decode($mbl), $fontStyleCal,'pLeft');		
	
		$section->addTextBreak(1);
		$tablePROD = $section->addTable();
		$tablePROD->addRow();
		$tablePROD->addCell(2000,$styleCell)->addText(utf8_decode('Descripción: '), $fontStyleCalNeg,'pCenter');
		$tablePROD->addCell(2000,$styleCell)->addText('Peso', $fontStyleCalNeg,'pCenter');
		$tablePROD->addCell(2000,$styleCell)->addText('Volumen: ', $fontStyleCalNeg,'pCenter');
		
		foreach($productos as $p)
		{
			$tablePROD->addRow();
			$tablePROD->addCell(2000,$styleCell)->addText(utf8_decode($p['nombre']), $fontStyleCal,'pCenter');
			$tablePROD->addCell(2000,$styleCell)->addText(utf8_decode($p['peso']), $fontStyleCal,'pCenter');
			$tablePROD->addCell(2000,$styleCell)->addText(utf8_decode($p['volumen']), $fontStyleCal,'pCenter');
		}
	
		$section->addPageBreak();
	
		$tableSL = $section->addTable();
		$tableSL->addRow();
		$tableSL->addCell(2000,$styleCell)->addText('Nombre: ', $fontStyleCalNeg,'pRight');
		$tableSL->addCell(4000,$styleCell)->addText(utf8_decode($datosSL[0]['nombre_fiscal']), $fontStyleCalNeg,'pLeft');
		$tableSL->addRow();
		$tableSL->addCell(2000,$styleCell)->addText('Domicilio: ', $fontStyleCalNeg,'pRight');
		$tableSL->addCell(4000,$styleCell)->addText(utf8_decode($datosSL[0]['domicilio_fiscal']), $fontStyleCal,'pLeft');
		$tableSL->addRow();
		$tableSL->addCell(2000,$styleCell)->addText('RFC: ', $fontStyleCalNeg,'pRight');
		$tableSL->addCell(4000,$styleCell)->addText($datosSL[0]['rfc'], $fontStyleCal,'pLeft');
		$tableSL->addRow();
		$tableSL->addCell(2000,$styleCell)->addText('Banco para realizar deposito: ', $fontStyleCalNeg,'pRight');
		$tableSL->addCell(4000,$styleCell)->addText(utf8_decode($cuentasSL[0]['banco']), $fontStyleCal,'pLeft');
		$tableSL->addRow();
		$tableSL->addCell(2000,$styleCell)->addText(utf8_decode('Número de cuenta: '), $fontStyleCalNeg,'pRight');
		$tableSL->addCell(4000,$styleCell)->addText(utf8_decode($cuentasSL[0]['cuenta']), $fontStyleCal,'pLeft');
		$tableSL->addRow();
		$tableSL->addCell(2000,$styleCell)->addText('CLABE: ', $fontStyleCalNeg,'pRight');
		$tableSL->addCell(4000,$styleCell)->addText(utf8_decode($cuentasSL[0]['clabe']), $fontStyleCal,'pLeft');						
		
		// Save File
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$preFactura = $dir.'preFactura_'.$id_pedido.'.docx';
		$objWriter->save($preFactura);
			
		return $preFactura;		
	}
	
	public function creaPrefacturaWordTemplate($encabezado,$productos,$cliente,$datosSL,$cuentasSL)
	{		
		$dir 		 = "adjuntos/prefactura/";
		$dirTemplate = "adjuntos/prefactura/template/";
		
		$now 	   = new DateTime();
		$fechaPF   = $now->format('d-F-Y');
		
		$rs    	   = $this->revisaValorVacio($cliente[0]['razon_social']);
		$calle 	   = $this->revisaValorVacio($cliente[0]['calle']);
		$num   	   = $this->revisaValorVacio($cliente[0]['numero']);
		$cp    	   = $this->revisaValorVacio($cliente[0]['cp']);
		$col   	   = $this->revisaValorVacio($cliente[0]['colonia']);
		$del   	   = $this->revisaValorVacio($cliente[0]['delegacion']);
		$edo   	   = $this->revisaValorVacio($cliente[0]['estado']);
		$pais  	   = $this->revisaValorVacio($cliente[0]['pais']);
		$vv    	   = $this->revisaValorVacio($encabezado[0]['vessel_voyage']);
		$etd       = $this->revisaValorVacio($encabezado[0]['etd']);
		$pol       = $this->revisaValorVacio($encabezado[0]['pol']);
		$pod       = $this->revisaValorVacio($encabezado[0]['pod']);
		$mbl       = $this->revisaValorVacio($encabezado[0]['mbl']);
		$hbl       = $this->revisaValorVacio($encabezado[0]['hbl']);
		$id_pedido = $this->revisaValorVacio($encabezado[0]['id_pedido']);
		
		$document = new \PhpWord\TemplateProcessor($dirTemplate.'template_pf.docx');
		
		$document->setValue('fa', $fechaPF);
		$document->setValue('rs', $rs);
		$document->setValue('rfc', $rfc);
		$document->setValue('calle', $calle);
		$document->setValue('num', $num);
			
		$preFactura = $dir.'preFactura_'.$id_pedido.'.docx';
		$document->saveAs($preFactura);						
		
		return $preFactura;
		
	}
				
	
	public function revisaValorVacio($v_entrada)
	{
		$v_salida = "";
		if (!empty($v_entrada))
				$v_salida = $v_entrada;
				
		return $v_salida;
	}


	function toFixed($number, $dec_length){
		$pos=strpos($number.'', ".");
		if($pos>0)
		{
			$int_str = substr($number,0,$pos);
			$dec_str = substr($number, $pos+1);
			if(strlen($dec_str)>$dec_length)
			  { return $int_str.($dec_length>0?'.':'').substr($dec_str, 0,$dec_length); }
			else
			  { return $number; }
		}
		else
			{ return $number; }
	}

/** conversor de numeros a letras  **/
private function unidad($numuero){
    
	switch (intval($numuero))
	{
			case 9:  { $numu = "NUEVE"; break; }
			case 8:  { $numu = "OCHO";  break; }
			case 7:  { $numu = "SIETE"; break; }		
			case 6:  { $numu = "SEIS";  break; }		
			case 5:  { $numu = "CINCO"; break; }		
			case 4:  { $numu = "CUATRO";break; }		
			case 3:  { $numu = "TRES";  break; }		
			case 2:  { $numu = "DOS";   break; }		
			case 1:  { $numu = "UN";    break; }		
			case 0:  { $numu = "";      break; }		
	}
	return $numu;	
	}
	
	 private function decena($numdero){
		$numd = "";
			if ($numdero >= 90 && $numdero <= 99)
			{
						$numd = "NOVENTA ";
						if ($numdero > 90)
						{ $numd = $numd."Y ".($this->unidad($numdero - 90)); }
			}
			else if ($numdero >= 80 && $numdero <= 89)
			{
						$numd = "OCHENTA ";
						if ($numdero > 80)
						{ $numd = $numd."Y ".($this->unidad($numdero - 80)); }
			}
			else if ($numdero >= 70 && $numdero <= 79)
			{
						$numd = "SETENTA ";
						if ($numdero > 70)
						{ $numd = $numd."Y ".($this->unidad($numdero - 70)); }
			}
			else if ($numdero >= 60 && $numdero <= 69)
			{
						$numd = "SESENTA ";
						if ($numdero > 60)
						{ $numd = $numd."Y ".($this->unidad($numdero - 60)); }
			}
			else if ($numdero >= 50 && $numdero <= 59)
			{
						$numd = "CINCUENTA ";
						if ($numdero > 50)
						{ $numd = $numd."Y ".($this->unidad($numdero - 50)); }
			}
			else if ($numdero >= 40 && $numdero <= 49)
			{
						$numd = "CUARENTA ";
						if ($numdero > 40)
						{ $numd = $numd."Y ".($this->unidad($numdero - 40)); }
			}
			else if ($numdero >= 30 && $numdero <= 39)
			{
						$numd = "TREINTA ";
						if ($numdero > 30)
						{ $numd = $numd."Y ".($this->unidad($numdero - 30)); }
			}
			else if ($numdero >= 20 && $numdero <= 29)
			{
						if ($numdero == 20)
						{ $numd = "VEINTE ";} 
						else
						{ $numd = "VEINTI".($this->unidad($numdero - 20));   }
			}
			else if ($numdero >= 10 && $numdero <= 19)
			{
				switch ($numdero){
							case 10: { $numd = "DIEZ ";       break; }
							case 11: { $numd = "ONCE ";       break; }
							case 12: { $numd = "DOCE ";       break; }
							case 13: { $numd = "TRECE ";      break; }
							case 14: { $numd = "CATORCE ";    break; }
							case 15: { $numd = "QUINCE ";     break; }
							case 16: { $numd = "DIECISEIS ";  break; }
							case 17: { $numd = "DIECISIETE "; break; }
							case 18: { $numd = "DIECIOCHO ";  break; }
							case 19: { $numd = "DIECINUEVE "; break; }
				}	
			}
			else
					 { $numd = $this->unidad($numdero); }
		return $numd;
	}
	
	private function centena($numc){
			if ($numc >= 100)
			{
					if ($numc >= 900 && $numc <= 999)
					{
						$numce = "NOVECIENTOS ";
						if ($numc > 900)
						{  $numce = $numce.($this->decena($numc - 900)); }
					}
					else if ($numc >= 800 && $numc <= 899)
					{
						$numce = "OCHOCIENTOS ";
						if ($numc > 800)
						{ $numce = $numce.($this->decena($numc - 800)); }
					}
					else if ($numc >= 700 && $numc <= 799)
					{
						$numce = "SETECIENTOS ";
						if ($numc > 700)
						{ $numce = $numce.($this->decena($numc - 700)); }
					}
					else if ($numc >= 600 && $numc <= 699)
					{
						$numce = "SEISCIENTOS ";
						if ($numc > 600)
						{ $numce = $numce.($this->decena($numc - 600)); }
					}
					else if ($numc >= 500 && $numc <= 599)
					{
						$numce = "QUINIENTOS ";
						if ($numc > 500)
						{ $numce = $numce.($this->decena($numc - 500)); }
					}
					else if ($numc >= 400 && $numc <= 499)
					{
						$numce = "CUATROCIENTOS ";
						if ($numc > 400)
						{ $numce = $numce.($this->decena($numc - 400)); }
					}
					else if ($numc >= 300 && $numc <= 399)
					{
						$numce = "TRESCIENTOS ";
						if ($numc > 300)
						{ $numce = $numce.($this->decena($numc - 300)); }
					}
					else if ($numc >= 200 && $numc <= 299)
					{
						$numce = "DOSCIENTOS ";
						if ($numc > 200)
						{ $numce = $numce.($this->decena($numc - 200)); }
					}
					else if ($numc >= 100 && $numc <= 199)
					{
						if ($numc == 100)
						{ $numce = "CIEN "; }
						else
						{ $numce = "CIENTO ".($this->decena($numc - 100)); }
					}
			}
			else
			{ $numce = $this->decena($numc); }
	
			return $numce;	
	}
	
	private function miles($nummero){
			if ($nummero >= 1000 && $nummero < 2000){ $numm = "MIL ".($this->centena($nummero%1000)); }
			if ($nummero >= 2000 && $nummero <10000){ $numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000)); }
			if ($nummero < 1000)  { $numm = $this->centena($nummero); } 
	
			return $numm;
	}
	
	private function decmiles($numdmero){
			if ($numdmero == 10000) { $numde = "DIEZ MIL"; }
			if ($numdmero > 10000  && $numdmero <20000)  { $numde = $this->decena(Floor($numdmero/1000))."MIL " .($this->centena($numdmero%1000)); }
			if ($numdmero >= 20000 && $numdmero <100000) { $numde = $this->decena(Floor($numdmero/1000))." MIL ".($this->miles($numdmero%1000));  }		
			if ($numdmero < 10000)  { $numde = $this->miles($numdmero); } 
	
			return $numde;
	}		
	
	private function cienmiles($numcmero){
			if ($numcmero == 100000) {  $num_letracm = "CIEN MIL"; }
			if ($numcmero >= 100000 && $numcmero <1000000){ $num_letracm = $this->centena(Floor($numcmero/1000))." MIL ".($this->centena($numcmero%1000)); }
			if ($numcmero < 100000)  { $num_letracm = $this->decmiles($numcmero); }
			return $num_letracm;
	}	
	
	private function millon($nummiero){
			if ($nummiero >= 1000000 && $nummiero <2000000) { $num_letramm = "UN MILLON ".($this->cienmiles($nummiero%1000000)); }
			if ($nummiero >= 2000000 && $nummiero <10000000){ $num_letramm = $this->unidad(Floor($nummiero/1000000))." MILLONES ".($this->cienmiles($nummiero%1000000)); }
			if ($nummiero < 1000000)  { $num_letramm = $this->cienmiles($nummiero); }
	
			return $num_letramm;
	}	
	
	private function decmillon($numerodm){
			if ($numerodm == 10000000) { $num_letradmm = "DIEZ MILLONES";          }
			if ($numerodm > 10000000  && $numerodm <20000000)  { $num_letradmm = $this->decena(Floor($numerodm/1000000))."MILLONES ". ($this->cienmiles($numerodm%1000000)); }
			if ($numerodm >= 20000000 && $numerodm <100000000) { $num_letradmm = $this->decena(Floor($numerodm/1000000))." MILLONES ".($this->millon($numerodm%1000000));   }
			if ($numerodm < 10000000)  { $num_letradmm = $this->millon($numerodm); }
	
			return $num_letradmm;
	}
	
	private function cienmillon($numcmeros){
			if ($numcmeros == 100000000) { $num_letracms = "CIEN MILLONES";              }
			if ($numcmeros >= 100000000 && $numcmeros <1000000000){ $num_letracms = $this->centena(Floor($numcmeros/1000000))." MILLONES ".($this->millon($numcmeros%1000000)); }
			if ($numcmeros < 100000000)  { $num_letracms = $this->decmillon($numcmeros); }
			return $num_letracms;
	}	
	
	private function milmillon($nummierod){
			if ($nummierod >= 1000000000 && $nummierod <2000000000) { $num_letrammd = "MIL ".($this->cienmillon($nummierod%1000000000)); }
			if ($nummierod >= 2000000000 && $nummierod <10000000000){ $num_letrammd = $this->unidad(Floor($nummierod/1000000000))." MIL ".($this->cienmillon($nummierod%1000000000)); }
			if ($nummierod < 1000000000)  { $num_letrammd = $this->cienmillon($nummierod); }
	
			return $num_letrammd;
	}	
				
			
	public function convertNumToChar($numero){ $numf = $this->milmillon($numero);
											   return $numf ;
											 }
			
	/** conversor de numeros a letras FIN **/        
	

}//Utils