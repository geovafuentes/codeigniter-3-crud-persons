<?php
class Persons extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Person_model');
        $this->load->helper('url');
    }

    public function index() {
        $data['persons'] = $this->Person_model->get_persons();
        $this->load->view('persons/index', $data);
    }
    public function create() {
        $this->load->library('form_validation');
    
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("status" => FALSE, "message" => validation_errors()));
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email')
            );
            $this->Person_model->insert_person($data);
            echo json_encode(array("status" => TRUE));
        }
    }
    
    public function update() {
        $this->load->library('form_validation');
    
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("status" => FALSE, "message" => validation_errors()));
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email')
            );
            $this->Person_model->update_person($this->input->post('id'), $data);
            echo json_encode(array("status" => TRUE));
        }
    }
    
    public function delete($id) {
        $this->Person_model->delete_person($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function get_persons() {
        $search = $this->input->get('search');
        $data = $this->Person_model->get_all_persons($search);
        echo json_encode($data);
    }
    
    public function edit($id) {
        $data = $this->Person_model->get_person_by_id($id);
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array("status" => FALSE, "message" => "Person not found"));
        }
    }
    
}
