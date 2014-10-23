<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class fichamedica extends MY_Controller {

    public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
       
	}

    public function index() {
	
		$this->styles = ['pacientes','select2','select2-bootstrap3','bootstrap-datetimepicker.min'] ;
		$this->jsfiles = ['select2','moment','bootstrap-datetimepicker.min','fichamedica_create','jquery.validate.min'] ;
	
		$id = $this->uri->segment(2);
		$query = $this->db->query('SELECT * FROM pacientes where id = '. $id);
		$paciente = $query->row();
		$this->data['paciente'] = $paciente;
		
	
		$this->data['page_title'] = "Ficha Médica";
		
		$this->data['view_file'] = 'fichamedica/create';
		
		$this->load->view('_layouts/mainPacientes', $this->data);
    }
	
	function getDiagnosticosE()
	{
		$query = $this->db->query('SELECT id, CONCAT(cod, " - ", diagnostico ) as text FROM diagnosticosEtiologicos where cod like "%' . $this->input->get('q') . '%" or diagnostico like "%' . $this->input->get('q') . '%"');
		echo json_encode($query->result());
	}
	
	function getDiagnosticosF()
	{
		$query = $this->db->query('SELECT id, CONCAT(cod, " - ", diagnostico ) as text FROM diagnosticosFuncionales where cod like "%' . $this->input->get('q') . '%" or diagnostico like "%' . $this->input->get('q') . '%"');
		echo json_encode($query->result());
	}
		
}

	

/* End of file home.php */
/* Location: ./application/controllers/home.php */