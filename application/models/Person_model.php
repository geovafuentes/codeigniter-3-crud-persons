<?php
class Person_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    public function get_all_persons($search = '') {
        if (!empty($search)) {
            $this->db->like('first_name', $search);
            $this->db->or_like('last_name', $search);
            $this->db->or_like('email', $search);
        }
        $query = $this->db->get('persons');
        return $query->result();
    }
    
    public function get_persons() {
        $query = $this->db->get('persons');
        return $query->result_array();
    }

    public function insert_person($data) {
        return $this->db->insert('persons', $data);
    }

    public function get_person_by_id($id) {
        $query = $this->db->get_where('persons', array('id' => $id));
        return $query->row_array();
    }

    public function update_person($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('persons', $data);
    }

    public function delete_person($id) {
        $this->db->where('id', $id);
        return $this->db->delete('persons');
    }
}
