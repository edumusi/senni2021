<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
		$this->load->database('senni_logistics');
		
        $this->load->model('md_usuario');
		$this->load->model('md_cliente');
		
		$this->load->library('session');		
		$this->load->library('table');
		$this->load->library('Utils');
		
		$this->load->helper('array');
    }
	
					
	public function index()
	{

	}
		
	public function clientesData()
	{
		$clientes = $this -> md_cliente -> traeClientesMA();
		
		echo json_encode ($clientes);
	}
	
	public function embarquesData()
	{
		$this->load->model('md_pedido');
		
		$pedidos = $this -> md_pedido -> traePedidos(null, 100,0);
		
		echo json_encode ($pedidos);
	}	
		
}//Controller

