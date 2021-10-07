<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TI extends CI_Controller {

	
	public function index()
	{
		$data['titulos'] = array("navegador"=>"SENNI TI", "ventana"=>"Rompiendo Barreras, Cumpliendo tus Metas","frase"=>"Servicios Integrales Especializados en Tecnolog&iacute;a de la Informaci&oacute;n");
		$this->load->view('vw_index_ti',$data);
	}
	
	public function store()
	{
		$data['titulos'] = array("navegador"=>"SENNI TI", "ventana"=>"Rompiendo Barreras, Cumpliendo tus Metas","frase"=>"Servicios Integrales Especializados en Tecnolog&iacute;a de la Informaci&oacute;n");
		$this->load->view('ti/vw_store',$data);
	}
	
	
	public function info()
	{
		$data['titulos'] = array("navegador"=>"SENNI LOGISTICS", "ventana"=>"Rompiendo Barreras, Cumpliendo tus Metas","frase"=>"Servicios Integrales Especializados en Log&iacute;stica");
		$this->load->view('vw_index_lg',$data);
	}
	
	
	
	
	
}

