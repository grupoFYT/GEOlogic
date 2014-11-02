<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Yacimientos extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap') ;
		$this->jsfiles = array('jquery.dataTables.min', 'dataTables.bootstrap','jquery.bootstrap.wizard','bootstrap3-typeahead','yacimientos');

		$zonas = $this->db->query("SELECT * FROM zonas WHERE active = 1")->result();
		
		foreach ($zonas as $key=>$value)
		{
			$this->data['zonas'][$key]['zona'] = $value;
			$region = $this->db->query("SELECT * FROM regiones where id =" . $value->region_id )->row();
			$this->data['zonas'][$key]['region'] = $region;
			$coordenadas = $this->db->query("SELECT * FROM zonas_coordenadas where zona_id = " . $value->id )->result();
			$this->data['zonas'][$key]['coordenadas'] = $coordenadas;
		}
		
				
		// $regiones = $this->db->query("SELECT * FROM regiones")->result();
		
		// foreach ($regiones as $key=>$value)
		// {
			// $this->data['regiones'][$key]['region'] = $value;
			// $pais = $this->db->query("SELECT * FROM paises where id = 1")->row();
			// $this->data['regiones'][$key]['pais'] = $pais;
			// $coordenadas = $this->db->query("SELECT * FROM regiones_coordenadas where region_id = " . $value->id )->result();
			// $this->data['regiones'][$key]['coordenadas'] = $coordenadas;
		// }
		
		$regiones = $this->db->query("SELECT * FROM regiones")->result();
		
		foreach ($regiones as $key=>$value)
		{
			$this->data['regiones'][$key]['region'] = $value;
			$pais = $this->db->query("SELECT * FROM paises where id = 1")->row();
			$this->data['regiones'][$key]['pais'] = $pais;
			$coordenadas = $this->db->query("SELECT * FROM regiones_coordenadas where region_id = " . $value->id )->result();
			$this->data['regiones'][$key]['coordenadas'] = $coordenadas;
		}
	
		$this->data['view_file'] = 'zonas';
		
		$this->load->view('_layouts/mainGeologicTabs', $this->data);
    }
	
	function datatable()
    {
		$this->datatables->select('zonas.id as id,zonas.zona as zona,regiones.region as region, paises.pais as pais', FALSE)
			->from('zonas') ->join('regiones','zonas.region_id = regiones.id','left')
			->from('zonas') ->join('paises','regiones.pais_id = paises.id','left')
			->where('active = 1');
		
        echo $this->datatables->generate();

	}
	
	function getRegiones()
	{
		$query = $this->db->query('SELECT id, region FROM regiones where region like "%' . $this->input->post('stringQuery') . '%"');
		echo json_encode($query->result());
	}
	
	function save()
	{
		if($_POST):
			
			$this->db->trans_begin();
		
			$this->db->insert('zonas', array( 'zona' => $this->input->post('zona') ,
											  'region_id' => $this->input->post('hiddenRegionID')));
			$id_fm = $this->db->insert_id();
			//$id_fm = 2;
			
			if (isset($id_fm)) {
				
				$count = 0;
				foreach( explode( ',', $this->input->post('coord') ) as $x ) {
					if ($count%2==0){
						$coordx = array( 'zona_id' => $id_fm );
						$coordx['lat']  = $x ;
					}
					else {
						$coordx['lng']  = $x ;
						$this->db->insert('zonas_coordenadas', $coordx );

						$idx = $this->db->insert_id();
						if (!isset($idx)) {
							$this->db->trans_rollback();
							return FALSE;
						}
						$coordx = array();						
					}
					$count = $count + 1;					
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

			$this->session->set_flashdata('item', 'Zona ' . $this->input->post('zona') . ' cargada.');
			echo TRUE;
 
		endif;
	}
	
	
	
}