<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movilapp extends CI_Controller {

	public $user = NULL;
	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('md_usuario'); 
		$this->load->model('md_cliente');       
        $this->load->database('senni_logistics');	
		$this->load->library('session');
		$this->load->helper('array');
		$this->load->library('table');
		$this->load->library('Utils');
    }
	
	private function validaSS()
	{
		
	}
			
	public function download($id_pedido,$filename)
	{
		$this->load->helper('download');			

		$data = file_get_contents("./adjuntos/".$id_pedido."/".$filename);

		force_download($filename, $data);		
	}
	
	
	
	public function index()
	{
		$this->load->view('vw_lg_gestion',$data);	
	}
		
	public function clientes()
	{
		$clientes = $this -> md_cliente -> traeClientesMA();
		
		echo json_encode ($clientes);
	}
	
	public function rastreo($guia)
	{
		$this->load->model('md_rastreo');
		
		$encabezado = $this -> md_rastreo -> traeEncabezado($guia);
		$fletes   	= $this -> md_rastreo -> traeFletes($guia);
		$rastreo 	= $this -> md_rastreo -> traeRastreo($guia,20,0);
		
		echo json_encode (array("encabezado" => $encabezado,
								"fletes"  	 => $fletes,
								"rastreo"    => $rastreo));
	}	
	
	public function login($u,$p)
	{
		$usuario = $this -> input -> post('u');
		$pwd  	 = $this -> input -> post('p');
				
		$lg = $this->md_usuario->validaUsuario($usuario,$pwd);		
		
		echo json_encode ($lg);
	}	
	
	
	
}//Controller

