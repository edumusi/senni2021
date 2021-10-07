<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LG extends CI_Controller {

	
	public function index()
	{
		$data['titulos'] = array("navegador"=>"Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('index',$data);
	}
	
	
	
	
	public function logistica()
	{
		$data['titulos'] = array("navegador"=>"SENNI LOGISTICS", "ventana"=>"Rompiendo Barreras, Cumpliendo tus Metas","frase"=>"Servicios Integrales Especializados en Log&iacute;stica");
		$this->load->view('vw_index_lg',$data);
	}
	
	
	public function intro()
	{
		$data['titulos'] = array("navegador"=>"Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('index',$data);
	}
	
	public function estrategia()
	{$data['titulos'] = array("navegador"=>"Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('index',$data);
	}
	
	public function aci()
	{
		$data['titulos'] = array("navegador"=>"Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('index',$data);
	}
	
	public function contacto()
	{
		$data['titulos'] = array("navegador"=>"Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('index',$data);
	}
	
	
}

