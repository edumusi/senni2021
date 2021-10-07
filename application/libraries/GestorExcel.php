<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GestorExcel
 *
 * @author edumu
 */

class GestorExcel {
     
    var $name;
    var $icon;
    var $path;
    var $data;
    var $columnsTitles;    
   
    
function __construct()
{        

}
    
public function setname($param)
{ $this->name = $param; }

public function getname()
{ return $this->name; }

public function seticon($param)
{ $this->icon = $param; }

public function geticon()
{ return $this->icon; }

public function getpath()
{ return $this->path; }

public function setpath($param)
{ $this->path = $param; }

public function setdata($param)
{ $this->data = $param; }

public function getdata()
{ return $this->data; }

public function setcolumnsTitles($param)
{ $this->columnsTitles = $param; }

public function getcolumnsTitles()
{ return $this->columnsTitles; }


public function generaReportaIVA()
{	
    
    $tituloReporte = " SENNI Logistics - Reporte de los conceptos de Venta y Costo con IVA";    
 
    $objPHPExcel   = new PHPExcel();
 /*    
    $objPHPExcel->getProperties()
                ->setCreator    ("SENNI Logistics")                
                ->setTitle      ("Reporte Excel de conceptos con IVA")
                ->setSubject    ("Portal SENNI Logistics") 
                ->setDescription("Reporte Excel de conceptos con IVA")
                ->setKeywords   ("Cargos, Ventas, Costos, IVA")
                ->setCategory   ("Reporte Excel de conceptos con IVA")
                ->setLastModifiedBy("Portal SENNI Logistics") 
                ;

    $estiloTituloReporte = array('font'      => array('name'        => 'Verdana', 'bold' => true, 'italic' => false, 'strike' => false, 'size' => 16, 'color' => array('rgb' => 'FFFFFF')) ,
                                 'fill'      => array('type'        => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'FF220835')),
                                 'borders'   => array('allborders'  => array( 'style' => PHPExcel_Style_Border::BORDER_NONE)),
                                 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation' => 0, 'wrap' => TRUE )
                                );

    $estiloTituloColumnas = array('font'      => array('name'       => 'Arial', 'bold' => true, 'color' => array('rgb' => 'FFFFFF') ),
                                  'fill'      => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, 'rotation' => 90, 'startcolor' => array('rgb' => 'CB0B0B'), 'endcolor' => array('rgb' => 'F5B093') ),
                                  'borders'   => array('top'        => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array( 'rgb' => 'EE7A48')), 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array( 'rgb' => 'EE7A48')) ),
                                  'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => TRUE)
                                );

    $estiloInformacion = new PHPExcel_Style();
    $estiloInformacion->applyFromArray( array('font'    => array('name' => 'Arial', 'color' => array('rgb' => '000000')),
                                              'fill'    => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFFFFF')),
                                              'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN , 'color' => array('rgb' => 'EE7A48') ) )   
                                             ));

    $objPHPExcel->getActiveSheet()->setTitle('Reporte Excel IVA');
    $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A1:F1');

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',$tituloReporte) 
                ->setCellValue('A3',  "           ")
                ->setCellValue('B3',  $this->getcolumnsTitles()[0])
                ->setCellValue('C3',  $this->getcolumnsTitles()[1])
                ->setCellValue('D3',  $this->getcolumnsTitles()[2])
                ;

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');            
    $objWriter->save($this->getpath().$this->getname());
*/
}//generaReportaIVA

}//CLASS