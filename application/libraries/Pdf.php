<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PDF Library
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Muhanz
 * @license			MIT License
 * @link			https://github.com/hanzzame/ci3-pdf-generator-library
 *
 */

//require_once(dirname(__FILE__) . 'third_party/dompdf/autoload.inc.php');
require_once APPPATH.'third_party/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Pdf
{	

  public function generate($html = '<html><head></head><body></body></html>', $filename = '', $stream = TRUE, $paper = 'A4', $orientation = "portrait")
  { 
    $dompdf = new DOMPDF();
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
  	$dompdf->render();
	
    if ($stream) { $dompdf->stream($filename, array("Attachment" => 0)); } 
    else 	       { $pdfOut = $dompdf->output();        
                    return write_file($filename, $pdfOut);
                 }
  }


}