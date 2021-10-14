<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright		Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @copyright		Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
        
        public function createFilter($param)
        {
            $this->load->database('senni_logistics');       
            $this->load->model('md_cotizador');
            $this->load->model('md_catalogo');
            $this->load->model('md_usuario');
            $this->load->library('session');            
            $this->load->library('table');
            $this->load->library('Utils');
            $this->load->helper('array');
            
            $data['titulos'] = array("navegador" => "Portal SENNI Logistics",								 
                                    "ventana"    => "Rompiendo Barreras, Cumpliendo tus Metas",
                                    "frase"      => "Servicios Integrales Especializados en Log&iacute;stica",
                                    "titulo"     => $param['titulo']);
		
            $data['usuario'] = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
            $data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
                        
            $tmpl = array ( 'table_open'  => '<table id="grid" class="display compact nowrap" style="width:100%">' );
            $this->table->set_template($tmpl);

            $this -> table -> set_heading($param["colBandeja"]);
            $this -> table->add_row(' ');

            $data['grid']            = $this->table->generate();
            $data['registrosPagina'] = $param["registrosPagina"];
            $data['controlador']     = $param["controlador"];
            $data['numColGrid']      = $param["numColGrid"];
            $data['mensajeConfirm']  = $param["mensajeConfirm"];

            $filtrosTbl = "";
            $filtrosTbl = $filtrosTbl. '<div class="body-filtros">';
            $filtrosTbl = $filtrosTbl.form_open(base_url().$param["controlador"].'/paginarAX/', array('class' => 'sky-form', 'id' => $param["formaId"]));            
            $filtrosTbl = $filtrosTbl. form_fieldset();
            $filtrosTbl = $filtrosTbl."<div class='row'>
            <section class='col col-4'>
                                    <label class='input'>
                                            <i class='icon-append fa ".$param["f1Image"]."'></i>".
                                            form_input(array('class'       => 'validate[custom[onlyLetterNumber]] text-input', 
                                                             'name'        => 'f1', 
                                                             'id'          => 'f1',
                                                             'placeholder' =>  $param["f1Label"],                                                         
                                                             'maxlength'   => '30'))."                                         
                                    </label>
                            </section>
                             <section class='col col-4'>
                                    <label class='input'>
                                            <i class='icon-append fa ".$param["f2Image"]."'></i>".
                                            form_input(array('class'       => 'text-input', 
                                                             'name'        => 'f2', 
                                                             'id'          => 'f2',
                                                             'placeholder' => $param["f2Label"],                                                         
                                                             'maxlength'   => '30'))."                                        
                                    </label>
                            </section>
                            <section class='col col-4'>
                                    <label class='input'>
                                            <i class='icon-append fa ".$param["f3Image"]."'></i>".
                                            form_input(array('class'       => 'text-input', 
                                                             'name'        => 'f3', 
                                                             'id'          => 'f3',
                                                             'placeholder' => $param["f3Label"],                                                         
                                                             'maxlength'   => '30'))."                                        
                                    </label>
                            </section>
                        </div>";
            if($param["controlador"]=='gestion')
            {
                 $filtrosTbl = $filtrosTbl."<div class='row'>
                                            <label class='label col col-2'>".$param["f4Label"]."</label>
                                            <label class='label col col-2'>Fecha de Alta</label>
                                            <section class='col col-4'>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-calendar'></i>".
                                                           form_input(array('class'     => ' text-input datepicker', 
                                                                                                        'name'      => 'fechaIni', 
                                                                                                        'id'        => 'fechaIni',
                                                                                                        'value'     =>  '',
                                                                                                        'size'      =>  '8',
                                                                                                        'placeholder' => "De:",
                                                                                                        'maxlength' => '20'))."                                         
                                                    </label>
                                            </section>
                                            <section class='col col-4'>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-calendar'></i>".
                                                           form_input(array('class'     => ' text-input datepicker', 
                                                                                                        'name'      => 'fechaFin', 
                                                                                                        'id'        => 'fechaFin',
                                                                                                        'value'     =>  '',
                                                                                                        'size'      =>  '8',
                                                                                                        'placeholder' => "Hasta:",
                                                                                                        'maxlength' => '20'))."                                         
                                                    </label>
                                            </section>
                                            </div>";
            }
            elseif($param["controlador"]=='pedido')
            {
                $filtrosTbl = $filtrosTbl."<div class='row'>
                                            <section class='col col-4'>
                                                    <label class='label'>Fecha de Alta</label>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-calendar'></i>".
                                                           form_input(array('class'     => ' text-input datepicker', 
                                                                                                        'name'      => 'fechaIni', 
                                                                                                        'id'        => 'fechaIni',
                                                                                                        'value'     =>  '',
                                                                                                        'placeholder' => "De:",
                                                                                                        'size'      =>  '8',
                                                                                                        'maxlength' => '20'))."                                         
                                                    </label>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-calendar'></i>".
                                                           form_input(array('class'     => ' text-input datepicker', 
                                                                                                        'name'      => 'fechaFin', 
                                                                                                        'id'        => 'fechaFin',
                                                                                                        'value'     =>  '',
                                                                                                        'placeholder' => "Hasta:",                                                               
                                                                                                        'size'      =>  '8',
                                                                                                        'maxlength' => '20'))."                                         
                                                    </label>
                                            </section>
                                            <section class='col col-4'>
                                                    <label class='label'>".$param["f8Label"]."</label>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-usd'></i>".
                                                           form_input(array('class'     => ' text-input', 
                                                                                            'name'      => 'deF8', 
                                                                                            'id'        => 'deF8',
                                                                                            'value'     =>  '',
                                                                                            'placeholder' => "De $:",
                                                                                            'size'      =>  '4',
                                                                                            'maxlength' => '10'))." 
                                                    </label>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-usd'></i>".
                                                           form_input(array('class'     => ' text-input', 
                                                                                            'name'      => 'aF8', 
                                                                                            'id'        => 'aF8',
                                                                                            'value'     =>  '',
                                                                                            'placeholder' => "Hasta $:",
                                                                                            'size'      =>  '4',
                                                                                            'maxlength' => '10'))." 
                                                    </label>
                                            </section>       
                                             <section class='col col-4'>
                                                 <label class='label'>".$param["f7Label"]."</label>
                                                 <label class='radio'>".form_radio(array("name"=>"f7","id"=>"f7","value"=>"USD"))."<i></i>USD</label>
                                                 <label class='radio'>".form_radio(array("name"=>"f7","id"=>"f7","value"=>"MXN"))."<i></i>MXN</label>
                                                </section>
                                            </div>
                                            <div class='row'>                                               
                                                <section class='col col-4'>
                                                    <label class='label'>".$param["f5Label"]."</label>
                                                    <label class='select'>".form_dropdown('f5',$param["f5Select"],"0",'id="f5"')." 
                                                    <i></i>                             
                                                    </label>
                                            </section>
                                            <section class='col col-4'>
                                                    <label class='label'>".$param["f6Label"]."</label>
                                                    <label class='select'>".form_dropdown('f6',$param["f6Select"],"0",'id="f6"')." 
                                                    <i></i>                             
                                                    </label>
                                            </section>
                                             <section class='col col-4'>
                                                    <label class='label'>".$param["f4Label"]."</label>
                                                    <label class='select'>".form_dropdown('f4',$param["f4Select"],"0",'id="f4"')." 
                                                    <i></i>                             
                                                    </label>
                                            </section>
                                            </div>
                                            ";
            }
            elseif($param["controlador"]=='usuario')
            { $filtrosTbl = $filtrosTbl.''; }
            elseif($param["controlador"]=='cotizador')
            {   $filtrosTbl = $filtrosTbl."<div class='row'>
                                             <section class='col col-3'>
                                                        <label class='label'>&nbsp;</label>
                                                        <label class='input'>
                                                                <i class='icon-append fa ".$param["f5Image"]."'></i>".
                                                                form_input(array('class'       => 'text-input', 
                                                                                'name'        => 'f5', 
                                                                                'id'          => 'f5',
                                                                                'placeholder' => $param["f5Label"],                                                         
                                                                                'maxlength'   => '30'))."                                        
                                                        </label>
                                            </section>
                                            <section class='col col-3'>
                                                    <label class='label'>Fecha de Alta</label>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-calendar'></i>".
                                                           form_input(array('class'     => ' text-input datepicker', 
                                                                                'name'      => 'fechaIni', 
                                                                                'id'        => 'fechaIni',
                                                                                'value'     =>  '',
                                                                                'size'      =>  '8',
                                                                                'placeholder' => "De:",
                                                                                'maxlength' => '20'))."                                         
                                                    </label>
                                            </section>
                                            <section class='col col-3'>
                                                    <label class='label'>&nbsp;</label>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-calendar'></i>".
                                                           form_input(array('class'     => ' text-input datepicker', 
                                                                                'name'      => 'fechaFin', 
                                                                                'id'        => 'fechaFin',
                                                                                'value'     =>  '',
                                                                                'size'      =>  '8',
                                                                                'placeholder' => "Hasta:",
                                                                                'maxlength' => '20'))."                                         
                                                    </label>
                                            </section>";
             $filtrosTbl = $filtrosTbl."<section class='col col-3'>
                                                    <label class='label'>".$param["f4Label"]."</label>
                                                    <label class='select'>".form_dropdown('f4',$param["f4Select"],"0",'id="f4"')." 
                                                    <i></i>                             
                                                    </label>
                                        </section>"; 
             
             $filtrosTbl = $filtrosTbl."</div>";
            }
            else
            {   $filtrosTbl = $filtrosTbl."<div class='row'>
                                            <section class='col col-4'>
                                                    <label class='label'>Fecha de Alta</label>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-calendar'></i>".
                                                           form_input(array('class'     => ' text-input datepicker', 
                                                                                                        'name'      => 'fechaIni', 
                                                                                                        'id'        => 'fechaIni',
                                                                                                        'value'     =>  '',
                                                                                                        'size'      =>  '8',
                                                                                                        'placeholder' => "De:",
                                                                                                        'maxlength' => '20'))."                                         
                                                    </label>
                                            </section>
                                            <section class='col col-4'>
                                                    <label class='label'>&nbsp;</label>
                                                    <label class='input'>
                                                            <i class='icon-append fa fa-calendar'></i>".
                                                           form_input(array('class'     => ' text-input datepicker', 
                                                                                                        'name'      => 'fechaFin', 
                                                                                                        'id'        => 'fechaFin',
                                                                                                        'value'     =>  '',
                                                                                                        'size'      =>  '8',
                                                                                                        'placeholder' => "Hasta:",                                                               
                                                                                                        'maxlength' => '20'))."                                         
                                                    </label>
                                            </section>";
             if ($param["f4Select"] != NULL)
             {$filtrosTbl = $filtrosTbl."<section class='col col-4'>
                                                    <label class='label'>".$param["f4Label"]."</label>
                                                    <label class='select'>".form_dropdown('f4',$param["f4Select"],"0",'id="f4"')." 
                                                    <i></i>                             
                                                    </label>
                                        </section>"; 
             }
             $filtrosTbl = $filtrosTbl."</div>";
            }
            $filtrosTbl = $filtrosTbl."<div class='row'>".
                                        "<sectionclass='col col-3'>".                                 
                                               "<a class='button' href=\"javascript:submitFormFiltros('".$param["formaId"]."','".$param['controlador']."','".$param['numColGrid']."','".$param['registrosPagina']."','".  base_url()."')\">Buscar</a>".
                                               "<a class='button button-secondary' href=\"javascript:submitFormReset('".$param["formaId"]."');\">Limpiar</a>".
                                        "</section>".
                                        "</div>";
            
            $filtrosTbl = $filtrosTbl. form_fieldset_close();    
            $filtrosTbl = $filtrosTbl. form_close();
            $filtrosTbl = $filtrosTbl. '</div>';

            $data['filtrosTbl']  = $filtrosTbl ;        
            $data['accion']      = $param["accion"];
            $data['tipo']        = $param["tipo"];    
                
            return $data;
        }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */