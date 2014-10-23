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
		$this->jsfiles = array('jquery.dataTables.min', 'dataTables.bootstrap', 'piedraspreciosas');
	
		$this->data['page_title'] = "Piedras Preciosas";
				
		$this->data['view_file'] = 'piedraspreciosas/index';
		
		//echo "caca";
		$this->load->view('_layouts/mainGeologic', $this->data);
    }

}