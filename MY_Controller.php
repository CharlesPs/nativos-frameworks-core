<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct () {
		parent::__construct();

		$this->load->helper("url");
		$this->load->helper("date");

        $this->salida = array();
	}
}

class Client_Controller extends MY_Controller {

    function __construct () {
        parent::__construct();

        $this->load->model('m_control');
    }
}
