<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginacion extends CI_Controller {

	
	function __construct(){
        parent::__construct();		
        $this->load->database('senni_logistics');
    }
	
	 public function index(){
	 	
	 }
	
	
    public function pg_rastreo($offset=1){
    	
		$url_a_paginar='/paginacion/pg_rastreo/';
		$filtro_paginacion=1;
		$registros_x_pagina= 5;
		//$offset=1;
		
        // Load the tables library
        $this->load->library('table');
		
		// Load Pagination
		$this->load->library('pagination');
		
		$this->load->model('md_rastreo');        
		
		$rastreo = $this->md_rastreo->traeRastreo($filtro_paginacion,$registros_x_pagina,$offset);
		
        // Config setup
		$config['base_url'] = base_url().$url_a_paginar;
		$config['total_rows'] = $rastreo["conteo"];
		$config['per_page'] = $registros_x_pagina;
		// I added this extra one to control the number of links to show up at each page.
		$config['num_links'] = 5;
		// Initialize
		$this->pagination->initialize($config);
		
		// Query the database and get results		
        $data['rastreo'] =  $rastreo["registros"];
 
        // Create custom headers
        $header = array('Descripcion', 'Fecha', 'Hora', 'Observaciones');
        // Set the headings
        $this->table->set_heading($header);
        // Load the view and send the results
        $this->load->view('vw_paginacion', $data);
    }
}