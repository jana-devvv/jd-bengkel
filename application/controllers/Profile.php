<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('profile_model');
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index()
    {
        
        $id = $this->session->userdata('id');
        $profile = $this->profile_model->get_profile_where(['id_user' => $id]);
        $user = $this->user_model->get_user_by_id($id);
        
        $data = [
            'title' => 'Profile | JD Bengkel',
            'profile' => $profile,
            'user' => $user,
        ];

        $this->load->view('_layouts/main/main_start', $data);
        $this->load->view('dashboard/profile', $data);
        $this->load->view('_layouts/main/main_end');
    }

    public function save_profile()
    {
        $id_user = $this->session->userdata('id');
        
        $existProfile = $this->profile_model->get_profile_where(['id_user' => $id_user]);

        $data = [
            'id_user' => $id_user,
            'name' => $this->input->post('name'),
            'age' => $this->input->post('age'),
            'gender' => $this->input->post('gender'),
            'position' => $this->input->post('position'),
            'bio' => $this->input->post('bio'),
        ];

        if($existProfile) {
            $this->profile_model->update_profile($existProfile->id, $data);
            // $response = ['status' => 'success', 'message' => 'Profile updated successfully.'];
        } else {
            $this->profile_model->insert_profile($data);
            // $response = ['status' => 'success', 'message' => 'Profile created successfully.'];
        }

        echo json_encode($data);
    }

    public function save_credential()
    {
        $id = $this->session->userdata('id');
        $data = [
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
        ];
        
        $this->user_model->update_user($id, $data);
        // $response = ['status' => 'success', 'message' => 'Credential updated successfully.', 'data' => $data];
        echo json_encode($data);
    }

    public function save_password()
    {
        $id = $this->session->userdata('id');
        $new_password = $this->input->post('new_password');

        $rules = $this->user_model->rules_change_password();
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() === FALSE) {
            $errors = [
                'old_password' => form_error('old_password'),
                'new_password' => form_error('new_password'),
                'confirm_password' => form_error('confirm_password'),
            ];

            echo json_encode(array('status' => 'error', 'errors' => $errors));
        } else {
            $data['password'] = password_hash($new_password, PASSWORD_BCRYPT);
            $this->user_model->update_user($id, $data);
    
            $response = ['status' => 'success', 'message' => 'Password updated successfully.'];
            echo json_encode($response);
        }
    }

    public function check_password($old_password)
    {
        $id = $this->session->userdata('id');
        $user = $this->user_model->get_user_where(['id' => $id]);

        if(!password_verify($old_password, $user->password)) {
            $this->form_validation->set_message('check_password', 'The {field} is incorrect.');
            return false;
        }

        return true;
    }
}