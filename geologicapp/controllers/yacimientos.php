<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class yacimientos extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap','yacimientos') ;
		$this->jsfiles = array('jquery.dataTables.min', 'dataTables.bootstrap', 'yacimientos');
	
		$this->data['page_title'] = "Gestion de Yacimientos";
				
		$this->data['view_file'] = 'yacimientos/index';
		
		//echo "caca";
		$this->load->view('_layouts/mainGeologic', $this->data);
    }

	function datatable()
    {
		
		$this->datatables->select('yacimientos.id as id,yacimientos.yacimiento as yacimiento,yacimientos.fecha_descubrimiento as fecha_descubrimiento,yacimientos.zona_id as zona_id', FALSE)
			->from('yacimientos');
		
        echo $this->datatables->generate();

	}
	
}