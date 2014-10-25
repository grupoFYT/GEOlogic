<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('Datatables');        
        $this->load->database();		
    }

	public function index() {
	
		$this->styles = array('dataTables.bootstrap','minerales') ;
		$this->jsfiles = array('jquery.dataTables.min', 'dataTables.bootstrap', 'minerales');
	
		$this->data['view_file'] = 'general';
		
		//echo "caca";
		$this->load->view('_layouts/mainGeologicTabs', $this->data);
    }
	
}