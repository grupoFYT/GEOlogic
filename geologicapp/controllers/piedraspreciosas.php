<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Piedraspreciosas extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap','piedraspreciosas') ;
		$this->jsfiles = array('jquery.dataTables.min', 'dataTables.bootstrap', 'piedraspreciosas', 'piedraspreciosas_create');
	
		$this->data['page_title'] = "Gestion de piedras preciosas";
				
		$this->data['view_file'] = 'piedraspreciosas/index';
		
		//echo "caca";
		$this->load->view('_layouts/mainGeologic', $this->data);
    }

	function datatable()
    {
		
		$this->datatables->select('piedraspreciosas.id as id,piedraspreciosas.piedrapreciosa as piedrapreciosa,piedraspreciosas.dureza as dureza,piedraspreciosas.color as color,piedraspreciosas.densidad as densidad,piedraspreciosas.caracteristicas as caracteristicas,piedraspreciosas.talla as talla', FALSE)
			->from('piedraspreciosas');
		
        echo $this->datatables->generate();

	}
	
}