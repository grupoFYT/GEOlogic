<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Minerales extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap','minerales') ;
		$this->jsfiles = array('jquery.dataTables.min', 'dataTables.bootstrap', 'minerales');
	
		$this->data['page_title'] = "Minerales";
				
		$this->data['view_file'] = 'minerales/index';
		
		//echo "caca";
		$this->load->view('_layouts/mainGeologic', $this->data);
    }

	function datatable()
    {
		
		$this->datatables->select('minerales.id as id,minerales.mineral as mineral,minerales.dureza as dureza,minerales.color as color,minerales.densidad as densidad,minerales.caracteristicas as caracteristicas,minerales.origen as origen,minerales.utilidad as utilidad', FALSE)
			->from('minerales');
		
        echo $this->datatables->generate();

	}
	
}