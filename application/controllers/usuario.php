<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller 
{	
        public $registros_x_pagina = 10;
        public $dirFoto = "images/firmas/";
	
        public function __construct()
        {
            parent::__construct();

            $this->load->database('senni_logistics');
            $this->load->model('md_usuario');
            $this->load->model('md_catalogo');
            $this->load->library('session');
            $this->load->library('table');
            $this->load->library('Utils');
            $this->load->helper('array');
        }
					
	private function validaSS()
	{
		$this->user = $this -> session -> userdata('datos_sesion');
		$data['titulos'] = array("navegador"=>"INGRESO a SENNI LOGISTICS", 
					"ventana"=>"Rompiendo Barreras, Cumpliendo tus Metas",
					"frase"=>"Servicios Integrales Especializados en Log&iacute;stica");
												
		if( $this->user == NULL)
		{
			$data['sesion'] = "Su sesión ha expirado";
			$this->load->view('vw_lg_gestion',$data);
			die($this->output->get_output());
		}
		else		
                    if ($this->user['0']['tipo']=="C" | $this->user['0']['tipo']=="V")
			{
				$data['sesion'] = "Usted no cuenta con los privilegios necesarios para accesar a la sección solicitada";
				$this->load->view('vw_index',$data);
				die($this->output->get_output());
			}
	}
	
	public function index($msj='')
	{
         try{
            $this->validaSS();

            $param = array("titulo"          => "Cat&aacute;logo de Usuarios ".$msj,
                           "colBandeja"      => array('','Nombre','Puesto', 'Correo','Fecha de Alta', 'Acciones'),
                           "registrosPagina" => $this->registros_x_pagina,
                           "controlador"     => "usuario",
                           "numColGrid"      => "6",
                           "formaId"         => "filtrosCl",
                           "f1Label"         => "Nombre",
                           "f1Image"         => "fa-user",
                           "f2Label"         => "Correo",
                           "f2Image"         => "fa-envelope-o",
                           "f3Label"         => "Puesto",
                           "f3Image"         => "fa fa-suitcase",
                           "f4Label"         => "",
                           "f4Select"        => NULL,
                           "accion"          => "nuevo",
                           "tipo"            => "Usuario",
						   "mensajeConfirm"  => $msj
                          );

            $data = $this->createFilter($param);				  				        	     

            $this->load->view('vw_lg_fil_pag',$data);
         } catch (Exception $e) {echo ' index Excepción: ',  $e->getMessage(), "\n";}		
	}
	
        
        public function nuevo()
        {
            $this->validaSS();

            try{
                $data['usuario']  = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
                $data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	        $data['titulos']  = array("navegador" => "Portal SENNI Logistics", 
                                  "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
                                  "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
                                  "titulo"    => "Formulario para ingresar un nuevo Usuario al Portal");
		
                $data['accion']   = "N";
                $data['dirFoto']  = $this->dirFoto;
                $data['profiles'] = $this->md_catalogo-> poblarSelect('profile',true);
                $data['attP']     = 'id="profile" class="validate[custom[requiredInFunction]]"';
                $data['fotoIni']  = "null.png";
                $data['headerLG'] = "Nuevo Usuario";
                $data['usr']      =  array(array("nombre"=>null,"apellidos"=>null,"tipo"=>'0',"puesto"=>null,"pwd"=>null, "correo"=>null, "titulo"=>null, "telefono"=>null, "celular"=>null, "firma"=>"null.png", "RFC"=>null, "Curp"=>null, "NumSeguridadSocial"=>null ));

                $this->load->view('form_usr',$data);

                } catch (Exception $e) {echo ' nuevo Excepción: ',  $e, "\n";}		
        }
        
        public function edita($correo=0)
        {
              $this->validaSS();
            try{
               $data['usuario']  = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
                $data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	        $data['titulos']  = array("navegador" => "Portal SENNI Logistics", 
                                          "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
                                          "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
                                          "titulo"    => "Formulario para ingresar un nuevo Usuario al Portal");

                $data['dirFoto']  = $this->dirFoto;
                $data['profiles'] = $this->md_catalogo-> poblarSelect('profile',true);
                $data['attP']     = 'id="profile" class="validate[custom[requiredInFunction]]"';
                $data['headerLG'] = "Actualizar Usuario";
                $usuarioData      = $this->md_usuario->traeDetalleAdmin(rawurldecode($correo));                
                $data['usr']      = $usuarioData;
                $data['accion']   = "E";
                
                $this->load->view('form_usr',$data);
                
                } catch (Exception $e) {echo ' edita Excepción: ',  $e, "\n";}		
        }
        
        public function guardar()
        {
            $this->validaSS();
            try{
                $this->load->helper('date');               
                
                $accion = $this -> input -> post('accion');
                $dataUsr = array('nombre'     =>   $this -> input -> post('nombre'),
                                 'apellidos'  =>   $this -> input -> post('apellidos'),
                                 'pwd'        =>   $this -> input -> post('pwd'),
                                 'correo'     =>   $this -> input -> post('correo'),
                                 'tipo'       =>   $this -> input -> post('tipo'),
                                 'puesto'     =>   $this -> input -> post('puesto'),
                                 'titulo'     =>   $this -> input -> post('titulo'),
                                 'telefono'   =>   $this -> input -> post('telefono'),
                                 'celular'    =>   $this -> input -> post('celular'),                                 
                                 'firma'      =>   $this -> input -> post('firmaNueva'),
                                 'RFC'        =>   $this -> input -> post('RFC'),
                                 'Curp'       =>   $this -> input -> post('Curp'),
                                 'NumSeguridadSocial' => $this -> input -> post('NumSeguridadSocial'),
                                 'fecha_alta' =>   date('Y-m-d H:i:s')
                                 );
                
                if($accion == "E")// Para actualizar el pedido borra todas las tablas auxiliriares para insertar la nueva 
                    {
                        unset($dataUsr['correo']);
                        unset($dataUsr['fecha_alta']);
                        unset($dataUsr['firma']);
                        $this->md_usuario->update_user($this -> input -> post('correo_ant'),$dataUsr);}
                else
                     { $this->md_usuario->insert_user($dataUsr);}
                
                                                  
                 $this->index('.Miembro del equipo: '.$this -> input -> post('nombre').' '.$this -> input -> post('apellidos').' agregado exitosamente');
                
                } catch (Exception $e) {echo ' guardar Excepción: ',  $e, "\n";}		
        }

        public function paginarAX()
    {
        try{                        
            $pagina   = $this -> input -> post('pagina');
            $f1       = $this -> input -> post('f1');
            $f2       = $this -> input -> post('f2');
            $f3       = $this -> input -> post('f3');            
                         
            $grid = $this -> md_usuario-> traeUsuariosFiltros($this->registros_x_pagina,$pagina,$f1,$f2,$f3 );
            
            echo json_encode ($grid);                          
            
        } catch (Exception $e) {echo ' paginarAX Excepción: ',  $e->getMessage(), "\n";}		
    }
               
    public function bajaUserAX()
        {
           $correo   = $this -> input -> post('correo');
           log_message('error', 'correo:'.$correo);
           log_message('error', 'correo II:'.rawurldecode($correo));
           $this -> md_usuario-> delete_user(rawurldecode($correo));
           
           echo json_encode (true); 
        }
    
      public function agregaFirmaAX()
        {
         try{

            if(isset($_FILES["myfile"]))
            {
                    $ret = array();		
                    $error =$_FILES["myfile"]["error"];		
                    if(!is_array($_FILES["myfile"]["name"])) //single file
                    {                            
                            $fileName =  $this->utils->generaNombreImagen($_FILES["myfile"]["name"]);
                            move_uploaded_file($_FILES["myfile"]["tmp_name"],$this->dirFoto.$fileName);

                            $ret[]= $fileName;
                    }
                    else  //Multiple files, file[]
                    {
                      $fileCount = count($_FILES["myfile"]["name"]);
                      for($i=0; $i < $fileCount; $i++)
                      {                            
                            $fileName =  $this->utils->generaNombreImagen($_FILES["myfile"]["name"][$i]);
                            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$this->dirFoto.$fileName);
                            $ret[]= $fileName;
                      }

                    }
                    echo json_encode($ret);                
             }
          } catch (Exception $e) {echo ' agregaImagenAX Excepción: ',  $e, "\n";}         
        }


        public function	borraImagenAX()
        {
            if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
            {
                    $fileName =$_POST['name'];
                    $filePath = $this->dirFoto.$fileName;
                    if (file_exists($filePath)) 		
                            unlink($filePath);

                    echo "Deleted File ".$fileName."<br>";
            }
        }

        public function	renombraFirmaAX()
        {	
        try{	                
            $this->load->helper('date');                                
            $extension     = $this -> input -> post('extension');
            $nombreArchivo = $this -> input -> post('nombreArchivo');
            $cuenta        = $this -> input -> post('cuenta');
            $idImagen      = "firma_".intval(substr(now(), -5));
            $nombreArchivo = $this->dirFoto.$nombreArchivo.".".$extension;
            $nombreSL      = $this->dirFoto.$idImagen.".".$extension;                               

            rename ($nombreArchivo,$nombreSL);
            
            $this -> md_usuario-> update_user($cuenta."@senni.com.mx", array('firma'=>$idImagen.".".$extension) );

            echo json_encode (array("nombreSL" => $nombreSL,"hImg" => $idImagen.".".$extension));

            } catch (Exception $e) {echo 'renombraImagenAX Excepción: ',  $e, "\n";}	
        }
        
        public function	borraFirmaCargadaAX()
        {	
        try{	
            $extension 	   = $this -> input -> post('extension');
            $nombreArchivo = $this -> input -> post('nombreArchivo');
            $cuenta        = $this -> input -> post('cuenta');

            $nombreArchivo = $nombreArchivo.".".$extension;
            $filePath      = $this->dirFoto.$nombreArchivo;
            $result        = false;

            if (file_exists($filePath)) 		
                { $result = unlink($filePath); }
                
            $this -> md_usuario-> update_user($cuenta."@senni.com.mx", array('firma'=>'null.png') );    

            echo json_encode (array("result" => $result,"dirFoto"=>$this->dirFoto));

            } catch (Exception $e) {echo 'borraFirmaCargadaAX Excepción: ',  $e, "\n";}	
        }

	
}//Controller

