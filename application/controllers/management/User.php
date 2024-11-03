<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        $data['breadcrumbs'] = ['Management', 'User'];
        $data['title'] = 'User | JD Bengkel';
        $data['roles'] = ['admin', 'worker'];

        $this->load->view('_layouts/main/main_start', $data);
        $this->load->view('management/user/index', $data);
        $this->load->view('_layouts/main/main_end');
    }    

    // AJAX
    public function fetch_all()
    {
        $data = $this->user_model->get_all_users();
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function insert()
    {
        $rules = $this->user_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = array(
                'username' => form_error('username'),
                'email' => form_error('email'),
                'password' => form_error('password'),
                'role' => form_error('role'),
            );

            echo json_encode(array(
                'status' => 'error',
                'errors' => $errors
            ));
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => $this->input->post('role'),
            );
    
            $this->user_model->insert_user($data);
    
            echo json_encode(array('status' => 'success'));
        }
    }

    public function edit($id)
    {
        $data = $this->user_model->get_user_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $rules = $this->user_model->rules(true);
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = array(
                'username' => form_error('username'),
                'email' => form_error('email'),
                'role' => form_error('role'),
            );

            echo json_encode(array(
                'status' => 'error',
                'errors' => $errors
            ));
        } else {
            $id = $this->input->post('id');
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('new_password'),
                'role' => $this->input->post('role'),
            );

            $this->user_model->update_user($id, $data);
            echo json_encode(array('status' => TRUE));
        }
    }

    public function destroy($id)
    {
        $this->user_model->destroy_user($id);
        echo json_encode(array('status' => 'success'));
        
    }
}
