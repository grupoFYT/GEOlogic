<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Zonas extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap') ;
		$this->jsfiles = array('jquery.dataTables.min', 'dataTables.bootstrap','jquery.bootstrap.wizard','bootstrap3-typeahead','jquery.validate.min','zonas');
		
		$regiones = $this->db->query("SELECT * FROM regiones")->result();
		
		foreach ($regiones as $key=>$value)
		{
			$this->data['regiones'][$key]['region'] = $value;
			$pais = $this->db->query("SELECT * FROM paises where id = 1")->row();
			$this->data['regiones'][$key]['pais'] = $pais;
			$coordenadas = $this->db->query("SELECT * FROM regiones_coordenadas where region_id = " . $value->id )->result();
			$this->data['regiones'][$key]['coordenadas'] = $coordenadas;
		}
		
		$zonas = $this->db->query("SELECT * FROM zonas")->result();
		
		foreach ($zonas as $key=>$value)
		{
			$this->data['zonas'][$key]['zona'] = $value;
			$region = $this->db->query("SELECT * FROM regiones where id =" . $value->region_id )->row();
			$this->data['zonas'][$key]['region'] = $region;
			$coordenadas = $this->db->query("SELECT * FROM zonas_coordenadas where zona_id = " . $value->id )->result();
			$this->data['zonas'][$key]['coordenadas'] = $coordenadas;
			$yacimientos = $this->db->query("SELECT yacimientos.*,
												minerales.*
											FROM yacimientos LEFT JOIN minerales ON minerales.yacimiento_id = yacimientos.id 
												LEFT JOIN 
												minerales_tipo ON minerales_tipo.id = minerales.mineral_tipo_id
											WHERE yacimientos.zona_id = " . $value->id )->result();
			$this->data['zonas'][$key]['yacimientos'] = $yacimientos;
		}
	
		$this->data['view_file'] = 'zonas';
		
		$this->load->view('_layouts/mainGeologicTabs', $this->data);
    }
	
	function datatable()
    {
		$this->datatables->select('zonas.id as id,zonas.zona as zona,regiones.region as region, paises.pais as pais', FALSE)
			->from('zonas') ->join('regiones','zonas.region_id = regiones.id','left')
			->from('zonas') ->join('paises','regiones.pais_id = paises.id','left');
		
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
	
	function getData()
	{
		
		//$query = $this->db->query('SELECT * from yacimientos inner join minerales on yacimientos.id = minerales.yacimiento_id inner join minerales_tipo on minerales.mineral_tipo_id = minerales_tipo.id where yacimientos.zona_id = ' . $this->input->post('zona'));
		$query = $this->db->query('SELECT * from yacimientos where yacimientos.zona_id = ' . $this->input->post('zona'));
		echo json_encode($query->result());
	}
	

	function delete()
	{
		$id = $this->uri->segment(3);
		$this->db->query("DELETE FROM zonas where  id = ". $id);
		//$this->input->post('stringQuery');
		$this->session->set_flashdata('item', 'Zona eliminada');
		
		redirect('/zonas/', 'refresh');
	}
	
	
}

