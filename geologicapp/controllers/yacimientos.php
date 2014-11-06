<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Yacimientos extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap','bootstrap-datetimepicker.min') ;
		$this->jsfiles = array('moment','bootstrap-datetimepicker.min','jquery.dataTables.min', 'dataTables.bootstrap','jquery.bootstrap.wizard','bootstrap3-typeahead','yacimientos');

		$zonas = $this->db->query("SELECT * FROM zonas WHERE active = 1")->result();
		
		foreach ($zonas as $key=>$value)
		{
			$this->data['zonas'][$key]['zona'] = $value;
			$region = $this->db->query("SELECT * FROM regiones where id =" . $value->region_id )->row();
			$this->data['zonas'][$key]['region'] = $region;
			$coordenadas = $this->db->query("SELECT * FROM zonas_coordenadas where zona_id = " . $value->id )->result();
			$this->data['zonas'][$key]['coordenadas'] = $coordenadas;
		}
		
		$yacimientos = $this->db->query("SELECT * FROM yacimientos")->result();
		
		foreach ($yacimientos as $key=>$value)
		{
			$this->data['yacimientos'][$key]['yacimiento'] = $value;
			$minerales = $this->db->query("SELECT minerales.*, minerales_tipo.nombre, minerales_tipo.origen, 
											minerales_tipo.utilidad, minerales_tipo.color
											FROM minerales inner join minerales_tipo on minerales.mineral_tipo_id = minerales_tipo.id where minerales.yacimiento_id = " . $value->id )->result();
			$this->data['yacimientos'][$key]['minerales'] = $minerales;
		}
		
		$this->data['minerales_tipo'] = $this->db->query("SELECT * FROM minerales_tipo order by nombre")->result();
	
		$this->data['view_file'] = 'yacimientos';
		
		$this->load->view('_layouts/mainGeologicTabs', $this->data);
    }
	
	function datatable()
    {		
		$this->datatables->select('yacimientos.id as id,yacimientos.yacimiento as yacimiento, yacimientos.fecha_descubrimiento as fecha_descubrimiento, zonas.zona as zona', FALSE)
			->from('yacimientos') ->join('zonas','yacimientos.zona_id = zonas.id','left');
		
        echo $this->datatables->generate();
	}
	
	function getZonas()
	{
		$query = $this->db->query('SELECT id, zona FROM zonas where zona like "%' . $this->input->post('stringQuery') . '%" and active = 1');
		echo json_encode($query->result());
	}
	
	function save()
	{
		if($_POST):
			
			$this->db->trans_begin();
			
			$x = explode( ',', $this->input->post('coord') );			
													
			$this->db->insert('yacimientos', array( 'yacimiento' => $this->input->post('yacimiento') ,
													'fecha_descubrimiento' => $this->input->post('fechaDescubrimiento'), 
													'zona_id' => $this->input->post('hiddenZonaID'), 
													'lat' => $x[0], 
													'lng' => $x[1]));

			$id_fm = $this->db->insert_id();
						
			if (isset($id_fm)) {			

				$this->db->insert('minerales', array(   'mineral_tipo_id' => $this->input->post('minerales') ,
														'dureza' => $this->input->post('dureza'), 
														'densidad' => $this->input->post('densidad'), 
														'caracteristicas' => $this->input->post('caracteristicas'), 
														'yacimiento_id' => $this->input->post('id_fm'), 
														'explotabilidad' => $this->input->post('explotabilidad'), 
														'explotacion' => $this->input->post('explotacion'));

				$idx = $this->db->insert_id();
				if (!isset($idx)) {
					$this->db->trans_rollback();
					return FALSE;
				}
				
			}
			else {
				$this->db->trans_rollback();
				return FALSE;
			}
			
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
			}		
			else {
				$this->db->trans_commit();
			}

			$this->session->set_flashdata('item', 'Yacimiento ' . $this->input->post('yacimiento') . ' cargado.');
			echo TRUE;
 
		endif;
	}
	
	
	
}