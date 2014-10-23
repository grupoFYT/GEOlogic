<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
       
		$this->data['page_title'] = "GEOLogic";		
		$this->data['view_file'] = 'dashboard';
		
		$this->load->view('_layouts/mainGeologic', $this->data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */