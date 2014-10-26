<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap') ;
		$this->jsfiles = array('jquery.dataTables.min', 'dataTables.bootstrap', 'general');
		
		$regiones = $this->db->query("SELECT * FROM regiones")->result();
		
		foreach ($regiones as $key=>$value)
		{
			$this->data['regiones'][$key]['region'] = $value;
			$pais = $this->db->query("SELECT * FROM paises where id = 1")->row();
			$this->data['regiones'][$key]['pais'] = $pais;
			$coordenadas = $this->db->query("SELECT * FROM regiones_coordenadas where region_id = " . $value->id )->result();
			$this->data['regiones'][$key]['coordenadas'] = $coordenadas;
		}
		
		$zonas = $this->db->query("SELECT * FROM zonas WHERE active = 1")->result();
		
		foreach ($zonas as $key=>$value)
		{
			$this->data['zonas'][$key]['zona'] = $value;
			$region = $this->db->query("SELECT * FROM regiones where id =" . $value->region_id )->row();
			$this->data['zonas'][$key]['region'] = $region;
			$coordenadas = $this->db->query("SELECT * FROM zonas_coordenadas where zona_id = " . $value->id )->result();
			$this->data['zonas'][$key]['coordenadas'] = $coordenadas;
		}
	
		$this->data['view_file'] = 'general';
		
		$this->load->view('_layouts/mainGeologicTabs', $this->data);
    }
	
}