<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Piedraspreciosas extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap','bootstrap-datetimepicker.min') ;
		$this->jsfiles = array('moment','bootstrap-datetimepicker.min','jquery.dataTables.min', 'dataTables.bootstrap','jquery.bootstrap.wizard','bootstrap3-typeahead','piedraspreciosas');

		$zonas = $this->db->query("SELECT * FROM zonas")->result();
		
		foreach ($zonas as $key=>$value)
		{
			$this->data['zonas'][$key]['zona'] = $value;
			$region = $this->db->query("SELECT * FROM regiones where id =" . $value->region_id )->row();
			$this->data['zonas'][$key]['region'] = $region;
			$coordenadas = $this->db->query("SELECT * FROM zonas_coordenadas where zona_id = " . $value->id )->result();
			$this->data['zonas'][$key]['coordenadas'] = $coordenadas;
		}
		
		$this->data['piedraspreciosas'] = $this->db->query("SELECT piedraspreciosas.*, piedraspreciosas_tipo.nombre, piedraspreciosas_tipo.similares, 
											piedraspreciosas_tipo.famosas
											FROM piedraspreciosas inner join piedraspreciosas_tipo on piedraspreciosas.piedrapreciosa_tipo_id = piedraspreciosas_tipo.id")->result();
		
		$this->data['piedraspreciosas_tipo'] = $this->db->query("SELECT * FROM piedraspreciosas_tipo order by nombre")->result();
	
		$this->data['view_file'] = 'piedraspreciosas';  
		
		$this->load->view('_layouts/mainGeologicTabs', $this->data);
    }
	
	function datatable()
    {		
		$this->datatables->select('piedraspreciosas.id as id, piedraspreciosas_tipo.nombre as nombre, piedraspreciosas.fecha_descubrimiento as fecha_descubrimiento, zonas.zona as zona', FALSE)
			->from('piedraspreciosas') ->join('piedraspreciosas_tipo','piedraspreciosas.piedrapreciosa_tipo_id = piedraspreciosas_tipo.id','inner')
			->from('piedraspreciosas') ->join('zonas','piedraspreciosas.zona_id = zonas.id','inner');
		
        echo $this->datatables->generate();
	}
	
	function getZonas()
	{
		$query = $this->db->query('SELECT id, zona FROM zonas where zona like "%' . $this->input->post('stringQuery') . '%"');
		echo json_encode($query->result());
	}
	
	function save()
	{
		if($_POST):
			
			$x = explode( ',', $this->input->post('coord') );
			
			$this->db->insert('piedraspreciosas', array( 'piedrapreciosa_tipo_id' => $this->input->post('piedrapreciosa') ,
													'dureza' => $this->input->post('dureza'), 
													'color' => $this->input->post('color'), 
													'densidad' => $this->input->post('densidad'), 
													'caracteristicas' => $this->input->post('caracteristicas'), 
													'talla' => $this->input->post('talla'), 
													'fecha_descubrimiento' => date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('fechaDescubrimiento')))),													
													'zona_id' => $this->input->post('hiddenZonaID'), 
													'lat' => $x[0], 
													'lng' => $x[1]));

			$id_fm = $this->db->insert_id();
						
			$this->session->set_flashdata('item', 'Piedra Preciosa cargada.');
			echo TRUE;
 
		endif;
	}
	
	
	
}