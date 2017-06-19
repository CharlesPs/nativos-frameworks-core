<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    private $_table = '';

    private $_query_fields = '*';
    private $_query_order;

    private $select_only_actives = true;

    private $_query_id = false;
    private $_query_condition = false;
    private $_ids_array = false;
    private $_field_array = false;

    function __construct(){
        parent::__construct();

        $this->_query_order = '-id';

        if (!isset($this->db)) {

            $this->load->database();
        }
    }

    public function set_table ($_table = false) {

        if ($_table) {

            $this->_table = $_table;
        }
    }

    public function where_id ($id) {

        if ($id) {

            $this->_query_id = $id;

            return $this;
        }
    }

    public function where_ids_array ($_ids_array, $separator = ',') {

        if ($_ids_array) {

            if (!is_array($_ids_array)) {

                $_ids_array = explode($separator, $_ids_array);
            }

            $this->_ids_array = $_ids_array;
        }

        return $this;
    }

    public function where_field_array ($field, $_array, $separator = ',') {

        if ($_array) {

            if (!is_array($_array)) {

                $_array = explode($separator, $_array);
            }

            $this->_field_array = array($field, $_array);
        }

        return $this;
    }

    public function where_condition ($_query_condition = false) {

        if ($_query_condition) {

            $this->_query_condition = $_query_condition;
        }

        return $this;
    }

    public function get_row () {

        if($this->select_only_actives){
			$this->db->where($this->_table . '.status', 'status_enabled');
		}

        $query_obj = $this->db->select($this->_query_fields)
                                ->from($this->_table)
                                ->limit(1);

        if ($this->_query_id) {

            $query_obj->where('id', $this->_query_id);
        }

        if ($this->_query_condition) {

            $query_obj->where($this->_query_condition, null, false);
        }

        if (substr($this->_query_order, 0, 1) === "-") {

            $query_obj->order_by(substr($this->_query_order, 1), "DESC");
        } else {

            $query_obj->order_by($this->_query_order, "DESC");
        }

        $query = $query_obj->get();

        $this->reset_where();

		return $query->row();
    }

    public function get_result () {

		if($this->select_only_actives){
			$this->db->where($this->_table . '.status', 'status_enabled');
		}

		$query_obj = $this->db->select($this->_query_fields)
							->from($this->_table);

        if ($this->_query_condition) {

            $query_obj->where($this->_query_condition, null, false);
        }

        if ($this->_ids_array) {

            $query_obj->where_in('id', $this->_ids_array);
        }

        if ($this->_field_array) {

            $query_obj->where_in($this->_field_array[0], $this->_field_array[1]);
        }

        if (substr($this->_query_order, 0, 1) === "-") {

            $query_obj->order_by(substr($this->_query_order, 1), "DESC");
        } else {

            $query_obj->order_by($this->_query_order, "DESC");
        }

        $query = $query_obj->get();

        $this->reset_where();

        return $query->result();
    }

    public function save ($data_obj) {

		if (is_array($data_obj)) {
			$data_obj = (object) $data_obj;
		}

        $data = clone $data_obj;

        $data->updated_at = date('Y-m-d H:i:s');

        $id = false;

        if(isset($data->id)){

            $id = $data->id;

            unset($data->id);
        }

        if($id){
            // update
            $this->db->where("id", $id);
            $this->db->update($this->_table, $data);

            return $this->get_by_id($id);
        }else{
            //insert
            $this->db->insert($this->_table, $data);

            $id = $this->db->insert_id();

            return $this->get_by_id($id);
        }
    }

    private function reset_where () {

        $this->_query_id        = false;
        $this->_query_condition = false;
        $this->_ids_array       = false;
    }
}
