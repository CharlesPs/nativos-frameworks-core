<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    private $_table = '';

    private $_query_fields = '*';

    function __construct(){
        parent::__construct();
    }

    public function get_result () {

		if($this->select_only_actives){
			$this->db->where($this->_table . '.status', 'status_enabled');
		}

		$query_obj = $this->db->select($this->_query_fields)
							->from($this->_table)
							->where($condition, null, false);

        if (substr($this->order_by, 0, 1) === "-") {

            $query_obj->order_by(substr($this->order_by, 1), "DESC");
        } else {

            $query_obj->order_by($this->order_by, "DESC");
        }

        $query = $query_obj->get();

        return $query->result();
    }
}
